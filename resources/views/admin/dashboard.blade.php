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
                 <img src="{{ asset('images/products/product-arch.png') }}" alt="" class="w-full h-full object-contain drop-shadow-2xl animate-float" />
             </div>
        </div>
    </div>
</div>

{{-- KPI Cards with enhanced aesthetics --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    @php
        $kpiData = [
            ['label'=>'Total Orders',    'value'=>$metrics['total_orders'],  'sub'=>$metrics['total_orders'] > 0 ? 'Orders to date' : 'No orders yet',    'icon'=>'📋', 'color'=>'brand'],
            ['label'=>'Catalogue items', 'value'=>$metrics['total_products'], 'sub'=>$metrics['total_products'] . ' active items',     'icon'=>'📦', 'color'=>'emerald'],
            ['label'=>'Categories',      'value'=>$metrics['total_categories'],  'sub'=>'Organizational units','icon'=>'🎨', 'color'=>'sky'],
            ['label'=>'Customers',       'value'=>'0',  'sub'=>'No customers yet', 'icon'=>'👥', 'color'=>'violet'],
        ];
    @endphp

    @foreach ($kpiData as $kpi)
    <div class="group card p-6 flex flex-col gap-5 hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div class="w-12 h-12 rounded-2xl bg-neutral-50 text-neutral-600 flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                {{ $kpi['icon'] }}
            </div>
            <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest bg-neutral-50 px-2 py-1 rounded">Realtime</span>
        </div>
        <div>
            <p class="text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1">{{ $kpi['label'] }}</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-extrabold text-neutral-900 tracking-tight">{{ $kpi['value'] }}</p>
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

    {{-- Recent Products --}}
    <div class="lg:col-span-2 card bg-white rounded-3xl overflow-hidden border border-neutral-100">
        <div class="p-6 border-b border-neutral-100 flex items-center justify-between">
            <h3 class="font-bold text-neutral-900">Recently Added Products</h3>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-brand-600 hover:text-brand-700 font-bold">View Catalogue →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <tbody class="divide-y divide-neutral-50">
                    @forelse($metrics['recent_products'] as $p)
                    <tr class="hover:bg-neutral-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-neutral-100">
                                    @if($p->image)
                                        <img src="{{ asset($p->image) }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-neutral-300">📦</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-neutral-800">{{ $p->name }}</p>
                                    <p class="text-[10px] text-neutral-400 uppercase font-bold tracking-wider">{{ $p->category->name ?? 'Uncategorized' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-neutral-900">${{ number_format($p->price_per_day, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $p->status === 'available' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-6 py-12 text-center text-neutral-400" colspan="3">
                            No products found. Start by adding one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="flex flex-col gap-6">

        <div class="card p-6 bg-white rounded-3xl border border-neutral-100 shadow-sm">
            <h3 class="font-bold text-neutral-900 mb-5">Quick Management</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between group p-3 rounded-2xl hover:bg-brand-50 transition-all border border-neutral-50 hover:border-brand-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center group-hover:scale-110 transition-transform">📦</div>
                        <span class="text-sm font-bold text-neutral-700">Add Product</span>
                    </div>
                    <svg class="w-5 h-5 text-neutral-300 group-hover:text-brand-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between group p-3 rounded-2xl hover:bg-sky-50 transition-all border border-neutral-50 hover:border-sky-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">🎨</div>
                        <span class="text-sm font-bold text-neutral-700">Manage Categories</span>
                    </div>
                    <svg class="w-5 h-5 text-neutral-300 group-hover:text-sky-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="#" class="flex items-center justify-between group p-3 rounded-2xl hover:bg-violet-50 transition-all border border-neutral-50 hover:border-violet-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center group-hover:scale-110 transition-transform">👥</div>
                        <span class="text-sm font-bold text-neutral-700">Customers</span>
                    </div>
                    <svg class="w-5 h-5 text-neutral-300 group-hover:text-violet-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Next Event teaser --}}
        <div class="relative rounded-3xl overflow-hidden h-44 shadow-lg ring-1 ring-neutral-100">
            <img src="{{ asset('images/ceremony.png') }}"
                 alt="Outdoor wedding ceremony"
                 class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/90 via-neutral-900/40 to-transparent flex items-end p-6">
                <div>
                    <div class="inline-flex items-center px-2 py-0.5 rounded bg-brand-500 text-[9px] font-bold text-white uppercase tracking-widest mb-2">Upcoming</div>
                    <p class="text-white text-lg font-bold font-display">No events scheduled</p>
                    <p class="text-neutral-300 text-xs mt-0.5">Check orders for new bookings</p>
                </div>
            </div>
        </div>

    </div>

</div>

</x-layout.admin-layout>
