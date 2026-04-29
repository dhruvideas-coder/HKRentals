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

            {{-- ── Sidebar Filters ── --}}
            <aside class="lg:w-60 flex-shrink-0" aria-label="Product filters">
                <form action="{{ route('products') }}" method="GET" class="card p-5 sticky top-24">
                    <h2 class="font-semibold text-neutral-800 text-sm uppercase tracking-wider mb-5">Filters</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Category</label>
                            <select name="category" class="form-input text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Max Price ($/day)</label>
                            <x-input name="max_price" type="number" value="{{ request('max_price') }}" placeholder="Any Price" />
                        </div>

                        <x-button type="submit" class="w-full mt-2">Apply Filters</x-button>
                        <a href="{{ route('products') }}" class="btn btn-ghost w-full text-neutral-500 text-sm block text-center">Clear All</a>
                    </div>

                    {{-- Category quick-links --}}
                    <div class="mt-6 pt-5 border-t border-neutral-100">
                        <p class="text-xs font-semibold text-neutral-400 uppercase tracking-widest mb-3">Browse By</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categories as $cat)
                                <a href="{{ route('products', ['category' => $cat->slug]) }}" class="badge badge-neutral hover:bg-brand-50 hover:text-brand-700 transition-base">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </form>
            </aside>

            {{-- ── Product Grid ── --}}
            <div class="flex-1 min-w-0">

                {{-- Sort + result count bar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-7">
                    <p class="text-sm text-neutral-500 font-medium">
                        Showing <span class="text-neutral-800 font-semibold">{{ count($products) }}</span> items
                    </p>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-neutral-500 whitespace-nowrap">Sort by:</label>
                        <select class="form-input w-44 text-sm">
                            <option>Featured</option>
                            <option>Newest First</option>
                            <option>Price: Low → High</option>
                            <option>Price: High → Low</option>
                        </select>
                    </div>
                </div>

                {{-- Grid --}}
                <x-product.grid :products="$products" />

                {{-- Pagination placeholder --}}
                <div class="flex justify-center mt-10">
                    <nav class="flex items-center gap-1" aria-label="Pagination">
                        <button class="w-9 h-9 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 transition-base flex items-center justify-center" aria-label="Previous">&laquo;</button>
                        <button class="w-9 h-9 rounded-lg bg-brand-500 text-white text-sm font-semibold shadow-sm" aria-current="page">1</button>
                        <button class="w-9 h-9 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 transition-base">2</button>
                        <button class="w-9 h-9 rounded-lg border border-neutral-200 text-sm text-neutral-500 hover:bg-neutral-50 transition-base flex items-center justify-center" aria-label="Next">&raquo;</button>
                    </nav>
                </div>

            </div>
        </div>
    </x-container>
</x-section>

</x-layout.app-layout>
