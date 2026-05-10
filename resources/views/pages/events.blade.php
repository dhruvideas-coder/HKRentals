<x-layout.app-layout>
    <x-slot:title>Events We Serve</x-slot>
    <x-slot:metaDescription>HK Rentals serves weddings, corporate galas, baby showers, anniversaries, and more across Knoxville, TN. Explore the events we make unforgettable.</x-slot>

{{-- ══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[65vh] flex items-center overflow-hidden" aria-labelledby="events-hero-heading">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero.png') }}"
             alt="Elegant event setup by HK Rentals"
             class="w-full h-full object-cover object-center"
             loading="eager" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 via-neutral-950/65 to-neutral-900/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/50 via-transparent to-transparent"></div>
    </div>
    <div class="absolute top-20 right-0 w-80 h-80 rounded-full bg-brand-500/8 blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 container-sk py-24 lg:py-36 w-full">
        <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-5">
                <div class="h-px w-10 bg-brand-400"></div>
                <span class="text-brand-300 text-sm font-medium uppercase tracking-widest">Events We Serve</span>
            </div>
            <h1 id="events-hero-heading" class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Every Occasion<br/>
                <span class="text-gradient-gold">Beautifully Styled</span>
            </h1>
            <p class="text-neutral-300 text-lg leading-relaxed max-w-xl mb-8">
                From intimate backyard ceremonies to grand corporate galas — HK Rentals brings premium
                furniture, décor, and event essentials to every celebration in Knoxville and beyond.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg shadow-glow">
                    Browse Rentals
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="btn btn-lg text-white" style="background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.25);backdrop-filter:blur(6px);">
                    Plan Your Event
                </a>
            </div>
        </div>
    </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     EVENTS GRID
══════════════════════════════════════════════════════════ --}}
<x-section class="bg-white" aria-labelledby="events-grid-heading">
    <x-container>

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">What We Cover</span>
            <h2 id="events-grid-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                The Perfect Rental for <span class="text-gradient-gold">Every Event</span>
            </h2>
            <p class="text-neutral-500 max-w-lg mx-auto text-base leading-relaxed">
                No matter the occasion, we have the pieces that make it extraordinary. Explore the events we specialise in.
            </p>
        </div>

        @php
        $events = [
            [
                'image'       => 'images/products/product-arch.png',
                'title'       => 'Weddings',
                'subtitle'    => 'The most special day of your life',
                'color'       => '#c8903a',
                'badge'       => 'Most Popular',
                'description' => 'From ceremony arches and chiavari chairs to sweetheart tables and floral walls, we provide everything for your dream wedding. Full setup and pickup included.',
                'items'       => ['Ceremony Arches', 'Chiavari Chairs', 'Sweetheart Tables', 'Floral Backdrops', 'String Lighting'],
            ],
            [
                'image'       => 'images/products/product-lounge.png',
                'title'       => 'Corporate Galas',
                'subtitle'    => 'Impress clients and colleagues',
                'color'       => '#6e4a1c',
                'badge'       => 'Business Events',
                'description' => 'Create a sophisticated atmosphere for product launches, award nights, and company galas with our elegant lounge furniture, lighting, and staging essentials.',
                'items'       => ['Lounge Suites', 'Cocktail Tables', 'Stage Risers', 'Uplighting', 'Branded Backdrops'],
            ],
            [
                'image'       => 'images/products/product-lighting.png',
                'title'       => 'Outdoor Parties',
                'subtitle'    => 'Garden, backyard & park events',
                'color'       => '#8e6024',
                'badge'       => 'All Seasons',
                'description' => 'Transform any outdoor space into a magical venue with fairy light canopies, farm tables, tent structures, and weather-appropriate décor.',
                'items'       => ['Fairy Light Canopies', 'Farm Tables', 'Folding Chairs', 'Tent Rentals', 'Outdoor Lighting'],
            ],
            [
                'image'       => 'images/products/product-tableware.png',
                'title'       => 'Baby Showers',
                'subtitle'    => 'Celebrate new beginnings',
                'color'       => '#b07a2e',
                'badge'       => 'Celebrations',
                'description' => 'Welcome the new arrival in style with our soft, elegant tableware sets, floral arrangements, backdrop panels, and custom décor packages.',
                'items'       => ['Crystal Glassware', 'Gold Flatware', 'Floral Backdrops', 'Table Linens', 'Centrepieces'],
            ],
            [
                'image'       => 'images/products/product-chairs.png',
                'title'       => 'Anniversaries',
                'subtitle'    => 'Celebrate your love story',
                'color'       => '#9e6818',
                'badge'       => 'Milestone Events',
                'description' => 'Mark your milestone anniversary with a beautifully decorated dinner or reception. Our team handles everything from intimate 10-person tables to grand 300-guest events.',
                'items'       => ['Elegant Dining Tables', 'Gold Chiavari Chairs', 'Centrepieces', 'Candle Arrangements', 'Photo Backdrops'],
            ],
            [
                'image'       => 'images/products/product-backdrop.png',
                'title'       => 'Birthdays & Quinceañeras',
                'subtitle'    => 'Make it a night to remember',
                'color'       => '#c8903a',
                'badge'       => 'Parties',
                'description' => 'From sweet 16s to milestone 50th birthdays, our vibrant décor collection ensures every birthday feels extraordinary and utterly unforgettable.',
                'items'       => ['Statement Backdrops', 'Balloon Garlands', 'Specialty Chairs', 'Neon Signs', 'Dessert Table Décor'],
            ],
        ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $ev)
            <article class="group card overflow-hidden hover:shadow-elevated transition-all duration-300 hover:-translate-y-1">
                {{-- Image --}}
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset($ev['image']) }}"
                         alt="{{ $ev['title'] }} rental setup"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         loading="lazy" />
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/60 to-transparent"></div>
                    {{-- Badge --}}
                    <span class="absolute top-4 left-4 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold text-white"
                          style="background: linear-gradient(135deg, {{ $ev['color'] }}, {{ $ev['color'] }}cc)">
                        {{ $ev['badge'] }}
                    </span>
                    {{-- Title on image --}}
                    <div class="absolute bottom-4 left-4">
                        <h3 class="font-display text-xl font-bold text-white">{{ $ev['title'] }}</h3>
                        <p class="text-white/70 text-xs mt-0.5">{{ $ev['subtitle'] }}</p>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 flex flex-col gap-4">
                    <p class="text-neutral-500 text-sm leading-relaxed">{{ $ev['description'] }}</p>

                    {{-- Items list --}}
                    <ul class="space-y-1.5">
                        @foreach($ev['items'] as $item)
                        <li class="flex items-center gap-2 text-sm text-neutral-600">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                                 style="color: {{ $ev['color'] }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('products') }}"
                       class="mt-1 inline-flex items-center gap-1.5 text-sm font-semibold transition-base"
                       style="color: {{ $ev['color'] }}">
                        Browse {{ $ev['title'] }} Rentals
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════════════ --}}
<section class="relative py-24 overflow-hidden" aria-labelledby="events-cta-heading">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/products/product-lighting.png') }}"
             alt="Beautiful event lighting"
             class="w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/92 to-brand-800/88"></div>
    </div>
    <div class="relative z-10 container-sk text-center">
        <span class="badge badge-gold mb-5">Let's Get Started</span>
        <h2 id="events-cta-heading" class="font-display text-3xl sm:text-4xl lg:text-5xl font-semibold text-white mb-5 leading-tight">
            What Are You<br class="hidden sm:block"/> Celebrating?
        </h2>
        <p class="text-brand-100 mb-8 text-base max-w-lg mx-auto leading-relaxed">
            Whatever the occasion, we have the perfect rentals to make it unforgettable.
            Reach out and let's start planning together.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('products') }}" class="btn btn-lg bg-white text-brand-700 hover:bg-brand-50 border-transparent shadow-elevated">
                Browse All Rentals
            </a>
            <a href="{{ route('contact') }}" class="btn btn-lg border-white/30 text-white hover:bg-white/10">
                Contact Us
            </a>
        </div>
    </div>
</section>

</x-layout.app-layout>
