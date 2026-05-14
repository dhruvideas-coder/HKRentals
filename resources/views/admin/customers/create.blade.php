<x-layout.admin-layout>
    <x-slot:title>Add New Customer</x-slot:title>
    <x-slot:pageTitle>Customers / Add Customer</x-slot:pageTitle>

    @php $mapsKey = config('services.google.maps_key'); @endphp

    <div class="max-w-5xl mx-auto">

        {{-- Breadcrumbs & Back --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.customers.index') }}"
               class="w-10 h-10 rounded-xl bg-white border border-neutral-100 shadow-sm flex items-center justify-center text-neutral-400 hover:text-brand-600 hover:border-brand-100 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-display font-bold text-neutral-900 tracking-tight">Add New Customer</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-neutral-400 font-medium">Customers</span>
                    <svg class="w-3 h-3 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-sm text-brand-600 font-bold">New Customer</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.customers.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
            @csrf

            {{-- ─── Main Content ─── --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Personal Information --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Personal Information</h3>
                        <p class="text-sm text-neutral-400 mt-1">Basic details to identify the customer.</p>
                    </div>
                    <div class="p-6 md:p-10 space-y-6">

                        {{-- Full Name --}}
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Full Name</label>
                            <input type="text" name="name" id="field_name" required value="{{ old('name') }}"
                                   class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold placeholder-neutral-300 shadow-sm"
                                   placeholder="e.g. Sarah Johnson" />
                            @error('name') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email & Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Email Address</label>
                                <input type="email" name="email" id="field_email" required value="{{ old('email') }}"
                                       class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium placeholder-neutral-300 shadow-sm"
                                       placeholder="sarah@example.com" />
                                @error('email') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Phone Number</label>
                                <input type="tel" name="phone" inputmode="tel" value="{{ old('phone') }}"
                                       class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium placeholder-neutral-300 shadow-sm"
                                       placeholder="+1 (555) 000-0000" />
                                @error('phone') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Address --}}
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Address</label>
                            <textarea name="address" id="field_address" rows="3"
                                      class="block w-full px-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium resize-none placeholder-neutral-300 shadow-sm"
                                      placeholder="Street address, city, state, ZIP…">{{ old('address') }}</textarea>
                            @error('address') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                {{-- Map Location --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-10 py-6 md:py-8 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="text-lg font-bold text-neutral-800">Map Location</h3>
                        <p class="text-sm text-neutral-400 mt-1">Search for an address or click anywhere on the map to drop a pin.</p>
                    </div>
                    <div class="p-6 md:p-10 space-y-5">

                        {{-- Autocomplete search bar --}}
                        <div>
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Search Address</label>
                            <div class="relative">
                                <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" id="customer_location_search"
                                       class="block w-full pl-12 pr-12 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-medium placeholder-neutral-300 shadow-sm"
                                       placeholder="Type an address or place name…"
                                       autocomplete="off" />
                                {{-- Clear search button --}}
                                <button type="button" id="btn_clear_search"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 hidden w-6 h-6 rounded-full bg-neutral-200 hover:bg-neutral-300 text-neutral-600 flex items-center justify-center transition-all"
                                        title="Clear search">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Map canvas --}}
                        @if($mapsKey)
                        <div id="customerMapCanvas"
                             class="w-full rounded-2xl overflow-hidden border border-neutral-100 shadow-inner"
                             style="height: 300px; background: #f5f5f5;">
                        </div>
                        @else
                        <div class="w-full rounded-2xl border-2 border-dashed border-neutral-200 bg-neutral-50 flex flex-col items-center justify-center py-12 text-center">
                            <svg class="w-8 h-8 text-neutral-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <p class="text-sm text-neutral-500 font-medium">Map unavailable</p>
                            <p class="text-xs text-neutral-400 mt-1">GOOGLE_MAPS_KEY is not configured in .env</p>
                        </div>
                        @endif

                        {{-- Selected location pill --}}
                        <div id="location_pill"
                             class="hidden items-center gap-3 px-4 py-3 bg-brand-50 border border-brand-100 rounded-2xl">
                            <div class="w-8 h-8 bg-brand-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p id="location_pill_text" class="text-sm text-brand-700 font-semibold flex-1 truncate"></p>
                            <button type="button" id="btn_clear_location"
                                    class="w-7 h-7 rounded-xl bg-brand-100 hover:bg-brand-200 text-brand-500 hover:text-brand-700 flex items-center justify-center flex-shrink-0 transition-all"
                                    title="Remove pin">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Coords display (subtle) --}}
                        <p id="location_coords" class="hidden text-[11px] font-mono text-neutral-400 ml-1"></p>

                        {{-- Hidden inputs submitted with the form --}}
                        <input type="hidden" name="latitude"          id="customer_lat"               value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude"         id="customer_lng"               value="{{ old('longitude') }}">
                        <input type="hidden" name="formatted_address" id="customer_formatted_address" value="{{ old('formatted_address') }}">

                        <p class="text-xs text-neutral-400 ml-1">Map location is optional. Pin auto-fills the address field above.</p>

                    </div>
                </div>

            </div>

            {{-- ─── Sidebar ─── --}}
            <div class="space-y-8">

                {{-- Avatar Preview --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
                    <div class="px-6 md:px-8 py-6 border-b border-neutral-50 bg-neutral-50/30">
                        <h3 class="font-bold text-neutral-800">Preview</h3>
                    </div>
                    <div class="p-6 md:p-8 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-brand-200 mb-4">
                            <span id="initials_display">?</span>
                        </div>
                        <p class="font-bold text-neutral-800 text-sm" id="name_preview">Customer Name</p>
                        <p class="text-xs text-neutral-400 mt-0.5" id="email_preview">email@example.com</p>
                    </div>
                </div>

                {{-- Action Card --}}
                <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-[2.5rem] p-6 md:p-8 shadow-xl shadow-neutral-200">
                    <h4 class="text-white font-bold text-lg mb-2">Create Customer</h4>
                    <p class="text-neutral-400 text-sm mb-8 leading-relaxed">Once created, the customer profile is available in your list and can be linked to orders.</p>
                    <div class="flex flex-col gap-3">
                        <button type="submit"
                                class="w-full px-6 py-4 bg-brand-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-500/20 hover:bg-brand-700 hover:shadow-xl hover:-translate-y-0.5 transition-all tracking-wide">
                            Create Customer
                        </button>
                        <a href="{{ route('admin.customers.index') }}"
                           class="w-full px-6 py-4 bg-white/5 text-white/60 text-center rounded-2xl font-bold hover:bg-white/10 hover:text-white transition-all">
                            Cancel
                        </a>
                    </div>
                </div>

                {{-- Info note --}}
                <div class="bg-sky-50 rounded-2xl border border-sky-100 p-5">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-sky-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-sky-800">Required fields</p>
                            <p class="text-xs text-sky-600 mt-1 leading-relaxed">Only <strong>name</strong> and <strong>email</strong> are required. All other fields are optional and can be updated later.</p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- ─── Scripts ─── --}}
    <script>
    // Live avatar preview
    (function () {
        const nameInput   = document.getElementById('field_name');
        const emailInput  = document.getElementById('field_email');
        const initialsEl  = document.getElementById('initials_display');
        const namePrev    = document.getElementById('name_preview');
        const emailPrev   = document.getElementById('email_preview');

        function initials(name) {
            const w = name.trim().split(/\s+/).filter(Boolean);
            if (!w.length) return '?';
            let s = w[0][0].toUpperCase();
            if (w.length > 1) s += w[w.length - 1][0].toUpperCase();
            return s;
        }

        function update() {
            const n = nameInput.value, e = emailInput.value;
            initialsEl.textContent = n ? initials(n) : '?';
            namePrev.textContent   = n ? n           : 'Customer Name';
            emailPrev.textContent  = e ? e           : 'email@example.com';
        }

        nameInput.addEventListener('input', update);
        emailInput.addEventListener('input', update);
    })();
    </script>

    @if($mapsKey)
    <script>
    // ─── Google Maps picker ───────────────────────────────────────────────────
    function _customerMapsReady() {
        const searchInput   = document.getElementById('customer_location_search');
        const latInput      = document.getElementById('customer_lat');
        const lngInput      = document.getElementById('customer_lng');
        const addrInput     = document.getElementById('customer_formatted_address');
        const addressField  = document.getElementById('field_address');
        const pill          = document.getElementById('location_pill');
        const pillText      = document.getElementById('location_pill_text');
        const coordsEl      = document.getElementById('location_coords');
        const clearLocation = document.getElementById('btn_clear_location');
        const clearSearch   = document.getElementById('btn_clear_search');

        // ── Map init ──
        const defaultPos = { lat: 25.7617, lng: -80.1918 }; // Miami default

        const map = new google.maps.Map(document.getElementById('customerMapCanvas'), {
            center: defaultPos,
            zoom: 11,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
            styles: [
                { featureType: 'all',      elementType: 'geometry',      stylers: [{ saturation: -15 }] },
                { featureType: 'road',     elementType: 'geometry.fill', stylers: [{ color: '#f5efe6' }] },
                { featureType: 'water',    elementType: 'geometry',      stylers: [{ color: '#d4e6f1' }] },
                { featureType: 'poi.park', elementType: 'geometry.fill', stylers: [{ color: '#d5e8d4' }] },
                { featureType: 'poi',      elementType: 'labels',        stylers: [{ visibility: 'off' }] },
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
            position: defaultPos,
            map: map,
            draggable: true,
            visible: false,
            animation: google.maps.Animation.DROP,
            icon: markerIcon,
        });

        // ── Helpers ──
        // pillLabel = text shown in UI; savedAddr = what goes into the hidden input.
        // Pass savedAddr='' when geocoding fails so a raw "lat, lng" is never stored
        // as formatted_address (prevents duplicate display on the profile page).
        function setPin(lat, lng, pillLabel, savedAddr) {
            const pos = { lat, lng };
            marker.setPosition(pos);
            marker.setVisible(true);
            map.panTo(pos);
            map.setZoom(17);

            latInput.value  = lat.toFixed(7);
            lngInput.value  = lng.toFixed(7);
            addrInput.value = (savedAddr !== undefined) ? savedAddr : pillLabel;

            pill.classList.remove('hidden');
            pill.classList.add('flex');
            pillText.textContent = pillLabel;
            coordsEl.classList.remove('hidden');
            coordsEl.textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
        }

        function clearPin() {
            marker.setVisible(false);
            latInput.value  = '';
            lngInput.value  = '';
            addrInput.value = '';
            pill.classList.add('hidden');
            pill.classList.remove('flex');
            pillText.textContent = '';
            coordsEl.classList.add('hidden');
            searchInput.value = '';
            clearSearch.classList.add('hidden');
        }

        function geocodeAndSetPin(lat, lng) {
            new google.maps.Geocoder().geocode({ location: { lat, lng } }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    const addr = results[0].formatted_address;
                    setPin(lat, lng, addr, addr);
                } else {
                    setPin(lat, lng, lat.toFixed(5) + ', ' + lng.toFixed(5), '');
                }
            });
        }

        // ── Places Autocomplete ──
        const ac = new google.maps.places.Autocomplete(searchInput, { types: ['geocode', 'establishment'] });
        ac.bindTo('bounds', map);

        ac.addListener('place_changed', function () {
            const place = ac.getPlace();
            if (!place.geometry?.location) return;

            const lat   = place.geometry.location.lat();
            const lng   = place.geometry.location.lng();
            const label = place.formatted_address || searchInput.value;

            setPin(lat, lng, label, label);
            clearSearch.classList.remove('hidden');

            // Auto-fill address textarea if empty
            if (!addressField.value.trim()) {
                addressField.value = label;
            }
        });

        // Show/hide clear-search button as user types
        searchInput.addEventListener('input', function () {
            clearSearch.classList.toggle('hidden', !this.value.trim());
        });

        clearSearch.addEventListener('click', function () {
            searchInput.value = '';
            clearSearch.classList.add('hidden');
            searchInput.focus();
        });

        // ── Click on map ──
        map.addListener('click', function (e) {
            geocodeAndSetPin(e.latLng.lat(), e.latLng.lng());
        });

        // ── Drag marker ──
        marker.addListener('dragend', function () {
            const pos = marker.getPosition();
            geocodeAndSetPin(pos.lat(), pos.lng());
        });

        // ── Clear pin ──
        clearLocation.addEventListener('click', clearPin);

        // ── Restore old value on validation error ──
        const oldLat = parseFloat(latInput.value);
        const oldLng = parseFloat(lngInput.value);
        const oldAddr = addrInput.value;
        if (!isNaN(oldLat) && !isNaN(oldLng)) {
            setPin(oldLat, oldLng, oldAddr || (oldLat.toFixed(5) + ', ' + oldLng.toFixed(5)));
            if (oldAddr) searchInput.value = oldAddr;
        }
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&libraries=places&callback=_customerMapsReady">
    </script>
    @endif

</x-layout.admin-layout>
