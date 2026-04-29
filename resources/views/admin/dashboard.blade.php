<x-layout.admin-layout>
    <x-slot:title>Dashboard</x-slot>
    <x-slot:pageTitle>Dashboard</x-slot>

{{-- Welcome strip with image accent --}}
<div class="relative overflow-hidden rounded-2xl mb-8 bg-gradient-to-r from-neutral-900 to-neutral-800 p-7">
    {{-- Background image accent --}}
    <div class="absolute right-0 top-0 h-full w-1/2 opacity-20 pointer-events-none hidden lg:block">
        <img src="{{ asset('images/hero.png') }}" alt="" class="w-full h-full object-cover object-center" aria-hidden="true" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-900 to-transparent"></div>
    </div>
    <div class="relative z-10">
        <p class="text-brand-300 text-sm font-medium mb-1 uppercase tracking-widest">Welcome back</p>
        <h2 class="font-display text-2xl sm:text-3xl font-semibold text-white mb-2">
            {{ auth()->user()->name ?? 'Admin' }} 👋
        </h2>
        <p class="text-neutral-400 text-sm">Here's what's happening with SK Rentals today, {{ now()->format('l, F j') }}.</p>
    </div>
</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    @foreach ([
        ['label'=>'Total Orders',    'value'=>'—',  'sub'=>'No orders yet',    'icon'=>'📋', 'from'=>'from-brand-500',  'to'=>'to-brand-700'],
        ['label'=>'Monthly Revenue', 'value'=>'$—', 'sub'=>'No sales yet',     'icon'=>'💰', 'from'=>'from-emerald-500','to'=>'to-emerald-700'],
        ['label'=>'Active Rentals',  'value'=>'—',  'sub'=>'No active rentals','icon'=>'📦', 'from'=>'from-sky-500',    'to'=>'to-sky-700'],
        ['label'=>'Customers',       'value'=>'—',  'sub'=>'No customers yet', 'icon'=>'👥', 'from'=>'from-violet-500', 'to'=>'to-violet-700'],
    ] as $kpi)
    <div class="card p-5 flex items-center gap-4 hover:shadow-elevated transition-all duration-200">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $kpi['from'] }} {{ $kpi['to'] }} flex items-center justify-center text-xl flex-shrink-0 shadow-md">
            {{ $kpi['icon'] }}
        </div>
        <div class="min-w-0">
            <p class="text-xs font-medium text-neutral-500 uppercase tracking-wide truncate">{{ $kpi['label'] }}</p>
            <p class="text-2xl font-bold text-neutral-900 mt-0.5 leading-none">{{ $kpi['value'] }}</p>
            <p class="text-xs text-neutral-400 mt-1">{{ $kpi['sub'] }}</p>
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
