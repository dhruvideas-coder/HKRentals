{{--
    Cart Drawer Component
    Triggered by $dispatch('open-cart') / $dispatch('close-cart')
    State managed in Alpine store: Alpine.store('cart')
--}}
<div
    x-data="{
        open: false,
        step: 1
    }"
    @open-cart.window="open = true; step = 1"
    @close-cart.window="open = false"
    @keydown.escape.window="open = false"
    x-cloak
>

    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-neutral-900/60 backdrop-blur-md z-[90]"
        aria-hidden="true"
        x-cloak
    ></div>

    {{-- Drawer Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="transform translate-x-full"
        x-transition:enter-end="transform translate-x-0"
        x-transition:leave="transition ease-in duration-400"
        x-transition:leave-start="transform translate-x-0"
        x-transition:leave-end="transform translate-x-full"
        class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl z-[100] flex flex-col overflow-hidden sm:rounded-l-[2rem]"
        role="dialog"
        aria-modal="true"
        aria-label="Shopping cart"
        x-cloak
    >

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-neutral-100 flex items-center justify-between bg-white relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 shadow-sm border border-brand-100/50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display text-lg font-bold text-neutral-900 leading-tight" x-text="step === 1 ? 'Your Selection' : 'Order Summary'"></h2>
                    <div class="flex items-center gap-2 mt-0.5">
                        <div class="flex gap-1">
                            <div class="h-1 w-3 rounded-full transition-all duration-300" :class="step === 1 ? 'bg-brand-500' : 'bg-neutral-200'"></div>
                            <div class="h-1 w-3 rounded-full transition-all duration-300" :class="step === 2 ? 'bg-brand-500' : 'bg-neutral-200'"></div>
                        </div>
                        <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-widest" x-text="'Step ' + step + ' of 2'"></span>
                    </div>
                </div>
            </div>
            <button @click="open = false" class="w-8 h-8 rounded-full bg-neutral-50 hover:bg-neutral-100 flex items-center justify-center transition-all hover:rotate-90 text-neutral-500 hover:text-neutral-900" aria-label="Close cart">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex-1 overflow-y-auto bg-neutral-50/30">
            
            {{-- Empty State --}}
            <div x-show="$store.cart.items.length === 0" class="flex flex-col items-center justify-center h-full text-center p-8">
                <div class="w-24 h-24 rounded-full bg-white shadow-soft flex items-center justify-center mb-6 relative">
                    <span class="text-4xl">🛍️</span>
                    <div class="absolute -bottom-1 -right-1 w-10 h-10 bg-brand-50 rounded-full flex items-center justify-center text-xl animate-bounce">✨</div>
                </div>
                <h3 class="font-display font-bold text-xl text-neutral-900 mb-2">Your cart is empty</h3>
                <p class="text-sm text-neutral-500 mb-8 max-w-xs mx-auto leading-relaxed">Discover our exclusive collection of premium rentals to elevate your next event.</p>
                <button @click="open = false; window.location.href='{{ route('products') }}'"
                        class="btn btn-primary w-full max-w-xs rounded-xl">
                    Explore Collection
                </button>
            </div>

            <div x-show="$store.cart.items.length > 0">
                {{-- Delivery Progress (Now only on Step 2 as requested) --}}
                <div class="px-5 pt-5" x-show="step === 2" x-transition>
                    <div class="bg-white p-4 rounded-2xl border border-neutral-100 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-neutral-900 flex items-center gap-2">
                                <span class="text-lg">🚚</span> Delivery Progress
                            </span>
                            <span x-show="$store.cart.subtotal() < 200" class="text-[11px] font-bold text-brand-600" x-text="'$' + (200 - $store.cart.subtotal()).toFixed(2) + ' to go'"></span>
                            <span x-show="$store.cart.subtotal() >= 200" class="text-[11px] font-bold text-green-600">Free Delivery Unlocked!</span>
                        </div>
                        <div class="h-1.5 w-full bg-neutral-100 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-500 transition-all duration-700" :style="`width: ${Math.min(($store.cart.subtotal() / 200) * 100, 100)}%`"></div>
                        </div>
                    </div>
                </div>

                {{-- Step 1: Items List --}}
                <div x-show="step === 1" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-4"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     class="p-5 space-y-3">
                    <template x-for="(item, index) in $store.cart.items" :key="item.product_id || item.id">
                        <div class="group flex gap-3 p-3 bg-white border border-neutral-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
                            
                            {{-- Image --}}
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-neutral-50 flex-shrink-0 border border-neutral-100 relative">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                            </div>
                            
                            {{-- Info --}}
                            <div class="flex-1 flex flex-col min-w-0">
                                <div class="flex justify-between items-start gap-2 mb-0.5">
                                    <h4 class="font-bold text-neutral-900 text-sm leading-tight truncate group-hover:text-brand-600 transition-colors" x-text="item.name"></h4>
                                    <button @click="Alpine.store('cart').remove(item.product_id ?? item.id)"
                                            class="text-neutral-300 hover:text-red-500 transition-colors p-1 flex-shrink-0"
                                            aria-label="Remove item">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider mb-1 truncate" x-text="item.category"></p>
                                
                                {{-- Qty + Price --}}
                                <div class="mt-auto flex items-end justify-between gap-2">
                                    <div class="flex items-center bg-neutral-50 rounded-lg p-0.5 border border-neutral-100">
                                        <button class="w-6 h-6 flex items-center justify-center rounded-md text-neutral-500 hover:bg-white hover:text-brand-600 hover:shadow-sm transition-all text-xs" @click="Alpine.store('cart').dec(item.product_id ?? item.id)">−</button>
                                        <span class="w-6 text-center text-xs font-black text-neutral-900" x-text="item.quantity || item.qty"></span>
                                        <button class="w-6 h-6 flex items-center justify-center rounded-md text-neutral-500 hover:bg-white hover:text-brand-600 hover:shadow-sm transition-all text-xs" @click="Alpine.store('cart').inc(item.product_id ?? item.id)">+</button>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[9px] text-neutral-400 font-bold uppercase" x-text="$store.cart.calculateDays(item.dateRange) + ' Days'"></p>
                                        <span class="font-display font-bold text-sm text-neutral-900" x-text="'$' + (item.price * (item.quantity || item.qty) * $store.cart.calculateDays(item.dateRange)).toFixed(2)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Step 2: Summary --}}
                <div x-show="step === 2" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-4"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     class="p-5 space-y-4">
                    
                    <div class="bg-white rounded-2xl border border-neutral-100 shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-neutral-50">
                            <h4 class="font-bold text-neutral-900 mb-3 flex items-center gap-2 text-sm">
                                <span class="w-1 h-3.5 bg-brand-500 rounded-full"></span>
                                Cost Breakdown
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-neutral-500 font-medium">Items Subtotal</span>
                                    <span class="text-neutral-900 font-bold" x-text="'$' + $store.cart.subtotal()"></span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-neutral-500 font-medium">Delivery & Setup</span>
                                    <div class="text-right">
                                        <span class="text-green-600 font-bold" x-show="$store.cart.subtotal() >= 200">FREE</span>
                                        <span class="text-neutral-900 font-bold" x-show="$store.cart.subtotal() < 200">$25.00</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-neutral-500 font-medium">Service Fee (5%)</span>
                                    <span class="text-neutral-900 font-bold" x-text="'$' + ($store.cart.subtotal() * 0.05).toFixed(2)"></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-brand-50/30">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-[9px] font-bold text-brand-600 uppercase tracking-widest">Total Amount</span>
                                    <p class="text-2xl font-display font-black text-neutral-900 mt-0.5" 
                                       x-text="'$' + (parseFloat($store.cart.subtotal()) + ($store.cart.subtotal() >= 200 ? 0 : 25) + (parseFloat($store.cart.subtotal()) * 0.05)).toFixed(2)">
                                    </p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 shadow-inner">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rental Policy Note --}}
                    <div class="flex gap-2.5 p-3.5 bg-amber-50 rounded-xl border border-amber-100">
                        <span class="text-base flex-shrink-0">ℹ️</span>
                        <p class="text-[10px] text-amber-800 leading-relaxed font-medium">
                            <strong>Note:</strong> Final charges may vary based on location. Security deposit required.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-white border-t border-neutral-100 p-5 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.08)] z-10" x-show="$store.cart.items.length > 0">
            
            {{-- Step 1 Footer: Row Buttons --}}
            <div x-show="step === 1" class="space-y-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Subtotal</span>
                    <span class="font-display font-bold text-lg text-neutral-900" x-text="'$' + $store.cart.subtotal()"></span>
                </div>
                <div class="flex gap-3">
                    <button @click="open = false" 
                            class="flex-1 h-11 bg-neutral-50 hover:bg-neutral-100 text-neutral-600 rounded-xl font-bold text-sm flex items-center justify-center transition-all duration-300 active:scale-95 border border-neutral-100">
                        Continue
                    </button>
                    <button @click="step = 2" 
                            class="flex-[2] h-11 bg-neutral-900 hover:bg-brand-600 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-brand-500/20 active:scale-95">
                        Next
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Step 2 Footer: Row Buttons --}}
            <div x-show="step === 2" class="space-y-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-neutral-500 uppercase tracking-wider">Total Booking</span>
                    <span class="font-display font-bold text-lg text-brand-600" x-text="'$' + (parseFloat($store.cart.subtotal()) + ($store.cart.subtotal() >= 200 ? 0 : 25) + (parseFloat($store.cart.subtotal()) * 0.05)).toFixed(2)"></span>
                </div>
                <div class="flex gap-3">
                    <button @click="step = 1" 
                            class="flex-1 h-11 bg-neutral-50 hover:bg-neutral-100 text-neutral-600 rounded-xl font-bold text-sm flex items-center justify-center transition-all duration-300 active:scale-95 border border-neutral-100">
                        Back
                    </button>
                    <a href="{{ route('checkout') }}" 
                       class="flex-[2] h-11 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all duration-300 shadow-lg shadow-brand-500/20 active:scale-95">
                        Checkout
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
