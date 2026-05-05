<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $title ?? 'Admin' }} — SK Rentals Dashboard</title>
    <meta name="robots" content="noindex, nofollow" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}

    <style>
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background: #5b4132; /* Luxurious Deep Ebony Brown */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            overflow-x: hidden;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 10px 0 30px rgb(0 0 0 / 0.15);
        }

        /* Mobile View (Overlay) */
        @media (max-width: 1023px) {
            .admin-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
            }
            .admin-sidebar.collapsed {
                transform: translateX(-100%);
                width: 260px;
                opacity: 1;
                pointer-events: none;
            }
        }

        /* Desktop View (Push/Collapse) */
        @media (min-width: 1024px) {
            .admin-sidebar.collapsed {
                width: 0;
                border-right-width: 0;
                opacity: 0;
                pointer-events: none;
            }
        }

        .admin-sidebar-logo {
            height: 72px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            min-width: 260px;
        }

        .admin-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f9f8f6; /* Premium light canvas */
        }

        .admin-topbar {
            height: 72px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #e5e1dc;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            gap: 0.75rem;
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.03);
        }

        @media (min-width: 640px) {
            .admin-topbar {
                padding: 0 1.5rem;
                gap: 1rem;
            }
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            border-radius: 0.875rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(253, 248, 240, 0.6); /* Warm off-white */
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
            margin: 0.2rem 0;
        }
        .admin-nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            transform: translateX(4px);
        }
        .admin-nav-item.active {
            background: var(--color-brand-500);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 15px rgb(200 144 58 / 0.25);
        }
        .admin-nav-section {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(253, 248, 240, 0.4);
            padding: 1.75rem 1.25rem 0.625rem;
            white-space: nowrap;
        }
        
        [x-cloak] { display: none !important; }

        /* Responsive Table Adjustments */
        .admin-table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .admin-table {
            width: 100%;
        }

        @media (min-width: 1024px) {
            .admin-table {
                min-width: auto;
            }
        }
    </style>
</head>
<body class="h-full bg-neutral-50" x-data="{ sidebarOpen: window.innerWidth >= 1024, userDropdownOpen: false }" @resize.window="if (window.innerWidth < 1024) sidebarOpen = false">

<div class="flex h-full overflow-hidden relative">

    {{-- Backdrop (Mobile only) --}}
    <div x-show="sidebarOpen" 
         x-cloak 
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-neutral-900/60 backdrop-blur-sm z-40 lg:hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- ── Sidebar ── --}}
    <aside class="admin-sidebar" 
           :class="sidebarOpen ? '' : 'collapsed'"
           @click.away="if (window.innerWidth < 1024) sidebarOpen = false">

        {{-- Logo --}}
        <div class="admin-sidebar-logo flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <span class="text-2xl font-display font-semibold text-white">SK <span class="text-gradient-gold">Rentals</span></span>
            </a>
            
            {{-- Close Button (Mobile Only) --}}
            <button @click="sidebarOpen = false" 
                    class="lg:hidden p-1 rounded-lg text-white/50 hover:text-white hover:bg-white/10 transition-all"
                    aria-label="Close sidebar">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5" aria-label="Admin navigation">

            <p class="admin-nav-section">Main</p>

            <a href="{{ route('admin.dashboard') }}"
               class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>

            <p class="admin-nav-section">Catalogue</p>

            <a href="{{ route('admin.products') }}"
               class="admin-nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Products</span>
            </a>

            <a href="{{ route('admin.categories') }}"
               class="admin-nav-item {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>Categories</span>
            </a>

            <p class="admin-nav-section">Business</p>

            <a href="{{ route('admin.orders') }}"
               class="admin-nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Orders</span>
            </a>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Customers</span>
            </a>

            <p class="admin-nav-section">Settings</p>

            <a href="#" class="admin-nav-item">
                <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Settings</span>
            </a>

        </nav>

    </aside>

    {{-- ── Main Area ── --}}
    <div class="admin-content">

        {{-- Topbar --}}
        <header class="admin-topbar" role="banner">
            {{-- Sidebar toggle --}}
            <button @click.stop="sidebarOpen = !sidebarOpen" class="p-1.5 rounded-lg hover:bg-neutral-100 transition-base" aria-label="Toggle sidebar">
                <svg class="w-5 h-5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            {{-- Page title --}}
            <h1 class="text-base font-semibold text-neutral-800 flex-1">{{ $pageTitle ?? 'Dashboard' }}</h1>

            {{-- Right: User Dropdown --}}
            <div class="relative" x-data="{ userDropdownOpen: false }">
                <button @click="userDropdownOpen = !userDropdownOpen" 
                        @click.away="userDropdownOpen = false"
                        class="group flex items-center gap-2.5 p-1 rounded-full hover:bg-neutral-50 transition-all duration-300">
                    
                    <div class="relative">
                        @if(auth()->check() && auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-md group-hover:ring-brand-100 transition-all duration-300"
                                 referrerpolicy="no-referrer" />
                        @else
                            <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center text-white text-sm font-bold ring-2 ring-white shadow-md group-hover:ring-brand-100 transition-all duration-300">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                        {{-- Status indicator --}}
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    
                    <div class="hidden md:flex flex-col items-start pr-2">
                        <span class="text-sm font-bold text-neutral-800 leading-none mb-1 group-hover:text-brand-600 transition-colors">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest">Admin Portal</span>
                    </div>

                    <svg class="w-4 h-4 text-neutral-400 transition-transform duration-300 mr-1" :class="userDropdownOpen ? 'rotate-180 text-brand-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Beautiful Dropdown Menu --}}
                <div x-show="userDropdownOpen" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 mt-3 w-72 bg-white/95 backdrop-blur-md rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.12)] border border-neutral-100 overflow-hidden z-50">
                    
                    {{-- Dropdown Header with Profile Card --}}
                    <div class="relative px-5 py-6 bg-gradient-to-br from-brand-50 via-white to-brand-50/30">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                @if(auth()->check() && auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}"
                                         alt="{{ auth()->user()->name }}"
                                         class="w-14 h-14 rounded-xl object-cover shadow-lg ring-2 ring-white"
                                         referrerpolicy="no-referrer" />
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-brand-500 flex items-center justify-center text-white text-xl font-bold shadow-lg ring-2 ring-white">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-brand-500 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-neutral-800 truncate">{{ auth()->user()->name ?? 'Admin' }}</h4>
                                <p class="text-xs text-neutral-500 truncate mb-1">{{ auth()->user()->email ?? '' }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-brand-100 text-brand-700 uppercase tracking-tighter">Super Admin</span>
                            </div>
                        </div>
                    </div>

                    {{-- Dropdown Actions --}}
                    <div class="px-2 py-2">
                        <div class="px-3 py-2">
                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-[0.2em] mb-1">Account & Security</p>
                        </div>
                        
                        <a href="#" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-neutral-700 hover:bg-neutral-50 rounded-xl transition-all">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-neutral-800 leading-tight">My Profile</p>
                                <p class="text-[11px] text-neutral-500">View and edit personal info</p>
                            </div>
                        </a>

                        <a href="#" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-neutral-700 hover:bg-neutral-50 rounded-xl transition-all">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-neutral-800 leading-tight">Settings</p>
                                <p class="text-[11px] text-neutral-500">Preferences and security</p>
                            </div>
                        </a>
                    </div>

                    {{-- Logout Section --}}
                    <div class="mt-2 p-3 bg-neutral-50/50 border-t border-neutral-100">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="group flex items-center justify-center gap-3 w-full px-4 py-2.5 bg-white border border-red-100 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-200 transition-all shadow-sm">
                                <svg class="w-4.5 h-4.5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span class="font-bold text-sm">Sign Out Account</span>
                            </button>
                        </form>
                    </div>
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

            {{ $slot }}
        </main>

    </div>

</div>

{{ $scripts ?? '' }}
</body>
</html>
