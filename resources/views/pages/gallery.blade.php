<x-layout.app-layout>
    <x-slot:title>Photo Gallery</x-slot>
    <x-slot:metaDescription>Browse the HK Rentals photo gallery — stunning weddings, corporate events, outdoor parties and more across Knoxville, TN.</x-slot>

{{-- ══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[55vh] flex items-center overflow-hidden" aria-labelledby="gallery-hero-heading">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/about-warehouse.png') }}"
             alt="HK Rentals gallery of beautiful events"
             class="w-full h-full object-cover object-center"
             loading="eager" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/92 via-neutral-950/72 to-neutral-900/35"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/50 via-transparent to-transparent"></div>
    </div>
    <div class="absolute bottom-0 right-20 w-80 h-80 rounded-full bg-brand-500/8 blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 container-sk py-24 lg:py-32 w-full">
        <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-5">
                <div class="h-px w-10 bg-brand-400"></div>
                <span class="text-brand-300 text-sm font-medium uppercase tracking-widest">Photo Gallery</span>
            </div>
            <h1 id="gallery-hero-heading" class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Events Brought<br/>
                <span class="text-gradient-gold">to Life</span>
            </h1>
            <p class="text-neutral-300 text-lg leading-relaxed max-w-xl">
                A curated look at the celebrations, gatherings, and milestones we've helped create across Knoxville and beyond.
            </p>
        </div>
    </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     GALLERY WITH FILTER
══════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28" aria-labelledby="gallery-grid-heading"
    x-data="{
        activeFilter: 'all',
        photos: [],
        get filtered() {
            if (this.activeFilter === 'all') return this.photos;
            return this.photos.filter(p => p.category === this.activeFilter);
        },
    }"
    x-init="
        photos = [
            { src: '{{ asset('images/products/product-arch.png') }}',               alt: 'Gold floral wedding arch',             category: 'weddings',  span: 'tall'   },
            { src: '{{ asset('images/products/product-chairs.png') }}',             alt: 'Gold chiavari chairs reception',       category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/product-backdrop.png') }}',           alt: 'Floral hexagon backdrop',              category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/product-tableware.png') }}',          alt: 'Luxury table setting with gold',       category: 'tableware', span: 'wide'   },
            { src: '{{ asset('images/products/product-lounge.png') }}',             alt: 'White lounge furniture setup',         category: 'corporate', span: 'normal' },
            { src: '{{ asset('images/products/product-lighting.png') }}',           alt: 'String light canopy installation',     category: 'lighting',  span: 'tall'   },
            { src: '{{ asset('images/products/arch-gold-metal.png') }}',            alt: 'Gold metal ceremony arch',             category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/arch-rustic-wooden.png') }}',         alt: 'Rustic wooden arch with greenery',     category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/ceremony-unity-candle.png') }}',      alt: 'Ceremony unity candle setup',          category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/chair-bentwood-black.png') }}',       alt: 'Black bentwood chairs',                category: 'corporate', span: 'normal' },
            { src: '{{ asset('images/products/chair-crossback-silver.png') }}',     alt: 'Silver crossback chairs',              category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/chair-folding-white.png') }}',        alt: 'White folding chairs outdoor',         category: 'outdoor',   span: 'normal' },
            { src: '{{ asset('images/products/chair-ghost-rosegold.png') }}',       alt: 'Rose gold ghost chairs',               category: 'weddings',  span: 'tall'   },
            { src: '{{ asset('images/products/decor-floral-wall.png') }}',          alt: 'Lush floral wall backdrop',            category: 'weddings',  span: 'wide'   },
            { src: '{{ asset('images/products/decor-gold-sphere.png') }}',          alt: 'Gold sphere decorative accents',       category: 'decor',     span: 'normal' },
            { src: '{{ asset('images/products/decor-rosegold-candles.png') }}',     alt: 'Rose gold candle centrepiece',         category: 'decor',     span: 'normal' },
            { src: '{{ asset('images/products/furniture-farm-table.png') }}',       alt: 'Rustic farm dining table',             category: 'outdoor',   span: 'wide'   },
            { src: '{{ asset('images/products/furniture-sweetheart-table.png') }}', alt: 'Sweetheart table for two',             category: 'weddings',  span: 'normal' },
            { src: '{{ asset('images/products/lighting-fairy-curtain.png') }}',     alt: 'Fairy light curtain backdrop',         category: 'lighting',  span: 'tall'   },
            { src: '{{ asset('images/products/lighting-gold-lanterns.png') }}',     alt: 'Gold hanging lanterns',                category: 'lighting',  span: 'normal' },
            { src: '{{ asset('images/products/tableware-crystal-glass.png') }}',    alt: 'Crystal glassware collection',         category: 'tableware', span: 'normal' },
            { src: '{{ asset('images/products/tableware-gold-flatware.png') }}',    alt: 'Gold flatware dinner setting',         category: 'tableware', span: 'normal' },
            { src: '{{ asset('images/products/tableware-silver-charger.png') }}',   alt: 'Silver charger plate table setting',   category: 'tableware', span: 'wide'   },
            { src: '{{ asset('images/ceremony.png') }}',                            alt: 'Outdoor wedding ceremony setup',       category: 'weddings',  span: 'tall'   },
        ];
    "
>

    <div class="container-sk">

        <div class="text-center mb-12">
            <span class="badge badge-gold mb-3">Our Portfolio</span>
            <h2 id="gallery-grid-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Moments We've <span class="text-gradient-gold">Made Special</span>
            </h2>
            <p class="text-neutral-500 max-w-md mx-auto text-base">
                Browse our portfolio by category.
            </p>
        </div>

        {{-- Filter tabs --}}
        <div class="flex flex-wrap justify-center gap-2 mb-10" role="tablist" aria-label="Gallery filters">
            @foreach([
                ['all',       'All Photos',    ''],
                ['weddings',  'Weddings',       '💍'],
                ['outdoor',   'Outdoor',        '🌿'],
                ['corporate', 'Corporate',      '🏢'],
                ['lighting',  'Lighting',       '✨'],
                ['tableware', 'Tableware',      '🍽️'],
                ['decor',     'Décor',          '🌸'],
            ] as [$val, $label, $emoji])
            <button
                @click="activeFilter = '{{ $val }}'"
                :class="activeFilter === '{{ $val }}'
                    ? 'bg-brand-600 text-white border-brand-600 shadow-glow'
                    : 'bg-white text-neutral-600 border-neutral-200 hover:border-brand-300 hover:text-brand-600'"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border text-sm font-medium transition-all duration-200"
                role="tab"
                :aria-selected="activeFilter === '{{ $val }}'">
                @if($emoji) <span>{{ $emoji }}</span> @endif
                {{ $label }}
                <span x-show="activeFilter === '{{ $val }}' && filtered.length > 0"
                      class="ml-0.5 bg-white/25 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center"
                      x-text="filtered.length"></span>
            </button>
            @endforeach
        </div>

        {{-- Masonry grid --}}
        <div class="columns-2 sm:columns-3 lg:columns-4 gap-3 space-y-3"
             x-ref="gallery">
            <template x-for="(photo, index) in filtered" :key="photo.src + index">
                <div class="break-inside-avoid overflow-hidden rounded-xl bg-neutral-100 relative shadow-sm"
                     :class="photo.span === 'tall' ? 'mb-3' : ''">
                    <img :src="photo.src"
                         :alt="photo.alt"
                         class="w-full object-cover block"
                         :class="photo.span === 'tall' ? 'h-80' : 'h-48'"
                         loading="lazy" />
                </div>
            </template>

            {{-- Empty state --}}
            <template x-if="filtered.length === 0">
                <div class="col-span-full py-20 text-center text-neutral-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                    <p class="text-sm">No photos in this category yet.</p>
                </div>
            </template>
        </div>

    </div>


</section>

{{-- ══════════════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════════════ --}}
<section class="relative py-20 overflow-hidden" aria-labelledby="gallery-cta-heading">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/products/decor-floral-wall.png') }}"
             alt="Floral decor wall"
             class="w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/92 to-brand-800/85"></div>
    </div>
    <div class="relative z-10 container-sk text-center">
        <span class="badge badge-gold mb-5">Your Event, Your Photos</span>
        <h2 id="gallery-cta-heading" class="font-display text-3xl sm:text-4xl font-semibold text-white mb-5 leading-tight">
            Want Your Event to Look<br class="hidden sm:block"/> This Beautiful?
        </h2>
        <p class="text-brand-100 mb-8 text-base max-w-lg mx-auto leading-relaxed">
            Browse our full collection and reserve your rental pieces today. Let's make your event one for the gallery.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('products') }}" class="btn btn-lg bg-white text-brand-700 hover:bg-brand-50 border-transparent shadow-elevated">
                Browse All Rentals
            </a>
            <a href="{{ route('contact') }}" class="btn btn-lg border-white/30 text-white hover:bg-white/10">
                Get in Touch
            </a>
        </div>
    </div>
</section>

</x-layout.app-layout>
