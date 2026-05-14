<x-layout.admin-layout>
    <x-slot:title>{{ $customer->name }}</x-slot:title>
    <x-slot:pageTitle>Customer Profile</x-slot:pageTitle>

    @php
        $mapsKey          = config('services.google.maps_key');
        $loc              = $customer->map_location;
        $lat              = $loc['lat']               ?? null;
        $lng              = $loc['lng']               ?? null;
        $formattedAddress = $loc['formatted_address'] ?? null;
        $hasPin           = $lat && $lng;
    @endphp

<div x-data="{ deleteModalOpen: false }">

    {{-- ─── Top Bar ─── --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}"
               class="w-10 h-10 rounded-xl bg-white border border-neutral-100 shadow-sm flex items-center justify-center text-neutral-400 hover:text-brand-600 hover:border-brand-100 transition-all flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-display font-bold text-neutral-900 tracking-tight">{{ $customer->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <a href="{{ route('admin.customers.index') }}" class="text-sm text-neutral-400 font-medium hover:text-brand-600 transition-colors">Customers</a>
                    <svg class="w-3 h-3 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-sm text-brand-600 font-bold">Profile</span>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('admin.customers.edit', $customer) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-neutral-200 text-neutral-700 rounded-xl text-sm font-bold hover:bg-amber-50 hover:border-amber-200 hover:text-amber-700 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <button type="button" @click="deleteModalOpen = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-neutral-200 text-neutral-700 rounded-xl text-sm font-bold hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </button>
        </div>
    </div>

    {{-- ─── Main Grid ─── --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ── LEFT COLUMN ── --}}
        <div class="space-y-5">

            {{-- Profile Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-100">
                {{-- Gradient header – rounded-t-2xl so corners clip without overflow-hidden on the card --}}
                <div class="h-24 bg-gradient-to-r from-brand-500 via-brand-600 to-brand-700 rounded-t-2xl relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10"
                         style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px), radial-gradient(circle at 80% 20%, white 1px, transparent 1px); background-size: 30px 30px;">
                    </div>
                </div>
                {{-- Avatar floats freely because the card no longer has overflow-hidden --}}
                <div class="px-6 pb-6 relative">
                    <div class="-mt-8 mb-4 flex items-end justify-between">
                        <div class="w-16 h-16 rounded-2xl bg-white shadow-lg flex items-center justify-center ring-4 ring-white z-10 relative">
                            <span class="text-2xl font-bold text-brand-600">{{ $customer->initials }}</span>
                        </div>
                        <span class="mb-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                            {{ $orderCount > 0 ? 'bg-green-100 text-green-700' : 'bg-neutral-100 text-neutral-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $orderCount > 0 ? 'bg-green-500' : 'bg-neutral-400' }}"></span>
                            {{ $orderCount > 0 ? 'Active' : 'New' }}
                        </span>
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
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-neutral-900">Contact Details</h3>
                    <a href="{{ route('admin.customers.edit', $customer) }}"
                       class="text-xs text-brand-500 hover:text-brand-700 font-bold transition-colors">Edit →</a>
                </div>
                <div class="space-y-3.5">
                    {{-- Email --}}
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Email</p>
                            <a href="mailto:{{ $customer->email }}"
                               class="text-sm text-neutral-700 font-medium truncate block hover:text-brand-600 transition-colors">{{ $customer->email }}</a>
                        </div>
                    </div>

                    {{-- Phone --}}
                    @if($customer->phone)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Phone</p>
                            <a href="tel:{{ $customer->phone }}"
                               class="text-sm text-neutral-700 font-medium hover:text-brand-600 transition-colors">{{ $customer->phone }}</a>
                        </div>
                    </div>
                    @endif

                    {{-- Address --}}
                    @if($customer->address)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Address</p>
                            <p class="text-sm text-neutral-700 font-medium leading-relaxed">{{ $customer->address }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- No info fallback --}}
                    @if(!$customer->phone && !$customer->address)
                    <p class="text-xs text-neutral-400 italic">No additional contact info saved.
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="text-brand-500 font-semibold not-italic hover:text-brand-700">Add now →</a>
                    </p>
                    @endif
                </div>
            </div>

            {{-- ── Map Location Card ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-neutral-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-brand-100 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-neutral-900 text-sm">Pinned Location</h3>
                    </div>
                    @if($hasPin)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>GPS Set
                    </span>
                    @else
                    <a href="{{ route('admin.customers.edit', $customer) }}"
                       class="text-xs text-brand-500 hover:text-brand-700 font-bold transition-colors">Add pin →</a>
                    @endif
                </div>

                @if($hasPin && $mapsKey)
                {{-- Interactive map --}}
                <div id="showMapCanvas" class="w-full" style="height: 220px; background: #f0f0f0;"></div>

                @php
                    // Only show formattedAddress when it contains letters (real geocoded address),
                    // not a raw "lat, lng" coordinate string stored as a fallback.
                    $isRealAddress = $formattedAddress && preg_match('/[a-zA-Z]/', $formattedAddress);
                @endphp
                <div class="px-5 py-3.5 bg-neutral-50/50 space-y-2">
                    @if($isRealAddress)
                    <p class="text-xs font-semibold text-neutral-700 leading-relaxed">{{ $formattedAddress }}</p>
                    @endif
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <p class="text-[10px] text-neutral-400 font-mono">{{ number_format($lat, 5) }}, {{ number_format($lng, 5) }}</p>
                        <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 rounded-lg text-xs font-bold text-neutral-700 hover:bg-brand-50 hover:border-brand-200 hover:text-brand-700 shadow-sm transition-all">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Open in Maps
                        </a>
                    </div>
                </div>

                @elseif($hasPin && !$mapsKey)
                {{-- Has coords but no API key – show coords only --}}
                <div class="px-5 py-5 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        @if($formattedAddress)
                        <p class="text-sm font-semibold text-neutral-700 leading-relaxed">{{ $formattedAddress }}</p>
                        @endif
                        <p class="text-xs text-neutral-400 font-mono mt-0.5">{{ $lat }}, {{ $lng }}</p>
                        <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}" target="_blank" rel="noopener"
                           class="text-xs text-brand-500 hover:text-brand-700 font-bold transition-colors mt-1 inline-block">Open in Maps →</a>
                    </div>
                </div>

                @else
                {{-- No location set --}}
                <div class="px-5 py-8 flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-neutral-50 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-neutral-600">No location pinned</p>
                    <p class="text-xs text-neutral-400 mt-1 mb-3">Add a map pin to see the customer location here.</p>
                    <a href="{{ route('admin.customers.edit', $customer) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-50 text-brand-600 rounded-xl text-xs font-bold hover:bg-brand-100 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Location
                    </a>
                </div>
                @endif
            </div>

        </div>{{-- end left --}}

        {{-- ── RIGHT COLUMN: Order History ── --}}
        <div class="xl:col-span-2 space-y-5">

            {{-- Order History Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-neutral-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-neutral-900">Order History</h3>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $orderCount }} order{{ $orderCount !== 1 ? 's' : '' }} placed</p>
                    </div>
                    @if($orderCount > 0)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700">
                        ${{ number_format($totalSpent, 2) }} total
                    </span>
                    @endif
                </div>
                <div class="divide-y divide-neutral-50">
                    @forelse($customer->orders->sortByDesc('created_at') as $order)
                    <div class="px-6 py-4 hover:bg-neutral-50/50 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-neutral-50 border border-neutral-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4.5 h-4.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="font-mono text-sm font-bold text-brand-600 hover:text-brand-700 transition-colors">
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
                        <div class="mt-3 flex flex-wrap gap-2" style="padding-left: 3.25rem">
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
                    <div class="px-6 py-16 flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-neutral-50 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <p class="text-base font-bold text-neutral-700">No orders yet</p>
                        <p class="text-sm text-neutral-400 mt-1">This customer hasn't placed any orders.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>{{-- end right --}}

    </div>{{-- end grid --}}

    {{-- ─── Delete Confirmation Modal ─── --}}
    <div x-show="deleteModalOpen"
         x-cloak
         class="fixed inset-0 z-[70] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-neutral-900/60 backdrop-blur-md" @click="deleteModalOpen = false"></div>

        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-sm p-8 text-center"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Delete Customer?</h3>
            <p class="text-neutral-500 mb-1 px-2">You are about to delete <strong class="text-neutral-800">{{ $customer->name }}</strong>.</p>
            <p class="text-sm text-neutral-400 mb-8 px-2">Their orders will be kept but unlinked. This cannot be undone.</p>

            <div class="flex flex-col gap-3">
                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-6 py-4 bg-red-500 text-white rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-600 transition-all">
                        Yes, Delete Customer
                    </button>
                </form>
                <button @click="deleteModalOpen = false"
                        class="w-full px-6 py-4 bg-neutral-50 text-neutral-600 rounded-2xl font-bold hover:bg-neutral-100 transition-all">
                    No, Keep Customer
                </button>
            </div>
        </div>
    </div>

</div>{{-- end x-data --}}

{{-- ─── Interactive map script ─── --}}
@if($hasPin && $mapsKey)
<script>
function _showMapReady() {
    const map = new google.maps.Map(document.getElementById('showMapCanvas'), {
        center: { lat: {{ (float)$lat }}, lng: {{ (float)$lng }} },
        zoom: 16,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: false,
        zoomControl: true,
        zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
        gestureHandling: 'cooperative',
        styles: [
            { featureType: 'all',      elementType: 'geometry',      stylers: [{ saturation: -15 }] },
            { featureType: 'road',     elementType: 'geometry.fill', stylers: [{ color: '#f5efe6' }] },
            { featureType: 'water',    elementType: 'geometry',      stylers: [{ color: '#d4e6f1' }] },
            { featureType: 'poi.park', elementType: 'geometry.fill', stylers: [{ color: '#d5e8d4' }] },
            { featureType: 'poi',      elementType: 'labels',        stylers: [{ visibility: 'off' }] },
        ],
    });

    new google.maps.Marker({
        position: { lat: {{ (float)$lat }}, lng: {{ (float)$lng }} },
        map: map,
        animation: google.maps.Animation.DROP,
        icon: {
            path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
            fillColor: '#c8902a',
            fillOpacity: 1,
            strokeColor: '#ffffff',
            strokeWeight: 2,
            scale: 2.2,
            anchor: new google.maps.Point(12, 22),
        },
    });
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&callback=_showMapReady">
</script>
@endif

</x-layout.admin-layout>
