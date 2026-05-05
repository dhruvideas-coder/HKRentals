<x-layout.app-layout>
    <x-slot:title>Our Collection</x-slot>
    <x-slot:metaDescription>Browse SK Rentals' premium wedding and event rental collection. Elegant furniture, decor, and accessories for your special day in Knoxville.</x-slot>


{{-- ══════════════════════════════════════════════════════════
     PAGE HERO — with background image
══════════════════════════════════════════════════════════ --}}
<section class="relative h-64 sm:h-80 flex items-center overflow-hidden" aria-labelledby="products-page-heading">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/product-tableware.png') }}"
             alt="Elegant wedding table setting"
             class="w-full h-full object-cover object-center"
             loading="eager" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/80 to-neutral-900/50"></div>
    </div>
    <div class="relative z-10 container-sk">
        <nav class="flex items-center gap-2 text-sm text-white/50 mb-3" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition-base">Home</a>
            <span>/</span>
            <span class="text-white/80">Products</span>
        </nav>
        <h1 id="products-page-heading" class="font-display text-4xl sm:text-5xl font-bold text-white">
            Our <span class="text-gradient-gold">Collection</span>
        </h1>
        <p class="text-neutral-300 mt-2 text-base">Premium rentals for your perfect event.</p>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     FILTERS + PRODUCT GRID
══════════════════════════════════════════════════════════ --}}
<x-section class="py-12 bg-cream" aria-label="Product listing">
    <x-container>
        <div class="flex flex-col gap-8">

            {{-- ── Horizontal Filter Bar ── --}}
            <div class="card p-6 mb-4 lg:mb-8">
                <form action="{{ route('products') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                        
                        {{-- Category --}}
                        <div>
                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2 px-1">Category</label>
                            <select name="category" class="form-input text-sm h-11" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Max Price --}}
                        <div>
                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2 px-1">Max Price <span class="normal-case font-medium">($/day)</span></label>
                            <div class="relative group">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400 text-sm transition-colors group-focus-within:text-brand-500">$</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" 
                                       class="form-input text-sm h-11 pl-8" onchange="this.form.submit()" />
                            </div>
                        </div>

                        {{-- Color --}}
                        <div>
                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2 px-1">Color</label>
                            <select name="color" class="form-input text-sm h-11" onchange="this.form.submit()">
                                <option value="">All Colors</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                                        {{ ucfirst($color) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Material --}}
                        <div>
                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2 px-1">Material</label>
                            <select name="material" class="form-input text-sm h-11" onchange="this.form.submit()">
                                <option value="">All Materials</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material }}" {{ request('material') == $material ? 'selected' : '' }}>
                                        {{ ucfirst($material) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sort --}}
                        <div>
                            <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-2 px-1">Sort By</label>
                            <select name="sort" class="form-input text-sm h-11" onchange="this.form.submit()">
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                                <option value="newest"   {{ request('sort') == 'newest'   ? 'selected' : '' }}>Newest First</option>
                                <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>Price: Low → High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                            </select>
                        </div>

                    </div>

                    @php
                        $hasFilters = request()->anyFilled(['category', 'max_price', 'color', 'material']) || request('sort') != 'featured';
                    @endphp

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-neutral-50">
                        <div class="text-sm text-neutral-500">
                            Showing <span class="font-semibold text-neutral-900">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> of <span class="font-semibold text-neutral-900">{{ $products->total() }}</span> products
                        </div>
                        
                        @if($hasFilters)
                        <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-sm font-medium text-brand-600 hover:text-brand-700 transition-base group">
                            <span class="w-5 h-5 rounded-full bg-brand-50 flex items-center justify-center group-hover:bg-brand-100 transition-base">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </span>
                            Clear All Filters
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ── Product Grid ── --}}
            <div class="min-w-0">
                <x-product.grid :products="$products" />

                {{-- Pagination --}}
                <div class="mt-12 pt-8 border-t border-neutral-100">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </x-container>
</x-section>

</x-layout.app-layout>
