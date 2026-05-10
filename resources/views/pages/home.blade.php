<x-layout.app-layout>
    <x-slot:title>Welcome</x-slot>
    <x-slot:metaDescription>HK Rentals — Premium Tents, tables, chairs, marquee letters, and event rentals for weddings, parties, and corporate events across Knoxville and surrounding areas.</x-slot>


{{-- ══════════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden h-[calc(100svh-4rem)] flex items-center" aria-labelledby="hero-heading">

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

    <div class="relative z-10 container-sk py-10 sm:py-20 lg:py-40 w-full">
        <div class="max-w-2xl">
            <span class="badge badge-gold mb-3 sm:mb-6 inline-flex text-xs tracking-widest uppercase">✦ Knoxville's Premier Rental Service</span>

            <h1 id="hero-heading" class="font-display text-4xl sm:text-5xl lg:text-[3.75rem] font-bold text-white leading-tight mb-3 sm:mb-6">
                Wedding, Event & Party Rentals in <span class="text-gradient-gold">Knoxville, TN</span>
            </h1>

            <p class="text-neutral-300 text-lg leading-relaxed mb-4 sm:mb-8 max-w-xl">
                Premium Tents, tables, chairs, marquee letters, and event rentals for weddings, parties, 
                and corporate events across Knoxville and surrounding areas.
            </p>

            {{-- 5-Star Rating --}}
            <div class="flex items-center gap-3 mb-5 sm:mb-10 fade-in" style="animation-delay: 0.4s">
                <div class="flex gap-1">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-brand-400 drop-shadow-glow" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-white font-bold text-lg leading-none">5.0</span>
                    <span class="text-neutral-400 text-sm border-l border-neutral-700 pl-2">Rated by 500+ Clients</span>
                </div>
            </div>

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
            <div class="flex flex-wrap items-center gap-6 mt-6 sm:mt-12 text-sm text-neutral-300">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    500+ Happy Clients
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Quality Guaranteed
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25a9 9 0 0 0-9-9h-2.25" /></svg>
                    Delivery and pickup available
                </span>
            </div>
        </div>
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
                    <p class="text-2xl font-bold text-brand-600 leading-none">5+</p>
                    <p class="text-xs text-neutral-500 mt-0.5 font-medium">Years of Experience</p>
                </div>
            </div>

            {{-- Text side --}}
            <div>
                <span class="badge badge-gold mb-4">About HK Rentals</span>
                <h2 id="about-section-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-5 leading-tight">
                    Knoxville's Most Trusted<br/>
                    <span class="text-gradient-gold">Event Rental Partner</span>
                </h2>
                <p class="text-neutral-500 text-base leading-relaxed mb-6">
                    From intimate backyard ceremonies to grand ballroom receptions, HK Rentals brings
                    your vision to life with a curated collection of premium furniture, decor, and event essentials.
                </p>
                <p class="text-neutral-500 text-base leading-relaxed mb-8">
                    We handle the details — delivery, setup, and pickup — so you can focus on celebrating
                    the moments that matter most.
                </p>
                <div class="grid grid-cols-2 gap-5 mb-8">
                    @foreach([['500+','Happy Couples'], ['200+','Rental Items'], ['5+','Years Experience'], ['5★','Average Rating']] as [$num, $label])
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

        @php
            $homeCategories = \App\Models\Category::withCount('products')->orderBy('name')->get();
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse($homeCategories as $cat)
            <x-category.card
                :name="$cat->name"
                :image="$cat->image ? asset($cat->image) : asset('images/ceremony.png')"
                :count="$cat->products_count"
                :href="route('products', ['category' => $cat->slug])"
            />
            @empty
            <p class="col-span-full text-center text-neutral-400 text-sm py-8">No categories found.</p>
            @endforelse
        </div>
    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     FEATURED PRODUCTS GALLERY
══════════════════════════════════════════════════════════ --}}
<x-section id="gallery" class="bg-white" aria-labelledby="products-section-heading">
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
            ['image' => 'images/products/product-chairs.png',    'name' => 'Gold Chiavari Chairs',  'category' => 'Seating',   'price' => '$4'],
            ['image' => 'images/products/product-arch.png',       'name' => 'Floral Wedding Arch',   'category' => 'Ceremony',  'price' => '$120'],
            ['image' => 'images/products/product-tableware.png',  'name' => 'Luxury Table Setting',  'category' => 'Tableware', 'price' => '$18'],
            ['image' => 'images/products/product-lighting.png',   'name' => 'String Light Canopy',   'category' => 'Lighting',  'price' => '$85'],
            ['image' => 'images/products/product-lounge.png',     'name' => 'White Lounge Suite',    'category' => 'Furniture', 'price' => '$200'],
            ['image' => 'images/products/product-backdrop.png',   'name' => 'Floral Hex Backdrop',   'category' => 'Decor',     'price' => '$95'],
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
<x-section class="bg-cream" aria-labelledby="features-heading">
    <x-container>
        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">Why HK Rentals</span>
            <h2 id="features-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Everything You Need for Your Perfect Event
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ([
                ['icon' => 'sparkles',      'title' => 'Curated Collection',   'desc' => 'Handpicked items that blend elegance and practicality for every style of event.'],
                ['icon' => 'truck',         'title' => 'Delivery & Setup',     'desc' => 'White-glove delivery and professional setup so you can focus on your guests.'],
                ['icon' => 'shield-check',  'title' => 'Premium Quality',      'desc' => 'Every item is cleaned, inspected, and maintained to the highest standards.'],
                ['icon' => 'chat-bubble',   'title' => 'Expert Consultation',  'desc' => 'Our team helps you choose the right pieces to match your vision perfectly.'],
                ['icon' => 'calendar',      'title' => 'Flexible Booking',     'desc' => 'Easy reservations with flexible date changes and cancellation options.'],
                ['icon' => 'map-pin',       'title' => 'Knoxville Local',      'desc' => 'Proudly serving the Knoxville area — we know the venues and the community.'],
            ] as $f)
            <div class="card p-6 hover:shadow-elevated hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        @if($f['icon'] === 'sparkles')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.456-2.455L18 2.25l.259 1.036a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.456-2.455zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                        @elseif($f['icon'] === 'truck')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25a9 9 0 0 0-9-9h-2.25" />
                        @elseif($f['icon'] === 'shield-check')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        @elseif($f['icon'] === 'chat-bubble')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        @elseif($f['icon'] === 'calendar')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        @elseif($f['icon'] === 'map-pin')
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        @endif
                    </svg>
                </div>
                <h3 class="font-display text-lg font-semibold text-neutral-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-neutral-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     HOW IT WORKS — Interactive Flow Selector
══════════════════════════════════════════════════════════ --}}
@php
$hiw_flows = [
    'booking' => [
        'label'   => 'Online Booking',
        'badge'   => 'Book Instantly',
        'cta'     => 'Book Now',
        'ctaHref' => route('products'),
        'steps'   => [
            ['num' => '01', 'icon' => 'viewfinder',   'title' => 'Browse the Catalog',     'desc' => 'Explore our full collection online. Filter by category, style, or price to find exactly what your event needs.'],
            ['num' => '02', 'icon' => 'bag',           'title' => 'Select Your Items',      'desc' => 'Pick your rental pieces and choose your preferred event date. Availability is shown in real time.'],
            ['num' => '03', 'icon' => 'lock',          'title' => 'Confirm and Pay Deposit','desc' => 'Secure your booking with a simple deposit online. You will receive an instant confirmation email.'],
            ['num' => '04', 'icon' => 'truck',         'title' => 'We Deliver and Set Up',  'desc' => 'Our crew arrives at your venue, sets everything up exactly as planned — no effort needed from you.'],
            ['num' => '05', 'icon' => 'gift',          'title' => 'Enjoy Your Event',       'desc' => 'Focus on celebrating. Everything is in place and looking stunning, just as you imagined.'],
            ['num' => '06', 'icon' => 'tray-down',     'title' => 'We Collect and Wrap Up', 'desc' => 'After the event we return to pack and collect everything. No cleanup stress on your end.'],
        ],
    ],
    'quote' => [
        'label'   => 'Request a Quote',
        'badge'   => 'Custom Quote',
        'cta'     => 'Request a Quote',
        'ctaHref' => route('products'),
        'steps'   => [
            ['num' => '01', 'icon' => 'viewfinder',   'title' => 'Browse and Note Items',  'desc' => 'Explore the catalog and note the pieces you love. No need to commit yet — just build your wish list.'],
            ['num' => '02', 'icon' => 'pencil',        'title' => 'Submit Your Request',    'desc' => 'Send us your event details, date, and item list. Takes less than two minutes.'],
            ['num' => '03', 'icon' => 'bubbles',       'title' => 'Receive Your Quote',     'desc' => 'We send a personalised quote within 24 hours, tailored to your exact event needs.'],
            ['num' => '04', 'icon' => 'shield-check',  'title' => 'Approve and Book',       'desc' => 'Happy with the quote? Simply approve it and we lock in your date right away.'],
            ['num' => '05', 'icon' => 'truck',         'title' => 'We Deliver and Set Up',  'desc' => 'Our team handles delivery, professional setup, and all the heavy lifting on event day.'],
            ['num' => '06', 'icon' => 'tray-down',     'title' => 'We Collect and Wrap Up', 'desc' => 'Post-event, we return for a hassle-free pickup. Just leave the rest to us.'],
        ],
    ],
    'consult' => [
        'label'   => 'Call and Consult',
        'badge'   => 'Personal Touch',
        'cta'     => 'Call Us Today',
        'ctaHref' => '#contact',
        'steps'   => [
            ['num' => '01', 'icon' => 'phone',         'title' => 'Give Us a Call',          'desc' => 'Speak directly with one of our friendly team members. We are here to help you plan the perfect event.'],
            ['num' => '02', 'icon' => 'lightbulb',     'title' => 'Share Your Vision',       'desc' => 'Tell us about your event, your style, your venue, and your guest count. The more detail, the better.'],
            ['num' => '03', 'icon' => 'clipboard',     'title' => 'We Build Your Package',   'desc' => 'We craft a custom rental package with the right pieces, quantities, and layout suggestions just for you.'],
            ['num' => '04', 'icon' => 'badge-check',   'title' => 'Confirm and Pay Deposit', 'desc' => 'Review your bespoke proposal, give the go-ahead, and secure your date with a deposit.'],
            ['num' => '05', 'icon' => 'truck',         'title' => 'We Deliver and Set Up',   'desc' => 'On event day our crew handles everything — delivery, setup, and styling — exactly to plan.'],
            ['num' => '06', 'icon' => 'tray-down',     'title' => 'We Collect and Wrap Up',  'desc' => 'We return after your event for a smooth, stress-free pickup. All done.'],
        ],
    ],
];
@endphp

<x-section class="bg-white" aria-labelledby="how-it-works-heading">
    <x-container>
        <div x-data='{ active: "quote", flows: @json($hiw_flows), get current() { return this.flows[this.active]; } }'>

            {{-- Section Header --}}
            <div class="text-center mb-10">
                <span class="badge badge-gold mb-3">Simple &amp; Stress-Free</span>
                <h2 id="how-it-works-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                    How It <span class="text-gradient-gold">Works</span>
                </h2>
                <p class="text-neutral-500 max-w-xl mx-auto text-base leading-relaxed">
                    Choose your preferred way to book and we will walk you through every step, start to finish.
                </p>
            </div>

            {{-- ── Flow Selector Tabs ── --}}
            <div class="flex justify-center mb-10 px-2">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center bg-neutral-100 rounded-2xl p-1.5 gap-1.5 shadow-inner w-full max-w-xs sm:max-w-none sm:w-auto">
                    <template x-for="[key, flow] in Object.entries(flows)" :key="key">
                        <button
                            @click="active = key"
                            :class="active === key
                                ? 'bg-white text-brand-700 shadow-card border border-brand-100 font-semibold'
                                : 'text-neutral-500 hover:text-neutral-700 hover:bg-white/50'"
                            class="relative flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl text-sm transition-all duration-200 cursor-pointer">
                            {{-- cart: online booking --}}
                            <svg x-show="key === 'booking'" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                            </svg>
                            {{-- document: request a quote --}}
                            <svg x-show="key === 'quote'" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                            {{-- phone: call and consult --}}
                            <svg x-show="key === 'consult'" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            <span x-text="flow.label"></span>
                            <span x-show="active === key" class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-brand-500 rounded-full border-2 border-white shadow-sm" aria-hidden="true"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- ── Active Flow Badge ── --}}
            <div class="flex justify-center mb-12">
                <div class="inline-flex items-center gap-2 bg-brand-50 border border-brand-100 rounded-full px-4 py-1.5 text-sm text-brand-700 font-medium">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse flex-shrink-0"></span>
                    <span x-text="current.badge + ' — here is your journey'"></span>
                </div>
            </div>

            {{-- ── Steps Panel ── --}}
            <div class="relative">

                {{-- Connecting line desktop --}}
                <div class="hidden lg:block absolute top-[52px] left-[10%] right-[10%] h-px z-0" aria-hidden="true">
                    <div class="w-full h-full bg-gradient-to-r from-transparent via-brand-200 to-transparent"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 lg:gap-3 relative z-10">
                    <template x-for="(step, i) in current.steps" :key="step.num">
                        <div class="flex flex-col items-center text-center group">

                            {{-- Bubble with floating number badge --}}
                            <div class="relative mb-6">

                                {{-- Step number badge --}}
                                <span class="absolute -top-3 left-1/2 -translate-x-1/2 z-10 inline-flex items-center justify-center w-7 h-7 rounded-full bg-brand-500 text-white text-[11px] font-bold shadow-md border-2 border-white leading-none" x-text="step.num"></span>

                                {{-- Outer ring --}}
                                <div class="w-[88px] h-[88px] rounded-full bg-white border-2 border-brand-100 group-hover:border-brand-400 transition-all duration-300 shadow-md group-hover:shadow-glow flex items-center justify-center">

                                    {{-- Inner filled circle --}}
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-50 to-brand-100 group-hover:from-brand-100 group-hover:to-brand-200 transition-all duration-300 flex items-center justify-center">

                                        {{-- Each icon has its own <svg> + x-show; x-if inside <svg> breaks SVG namespace and prevents rendering --}}
                                        <svg x-show="step.icon === 'viewfinder'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'bag'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'lock'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'truck'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25a9 9 0 0 0-9-9h-2.25"/>
                                        </svg>
                                        <svg x-show="step.icon === 'gift'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'tray-down'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                        </svg>
                                        <svg x-show="step.icon === 'pencil'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                        </svg>
                                        <svg x-show="step.icon === 'bubbles'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                                        </svg>
                                        <svg x-show="step.icon === 'shield-check'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'phone'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'lightbulb'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                                        </svg>
                                        <svg x-show="step.icon === 'clipboard'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                                        </svg>
                                        <svg x-show="step.icon === 'badge-check'" class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Mobile arrow --}}
                                <div x-show="i < current.steps.length - 1"
                                     class="lg:hidden absolute -bottom-7 left-1/2 -translate-x-1/2 flex flex-col items-center" aria-hidden="true">
                                    <div class="w-px h-5 bg-brand-200"></div>
                                    <svg class="w-3 h-3 text-brand-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>

                            <h3 class="font-display text-sm font-semibold text-neutral-900 mb-1.5 leading-snug" x-text="step.title"></h3>
                            <p class="text-neutral-500 text-xs leading-relaxed max-w-[9rem] lg:max-w-[8rem]" x-text="step.desc"></p>
                        </div>
                    </template>
                </div>
            </div>

            {{-- ── Bottom CTA ── --}}
            <div class="text-center mt-14">
                <a :href="current.ctaHref" class="btn btn-primary btn-lg shadow-glow">
                    <span x-text="current.cta"></span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <p class="text-xs text-neutral-400 mt-3">No commitment required. Switch methods any time.</p>
            </div>

        </div>
    </x-container>
</x-section>

{{-- ══════════════════════════════════════════════════════════
     TESTIMONIALS — Real Stories, Real Joy
══════════════════════════════════════════════════════════ --}}
<section class="reviews-section-bg py-20 sm:py-28" aria-labelledby="testimonials-heading">

    <div class="container-sk relative z-10">

        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-14">
            <div>
                <span class="badge badge-gold mb-3">⭐ What Our Clients Say</span>
                <h2 id="testimonials-heading" class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 leading-tight">
                    Real Stories, <span class="text-gradient-gold">Real Joy</span>
                </h2>
                <p class="text-neutral-500 mt-3 max-w-md text-base leading-relaxed">
                    Hear from the couples, families &amp; companies who trusted HK Rentals to make their event unforgettable.
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

        @php
        $homeReviews = [
            ['initials'=>'EW','name'=>'Emily & James Watson',  'event'=>'Wedding · May 2025',        'rating'=>5,'tag'=>'Verified Client', 'color'=>'#c8903a','text'=>'HK Rentals made our wedding day absolutely magical. The gold chiavari chairs and floral arch were beyond beautiful. Everything arrived perfectly on time and the setup team was so kind!'],
            ['initials'=>'OC','name'=>'Olivia Chen',           'event'=>'Corporate Gala · Mar 2025', 'rating'=>5,'tag'=>'Verified Client', 'color'=>'#8e6024','text'=>'We hired HK Rentals for our annual company gala and the results were stunning. The lounge suite and lighting created such an elegant atmosphere. Highly recommend!'],
            ['initials'=>'SB','name'=>'Sarah & Michael Brown', 'event'=>'Wedding · Jan 2025',        'rating'=>5,'tag'=>'Verified Client', 'color'=>'#b07a2e','text'=>'From the first enquiry to the final pickup, the team was professional and genuinely caring. Our guests could not stop complimenting the beautiful decor.'],
            ['initials'=>'RT','name'=>'Rachel Thompson',       'event'=>'Baby Shower · Apr 2025',    'rating'=>5,'tag'=>'Repeat Customer','color'=>'#c8903a','text'=>'I rented the tableware set and beautiful backdrop panels. Everything was pristine, exactly as shown, and delivery was seamless. Will absolutely use again!'],
            ['initials'=>'MK','name'=>'Marcus & Kim Lee',      'event'=>'Anniversary · Feb 2025',    'rating'=>5,'tag'=>'Verified Client', 'color'=>'#6e4a1c','text'=>'The string light canopy transformed our backyard into a fairytale. Setup crew was fast, professional, and left everything spotless. Truly world-class service.'],
        ];
        @endphp

        {{-- ── Featured hero review (full-width) ── --}}
        <div class="relative overflow-hidden rounded-3xl p-8 sm:p-10 mb-6"
             style="background: linear-gradient(135deg, #c8903a 0%, #7a4f1a 100%)">

            <span class="absolute top-2 right-6 text-[9rem] leading-none font-display text-white/10 select-none pointer-events-none" aria-hidden="true">&ldquo;</span>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-8">

                {{-- Quote side --}}
                <div class="flex-1 min-w-0">
                    <div class="flex gap-1 mb-5">
                        @for ($s = 0; $s < 5; $s++)
                            <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-white text-lg sm:text-xl leading-relaxed font-light italic">
                        &ldquo;{{ $homeReviews[0]['text'] }}&rdquo;
                    </p>
                </div>

                {{-- Author side --}}
                <div class="flex sm:flex-col items-center gap-4 sm:text-center sm:min-w-[160px]">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center font-bold text-xl flex-shrink-0"
                         style="background: rgba(255,255,255,0.18); color:#fff; border: 2px solid rgba(255,255,255,0.35)">
                        {{ $homeReviews[0]['initials'] }}
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm leading-snug">{{ $homeReviews[0]['name'] }}</p>
                        <p class="text-white/60 text-xs mt-0.5">{{ $homeReviews[0]['event'] }}</p>
                        <span class="inline-flex items-center gap-1 mt-2 text-xs font-medium px-2.5 py-1 rounded-full bg-white/20 text-white">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $homeReviews[0]['tag'] }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Supporting reviews: 2×2 grid ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach(array_slice($homeReviews, 1, 4) as $r)
            <div class="review-card">
                <span class="review-card-quote" aria-hidden="true">&ldquo;</span>

                <div class="review-stars">
                    @for ($s = 0; $s < $r['rating']; $s++)
                        <svg class="review-star" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>

                <p class="text-sm leading-relaxed flex-1 text-neutral-600" style="font-style:italic">
                    &ldquo;{{ $r['text'] }}&rdquo;
                </p>

                <div class="flex items-center gap-3 pt-2 border-t border-neutral-100">
                    <div class="review-avatar review-avatar-lg"
                         style="background: linear-gradient(135deg, {{ $r['color'] }}22, {{ $r['color'] }}44); color:{{ $r['color'] }}; border-color:{{ $r['color'] }}44">
                        {{ $r['initials'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate text-neutral-900">{{ $r['name'] }}</p>
                        <p class="text-xs truncate text-neutral-400">{{ $r['event'] }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full flex-shrink-0 bg-brand-50 text-brand-700">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ $r['tag'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── View all CTA ── --}}
        <div class="text-center mt-10">
            <a href="{{ route('reviews') }}" class="btn btn-outline btn-lg">
                Read All 500+ Reviews
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
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
        <img src="{{ asset('images/products/product-lighting.png') }}"
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
