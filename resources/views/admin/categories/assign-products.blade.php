<x-layout.admin-layout>
    <x-slot:title>Assign Products — {{ $category->name }}</x-slot:title>
    <x-slot:pageTitle>Catalogue / Assign Products</x-slot:pageTitle>

    {{-- Alpine scope: only manages checkbox state --}}
    <div
        x-data="{
            selected: [],
            toggleAll(e) {
                const ids = Array.from(document.querySelectorAll('[data-product-id]')).map(el => Number(el.dataset.productId));
                if (e.target.checked) {
                    this.selected = [...new Set([...this.selected, ...ids])];
                } else {
                    this.selected = this.selected.filter(id => !ids.includes(id));
                }
            },
            allSelected() {
                const ids = Array.from(document.querySelectorAll('[data-product-id]')).map(el => Number(el.dataset.productId));
                return ids.length > 0 && ids.every(id => this.selected.includes(id));
            }
        }"
    >

        {{-- Back + Title --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.categories.index') }}"
               class="w-10 h-10 rounded-xl bg-white border border-neutral-100 shadow-sm flex items-center justify-center text-neutral-400 hover:text-brand-600 hover:border-brand-100 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-3xl font-display font-bold text-neutral-900 tracking-tight">Assign Products</h2>
                <p class="text-neutral-400 text-sm mt-1 font-medium">Select products to move into this category</p>
            </div>
        </div>

        {{-- Category banner --}}
        <div class="bg-gradient-to-r from-brand-600 to-brand-700 rounded-2xl p-6 mb-8 flex items-center gap-5 shadow-lg shadow-brand-100">
            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-3xl flex-shrink-0">
                {{ $category->icon ?: '📦' }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold text-brand-200 uppercase tracking-widest mb-0.5">Target Category</p>
                <h3 class="text-xl font-bold text-white truncate">{{ $category->name }}</h3>
                @if($category->description)
                    <p class="text-brand-100 text-sm mt-0.5 truncate">{{ $category->description }}</p>
                @endif
            </div>
            <div class="hidden sm:flex flex-col items-end gap-2 flex-shrink-0">
                <div class="text-right">
                    <p class="text-[10px] font-bold text-brand-200 uppercase tracking-widest mb-0.5">Currently Has</p>
                    <p class="text-2xl font-bold text-white">{{ $category->products()->count() }} <span class="text-sm font-normal text-brand-200">items</span></p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-brand-200 uppercase tracking-widest mb-0.5">Total Products</p>
                    <p class="text-2xl font-bold text-white">{{ $total }} <span class="text-sm font-normal text-brand-200">in DB</span></p>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="mb-6 px-5 py-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-sm font-medium">
            {{ session('error') }}
        </div>
        @endif

        {{-- ───── Search / Filter (GET form) ───── --}}
        <form
            id="searchForm"
            method="GET"
            action="{{ route('admin.categories.assign-products.show', $category) }}"
            class="bg-white rounded-2xl shadow-sm border border-neutral-100 p-5 mb-6"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

                {{-- Search by name --}}
                <div class="lg:col-span-2">
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Search Products</label>
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Name or description..."
                            class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-300 transition-all"
                        />
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                {{-- Filter by current category --}}
                <div>
                    <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-1">Current Category</label>
                    <select name="filter_category" onchange="document.getElementById('searchForm').submit()"
                            class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl text-sm focus:ring-2 focus:ring-brand-500/20 appearance-none cursor-pointer transition-all">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat->id }}" {{ $filterCat !== '' && (int)$filterCat === $cat->id ? 'selected' : '' }}>{{ $cat->icon ?: '📦' }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-bold hover:bg-brand-700 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search
                    </button>
                    @if($search || $filterCat)
                    <a href="{{ route('admin.categories.assign-products.show', $category) }}"
                       class="inline-flex items-center justify-center px-3 py-2.5 bg-red-50 text-red-500 rounded-xl text-xs font-bold hover:bg-red-100 transition-all" title="Clear filters">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                </div>

            </div>

            {{-- Result summary --}}
            <div class="mt-4 flex items-center gap-3 flex-wrap">
                <span class="text-xs text-neutral-400">
                    <span class="font-bold text-neutral-700">{{ $products->total() }}</span> {{ Str::plural('product', $products->total()) }} found
                    @if($products->total() !== $total)
                        <span class="text-neutral-300 mx-1">·</span> <span class="font-bold text-neutral-700">{{ $total }}</span> total in DB
                    @endif
                </span>
                @if($search)
                    <span class="px-2.5 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold rounded-md uppercase tracking-wider">
                        "{{ $search }}"
                    </span>
                @endif
                @if($filterCat)
                    @php $selectedCatName = $allCategories->firstWhere('id', $filterCat)?->name; @endphp
                    @if($selectedCatName)
                    <span class="px-2.5 py-1 bg-neutral-100 text-neutral-600 text-[10px] font-bold rounded-md uppercase tracking-wider">
                        {{ $selectedCatName }}
                    </span>
                    @endif
                @endif
            </div>
        </form>

        {{-- ───── Assignment form (POST) wraps the table ───── --}}
        <form
            id="assignForm"
            action="{{ route('admin.categories.assign-products', $category) }}"
            method="POST"
        >
            @csrf

            {{-- Hidden inputs built from Alpine selected array --}}
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="product_ids[]" :value="id" />
            </template>

            <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden mb-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50/50 border-b border-neutral-100">
                                <th class="px-5 py-4 w-12">
                                    <input
                                        type="checkbox"
                                        :checked="allSelected()"
                                        @change="toggleAll($event)"
                                        class="w-4 h-4 rounded border-neutral-300 text-brand-600 focus:ring-brand-500/30 cursor-pointer"
                                        title="Select all visible"
                                    />
                                </th>
                                <th class="px-4 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Product</th>
                                <th class="px-4 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden sm:table-cell">Current Category</th>
                                <th class="px-4 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden md:table-cell">Price / Day</th>
                                <th class="px-4 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em] hidden lg:table-cell">Stock</th>
                                <th class="px-4 py-4 text-[11px] font-bold text-neutral-400 uppercase tracking-[0.2em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($products as $p)
                            <tr
                                data-product-id="{{ $p->id }}"
                                class="group transition-all duration-150 cursor-pointer"
                                :class="selected.includes({{ $p->id }}) ? 'bg-brand-50/70' : 'hover:bg-neutral-50/60'"
                                @click="selected.includes({{ $p->id }})
                                    ? selected = selected.filter(i => i !== {{ $p->id }})
                                    : selected.push({{ $p->id }})"
                            >
                                {{-- Checkbox --}}
                                <td class="px-5 py-4" @click.stop>
                                    <input
                                        type="checkbox"
                                        :checked="selected.includes({{ $p->id }})"
                                        @change="$event.target.checked
                                            ? selected.push({{ $p->id }})
                                            : selected = selected.filter(i => i !== {{ $p->id }})"
                                        class="w-4 h-4 rounded border-neutral-300 text-brand-600 focus:ring-brand-500/30 cursor-pointer"
                                    />
                                </td>

                                {{-- Image + Name --}}
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative w-11 h-11 rounded-xl overflow-hidden shadow-sm ring-1 ring-neutral-100 flex-shrink-0">
                                            @if($p->image)
                                                <img src="{{ asset($p->image) }}" alt="{{ $p->name }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                            @else
                                                <div class="w-full h-full bg-neutral-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-neutral-800 text-sm leading-tight truncate max-w-[180px]">{{ $p->name }}</p>
                                            <p class="text-[11px] text-neutral-400 truncate max-w-[180px] mt-0.5">{{ Str::limit($p->description, 38) }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Current Category --}}
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    @if($p->category_id === $category->id)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold uppercase tracking-wider">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            {{ $p->category->name }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md bg-neutral-100 text-neutral-500 text-[10px] font-bold uppercase tracking-wider">
                                            {{ $p->category->name ?? 'Uncategorized' }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Price --}}
                                <td class="px-4 py-4 hidden md:table-cell">
                                    <span class="font-bold text-neutral-800 text-sm">${{ number_format($p->price_per_day, 2) }}</span>
                                    <span class="text-[10px] text-neutral-400 ml-0.5">/day</span>
                                </td>

                                {{-- Stock --}}
                                <td class="px-4 py-4 hidden lg:table-cell">
                                    <span class="text-sm font-medium {{ $p->total_quantity <= 5 ? 'text-amber-600' : 'text-neutral-600' }}">
                                        {{ $p->total_quantity }} units
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $p->status === 'available' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $p->status === 'available' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $p->status }}
                                    </span>
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
                                        <p class="text-neutral-400 text-sm max-w-xs mt-1">
                                            @if($search || $filterCat)
                                                Try adjusting your search or clearing the filters.
                                            @else
                                                Create some products first before assigning them to categories.
                                            @endif
                                        </p>
                                        @if($search || $filterCat)
                                        <a href="{{ route('admin.categories.assign-products.show', $category) }}"
                                           class="mt-4 px-5 py-2 bg-neutral-100 text-neutral-600 rounded-xl text-sm font-bold hover:bg-neutral-200 transition-all">
                                            Clear Filters
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="px-6 py-4 bg-neutral-50/30 border-t border-neutral-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-neutral-400">
                    Showing <span class="font-bold text-neutral-600">{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                    of <span class="font-bold text-neutral-600">{{ $products->total() }}</span> products
                </p>
                <div>{{ $products->links() }}</div>
            </div>
            @endif
            </div>

            {{-- ───── Action bar below products ───── --}}
            <div
                class="bg-neutral-900 rounded-2xl shadow-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 border border-neutral-800 mt-6"
                x-show="selected.length > 0"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
            >
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-brand-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">
                            <span x-text="selected.length"></span>
                            <span x-text="selected.length === 1 ? 'product' : 'products'"></span> selected
                        </p>
                        <p class="text-neutral-400 text-xs mt-0.5">
                            Will be moved to
                            <span class="text-brand-400 font-semibold">{{ $category->icon ?: '📦' }} {{ $category->name }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="button" @click="selected = []"
                            class="flex-1 sm:flex-none px-5 py-2.5 bg-neutral-800 text-neutral-300 rounded-xl text-sm font-bold hover:bg-neutral-700 transition-all">
                        Clear
                    </button>
                    <button type="submit" form="assignForm"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-brand-900/40 hover:bg-brand-500 hover:-translate-y-0.5 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Assign to {{ $category->name }}
                    </button>
                </div>
            </div>

        </form>

    </div>

</x-layout.admin-layout>
