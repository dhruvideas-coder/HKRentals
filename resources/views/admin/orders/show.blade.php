<x-layout.admin-layout>
    <x-slot:title>Order #{{ $order->formatted_id }}</x-slot>
    <x-slot:pageTitle>Order Detail</x-slot>

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-neutral-400 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="hover:text-brand-600 transition-colors font-medium">Orders</a>
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 font-semibold">#{{ $order->formatted_id }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- LEFT COLUMN: Order items --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- Order Items Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-neutral-900">Order Items</h3>
                    <p class="text-xs text-neutral-400 mt-0.5">{{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }} in this order</p>
                </div>
                <span class="font-mono text-sm font-bold text-brand-600 bg-brand-50 px-3 py-1.5 rounded-lg">#{{ $order->formatted_id }}</span>
            </div>
            <div class="divide-y divide-neutral-50">
                @forelse($order->items as $item)
                <div class="px-6 py-4 flex items-center gap-4">
                    {{-- Product image --}}
                    <div class="w-14 h-14 rounded-xl overflow-hidden ring-1 ring-neutral-100 flex-shrink-0 bg-neutral-50">
                        @if($item->product?->image)
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" />
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Product info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-neutral-800 text-sm leading-tight truncate">
                            {{ $item->product?->name ?? 'Product removed' }}
                        </p>
                        @if($item->start_date && $item->end_date)
                        <p class="text-xs text-neutral-400 mt-0.5">
                            {{ $item->start_date->format('M d') }} → {{ $item->end_date->format('M d, Y') }}
                            <span class="text-neutral-300 mx-1">·</span>
                            {{ $item->rental_days }} day{{ $item->rental_days !== 1 ? 's' : '' }}
                        </p>
                        @else
                        <p class="text-xs text-neutral-400 mt-0.5">No rental dates set</p>
                        @endif
                        <p class="text-xs text-neutral-400 mt-0.5">Qty: {{ $item->quantity }} × ${{ number_format($item->price_per_day, 2) }}/day</p>
                    </div>

                    {{-- Line total --}}
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-neutral-900 text-sm">${{ number_format($item->line_total, 2) }}</p>
                        @if($item->rental_days > 1)
                        <p class="text-[10px] text-neutral-400">{{ $item->rental_days }}d × ${{ number_format($item->price_per_day * $item->quantity, 2) }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-neutral-400 text-sm">No items in this order.</div>
                @endforelse
            </div>

            {{-- Order total --}}
            <div class="px-6 py-4 bg-neutral-50/50 border-t border-neutral-100">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-neutral-600">Order Total</span>
                    <span class="text-xl font-bold text-neutral-900">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Timeline / Activity --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-6">
            <h3 class="font-bold text-neutral-900 mb-4">Order Timeline</h3>
            <div class="relative pl-5">
                <div class="absolute left-1.5 top-1 bottom-1 w-px bg-neutral-100"></div>
                <div class="space-y-4">
                    <div class="relative flex gap-3">
                        <div class="absolute -left-5 w-3 h-3 rounded-full bg-green-500 ring-2 ring-white mt-0.5"></div>
                        <div>
                            <p class="text-sm font-semibold text-neutral-800">Order Placed</p>
                            <p class="text-xs text-neutral-400">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    @if(!in_array($order->status, ['pending']))
                    <div class="relative flex gap-3">
                        <div class="absolute -left-5 w-3 h-3 rounded-full bg-brand-500 ring-2 ring-white mt-0.5"></div>
                        <div>
                            <p class="text-sm font-semibold text-neutral-800">Status: {{ ucfirst($order->status) }}</p>
                            <p class="text-xs text-neutral-400">{{ $order->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: Customer info + Status --}}
    <div class="space-y-5">

        {{-- Status Update Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-6">
            <h3 class="font-bold text-neutral-900 mb-4">Order Status</h3>
            <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider {{ $order->status_color }}">
                    <span class="w-2 h-2 rounded-full mr-2
                        @if($order->status === 'pending') bg-amber-500
                        @elseif($order->status === 'confirmed') bg-brand-500
                        @elseif($order->status === 'active') bg-green-500
                        @elseif($order->status === 'completed') bg-neutral-400
                        @else bg-red-500
                        @endif"></span>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <div>
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5">Update Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all appearance-none cursor-pointer">
                        @foreach(['pending','confirmed','active','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 transition-all shadow-sm shadow-brand-200">
                    Update Status
                </button>
            </form>
        </div>

        {{-- Customer Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-neutral-900">Customer</h3>
                @if($order->customer)
                <a href="{{ route('admin.customers.show', $order->customer) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">
                    View Profile →
                </a>
                @endif
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                    {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-bold text-neutral-800">{{ $order->customer_name }}</p>
                    <p class="text-xs text-neutral-400">{{ $order->customer_email }}</p>
                </div>
            </div>
            <div class="space-y-2.5">
                <div class="flex items-center gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-neutral-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-neutral-600">{{ $order->customer_phone }}</span>
                </div>
                <div class="flex items-start gap-2.5 text-sm">
                    <svg class="w-4 h-4 text-neutral-300 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-neutral-600 leading-relaxed">{{ $order->customer_address }}</span>
                </div>
            </div>
        </div>

        {{-- Order Summary Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-6">
            <h3 class="font-bold text-neutral-900 mb-4">Summary</h3>
            <dl class="space-y-2.5 text-sm">
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Order ID</dt>
                    <dd class="font-mono font-bold text-neutral-800">#{{ $order->formatted_id }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Placed</dt>
                    <dd class="font-semibold text-neutral-700">{{ $order->created_at->format('M d, Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Items</dt>
                    <dd class="font-semibold text-neutral-700">{{ $order->items->count() }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Distance</dt>
                    <dd class="font-semibold text-neutral-700">{{ $order->distance_km ? number_format($order->distance_km, 1) . ' km' : 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500">Traveling Cost</dt>
                    <dd class="font-semibold {{ $order->traveling_cost > 0 ? 'text-brand-600' : 'text-green-600' }}">{{ $order->traveling_cost > 0 ? '$' . number_format($order->traveling_cost, 2) : 'Free' }}</dd>
                </div>
                <div class="border-t border-neutral-100 pt-2.5 flex justify-between">
                    <dt class="font-bold text-neutral-700">Total</dt>
                    <dd class="font-bold text-lg text-neutral-900">${{ number_format($order->total_amount, 2) }}</dd>
                </div>
            </dl>
        </div>

    </div>
</div>

</x-layout.admin-layout>
