<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Receipt {{ $order->formatted_id }}</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #1a1a1a; background: #fff; }

    /* ── Layout ── */
    .page { padding: 36px 40px; max-width: 780px; margin: 0 auto; }

    /* ── Header ── */
    .header { display: table; width: 100%; border-bottom: 2px solid #c8a96e; padding-bottom: 20px; margin-bottom: 24px; }
    .header-logo { display: table-cell; vertical-align: middle; width: 84px; padding-right: 16px; }
    .header-logo img { height: 64px; width: auto; }
    .header-left { display: table-cell; vertical-align: middle; width: auto; }
    .header-right { display: table-cell; vertical-align: middle; text-align: right; width: 36%; padding-left: 16px; }
    .company-name { font-size: 22px; font-weight: 700; color: #c8a96e; letter-spacing: 0.5px; }
    .company-tagline { font-size: 10px; color: #888; margin-top: 2px; letter-spacing: 0.3px; }
    .company-contact { font-size: 10px; color: #555; margin-top: 8px; line-height: 1.6; }
    .receipt-label { font-size: 10px; font-weight: 700; color: #888; letter-spacing: 1.5px; text-transform: uppercase; }
    .receipt-id { font-size: 20px; font-weight: 700; color: #1a1a1a; margin-top: 2px; }
    .receipt-date { font-size: 10px; color: #888; margin-top: 4px; }

    /* ── Status badge ── */
    .status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px; }
    .status-pending   { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #fdf8f0; color: #c8a96e; border: 1px solid #c8a96e; }
    .status-active    { background: #d1fae5; color: #065f46; }
    .status-completed { background: #f3f4f6; color: #374151; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* ── Section title ── */
    .section-title { font-size: 9px; font-weight: 700; color: #999; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; padding-bottom: 4px; border-bottom: 1px solid #f0ece6; }

    /* ── Info grid ── */
    .info-grid { display: table; width: 100%; margin-bottom: 20px; }
    .info-col  { display: table-cell; width: 50%; vertical-align: top; padding-right: 16px; }
    .info-col:last-child { padding-right: 0; }
    .info-box { background: #faf9f7; border: 1px solid #ede9e3; border-radius: 6px; padding: 12px 14px; }
    .info-label { font-size: 9px; font-weight: 700; color: #aaa; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px; }
    .info-value { font-size: 12px; color: #1a1a1a; line-height: 1.7; }
    .info-value strong { font-weight: 700; }

    /* ── Rental period banner ── */
    .rental-banner { background: #fdf8f0; border: 1px solid #e8d9b8; border-radius: 6px; padding: 10px 14px; margin-bottom: 20px; display: table; width: 100%; }
    .rental-banner-icon { display: table-cell; width: 20px; vertical-align: middle; font-size: 14px; }
    .rental-banner-text { display: table-cell; vertical-align: middle; }
    .rental-banner-label { font-size: 9px; font-weight: 700; color: #c8a96e; letter-spacing: 1px; text-transform: uppercase; }
    .rental-banner-dates { font-size: 12px; font-weight: 700; color: #1a1a1a; margin-top: 1px; }

    /* ── Items table ── */
    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .items-table thead tr { background: #c8a96e; }
    .items-table thead th { padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #fff; letter-spacing: 0.8px; text-transform: uppercase; }
    .items-table thead th:last-child { text-align: right; }
    .items-table tbody tr { border-bottom: 1px solid #f0ece6; }
    .items-table tbody tr:last-child { border-bottom: none; }
    .items-table tbody tr:nth-child(even) { background: #faf9f7; }
    .items-table tbody td { padding: 9px 10px; font-size: 11px; color: #333; vertical-align: middle; }
    .items-table tbody td:last-child { text-align: right; font-weight: 700; color: #1a1a1a; }
    .item-img { width: 38px; height: 38px; border-radius: 6px; object-fit: cover; border: 1px solid #ede9e3; display: block; }
    .item-img-placeholder { width: 38px; height: 38px; border-radius: 6px; background: #f0ece6; border: 1px solid #ede9e3; display: block; }
    .item-name { font-weight: 600; color: #1a1a1a; }
    .item-meta { font-size: 9px; color: #999; margin-top: 2px; }

    /* ── Totals ── */
    .totals-wrap { display: table; width: 100%; margin-bottom: 20px; }
    .totals-spacer { display: table-cell; width: 55%; }
    .totals-box { display: table-cell; width: 45%; vertical-align: top; }
    .totals-table { width: 100%; }
    .totals-table tr td { padding: 5px 0; font-size: 11px; color: #555; }
    .totals-table tr td:last-child { text-align: right; font-weight: 600; color: #1a1a1a; }
    .totals-table .total-row td { font-size: 14px; font-weight: 700; color: #1a1a1a; border-top: 2px solid #c8a96e; padding-top: 8px; margin-top: 4px; }
    .totals-table .delivery-row td { color: #c8a96e; }

    /* ── Payment info ── */
    .payment-box { background: #faf9f7; border: 1px solid #ede9e3; border-radius: 6px; padding: 12px 14px; margin-bottom: 20px; display: table; width: 100%; }
    .payment-col { display: table-cell; width: 33.33%; vertical-align: top; padding-right: 12px; }
    .payment-col:last-child { padding-right: 0; }
    .payment-label { font-size: 9px; font-weight: 700; color: #aaa; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 4px; }
    .payment-value { font-size: 11px; font-weight: 600; color: #1a1a1a; }
    .paid-badge { color: #065f46; background: #d1fae5; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; display: inline-block; }
    .unpaid-badge { color: #92400e; background: #fef3c7; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; display: inline-block; }

    /* ── Footer ── */
    .footer { border-top: 1px solid #ede9e3; padding-top: 16px; text-align: center; color: #aaa; font-size: 10px; line-height: 1.7; }
    .footer strong { color: #c8a96e; }
</style>
</head>
<body>
<div class="page">

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/logo.webp') }}" alt="{{ config('app.name', 'SK Rentals') }}">
        </div>
        <div class="header-left">
            <div class="company-name">{{ config('app.name', 'SK Rentals') }}</div>
            <div class="company-tagline">Premium Wedding & Event Rentals — Knoxville, TN</div>
            <div class="company-contact">
                📍 Knoxville, Tennessee, USA<br>
                📧 hello@skrentals.com &nbsp;|&nbsp; 📞 (865) 000-0000<br>
                🌐 www.skrentals.com
            </div>
        </div>
        <div class="header-right">
            <div class="receipt-label">Order Receipt</div>
            <div class="receipt-id">{{ $order->formatted_id }}</div>
            <div class="receipt-date">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>
            <div>
                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
        </div>
    </div>

    {{-- ── FULFILLMENT BADGE ── --}}
    @if($order->is_pickup)
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:9px 14px;margin-bottom:18px;display:table;width:100%;">
        <div style="display:table-cell;width:22px;vertical-align:middle;font-size:15px;">🏢</div>
        <div style="display:table-cell;vertical-align:middle;">
            <span style="font-size:9px;font-weight:700;color:#1d4ed8;letter-spacing:1px;text-transform:uppercase;">Customer Pickup</span>
            <div style="font-size:11px;color:#1e3a5f;margin-top:1px;font-weight:600;">Customer will collect items from our warehouse — no delivery charge.</div>
        </div>
    </div>
    @endif

    {{-- ── CUSTOMER & DELIVERY/PICKUP INFO ── --}}
    <div class="info-grid">
        <div class="info-col">
            <div class="section-title">Customer Information</div>
            <div class="info-box">
                <div class="info-value">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_email }}<br>
                    {{ $order->customer_phone }}<br>
                </div>
            </div>
        </div>
        <div class="info-col">
            @if($order->is_pickup)
                <div class="section-title">Pickup Location (Warehouse)</div>
                <div class="info-box">
                    <div class="info-value">
                        <strong>{{ config('app.name', 'SK Rentals') }} Warehouse</strong><br>
                        {{ $settings?->godown_address ?? 'Knoxville, Tennessee, USA' }}<br>
                        <span style="font-size:10px;color:#888;">Please bring this receipt when collecting your items.</span>
                    </div>
                </div>
            @else
                <div class="section-title">Billing & Delivery Address</div>
                <div class="info-box">
                    <div class="info-value">
                        {{ $order->customer_address }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ── RENTAL PERIOD ── --}}
    @if($order->rental_start_date && $order->rental_end_date)
    <div class="rental-banner">
        <div class="rental-banner-icon">📅</div>
        <div class="rental-banner-text">
            <div class="rental-banner-label">Rental Period</div>
            <div class="rental-banner-dates">
                {{ $order->rental_start_date->format('D, M j, Y g:i A') }}
                &nbsp;&rarr;&nbsp;
                {{ $order->rental_end_date->format('D, M j, Y g:i A') }}
            </div>
        </div>
    </div>
    @endif

    {{-- ── ORDER ITEMS ── --}}
    <div class="section-title">Order Items</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:6%"></th>
                <th style="width:32%">Product</th>
                <th style="width:12%">Qty</th>
                <th style="width:22%">Rental Period</th>
                <th style="width:10%">Days</th>
                <th style="width:18%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            @php
                $imgPath = $item->product?->image ? public_path($item->product->image) : null;
                $hasImg  = $imgPath && file_exists($imgPath);
            @endphp
            <tr>
                <td style="padding: 8px 6px 8px 10px;">
                    @if($hasImg)
                        <img src="{{ $imgPath }}" class="item-img" alt=""/>
                    @else
                        <div class="item-img-placeholder"></div>
                    @endif
                </td>
                <td>
                    <div class="item-name">{{ $item->product?->name ?? 'Product removed' }}</div>
                    <div class="item-meta">${{ number_format($item->price_per_day, 2) }} base rate</div>
                </td>
                <td>{{ $item->quantity }}</td>
                <td>
                    @if($item->start_date && $item->end_date)
                        <div>{{ $item->start_date->format('M j, Y') }}</div>
                        <div class="item-meta">→ {{ $item->end_date->format('M j, Y') }}</div>
                    @else
                        <span style="color:#bbb">—</span>
                    @endif
                </td>
                <td>{{ $item->rental_days }}d</td>
                <td>${{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ── TOTALS ── --}}
    @php
        $subtotal = $order->items->sum('line_total');
        $tax      = $order->total_amount - $subtotal - $order->traveling_cost;
        $taxRate  = $settings?->tax_rate ?? 9.25;
    @endphp
    <div class="totals-wrap">
        <div class="totals-spacer"></div>
        <div class="totals-box">
            <table class="totals-table">
                <tr>
                    <td>Subtotal</td>
                    <td>${{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr class="delivery-row">
                    <td>
                        @if($order->is_pickup)
                            Pickup (no charge)
                        @else
                            Delivery @if($order->distance_miles)({{ number_format($order->distance_miles, 1) }} mi)@endif
                        @endif
                    </td>
                    <td>{{ $order->is_pickup ? '$0.00' : '$' . number_format($order->traveling_cost, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax ({{ $taxRate }}%)</td>
                    <td>${{ number_format(max(0, $tax), 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ── PAYMENT INFO — only when paid ── --}}
    @php $payment = $order->payment; @endphp
    @if($payment && $payment->status === 'succeeded')
    <div class="section-title">Payment Information</div>
    <div class="payment-box">
        <div class="payment-col">
            <div class="payment-label">Payment Status</div>
            <div class="payment-value"><span class="paid-badge">Paid</span></div>
        </div>
        <div class="payment-col">
            <div class="payment-label">Payment Method</div>
            <div class="payment-value">{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</div>
        </div>
        <div class="payment-col">
            <div class="payment-label">Amount Paid</div>
            <div class="payment-value">${{ number_format($payment->amount, 2) }}</div>
        </div>
    </div>
    @endif

    {{-- ── FOOTER ── --}}
    <div class="footer">
        <strong>Thank you for choosing {{ config('app.name', 'SK Rentals') }}!</strong><br>
        Questions? Contact us at hello@skrentals.com or (865) 000-0000<br>
        This is your official order receipt. Please keep it for your records.<br>
        <span style="font-size:9px; color:#ccc; margin-top:4px; display:block;">
            Generated on {{ now()->format('F j, Y \a\t g:i A') }} &nbsp;·&nbsp; {{ $order->formatted_id }}
        </span>
    </div>

</div>
</body>
</html>
