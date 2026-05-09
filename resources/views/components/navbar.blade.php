@php
    $navCategories = \App\Models\Category::orderBy('name')->get();
@endphp

<nav class="w-full bg-white/95 backdrop-blur-sm border-b border-neutral-100 sticky top-0 z-50"
     x-data="{ mobileOpen: false, catalogOpen: false }"
     role="navigation"
     aria-label="Main navigation">

    <div class="container-sk">
        <div class="flex items-center justify-between h-16">

            {{-- ── Logo ── --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0" aria-label="HK Rentals home">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center">
                    <span class="text-white font-display font-bold text-sm leading-none">HK</span>
                </div>
                <span class="font-display text-xl font-semibold text-neutral-900">
                    HK <span class="text-gradient-gold">Rentals</span>
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
                          {{ request()->routeIs('products') && !request()->filled('category') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Products
                </a>

                {{-- ── Catalog Dropdown ── --}}
                <div class="relative" x-data @click.away="catalogOpen = false">
                    <button @click="catalogOpen = !catalogOpen"
                            :aria-expanded="catalogOpen"
                            class="flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-medium transition-base
                                   {{ request()->filled('category') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                        Catalog
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': catalogOpen }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown panel --}}
                    <div x-show="catalogOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-98"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1 scale-98"
                         x-cloak
                         class="absolute left-0 top-full mt-1.5 w-64 bg-white rounded-xl shadow-xl border border-neutral-100 py-2 z-50 max-h-[70vh] overflow-y-auto">

                        <a href="{{ route('products') }}"
                           @click="catalogOpen = false"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition-base
                                  {{ request()->routeIs('products') && !request()->filled('category') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50 hover:text-neutral-900' }}">
                            <span class="text-base">🗂️</span>
                            <span>All Categories</span>
                        </a>

                        <div class="my-1.5 border-t border-neutral-100"></div>

                        @foreach($navCategories as $cat)
                        <a href="{{ route('products', ['category' => $cat->slug]) }}"
                           @click="catalogOpen = false"
                           class="flex items-center gap-3 px-4 py-2 text-sm transition-base
                                  {{ request()->get('category') === $cat->slug ? 'bg-brand-50 text-brand-700 font-medium' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                            @if($cat->icon)
                                <span class="text-base w-5 text-center">{{ $cat->icon }}</span>
                            @else
                                <span class="w-5 h-5 rounded-full bg-neutral-100 flex-shrink-0"></span>
                            @endif
                            <span>{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('about') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    About
                </a>
                <a href="{{ route('reviews') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('reviews') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Reviews
                </a>
                <a href="{{ route('events') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('events') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Events
                </a>
                <a href="{{ route('gallery') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-base
                          {{ request()->routeIs('gallery') ? 'bg-brand-50 text-brand-700' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }}">
                    Gallery
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
                @auth
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm" style="background:linear-gradient(135deg,#c8903a,#8b5e1c);color:#fff;border-color:transparent;box-shadow:0 2px 8px rgba(200,144,58,0.4);" aria-label="Go to Admin Dashboard">
                        <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('admin.login') }}" class="btn btn-sm" style="background:rgba(200,144,58,0.05); color:#8b5e1c; border:1.5px solid rgba(200,144,58,0.25); box-shadow:0 2px 10px rgba(200,144,58,0.05);" aria-label="Admin Portal">
                        <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Admin Portal
                    </a>
                    @endif
                @else
                <a href="{{ route('admin.login') }}" class="btn btn-sm" style="background:rgba(200,144,58,0.05); color:#8b5e1c; border:1.5px solid rgba(200,144,58,0.25); box-shadow:0 2px 10px rgba(200,144,58,0.05);" aria-label="Admin Portal">
                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Admin Portal
                </a>
                @endauth
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
            <a href="{{ route('products') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('products') && !request()->filled('category') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Products</a>

            {{-- Mobile Catalog accordion --}}
            <div x-data="{ open: {{ request()->filled('category') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium
                               {{ request()->filled('category') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">
                    <span>Catalog</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="pl-3 mt-1 flex flex-col gap-0.5 border-l-2 border-brand-100 ml-3">
                    <a href="{{ route('products') }}"
                       class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('products') && !request()->filled('category') ? 'text-brand-700 font-medium' : 'text-neutral-600 hover:bg-neutral-50' }}">
                        🗂️ All Categories
                    </a>
                    @foreach($navCategories as $cat)
                    <a href="{{ route('products', ['category' => $cat->slug]) }}"
                       class="px-3 py-2 rounded-lg text-sm {{ request()->get('category') === $cat->slug ? 'text-brand-700 font-medium bg-brand-50' : 'text-neutral-600 hover:bg-neutral-50' }}">
                        {{ $cat->icon ?? '' }} {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('about') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">About</a>
            <a href="{{ route('reviews') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('reviews') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Reviews</a>
            <a href="{{ route('events') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('events') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Events</a>
            <a href="{{ route('gallery') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('gallery') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Gallery</a>
            <a href="{{ route('contact') }}" class="px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-700' : 'text-neutral-700 hover:bg-neutral-50' }}">Contact</a>
            <div class="pt-2 border-t border-neutral-100">
                @auth
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn w-full" style="background:linear-gradient(135deg,#c8903a,#8b5e1c);color:#fff;border-color:transparent;">Dashboard</a>
                    @else
                    <a href="{{ route('admin.login') }}" class="btn w-full" style="background:rgba(200,144,58,0.05); color:#8b5e1c; border:1.5px solid rgba(200,144,58,0.25);">Admin Portal</a>
                    @endif
                @else
                <a href="{{ route('admin.login') }}" class="btn w-full" style="background:rgba(200,144,58,0.05); color:#8b5e1c; border:1.5px solid rgba(200,144,58,0.25);">Admin Portal</a>
                @endauth
            </div>
        </div>
    </div>

</nav>
