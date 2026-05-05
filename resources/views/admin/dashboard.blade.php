<x-layout.admin-layout>
    <x-slot:title>Dashboard</x-slot>
    <x-slot:pageTitle>Dashboard</x-slot>

{{-- Welcome strip with premium glassmorphism feel --}}
<div class="relative overflow-hidden rounded-3xl mb-10 bg-white border border-white/60 shadow-[0_8px_32px_rgba(0,0,0,0.04)] p-8 sm:p-10">
    {{-- Decorative background elements --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-200/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-brand-100/30 rounded-full blur-3xl"></div>
    
    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-700 text-[10px] font-bold uppercase tracking-widest mb-5 border border-brand-200/50">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                </span>
                Live Platform Dashboard
            </div>
            <h2 class="font-display text-3xl sm:text-5xl font-bold text-neutral-900 mb-4 leading-tight">
                Welcome back, <span class="text-gradient-gold">{{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</span> 👋
            </h2>
            <p class="text-neutral-500 text-base sm:text-lg leading-relaxed">
                Your rental business is growing. Track your <span class="text-neutral-900 font-semibold">Catalogue</span> and <span class="text-neutral-900 font-semibold">Orders</span> for today, <span class="text-brand-600 font-medium">{{ now()->format('l, F j') }}</span>.
            </p>
        </div>
        <div class="flex-shrink-0 hidden lg:block">
             <div class="w-48 h-48 relative">
                 <img src="{{ asset('images/product-arch.png') }}" alt="" class="w-full h-full object-contain drop-shadow-2xl animate-float" />
             </div>
        </div>
    </div>
</div>

{{-- KPI Cards with enhanced aesthetics --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    @foreach ([
        ['label'=>'Total Orders',    'value'=>'—',  'sub'=>'No orders yet',    'icon'=>'📋', 'color'=>'brand'],
        ['label'=>'Monthly Revenue', 'value'=>'$—', 'sub'=>'No sales yet',     'icon'=>'💰', 'color'=>'emerald'],
        ['label'=>'Active Rentals',  'value'=>'—',  'sub'=>'No active rentals','icon'=>'📦', 'color'=>'sky'],
        ['label'=>'Customers',       'value'=>'—',  'sub'=>'No customers yet', 'icon'=>'👥', 'color'=>'violet'],
    ] as $kpi)
    <div class="group card p-6 flex flex-col gap-5 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="w-12 h-12 rounded-2xl bg-{{ $kpi['color'] }}-50 text-{{ $kpi['color'] }}-600 flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                {{ $kpi['icon'] }}
            </div>
            <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest bg-neutral-50 px-2 py-1 rounded">Realtime</span>
        </div>
        <div>
            <p class="text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1">{{ $kpi['label'] }}</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-extrabold text-neutral-900 tracking-tight">{{ $kpi['value'] }}</p>
                <span class="text-emerald-500 text-xs font-bold">0% ↑</span>
            </div>
            <p class="text-xs text-neutral-400 mt-2 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $kpi['sub'] }}
            </p>
        </div>
    </div>
    @endforeach
</div>

{{-- Content Grid --}}
<div class="grid lg:grid-cols-3 gap-6">

    {{-- Recent Activity --}}
    <div class="lg:col-span-2 card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-semibold text-neutral-900">Recent Orders</h3>
            <a href="#" class="text-sm text-brand-600 hover:text-brand-700 font-medium">View all →</a>
        </div>
        <div class="card-body">
            <div class="text-center py-12">
                <img src="{{ asset('images/product-arch.png') }}"
                     alt="No orders yet"
                     class="w-28 h-28 object-cover rounded-full mx-auto mb-4 opacity-60 grayscale" />
                <p class="text-sm text-neutral-400 font-medium">No orders yet</p>
                <p class="text-xs text-neutral-300 mt-1">Orders will appear here once customers place them.</p>
                <a href="#" class="btn btn-primary btn-sm mt-4">Add First Product</a>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="flex flex-col gap-6">

        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-neutral-900">Quick Actions</h3>
            </div>
            <div class="card-body flex flex-col gap-3">
                <a href="#" class="btn btn-primary w-full">+ New Product</a>
                <a href="#" class="btn btn-outline w-full">View Orders</a>
                <a href="#" class="btn btn-ghost w-full text-neutral-600">Manage Customers</a>
            </div>
        </div>

        {{-- Image teaser card --}}
        <div class="relative rounded-2xl overflow-hidden h-40">
            <img src="{{ asset('images/ceremony.png') }}"
                 alt="Outdoor wedding ceremony"
                 class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/80 to-transparent flex items-end p-4">
                <div>
                    <p class="text-white text-sm font-semibold font-display">Next Event</p>
                    <p class="text-neutral-300 text-xs mt-0.5">No upcoming events scheduled</p>
                </div>
            </div>
        </div>

    </div>

</div>

</x-layout.admin-layout>
