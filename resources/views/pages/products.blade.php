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
        <div class="flex flex-col lg:flex-row gap-8">

            <aside class="lg:w-60 flex-shrink-0" aria-label="Product filters">
                <form action="{{ route('products') }}" method="GET" class="card p-5 sticky top-24">
                    <h2 class="font-semibold text-neutral-800 text-sm uppercase tracking-wider mb-5">Filters</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Category</label>
                            <select name="category" class="form-input text-sm" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Max Price ($/day)</label>
                            <x-input name="max_price" type="number" value="{{ request('max_price') }}" placeholder="Any Price" onchange="this.form.submit()" />
                        </div>

                        {{-- Color Filter --}}
                        <div>
                            <label class="form-label">Color</label>
                            <select name="color" class="form-input text-sm" onchange="this.form.submit()">
                                <option value="">All Colors</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                                        {{ ucfirst($color) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Material Filter --}}
                        <div>
                            <label class="form-label">Material</label>
                            <select name="material" class="form-input text-sm" onchange="this.form.submit()">
                                <option value="">All Materials</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material }}" {{ request('material') == $material ? 'selected' : '' }}>
                                        {{ ucfirst($material) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <a href="{{ route('products') }}" class="btn btn-ghost w-full text-neutral-500 text-sm block text-center">Clear All</a>
                    </div>

                </form>
            </aside>

            {{-- ── Product Grid ── --}}
            <div class="flex-1 min-w-0">

                {{-- Sort bar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-3 mb-7">
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-neutral-500 whitespace-nowrap">Sort by:</label>
                        <select class="form-input w-44 text-sm"
                                onchange="window.location.href = '{{ route('products', array_merge(request()->query(), ['sort' => ''])) }}'.replace('sort=', 'sort=' + this.value)">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="newest"   {{ request('sort') == 'newest'   ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>Price: Low → High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                <x-product.grid :products="$products" />

                {{-- Pagination --}}
                <div class="border-t border-neutral-200">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </x-container>
</x-section>

</x-layout.app-layout>
