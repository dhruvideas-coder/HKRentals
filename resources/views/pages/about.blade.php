@extends('layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn about SK Rentals — Knoxville\'s premier wedding and event rental company. Meet our team, discover our story, and see why 500+ couples trust us for their special day.')

@section('content')

{{-- ══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[70vh] flex items-center overflow-hidden" aria-labelledby="about-hero-heading">

    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/about-hero.png') }}"
             alt="SK Rentals elegant showroom interior"
             class="w-full h-full object-cover object-center"
             loading="eager" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 via-neutral-950/70 to-neutral-900/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/50 via-transparent to-transparent"></div>
    </div>

    {{-- Decorative elements --}}
    <div class="absolute top-20 right-20 w-72 h-72 rounded-full bg-brand-500/8 blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 container-sk py-28 lg:py-36 w-full">
        <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-5">
                <div class="h-px w-10 bg-brand-400"></div>
                <span class="text-brand-300 text-sm font-medium uppercase tracking-widest">Our Story</span>
            </div>
            <h1 id="about-hero-heading" class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Crafting <span class="text-gradient-gold">Unforgettable</span><br class="hidden sm:block"/>
                Moments Since 2013
            </h1>
            <p class="text-neutral-300 text-lg leading-relaxed max-w-xl">
                From a small collection of 50 rental pieces to Knoxville's most trusted event rental partner —
                our passion for perfection drives everything we do.
            </p>
        </div>
    </div>

    {{-- Stat chips floating at bottom --}}
    <div class="absolute bottom-0 left-0 right-0 z-10">
        <div class="container-sk pb-0">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-px bg-neutral-800/60 backdrop-blur-sm border-t border-white/10 overflow-hidden rounded-t-2xl">
                @foreach([['500+','Happy Couples'],['200+','Rental Items'],['10+','Years Experience'],['5★','Average Rating']] as [$num, $lbl])
                <div class="bg-neutral-900/80 backdrop-blur-sm px-6 py-5 text-center">
                    <p class="font-display text-2xl font-bold text-brand-400">{{ $num }}</p>
                    <p class="text-xs text-neutral-400 mt-0.5 uppercase tracking-wide">{{ $lbl }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     OUR STORY — Split Section
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white" aria-labelledby="story-heading">
    <div class="container-sk">
        <div class="grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">

            {{-- Images collage --}}
            <div class="relative">
                <div class="grid grid-cols-5 grid-rows-3 gap-3 aspect-square">
                    {{-- Main large image --}}
                    <div class="col-span-3 row-span-3 rounded-2xl overflow-hidden shadow-elevated">
                        <img src="{{ asset('images/about-story.png') }}"
                             alt="SK Rentals consultation session with client"
                             class="w-full h-full object-cover"
                             loading="lazy" />
                    </div>
                    {{-- Top-right stacked --}}
                    <div class="col-span-2 row-span-2 rounded-xl overflow-hidden shadow-card">
                        <img src="{{ asset('images/product-arch.png') }}"
                             alt="Floral wedding arch rental"
                             class="w-full h-full object-cover"
                             loading="lazy" />
                    </div>
                    {{-- Bottom-right --}}
                    <div class="col-span-2 row-span-1 rounded-xl overflow-hidden shadow-card">
                        <img src="{{ asset('images/product-chairs.png') }}"
                             alt="Gold chiavari chairs"
                             class="w-full h-full object-cover object-bottom"
                             loading="lazy" />
                    </div>
                </div>

                {{-- Floating quote badge --}}
                <div class="absolute -bottom-6 -left-6 bg-brand-500 text-white rounded-2xl p-5 shadow-elevated max-w-xs hidden lg:block">
                    <p class="text-sm font-medium leading-relaxed italic">
                        "We don't just rent items — we rent the building blocks of your most cherished memories."
                    </p>
                    <p class="text-xs text-brand-100 mt-2 font-semibold">— Sarah Mitchell, Founder</p>
                </div>
            </div>

            {{-- Text --}}
            <div class="lg:pt-4">
                <span class="badge badge-gold mb-4">Our Story</span>
                <h2 id="story-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 leading-tight mb-6">
                    Born From a Love of<br/>
                    <span class="text-gradient-gold">Beautiful Celebrations</span>
                </h2>
                <div class="space-y-4 text-neutral-500 text-base leading-relaxed">
                    <p>
                        SK Rentals was founded in 2013 by Sarah Mitchell, a lifelong lover of elegant design and
                        meaningful celebrations. After years of working in event planning across Tennessee, Sarah saw
                        a gap — Knoxville needed a rental partner that combined premium quality with genuine personal service.
                    </p>
                    <p>
                        Starting with just 50 carefully curated pieces out of a small warehouse, SK Rentals quickly
                        earned a reputation for reliability, beauty, and a client-first approach. Today, our
                        200+ item collection spans every style from classic romantic to modern minimalist.
                    </p>
                    <p>
                        We've had the privilege of being part of over 500 weddings, corporate events, and celebrations —
                        and each one reminds us why we do what we do.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Browse Our Collection</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-lg">Book a Consultation</a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     OUR VALUES — full-width image with overlays
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-cream" aria-labelledby="values-heading">
    <div class="container-sk">

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">What We Stand For</span>
            <h2 id="values-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Our Core Values
            </h2>
            <p class="text-neutral-500 max-w-lg mx-auto text-base leading-relaxed">
                Everything we do is guided by a commitment to quality, care, and creating moments that last a lifetime.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 items-center">

            {{-- Image side --}}
            <div class="relative h-96 lg:h-auto lg:aspect-[4/3] rounded-2xl overflow-hidden shadow-elevated order-last lg:order-first">
                <img src="{{ asset('images/about-values.png') }}"
                     alt="SK Rentals team setting up wedding reception"
                     class="w-full h-full object-cover"
                     loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/50 via-transparent to-transparent"></div>
            </div>

            {{-- Values grid --}}
            <div class="grid sm:grid-cols-2 gap-5">
                @foreach([
                    ['icon'=>'💎', 'color'=>'bg-brand-50 text-brand-600',    'title'=>'Uncompromising Quality',   'desc'=>'Every piece in our collection is hand-selected for beauty and durability. We inspect and clean each item before every event.'],
                    ['icon'=>'🤝', 'color'=>'bg-emerald-50 text-emerald-600', 'title'=>'Genuine Partnership',      'desc'=>'We build lasting relationships with our clients. Your vision becomes our mission from the first consultation to the final pickup.'],
                    ['icon'=>'⏰', 'color'=>'bg-sky-50 text-sky-600',         'title'=>'Punctual & Reliable',      'desc'=>'We understand your timeline is sacred. Our team delivers, sets up, and collects on schedule — every single time.'],
                    ['icon'=>'✨', 'color'=>'bg-violet-50 text-violet-600',   'title'=>'Attention to Detail',      'desc'=>'From the way a chair is placed to the polish on a candelabra, we obsess over the details so you don\'t have to.'],
                ] as $val)
                <div class="card p-5 hover:shadow-elevated hover:-translate-y-0.5 transition-all duration-200">
                    <div class="w-11 h-11 rounded-xl {{ $val['color'] }} flex items-center justify-center text-xl mb-4">
                        {{ $val['icon'] }}
                    </div>
                    <h3 class="font-semibold text-neutral-900 text-base mb-2">{{ $val['title'] }}</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">{{ $val['desc'] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     OUR PROCESS — Timeline Steps
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white" aria-labelledby="process-heading">
    <div class="container-sk">

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">How It Works</span>
            <h2 id="process-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Your Journey With SK Rentals
            </h2>
            <p class="text-neutral-500 max-w-lg mx-auto text-base leading-relaxed">
                From first enquiry to final pickup, we make the rental process effortless and enjoyable.
            </p>
        </div>

        {{-- Process Steps --}}
        <div class="relative">
            {{-- Connector line (desktop) --}}
            <div class="hidden lg:block absolute top-12 left-[calc(12.5%+1.5rem)] right-[calc(12.5%+1.5rem)] h-px bg-gradient-to-r from-brand-200 via-brand-400 to-brand-200 z-0"></div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach([
                    ['step'=>'01','icon'=>'💬','title'=>'Consultation',   'desc'=>'Schedule a free consultation — in-person, by phone, or online. We\'ll listen to your vision and suggest the perfect pieces.'],
                    ['step'=>'02','icon'=>'📋','title'=>'Custom Quote',    'desc'=>'Receive a detailed, transparent quote tailored to your event size, date, and style with no hidden fees.'],
                    ['step'=>'03','icon'=>'🎀','title'=>'Secure & Confirm','desc'=>'Reserve your items with a deposit. We handle all the logistics so you can focus on what matters most.'],
                    ['step'=>'04','icon'=>'🚚','title'=>'Deliver & Enjoy', 'desc'=>'Our team delivers, sets up everything perfectly, and returns after your event for seamless pickup.'],
                ] as $step)
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-brand-100 to-brand-200 border-4 border-white shadow-card flex items-center justify-center mb-5">
                        <span class="text-3xl">{{ $step['icon'] }}</span>
                    </div>
                    <span class="text-xs font-bold text-brand-500 uppercase tracking-widest mb-1">Step {{ $step['step'] }}</span>
                    <h3 class="font-display font-semibold text-neutral-900 text-lg mb-2">{{ $step['title'] }}</h3>
                    <p class="text-neutral-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-14">
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg shadow-glow">
                Start Your Consultation
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     MEET THE TEAM
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-neutral-900" aria-labelledby="team-heading">
    <div class="container-sk">

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">The People Behind the Magic</span>
            <h2 id="team-heading" class="font-display text-3xl sm:text-4xl font-semibold text-white mb-4">
                Meet Our Team
            </h2>
            <p class="text-neutral-400 max-w-lg mx-auto text-base leading-relaxed">
                Passionate, dedicated, and obsessed with creating extraordinary events.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($team as $member)
            <div class="group card bg-neutral-800 border-neutral-700 overflow-hidden hover:shadow-elevated hover:-translate-y-1 transition-all duration-300"
                 style="background: linear-gradient(145deg,#2a2620,#1e1c18);">

                {{-- Portrait --}}
                <div class="relative aspect-[3/4] overflow-hidden">
                    <img src="{{ asset('images/' . $member['image']) }}"
                         alt="{{ $member['name'] }}"
                         class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                         loading="lazy" />
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-neutral-900/20 to-transparent"></div>
                    {{-- Name overlay on image --}}
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="font-display font-semibold text-white text-xl leading-tight">{{ $member['name'] }}</h3>
                        <p class="text-brand-300 text-sm font-medium mt-0.5">{{ $member['role'] }}</p>
                    </div>
                </div>

                {{-- Bio --}}
                <div class="p-5">
                    <p class="text-neutral-400 text-sm leading-relaxed mb-4">{{ $member['bio'] }}</p>
                    <a href="mailto:{{ $member['email'] }}"
                       class="inline-flex items-center gap-1.5 text-sm text-brand-400 hover:text-brand-300 transition-base font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $member['email'] }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     MILESTONES / TIMELINE
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white" aria-labelledby="milestones-heading">
    <div class="container-sk">

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">Our Journey</span>
            <h2 id="milestones-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                A Decade of Growth
            </h2>
        </div>

        <div class="relative max-w-3xl mx-auto">
            {{-- Vertical line --}}
            <div class="absolute left-8 sm:left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-brand-200 via-brand-400 to-brand-200 -translate-x-1/2"></div>

            <div class="space-y-10">
                @foreach ($milestones as $i => $m)
                <div class="relative flex items-start sm:items-center gap-6 {{ $i % 2 === 0 ? 'sm:flex-row' : 'sm:flex-row-reverse' }}">

                    {{-- Content box --}}
                    <div class="flex-1 {{ $i % 2 === 0 ? 'sm:text-right sm:pr-10' : 'sm:text-left sm:pl-10' }} pl-16 sm:pl-0">
                        <div class="card p-5 inline-block w-full hover:shadow-elevated transition-all duration-200">
                            <span class="text-xs font-bold text-brand-500 uppercase tracking-widest">{{ $m['year'] }}</span>
                            <h3 class="font-display font-semibold text-neutral-900 text-lg mt-1 mb-1.5">{{ $m['title'] }}</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">{{ $m['desc'] }}</p>
                        </div>
                    </div>

                    {{-- Circle on timeline --}}
                    <div class="absolute left-8 sm:left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-brand-500 border-4 border-white shadow-md flex-shrink-0 z-10"></div>

                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     WAREHOUSE SECTION — Full Image Showcase
══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-cream" aria-labelledby="warehouse-heading">
    <div class="container-sk">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="badge badge-gold mb-4">Our Showroom</span>
                <h2 id="warehouse-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 leading-tight mb-5">
                    Over 200 Premium Items<br/>
                    <span class="text-gradient-gold">Ready for Your Event</span>
                </h2>
                <p class="text-neutral-500 text-base leading-relaxed mb-6">
                    Our climate-controlled showroom in Knoxville houses our entire collection. Every item is
                    meticulously maintained, professionally cleaned, and ready to impress. We invite you to
                    visit and experience the quality firsthand.
                </p>
                <ul class="space-y-3 mb-8">
                    @foreach([
                        'Chairs, tables & lounge furniture',
                        'Floral arrangements & backdrops',
                        'Tableware, linen & centerpieces',
                        'Lighting, draping & ambiance decor',
                        'Ceremony arches & aisle accents',
                    ] as $item)
                    <li class="flex items-center gap-3 text-sm text-neutral-600">
                        <div class="w-5 h-5 rounded-full bg-brand-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">Schedule a Showroom Visit</a>
            </div>
            <div class="relative">
                <div class="rounded-2xl overflow-hidden shadow-elevated aspect-[4/3]">
                    <img src="{{ asset('images/about-warehouse.png') }}"
                         alt="SK Rentals showroom and warehouse"
                         class="w-full h-full object-cover"
                         loading="lazy" />
                </div>
                {{-- Floating tag --}}
                <div class="absolute -top-4 -right-4 bg-white border border-neutral-100 rounded-xl shadow-card px-4 py-3 hidden sm:block">
                    <p class="text-xs text-neutral-400 uppercase tracking-wide font-medium">Location</p>
                    <p class="font-semibold text-neutral-900 text-sm mt-0.5">Knoxville, TN</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CTA — Full Width
══════════════════════════════════════════════════════════ --}}
<section class="relative py-24 overflow-hidden bg-neutral-950" aria-labelledby="about-cta-heading">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero.png') }}"
             alt="Wedding reception"
             class="w-full h-full object-cover opacity-30" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 to-brand-950/80"></div>
    </div>
    <div class="relative z-10 container-sk text-center">
        <span class="badge badge-gold mb-5">Ready to Start?</span>
        <h2 id="about-cta-heading" class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-5 leading-tight">
            Let's Create Something<br class="hidden sm:block"/>
            <span class="text-gradient-gold">Beautiful Together</span>
        </h2>
        <p class="text-neutral-300 text-base mb-8 max-w-lg mx-auto leading-relaxed">
            Your dream event is just one conversation away. Get in touch with our team today for a free consultation.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg shadow-glow">
                Get in Touch
            </a>
            <a href="{{ route('products') }}" class="btn btn-lg border-white/30 text-white hover:bg-white/10">
                View Collection
            </a>
        </div>
    </div>
</section>

@endsection
