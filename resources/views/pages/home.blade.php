@extends('layouts.app')

@section('title', 'Welcome')
@section('meta_description', 'SK Rentals — Premium wedding and event rental items in Knoxville, Tennessee. Browse our elegant collection and make your special day unforgettable.')

@section('content')

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
<section class="py-20 bg-white" aria-labelledby="about-section-heading">
    <div class="container-sk">
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
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     FEATURED PRODUCTS GALLERY
══════════════════════════════════════════════════════════ --}}
<section id="gallery" class="py-20 bg-cream" aria-labelledby="products-section-heading">
    <div class="container-sk">

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

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach ($items as $item)
            <div class="group card overflow-hidden hover:shadow-elevated transition-all duration-300 hover:-translate-y-1">
                {{-- Image --}}
                <div class="relative overflow-hidden aspect-[4/3]">
                    <img src="{{ asset('images/' . $item['image']) }}"
                         alt="{{ $item['name'] }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy" />
                    {{-- Category badge --}}
                    <span class="absolute top-3 left-3 badge badge-gold text-xs">{{ $item['category'] }}</span>
                </div>
                {{-- Info --}}
                <div class="p-5">
                    <h3 class="font-display font-semibold text-neutral-900 text-lg mb-1">{{ $item['name'] }}</h3>
                    <p class="text-neutral-500 text-sm mb-4 leading-relaxed">
                        Premium quality rental piece for your special event.
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-brand-600 text-lg">
                            {{ $item['price'] }}<span class="text-sm font-normal text-neutral-400">/day</span>
                        </span>
                        <a href="{{ route('products') }}" class="btn btn-primary btn-sm">Enquire</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('products') }}" class="btn btn-outline btn-lg">
                View Full Collection
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     WHY CHOOSE US — Icon Grid
══════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white" aria-labelledby="features-heading">
    <div class="container-sk">
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

@endsection
