<x-layout.admin-layout>
    <x-slot:title>Customers</x-slot>
    <x-slot:pageTitle>Customers</x-slot>

{{-- Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <h2 class="font-display text-3xl font-bold text-neutral-900">Customers</h2>
        <p class="text-neutral-500 mt-1">All customers who have placed orders</p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label' => 'Total Customers',  'value' => $stats['total'],          'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'bg-brand-100 text-brand-700'],
        ['label' => 'New This Month',   'value' => $stats['new_this_month'],  'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z',                                 'color' => 'bg-green-100 text-green-700'],
        ['label' => 'With Orders',      'value' => $stats['with_orders'],     'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',                                                                            'color' => 'bg-sky-100 text-sky-700'],
        ['label' => 'Total Revenue',    'value' => '$'.number_format($stats['total_revenue'], 0), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 8v1m0-9v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-amber-100 text-amber-700'],
    ] as $stat)
    <div class="bg-white rounded-2xl border border-neutral-100 p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $stat['color'] }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-neutral-900 leading-none">{{ $stat['value'] }}</p>
            <p class="text-xs text-neutral-500 mt-0.5">{{ $stat['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Search bar --}}
<div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-5 mb-6">
    <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all"
                   placeholder="Search by name, email, or phone…" />
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-bold hover:bg-brand-700 transition-all shadow-sm shadow-brand-200 whitespace-nowrap">
            Search
        </button>
        @if(request()->filled('search'))
        <a href="{{ route('admin.customers.index') }}" class="px-5 py-2.5 bg-red-50 text-red-500 rounded-xl text-sm font-bold hover:bg-red-100 transition-all whitespace-nowrap">
            Clear
        </a>
        @endif
    </form>
</div>

{{-- Customers Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-neutral-50/50 border-b border-neutral-100">
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Customer</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden sm:table-cell">Contact</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden md:table-cell whitespace-nowrap">Orders</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden lg:table-cell whitespace-nowrap">Total Spent</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden md:table-cell whitespace-nowrap">Member Since</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($customers as $customer)
                <tr class="group hover:bg-neutral-50/50 transition-all duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 shadow-sm">
                                {{ $customer->initials }}
                            </div>
                            <div>
                                <p class="font-bold text-neutral-800 text-sm leading-tight">{{ $customer->name }}</p>
                                <p class="text-xs text-neutral-400 sm:hidden mt-0.5">{{ $customer->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell">
                        <p class="text-sm text-neutral-600">{{ $customer->email }}</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $customer->phone }}</p>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700">
                            {{ $customer->orders_count }} order{{ $customer->orders_count !== 1 ? 's' : '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell font-bold text-neutral-900 whitespace-nowrap">
                        ${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-sm text-neutral-500 whitespace-nowrap">
                        {{ $customer->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.customers.show', $customer) }}"
                           class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-brand-50 hover:text-brand-600 transition-all duration-200 inline-flex" title="View customer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-neutral-50 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-neutral-800">No customers yet</h3>
                            <p class="text-neutral-400 text-sm mt-1">Customers appear here once they place an order.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($customers->hasPages())
    <div class="px-6 py-4 bg-neutral-50/30 border-t border-neutral-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-neutral-400">
            Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }} of {{ $customers->total() }} customers
        </p>
        {{ $customers->links() }}
    </div>
    @else
    <div class="px-6 py-4 border-t border-neutral-100">
        <p class="text-sm text-neutral-400">{{ $customers->count() }} customer{{ $customers->count() !== 1 ? 's' : '' }}</p>
    </div>
    @endif
</div>

</x-layout.admin-layout>
