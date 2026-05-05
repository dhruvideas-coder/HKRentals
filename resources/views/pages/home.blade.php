<x-layout.app-layout>
    <x-slot:title>Welcome</x-slot>
    <x-slot:metaDescription>SK Rentals — Premium wedding and event rental items in Knoxville, Tennessee. Browse our elegant collection and make your special day unforgettable.</x-slot>


{{-- ══════════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden min-h-[92vh] flex items-center" aria-labelledby="hero-heading">

    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero.png') }}"
             alt="Elegant wedding reception hall with golden chandeliers"
             class="w-full h-full object-cover object-center"
             loading="eager"
             fetchpriority="high" />
        {{-- Gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/85 via-neutral-900/70 to-neutral-900/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/60 via-transparent to-transparent"></div>
    </div>

    {{-- Decorative accent glow --}}
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 container-sk py-28 lg:py-40 w-full">
        <div class="max-w-2xl">
            <span class="badge badge-gold mb-6 inline-flex text-xs tracking-widest uppercase">✦ Knoxville's Premier Rental Service</span>

            <h1 id="hero-heading" class="font-display text-4xl sm:text-5xl lg:text-[3.75rem] font-bold text-white leading-tight mb-6">
                Make Your <span class="text-gradient-gold">Wedding Day</span><br class="hidden sm:block" />
                Truly Unforgettable
            </h1>

            <p class="text-neutral-300 text-lg leading-relaxed mb-10 max-w-xl">
                Curated wedding &amp; event rental pieces — elegant furniture, stunning decor,
                and everything in between. Browse our collection and bring your vision to life.
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg shadow-glow">
                    Browse Collection
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#gallery" class="btn btn-lg text-white" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.25);backdrop-filter:blur(6px);">
                    View Gallery
                </a>
            </div>

            {{-- Trust badges --}}
            <div class="flex flex-wrap items-center gap-6 mt-12 text-sm text-neutral-300">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    500+ Happy Clients
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Quality Guaranteed
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Same-Day Availability
                </span>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-1.5 text-white/40 text-xs" aria-hidden="true">
        <span class="tracking-widest uppercase text-[10px]">Scroll</span>
        <div class="w-px h-8 bg-gradient-to-b from-white/40 to-transparent animate-pulse"></div>
    </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     FEATURE STRIP — Photo + Text split
══════════════════════════════════════════════════════════ --}}
<x-section class="bg-white" aria-labelledby="about-section-heading">
    <x-container>
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Image side --}}
            <div class="relative">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-elevated">
                    <img src="{{ asset('images/ceremony.png') }}"
                         alt="Outdoor wedding ceremony setup in Tennessee countryside"
                         class="w-full h-full object-cover"
                         loading="lazy" />
                </div>
                {{-- Floating badge --}}
                <div class="absolute -bottom-5 -right-5 bg-white rounded-xl shadow-card px-5 py-4 border border-neutral-100 hidden sm:block">
                    <p class="text-2xl font-bold text-brand-600 leading-none">10+</p>
                    <p class="text-xs text-neutral-500 mt-0.5 font-medium">Years of Experience</p>
                </div>
            </div>

            {{-- Text side --}}
            <div>
                <span class="badge badge-gold mb-4">About SK Rentals</span>
                <h2 id="about-section-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-5 leading-tight">
                    Knoxville's Most Trusted<br/>
                    <span class="text-gradient-gold">Event Rental Partner</span>
                </h2>
                <p class="text-neutral-500 text-base leading-relaxed mb-6">
                    From intimate backyard ceremonies to grand ballroom receptions, SK Rentals brings
                    your vision to life with a curated collection of premium furniture, decor, and event essentials.
                </p>
                <p class="text-neutral-500 text-base leading-relaxed mb-8">
                    We handle the details — delivery, setup, and pickup — so you can focus on celebrating
                    the moments that matter most.
                </p>
                <div class="grid grid-cols-2 gap-5 mb-8">
                    @foreach([['500+','Happy Couples'], ['200+','Rental Items'], ['10+','Years Experience'], ['5★','Average Rating']] as [$num, $label])
                    <div class="bg-neutral-50 rounded-xl p-4 border border-neutral-100">
                        <p class="text-2xl font-bold text-brand-600 font-display">{{ $num }}</p>
                        <p class="text-sm text-neutral-500 mt-0.5">{{ $label }}</p>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                    Explore Our Collection
                </a>
            </div>

        </div>
    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     FEATURED PRODUCTS GALLERY
══════════════════════════════════════════════════════════ --}}
<x-section id="gallery" class="bg-cream" aria-labelledby="products-section-heading">
    <x-container>

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">Our Collection</span>
            <h2 id="products-section-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Rentals That Set the Scene
            </h2>
            <p class="text-neutral-500 max-w-xl mx-auto text-base leading-relaxed">
                Handpicked pieces for every style — romantic, modern, rustic, or classic.
                Everything you need in one place.
            </p>
        </div>

        @php
        $items = [
            ['image' => 'product-chairs.png',    'name' => 'Gold Chiavari Chairs',  'category' => 'Seating',   'price' => '$4'],
            ['image' => 'product-arch.png',       'name' => 'Floral Wedding Arch',   'category' => 'Ceremony',  'price' => '$120'],
            ['image' => 'product-tableware.png',  'name' => 'Luxury Table Setting',  'category' => 'Tableware', 'price' => '$18'],
            ['image' => 'product-lighting.png',   'name' => 'String Light Canopy',   'category' => 'Lighting',  'price' => '$85'],
            ['image' => 'product-lounge.png',     'name' => 'White Lounge Suite',    'category' => 'Furniture', 'price' => '$200'],
            ['image' => 'product-backdrop.png',   'name' => 'Floral Hex Backdrop',   'category' => 'Decor',     'price' => '$95'],
        ];
        @endphp

        <x-product.grid :products="$items" />

        <div class="text-center mt-12">
            <a href="{{ route('products') }}" class="btn btn-outline btn-lg">
                View Full Collection
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     WHY CHOOSE US — Icon Grid
══════════════════════════════════════════════════════════ --}}
<x-section class="bg-white" aria-labelledby="features-heading">
    <x-container>
        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">Why SK Rentals</span>
            <h2 id="features-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Everything You Need for Your Perfect Event
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ([
                ['icon' => '🌸', 'title' => 'Curated Collection',   'desc' => 'Handpicked items that blend elegance and practicality for every style of event.'],
                ['icon' => '🚚', 'title' => 'Delivery & Setup',     'desc' => 'White-glove delivery and professional setup so you can focus on your guests.'],
                ['icon' => '✨', 'title' => 'Premium Quality',      'desc' => 'Every item is cleaned, inspected, and maintained to the highest standards.'],
                ['icon' => '💬', 'title' => 'Expert Consultation',  'desc' => 'Our team helps you choose the right pieces to match your vision perfectly.'],
                ['icon' => '📅', 'title' => 'Flexible Booking',     'desc' => 'Easy reservations with flexible date changes and cancellation options.'],
                ['icon' => '💛', 'title' => 'Knoxville Local',      'desc' => 'Proudly serving the Knoxville area — we know the venues and the community.'],
            ] as $f)
            <div class="card p-6 hover:shadow-elevated hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-2xl mb-4">{{ $f['icon'] }}</div>
                <h3 class="font-display text-lg font-semibold text-neutral-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-neutral-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </x-container>
</x-section>


{{-- ══════════════════════════════════════════════════════════
     CATEGORIES GRID
══════════════════════════════════════════════════════════ --}}
<x-section class="bg-cream" aria-labelledby="categories-heading">
    <x-container>
        <div class="text-center mb-12">
            <span class="badge badge-gold mb-3">Browse By Style</span>
            <h2 id="categories-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-3">
                Shop by Category
            </h2>
            <p class="text-neutral-500 max-w-md mx-auto text-base">
                Find exactly what you need for every part of your perfect event.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach([
                ['name'=>'Seating',   'image'=>asset('images/product-chairs.png'),   'count'=>12, 'slug'=>'seating'],
                ['name'=>'Ceremony',  'image'=>asset('images/product-arch.png'),      'count'=>8,  'slug'=>'ceremony'],
                ['name'=>'Tableware', 'image'=>asset('images/product-tableware.png'), 'count'=>24, 'slug'=>'tableware'],
                ['name'=>'Lighting',  'image'=>asset('images/product-lighting.png'),  'count'=>10, 'slug'=>'lighting'],
                ['name'=>'Furniture', 'image'=>asset('images/product-lounge.png'),    'count'=>15, 'slug'=>'furniture'],
                ['name'=>'Decor',     'image'=>asset('images/product-backdrop.png'),  'count'=>20, 'slug'=>'decor'],
            ] as $cat)
            <x-category.card
                :name="$cat['name']"
                :image="$cat['image']"
                :count="$cat['count']"
                :href="route('products') . '?category=' . $cat['slug']"
            />
            @endforeach
        </div>
    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     TESTIMONIALS — Real Stories, Real Joy
══════════════════════════════════════════════════════════ --}}
<section class="reviews-section-bg py-20 sm:py-28" aria-labelledby="testimonials-heading"
    x-data="{
        current: 0,
        perPage: 3,
        reviews: [
            { initials: 'EW', name: 'Emily & James Watson',   event: 'Wedding · May 2025',        rating: 5, tag: 'Verified Client',  color: '#c8903a', text: 'SK Rentals made our wedding day absolutely magical. The gold chiavari chairs and floral arch were beyond beautiful. Everything arrived perfectly on time and the setup team was so kind!' },
            { initials: 'OC', name: 'Olivia Chen',            event: 'Corporate Gala · Mar 2025', rating: 5, tag: 'Verified Client',  color: '#8e6024', text: 'We hired SK Rentals for our annual company gala and the results were stunning. The lounge suite and lighting created such an elegant atmosphere. Highly recommend!' },
            { initials: 'SB', name: 'Sarah & Michael Brown',  event: 'Wedding · Jan 2025',        rating: 5, tag: 'Verified Client',  color: '#b07a2e', text: 'From the first enquiry to the final pickup, the team was professional and genuinely caring. Our guests could not stop complimenting the beautiful decor.' },
            { initials: 'RT', name: 'Rachel Thompson',        event: 'Baby Shower · Apr 2025',    rating: 5, tag: 'Repeat Customer', color: '#c8903a', text: 'I rented the tableware set and beautiful backdrop panels. Everything was pristine, exactly as shown, and delivery was seamless. Will absolutely use again!' },
            { initials: 'MK', name: 'Marcus & Kim Lee',       event: 'Anniversary · Feb 2025',    rating: 5, tag: 'Verified Client',  color: '#6e4a1c', text: 'The string light canopy transformed our backyard into a fairytale. Setup crew was fast, professional, and left everything spotless. Truly world-class service.' },
            { initials: 'JD', name: 'Jessica Davis',          event: 'Bridal Shower · Mar 2025',  rating: 5, tag: 'Verified Client',  color: '#b07a2e', text: 'From the moment I reached out, the SK Rentals team was attentive and full of great ideas. The lounge furniture was gorgeous and everything fit perfectly in the space.' },
        ],
        get maxPage() {
            if (window.innerWidth >= 1024) return Math.max(0, this.reviews.length - 3);
            if (window.innerWidth >= 640)  return Math.max(0, this.reviews.length - 2);
            return this.reviews.length - 1;
        },
        get offset() {
            const cardW = this.\$el.querySelector('.reviews-slide')?.offsetWidth || 0;
            const gap = 24;
            return this.current * (cardW + gap);
        },
        next() { if (this.current < this.maxPage) this.current++; else this.current = 0; },
        prev() { if (this.current > 0) this.current--; else this.current = this.maxPage; },
    }"
    x-init="setInterval(() => next(), 5500)">

    <div class="container-sk relative z-10">

        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-14">
            <div>
                <span class="badge badge-gold mb-3">⭐ What Our Clients Say</span>
                <h2 id="testimonials-heading" class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 leading-tight">
                    Real Stories, <span class="text-gradient-gold">Real Joy</span>
                </h2>
                <p class="text-neutral-500 mt-3 max-w-md text-base leading-relaxed">
                    Hear from the couples, families &amp; companies who trusted SK Rentals to make their event unforgettable.
                </p>
            </div>

            {{-- Overall rating summary --}}
            <div class="flex items-center gap-4 bg-white rounded-2xl px-5 py-4 shadow-card border border-neutral-100 flex-shrink-0">
                <div class="text-center">
                    <p class="font-display text-4xl font-bold text-neutral-900 leading-none">5.0</p>
                    <div class="flex gap-0.5 mt-1 justify-center">
                        @for ($s = 0; $s < 5; $s++)
                            <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-xs text-neutral-400 mt-1 font-medium">500+ Reviews</p>
                </div>
                <div class="w-px h-12 bg-neutral-100"></div>
                <div class="space-y-1.5">
                    @foreach([[5,'92%'],[4,'6%'],[3,'2%']] as [$star,$pct])
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-neutral-500 w-3">{{ $star }}</span>
                        <svg class="w-3 h-3 text-brand-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <div class="rating-bar-track w-20"><div class="rating-bar-fill" style="width:{{ $pct }}"></div></div>
                        <span class="text-xs text-neutral-400 w-6">{{ $pct }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Carousel Viewport --}}
        <div class="overflow-hidden" style="border-radius:1rem">
            <div class="reviews-track" :style="`transform: translateX(-${offset}px)`">

                @php
                $reviews = [
                    ['initials'=>'EW','name'=>'Emily & James Watson',  'event'=>'Wedding · May 2025',       'rating'=>5,'tag'=>'Verified Client', 'color'=>'#c8903a','text'=>'SK Rentals made our wedding day absolutely magical. The gold chiavari chairs and floral arch were beyond beautiful. Everything arrived perfectly on time and the setup team was so kind!'],
                    ['initials'=>'OC','name'=>'Olivia Chen',           'event'=>'Corporate Gala · Mar 2025','rating'=>5,'tag'=>'Verified Client', 'color'=>'#8e6024','text'=>'We hired SK Rentals for our annual company gala and the results were stunning. The lounge suite and lighting created such an elegant atmosphere. Highly recommend!'],
                    ['initials'=>'SB','name'=>'Sarah & Michael Brown', 'event'=>'Wedding · Jan 2025',       'rating'=>5,'tag'=>'Verified Client', 'color'=>'#b07a2e','text'=>'From the first enquiry to the final pickup, the team was professional and genuinely caring. Our guests could not stop complimenting the beautiful decor.'],
                    ['initials'=>'RT','name'=>'Rachel Thompson',       'event'=>'Baby Shower · Apr 2025',   'rating'=>5,'tag'=>'Repeat Customer','color'=>'#c8903a','text'=>'I rented the tableware set and beautiful backdrop panels. Everything was pristine, exactly as shown, and delivery was seamless. Will absolutely use again!'],
                    ['initials'=>'MK','name'=>'Marcus & Kim Lee',      'event'=>'Anniversary · Feb 2025',   'rating'=>5,'tag'=>'Verified Client', 'color'=>'#6e4a1c','text'=>'The string light canopy transformed our backyard into a fairytale. Setup crew was fast, professional, and left everything spotless. Truly world-class service.'],
                    ['initials'=>'JD','name'=>'Jessica Davis',         'event'=>'Bridal Shower · Mar 2025', 'rating'=>5,'tag'=>'Verified Client', 'color'=>'#b07a2e','text'=>'From the moment I reached out, the SK Rentals team was attentive and full of great ideas. The lounge furniture was gorgeous and everything fit perfectly in the space.'],
                ];
                @endphp

                @foreach($reviews as $i => $r)
                <div class="reviews-slide">
                    <div class="review-card {{ $i === 0 ? 'review-card-featured' : '' }}">
                        {{-- Big decorative quote mark --}}
                        <span class="review-card-quote" aria-hidden="true">&ldquo;</span>

                        {{-- Stars --}}
                        <div class="review-stars">
                            @for($s = 0; $s < $r['rating']; $s++)
                                <svg class="review-star" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>

                        {{-- Review Text --}}
                        <p class="text-sm leading-relaxed flex-1 {{ $i === 0 ? 'text-white/90' : 'text-neutral-600' }}" style="font-style:italic">
                            &ldquo;{{ $r['text'] }}&rdquo;
                        </p>

                        {{-- Author row --}}
                        <div class="flex items-center gap-3 pt-2 border-t {{ $i === 0 ? 'border-white/20' : 'border-neutral-100' }}">
                            <div class="review-avatar review-avatar-lg" style="background: linear-gradient(135deg, {{ $r['color'] }}22, {{ $r['color'] }}44); color:{{ $r['color'] }}; border-color:{{ $r['color'] }}44">
                                {{ $r['initials'] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate {{ $i === 0 ? 'text-white' : 'text-neutral-900' }}">
                                    {{ $r['name'] }}
                                </p>
                                <p class="text-xs truncate {{ $i === 0 ? 'text-white/60' : 'text-neutral-400' }}">
                                    {{ $r['event'] }}
                                </p>
                            </div>
                            {{-- Verified badge --}}
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full flex-shrink-0
                                {{ $i === 0 ? 'bg-white/20 text-white' : 'bg-brand-50 text-brand-700' }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                {{ $r['tag'] }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        {{-- Controls Row --}}
        <div class="flex items-center justify-between mt-8">

            {{-- Dot indicators --}}
            <div class="flex items-center gap-2">
                @foreach($reviews as $i => $r)
                <button @click="current = {{ $i }}"
                        class="rounded-full transition-all duration-300"
                        :class="current === {{ $i }} ? 'w-7 h-2.5 bg-brand-500' : 'w-2.5 h-2.5 bg-neutral-200 hover:bg-neutral-300'"
                        aria-label="Go to review {{ $i + 1 }}"></button>
                @endforeach
            </div>

            {{-- Prev / Next buttons --}}
            <div class="flex items-center gap-3">
                <button @click="prev"
                        class="w-10 h-10 rounded-full border-2 border-neutral-200 hover:border-brand-400 bg-white hover:bg-brand-50 flex items-center justify-center transition-all duration-200 shadow-sm"
                        aria-label="Previous review">
                    <svg class="w-4 h-4 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="next"
                        class="w-10 h-10 rounded-full bg-brand-500 hover:bg-brand-600 flex items-center justify-center transition-all duration-200 shadow-glow"
                        aria-label="Next review">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        {{-- Bottom trust strip --}}
        <div class="mt-12 pt-8 border-t border-neutral-200 flex flex-wrap items-center justify-center gap-8 text-sm text-neutral-500">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                All reviews from real customers
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Rated 5.0 stars across 500+ events
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Trusted by Knoxville families since 2014
            </span>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CTA BAND — with background image
══════════════════════════════════════════════════════════ --}}

<section class="relative py-24 overflow-hidden" aria-labelledby="cta-heading">
    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/product-lighting.png') }}"
             alt="Beautiful fairy lights wedding reception"
             class="w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/90 to-brand-800/85"></div>
    </div>

    <div class="relative z-10 container-sk text-center">
        <span class="badge badge-gold mb-5">Start Planning Today</span>
        <h2 id="cta-heading" class="font-display text-3xl sm:text-4xl lg:text-5xl font-semibold text-white mb-5 leading-tight">
            Ready to Make Your Vision<br class="hidden sm:block"/> a Reality?
        </h2>
        <p class="text-brand-100 mb-8 text-base max-w-lg mx-auto leading-relaxed">
            Browse our full catalogue and check availability for your special date.
            Our team is ready to help you create something magical.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('products') }}"
               class="btn btn-lg bg-white text-brand-700 hover:bg-brand-50 border-transparent shadow-elevated">
                Browse All Rentals
            </a>
            <a href="#" class="btn btn-lg border-white/30 text-white hover:bg-white/10">
                Contact Us
            </a>
        </div>
    </div>
</section>
</x-layout.app-layout>
