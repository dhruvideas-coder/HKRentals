# SK Rentals — Functionality Rules Reference

> Quick-recall reference for all business logic, rules, and module behaviour.

---

## 1. Rental Day Counting

**Rule: 24-hour based, minimum 2 days.**

| Period | Days Charged |
|--------|-------------|
| 0 – 47 h 59 min | 2 days (minimum) |
| 48 h exactly | 2 days |
| 48 h 1 sec → 71 h 59 min | 3 days |
| 72 h → 95 h 59 min | 4 days |
| …and so on | `ceil(totalSeconds / 86400)` |

**Formula:** `days = max(2, ceil(diffSeconds / 86400))`

**Single source of truth:**
- PHP → `App\Helpers\RentalHelper::calculateDays($start, $end)` — accepts Carbon, DateTime, timestamp, or string
- JS → `window.calcRentalDays(start, end)` — defined in `resources/js/app.js`, available globally

**Used in:**
- `app/Services/CartService.php` — `calculateDays()` (parses `item.dateRange`)
- `app/Http/Controllers/Admin/OrderController.php` — `store()` per-item calculation
- `resources/js/app.js` — Alpine cart store `calculateDays(dateRange)` and `subtotal()`
- `resources/views/admin/orders/create.blade.php` — `_calcDays(start, end)` delegates to `window.calcRentalDays`

---

## 2. Rental Pricing / Line Total

**Rule: price_per_day is the 2-day base rate. Extra days cost half the base rate each.**

**Formula:** `multiplier = max(1, days / 2)`
`lineTotal = quantity × price_per_day × multiplier`

| Days | Multiplier | Charge (example $1 base) |
|------|-----------|--------------------------|
| 1 | 1.0 | $1.00 |
| 2 | 1.0 | $1.00 |
| 3 | 1.5 | $1.50 |
| 4 | 2.0 | $2.00 |
| 5 | 2.5 | $2.50 |
| 6 | 3.0 | $3.00 |

**`price_per_day` is effectively the 2-day base price** — 1 day and 2 days cost the same.

**Used in:**
- `app/Services/CartService.php` — `getTotal()`
- `app/Http/Controllers/Admin/OrderController.php` — `store()`
- `resources/js/app.js` — Alpine cart store `subtotal()`
- `resources/views/admin/orders/create.blade.php` — `addProduct()`, `updateItemDates()`
- `app/Models/OrderItem.php` — computed `rental_days`, `line_total`

---

## 3. Distance & Delivery Charge

**Rule: Distance in miles. Flat fee within threshold, flat fee + actual miles beyond it.**


- No free delivery distance — every order pays travel cost based on actual distance
- Distance calculated using **Haversine formula** with Earth radius **3958.8 miles**
- Godown (warehouse) coordinates stored in Settings

**Formula:**
```
if distanceMiles ≤ max_delivery_distance:
    travelingCost = charge_per_mile × max_delivery_distance   ← flat fee for everyone within threshold

if distanceMiles > max_delivery_distance:
    travelingCost = charge_per_mile × max_delivery_distance
                  + charge_per_mile × distanceMiles            ← flat fee + actual mileage on top
```

**Example** (charge_per_mile = $1, max_delivery_distance = 40 mi):
| Actual distance | Calculation | Charge |
|----------------|-------------|--------|
| 20 mi | $1 × 40 | $40.00 |
| 40 mi | $1 × 40 | $40.00 |
| 60 mi | $1 × 40 + $1 × 60 | $100.00 |

**JS helper:** `calcTravelCost(distanceMiles)` method on the admin Alpine component; same logic inline in `checkout.blade.php calculateCost()`

**JS frontend:**
- Checkout: Google Maps `computeDistanceBetween()` → meters ÷ 1609.344 → miles
- Admin create: `haversine()` JS function with R = 3958.8

**Customer map location** stored on the `Customer` model as `map_location` JSON `{lat, lng, formatted_address}`.

**Settings fields:** `godown_address`, `godown_lat`, `godown_lng`, `charge_per_mile`, `max_delivery_distance`

---

## 4. Order Total Calculation

```
subtotal     = Σ (quantity × price_per_day × multiplier)  per item
tax          = subtotal × (tax_rate / 100)   ← configurable in Settings
travelCost   = see Distance formula (Section 3)
──────────────────────────────────────────────
orderTotal   = subtotal + tax + travelCost
```

> Tax applies to **subtotal only** — not to the delivery charge.
> `total_amount` stored in DB **includes tax** for both customer and admin-created orders.

---

## 5. Cart System

- Cart stored in **PHP session** via `CartService`
- Items keyed by `product_id` in session
- Cart data exposed via `GET /cart/data` (JSON) — Alpine store fetches on `init()`
- `dateRange` on cart items: format `"YYYY-MM-DD HH:MM → YYYY-MM-DD HH:MM"` (separator ` → `)
- Products added from product-detail page do **not** carry a dateRange — pricing defaults to 2-day minimum
- Rental start/end dates captured at checkout level (order-wide), not per cart item

**Stock check:** done both when adding to cart (CartController) and before order creation (CheckoutController)

---

## 6. Order Flow (Customer)

```
1. Browse products → add to cart (session)
2. Checkout page → fill customer info + rental dates + delivery location (map pin)
3. POST /checkout/process:
   - Validate fields
   - Create/update Customer (updateOrCreate by email)
   - Calculate distance + travelingCost
   - Stock validation for all cart items
   - Create Order + OrderItems
   - Return order_id (JSON)
4. Payment → /payment/create-intent → /payment/confirm
   - On confirm: Payment record created, Order status → 'confirmed', cart cleared
5. Redirect to /order/success
```

**Order statuses:** `pending` → `confirmed` → `active` → `completed` | `cancelled`

---

## 7. Order Flow (Admin Create)

```
1. Admin → Orders → Create Order
2. Select customer (existing or create inline)
3. Set rental start/end datetime (datetime-local inputs)
4. Add products — lineTotal auto-calculated via JS (window.calcRentalDays + multiplier)
5. Map pin for delivery location → distanceMiles + travelingCost auto-calculated
6. Set payment status (pending / paid / waived) and method
7. POST /admin/orders → OrderController.store():
   - Stock check
   - Server-side distance recalc if not provided
   - Server-side price recalc (RentalHelper)
   - Create Order + OrderItems
   - If paid: create Payment record, set status 'confirmed'
```

---

## 8. Settings Module

**Single row** in `settings` table — `Setting::first()` / `Setting::firstOrCreate()`.

| Field | Default | Purpose |
|-------|---------|---------|
| `godown_address` | — | Warehouse display address |
| `godown_lat` | — | Warehouse latitude for distance calc |
| `godown_lng` | — | Warehouse longitude for distance calc |
| `charge_per_mile` | 1.00 | $ per mile delivery charge |
| `max_delivery_distance` | 20.00 | Flat-rate threshold in miles (see Section 3) |
| `tax_rate` | 9.25 | % applied to order subtotal (not delivery) |

Admin: Settings → System Configuration page.

---

## 9. Products & Categories

- **Product** fields: `name`, `slug`, `description`, `price_per_day` (2-day base rate), `deposit_percentage`, `total_quantity` (stock), `color`, `material`, `status` (`available`/`unavailable`), `product_specification` (JSON), soft deletes
- **Category** fields: `name`, `slug`, `image`, `description`, `icon`, soft deletes
- Each product belongs to one Category; multiple `ProductImage` records with `sort_order`
- Products filtered by category on the public products page via `?category=slug`

---

## 10. Customers Module

- Created automatically on first checkout (`updateOrCreate` by email)
- Can also be created manually from Admin → Customers
- Key fields: `name`, `email`, `phone`, `address`, `map_location` (JSON `{lat,lng,formatted_address}`)
- Computed attributes: `total_spent`, `latest_order`, `initials`
- `map_location` reused on subsequent orders for distance calculation

---

## 11. Payments

- Payment intent created via `POST /payment/create-intent`
- Confirmed via `POST /payment/confirm`
- `Payment` record fields: `order_id`, `payment_intent_id`, `amount`, `currency` (usd), `status` (`succeeded`/`failed`/`pending`), `payment_method`
- Admin can mark orders as paid manually during order creation (method: cash / bank_transfer / card / other / manual)
- Payment creates a `Payment` record and sets order status to `confirmed`

---

## 12. Admin Auth

- Google OAuth login only (`admin.auth.google`)
- Standard session-based after OAuth
- All `/admin/*` routes protected by auth middleware

---

## Key File Locations

| Concern | File |
|---------|------|
| Rental day helper (PHP) | `app/Helpers/RentalHelper.php` |
| Rental day helper (JS) | `resources/js/app.js` → `window.calcRentalDays` |
| Cart logic | `app/Services/CartService.php` |
| Customer checkout | `app/Http/Controllers/CheckoutController.php` |
| Admin order create | `app/Http/Controllers/Admin/OrderController.php` |
| Settings | `app/Http/Controllers/Admin/SettingController.php` |
| Distance (JS, checkout) | `resources/views/pages/checkout.blade.php` |
| Distance (JS, admin) | `resources/views/admin/orders/create.blade.php` |
| Pricing migration | `database/migrations/2026_05_07_081623_create_settings_table.php` |
| Orders table migration | `database/migrations/2026_05_07_081719_add_traveling_cost_and_event_date_to_orders_table.php` |
