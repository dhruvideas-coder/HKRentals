<footer class="bg-neutral-900 text-white" role="contentinfo">

    <div class="container-sk py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand Column --}}
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center">
                        <span class="text-white font-display font-bold text-sm">SK</span>
                    </div>
                    <span class="font-display text-xl font-semibold">SK <span class="text-gradient-gold">Rentals</span></span>
                </a>
                <p class="text-neutral-400 text-sm leading-relaxed max-w-sm">
                    Premium wedding and event rental services in Knoxville. We provide elegant decor,
                    furniture, and essentials to make your special day unforgettable.
                </p>
                {{-- Social links placeholder --}}
                <div class="flex items-center gap-3 mt-5">
                    <a href="#" aria-label="Facebook" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-500/30 flex items-center justify-center transition-base">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-500/30 flex items-center justify-center transition-base">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" aria-label="Pinterest" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-500/30 flex items-center justify-center transition-base">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="font-semibold text-white text-sm uppercase tracking-widest mb-4 text-gradient-gold">Quick Links</h3>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}"     class="text-neutral-400 hover:text-white text-sm transition-base">Home</a></li>
                    <li><a href="{{ route('products') }}" class="text-neutral-400 hover:text-white text-sm transition-base">Products</a></li>
                    <li><a href="{{ route('about') }}"    class="text-neutral-400 hover:text-white text-sm transition-base">About Us</a></li>
                    <li><a href="{{ route('products') }}" class="text-neutral-400 hover:text-white text-sm transition-base">Gallery</a></li>
                    <li><a href="{{ route('contact') }}"  class="text-neutral-400 hover:text-white text-sm transition-base">Contact</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="font-semibold text-white text-sm uppercase tracking-widest mb-4 text-gradient-gold">Contact Us</h3>
                <ul class="space-y-3 text-sm text-neutral-400">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-brand-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Knoxville, Tennessee, USA
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +1 9312152756
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        hello@skrentals.com
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="container-sk py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-neutral-500">
            <p>&copy; {{ date('Y') }} HK Rentals. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-white transition-base">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-base">Terms of Service</a>
            </div>
        </div>
    </div>

</footer>
