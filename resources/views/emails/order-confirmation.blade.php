<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Order Confirmed — {{ $order->formatted_id }}</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1a1a1a; background: #f5f2ee; }
    .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

    /* Body */
    .body { padding: 32px 40px; }

    /* Section */
    .section-title { font-size: 11px; font-weight: 700; color: #999; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 12px; padding-bottom: 6px; border-bottom: 2px solid #f0ece6; }

    /* Info box */
    .info-grid { display: table; width: 100%; margin-bottom: 24px; border-spacing: 0; }
    .info-col { display: table-cell; width: 50%; vertical-align: top; padding-right: 12px; }
    .info-col:last-child { padding-right: 0; padding-left: 12px; }
    .info-box { background: #faf9f7; border: 1px solid #ede9e3; border-radius: 10px; padding: 14px 16px; }
    .info-label { font-size: 10px; font-weight: 700; color: #aaa; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px; }
    .info-value { font-size: 13px; color: #333; line-height: 1.7; }

    /* Rental dates banner */
    .dates-banner { background: #fdf8f0; border: 1px solid #e8d9b8; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; text-align: center; }
    .dates-label { font-size: 10px; font-weight: 700; color: #c8a96e; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px; }
    .dates-value { font-size: 14px; font-weight: 700; color: #1a1a1a; }

    /* Pickup banner */
    .pickup-banner { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; }
    .pickup-label { font-size: 11px; font-weight: 700; color: #1d4ed8; letter-spacing: 0.5px; margin-bottom: 4px; }
    .pickup-value { font-size: 13px; color: #1e3a5f; }

    /* Items */
    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
    .items-table th { padding: 10px 12px; background: #1a1a1a; color: #c8a96e; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; text-align: left; }
    .items-table th:last-child { text-align: right; }
    .items-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #f0ece6; color: #333; vertical-align: top; }
    .items-table td:last-child { text-align: right; font-weight: 700; color: #1a1a1a; }
    .items-table tr:last-child td { border-bottom: none; }
    .item-name { font-weight: 600; color: #1a1a1a; }
    .item-meta { font-size: 11px; color: #999; margin-top: 2px; }

    /* Totals */
    .totals { background: #faf9f7; border: 1px solid #ede9e3; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; }
    .totals-row { display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 8px; }
    .totals-row:last-child { margin-bottom: 0; font-size: 15px; font-weight: 700; color: #1a1a1a; padding-top: 10px; border-top: 2px solid #c8a96e; margin-top: 4px; }
    .totals-delivery { color: #c8a96e; }

    /* Payment */
    .payment-row { display: flex; align-items: center; gap: 8px; padding: 10px 0; border-bottom: 1px solid #f0ece6; font-size: 13px; color: #555; }
    .payment-row:last-child { border-bottom: none; }
    .badge-paid { background: #d1fae5; color: #065f46; font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 20px; }
    .badge-pending { background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 20px; }

    /* CTA */
    .cta { text-align: center; margin: 28px 0; }
    .cta a { display: inline-block; background: #c8a96e; color: #ffffff; font-weight: 700; font-size: 14px; padding: 14px 32px; border-radius: 10px; text-decoration: none; letter-spacing: 0.3px; }

    /* Footer */
    .footer { background: #1a1a1a; padding: 24px 40px; text-align: center; }
    .footer p { font-size: 12px; color: #666; line-height: 1.8; }
    .footer a { color: #c8a96e; text-decoration: none; }
    .footer-brand { font-size: 14px; font-weight: 700; color: #c8a96e; margin-bottom: 6px; }
</style>
</head>
<body>
<div class="wrapper">

    {{-- Compact header: brand (logo + name) on the left, order status on the right --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#1a1a1a;">
        <tr>
            <td style="padding:22px 32px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        {{-- Brand --}}
                        <td valign="middle" align="left">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="middle" style="background:#ffffff;border-radius:10px;padding:7px 11px;">
                                        <img src="{{ $message->embed(public_path('images/logo.webp')) }}" alt="{{ config('app.name', 'SK Rentals') }}" width="60" style="display:block;height:auto;max-width:60px;">
                                    </td>
                                    <td valign="middle" style="padding-left:13px;">
                                        <div style="font-family:Georgia,'Times New Roman',serif;font-size:19px;font-weight:700;color:#c8a96e;letter-spacing:1px;line-height:1.1;">
                                            {{ config('app.name', 'SK Rentals') }}
                                        </div>
                                        <div style="font-size:9px;color:#9a9a9a;letter-spacing:1.5px;text-transform:uppercase;margin-top:5px;">
                                            Premium Wedding &amp; Event Rentals
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        {{-- Order status --}}
                        <td valign="middle" align="right">
                            <div style="font-size:12px;font-weight:700;color:#22c55e;margin-bottom:7px;white-space:nowrap;">&#10004;&nbsp;Order Confirmed</div>
                            <table role="presentation" cellpadding="0" cellspacing="0" align="right">
                                <tr>
                                    <td style="background:#c8a96e;border-radius:20px;padding:5px 15px;">
                                        <span style="font-size:12px;font-weight:700;color:#1a1a1a;letter-spacing:1px;">{{ $order->formatted_id }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="body">

        {{-- Main message (admin-written) --}}
        <div style="font-size:14px;color:#333;line-height:1.7;margin-bottom:28px;">
            {!! nl2br(e($email['body'])) !!}
        </div>

        {{-- Customer + Address --}}
        <div class="info-grid">
            <div class="info-col">
                <div class="info-label">Customer</div>
                <div class="info-box">
                    <div class="info-value">
                        <strong>{{ $order->customer_name }}</strong><br>
                        {{ $order->customer_email }}<br>
                        {{ $order->customer_phone }}
                    </div>
                </div>
            </div>
            <div class="info-col">
                @if($order->is_pickup)
                    <div class="info-label">Pickup Location</div>
                    <div class="info-box">
                        <div class="info-value">
                            <strong>{{ config('app.name') }} Warehouse</strong><br>
                            {{ $settings->godown_address ?? 'Knoxville, Tennessee, USA' }}
                        </div>
                    </div>
                @else
                    <div class="info-label">Delivery Address</div>
                    <div class="info-box">
                        <div class="info-value">{{ $order->customer_address }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Pickup notice --}}
        @if($order->is_pickup)
        <div class="pickup-banner">
            <div class="pickup-label">🏢 Customer Pickup — No Delivery Charge</div>
            <div class="pickup-value">Please bring this email when collecting your items from our warehouse.</div>
        </div>
        @endif

        {{-- Rental period --}}
        @if($order->rental_start_date && $order->rental_end_date)
        <div class="dates-banner">
            <div class="dates-label">📅 Rental Period</div>
            <div class="dates-value">
                {{ $order->rental_start_date->format('D, M j, Y g:i A') }}
                &nbsp;→&nbsp;
                {{ $order->rental_end_date->format('D, M j, Y g:i A') }}
            </div>
        </div>
        @endif

        {{-- Order items --}}
        <div class="section-title">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:15%">Qty</th>
                    <th style="width:20%">Rental Days</th>
                    <th style="width:15%">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->product?->name ?? 'Product removed' }}</div>
                        <div class="item-meta">${{ number_format($item->price_per_day, 2) }} base rate</div>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->rental_days }} day{{ $item->rental_days !== 1 ? 's' : '' }}</td>
                    <td>${{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        @php
            $subtotal = $order->items->sum('line_total');
            $taxRate  = $settings->tax_rate ?? 9.25;
            $tax      = $order->total_amount - $subtotal - $order->traveling_cost;
        @endphp
        <div class="totals">
            <div class="totals-row"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span></div>
            <div class="totals-row totals-delivery">
                <span>
                    @if($order->is_pickup) Pickup (no charge)
                    @else Delivery{{ $order->distance_miles ? ' (' . number_format($order->distance_miles, 1) . ' mi)' : '' }}
                    @endif
                </span>
                <span>{{ $order->is_pickup ? 'Free' : '$' . number_format($order->traveling_cost, 2) }}</span>
            </div>
            <div class="totals-row"><span>Tax ({{ $taxRate }}%)</span><span>${{ number_format(max(0, $tax), 2) }}</span></div>
            <div class="totals-row"><span>Total</span><span>${{ number_format($order->total_amount, 2) }}</span></div>
        </div>

        {{-- Payment --}}
        @if($order->payment && $order->payment->status === 'succeeded')
        <div class="section-title">Payment</div>
        <div style="background:#faf9f7;border:1px solid #ede9e3;border-radius:10px;padding:14px 20px;margin-bottom:24px;">
            <div class="payment-row">
                <span>Status</span>
                <span style="margin-left:auto"><span class="badge-paid">Paid ✓</span></span>
            </div>
            <div class="payment-row">
                <span>Method</span>
                <span style="margin-left:auto;font-weight:600;">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method ?? '—')) }}</span>
            </div>
            <div class="payment-row">
                <span>Amount</span>
                <span style="margin-left:auto;font-weight:700;">${{ number_format($order->payment->amount, 2) }}</span>
            </div>
        </div>
        @endif

        {{-- CTA --}}
        <div class="cta">
            <a href="{{ url('/order-success/' . $order->id) }}">View Full Order &amp; Download Receipt</a>
        </div>

        {{-- Note --}}
        <p style="font-size:12px;color:#999;text-align:center;line-height:1.7;">
            Your PDF receipt is attached to this email.
        </p>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <div class="footer-brand">{{ config('app.name', 'SK Rentals') }}</div>
        <p>
            📍 {{ $settings->godown_address ?? 'Knoxville, Tennessee, USA' }}<br>
            📧 <a href="mailto:{{ config('mail.from.address', 'hello@skrentals.com') }}">{{ config('mail.from.address', 'hello@skrentals.com') }}</a>
            &nbsp;·&nbsp; 📞 (865) 000-0000
        </p>
        <p style="margin-top:12px;font-size:11px;color:#555;">
            This is an automated confirmation email. Receipt #{{ $order->formatted_id }} · {{ now()->format('F j, Y') }}
        </p>
    </div>

</div>
</body>
</html>
