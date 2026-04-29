<x-layout.app-layout>
    <x-slot:title>Checkout</x-slot>
    <x-slot:metaDescription>Complete your rental booking with SK Rentals.</x-slot>


<x-section class="bg-cream min-h-screen" aria-label="Checkout" x-data="{
    step: 1,
    form: { firstName:'',lastName:'',email:'',phone:'',address:'',city:'',state:'',zip:'',notes:'',paymentMethod:'card' },
    get cartItems() { return Alpine.store('cart').items },
    get subtotal()  { return Alpine.store('cart').subtotal() },
    next() { if(this.step < 3) this.step++ },
    prev() { if(this.step > 1) this.step-- },
    labels: ['Customer Details','Order Summary','Payment'],
}">
<x-container class="max-w-4xl">

    <div class="text-center mb-10">
        <span class="badge badge-gold mb-3">Secure Checkout</span>
        <h1 class="font-display text-3xl font-bold text-neutral-900">Complete Your Booking</h1>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-center justify-center mb-10 gap-0">
        <template x-for="s in [1,2,3]" :key="s">
            <div class="flex items-center">
                <div class="flex flex-col items-center">
                    <div class="step-circle" :class="step > s ? 'done' : (step === s ? 'active' : 'pending')">
                        <template x-if="step > s">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        <template x-if="step <= s"><span x-text="s"></span></template>
                    </div>
                    <span class="text-xs mt-1.5 font-medium hidden sm:block"
                          :class="step===s?'text-brand-600':(step>s?'text-green-600':'text-neutral-400')"
                          x-text="labels[s-1]"></span>
                </div>
                <div x-show="s < 3" class="step-line mx-3 w-16 sm:w-24" :class="step > s ? 'done' : ''"></div>
            </div>
        </template>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 items-start">

        <div class="lg:col-span-2 card p-7">

            {{-- Step 1 --}}
            <div x-show="step===1" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-display text-xl font-semibold text-neutral-900 mb-6">Customer Details</h2>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div><x-input label="First Name" x-model="form.firstName" placeholder="Sarah" /></div>
                    <div><x-input label="Last Name" x-model="form.lastName" placeholder="Johnson" /></div>
                    <div><x-input label="Email" type="email" x-model="form.email" placeholder="sarah@email.com" /></div>
                    <div><x-input label="Phone" type="tel" x-model="form.phone" placeholder="+1 (865) 000-0000" /></div>
                    <div class="sm:col-span-2"><x-input label="Delivery Address" x-model="form.address" placeholder="123 Main Street" /></div>
                    <div><x-input label="City" x-model="form.city" placeholder="Knoxville" /></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><x-input label="State" x-model="form.state" placeholder="TN" maxlength="2" /></div>
                        <div><x-input label="ZIP" x-model="form.zip" placeholder="37901" /></div>
                    </div>
                    <div class="sm:col-span-2"><label class="form-label">Special Notes <span class="text-neutral-400 font-normal">(optional)</span></label><textarea x-model="form.notes" class="form-input resize-none" rows="3" placeholder="Setup time, venue access..."></textarea></div>
                </div>
            </div>

            {{-- Step 2 --}}
            <div x-show="step===2" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-display text-xl font-semibold text-neutral-900 mb-6">Order Summary</h2>
                <div class="bg-neutral-50 rounded-xl p-4 mb-5 border border-neutral-100">
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-1">Delivery To</p>
                    <p class="font-semibold text-neutral-800" x-text="form.firstName + ' ' + form.lastName"></p>
                    <p class="text-sm text-neutral-500" x-text="form.address + ', ' + form.city + ' ' + form.zip"></p>
                </div>
                <div class="space-y-3 mb-5">
                    <template x-for="item in cartItems" :key="item.id">
                        <div class="flex items-center gap-3 py-3 border-b border-neutral-100 last:border-0">
                            <img :src="item.image" :alt="item.name" class="w-12 h-12 rounded-lg object-cover" />
                            <div class="flex-1"><p class="font-semibold text-sm text-neutral-800" x-text="item.name"></p><p class="text-xs text-neutral-400" x-text="'Qty: ' + item.qty"></p></div>
                            <span class="font-bold text-brand-600 text-sm" x-text="'$'+(item.price*item.qty).toFixed(2)"></span>
                        </div>
                    </template>
                </div>
                <div class="bg-neutral-50 rounded-xl p-5 space-y-2">
                    <div class="flex justify-between text-sm text-neutral-600"><span>Subtotal</span><span x-text="'$'+subtotal"></span></div>
                    <div class="flex justify-between text-sm text-neutral-600"><span>Delivery &amp; Setup</span><span class="text-green-600 font-medium">Free</span></div>
                    <div class="flex justify-between text-sm text-neutral-600"><span>Tax (8.5%)</span><span x-text="'$'+(subtotal*0.085).toFixed(2)"></span></div>
                    <div class="flex justify-between font-bold text-neutral-900 text-lg pt-2 border-t border-neutral-200"><span>Total</span><span x-text="'$'+(parseFloat(subtotal)+parseFloat(subtotal)*0.085).toFixed(2)"></span></div>
                </div>
            </div>

            {{-- Step 3 --}}
            <div x-show="step===3" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-display text-xl font-semibold text-neutral-900 mb-6">Payment</h2>
                <div class="flex gap-3 mb-6">
                    <button @click="form.paymentMethod='card'" :class="form.paymentMethod==='card'?'border-brand-500 bg-brand-50 text-brand-700':'border-neutral-200 text-neutral-500'" class="flex-1 py-3 px-4 rounded-xl border-2 text-sm font-semibold transition-base">💳 Credit Card</button>
                    <button @click="form.paymentMethod='invoice'" :class="form.paymentMethod==='invoice'?'border-brand-500 bg-brand-50 text-brand-700':'border-neutral-200 text-neutral-500'" class="flex-1 py-3 px-4 rounded-xl border-2 text-sm font-semibold transition-base">📄 Invoice</button>
                </div>
                <div x-show="form.paymentMethod==='card'" class="space-y-4">
                    <div><label class="form-label">Cardholder Name</label><input type="text" class="form-input" placeholder="Sarah Johnson" /></div>
                    <div><label class="form-label">Card Number</label><input type="text" class="form-input" placeholder="•••• •••• •••• ••••" maxlength="19" /></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="form-label">Expiry</label><input type="text" class="form-input" placeholder="MM / YY" maxlength="7" /></div>
                        <div><label class="form-label">CVV</label><input type="text" class="form-input" placeholder="•••" maxlength="4" /></div>
                    </div>
                    <div class="flex items-center gap-2 bg-green-50 rounded-lg p-3 border border-green-100">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <p class="text-xs text-green-700 font-medium">256-bit SSL encrypted. Your payment info is secure.</p>
                    </div>
                </div>
                <div x-show="form.paymentMethod==='invoice'" class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                    <p class="font-semibold text-amber-800 mb-2">Pay by Invoice</p>
                    <p class="text-sm text-amber-700">An invoice will be emailed to <strong x-text="form.email||'your email'"></strong>. Payment due 5 business days before your event.</p>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-neutral-100">
                <button @click="prev" x-show="step>1" class="btn btn-ghost text-neutral-600 btn-lg">← Back</button>
                <div x-show="step===1" class="text-xs text-neutral-300">Step 1 of 3</div>
                <button @click="step<3?next():window.location.href='{{ route('order.success') }}'" class="btn btn-primary btn-lg ml-auto shadow-glow">
                    <span x-text="step<3?'Continue →':'Place Order 🎉'"></span>
                </button>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <x-checkout.summary />
        </div>
    </div>
</x-container>
</x-section>

</x-layout.app-layout>
