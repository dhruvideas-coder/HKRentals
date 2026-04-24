<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Admin') — SK Rentals Dashboard</title>
    <meta name="robots" content="noindex, nofollow" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')

    <style>
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1612 0%, #2a2219 50%, #1a1612 100%);
            border-right: 1px solid rgb(200 144 58 / 0.15);
        }
        .admin-sidebar-logo {
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgb(200 144 58 / 0.12);
        }
        .admin-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }
        .admin-topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #f0ece6;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: 0 1px 4px rgb(0 0 0 / 0.04);
        }
        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: rgb(255 255 255 / 0.65);
            transition: all 0.18s ease;
            text-decoration: none;
        }
        .admin-nav-item:hover,
        .admin-nav-item.active {
            background: rgb(200 144 58 / 0.15);
            color: #e8b96c;
        }
        .admin-nav-section {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgb(255 255 255 / 0.3);
            padding: 0.5rem 1.25rem 0.25rem;
            margin-top: 0.75rem;
        }
    </style>
</head>
<body class="h-full bg-neutral-50" x-data="{ sidebarOpen: true }">

<div class="flex h-full">

    {{-- ── Sidebar ── --}}
    <aside class="admin-sidebar flex-shrink-0 flex flex-col" :class="sidebarOpen ? '' : '-translate-x-full'">

        {{-- Logo --}}
        <div class="admin-sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <span class="text-xl font-display font-semibold text-white">SK <span class="text-gradient-gold">Rentals</span></span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5" aria-label="Admin navigation">

            <p class="admin-nav-section">Main</p>

            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p class="admin-nav-section">Catalogue</p>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Products
            </a>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
            </a>

            <p class="admin-nav-section">Business</p>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Orders
            </a>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Customers
            </a>

            <p class="admin-nav-section">Settings</p>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>

        </nav>

        {{-- Sidebar Footer --}}
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-nav-item w-full text-left hover:text-red-400 hover:bg-red-500/10">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ── Main Area ── --}}
    <div class="admin-content">

        {{-- Topbar --}}
        <header class="admin-topbar" role="banner">
            {{-- Sidebar toggle --}}
            <button @click="sidebarOpen = !sidebarOpen" class="p-1.5 rounded-lg hover:bg-neutral-100 transition-base" aria-label="Toggle sidebar">
                <svg class="w-5 h-5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            {{-- Page title --}}
            <h1 class="text-base font-semibold text-neutral-800 flex-1">@yield('page_title', 'Dashboard')</h1>

            {{-- Right: user info --}}
            <div class="flex items-center gap-3">
                <span class="text-sm text-neutral-500 hidden sm:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center text-white text-sm font-semibold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main id="admin-content" class="flex-1 overflow-y-auto p-6 fade-in" role="main">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-4 p-3.5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2" role="alert">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3.5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2" role="alert">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')
</body>
</html>
