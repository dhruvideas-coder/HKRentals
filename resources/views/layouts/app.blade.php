<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- SEO --}}
    <title>@yield('title', config('app.name', 'SK Rentals')) — Wedding & Event Rentals</title>
    <meta name="description" content="@yield('meta_description', 'SK Rentals — Premium wedding and event rental items in Knoxville. Elegant decor, furniture, and more for your special day.')" />
    <meta name="keywords" content="@yield('meta_keywords', 'wedding rentals, event rentals, Knoxville, party supplies, decor')" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'SK Rentals') — Wedding & Event Rentals" />
    <meta property="og:description" content="@yield('meta_description', 'Premium wedding and event rental items in Knoxville.')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Fonts: Plus Jakarta Sans + Playfair Display --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet" />

    {{-- Vite: CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page-level head extras --}}
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-cream" x-data="{}">

    {{-- ── Cart Drawer (global) ── --}}
    @include('components.cart-drawer')

    {{-- ── Navbar ── --}}
    @include('components.navbar')

    {{-- ── Main Content ── --}}
    <main id="main-content" class="flex-1 fade-in" role="main">
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    @include('components.footer')

    {{-- ── Floating Cart FAB ── --}}
    <div x-data="{ get count() { return Alpine.store('cart').count() } }">
        <button
            @click="$dispatch('open-cart')"
            class="cart-fab"
            aria-label="Open cart"
            x-show="count > 0"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span class="cart-fab-badge" x-text="count"></span>
        </button>
    </div>

    {{-- Page-level scripts --}}
    @stack('scripts')

</body>
</html>

