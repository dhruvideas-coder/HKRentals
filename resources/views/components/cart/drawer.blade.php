{{--
    Cart Drawer Component
    Triggered by $dispatch('open-cart') / $dispatch('close-cart')
    State managed in Alpine store: Alpine.store('cart')
--}}
<div
    x-data="{
        open: false,
        get items() { return Alpine.store('cart').items },
        get count() { return Alpine.store('cart').count() },
        get subtotal() { return Alpine.store('cart').subtotal() },
    }"
    @open-cart.window="open = true"
    @close-cart.window="open = false"
    @keydown.escape.window="open = false"
>

    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-[2px] z-49"
        style="z-index:49"
        aria-hidden="true"
    ></div>

    {{-- Drawer Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform translate-x-full"
        x-transition:enter-end="transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="transform translate-x-0"
        x-transition:leave-end="transform translate-x-full"
        class="cart-drawer"
        role="dialog"
        aria-modal="true"
        aria-label="Shopping cart"
    >

        {{-- Header --}}
        <div class="cart-drawer-header">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h2 class="font-display text-lg font-semibold text-neutral-900">Your Cart</h2>
                <span x-show="count > 0" class="badge badge-gold text-xs" x-text="count + ' items'"></span>
            </div>
            <button @click="open = false" class="w-8 h-8 rounded-lg hover:bg-neutral-100 flex items-center justify-center transition-base" aria-label="Close cart">
                <svg class="w-4 h-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="cart-drawer-body">

            {{-- Empty State --}}
            <div x-show="items.length === 0" class="flex flex-col items-center justify-center h-full text-center py-16">
                <div class="w-20 h-20 rounded-full bg-brand-50 flex items-center justify-center mb-4">
                    <svg class="w-9 h-9 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="font-display font-semibold text-neutral-700 mb-1">Your cart is empty</p>
                <p class="text-sm text-neutral-400 mb-6">Add items from our collection to get started.</p>
                <button @click="open = false; window.location.href='{{ route('products') }}'"
                        class="btn btn-primary btn-sm">
                    Browse Collection
                </button>
            </div>

            {{-- Cart Items --}}
            <div x-show="items.length > 0" class="space-y-4">
                <template x-for="(item, index) in items" :key="item.product_id || item.id">
                    <div class="flex gap-3 py-3 border-b border-neutral-100 last:border-0">
                        {{-- Image --}}
                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-neutral-100 flex-shrink-0">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
                        </div>
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-neutral-800 text-sm leading-tight truncate" x-text="item.name"></p>
                            <p class="text-xs text-neutral-400 mt-0.5" x-text="item.category"></p>
                            <p class="text-xs text-neutral-500 mt-1">
                                <span x-text="item.dateRange || 'Select dates'"></span>
                            </p>
                            {{-- Qty + Remove row --}}
                            <div class="flex items-center justify-between mt-2.5">
                                <div class="flex items-center gap-1.5">
                                    <button class="qty-btn" @click="Alpine.store('cart').dec(item.product_id || item.id)" aria-label="Decrease">−</button>
                                    <span class="w-7 text-center text-sm font-semibold text-neutral-800" x-text="item.quantity || item.qty"></span>
                                    <button class="qty-btn" @click="Alpine.store('cart').inc(item.product_id || item.id)" aria-label="Increase">+</button>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-brand-600 text-sm" x-text="'$' + (item.price * (item.quantity || item.qty)).toFixed(2)"></span>
                                    <button @click="Alpine.store('cart').remove(item.product_id || item.id)"
                                            class="text-neutral-300 hover:text-red-500 transition-base"
                                            aria-label="Remove item">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Footer --}}
        <div class="cart-drawer-footer" x-show="items.length > 0">
            {{-- Subtotal --}}
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-neutral-500">Subtotal</span>
                <span class="font-bold text-neutral-900 text-lg" x-text="'$' + subtotal"></span>
            </div>
            <p class="text-xs text-neutral-400 mb-4">Delivery, setup fees &amp; taxes calculated at checkout.</p>
            <a href="{{ route('checkout') }}" class="btn btn-primary w-full btn-lg">
                Proceed to Checkout
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <button @click="open = false" class="btn btn-ghost w-full mt-2 text-sm text-neutral-500">
                Continue Shopping
            </button>
        </div>

    </div>
</div>
