<x-layout.app-layout>
    <x-slot:title>Checkout</x-slot>
    <x-slot:metaDescription>Complete your rental booking with HK Rentals.</x-slot>

@php $mapsKey = config('services.google.maps_key'); @endphp

<x-section class="bg-cream min-h-screen" aria-label="Checkout"
    @delivery-place-selected.window="handleDeliveryPlace($event.detail)"
    x-data="{
    step: 1,
    form: {
        firstName:'', lastName:'', email:'', phone:'',
        eventDate:'',
        address:'', city:'', state:'', zip:'',
        notes:'', paymentMethod:'card', mapLocation: null
    },
    errors: {},
    paymentState: 'idle',
    paymentError: '',

    /* ── Settings for Distance ── */
    settings: {
        godownLat: {{ $settings?->godown_lat ?: 'null' }},
        godownLng: {{ $settings?->godown_lng ?: 'null' }},
        freeDist: {{ $settings?->free_delivery_distance ?: 5 }},
        chargePerKm: {{ $settings?->charge_per_km ?: 1 }}
    },
    travelingCost: 0,
    distanceKm: 0,

    /* ── Map state ── */
    mapModalOpen: false,
    selectedLocation: null,
    mapInitialized: false,
    locationPinned: false,
    locatingMe: false,

    get totalAmount() {
        return parseFloat(Alpine.store('cart').subtotal()) + parseFloat(Alpine.store('cart').subtotal()) * 0.085 + this.travelingCost;
    },
    getDays(dateRange) { return Alpine.store('cart').calculateDays(dateRange); },

    calculateCost() {
        if (!this.form.mapLocation || !this.settings.godownLat || !this.settings.godownLng) {
            this.travelingCost = 0;
            this.distanceKm = 0;
            return;
        }
        if (!window.google?.maps?.geometry) return;
        
        let godown = new google.maps.LatLng(this.settings.godownLat, this.settings.godownLng);
        let eventLoc = new google.maps.LatLng(this.form.mapLocation.lat, this.form.mapLocation.lng);
        
        let distMeters = google.maps.geometry.spherical.computeDistanceBetween(godown, eventLoc);
        this.distanceKm = distMeters / 1000;
        
        if (this.distanceKm <= this.settings.freeDist) {
            this.travelingCost = 0;
        } else {
            this.travelingCost = this.distanceKm * this.settings.chargePerKm;
        }
    },

    validateStep1() {
        this.errors = {};
        if (!this.form.firstName) this.errors.firstName = 'First name is required';
        if (!this.form.lastName)  this.errors.lastName  = 'Last name is required';
        if (!this.form.email)     this.errors.email     = 'Email is required';
        else if (!/^\S+@\S+\.\S+$/.test(this.form.email)) this.errors.email = 'Invalid email format';
        if (!this.form.phone)     this.errors.phone     = 'Phone is required';
        if (!this.form.eventDate) this.errors.eventDate = 'Event date is required';
        if (!this.form.address)   this.errors.address   = 'Address is required';
        if (!this.form.city)    this.errors.city    = 'City is required';
        if (!this.form.state)   this.errors.state   = 'State is required';
        if (!this.form.zip)     this.errors.zip     = 'ZIP is required';
        return Object.keys(this.errors).length === 0;
    },
    next() {
        if (this.step === 1 && !this.validateStep1()) return;
        if (this.step < 3) { this.step++; window.scrollTo({ top: 0, behavior: 'smooth' }); }
    },
    prev() {
        if (this.step > 1) { this.step--; window.scrollTo({ top: 0, behavior: 'smooth' }); }
    },

    async submitOrder() {
        if (this.paymentState === 'loading') return;
        this.paymentState = 'loading';
        this.paymentError = '';
        try {
            let orderResponse = await fetch('{{ route('checkout.process') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ ...this.form, total_amount: this.totalAmount })
            });
            let orderData = await orderResponse.json();
            if (!orderData.success) throw new Error('Order creation failed');

            if (this.form.paymentMethod === 'card') {
                let intentResponse = await fetch('{{ route('payment.create-intent') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ amount: this.totalAmount, order_id: orderData.order_id })
                });
                let intentData = await intentResponse.json();
                if (!intentData.id) throw new Error('Failed to initiate payment');

                await new Promise(r => setTimeout(r, 1500));

                let confirmResponse = await fetch('{{ route('payment.confirm') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ payment_intent_id: intentData.id, order_id: orderData.order_id, amount: this.totalAmount })
                });
                let confirmData = await confirmResponse.json();
                if (!confirmData.success) throw new Error(confirmData.message || 'Payment failed');
            }

            this.paymentState = 'success';
            Alpine.store('cart').clear();
            setTimeout(() => { window.location.href = '{{ route('order.success') }}'; }, 1500);
        } catch (error) {
            console.error(error);
            this.paymentState = 'error';
            this.paymentError = error.message || 'An error occurred during payment processing.';
        }
    },

    labels: ['Customer Details', 'Order Summary', 'Payment'],

    handleDeliveryPlace(detail) {
        if (detail.address_components) this.fillAddressFromPlace({ address_components: detail.address_components });
        this.form.mapLocation = {
            lat: detail.lat,
            lng: detail.lng,
            formatted_address: detail.formatted_address,
        };
        this.locationPinned = true;
        this.calculateCost();
    },

    /* ── Google Maps methods ── */
    openMapModal() {
        this.mapModalOpen = true;
        this.$nextTick(() => this.initMap());
    },
    closeMapModal() { this.mapModalOpen = false; },

    async initMap() {
        if (this.mapInitialized) return;
        if (!window.google?.maps) {
            await new Promise(resolve => {
                if (window._gmapsReady) return resolve();
                window._gmapsQueue = window._gmapsQueue || [];
                window._gmapsQueue.push(resolve);
            });
        }
        const defaultPos = { lat: 35.9606, lng: -83.9207 };
        const mapEl = document.getElementById('mapCanvas');
        const map = new google.maps.Map(mapEl, {
            center: defaultPos,
            zoom: 13,
            mapTypeControl: false,
            fullscreenControl: false,
            streetViewControl: false,
            zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
            styles: [
                { featureType: 'all', elementType: 'geometry', stylers: [{ saturation: -15 }] },
                { featureType: 'road', elementType: 'geometry.fill', stylers: [{ color: '#f5efe6' }] },
                { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#d4e6f1' }] },
                { featureType: 'poi.park', elementType: 'geometry.fill', stylers: [{ color: '#d5e8d4' }] },
                { featureType: 'poi', elementType: 'labels', stylers: [{ visibility: 'off' }] },
            ],
        });
        const markerIcon = {
            path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
            fillColor: '#c8902a',
            fillOpacity: 1,
            strokeColor: '#ffffff',
            strokeWeight: 2,
            scale: 2.2,
            anchor: new google.maps.Point(12, 22),
        };
        const marker = new google.maps.Marker({
            position: defaultPos, map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            icon: markerIcon,
        });
        window._skMap = map;
        window._skMarker = marker;

        marker.addListener('dragend', () => {
            const p = marker.getPosition();
            this.geocodeLatLng(p.lat(), p.lng());
        });
        map.addListener('click', e => {
            marker.setPosition(e.latLng);
            this.geocodeLatLng(e.latLng.lat(), e.latLng.lng());
        });

        const searchInput = document.getElementById('mapSearchInput');
        const ac = new google.maps.places.Autocomplete(searchInput, { types: ['address'] });
        ac.bindTo('bounds', map);
        ac.addListener('place_changed', () => {
            const pl = ac.getPlace();
            if (!pl.geometry?.location) return;
            map.panTo(pl.geometry.location);
            map.setZoom(17);
            marker.setPosition(pl.geometry.location);
            this.selectedLocation = {
                lat: pl.geometry.location.lat(),
                lng: pl.geometry.location.lng(),
                formatted_address: pl.formatted_address,
            };
            if (pl.address_components) this.fillAddressFromPlace(pl);
        });

        if (this.form.address && this.form.city) {
            const q = `${this.form.address}, ${this.form.city}, ${this.form.state}`;
            new google.maps.Geocoder().geocode({ address: q }, (r, s) => {
                if (s === 'OK' && r[0]) {
                    const l = r[0].geometry.location;
                    map.panTo(l); map.setZoom(17); marker.setPosition(l);
                    this.selectedLocation = { lat: l.lat(), lng: l.lng(), formatted_address: r[0].formatted_address };
                }
            });
        } else if (this.form.mapLocation) {
            const pos = { lat: this.form.mapLocation.lat, lng: this.form.mapLocation.lng };
            map.panTo(pos); map.setZoom(17); marker.setPosition(pos);
            this.selectedLocation = this.form.mapLocation;
        }

        this.mapInitialized = true;
    },

    geocodeLatLng(lat, lng) {
        new google.maps.Geocoder().geocode({ location: { lat, lng } }, (r, s) => {
            this.selectedLocation = (s === 'OK' && r[0])
                ? { lat, lng, formatted_address: r[0].formatted_address }
                : { lat, lng, formatted_address: `${lat.toFixed(5)}, ${lng.toFixed(5)}` };
        });
    },

    fillAddressFromPlace(pl) {
        let n = '', r = '', c = '', s = '', z = '';
        for (const x of pl.address_components) {
            if (x.types.includes('street_number')) n = x.long_name;
            if (x.types.includes('route')) r = x.long_name;
            if (x.types.includes('locality')) c = x.long_name;
            if (x.types.includes('administrative_area_level_1')) s = x.short_name;
            if (x.types.includes('postal_code')) z = x.long_name;
        }
        if (n || r) this.form.address = `${n} ${r}`.trim();
        if (c) this.form.city = c;
        if (s) this.form.state = s;
        if (z) this.form.zip = z;
    },

    useMyLocation() {
        if (!navigator.geolocation) return;
        this.locatingMe = true;
        navigator.geolocation.getCurrentPosition(pos => {
            this.locatingMe = false;
            const { latitude: lat, longitude: lng } = pos.coords;
            if (window._skMap && window._skMarker) {
                const ll = new google.maps.LatLng(lat, lng);
                window._skMap.panTo(ll);
                window._skMap.setZoom(17);
                window._skMarker.setPosition(ll);
            }
            this.geocodeLatLng(lat, lng);
        }, () => { this.locatingMe = false; });
    },

    confirmLocation() {
        if (!this.selectedLocation) return;
        this.form.mapLocation = this.selectedLocation;
        this.locationPinned = true;
        this.closeMapModal();
        this.calculateCost();
    },
}">

<x-container class="max-w-4xl relative">

    {{-- Loading Overlay --}}
    <div x-show="paymentState === 'loading'" x-transition class="absolute inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm rounded-3xl">
        <div class="text-center">
            <svg class="animate-spin h-12 w-12 text-brand-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="font-semibold text-lg text-neutral-800">Processing payment...</p>
            <p class="text-sm text-neutral-500">Please do not close this window.</p>
        </div>
    </div>

    {{-- Success Overlay --}}
    <div x-show="paymentState === 'success'" x-transition class="absolute inset-0 z-50 flex items-center justify-center bg-white rounded-3xl">
        <div class="text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 scale-up">
                <svg class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="font-display text-3xl font-bold text-neutral-900 mb-2">Payment Successful!</h2>
            <p class="text-neutral-500">Redirecting to your order confirmation...</p>
        </div>
    </div>

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
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </template>
                        <template x-if="step <= s"><span x-text="s"></span></template>
                    </div>
                    <span class="text-xs mt-1.5 font-medium hidden sm:block"
                          :class="step===s ? 'text-brand-600' : (step>s ? 'text-green-600' : 'text-neutral-400')"
                          x-text="labels[s-1]"></span>
                </div>
                <div x-show="s < 3" class="step-line mx-3 w-16 sm:w-24" :class="step > s ? 'done' : ''"></div>
            </div>
        </template>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 items-start relative">
        <div class="lg:col-span-2 card p-7">

            {{-- Error banner --}}
            <div x-show="paymentState === 'error'" x-transition class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800">Payment Failed</h3>
                        <p class="text-sm text-red-700 mt-0.5" x-text="paymentError"></p>
                    </div>
                </div>
            </div>

            {{-- ── Step 1: Customer Details ── --}}
            <div x-show="step===1"
                 x-transition:enter="transition duration-200"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0">

                <h2 class="font-display text-xl font-semibold text-neutral-900 mb-6">Customer Details</h2>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <x-input label="First Name" x-model="form.firstName" placeholder="Sarah" :required="true" />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.firstName" x-text="errors.firstName"></p>
                    </div>
                    <div>
                        <x-input label="Last Name" x-model="form.lastName" placeholder="Johnson" :required="true" />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.lastName" x-text="errors.lastName"></p>
                    </div>
                    <div>
                        <x-input label="Email" type="email" x-model="form.email" placeholder="sarah@email.com" :required="true" />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.email" x-text="errors.email"></p>
                    </div>
                    <div>
                        <x-input label="Phone" type="tel" inputmode="tel" x-model="form.phone" placeholder="+1 9312152756" :required="true" />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.phone" x-text="errors.phone"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Event Date <span class="text-red-400">*</span></label>
                        <input type="date" x-model="form.eventDate"
                               :min="new Date().toISOString().split('T')[0]"
                               class="form-input w-full sm:w-64" required />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.eventDate" x-text="errors.eventDate"></p>
                    </div>

                    {{-- Delivery Address with Map Pin --}}
                    <div class="sm:col-span-2">
                        <div class="flex items-end justify-between mb-1">
                            <label class="form-label mb-0">Delivery Address <span class="text-red-400">*</span></label>
                            @if($mapsKey)
                            <button type="button"
                                    @click="openMapModal()"
                                    class="group inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors px-2.5 py-1 rounded-lg hover:bg-brand-50">
                                <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pin on Map
                            </button>
                            @endif
                        </div>
                        <input type="text" x-model="form.address" placeholder="123 Main Street"
                               id="deliveryAddressInput"
                               class="form-input w-full" autocomplete="off" required />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.address" x-text="errors.address"></p>

                        {{-- Location pinned badge --}}
                        @if($mapsKey)
                        <div x-show="locationPinned && form.mapLocation" x-cloak
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="mt-3 rounded-2xl overflow-hidden border border-green-200 shadow-sm">
                            {{-- Top strip --}}
                            <div class="flex items-center justify-between gap-2 px-4 py-2 bg-green-500">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-xs font-bold text-white tracking-wide uppercase">Location Confirmed</span>
                                </div>
                                <button type="button" @click="openMapModal()"
                                        class="flex items-center gap-1 text-[11px] font-bold text-white/80 hover:text-white transition-colors bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-full">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    Change
                                </button>
                            </div>
                            {{-- Address body --}}
                            <div class="flex items-start gap-3 px-4 py-3 bg-green-50">
                                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-green-900 leading-snug" x-text="form.mapLocation?.formatted_address"></p>
                                    <p class="text-[11px] text-green-600 font-mono mt-1"
                                       x-text="form.mapLocation ? form.mapLocation.lat.toFixed(5) + ', ' + form.mapLocation.lng.toFixed(5) : ''"></p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div>
                        <x-input label="City" x-model="form.city" placeholder="Knoxville" :required="true" />
                        <p class="text-red-500 text-xs mt-1" x-show="errors.city" x-text="errors.city"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input label="State" x-model="form.state" placeholder="TN" maxlength="2" :required="true" />
                            <p class="text-red-500 text-xs mt-1" x-show="errors.state" x-text="errors.state"></p>
                        </div>
                        <div>
                            <x-input label="ZIP" inputmode="numeric" x-model="form.zip" placeholder="37901" :required="true" />
                            <p class="text-red-500 text-xs mt-1" x-show="errors.zip" x-text="errors.zip"></p>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Special Notes <span class="text-neutral-400 font-normal">(optional)</span></label>
                        <textarea x-model="form.notes" class="form-input resize-none" rows="3" placeholder="Setup time, venue access..."></textarea>
                    </div>
                </div>
            </div>

            {{-- ── Step 2: Order Summary ── --}}
            <div x-show="step===2"
                 x-transition:enter="transition duration-200"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-display text-xl font-semibold text-neutral-900 mb-6">Order Summary</h2>

                <div class="bg-neutral-50 rounded-xl p-4 mb-5 border border-neutral-100">
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-1">Delivery To</p>
                    <p class="font-semibold text-neutral-800" x-text="form.firstName + ' ' + form.lastName"></p>
                    <p class="text-sm text-neutral-500" x-text="form.address + ', ' + form.city + ' ' + form.zip"></p>
                    <template x-if="form.mapLocation">
                        <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Location pinned on map
                        </p>
                    </template>
                    <template x-if="form.eventDate">
                        <p class="text-xs text-brand-600 mt-2 flex items-center gap-1 font-medium">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Event: <span x-text="new Date(form.eventDate + 'T00:00:00').toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'})"></span>
                        </p>
                    </template>
                </div>

                <div class="space-y-3 mb-5">
                    <template x-for="item in $store.cart.items" :key="item.product_id || item.id">
                        <div class="flex items-center gap-3 py-3 border-b border-neutral-100 last:border-0">
                            <img :src="item.image" :alt="item.name" class="w-12 h-12 rounded-lg object-cover" />
                            <div class="flex-1">
                                <p class="font-semibold text-sm text-neutral-800" x-text="item.name"></p>
                                <p class="text-xs text-neutral-400" x-text="'Qty: '+(item.quantity||item.qty)+' • '+getDays(item.dateRange)+' Days'"></p>
                            </div>
                            <span class="font-bold text-brand-600 text-sm" x-text="'$'+(item.price*(item.quantity||item.qty)*getDays(item.dateRange)).toFixed(2)"></span>
                        </div>
                    </template>
                </div>
                <div class="bg-neutral-50 rounded-xl p-5 space-y-2">
                    <div class="flex justify-between text-sm text-neutral-600"><span>Subtotal</span><span x-text="'$'+$store.cart.subtotal()"></span></div>
                    <div class="flex justify-between text-sm text-neutral-600">
                        <span class="flex items-center gap-1">
                            Delivery &amp; Setup 
                            <template x-if="distanceKm > 0">
                                <span class="text-[10px] bg-neutral-200 px-1.5 py-0.5 rounded text-neutral-600" x-text="distanceKm.toFixed(1) + ' km'"></span>
                            </template>
                        </span>
                        <template x-if="travelingCost > 0">
                            <span class="text-brand-600 font-medium" x-text="'+$'+travelingCost.toFixed(2)"></span>
                        </template>
                        <template x-if="travelingCost === 0">
                            <span class="text-green-600 font-medium">Free</span>
                        </template>
                    </div>
                    <div class="flex justify-between text-sm text-neutral-600"><span>Tax (8.5%)</span><span x-text="'$'+($store.cart.subtotal()*0.085).toFixed(2)"></span></div>
                    <div class="flex justify-between font-bold text-neutral-900 text-lg pt-2 border-t border-neutral-200"><span>Total</span><span x-text="'$'+totalAmount.toFixed(2)"></span></div>
                </div>
            </div>

            {{-- ── Step 3: Payment ── --}}
            <div x-show="step===3"
                 x-transition:enter="transition duration-200"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0">
                <h2 class="font-display text-xl font-semibold text-neutral-900 mb-6">Payment</h2>
                <div class="flex gap-3 mb-6">
                    <button @click="form.paymentMethod='card'"   :class="form.paymentMethod==='card'   ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-neutral-200 text-neutral-500'" class="flex-1 py-3 px-4 rounded-xl border-2 text-sm font-semibold transition-base">💳 Credit Card</button>
                    <button @click="form.paymentMethod='invoice'" :class="form.paymentMethod==='invoice' ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-neutral-200 text-neutral-500'" class="flex-1 py-3 px-4 rounded-xl border-2 text-sm font-semibold transition-base">📄 Invoice</button>
                </div>
                <div x-show="form.paymentMethod==='card'" class="space-y-4">
                    <div><label class="form-label">Cardholder Name</label><input type="text" class="form-input" placeholder="Sarah Johnson" /></div>
                    <div><label class="form-label">Card Number</label><input type="text" inputmode="numeric" class="form-input" placeholder="•••• •••• •••• ••••" maxlength="19" /></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="form-label">Expiry</label><input type="text" inputmode="numeric" class="form-input" placeholder="MM / YY" maxlength="7" /></div>
                        <div><label class="form-label">CVV</label><input type="text" inputmode="numeric" class="form-input" placeholder="•••" maxlength="4" /></div>
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
                <button @click="prev" x-show="step>1" class="btn btn-ghost text-neutral-600 btn-lg" :disabled="paymentState === 'loading'">← Back</button>
                <div x-show="step===1" class="text-xs text-neutral-300">Step 1 of 3</div>
                <button x-show="step < 3" @click="next()" class="btn btn-primary btn-lg ml-auto shadow-glow">Continue →</button>
                <button x-show="step === 3" @click="submitOrder()" class="btn btn-primary btn-lg ml-auto shadow-glow flex items-center gap-2" :disabled="paymentState === 'loading'">
                    <span x-text="paymentState === 'error' ? 'Retry Payment' : 'Pay Deposit'"></span>
                    <svg x-show="paymentState === 'idle' || paymentState === 'error'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <x-checkout.summary />
        </div>
    </div>
</x-container>

{{-- ══════════════════════════════════════════
     Google Maps Location Picker Modal
     (inside Alpine scope, fixed positioned)
     ══════════════════════════════════════════ --}}
@if($mapsKey)
<div x-show="mapModalOpen"
     x-cloak
     class="fixed inset-0 z-[200] flex items-end sm:items-center justify-center p-0 sm:p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-neutral-900/70 backdrop-blur-sm"
         @click="closeMapModal()"></div>

    {{-- Modal --}}
    <div class="relative w-full sm:max-w-2xl flex flex-col bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden"
         style="max-height: 95dvh; max-height: 95vh;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-y-8 opacity-0 scale-95"
         x-transition:enter-end="transform translate-y-0 opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform translate-y-0 opacity-100 scale-100"
         x-transition:leave-end="transform translate-y-8 opacity-0 scale-95"
         @click.stop>

        {{-- Modal Header --}}
        <div class="relative px-5 py-4 border-b border-neutral-100 flex items-center gap-3 flex-shrink-0 bg-gradient-to-r from-brand-50/60 to-white">
            <div class="w-10 h-10 rounded-xl bg-brand-500 flex items-center justify-center flex-shrink-0 shadow-sm shadow-brand-200">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-neutral-900 text-base leading-tight">Pin Your Delivery Location</h3>
                <p class="text-xs text-neutral-400 mt-0.5">Search or drag the pin to your exact address</p>
            </div>
            <button @click="closeMapModal()"
                    class="w-8 h-8 rounded-full bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center text-neutral-500 hover:text-neutral-700 transition-all flex-shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Search Row --}}
        <div class="px-4 py-3 border-b border-neutral-100 bg-white flex-shrink-0 flex items-center gap-2">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="mapSearchInput" type="text"
                       placeholder="Search for your address..."
                       class="w-full pl-10 pr-4 py-2.5 bg-neutral-50 rounded-xl text-sm border border-neutral-200 focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all"
                       autocomplete="off" />
            </div>
            <button @click="useMyLocation()"
                    :disabled="locatingMe"
                    class="flex-shrink-0 w-10 h-10 rounded-xl bg-neutral-50 border border-neutral-200 flex items-center justify-center text-brand-600 hover:bg-brand-50 hover:border-brand-300 transition-all disabled:opacity-60"
                    title="Use my current location">
                <svg x-show="!locatingMe" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0013 3.06V1h-2v2.06A8.994 8.994 0 003.06 11H1v2h2.06A8.994 8.994 0 0011 20.94V23h2v-2.06A8.994 8.994 0 0020.94 13H23v-2h-2.06z"/>
                </svg>
                <svg x-show="locatingMe" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </button>
        </div>

        {{-- Map Canvas --}}
        <div id="mapCanvas" class="flex-1 w-full" style="min-height: 300px; height: 380px;"></div>

        {{-- Location Tip strip --}}
        <div class="px-4 py-2 bg-amber-50 border-t border-amber-100 flex items-center gap-2 flex-shrink-0">
            <svg class="w-3.5 h-3.5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-amber-700">Click anywhere on the map or drag the pin to set your exact delivery location.</p>
        </div>

        {{-- Footer: Address preview + Confirm --}}
        <div class="px-5 py-4 bg-white border-t border-neutral-100 flex-shrink-0">
            {{-- Selected address preview --}}
            <div x-show="selectedLocation" class="flex items-start gap-3 mb-3 p-3 bg-neutral-50 rounded-xl border border-neutral-100">
                <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-neutral-800 leading-snug" x-text="selectedLocation?.formatted_address || 'Fetching address…'"></p>
                    <p class="text-[11px] text-neutral-400 mt-0.5 font-mono"
                       x-text="selectedLocation ? selectedLocation.lat.toFixed(5)+', '+selectedLocation.lng.toFixed(5) : ''"></p>
                </div>
            </div>
            <div x-show="!selectedLocation" class="flex items-center gap-2 mb-3 p-3 bg-neutral-50 rounded-xl border border-dashed border-neutral-200">
                <svg class="w-4 h-4 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <p class="text-sm text-neutral-400">No location selected — click the map or search above</p>
            </div>

            {{-- Action buttons --}}
            <div class="flex gap-3">
                <button @click="closeMapModal()"
                        class="px-5 py-2.5 rounded-xl border border-neutral-200 text-neutral-600 font-semibold text-sm hover:bg-neutral-50 transition-all flex-shrink-0">
                    Cancel
                </button>
                <button @click="confirmLocation()"
                        :disabled="!selectedLocation"
                        class="flex-1 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2
                               bg-brand-600 text-white shadow-sm shadow-brand-200 hover:bg-brand-700 hover:shadow-md
                               disabled:bg-neutral-200 disabled:text-neutral-400 disabled:shadow-none disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Confirm This Location
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</x-section>

<style>
.scale-up {
    animation: scaleUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
@keyframes scaleUp {
    0%   { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1);   opacity: 1; }
}
/* Keep the autocomplete dropdown above the modal backdrop */
.pac-container {
    z-index: 9999 !important;
    border-radius: 0.75rem;
    border: 1px solid #e5e1dc;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    font-family: 'Plus Jakarta Sans', sans-serif;
    overflow: hidden;
    margin-top: 4px;
}
.pac-item {
    padding: 8px 14px;
    font-size: 0.8125rem;
    cursor: pointer;
    border-top: 1px solid #f3f4f6;
}
.pac-item:hover, .pac-item-selected {
    background: #fdf8f0;
}
.pac-item-query {
    font-weight: 600;
    color: #1a1a1a;
}
.pac-icon { display: none; }
</style>

@if($mapsKey)
<x-slot:scripts>
<script>
    function _gmapsCallback() {
        window._gmapsReady = true;
        (window._gmapsQueue || []).forEach(fn => fn());
        window._gmapsQueue = [];

        // Attach Places Autocomplete to the main delivery address field
        var addrInput = document.getElementById('deliveryAddressInput');
        if (addrInput && google.maps.places) {
            var addrAc = new google.maps.places.Autocomplete(addrInput, {
                types: ['address'],
            });
            addrAc.addListener('place_changed', function () {
                var pl = addrAc.getPlace();
                if (!pl.geometry?.location) return;
                window.dispatchEvent(new CustomEvent('delivery-place-selected', {
                    detail: {
                        address_components: pl.address_components || [],
                        formatted_address: pl.formatted_address || addrInput.value,
                        lat: pl.geometry.location.lat(),
                        lng: pl.geometry.location.lng(),
                    }
                }));
            });
        }
    }
</script>
<script
    async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&libraries=places,geometry&callback=_gmapsCallback">
</script>
</x-slot:scripts>
@endif

</x-layout.app-layout>
