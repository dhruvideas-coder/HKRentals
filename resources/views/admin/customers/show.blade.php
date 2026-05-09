<x-layout.admin-layout>
    <x-slot:title>{{ $customer->name }}</x-slot>
    <x-slot:pageTitle>Customer Profile</x-slot>

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-neutral-400 mb-6">
    <a href="{{ route('admin.customers.index') }}" class="hover:text-brand-600 transition-colors font-medium">Customers</a>
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 font-semibold truncate max-w-[200px]">{{ $customer->name }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- LEFT: Profile + Contact --}}
    <div class="space-y-5">

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <div class="h-20 bg-gradient-to-r from-brand-500 via-brand-600 to-brand-700"></div>
            <div class="px-6 pb-6">
                <div class="-mt-8 mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-lg flex items-center justify-center ring-4 ring-white">
                        <span class="text-2xl font-bold text-brand-600">{{ $customer->initials }}</span>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-neutral-900 leading-tight">{{ $customer->name }}</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Customer since {{ $customer->created_at->format('M Y') }}</p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white rounded-2xl border border-neutral-100 p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-neutral-900">{{ $orderCount }}</p>
                <p class="text-xs text-neutral-500 mt-0.5">Total Orders</p>
            </div>
            <div class="bg-white rounded-2xl border border-neutral-100 p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-brand-600">${{ number_format($totalSpent, 0) }}</p>
                <p class="text-xs text-neutral-500 mt-0.5">Total Spent</p>
            </div>
        </div>

        {{-- Contact Details --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-6">
            <h3 class="font-bold text-neutral-900 mb-4">Contact Details</h3>
            <div class="space-y-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Email</p>
                        <p class="text-sm text-neutral-700 font-medium truncate">{{ $customer->email }}</p>
                    </div>
                </div>
                @if($customer->phone)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Phone</p>
                        <p class="text-sm text-neutral-700 font-medium">{{ $customer->phone }}</p>
                    </div>
                </div>
                @endif
                @if($customer->address)
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Address</p>
                        <p class="text-sm text-neutral-700 font-medium leading-relaxed">{{ $customer->address }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Map Location Card --}}
        @if($customer->map_location && config('services.google.maps_key'))
        @php
            $loc = $customer->map_location;
            $lat = $loc['lat'] ?? null;
            $lng = $loc['lng'] ?? null;
            $formattedAddress = $loc['formatted_address'] ?? null;
            $mapsKey = config('services.google.maps_key');
        @endphp
        @if($lat && $lng)
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-neutral-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-brand-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-neutral-900 text-sm">Pinned Location</h3>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>GPS Verified
                </span>
            </div>

            {{-- Static map embed --}}
            <div class="relative">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $lat }},{{ $lng }}&zoom=16&size=500x220&scale=2&maptype=roadmap&markers=color:0xc8902a%7Csize:mid%7C{{ $lat }},{{ $lng }}&style=feature:all|element:geometry|saturation:-15&style=feature:road|element:geometry.fill|color:0xf5efe6&style=feature:water|element:geometry|color:0xd4e6f1&key={{ $mapsKey }}"
                     alt="Customer location map"
                     class="w-full object-cover"
                     style="height: 180px;" />
                <div class="absolute bottom-2 right-2">
                    <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-lg text-xs font-bold text-neutral-700 hover:bg-white shadow-sm border border-neutral-200 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Open in Maps
                    </a>
                </div>
            </div>

            <div class="px-5 py-3 bg-neutral-50/50">
                @if($formattedAddress)
                <p class="text-xs font-semibold text-neutral-700 leading-relaxed">{{ $formattedAddress }}</p>
                @endif
                <p class="text-[10px] text-neutral-400 font-mono mt-1">{{ number_format($lat, 5) }}, {{ number_format($lng, 5) }}</p>
            </div>
        </div>
        @endif
        @endif

    </div>

    {{-- RIGHT: Order History --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-100">
                <h3 class="font-bold text-neutral-900">Order History</h3>
                <p class="text-xs text-neutral-400 mt-0.5">{{ $orderCount }} order{{ $orderCount !== 1 ? 's' : '' }} placed</p>
            </div>
            <div class="divide-y divide-neutral-50">
                @forelse($customer->orders->sortByDesc('created_at') as $order)
                <div class="px-6 py-4 hover:bg-neutral-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-neutral-50 border border-neutral-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-sm font-bold text-brand-600 hover:text-brand-700 transition-colors">
                                        #{{ $order->formatted_id }}
                                    </a>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $order->status_color }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-neutral-400 mt-0.5">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <span class="text-neutral-300 mx-1">·</span>
                                    {{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-neutral-900">${{ number_format($order->total_amount, 2) }}</p>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-xs text-brand-500 hover:text-brand-700 font-semibold transition-colors">View →</a>
                        </div>
                    </div>

                    {{-- Order items preview --}}
                    @if($order->items->count() > 0)
                    <div class="mt-3 pl-13 flex flex-wrap gap-2" style="padding-left: 3.25rem">
                        @foreach($order->items->take(3) as $item)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-neutral-50 border border-neutral-100 rounded-lg text-xs text-neutral-600">
                            @if($item->product?->image)
                            <img src="{{ asset($item->product->image) }}" class="w-4 h-4 rounded object-cover" alt="" />
                            @endif
                            {{ $item->product?->name ?? 'Item' }}
                            @if($item->quantity > 1)
                                <span class="text-neutral-400">×{{ $item->quantity }}</span>
                            @endif
                        </span>
                        @endforeach
                        @if($order->items->count() > 3)
                        <span class="inline-flex items-center px-2.5 py-1 bg-neutral-50 border border-neutral-100 rounded-lg text-xs text-neutral-400">
                            +{{ $order->items->count() - 3 }} more
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
                @empty
                <div class="px-6 py-12 text-center text-neutral-400 text-sm">
                    No orders placed yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

</x-layout.admin-layout>
