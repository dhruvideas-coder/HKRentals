<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Persists a customer order from a validated checkout payload + cart snapshot.
 *
 * Centralised so the customer checkout (invoice = create now) and the payment
 * confirmation (card = create only after payment succeeds) build orders the
 * exact same way. An order is therefore only ever created at a real completion
 * point — an abandoned/incomplete checkout never leaves an order behind.
 */
class CheckoutOrderService
{
    /**
     * @param  array  $data    Normalised checkout fields (see CheckoutController::buildCheckoutPayload)
     * @param  array  $cart    Cart snapshot (CartService::getCart shape)
     * @param  string $status  Order status to set ('pending' for invoice, 'confirmed' for paid card)
     */
    public function persist(array $data, array $cart, string $status): Order
    {
        return DB::transaction(function () use ($data, $cart, $status) {
            $customer = Customer::updateOrCreate(
                ['email' => $data['email']],
                array_filter([
                    'name'         => $data['name'],
                    'phone'        => $data['phone'],
                    'address'      => $data['address'],
                    'map_location' => $data['map_location'] ?? null,
                ], fn ($v) => $v !== null)
            );

            $order = Order::create([
                'customer_id'       => $customer->id,
                'customer_name'     => $data['name'],
                'customer_email'    => $data['email'],
                'customer_phone'    => $data['phone'],
                'customer_address'  => $data['address'],
                'rental_start_date' => $data['rental_start_date'],
                'rental_end_date'   => $data['rental_end_date'],
                'total_amount'      => $data['total_amount'],
                'traveling_cost'    => $data['traveling_cost'],
                'distance_miles'    => $data['distance_miles'],
                'is_pickup'         => $data['is_pickup'],
                'status'            => $status,
            ]);

            foreach ($cart as $item) {
                [$startDate, $endDate] = $this->itemDates($item, $order);

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'quantity'      => $item['quantity'],
                    'price_per_day' => $item['price'],
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                ]);
            }

            return $order;
        });
    }

    /**
     * Resolve a cart line's start/end dates, falling back to the order rental window.
     */
    private function itemDates(array $item, Order $order): array
    {
        $startDate = $order->rental_start_date;
        $endDate   = $order->rental_end_date;

        if (! empty($item['dateRange'])) {
            $parts = explode(' → ', $item['dateRange']);
            if (count($parts) === 2) {
                $startDate = Carbon::parse($parts[0]);
                $endDate   = Carbon::parse($parts[1]);
            }
        }

        return [$startDate, $endDate];
    }
}
