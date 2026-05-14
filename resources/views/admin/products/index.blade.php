<x-layout.admin-layout>
    <x-slot:title>Products Management</x-slot>
    <x-slot:pageTitle>Products</x-slot>

    <div x-data="{ deleteModalOpen: false, deleteId: '' }"
         x-init="$watch('deleteModalOpen', val => { const m = document.getElementById('admin-content'); m.style.overflow = val ? 'hidden' : ''; })"
         @keydown.escape.window="deleteModalOpen = false">
        {{-- Header + Add Button --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="font-display text-3xl font-bold text-neutral-900">Rental Catalogue</h2>
                <p class="text-neutral-500 mt-1">Manage, filter, and track your rental inventory</p>
            </div>
            <a href="{{ route('admin.products.create') }}"
               class="group inline-flex items-center gap-2 px-6 py-3 bg-brand-600 text-white rounded-xl font-bold shadow-lg shadow-brand-200 hover:bg-brand-700 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Product</span>
            </a>
        </div>

        {{-- Enhanced Filters Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-5 mb-8">
            <form action="{{ route('admin.products.index') }}" method="GET"
                  x-data="{ hasFilters: {{ request()->anyFilled(['search', 'category', 'color', 'material', 'status']) ? 'true' : 'false' }} }"
                  :class="hasFilters ? 'lg:grid-cols-6' : 'lg:grid-cols-5'"
                  class="grid grid-cols-1 md:grid-cols-2 gap-4" id="filterForm">
                <div class="lg:col-span-1">
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Search Products</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all" 
                               placeholder="Name or keyword..." />
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Category</label>
                    <select name="category" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all appearance-none cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Color</label>
                    <select name="color" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all appearance-none cursor-pointer">
                        <option value="">All Colors</option>
                        @foreach($colors as $color)
                            <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>{{ $color }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Material</label>
                    <select name="material" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all appearance-none cursor-pointer">
                        <option value="">All Materials</option>
                        @foreach($materials as $material)
                            <option value="{{ $material }}" {{ request('material') == $material ? 'selected' : '' }}>{{ $material }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Status</label>
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-neutral-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all appearance-none cursor-pointer">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>

                @if(request()->anyFilled(['search', 'category', 'color', 'material', 'status']))
                <div class="flex items-end">
                    <a href="{{ route('admin.products.index') }}" class="w-full text-center px-4 py-2.5 text-xs font-bold text-red-500 hover:text-red-600 transition-colors bg-red-50 rounded-xl">
                        Clear All
                    </a>
                </div>
                @endif
            </form>
        </div>

        {{-- Products Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50/50 border-b border-neutral-100">
                            <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Product Info</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden sm:table-cell">Category</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden lg:table-cell">Attributes</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Price & Stock</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($products as $p)
                        <tr class="group hover:bg-neutral-50/50 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 rounded-xl overflow-hidden shadow-sm ring-1 ring-neutral-100 flex-shrink-0">
                                        @if($p->image)
                                            <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                        @else
                                            <div class="w-full h-full bg-neutral-100 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-neutral-800 text-sm mb-0.5 leading-tight">{{ $p->name }}</p>
                                        <p class="text-[11px] text-neutral-400 truncate max-w-[150px]">{{ Str::limit($p->description, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <span class="px-2.5 py-1 rounded-md bg-brand-50 text-brand-700 text-[10px] font-bold uppercase tracking-wider">{{ $p->category->name ?? 'Uncategorized' }}</span>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-neutral-200"></span>
                                        <span class="text-xs text-neutral-600">{{ $p->color ?: 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-neutral-200"></span>
                                        <span class="text-xs text-neutral-600">{{ $p->material ?: 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-neutral-900">${{ number_format($p->price_per_day, 2) }}<span class="text-[10px] font-normal text-neutral-400 ml-0.5">/day</span></span>
                                    <span class="text-[11px] font-medium {{ $p->total_quantity <= 5 ? 'text-amber-600' : 'text-neutral-500' }}">{{ $p->total_quantity }} units in stock</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $p->status === 'available' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $p->status === 'available' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $p) }}" 
                                       class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-brand-50 hover:text-brand-600 transition-all duration-200" title="Edit">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button @click="deleteId = '{{ $p->id }}'; deleteModalOpen = true" 
                                            class="p-2 rounded-lg bg-neutral-50 text-neutral-400 hover:bg-red-50 hover:text-red-600 transition-all duration-200" title="Delete">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-neutral-800">No products found</h3>
                                    <p class="text-neutral-400 text-sm max-w-xs mt-1">Try adjusting your filters or search terms to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="px-6 py-4 bg-neutral-50/30 border-t border-neutral-100">
                {{ $products->links() }}
            </div>
            @endif
        </div>

        {{-- Delete Confirmation Modal --}}
        {{-- Backdrop: own transition so backdrop-filter renders independently --}}
        <template x-teleport="body">
        <div x-show="deleteModalOpen"
             x-cloak
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[69] bg-neutral-900/60 backdrop-blur-md"
             @click="deleteModalOpen = false"></div>
        </template>

        {{-- Card: own scale + fade transition --}}
        <template x-teleport="body">
        <div x-show="deleteModalOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 pointer-events-none">

            <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-8 text-center pointer-events-auto">

                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-12">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>

                <h3 class="text-2xl font-bold text-neutral-900 mb-2">Delete Product?</h3>
                <p class="text-neutral-500 mb-8 px-4">This product will be moved to trash. You can restore it later if needed.</p>

                <div class="flex flex-col gap-3">
                    <form :action="'{{ route('admin.products.index') }}/' + deleteId" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-4 bg-red-500 text-white rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-600 hover:shadow-xl transition-all">
                            Yes, Move to Trash
                        </button>
                    </form>
                    <button @click="deleteModalOpen = false" class="w-full px-6 py-4 bg-neutral-50 text-neutral-600 rounded-2xl font-bold hover:bg-neutral-100 transition-all">
                        No, Keep it
                    </button>
                </div>
            </div>
        </div>
        </template>

    </div>

</x-layout.admin-layout>
