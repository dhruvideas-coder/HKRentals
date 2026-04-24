@extends('layouts.app')

@section('title', 'Our Collection')
@section('meta_description', 'Browse SK Rentals\' premium wedding and event rental collection. Elegant furniture, decor, and accessories for your special day in Knoxville.')

@section('content')

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
<section class="py-12 bg-cream" aria-label="Product listing">
    <div class="container-sk">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ── Sidebar Filters ── --}}
            <aside class="lg:w-60 flex-shrink-0" aria-label="Product filters">
                <div class="card p-5 sticky top-24">
                    <h2 class="font-semibold text-neutral-800 text-sm uppercase tracking-wider mb-5">Filters</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Category</label>
                            <select class="form-input text-sm">
                                <option>All Categories</option>
                                <option>Seating</option>
                                <option>Ceremony</option>
                                <option>Tableware</option>
                                <option>Lighting</option>
                                <option>Furniture</option>
                                <option>Decor</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Event Date</label>
                            <input type="date" class="form-input text-sm" />
                        </div>

                        <div>
                            <label class="form-label">Price Range</label>
                            <select class="form-input text-sm">
                                <option>Any Price</option>
                                <option>Under $50/day</option>
                                <option>$50–$150/day</option>
                                <option>$150+/day</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-full mt-2">Apply Filters</button>
                        <button class="btn btn-ghost w-full text-neutral-500 text-sm">Clear All</button>
                    </div>

                    {{-- Category quick-links --}}
                    <div class="mt-6 pt-5 border-t border-neutral-100">
                        <p class="text-xs font-semibold text-neutral-400 uppercase tracking-widest mb-3">Browse By</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Seating','Lighting','Tableware','Decor','Ceremony','Furniture'] as $cat)
                            <span class="badge badge-neutral cursor-pointer hover:bg-brand-50 hover:text-brand-700 transition-base">{{ $cat }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            {{-- ── Product Grid ── --}}
            <div class="flex-1 min-w-0">

                {{-- Sort + result count bar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-7">
                    <p class="text-sm text-neutral-500 font-medium">
                        Showing <span class="text-neutral-800 font-semibold">6</span> items
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
                @php
                $products = [
                    ['image'=>'product-chairs.png',   'name'=>'Gold Chiavari Chairs',  'cat'=>'Seating',   'price'=>'$4',   'desc'=>'Elegant gold chiavari chairs with white cushioned seats. Perfect for weddings and formal events.'],
                    ['image'=>'product-arch.png',      'name'=>'Floral Wedding Arch',   'cat'=>'Ceremony',  'price'=>'$120', 'desc'=>'Stunning floral arch with fresh white roses and eucalyptus. Makes a breathtaking ceremony backdrop.'],
                    ['image'=>'product-tableware.png', 'name'=>'Luxury Table Setting',  'cat'=>'Tableware', 'price'=>'$18',  'desc'=>'Complete premium table setting with white and gold dinnerware, crystal glasses, and silverware.'],
                    ['image'=>'product-lighting.png',  'name'=>'String Light Canopy',   'cat'=>'Lighting',  'price'=>'$85',  'desc'=>'Romantic Edison bulb and fairy light canopy for outdoor receptions. Creates magical ambiance.'],
                    ['image'=>'product-lounge.png',    'name'=>'White Lounge Suite',    'cat'=>'Furniture', 'price'=>'$200', 'desc'=>'Luxurious white tufted sofa and armchair set with gold accent legs. Ideal for reception lounge areas.'],
                    ['image'=>'product-backdrop.png',  'name'=>'Floral Hex Backdrop',   'cat'=>'Decor',     'price'=>'$95',  'desc'=>'Geometric hexagonal backdrop with white linen and lush floral arrangements. Perfect photo backdrop.'],
                ];
                @endphp

                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                    <article class="group card overflow-hidden hover:shadow-elevated transition-all duration-300 hover:-translate-y-1">

                        {{-- Image --}}
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <img src="{{ asset('images/' . $product['image']) }}"
                                 alt="{{ $product['name'] }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy" />

                            {{-- Category badge --}}
                            <span class="absolute top-3 left-3 badge badge-gold text-xs">{{ $product['cat'] }}</span>

                            {{-- Quick-enquire overlay on hover --}}
                            <div class="absolute inset-0 bg-brand-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <a href="#" class="btn bg-white text-brand-700 hover:bg-brand-50 border-transparent btn-sm shadow-lg translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                    Quick Enquire
                                </a>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-5">
                            <h3 class="font-display font-semibold text-neutral-900 text-lg mb-1.5 leading-snug">
                                {{ $product['name'] }}
                            </h3>
                            <p class="text-neutral-500 text-sm mb-4 leading-relaxed line-clamp-2">
                                {{ $product['desc'] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-brand-600 text-xl">{{ $product['price'] }}</span>
                                    <span class="text-sm font-normal text-neutral-400">/day</span>
                                </div>
                                <button class="btn btn-primary btn-sm">Enquire</button>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

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
    </div>
</section>

@endsection
