<x-layout.admin-layout>
    <x-slot:title>Orders</x-slot>
    <x-slot:pageTitle>Orders</x-slot>

{{-- Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
    <div>
        <h2 class="font-display text-3xl font-bold text-neutral-900">Orders</h2>
        <p class="text-neutral-500 mt-1">Track and manage all rental orders</p>
    </div>
    <a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-neutral-200 text-neutral-700 rounded-xl font-semibold text-sm hover:bg-neutral-50 hover:border-neutral-300 transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Export CSV
    </a>
</div>

{{-- Stat chips --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label' => 'All Orders',  'value' => $stats['all'],       'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',     'color' => 'bg-neutral-100 text-neutral-600',  'active' => !request('status')],
        ['label' => 'Pending',     'value' => $stats['pending'],   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',   'color' => 'bg-amber-100 text-amber-700',       'active' => request('status') === 'pending'],
        ['label' => 'Active',      'value' => $stats['active'],    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-green-100 text-green-700',       'active' => request('status') === 'active'],
        ['label' => 'Completed',   'value' => $stats['completed'], 'icon' => 'M5 13l4 4L19 7',                                 'color' => 'bg-sky-100 text-sky-700',           'active' => request('status') === 'completed'],
    ] as $chip)
    <a href="{{ request('status') === ($chip['active'] ? null : strtolower($chip['label'])) ? route('admin.orders.index') : route('admin.orders.index', ['status' => strtolower($chip['label']), 'search' => request('search')]) }}"
       class="bg-white rounded-2xl border p-4 flex items-center gap-3 hover:shadow-md transition-all duration-200 {{ $chip['active'] ? 'border-brand-300 shadow-sm ring-1 ring-brand-200' : 'border-neutral-100' }}">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $chip['color'] }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $chip['icon'] }}"/></svg>
        </div>
        <div>
            <p class="text-xl font-bold text-neutral-900 leading-none">{{ $chip['value'] }}</p>
            <p class="text-xs text-neutral-500 mt-0.5">{{ $chip['label'] }}</p>
        </div>
    </a>
    @endforeach
</div>

{{-- Filter Bar --}}
<div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-5 mb-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}" />
        @endif
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all"
                   placeholder="Search by order #, customer name, or email…" />
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input type="date" name="date" value="{{ request('date') }}"
               class="px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all w-full sm:w-44" />
        <select name="status" onchange="this.form.submit()"
                class="px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all w-full sm:w-44 appearance-none cursor-pointer">
            <option value="">All Status</option>
            @foreach(['pending','confirmed','active','completed','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-bold hover:bg-brand-700 transition-all shadow-sm shadow-brand-200 whitespace-nowrap">
            Search
        </button>
        @if(request()->anyFilled(['search','status','date']))
            <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 bg-red-50 text-red-500 rounded-xl text-sm font-bold hover:bg-red-100 transition-all whitespace-nowrap">
                Clear
            </a>
        @endif
    </form>
</div>

{{-- Orders Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-neutral-50/50 border-b border-neutral-100">
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] whitespace-nowrap">Order</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Customer</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden md:table-cell whitespace-nowrap">Placed On</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] whitespace-nowrap">Items</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] whitespace-nowrap">Total</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($orders as $order)
                <tr class="group hover:bg-neutral-50/50 transition-all duration-200">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-bold text-brand-600">#{{ $order->formatted_id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-neutral-800 text-sm leading-tight">{{ $order->customer_name }}</p>
                            <p class="text-xs text-neutral-400 mt-0.5">{{ $order->customer_email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-sm text-neutral-600 whitespace-nowrap">
                        {{ $order->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-neutral-700">
                            {{ $order->items->count() }} item{{ $order->items->count() !== 1 ? 's' : '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-neutral-900 whitespace-nowrap">
                        ${{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $order->status_color }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                @if($order->status === 'pending') bg-amber-500
                                @elseif($order->status === 'confirmed') bg-brand-500
                                @elseif($order->status === 'active') bg-green-500
                                @elseif($order->status === 'completed') bg-neutral-400
                                @else bg-red-500
                                @endif"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-brand-50 hover:text-brand-600 transition-all duration-200" title="View order">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirmed" />
                                <button type="submit" class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-green-50 hover:text-green-600 transition-all duration-200" title="Confirm order">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-neutral-50 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-neutral-800">No orders found</h3>
                            <p class="text-neutral-400 text-sm mt-1">Try adjusting your filters or search terms.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="px-6 py-4 bg-neutral-50/30 border-t border-neutral-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-neutral-400">
            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} orders
        </p>
        {{ $orders->links() }}
    </div>
    @else
    <div class="px-6 py-4 border-t border-neutral-100">
        <p class="text-sm text-neutral-400">Showing {{ $orders->count() }} order{{ $orders->count() !== 1 ? 's' : '' }}</p>
    </div>
    @endif
</div>

</x-layout.admin-layout>
