@if(auth()->check())
<div x-data="sessionTimeout()"
     x-init="init()"
     @click.window="if(showModal) stayLoggedIn()"
     @keydown.window="if(showModal) stayLoggedIn()"
     @scroll.window="if(showModal) stayLoggedIn()">

    {{-- Logout Form --}}
    <form id="auto-logout-form" action="{{ Auth::user() && Auth::user()->isAdmin() ? route('admin.logout') : route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <template x-if="showModal">
        {{-- Full-screen overlay — z-[9999] beats sidebar (z-50) and topbar (z-30) --}}
        <div class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-10 sm:py-16">

            {{-- Backdrop: heavy warm-white blur — completely hides sidebar & header --}}
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0"
                 style="background: rgba(248, 246, 243, 0.92); backdrop-filter: blur(32px); -webkit-backdrop-filter: blur(32px);">
            </div>

            {{-- Modal Card --}}
            <div x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-3"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                 class="relative w-full max-w-sm bg-white rounded-2xl overflow-hidden overflow-y-auto"
                 style="box-shadow: 0 24px 64px rgba(0,0,0,0.11), 0 4px 16px rgba(0,0,0,0.05); max-height: calc(100dvh - 5rem);">

                {{-- Gold top accent line --}}
                <div class="h-1 flex-shrink-0" style="background: linear-gradient(90deg, #d4a452, #c8903a, #b07a2e);"></div>

                <div class="px-6 pt-6 pb-5 sm:px-8 sm:pt-7 sm:pb-6">

                    {{-- Countdown Ring --}}
                    <div class="flex justify-center mb-4">
                        <div class="relative w-20 h-20 sm:w-24 sm:h-24">
                            <svg class="w-full h-full -rotate-90" viewBox="0 0 96 96">
                                <circle cx="48" cy="48" r="42" fill="none" stroke="#f0ece6" stroke-width="5"/>
                                <circle cx="48" cy="48" r="42" fill="none" stroke="#c8903a" stroke-width="5"
                                        stroke-linecap="round"
                                        :stroke-dasharray="263.89"
                                        :stroke-dashoffset="263.89 * (1 - countdown / 30)"
                                        style="transition: stroke-dashoffset 1s linear;" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold leading-none text-neutral-800" x-text="countdown"></span>
                                <span class="text-[9px] font-bold uppercase tracking-widest mt-0.5" style="color: #c8903a;">sec</span>
                            </div>
                        </div>
                    </div>

                    {{-- Icon badge --}}
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 border border-amber-200">
                            <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                <line x1="12" y1="9" x2="12" y2="13"/>
                                <line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                            <span class="text-xs font-semibold text-amber-600">Session Expiring</span>
                        </div>
                    </div>

                    {{-- Title & Message --}}
                    <div class="text-center mb-5">
                        <h3 class="text-lg font-bold text-neutral-800 mb-1.5">Still here?</h3>
                        <p class="text-sm text-neutral-500 leading-relaxed">
                            You'll be signed out in
                            <span class="font-semibold text-neutral-700" x-text="countdown"></span>
                            seconds due to inactivity.
                            Click anywhere or tap below to stay.
                        </p>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-2">
                        {{-- Primary --}}
                        <button @click="stayLoggedIn()"
                                class="w-full py-3 px-6 rounded-xl text-sm font-bold text-white tracking-wide transition-all duration-150 active:scale-[0.98]"
                                style="background: linear-gradient(135deg, #d4a452 0%, #c8903a 100%); box-shadow: 0 4px 16px rgba(200,144,58,0.4);"
                                onmouseover="this.style.boxShadow='0 6px 24px rgba(200,144,58,0.55)'; this.style.filter='brightness(1.05)'"
                                onmouseout="this.style.boxShadow='0 4px 16px rgba(200,144,58,0.4)'; this.style.filter='brightness(1)'">
                            Keep Me Logged In
                        </button>

                        {{-- Secondary --}}
                        <button @click="logoutNow()"
                                class="w-full py-2.5 px-6 rounded-xl text-sm font-medium text-neutral-400 border border-neutral-200 bg-white transition-all duration-150 hover:border-neutral-300 hover:text-neutral-600 hover:bg-neutral-50 active:scale-[0.98]">
                            Sign Out Now
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </template>
</div>

<script>
function sessionTimeout() {
    return {
        showModal: false,
        timer: null,
        countdown: 30,
        countdownInterval: null,
        // inactivityTime: 30 * 1000, // 30 seconds — testing mode
        inactivityTime: 5 * 60 * 1000, // 5 Minutes

        init() {
            this.resetTimer();
            ['mousedown', 'keydown', 'scroll', 'touchstart'].forEach(event => {
                window.addEventListener(event, () => {
                    if (!this.showModal) this.resetTimer();
                }, { passive: true });
            });
        },

        resetTimer() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.showWarning(), this.inactivityTime);
        },

        showWarning() {
            this.showModal = true;
            this.countdown = 30;
            this.countdownInterval = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) this.logoutNow();
            }, 1000);
        },

        stayLoggedIn() {
            if (!this.showModal) return;
            this.showModal = false;
            clearInterval(this.countdownInterval);
            this.resetTimer();
            fetch('{{ route("home") }}', { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        },

        logoutNow() {
            clearInterval(this.countdownInterval);
            document.getElementById('auto-logout-form').submit();
        }
    }
}
</script>
@endif
