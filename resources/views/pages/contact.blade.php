<x-layout.app-layout>
    <x-slot:title>Contact Us</x-slot>
    <x-slot:metaDescription>Contact HK Rentals — Knoxville's premier wedding and event rental company. Reach out to book a consultation, check availability, or get a custom quote.</x-slot>


{{-- ══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════ --}}
<section class="relative h-72 sm:h-96 flex items-center overflow-hidden" aria-labelledby="contact-hero-heading">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/contact-hero.png') }}"
             alt="HK Rentals consultation office"
             class="w-full h-full object-cover object-center"
             loading="eager" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/88 via-neutral-900/70 to-neutral-900/30"></div>
    </div>
    <div class="relative z-10 container-sk">
        <div class="flex items-center gap-2 mb-4">
            <div class="h-px w-8 bg-brand-400"></div>
            <span class="text-brand-300 text-sm uppercase tracking-widest">Get In Touch</span>
        </div>
        <h1 id="contact-hero-heading" class="font-display text-4xl sm:text-5xl font-bold text-white leading-tight mb-3">
            We'd Love to <span class="text-gradient-gold">Hear From You</span>
        </h1>
        <p class="text-neutral-300 text-base max-w-md leading-relaxed">
            Whether you're planning your dream wedding or a corporate event, we're here to help you every step of the way.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     CONTACT INFO CARDS
══════════════════════════════════════════════════════════ --}}
<section class="bg-cream py-0" aria-label="Contact information">
    <div class="container-sk -mt-8 relative z-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                [
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>',
                    'label' => 'Call Us',
                    'value' => '+1 9312152756',
                    'sub'   => 'Mon–Sat, 9am–6pm EST',
                    'color' => 'from-brand-500 to-brand-700',
                ],
                [
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    'label' => 'Email Us',
                    'value' => 'hello@skrentals.com',
                    'sub'   => 'We reply within 24 hours',
                    'color' => 'from-emerald-500 to-emerald-700',
                ],
                [
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'label' => 'Visit Us',
                    'value' => 'Knoxville, TN',
                    'sub'   => 'Showroom by appointment',
                    'color' => 'from-sky-500 to-sky-700',
                ],
                [
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'label' => 'Hours',
                    'value' => 'Mon–Sat 9am–6pm',
                    'sub'   => 'Sunday by appointment',
                    'color' => 'from-violet-500 to-violet-700',
                ],
            ] as $info)
            <div class="card p-5 flex items-start gap-4 hover:shadow-elevated transition-all duration-200">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $info['color'] }} flex items-center justify-center flex-shrink-0 shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">{!! $info['icon'] !!}</svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">{{ $info['label'] }}</p>
                    <p class="font-semibold text-neutral-900 text-sm mt-0.5 truncate">{{ $info['value'] }}</p>
                    <p class="text-xs text-neutral-400 mt-0.5">{{ $info['sub'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     MAIN CONTENT: FORM + SIDE INFO
══════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-cream" aria-labelledby="contact-form-heading">
    <div class="container-sk">
        <div class="grid lg:grid-cols-5 gap-10 lg:gap-14">

            {{-- ── CONTACT FORM (3 cols) ── --}}
            <div class="lg:col-span-3">
                <div class="card p-6 sm:p-8">
                    <h2 id="contact-form-heading" class="font-display text-2xl font-semibold text-neutral-900 mb-1">
                        Send Us a Message
                    </h2>
                    <p class="text-neutral-500 text-sm mb-7">
                        Fill in the form below and our team will get back to you within 24 hours.
                    </p>

                    {{-- Success Flash --}}
                    @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start gap-3" role="alert">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200" role="alert">
                        <p class="text-red-700 text-sm font-semibold mb-2">Please fix the following:</p>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-sm flex items-center gap-1.5">
                                <span class="w-1 h-1 rounded-full bg-red-400 flex-shrink-0"></span>{{ $error }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}" x-data="{
                        submitting: false,
                        handleSubmit(e) {
                            this.submitting = true;
                            e.target.submit();
                        }
                    }" @submit.prevent="handleSubmit">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5 mb-5">
                            {{-- Full Name --}}
                            <div>
                                <label for="contact_name" class="form-label">
                                    Full Name <span class="text-red-400">*</span>
                                </label>
                                <input type="text"
                                       id="contact_name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-input @error('name') border-red-300 focus:ring-red-200 @enderror"
                                       placeholder="Jane & John Smith"
                                       required />
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="contact_email" class="form-label">
                                    Email Address <span class="text-red-400">*</span>
                                </label>
                                <input type="email"
                                       id="contact_email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-input @error('email') border-red-300 @enderror"
                                       placeholder="you@example.com"
                                       required />
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="contact_phone" class="form-label">
                                    Phone Number
                                    <span class="text-neutral-400 font-normal">(Optional)</span>
                                </label>
                                <input type="tel"
                                       id="contact_phone"
                                       name="phone"
                                       inputmode="tel"
                                       value="{{ old('phone') }}"
                                       class="form-input"
                                       placeholder="+1 9312152756" />
                            </div>

                            {{-- Event Type --}}
                            <div>
                                <label for="contact_event_type" class="form-label">Event Type</label>
                                <select id="contact_event_type" name="event_type" class="form-input">
                                    <option value="">— Select event type —</option>
                                    <option value="wedding" {{ old('event_type') === 'wedding' ? 'selected' : '' }}>Wedding</option>
                                    <option value="reception" {{ old('event_type') === 'reception' ? 'selected' : '' }}>Wedding Reception</option>
                                    <option value="engagement" {{ old('event_type') === 'engagement' ? 'selected' : '' }}>Engagement Party</option>
                                    <option value="corporate" {{ old('event_type') === 'corporate' ? 'selected' : '' }}>Corporate Event</option>
                                    <option value="birthday" {{ old('event_type') === 'birthday' ? 'selected' : '' }}>Birthday / Celebration</option>
                                    <option value="other" {{ old('event_type') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        {{-- Event Date --}}
                        <div class="mb-5">
                            <label for="contact_event_date" class="form-label">
                                Event Date
                                <span class="text-neutral-400 font-normal">(If known)</span>
                            </label>
                            <input type="date"
                                   id="contact_event_date"
                                   name="event_date"
                                   value="{{ old('event_date') }}"
                                   class="form-input @error('event_date') border-red-300 @enderror"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
                            @error('event_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="mb-7">
                            <label for="contact_message" class="form-label">
                                Message <span class="text-red-400">*</span>
                            </label>
                            <textarea id="contact_message"
                                      name="message"
                                      rows="5"
                                      class="form-input resize-none @error('message') border-red-300 @enderror"
                                      placeholder="Tell us about your event vision, the items you're interested in, and any questions you have..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                id="contact-submit-btn"
                                class="btn btn-primary btn-lg w-full shadow-glow"
                                :class="submitting ? 'opacity-70 cursor-wait pointer-events-none' : ''"
                                :disabled="submitting">
                            <span x-show="!submitting" class="flex items-center gap-2">
                                Send Message
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </span>
                            <span x-show="submitting" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Sending…
                            </span>
                        </button>

                        <p class="text-xs text-neutral-400 text-center mt-4">
                            🔒 Your information is secure and will never be shared with third parties.
                        </p>
                    </form>
                </div>
            </div>

            {{-- ── SIDE INFO (2 cols) ── --}}
            <div class="lg:col-span-2 flex flex-col gap-6">

                {{-- Image card --}}
                <div class="relative rounded-2xl overflow-hidden shadow-elevated h-52 lg:h-64 flex-shrink-0">
                    <img src="{{ asset('images/about-story.png') }}"
                         alt="HK Rentals consultation"
                         class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/70 via-transparent to-transparent flex items-end p-5">
                        <div>
                            <p class="text-white font-display font-semibold text-lg leading-tight">Schedule a free consultation</p>
                            <p class="text-neutral-300 text-sm mt-1">In-person or virtual — your choice.</p>
                        </div>
                    </div>
                </div>

                {{-- Social & Direct Links --}}
                <div class="card p-6">
                    <h3 class="font-semibold text-neutral-900 mb-4 text-base">Connect With Us</h3>
                    <div class="space-y-3">
                        @foreach([
                            ['label'=>'Facebook',  'handle'=>'@SKRentalsKnoxville', 'color'=>'text-blue-600 bg-blue-50',   'icon'=>'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                            ['label'=>'Instagram', 'handle'=>'@hk_rentals',          'color'=>'text-pink-600 bg-pink-50',   'icon'=>'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM2 2h20v20H2z'],
                            ['label'=>'Pinterest', 'handle'=>'HK Rentals Board',     'color'=>'text-red-600 bg-red-50',    'icon'=>'M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782'],
                        ] as $social)
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 transition-base group">
                            <div class="w-9 h-9 rounded-lg {{ $social['color'] }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $social['icon'] }}"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-neutral-900">{{ $social['label'] }}</p>
                                <p class="text-xs text-neutral-400">{{ $social['handle'] }}</p>
                            </div>
                            <svg class="w-4 h-4 text-neutral-300 ml-auto group-hover:text-brand-400 transition-base" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Business Hours --}}
                <div class="card p-6">
                    <h3 class="font-semibold text-neutral-900 mb-4 text-base flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Business Hours
                    </h3>
                    <div class="space-y-2.5">
                        @foreach([
                            ['day'=>'Monday – Friday',  'hours'=>'9:00 AM – 6:00 PM', 'open'=>true],
                            ['day'=>'Saturday',         'hours'=>'10:00 AM – 5:00 PM','open'=>true],
                            ['day'=>'Sunday',           'hours'=>'By Appointment',    'open'=>false],
                        ] as $hours)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-600 font-medium">{{ $hours['day'] }}</span>
                            <span class="{{ $hours['open'] ? 'text-neutral-900' : 'text-neutral-400 italic' }} font-medium">
                                {{ $hours['hours'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-neutral-100">
                        <p class="text-xs text-neutral-400">All times in Eastern Standard Time (EST)</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     MAP PLACEHOLDER
══════════════════════════════════════════════════════════ --}}
<section class="relative h-72 bg-neutral-200 overflow-hidden" aria-label="Location map">
    {{-- Use the ceremony image as a map stand-in with overlay --}}
    <img src="{{ asset('images/ceremony.png') }}"
         alt="HK Rentals location in Knoxville Tennessee"
         class="w-full h-full object-cover object-center opacity-50" />
    <div class="absolute inset-0 bg-neutral-900/60 flex items-center justify-center">
        <div class="text-center">
            <div class="w-12 h-12 rounded-full bg-brand-500 flex items-center justify-center mx-auto mb-3 shadow-glow">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-white font-display font-semibold text-xl mb-1">Knoxville, Tennessee</p>
            <p class="text-neutral-300 text-sm mb-4">Serving a 60-mile radius across East Tennessee</p>
            <a href="https://maps.google.com/?q=Knoxville,Tennessee"
               target="_blank"
               rel="noopener noreferrer"
               class="btn btn-primary btn-sm">
                Open in Google Maps
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     FAQ ACCORDION
══════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white" aria-labelledby="faq-heading">
    <div class="container-sk max-w-4xl">

        <div class="text-center mb-12">
            <span class="badge badge-gold mb-3">FAQ</span>
            <h2 id="faq-heading" class="font-display text-3xl sm:text-4xl font-semibold text-neutral-900 mb-3">
                Frequently Asked Questions
            </h2>
            <p class="text-neutral-500 text-base leading-relaxed">
                Can't find your answer? <a href="mailto:hello@skrentals.com" class="text-brand-600 hover:text-brand-700 font-medium">Email us directly →</a>
            </p>
        </div>

        <div class="space-y-3" x-data="{ openFaq: null }">
            @foreach ($faqs as $i => $faq)
            <div class="card overflow-hidden"
                 x-data="{ open: false }"
                 :class="open ? 'shadow-soft border-brand-200' : ''">
                <button @click="open = !open"
                        :aria-expanded="open"
                        aria-controls="faq-answer-{{ $i }}"
                        class="w-full flex items-center justify-between p-5 text-left hover:bg-neutral-50/50 transition-base">
                    <span class="font-semibold text-neutral-900 text-base pr-4 leading-snug">{{ $faq['q'] }}</span>
                    <div class="flex-shrink-0 w-7 h-7 rounded-full border-2 border-neutral-200 flex items-center justify-center transition-all duration-200"
                         :class="open ? 'bg-brand-500 border-brand-500 rotate-180' : ''">
                        <svg class="w-3.5 h-3.5 transition-colors duration-200"
                             :class="open ? 'text-white' : 'text-neutral-400'"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div id="faq-answer-{{ $i }}"
                     x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="px-5 pb-5">
                    <div class="h-px bg-neutral-100 mb-4"></div>
                    <p class="text-neutral-600 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     BOTTOM CTA — TESTIMONIAL STYLE
══════════════════════════════════════════════════════════ --}}
<section class="relative py-20 overflow-hidden" aria-labelledby="contact-bottom-cta">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/product-lighting.png') }}"
             alt="Beautiful fairy light wedding reception"
             class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-br from-brand-950/92 to-neutral-950/90"></div>
    </div>
    <div class="relative z-10 container-sk text-center">
        <div class="max-w-2xl mx-auto">
            {{-- Quotation mark --}}
            <div class="text-6xl text-brand-400 font-display leading-none mb-4 opacity-50">"</div>
            <blockquote class="font-display text-xl sm:text-2xl text-white font-medium leading-relaxed mb-6 italic">
                Working with HK Rentals was the best decision we made for our wedding.
                Every piece was stunning and the team handled everything flawlessly.
            </blockquote>
            <div class="flex items-center justify-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold text-sm">A</div>
                <div class="text-left">
                    <p class="text-white text-sm font-semibold">Ashley &amp; Marcus W.</p>
                    <p class="text-neutral-400 text-xs">Wedding — September 2024, Knoxville TN</p>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}#contact_name" class="btn btn-primary btn-lg shadow-glow">
                    Start Planning Your Event
                </a>
                <a href="{{ route('about') }}" class="btn btn-lg border-white/25 text-white hover:bg-white/10">
                    Learn About Us
                </a>
            </div>
        </div>
    </div>
</section>

</x-layout.app-layout>
