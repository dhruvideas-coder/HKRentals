<x-layout.app-layout>
    <x-slot:title>Client Reviews</x-slot>
    <x-slot:metaDescription>Read what our 500+ happy clients say about HK Rentals — Knoxville's top-rated wedding and event rental company.</x-slot>

{{-- ══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[55vh] flex items-center overflow-hidden" aria-labelledby="reviews-hero-heading">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/about-hero.png') }}"
             alt="Happy clients at an HK Rentals event"
             class="w-full h-full object-cover object-center"
             loading="eager" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/92 via-neutral-950/75 to-neutral-900/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/50 via-transparent to-transparent"></div>
    </div>

    <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-brand-500/8 blur-3xl pointer-events-none z-0"></div>

    <div class="relative z-10 container-sk py-24 lg:py-32 w-full">
        <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-5">
                <div class="h-px w-10 bg-brand-400"></div>
                <span class="text-brand-300 text-sm font-medium uppercase tracking-widest">Client Stories</span>
            </div>
            <h1 id="reviews-hero-heading" class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Trusted by <span class="text-gradient-gold">500+</span><br class="hidden sm:block"/>
                Happy Families
            </h1>
            <p class="text-neutral-300 text-lg leading-relaxed max-w-xl mb-8">
                Every event is a new story. Here's what our clients say about working with HK Rentals to create their perfect day.
            </p>
            {{-- Star rating row --}}
            <div class="flex items-center gap-4">
                <div class="flex gap-1">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-6 h-6 text-brand-400 drop-shadow-glow" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span class="text-white font-bold text-2xl leading-none">5.0</span>
                <span class="text-neutral-400 text-sm border-l border-neutral-700 pl-4">Rated 5 stars across 500+ reviews</span>
            </div>
        </div>
    </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     FEATURED REVIEW (full-width)
══════════════════════════════════════════════════════════ --}}
{{-- <section class="bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 py-16 sm:py-20" aria-label="Featured review">
    <div class="container-sk">
        <div class="max-w-3xl mx-auto text-center">
            <svg class="w-12 h-12 text-brand-300/50 mx-auto mb-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            <p class="text-white text-xl sm:text-2xl leading-relaxed font-light italic mb-8">
                "HK Rentals transformed our backyard into an absolute fairytale. The attention to detail, the quality of every piece, and the professionalism of the entire team made our wedding day completely stress-free. I couldn't have asked for a more perfect experience."
            </p>
            <div class="flex items-center justify-center gap-4">
                <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg"
                     style="background: linear-gradient(135deg, #c8903a44, #c8903a88); border: 2px solid #c8903a66">
                    EW
                </div>
                <div class="text-left">
                    <p class="text-white font-semibold text-lg">Emily & James Watson</p>
                    <p class="text-brand-200 text-sm">Wedding · May 2025 · Knoxville, TN</p>
                    <div class="flex gap-0.5 mt-1">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- ══════════════════════════════════════════════════════════
     REVIEWS GRID
══════════════════════════════════════════════════════════ --}}
<section class="reviews-section-bg py-10 sm:py-20" aria-labelledby="all-reviews-heading">
    <div class="container-sk">

        <div class="text-center mb-14">
            <span class="badge badge-gold mb-3">⭐ All Reviews</span>
            <h2 id="all-reviews-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-4">
                Real Stories, <span class="text-gradient-gold">Real Joy</span>
            </h2>
            <p class="text-neutral-500 max-w-md mx-auto">
                Hear directly from the couples, families, and businesses who trusted us with their most important moments.
            </p>
        </div>

        @php
        $allReviews = [
            ['initials'=>'EW', 'name'=>'Emily & James Watson',   'event'=>'Wedding · May 2025',           'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#c8903a', 'text'=>'HK Rentals made our wedding day absolutely magical. The gold chiavari chairs and floral arch were beyond beautiful. Everything arrived perfectly on time and the setup team was so kind and professional!'],
            ['initials'=>'OC', 'name'=>'Olivia Chen',            'event'=>'Corporate Gala · Mar 2025',    'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#8e6024', 'text'=>'We hired HK Rentals for our annual company gala and the results were stunning. The lounge suite and lighting created such an elegant atmosphere. Highly recommend for any corporate event!'],
            ['initials'=>'SB', 'name'=>'Sarah & Michael Brown',  'event'=>'Wedding · Jan 2025',           'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#b07a2e', 'text'=>'From the first enquiry to the final pickup, the team was professional and genuinely caring. Our guests could not stop complimenting the beautiful decor. Truly a dream team.'],
            ['initials'=>'RT', 'name'=>'Rachel Thompson',        'event'=>'Baby Shower · Apr 2025',       'rating'=>5, 'tag'=>'Repeat Customer', 'color'=>'#c8903a', 'text'=>'I rented the tableware set and beautiful backdrop panels. Everything was pristine, exactly as shown, and delivery was seamless. Will absolutely use again for every party I host!'],
            ['initials'=>'MK', 'name'=>'Marcus & Kim Lee',       'event'=>'Anniversary · Feb 2025',       'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#6e4a1c', 'text'=>'The string light canopy transformed our backyard into a fairytale. Setup crew was fast, professional, and left everything spotless. Truly world-class service from start to finish.'],
            ['initials'=>'JD', 'name'=>'Jessica Davis',          'event'=>'Bridal Shower · Mar 2025',     'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#b07a2e', 'text'=>'From the moment I reached out, the HK Rentals team was attentive and full of great ideas. The lounge furniture was gorgeous and everything fit perfectly in the space.'],
            ['initials'=>'TN', 'name'=>'Thomas & Nancy Patel',   'event'=>'Wedding · Apr 2025',           'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#c8903a', 'text'=>'We had 250 guests and everything was flawless — from the sweetheart table to the centerpieces. The HK team worked tirelessly and the result was jaw-dropping. Every photo is stunning.'],
            ['initials'=>'AM', 'name'=>'Angela Martinez',        'event'=>'Quinceañera · Dec 2024',       'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#9e6818', 'text'=>'My daughter\'s quinceañera was a night she\'ll never forget. The floral backdrop and gold accents were absolutely perfect. HK Rentals made the whole experience so easy and enjoyable.'],
            ['initials'=>'BW', 'name'=>'Brandon & Lisa White',   'event'=>'Wedding · Nov 2024',           'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#8e5e14', 'text'=>'Five stars isn\'t enough. The team exceeded every single expectation. The farm tables and crossback chairs gave our barn wedding exactly the rustic-chic look we dreamed of.'],
            ['initials'=>'CP', 'name'=>'Claire Patterson',       'event'=>'Corporate Event · Oct 2024',   'rating'=>5, 'tag'=>'Repeat Customer', 'color'=>'#c8903a', 'text'=>'I\'ve now used HK Rentals for three consecutive company events. The consistency of quality and service is unmatched in Knoxville. They\'re our go-to partner for everything.'],
            ['initials'=>'GH', 'name'=>'George & Helen Murphy',  'event'=>'50th Anniversary · Sep 2024',  'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#b07a2e', 'text'=>'We wanted to renew our vows on our 50th anniversary with an intimate backyard dinner. HK Rentals set up the most elegant table for 30 guests. We cried happy tears all evening.'],
            ['initials'=>'KS', 'name'=>'Kayla Simmons',          'event'=>'Baby Shower · Aug 2024',       'rating'=>5, 'tag'=>'Verified Client',  'color'=>'#6e4a1c', 'text'=>'I had about 60 guests for my baby shower and the decor was absolutely immaculate. The rose gold candles and floral wall backdrop made for the most beautiful photos. Highly recommend!'],
        ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allReviews as $r)
            <div class="card p-6 flex flex-col gap-4 hover:shadow-elevated hover:-translate-y-0.5 transition-all duration-200">
                {{-- Stars --}}
                <div class="flex gap-0.5">
                    @for ($s = 0; $s < $r['rating']; $s++)
                        <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>

                {{-- Text --}}
                <p class="text-neutral-600 text-sm leading-relaxed flex-1 italic">
                    "{{ $r['text'] }}"
                </p>

                {{-- Author --}}
                <div class="flex items-center gap-3 pt-3 border-t border-neutral-100">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                         style="background: linear-gradient(135deg, {{ $r['color'] }}22, {{ $r['color'] }}44); color:{{ $r['color'] }}; border: 1.5px solid {{ $r['color'] }}44">
                        {{ $r['initials'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-neutral-900 truncate">{{ $r['name'] }}</p>
                        <p class="text-xs text-neutral-400 truncate">{{ $r['event'] }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2 py-1 rounded-full bg-brand-50 text-brand-700 flex-shrink-0">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $r['tag'] }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Trust strip --}}
        <div class="mt-16 pt-10 border-t border-neutral-200 flex flex-wrap items-center justify-center gap-8 text-sm text-neutral-500">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                All reviews from verified clients
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Rated 5.0 stars across 500+ events
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Trusted by Knoxville families since 2014
            </span>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════════════ --}}
<section class="relative py-20 overflow-hidden" aria-labelledby="reviews-cta-heading">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ceremony.png') }}"
             alt="Beautiful event setup"
             class="w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/92 to-brand-800/88"></div>
    </div>
    <div class="relative z-10 container-sk text-center">
        <span class="badge badge-gold mb-5">Join Our Happy Clients</span>
        <h2 id="reviews-cta-heading" class="font-display text-3xl sm:text-4xl font-semibold text-white mb-5 leading-tight">
            Ready to Create Your<br class="hidden sm:block"/> Own Story?
        </h2>
        <p class="text-brand-100 mb-8 text-base max-w-lg mx-auto leading-relaxed">
            Let us help you design the perfect event. Browse our full catalogue and check availability for your date.
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
