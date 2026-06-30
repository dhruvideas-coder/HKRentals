<x-layout.admin-layout>
    <x-slot:title>Send Email — Order #{{ $order->formatted_id }}</x-slot>
    <x-slot:pageTitle>Send Confirmation Email</x-slot>

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-neutral-400 mb-6 flex-wrap">
    <a href="{{ route('admin.orders.index') }}" class="hover:text-brand-600 transition-colors font-medium">Orders</a>
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-brand-600 transition-colors font-medium">#{{ $order->formatted_id }}</a>
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    <span class="text-neutral-600 font-semibold">Send Email</span>
</div>

@if ($errors->any())
    <div class="mb-4 p-3.5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm" role="alert">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.orders.send-email', $order) }}" method="POST"
      x-data="{
          subject: @js(old('subject', $email['subject'])),
          body: @js(old('body', $email['body'])),
          sending: false
      }"
      @submit="sending = true"
      class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
    @csrf

    {{-- ── LEFT: Editor ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
        <div class="px-5 sm:px-6 py-5 border-b border-neutral-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-4.5 h-4.5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-neutral-900">Compose Email</h3>
                <p class="text-xs text-neutral-400 mt-0.5">Review and edit before sending to the customer.</p>
            </div>
        </div>

        <div class="p-5 sm:p-6 space-y-5">

            {{-- From --}}
            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-0.5">From</label>
                <div class="flex items-center gap-2.5 px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl">
                    <svg class="w-4 h-4 text-neutral-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                    <span class="text-sm text-neutral-700 font-medium truncate">
                        {{ $fromName }} <span class="text-neutral-400">&lt;{{ $fromAddress }}&gt;</span>
                    </span>
                </div>
                <p class="text-[11px] text-neutral-400 mt-1.5 ml-0.5">Configured sender address. Change it in your mail settings.</p>
            </div>

            {{-- To --}}
            <div>
                <label class="block text-[11px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-0.5">To</label>
                <div class="flex items-center gap-2.5 px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-[11px] flex-shrink-0">
                        {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                    </div>
                    <span class="text-sm text-neutral-700 font-medium truncate">
                        {{ $order->customer_name }} <span class="text-neutral-400">&lt;{{ $order->customer_email }}&gt;</span>
                    </span>
                </div>
            </div>

            {{-- Subject --}}
            <div>
                <label for="subject" class="block text-[11px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-0.5">Subject</label>
                <input type="text" name="subject" id="subject" x-model="subject" maxlength="255"
                       class="block w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold shadow-sm"
                       required>
            </div>

            {{-- Body --}}
            <div>
                <label for="body" class="block text-[11px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 ml-0.5">Message</label>
                <textarea name="body" id="body" x-model="body" rows="12"
                          class="block w-full px-4 py-3.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium shadow-sm leading-relaxed resize-y"
                          required></textarea>
                <p class="text-[11px] text-neutral-400 mt-1.5 ml-0.5">The full order summary &amp; PDF invoice are attached automatically below your message.</p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse sm:flex-row items-center gap-3 pt-2">
                <a href="{{ route('admin.orders.show', $order) }}"
                   class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-3 bg-white text-neutral-600 border border-neutral-200 text-sm font-bold rounded-xl hover:bg-neutral-50 transition-all">
                    Cancel
                </a>
                <button type="submit" :disabled="sending"
                        class="w-full sm:flex-1 justify-center inline-flex items-center gap-2 px-5 py-3 bg-brand-600 text-white text-sm font-bold rounded-xl hover:bg-brand-700 transition-all shadow-sm shadow-brand-200 disabled:opacity-70 disabled:cursor-not-allowed">
                    <svg x-show="sending" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <svg x-show="!sending" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span x-text="sending ? 'Sending…' : 'Send to ' + @js($order->customer_email)"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Live preview ── --}}
    <div class="lg:sticky lg:top-6">
        <div class="flex items-center gap-2 mb-3 ml-0.5">
            <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span class="text-[11px] font-bold text-neutral-400 uppercase tracking-widest">Live Preview</span>
        </div>

        <div class="rounded-2xl overflow-hidden shadow-sm border border-neutral-200 bg-[#f5f2ee]">
            {{-- Subject bar --}}
            <div class="px-5 py-3 bg-white border-b border-neutral-100">
                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Subject</p>
                <p class="text-sm font-bold text-neutral-900 mt-0.5 break-words" x-text="subject || '(no subject)'"></p>
            </div>

            <div class="p-4 sm:p-6">
                <div class="max-w-[600px] mx-auto bg-white rounded-2xl overflow-hidden shadow">
                    {{-- Email header --}}
                    <div style="background:#1a1a1a" class="px-6 py-5 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-white rounded-lg px-2.5 py-1.5">
                                <img src="{{ asset('images/logo.webp') }}" alt="{{ config('app.name', 'SK Rentals') }}" class="h-7 w-auto" />
                            </div>
                            <div>
                                <div style="color:#c8a96e" class="font-display text-base font-bold leading-tight tracking-wide">{{ config('app.name', 'SK Rentals') }}</div>
                                <div class="text-[8px] text-neutral-400 uppercase tracking-[0.15em] mt-1">Premium Wedding &amp; Event Rentals</div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-[11px] font-bold text-green-400 mb-1.5 whitespace-nowrap">&#10004; Order Confirmed</div>
                            <span style="background:#c8a96e;color:#1a1a1a" class="inline-block rounded-full px-3 py-1 text-[11px] font-bold tracking-wide">{{ $order->formatted_id }}</span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-6">
                        <div class="text-sm text-neutral-700 leading-relaxed whitespace-pre-wrap break-words" x-text="body"></div>

                        {{-- Appended-content placeholder --}}
                        <div class="mt-6 rounded-xl border border-dashed border-neutral-200 bg-neutral-50 px-4 py-5 text-center">
                            <svg class="w-6 h-6 text-neutral-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-xs font-semibold text-neutral-500">Order summary, totals &amp; payment</p>
                            <p class="text-[11px] text-neutral-400 mt-0.5">Added automatically · ${{ number_format($order->total_amount, 2) }} total · PDF receipt attached</p>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div style="background:#1a1a1a" class="px-6 py-5 text-center">
                        <div style="color:#c8a96e" class="text-sm font-bold mb-1">{{ config('app.name', 'SK Rentals') }}</div>
                        <p class="text-[11px] text-neutral-500 leading-relaxed">{{ $order->customer_email ? $fromAddress : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</x-layout.admin-layout>
