<x-layout.app-layout>
    <x-slot:title>Order Confirmed — {{ $order->formatted_id }}</x-slot>
    <x-slot:metaDescription>Your order has been confirmed. Thank you for booking with us!</x-slot>

<section class="py-16 bg-cream min-h-screen" aria-label="Order success">
<div class="container-sk max-w-3xl">

    {{-- ── Success Header ── --}}
    <div class="text-center mb-10">
        <div class="relative inline-flex items-center justify-center mb-6">
            <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="absolute -top-2 -left-2 w-3 h-3 rounded-full bg-brand-400 opacity-70"></span>
            <span class="absolute -top-1 right-0 w-2 h-2 rounded-full bg-pink-400 opacity-70"></span>
            <span class="absolute bottom-0 -right-3 w-3 h-3 rounded-full bg-sky-400 opacity-60"></span>
        </div>
        <div class="inline-flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-xs font-bold uppercase tracking-wider px-4 py-1.5 rounded-full mb-4">
            Booking Confirmed
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 mb-3">
            Thank You for Choosing Us!
        </h1>
        <p class="text-neutral-500 text-base max-w-md mx-auto">
            Your order <span class="font-bold text-brand-600">{{ $order->formatted_id }}</span> has been received and is being processed.
        </p>
    </div>

    {{-- ── Order Receipt Card ── --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-neutral-100 overflow-hidden mb-6">

        {{-- Card Header --}}
        <div class="px-6 md:px-8 py-5 border-b border-neutral-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-neutral-900 text-lg">Order Receipt</h2>
                <p class="text-xs text-neutral-400 mt-0.5">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="font-mono text-sm font-bold text-brand-600 bg-brand-50 px-3 py-1.5 rounded-lg">{{ $order->formatted_id }}</span>
                <span class="text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full
                    @if($order->status === 'pending')   bg-amber-100 text-amber-700
                    @elseif($order->status === 'confirmed') bg-brand-50 text-brand-700
                    @elseif($order->status === 'active')    bg-green-100 text-green-700
                    @elseif($order->status === 'completed') bg-neutral-100 text-neutral-600
                    @else bg-red-100 text-red-600
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        {{-- Customer + Rental Info ── --}}
        {{-- Pickup banner --}}
        @if($order->is_pickup)
        <div class="px-6 md:px-8 py-3 bg-sky-50 border-b border-sky-100 flex items-center gap-3">
            <svg class="w-4 h-4 text-sky-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span class="text-sm font-bold text-sky-700">Customer Pickup — no delivery charge</span>
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 divide-y sm:divide-y-0 sm:divide-x divide-neutral-100 border-b border-neutral-100">
            <div class="px-6 md:px-8 py-5">
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2">Customer</p>
                <p class="font-bold text-neutral-800">{{ $order->customer_name }}</p>
                <p class="text-sm text-neutral-500 mt-0.5">{{ $order->customer_email }}</p>
                <p class="text-sm text-neutral-500">{{ $order->customer_phone }}</p>
            </div>
            <div class="px-6 md:px-8 py-5">
                @if($order->is_pickup)
                    @php $settings = \App\Models\Setting::first(); @endphp
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2">Pickup Location</p>
                    <p class="text-sm font-bold text-neutral-800">{{ config('app.name') }} Warehouse</p>
                    <p class="text-sm text-neutral-600 mt-0.5 leading-relaxed">{{ $settings?->godown_address ?? 'Knoxville, Tennessee, USA' }}</p>
                    <p class="text-xs text-sky-600 mt-1.5 font-medium">Please bring this receipt when collecting your items.</p>
                @else
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2">Delivery Address</p>
                    <p class="text-sm text-neutral-700 leading-relaxed">{{ $order->customer_address }}</p>
                @endif
            </div>
        </div>

        @if($order->rental_start_date && $order->rental_end_date)
        <div class="px-6 md:px-8 py-4 bg-brand-50/50 border-b border-brand-100/50 flex items-center gap-3">
            <svg class="w-4 h-4 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm font-semibold text-brand-700">
                Rental Period:
                <span class="font-bold">{{ $order->rental_start_date->format('M j, Y g:i A') }}</span>
                <span class="mx-2 text-brand-400">→</span>
                <span class="font-bold">{{ $order->rental_end_date->format('M j, Y g:i A') }}</span>
            </span>
        </div>
        @endif

        {{-- Order Items --}}
        <div class="divide-y divide-neutral-50">
            @foreach($order->items as $item)
            <div class="px-6 md:px-8 py-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl overflow-hidden ring-1 ring-neutral-100 flex-shrink-0 bg-neutral-50">
                    @if($item->product?->image)
                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-neutral-800 text-sm">{{ $item->product?->name ?? 'Product removed' }}</p>
                    <p class="text-xs text-neutral-400 mt-0.5">
                        Qty: {{ $item->quantity }}
                        @if($item->start_date && $item->end_date)
                            &nbsp;·&nbsp; {{ $item->start_date->format('M d') }} → {{ $item->end_date->format('M d, Y') }}
                            &nbsp;·&nbsp; {{ $item->rental_days }} day{{ $item->rental_days !== 1 ? 's' : '' }}
                        @endif
                    </p>
                </div>
                <p class="font-bold text-neutral-900 text-sm flex-shrink-0">${{ number_format($item->line_total, 2) }}</p>
            </div>
            @endforeach
        </div>

        {{-- Pricing Summary --}}
        @php
            $subtotal = $order->items->sum('line_total');
            $settings = \App\Models\Setting::first();
            $taxRate  = $settings?->tax_rate ?? 9.25;
            $tax      = $order->total_amount - $subtotal - $order->traveling_cost;
        @endphp
        <div class="px-6 md:px-8 py-5 bg-neutral-50/50 border-t border-neutral-100 space-y-2">
            <div class="flex justify-between text-sm text-neutral-600">
                <span>Subtotal</span>
                <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm text-neutral-600">
                @if($order->is_pickup)
                    <span>Pickup (no delivery charge)</span>
                    <span class="font-semibold text-green-600">Free</span>
                @else
                    <span>Delivery & Setup
                        @if($order->distance_miles)
                            <span class="text-xs text-neutral-400">({{ number_format($order->distance_miles, 1) }} mi)</span>
                        @endif
                    </span>
                    <span class="font-semibold">${{ number_format($order->traveling_cost, 2) }}</span>
                @endif
            </div>
            <div class="flex justify-between text-sm text-neutral-600">
                <span>Tax ({{ $taxRate }}%)</span>
                <span class="font-semibold">${{ number_format(max(0, $tax), 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-neutral-900 text-base pt-2 border-t border-neutral-200">
                <span>Total</span>
                <span>${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        {{-- Payment Info — only when actually paid ── --}}
        @if($order->payment && $order->payment->status === 'succeeded')
        <div class="px-6 md:px-8 py-4 border-t border-neutral-100 flex flex-wrap gap-6">
            <div>
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Payment Status</p>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Paid
                </span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Method</p>
                <p class="text-sm font-semibold text-neutral-700">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method ?? '—')) }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1">Amount Paid</p>
                <p class="text-sm font-bold text-neutral-900">${{ number_format($order->payment->amount, 2) }}</p>
            </div>
        </div>
        @endif

        {{-- Download PDF Button --}}
        <div class="px-6 md:px-8 py-5 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
            <p class="text-xs text-neutral-400">You'll receive a confirmation email with all details shortly.</p>
            <a href="{{ route('order.receipt', $order) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-neutral-900 text-white text-sm font-bold rounded-xl hover:bg-neutral-700 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF Receipt
            </a>
        </div>
    </div>

    {{-- ── What Happens Next ── --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-neutral-100 p-6 md:p-8 mb-8">
        <h3 class="font-bold text-neutral-900 mb-5">What happens next?</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach([
                ['📧','Confirmation Email','You\'ll receive an email with full order details within a few minutes.'],
                ['📞','We\'ll Call You','Our team will reach out 48 hours before delivery to confirm the schedule.'],
                ['🚚','Delivery & Setup','We handle delivery and professional setup on your event day.'],
                ['✨','Pickup','After your event, we collect everything. You don\'t lift a finger!'],
            ] as [$icon, $title, $desc])
            <div class="flex items-start gap-3 p-4 bg-neutral-50 rounded-2xl">
                <span class="text-2xl flex-shrink-0">{{ $icon }}</span>
                <div>
                    <p class="font-semibold text-neutral-800 text-sm">{{ $title }}</p>
                    <p class="text-xs text-neutral-400 mt-1 leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTAs --}}
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg shadow-glow w-full sm:w-auto">Return to Home</a>
        <a href="{{ route('products') }}" class="btn btn-outline btn-lg w-full sm:w-auto">Continue Browsing</a>
    </div>

</div>
</section>

</x-layout.app-layout>
