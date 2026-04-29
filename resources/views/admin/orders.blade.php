<x-layout.admin-layout>
    <x-slot:title>Orders</x-slot>
    <x-slot:pageTitle>Orders</x-slot>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-2xl font-semibold text-neutral-900">Orders</h2>
        <p class="text-sm text-neutral-500 mt-0.5">Track and manage all rental orders</p>
    </div>
    <div class="flex items-center gap-3">
        <button class="btn btn-outline btn-sm">Export CSV</button>
    </div>
</div>

{{-- Stat chips --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @foreach([['All','24','neutral'],['Pending','5','amber'],['Active','12','green'],['Completed','7','sky']] as [$l,$v,$c])
    <div class="card p-4 flex items-center gap-3 cursor-pointer hover:shadow-elevated transition-all duration-200">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold
            @if($c==='neutral') bg-neutral-100 text-neutral-600
            @elseif($c==='amber') bg-amber-100 text-amber-700
            @elseif($c==='green') bg-green-100 text-green-700
            @else bg-sky-100 text-sky-700 @endif">{{ $v }}</div>
        <p class="text-sm font-medium text-neutral-600">{{ $l }}</p>
    </div>
    @endforeach
</div>

{{-- Filter Bar --}}
<div class="card mb-5 p-4 flex flex-col sm:flex-row gap-3">
    <input type="text" class="form-input text-sm flex-1" placeholder="Search by order #, customer..." />
    <input type="date" class="form-input text-sm w-full sm:w-44" />
    <select class="form-input text-sm w-full sm:w-40">
        <option>All Status</option>
        <option>Pending</option>
        <option>Confirmed</option>
        <option>Active</option>
        <option>Completed</option>
        <option>Cancelled</option>
    </select>
</div>

{{-- Orders Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th class="hidden md:table-cell">Event Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-right pr-5">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $orders = [
                    ['id'=>'SKR-10024','customer'=>'Emily Watson',   'email'=>'emily@email.com', 'date'=>'May 15, 2026','items'=>3,'total'=>318,'status'=>'Confirmed'],
                    ['id'=>'SKR-10023','customer'=>'James & Olivia', 'email'=>'josmith@email.com','date'=>'May 10, 2026','items'=>7,'total'=>742,'status'=>'Active'],
                    ['id'=>'SKR-10022','customer'=>'Michael Brown',  'email'=>'mbrown@email.com', 'date'=>'Apr 28, 2026','items'=>2,'total'=>205,'status'=>'Completed'],
                    ['id'=>'SKR-10021','customer'=>'Sophia Chen',    'email'=>'schen@email.com',  'date'=>'Apr 22, 2026','items'=>4,'total'=>480,'status'=>'Completed'],
                    ['id'=>'SKR-10020','customer'=>'David Taylor',   'email'=>'dtaylor@email.com','date'=>'May 20, 2026','items'=>1,'total'=>120,'status'=>'Pending'],
                    ['id'=>'SKR-10019','customer'=>'Rachel Green',   'email'=>'rgreen@email.com', 'date'=>'Jun 5, 2026', 'items'=>5,'total'=>612,'status'=>'Pending'],
                ];
                $statusColors = [
                    'Pending'=>'badge-low',
                    'Confirmed'=>'badge-gold',
                    'Active'=>'badge-available',
                    'Completed'=>'bg-neutral-100 text-neutral-600',
                    'Cancelled'=>'badge-unavailable',
                ];
                @endphp

                @foreach($orders as $order)
                <tr>
                    <td>
                        <span class="font-mono text-sm font-semibold text-brand-600">#{{ $order['id'] }}</span>
                    </td>
                    <td>
                        <div>
                            <p class="font-semibold text-neutral-800 text-sm">{{ $order['customer'] }}</p>
                            <p class="text-xs text-neutral-400">{{ $order['email'] }}</p>
                        </div>
                    </td>
                    <td class="hidden md:table-cell text-sm text-neutral-600">{{ $order['date'] }}</td>
                    <td>
                        <span class="text-sm font-medium text-neutral-700">{{ $order['items'] }} item{{ $order['items']>1?'s':'' }}</span>
                    </td>
                    <td class="font-bold text-neutral-900">${{ number_format($order['total']) }}</td>
                    <td>
                        <span class="badge {{ $statusColors[$order['status']] }} text-xs">{{ $order['status'] }}</span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1 pr-1">
                            <button class="p-1.5 rounded-lg hover:bg-brand-50 text-neutral-400 hover:text-brand-600 transition-base" title="View">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button class="p-1.5 rounded-lg hover:bg-green-50 text-neutral-400 hover:text-green-600 transition-base" title="Confirm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-neutral-100 flex items-center justify-between">
        <p class="text-sm text-neutral-400">Showing 6 of 24 orders</p>
        <nav class="flex items-center gap-1">
            <button class="w-8 h-8 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 flex items-center justify-center">‹</button>
            <button class="w-8 h-8 rounded-lg bg-brand-500 text-white text-sm font-semibold">1</button>
            <button class="w-8 h-8 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 flex items-center justify-center">2</button>
            <button class="w-8 h-8 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 flex items-center justify-center">3</button>
            <button class="w-8 h-8 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 flex items-center justify-center">›</button>
        </nav>
    </div>
</div>

</x-layout.admin-layout>
