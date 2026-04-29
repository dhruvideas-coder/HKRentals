<x-layout.app-layout>
    <x-slot:title>Your Cart</x-slot:title>

    <x-layout.section class="pt-32 pb-24">
        <x-layout.container class="max-w-4xl">
            
            <div class="mb-10">
                <h1 class="font-display text-4xl md:text-5xl font-bold text-neutral-900 mb-4">Shopping Cart</h1>
                <p class="text-lg text-neutral-500">Review your items before proceeding to checkout.</p>
            </div>

            <div x-data="{
                get items() { return Alpine.store('cart').items; },
                get total() { return Alpine.store('cart').subtotal(); },
                get count() { return Alpine.store('cart').count(); }
            }" x-cloak>
                
                {{-- Empty State --}}
                <div x-show="items.length === 0" class="text-center py-20 bg-white rounded-3xl shadow-sm border border-neutral-100">
                    <div class="w-24 h-24 rounded-full bg-brand-50 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-display font-bold text-neutral-900 mb-2">Your cart is empty</h2>
                    <p class="text-neutral-500 mb-8">Looks like you haven't added any items to your event yet.</p>
                    <a href="{{ route('products') }}" class="btn btn-primary">Browse Collection</a>
                </div>

                {{-- Cart Items --}}
                <div x-show="items.length > 0" class="bg-white rounded-3xl shadow-sm border border-neutral-100 p-6 md:p-10 mb-8">
                    <div class="hidden md:grid grid-cols-12 gap-6 pb-4 border-b border-neutral-100 text-sm font-semibold text-neutral-400 uppercase tracking-wider">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    <div class="divide-y divide-neutral-100">
                        <template x-for="(item, index) in items" :key="item.product_id || item.id">
                            <div class="py-6 flex flex-col md:grid md:grid-cols-12 md:items-center gap-6 relative">
                                
                                {{-- Mobile remove --}}
                                <button @click="Alpine.store('cart').remove(item.product_id || item.id)" class="md:hidden absolute top-6 right-0 text-neutral-400 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                {{-- Product Info --}}
                                <div class="col-span-6 flex items-center gap-4">
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-neutral-100 flex-shrink-0">
                                        <img :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-neutral-900 text-lg" x-text="item.name"></h3>
                                        <p class="text-sm text-neutral-500 mt-1" x-text="item.category"></p>
                                        <p class="text-xs text-neutral-400 mt-1" x-text="item.dateRange"></p>
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="col-span-2 text-left md:text-center">
                                    <span class="md:hidden text-sm text-neutral-500 mr-2">Price:</span>
                                    <span class="font-medium text-neutral-700" x-text="'$' + Number(item.price).toFixed(2)"></span>
                                </div>

                                {{-- Quantity --}}
                                <div class="col-span-2 flex items-center justify-start md:justify-center">
                                    <div class="flex items-center gap-2 bg-neutral-50 rounded-lg p-1 border border-neutral-200">
                                        <button @click="Alpine.store('cart').dec(item.product_id || item.id)" class="w-8 h-8 rounded-md bg-white shadow-sm flex items-center justify-center text-neutral-600 hover:text-brand-500 transition-colors" aria-label="Decrease quantity">−</button>
                                        <span class="w-8 text-center font-semibold text-neutral-800" x-text="item.quantity || item.qty"></span>
                                        <button @click="Alpine.store('cart').inc(item.product_id || item.id)" class="w-8 h-8 rounded-md bg-white shadow-sm flex items-center justify-center text-neutral-600 hover:text-brand-500 transition-colors" aria-label="Increase quantity">+</button>
                                    </div>
                                </div>

                                {{-- Total & Remove --}}
                                <div class="col-span-2 flex items-center justify-between md:justify-end gap-4">
                                    <div class="font-bold text-brand-600 text-lg" x-text="'$' + (item.price * (item.quantity || item.qty)).toFixed(2)"></div>
                                    <button @click="Alpine.store('cart').remove(item.product_id || item.id)" class="hidden md:flex text-neutral-400 hover:text-red-500 transition-colors" aria-label="Remove item">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Summary --}}
                <div x-show="items.length > 0" class="flex flex-col items-end">
                    <div class="w-full md:w-96 bg-white rounded-3xl shadow-sm border border-neutral-100 p-8">
                        <div class="flex items-center justify-between mb-4 text-neutral-600">
                            <span>Subtotal</span>
                            <span class="font-medium" x-text="'$' + total"></span>
                        </div>
                        <div class="flex items-center justify-between mb-6 text-neutral-600">
                            <span>Taxes & Fees</span>
                            <span class="text-sm">Calculated at checkout</span>
                        </div>
                        <div class="border-t border-neutral-100 pt-6 flex items-center justify-between mb-8">
                            <span class="text-lg font-bold text-neutral-900">Total estimated</span>
                            <span class="text-2xl font-display font-bold text-brand-600" x-text="'$' + total"></span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-full btn-lg">
                            Proceed to Checkout
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <button @click="Alpine.store('cart').clear()" class="w-full mt-4 py-2 text-sm text-neutral-400 hover:text-red-500 transition-colors font-medium">
                            Clear Cart
                        </button>
                    </div>
                </div>

            </div>
        </x-layout.container>
    </x-layout.section>
</x-layout.app-layout>
