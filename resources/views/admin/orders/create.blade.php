<x-layout.admin-layout>
    <x-slot:title>Book Order</x-slot>
    <x-slot:pageTitle>Book Manual Order</x-slot>

@php $mapsKey = config('services.google.maps_key'); @endphp

<div class="flex items-center gap-2 text-sm text-neutral-400 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="hover:text-brand-600 transition-colors font-medium">Orders</a>
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 font-semibold">Book Order</span>
</div>

<form action="{{ route('admin.orders.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:items-start" x-data="orderForm()" @load="init()" @submit.prevent="submitForm()">
    @csrf

    <div class="lg:col-span-2 space-y-6">

        {{-- Customer Selection --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                <h3 class="font-bold text-neutral-900 text-lg">Select Customer</h3>
                <p class="text-xs text-neutral-500 mt-1">Choose an existing customer for this order</p>
            </div>

            <div class="px-6 md:px-10 py-6 md:py-8 space-y-6">
                <div class="space-y-6">
                    {{-- Customer Select --}}
                    <div>
                        <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Customer</label>
                        <select x-model="selectedCustomerId" @change="onCustomerChange()" name="customer_id" required
                                class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium appearance-none cursor-pointer shadow-sm"
                                style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23737373%22 stroke-width=%222%22><path d=%22M6 9l6 6 6-6%22/></svg>'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                            <option value="">-- Select a Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Customer Preview --}}
                    <div x-show="selectedCustomer" class="bg-brand-50 rounded-2xl border border-brand-200 p-5">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[11px] font-bold text-brand-700 uppercase tracking-wider">Customer Details</p>
                                    <p class="font-bold text-neutral-900 text-lg mt-1" x-text="selectedCustomer?.name || ''"></p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-green-500"></span>
                                    Selected
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-neutral-500 text-[11px]">Email</p>
                                    <p class="font-medium text-neutral-800 mt-0.5" x-text="selectedCustomer?.email || '--'"></p>
                                </div>
                                <div>
                                    <p class="text-neutral-500 text-[11px]">Phone</p>
                                    <p class="font-medium text-neutral-800 mt-0.5" x-text="selectedCustomer?.phone || '--'"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-neutral-500 text-[11px]">Address</p>
                                    <p class="font-medium text-neutral-800 mt-0.5 text-sm" x-text="selectedCustomer?.address || '--'"></p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Product Picker Section --}}
                    <div x-show="selectedCustomer" class="mt-8 pt-8 border-t border-neutral-100">
                        <h3 class="font-bold text-neutral-900 text-lg mb-4">Add Products</h3>

                        {{-- Category Filter --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            <button type="button" @click="categoryFilter = 'all'" :class="categoryFilter === 'all' ? 'bg-brand-600 text-white' : 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200'"
                                    class="px-4 py-2 rounded-full font-semibold text-sm transition-all">
                                All Products
                            </button>
                            <template x-for="cat in categories" :key="cat.id">
                                <button type="button" @click="categoryFilter = cat.id" :class="categoryFilter === cat.id ? 'bg-brand-600 text-white' : 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200'"
                                        class="px-4 py-2 rounded-full font-semibold text-sm transition-all"
                                        x-text="cat.name"></button>
                            </template>
                        </div>

                        {{-- Product Grid --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                            <template x-for="product in filteredProducts" :key="product.id">
                                <div class="bg-neutral-50 rounded-2xl border border-neutral-100 overflow-hidden hover:shadow-md hover:border-neutral-200 transition-all">
                                    <div class="aspect-square overflow-hidden bg-neutral-100">
                                        <img :src="`{{ asset('') }}${product.image}`" :alt="product.name" class="w-full h-full object-cover" x-show="product.image" />
                                        <div x-show="!product.image" class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <p class="font-semibold text-neutral-800 text-sm truncate" x-text="product.name"></p>
                                        <p class="text-xs text-neutral-500 mt-1" x-text="`$${product.price_per_day}/day`"></p>
                                        <p class="text-[10px] text-neutral-400 mt-0.5" x-text="`Stock: ${product.total_quantity}`"></p>
                                        <button type="button" @click="addProduct(product)"
                                                x-show="!isProductInOrder(product.id)"
                                                class="w-full mt-2 py-1.5 px-2 bg-brand-600 text-white rounded-lg text-xs font-bold hover:bg-brand-700 transition-all">
                                            + Add
                                        </button>
                                        <div x-show="isProductInOrder(product.id)"
                                             class="mt-2 flex items-center rounded-lg overflow-hidden border border-brand-300 bg-brand-50">
                                            <button type="button" @click="decrementProduct(product.id)"
                                                    class="px-2.5 py-1.5 text-brand-700 font-bold text-base hover:bg-brand-100 transition-all flex-shrink-0 leading-none">
                                                −
                                            </button>
                                            <input type="number"
                                                   :value="getProductQty(product.id)"
                                                   @change="setProductQty(product.id, $event.target.value)"
                                                   tabindex="-1"
                                                   class="w-full text-center text-xs font-bold text-brand-800 bg-transparent border-0 focus:ring-0 focus:outline-none py-1.5 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                                            <button type="button" @click="incrementProduct(product.id)"
                                                    :disabled="getProductQty(product.id) >= product.total_quantity"
                                                    :class="getProductQty(product.id) >= product.total_quantity ? 'opacity-30 cursor-not-allowed' : 'hover:bg-brand-100'"
                                                    class="px-2.5 py-1.5 text-brand-700 font-bold text-base transition-all flex-shrink-0 leading-none">
                                                +
                                            </button>
                                        </div>
                                        <p x-show="isProductInOrder(product.id) && getProductQty(product.id) >= product.total_quantity"
                                           class="text-[10px] text-red-500 mt-1 font-semibold">Max stock reached</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div x-show="orderItems.length > 0" class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                <h3 class="font-bold text-neutral-900 text-lg">Order Items</h3>
                <p class="text-xs text-neutral-500 mt-1" x-text="`${orderItems.length} item(s) in this order`"></p>
            </div>

            <div class="divide-y divide-neutral-50">
                <template x-for="(item, index) in orderItems" :key="index">
                    <div class="px-6 md:px-10 py-6 space-y-4">
                        {{-- Hidden product_id input --}}
                        <input type="hidden" :value="item.product.id" :name="`items[${index}][product_id]`" />

                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 rounded-xl overflow-hidden ring-1 ring-neutral-100 flex-shrink-0 bg-neutral-50">
                                <img :src="`{{ asset('') }}${item.product.image}`" :alt="item.product.name" class="w-full h-full object-cover" x-show="item.product.image" />
                                <div x-show="!item.product.image" class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-neutral-800 text-sm" x-text="item.product.name"></p>
                                <div class="mt-3 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <label class="text-[11px] font-bold text-neutral-500 uppercase w-24">Quantity</label>
                                        <input type="number" x-model.number="item.quantity" min="1" :max="item.product.total_quantity" @change="updateItemDates(index)"
                                               :name="`items[${index}][quantity]`"
                                               class="w-20 px-3 py-1.5 bg-neutral-50 border border-neutral-100 rounded-lg text-sm focus:ring-2 focus:ring-brand-500/20" />
                                        <span class="text-[10px] text-neutral-400" x-text="`/ ${item.product.total_quantity} in stock`"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <label class="text-[11px] font-bold text-neutral-500 uppercase w-24">From</label>
                                        <input type="date" x-model="item.startDate" @change="updateItemDates(index)"
                                               :name="`items[${index}][start_date]`"
                                               class="flex-1 px-3 py-1.5 bg-neutral-50 border border-neutral-100 rounded-lg text-sm focus:ring-2 focus:ring-brand-500/20" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <label class="text-[11px] font-bold text-neutral-500 uppercase w-24">To</label>
                                        <input type="date" x-model="item.endDate" @change="updateItemDates(index)"
                                               :name="`items[${index}][end_date]`"
                                               class="flex-1 px-3 py-1.5 bg-neutral-50 border border-neutral-100 rounded-lg text-sm focus:ring-2 focus:ring-brand-500/20" />
                                    </div>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-bold text-neutral-900 text-lg" x-text="`$${item.lineTotal.toFixed(2)}`"></p>
                                <p class="text-[10px] text-neutral-400 mt-1" x-text="`${item.rentalDays}d × $${(item.product.price_per_day * item.quantity).toFixed(2)}`"></p>
                                <button type="button" @click="removeItem(index)"
                                        class="mt-2 p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                <h3 class="font-bold text-neutral-900 text-lg">Order Details</h3>
            </div>

            <div class="px-6 md:px-10 py-6 md:py-8 space-y-6">

                {{-- Event Date --}}
                <div>
                    <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Event Date</label>
                    <input type="date" x-model="eventDate" name="event_date" required
                           class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold" />
                    @error('event_date')
                        <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Event / Delivery Location (Map Picker) --}}
                @if($mapsKey)
                <div>
                    <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Event / Delivery Location</label>

                    {{-- Not pinned — CTA button --}}
                    <div x-show="!locationPinned">
                        <button type="button" @click="openMapModal()"
                                class="w-full flex items-center gap-4 px-5 py-4 bg-neutral-50 border-2 border-dashed border-neutral-200 rounded-2xl hover:border-brand-300 hover:bg-brand-50/40 transition-all group">
                            <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center flex-shrink-0 group-hover:bg-brand-200 transition-all">
                                <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="text-left flex-1">
                                <p class="font-bold text-neutral-800 text-sm group-hover:text-brand-700 transition-colors">Pin Delivery Location on Map</p>
                                <p class="text-[11px] text-neutral-400 mt-0.5">Calculates exact traveling charges automatically</p>
                            </div>
                            <svg class="w-4 h-4 text-neutral-300 group-hover:text-brand-400 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                        <p x-show="selectedCustomer && !selectedCustomer.map_location" class="text-[11px] text-amber-600 mt-2 ml-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Customer has no saved location — pin the delivery spot above for accurate charges.
                        </p>
                    </div>

                    {{-- Pinned — confirmed location card --}}
                    <div x-show="locationPinned && eventLocation" class="rounded-2xl overflow-hidden border border-green-200 shadow-sm">
                        {{-- Green header bar --}}
                        <div class="flex items-center justify-between px-4 py-2.5 bg-green-500">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-xs font-bold text-white uppercase tracking-wider">Location Confirmed</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button type="button" @click="openMapModal()"
                                        class="inline-flex items-center gap-1 text-[11px] font-bold text-white/80 hover:text-white bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-full transition-all">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Change
                                </button>
                                <button type="button" @click="clearEventLocation()"
                                        class="text-[11px] font-bold text-white/70 hover:text-white bg-white/10 hover:bg-red-400/30 px-2.5 py-1 rounded-full transition-all">
                                    Clear
                                </button>
                            </div>
                        </div>

                        {{-- Address + stats --}}
                        <div class="bg-green-50 px-4 py-4 space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4.5 h-4.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-green-900 leading-snug" x-text="eventLocation?.formatted_address || '—'"></p>
                                    <p class="text-[11px] text-green-600 font-mono mt-0.5"
                                       x-text="eventLocation ? `${eventLocation.lat.toFixed(5)}, ${eventLocation.lng.toFixed(5)}` : ''"></p>
                                </div>
                            </div>

                            {{-- Distance + cost chips --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white rounded-xl p-3 border border-green-100">
                                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Distance</p>
                                    <p class="font-bold text-neutral-900 text-xl leading-none" x-text="distanceKm > 0 ? `${distanceKm.toFixed(1)} km` : '—'"></p>
                                    <p class="text-[10px] text-neutral-400 mt-1">from godown</p>
                                </div>
                                <div class="bg-white rounded-xl p-3 border border-green-100">
                                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1">Travel Cost</p>
                                    <p class="font-bold text-xl leading-none"
                                       :class="travelingCost > 0 ? 'text-brand-600' : 'text-green-600'"
                                       x-text="`$${travelingCost.toFixed(2)}`"></p>
                                    <p x-show="travelingCost === 0 && distanceKm > 0" class="text-[10px] text-green-600 mt-1 font-semibold">Free delivery zone</p>
                                    <p x-show="travelingCost > 0" class="text-[10px] text-neutral-400 mt-1"
                                       x-text="`${distanceKm.toFixed(1)} km × ${{ $settings?->charge_per_km ?: 1 }}/km`"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Traveling Cost (manual override) --}}
                <div>
                    <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">
                        Traveling Cost
                        @if($mapsKey)
                        <span class="ml-1 text-neutral-400 font-normal normal-case tracking-normal">(auto-calculated · override if needed)</span>
                        @else
                        <span class="ml-1 text-neutral-400 font-normal normal-case tracking-normal">(override)</span>
                        @endif
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <span class="text-neutral-500 font-bold text-lg">$</span>
                        </div>
                        <input type="number" x-model.number="travelingCost" name="traveling_cost" step="0.01" min="0"
                               class="block w-full pl-10 pr-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold text-lg" />
                    </div>
                    <input type="hidden" name="distance_km" :value="distanceKm" />
                    <p class="text-[11px] text-neutral-400 mt-1 ml-1">
                        @if($mapsKey)
                        Pin a location above for auto-calculation, or type a custom amount here.
                        @else
                        Auto-calculated from customer location if available; enter a custom amount to override.
                        @endif
                    </p>
                    @error('traveling_cost')
                        <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Payment --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
            <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                <h3 class="font-bold text-neutral-900 text-lg">Payment</h3>
            </div>

            <div class="px-6 md:px-10 py-6 md:py-8 space-y-6" x-data="{ showPaymentMethod: false }">
                <div>
                    <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Payment Status</label>
                    <select x-model="paymentStatus" @change="showPaymentMethod = paymentStatus === 'paid'" name="payment_status" required
                            class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium appearance-none cursor-pointer"
                            style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23737373%22 stroke-width=%222%22><path d=%22M6 9l6 6 6-6%22/></svg>'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="waived">Waived</option>
                    </select>
                    @error('payment_status')
                        <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="paymentStatus === 'paid'" class="space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Payment Method</label>
                        <select x-model="paymentMethod" name="payment_method"
                                class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium appearance-none cursor-pointer"
                                style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2224%22 height=%2224%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23737373%22 stroke-width=%222%22><path d=%22M6 9l6 6 6-6%22/></svg>'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                            <option value="">-- Select Method --</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Payment Amount</label>
                        <input type="number" x-model.number="paymentAmount" name="payment_amount" step="0.01" min="0"
                               :placeholder="`$${grandTotal.toFixed(2)}`"
                               class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold" />
                        <p class="text-[11px] text-neutral-400 mt-1 ml-1">Defaults to total amount if left blank</p>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Reference / Transaction ID</label>
                        <input type="text" name="payment_reference" placeholder="e.g., TXN-12345 or check #"
                               class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold placeholder-neutral-300" />
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Sidebar: Summary + Actions --}}
    <div class="lg:col-span-1 lg:self-start">
        <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-[2.5rem] p-6 md:p-8 sticky top-6 space-y-6">

            {{-- Summary Card --}}
            <div class="bg-white/10 backdrop-blur rounded-2xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-neutral-300 text-sm">Items</span>
                    <span class="font-bold text-white" x-text="`${orderItems.length}`"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-neutral-300 text-sm">Subtotal</span>
                    <span class="font-bold text-white" x-text="`$${subtotal.toFixed(2)}`"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-neutral-300 text-sm">Delivery</span>
                    <span class="font-bold text-white" x-text="`$${travelingCost.toFixed(2)}`"></span>
                </div>
                <div class="border-t border-white/20 pt-3 flex items-center justify-between">
                    <span class="text-white font-semibold">Total</span>
                    <span class="text-2xl font-bold text-brand-400" x-text="`$${grandTotal.toFixed(2)}`"></span>
                </div>
            </div>

            {{-- Status Badge --}}
            <div x-show="!selectedCustomer" class="bg-amber-500/20 rounded-xl p-3 border border-amber-500/30">
                <p class="text-xs text-amber-100">Select a customer to begin booking</p>
            </div>

            <div x-show="selectedCustomer && orderItems.length === 0" class="bg-amber-500/20 rounded-xl p-3 border border-amber-500/30">
                <p class="text-xs text-amber-100">Add at least 1 product to proceed</p>
            </div>

            {{-- Submit Button --}}
            <button type="submit" :disabled="!selectedCustomer || orderItems.length === 0"
                    class="w-full px-6 py-4 bg-brand-600 text-white rounded-2xl font-bold hover:bg-brand-700 disabled:bg-neutral-600 disabled:cursor-not-allowed shadow-lg shadow-brand-500/20 hover:shadow-xl hover:-translate-y-0.5 transition-all tracking-wide">
                Book Order
            </button>

            {{-- Cancel Link --}}
            <a href="{{ route('admin.orders.index') }}"
               class="block text-center px-6 py-3 bg-white/10 text-white rounded-2xl font-semibold hover:bg-white/20 transition-all">
                Cancel
            </a>

        </div>
    </div>

    {{-- ══════════════════════════════════════
         Map Modal — teleported to <body> so
         layout overflow:hidden doesn't clip it
         ══════════════════════════════════════ --}}
    @if($mapsKey)
    <template x-teleport="body">
    <div x-show="mapModalOpen"
         x-cloak
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-neutral-900/70 backdrop-blur-sm" @click="closeMapModal()"></div>

        {{-- Modal panel --}}
        <div class="relative w-full max-w-2xl flex flex-col bg-white rounded-3xl shadow-2xl overflow-hidden"
             style="max-height:90dvh;max-height:90vh;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform translate-y-8 opacity-0 scale-95"
             x-transition:enter-end="transform translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform translate-y-0 opacity-100 scale-100"
             x-transition:leave-end="transform translate-y-8 opacity-0 scale-95"
             @click.stop>

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-neutral-100 flex items-center gap-3 flex-shrink-0 bg-gradient-to-r from-amber-50/60 to-white">
                <div class="w-10 h-10 rounded-xl bg-brand-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-neutral-900 text-base leading-tight">Pin Event / Delivery Location</h3>
                    <p class="text-xs text-neutral-400 mt-0.5">Search or click the map — traveling cost auto-updates</p>
                </div>
                <button type="button" @click="closeMapModal()"
                        class="w-8 h-8 rounded-full bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center text-neutral-500 transition-all flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Search row --}}
            <div class="px-4 py-3 border-b border-neutral-100 bg-white flex-shrink-0 flex items-center gap-2">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="orderMapSearch" type="text" placeholder="Search address or place…"
                           class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 rounded-xl text-sm border border-neutral-200 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all"
                           autocomplete="off" />
                </div>
                <button type="button" @click="useMyLocation()" :disabled="locatingMe" title="Use my current location"
                        class="flex-shrink-0 w-10 h-10 rounded-xl bg-neutral-50 border border-neutral-200 flex items-center justify-center text-brand-600 hover:bg-brand-50 hover:border-brand-300 transition-all disabled:opacity-50">
                    <svg x-show="!locatingMe" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0013 3.06V1h-2v2.06A8.994 8.994 0 003.06 11H1v2h2.06A8.994 8.994 0 0011 20.94V23h2v-2.06A8.994 8.994 0 0020.94 13H23v-2h-2.06z"/>
                    </svg>
                    <svg x-show="locatingMe" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                </button>
            </div>

            {{-- Map canvas --}}
            <div id="orderMapCanvas" class="flex-1 w-full" style="min-height:300px;height:360px;"></div>

            {{-- Tip strip --}}
            <div class="px-4 py-2 bg-amber-50 border-t border-amber-100 flex items-center gap-2 flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-amber-700">Brown dot = your godown. Click anywhere on map or drag the gold pin to set the delivery point.</p>
            </div>

            {{-- Footer: address preview + live cost + confirm --}}
            <div class="px-5 py-4 bg-white border-t border-neutral-100 flex-shrink-0">

                {{-- Selected address + live cost estimate --}}
                <div x-show="selectedLocation" class="mb-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2 flex items-start gap-3 p-3 bg-neutral-50 rounded-xl border border-neutral-100">
                        <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-neutral-800 leading-snug" x-text="selectedLocation?.formatted_address || 'Fetching address…'"></p>
                            <p class="text-[11px] text-neutral-400 mt-0.5 font-mono"
                               x-text="selectedLocation ? selectedLocation.lat.toFixed(5)+', '+selectedLocation.lng.toFixed(5) : ''"></p>
                        </div>
                    </div>
                    <div class="bg-brand-50 rounded-xl border border-brand-100 p-3 flex flex-col justify-center">
                        <p class="text-[10px] font-bold text-brand-500 uppercase tracking-wider">Est. Travel Cost</p>
                        <p class="font-bold text-brand-700 text-xl mt-0.5"
                           x-text="selectedLocation && mapCfg.godownLat ? '$' + (Math.max(0, haversine(mapCfg.godownLat,mapCfg.godownLng,selectedLocation.lat,selectedLocation.lng) - mapCfg.freeDist) * mapCfg.chargeKm).toFixed(2) : '—'"></p>
                        <p class="text-[10px] text-brand-400 mt-0.5"
                           x-text="selectedLocation && mapCfg.godownLat ? haversine(mapCfg.godownLat,mapCfg.godownLng,selectedLocation.lat,selectedLocation.lng).toFixed(1)+' km from godown' : ''"></p>
                    </div>
                </div>

                <div x-show="!selectedLocation" class="mb-3 flex items-center gap-2 p-3 bg-neutral-50 rounded-xl border border-dashed border-neutral-200">
                    <svg class="w-4 h-4 text-neutral-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <p class="text-sm text-neutral-400">No location selected — click the map or search above</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" @click="closeMapModal()"
                            class="px-5 py-2.5 rounded-xl border border-neutral-200 text-neutral-600 font-semibold text-sm hover:bg-neutral-50 transition-all flex-shrink-0">
                        Cancel
                    </button>
                    <button type="button" @click="confirmLocation()" :disabled="!selectedLocation"
                            class="flex-1 py-2.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all
                                   bg-brand-600 text-white shadow-sm hover:bg-brand-700
                                   disabled:bg-neutral-200 disabled:text-neutral-400 disabled:shadow-none disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Confirm Delivery Location
                    </button>
                </div>
            </div>
        </div>
    </div>
    </template>
    @endif

</form>

<script>
    function orderForm() {
        return {
            selectedCustomerId: '',
            selectedCustomer: null,
            customers: @json($customers),
            settings: @json($settings),
            categoryFilter: 'all',
            categories: @json($categoriesForJS),
            allProducts: @json($allProducts),
            orderItems: [],
            eventDate: new Date().toISOString().split('T')[0],
            travelingCost: 0,
            distanceKm: 0,
            paymentStatus: 'pending',
            paymentMethod: '',
            paymentAmount: 0,
            paymentReference: '',

            /* ── Map state ── */
            mapModalOpen: false,
            selectedLocation: null,
            mapInitialized: false,
            locatingMe: false,
            eventLocation: null,
            locationPinned: false,
            mapCfg: {
                godownLat: {{ $settings?->godown_lat ?: 'null' }},
                godownLng: {{ $settings?->godown_lng ?: 'null' }},
                freeDist:  {{ $settings?->free_delivery_distance ?: 5 }},
                chargeKm:  {{ $settings?->charge_per_km ?: 1 }},
            },

            init() {},

            get filteredProducts() {
                if (this.categoryFilter === 'all') {
                    return this.allProducts;
                }
                return this.allProducts.filter(p => p.category_id == this.categoryFilter);
            },

            get subtotal() {
                return this.orderItems.reduce((sum, item) => sum + item.lineTotal, 0);
            },

            get grandTotal() {
                return this.subtotal + this.travelingCost;
            },

            onCustomerChange() {
                if (!this.selectedCustomerId) {
                    this.selectedCustomer = null;
                    if (!this.locationPinned) { this.travelingCost = 0; this.distanceKm = 0; }
                    return;
                }

                this.selectedCustomer = this.customers.find(c => c.id == this.selectedCustomerId);

                // If admin already pinned a delivery location, keep it — don't override
                if (this.locationPinned) return;

                this.distanceKm = 0;
                this.travelingCost = 0;

                if (this.selectedCustomer && this.selectedCustomer.map_location &&
                    this.settings && this.settings.godown_lat && this.settings.godown_lng) {

                    const lat1 = parseFloat(this.settings.godown_lat);
                    const lon1 = parseFloat(this.settings.godown_lng);
                    const lat2 = parseFloat(this.selectedCustomer.map_location.lat);
                    const lon2 = parseFloat(this.selectedCustomer.map_location.lng);

                    this.distanceKm = this.haversine(lat1, lon1, lat2, lon2);

                    const freeDistance = parseFloat(this.settings.free_delivery_distance || 5);
                    const chargePerKm  = parseFloat(this.settings.charge_per_km || 1);

                    if (this.distanceKm > freeDistance) {
                        this.travelingCost = Math.round((this.distanceKm - freeDistance) * chargePerKm * 100) / 100;
                    }
                }
            },

            /* ── Map methods ── */
            openMapModal() {
                this.mapModalOpen = true;
                this.$nextTick(() => {
                    if (this.mapInitialized && window._orderMap) {
                        google.maps.event.trigger(window._orderMap, 'resize');
                        if (window._orderMarker) window._orderMap.panTo(window._orderMarker.getPosition());
                    } else {
                        this.initOrderMap();
                    }
                });
            },

            closeMapModal() { this.mapModalOpen = false; },

            async initOrderMap() {
                if (this.mapInitialized) return;
                if (!window.google?.maps) {
                    await new Promise(resolve => {
                        if (window._orderGmapsReady) return resolve();
                        window._orderGmapsQueue = window._orderGmapsQueue || [];
                        window._orderGmapsQueue.push(resolve);
                    });
                }
                const defaultPos = this.eventLocation
                    ? { lat: this.eventLocation.lat, lng: this.eventLocation.lng }
                    : (this.mapCfg.godownLat ? { lat: this.mapCfg.godownLat, lng: this.mapCfg.godownLng } : { lat: 35.9606, lng: -83.9207 });

                const mapEl = document.getElementById('orderMapCanvas');
                const map = new google.maps.Map(mapEl, {
                    center: defaultPos,
                    zoom: this.eventLocation ? 16 : 12,
                    mapTypeControl: false,
                    fullscreenControl: false,
                    streetViewControl: false,
                    zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
                    styles: [
                        { featureType: 'all',      elementType: 'geometry',      stylers: [{ saturation: -15 }] },
                        { featureType: 'road',     elementType: 'geometry.fill', stylers: [{ color: '#f5efe6' }] },
                        { featureType: 'water',    elementType: 'geometry',      stylers: [{ color: '#d4e6f1' }] },
                        { featureType: 'poi.park', elementType: 'geometry.fill', stylers: [{ color: '#d5e8d4' }] },
                        { featureType: 'poi',      elementType: 'labels',        stylers: [{ visibility: 'off' }] },
                    ],
                });

                const markerIcon = {
                    path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                    fillColor: '#c8902a', fillOpacity: 1,
                    strokeColor: '#ffffff', strokeWeight: 2, scale: 2.2,
                    anchor: new google.maps.Point(12, 22),
                };

                const marker = new google.maps.Marker({
                    position: defaultPos, map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    icon: markerIcon,
                });

                // Godown marker (reference point)
                if (this.mapCfg.godownLat && this.mapCfg.godownLng) {
                    new google.maps.Marker({
                        position: { lat: this.mapCfg.godownLat, lng: this.mapCfg.godownLng },
                        map,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 8,
                            fillColor: '#5b4132', fillOpacity: 1,
                            strokeColor: '#ffffff', strokeWeight: 2,
                        },
                        title: 'Our Godown',
                    });
                }

                window._orderMap    = map;
                window._orderMarker = marker;

                marker.addListener('dragend', () => {
                    const p = marker.getPosition();
                    this.geocodeOrderLatLng(p.lat(), p.lng());
                });
                map.addListener('click', e => {
                    marker.setPosition(e.latLng);
                    this.geocodeOrderLatLng(e.latLng.lat(), e.latLng.lng());
                });

                const searchInput = document.getElementById('orderMapSearch');
                if (searchInput) {
                    const ac = new google.maps.places.Autocomplete(searchInput, { types: ['geocode'] });
                    ac.bindTo('bounds', map);
                    ac.addListener('place_changed', () => {
                        const pl = ac.getPlace();
                        if (!pl.geometry?.location) return;
                        map.panTo(pl.geometry.location);
                        map.setZoom(17);
                        marker.setPosition(pl.geometry.location);
                        this.selectedLocation = {
                            lat: pl.geometry.location.lat(),
                            lng: pl.geometry.location.lng(),
                            formatted_address: pl.formatted_address,
                        };
                    });
                }

                if (this.eventLocation) {
                    this.selectedLocation = this.eventLocation;
                }

                this.mapInitialized = true;
            },

            geocodeOrderLatLng(lat, lng) {
                new google.maps.Geocoder().geocode({ location: { lat, lng } }, (r, s) => {
                    this.selectedLocation = (s === 'OK' && r[0])
                        ? { lat, lng, formatted_address: r[0].formatted_address }
                        : { lat, lng, formatted_address: `${lat.toFixed(5)}, ${lng.toFixed(5)}` };
                });
            },

            confirmLocation() {
                if (!this.selectedLocation) return;
                this.eventLocation  = this.selectedLocation;
                this.locationPinned = true;
                this.closeMapModal();
                this.recalcFromMap();
            },

            recalcFromMap() {
                if (!this.eventLocation || !this.mapCfg.godownLat || !this.mapCfg.godownLng) return;
                this.distanceKm   = this.haversine(this.mapCfg.godownLat, this.mapCfg.godownLng, this.eventLocation.lat, this.eventLocation.lng);
                const extra       = Math.max(0, this.distanceKm - this.mapCfg.freeDist);
                this.travelingCost = Math.round(extra * this.mapCfg.chargeKm * 100) / 100;
            },

            clearEventLocation() {
                this.eventLocation  = null;
                this.locationPinned = false;
                this.selectedLocation = null;
                // Re-run customer-based calculation
                const saved = this.locationPinned; // false now
                this.onCustomerChange();
            },

            useMyLocation() {
                if (!navigator.geolocation) return;
                this.locatingMe = true;
                navigator.geolocation.getCurrentPosition(pos => {
                    this.locatingMe = false;
                    const { latitude: lat, longitude: lng } = pos.coords;
                    if (window._orderMap && window._orderMarker) {
                        const ll = new google.maps.LatLng(lat, lng);
                        window._orderMap.panTo(ll);
                        window._orderMap.setZoom(17);
                        window._orderMarker.setPosition(ll);
                    }
                    this.geocodeOrderLatLng(lat, lng);
                }, () => { this.locatingMe = false; });
            },

            addProduct(product) {
                if (this.isProductInOrder(product.id)) return;

                this.orderItems.push({
                    product: product,
                    quantity: 1,
                    startDate: this.eventDate,
                    endDate: this.eventDate,
                    rentalDays: 1,
                    lineTotal: product.price_per_day
                });
            },

            removeItem(index) {
                this.orderItems.splice(index, 1);
            },

            removeItemByProductId(productId) {
                const index = this.orderItems.findIndex(item => item.product.id === productId);
                if (index > -1) {
                    this.removeItem(index);
                }
            },

            isProductInOrder(productId) {
                return this.orderItems.some(item => item.product.id === productId);
            },

            getProductQty(productId) {
                const item = this.orderItems.find(item => item.product.id === productId);
                return item ? item.quantity : 0;
            },

            incrementProduct(productId) {
                const item = this.orderItems.find(item => item.product.id === productId);
                if (item) {
                    if (item.quantity >= item.product.total_quantity) {
                        alert(`Only ${item.product.total_quantity} in stock for "${item.product.name}"`);
                        return;
                    }
                    item.quantity++;
                    this.updateItemDates(this.orderItems.indexOf(item));
                }
            },

            decrementProduct(productId) {
                const index = this.orderItems.findIndex(item => item.product.id === productId);
                if (index > -1) {
                    if (this.orderItems[index].quantity > 1) {
                        this.orderItems[index].quantity--;
                        this.updateItemDates(index);
                    } else {
                        this.removeItem(index);
                    }
                }
            },

            setProductQty(productId, value) {
                const qty = parseInt(value);
                if (isNaN(qty) || qty <= 0) {
                    this.removeItemByProductId(productId);
                    return;
                }
                const item = this.orderItems.find(item => item.product.id === productId);
                if (item) {
                    if (qty > item.product.total_quantity) {
                        alert(`Only ${item.product.total_quantity} in stock for "${item.product.name}"`);
                        item.quantity = item.product.total_quantity;
                    } else {
                        item.quantity = qty;
                    }
                    this.updateItemDates(this.orderItems.indexOf(item));
                }
            },

            updateItemDates(index) {
                const item = this.orderItems[index];
                const startDate = new Date(item.startDate);
                const endDate = new Date(item.endDate);
                const rentalDays = Math.max(1, Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1);
                item.rentalDays = rentalDays;
                item.lineTotal = item.quantity * item.product.price_per_day * rentalDays;
            },

            submitForm() {
                if (!this.selectedCustomerId) {
                    alert('Please select a customer');
                    return;
                }
                if (!this.eventDate) {
                    alert('Please select an event date');
                    return;
                }
                if (this.orderItems.length === 0) {
                    alert('Please add at least one product to the order');
                    return;
                }
                for (let i = 0; i < this.orderItems.length; i++) {
                    const item = this.orderItems[i];
                    if (!item.startDate || !item.endDate) {
                        alert(`Item ${i + 1}: Please set rental dates`);
                        return;
                    }
                    if (item.quantity < 1) {
                        alert(`Item ${i + 1}: Quantity must be at least 1`);
                        return;
                    }
                    if (item.quantity > item.product.total_quantity) {
                        alert(`"${item.product.name}": quantity ${item.quantity} exceeds available stock of ${item.product.total_quantity}`);
                        return;
                    }
                }
                if (this.paymentStatus === 'paid' && !this.paymentMethod) {
                    alert('Please select a payment method for paid orders');
                    return;
                }

                // Get the form element (use this.$el to avoid selecting the logout form in the nav)
                const form = this.$el;
                if (!form) {
                    console.error('Form element not found');
                    alert('Error: Could not find form. Please refresh the page.');
                    return;
                }

                // Disable button to prevent double submission
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Booking...';
                }

                // Log form action and data
                console.log('Form action:', form.action);
                console.log('Form method:', form.method);
                console.log('Order items to submit:', this.orderItems.length);

                // Add a small delay to ensure all inputs are updated, then submit
                setTimeout(() => {
                    try {
                        form.submit();
                    } catch (error) {
                        console.error('Form submission error:', error);
                        alert('Error submitting form: ' + error.message);
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = 'Book Order';
                        }
                    }
                }, 100);
            },

            haversine(lat1, lon1, lat2, lon2) {
                const R = 6371; // Earth radius in km
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                          Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                          Math.sin(dLon/2) * Math.sin(dLon/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                return R * c;
            }
        };
    }
</script>

@if($mapsKey)
<x-slot:scripts>
<style>
.pac-container {
    z-index: 9999 !important;
    border-radius: 0.75rem;
    border: 1px solid #e5e1dc;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    font-family: 'Plus Jakarta Sans', sans-serif;
    overflow: hidden;
    margin-top: 4px;
}
.pac-item { padding: 8px 14px; font-size: 0.8125rem; cursor: pointer; border-top: 1px solid #f3f4f6; }
.pac-item:hover, .pac-item-selected { background: #fdf8f0; }
.pac-item-query { font-weight: 600; color: #1a1a1a; }
.pac-icon { display: none; }
</style>
<script>
function _orderGmapsCallback() {
    window._orderGmapsReady = true;
    (window._orderGmapsQueue || []).forEach(fn => fn());
    window._orderGmapsQueue = [];
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&libraries=places,geometry&callback=_orderGmapsCallback">
</script>
</x-slot:scripts>
@endif

</x-layout.admin-layout>
