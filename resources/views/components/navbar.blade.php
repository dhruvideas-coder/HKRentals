<nav class="w-full bg-white/95 backdrop-blur-sm border-b border-neutral-100 sticky top-0 z-50"
     x-data="{ mobileOpen: false }"
     role="navigation"
     aria-label="Main navigation">

    <div class="container-sk">
        <div class="flex items-center justify-between h-16">

            {{-- ── Logo ── --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0" aria-label="SK Rentals home">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center">
                    <span class="text-white font-display font-bold text-sm leading-none">SK</span>
                </div>
                <span class="font-display text-xl font-semibold text-neutral-900">
                    SK <span class="text-gradient-gold">Rentals</span>
                </span>
            </a>

            {{-- ── Desktop Nav Links ── --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Home
                </a>
                <a href="{{ route('products') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('products') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Products
                </a>
                <a href="{{ route('about') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    About
                </a>
                <a href="{{ route('contact') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Contact
                </a>
            </div>

            {{-- ── Desktop CTA ── --}}
            <div class="hidden md:flex items-center gap-3" x-data="{ get cartCount() { return Alpine.store('cart').count() } }">
                {{-- Cart icon button --}}
                <button @click="$dispatch('open-cart')"
                        class="relative p-2 rounded-lg hover:bg-brand-50 transition-base text-neutral-600 hover:text-brand-600"
                        aria-label="Open shopping cart">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartCount > 0"
                          class="absolute -top-0.5 -right-0.5 min-w-[1.1rem] h-[1.1rem] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-0.5 border border-white"
                          x-text="cartCount"></span>
                </button>
                <a href="{{ route('products') }}" class="btn btn-primary btn-sm">
                    Browse Rentals
                </a>
            </div>


            {{-- ── Mobile Hamburger ── --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden p-2 rounded-lg hover:bg-neutral-100 transition-base"
                    :aria-expanded="mobileOpen"
                    aria-controls="mobile-menu"
                    aria-label="Toggle menu">
                <svg x-show="!mobileOpen" class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen"  class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

        </div>
    </div>

    {{-- ── Mobile Menu ── --}}
    <div id="mobile-menu"
         x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-neutral-100 bg-white"
         @click.away="mobileOpen = false">
        <div class="container-sk py-3 flex flex-col gap-1">
            <a href="{{ route('home') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Home</a>
            <a href="{{ route('products') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('products') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Products</a>
            <a href="{{ route('about') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">About</a>
            <a href="{{ route('contact') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Contact</a>
            <div class="pt-2 border-t border-neutral-100">
                <a href="{{ route('products') }}" class="btn btn-primary w-full">Browse Rentals</a>
            </div>
        </div>
    </div>

</nav>
