<x-layout.admin-layout>
    <x-slot:title>Manage Settings</x-slot>
    <x-slot:pageTitle>Settings / System Configuration</x-slot>

@php $mapsKey = config('services.google.maps_key'); @endphp

    <div class="max-w-4xl mx-auto pb-12">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="font-display text-3xl font-bold text-neutral-900">System Settings</h2>
                <p class="text-neutral-500 mt-1">Manage delivery costs and godown location.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 rounded-2xl bg-green-50 p-4 border border-green-200 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-green-800">Success!</p>
                    <p class="text-xs text-green-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- ── Section 1: Warehouse Location ── --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-neutral-100 overflow-hidden">
                <div class="px-6 md:px-10 pt-8 pb-2 border-b border-neutral-50">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-xl bg-brand-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-neutral-900">Warehouse Location</h3>
                            <p class="text-xs text-neutral-400">Used to calculate delivery distance for every order.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 md:p-10 space-y-6">
                    {{-- Godown Address --}}
                    <div>
                        <label for="godown_address" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">
                            Warehouse Address
                            @if($mapsKey)
                                <span class="ml-2 inline-flex items-center gap-1 text-brand-600 font-semibold normal-case tracking-normal text-[10px] bg-brand-50 border border-brand-100 px-2 py-0.5 rounded-full">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    Google search enabled
                                </span>
                            @endif
                        </label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <input type="text" name="godown_address" id="godown_address"
                                   value="{{ old('godown_address', $settings->godown_address) }}"
                                   placeholder="Search for warehouse address..."
                                   autocomplete="off"
                                   class="block w-full pl-12 pr-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold shadow-sm" required>
                        </div>
                        @error('godown_address') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Hidden Coordinates --}}
                    <input type="hidden" name="godown_lat" id="godown_lat" value="{{ old('godown_lat', $settings->godown_lat) }}">
                    <input type="hidden" name="godown_lng" id="godown_lng" value="{{ old('godown_lng', $settings->godown_lng) }}">

                    {{-- Godown Map --}}
                    <div>
                        <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Pin Exact Location</label>
                        <div class="relative w-full h-[280px] rounded-2xl overflow-hidden border border-neutral-200 shadow-inner bg-neutral-50">
                            @if($mapsKey)
                                <div id="adminMapCanvas" class="w-full h-full"></div>
                            @else
                                <div class="flex items-center justify-center w-full h-full text-neutral-400 p-6 text-center text-sm">
                                    Google Maps key is missing. Add it to your .env file to enable the map.
                                </div>
                            @endif
                        </div>
                        <p class="text-[10px] text-neutral-400 font-medium mt-2 ml-1">Search above or drag the pin to set the precise warehouse location.</p>
                    </div>
                </div>
            </div>

            {{-- ── Section 2: Pricing & Tax ── --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-neutral-100 overflow-hidden">
                <div class="px-6 md:px-10 pt-8 pb-2 border-b border-neutral-50">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-neutral-900">Pricing & Tax</h3>
                            <p class="text-xs text-neutral-400">Delivery charge rules and tax applied to every order.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 md:p-10">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Delivery Charge Per Mile --}}
                        <div>
                            <label for="charge_per_mile" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-1 ml-1">Charge Per Mile</label>
                            <p class="text-[11px] text-neutral-400 mb-3 ml-1">Base rate applied to every delivery.</p>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <span class="text-neutral-500 font-bold">$</span>
                                </div>
                                <input type="number" step="0.01" min="0" name="charge_per_mile" id="charge_per_mile" inputmode="decimal"
                                       value="{{ old('charge_per_mile', $settings->charge_per_mile) }}"
                                       class="block w-full pl-9 pr-5 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-bold shadow-sm text-lg" required>
                            </div>
                            @error('charge_per_mile') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Max Delivery Distance --}}
                        <div>
                            <label for="max_delivery_distance" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-1 ml-1">Max Distance (Flat Rate)</label>
                            <p class="text-[11px] text-neutral-400 mb-3 ml-1">Orders within this range pay a flat fee. Beyond it: flat fee + actual miles.</p>
                            <div class="relative">
                                <input type="number" step="0.01" min="0" name="max_delivery_distance" id="max_delivery_distance" inputmode="decimal"
                                       value="{{ old('max_delivery_distance', $settings->max_delivery_distance) }}"
                                       class="block w-full pl-5 pr-14 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-bold shadow-sm text-lg" required>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 font-semibold text-sm">mi</span>
                                </div>
                            </div>
                            @error('max_delivery_distance') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tax Rate --}}
                        <div>
                            <label for="tax_rate" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-1 ml-1">Tax Rate</label>
                            <p class="text-[11px] text-neutral-400 mb-3 ml-1">Applied to order subtotal only, not delivery charge.</p>
                            <div class="relative">
                                <input type="number" step="0.01" min="0" max="100" name="tax_rate" id="tax_rate" inputmode="decimal"
                                       value="{{ old('tax_rate', $settings->tax_rate) }}"
                                       class="block w-full pl-5 pr-10 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-bold shadow-sm text-lg" required>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 font-semibold">%</span>
                                </div>
                            </div>
                            @error('tax_rate') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    {{-- Delivery logic visual example --}}
                    <div class="mt-6 rounded-2xl bg-neutral-50 border border-neutral-100 p-4">
                        <p class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-3">How delivery charge is calculated</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="flex items-start gap-2.5 bg-white rounded-xl p-3 border border-neutral-100">
                                <span class="mt-0.5 w-5 h-5 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0">≤</span>
                                <div>
                                    <p class="font-semibold text-neutral-700">Within max distance</p>
                                    <p class="text-neutral-400 mt-0.5">charge = <span class="font-mono text-neutral-600">$ per mile × max distance</span></p>
                                    <p class="text-neutral-400 mt-0.5 italic">Everyone within range pays the same flat fee.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5 bg-white rounded-xl p-3 border border-neutral-100">
                                <span class="mt-0.5 w-5 h-5 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0">&gt;</span>
                                <div>
                                    <p class="font-semibold text-neutral-700">Beyond max distance</p>
                                    <p class="text-neutral-400 mt-0.5">charge = <span class="font-mono text-neutral-600">flat fee + $ per mile × actual miles</span></p>
                                    <p class="text-neutral-400 mt-0.5 italic">Flat fee plus the actual distance on top.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Save Button ── --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2">
                <p class="text-xs text-neutral-400 font-medium italic text-center sm:text-left">Changes apply immediately to all new orders.</p>
                <button type="submit" class="w-full sm:w-auto justify-center px-10 py-3.5 bg-brand-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-200 hover:bg-brand-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Save Settings
                </button>
            </div>
        </form>
    </div>

@if($mapsKey)
<x-slot:scripts>
<style>
.pac-container {
    z-index: 99999 !important;
    border-radius: 0.75rem;
    border: 1px solid #e5e1dc;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    font-family: 'Plus Jakarta Sans', sans-serif;
    overflow: hidden;
    margin-top: 4px;
}
.pac-item { padding: 8px 14px; font-size: 0.8125rem; cursor: pointer; border-top: 1px solid #f3f4f6; }
.pac-item:hover, .pac-item-selected { background: #fdf8f0; }
.pac-item-query { font-weight: 600; color: #1a1a1a; }
.pac-icon { display: none; }
</style>
<script>
function _adminMapsReady() {
    const input   = document.getElementById('godown_address');
    const latInput = document.getElementById('godown_lat');
    const lngInput = document.getElementById('godown_lng');
    if (!input || !latInput || !lngInput) return;

    // Map initialization
    const mapEl = document.getElementById('adminMapCanvas');
    let map, marker;
    
    if (mapEl) {
        let initialLat = parseFloat(latInput.value) || 35.9606;
        let initialLng = parseFloat(lngInput.value) || -83.9207;
        const defaultPos = { lat: initialLat, lng: initialLng };

        map = new google.maps.Map(mapEl, {
            center: defaultPos,
            zoom: latInput.value ? 16 : 4,
            mapTypeId: 'hybrid',
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            styles: [
                { featureType: 'poi', elementType: 'labels', stylers: [{ visibility: 'off' }] },
            ],
        });

        marker = new google.maps.Marker({
            position: defaultPos,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        // Update hidden inputs when marker is dragged
        marker.addListener('dragend', function() {
            const pos = marker.getPosition();
            latInput.value = pos.lat().toFixed(7);
            lngInput.value = pos.lng().toFixed(7);
        });
        
        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            latInput.value = e.latLng.lat().toFixed(7);
            lngInput.value = e.latLng.lng().toFixed(7);
        });
    }

    // Autocomplete initialization
    const ac = new google.maps.places.Autocomplete(input, { types: ['address'] });
    ac.addListener('place_changed', function () {
        const place = ac.getPlace();
        if (!place.geometry?.location) return;
        
        const newLat = place.geometry.location.lat();
        const newLng = place.geometry.location.lng();
        
        latInput.value = newLat.toFixed(7);
        lngInput.value = newLng.toFixed(7);
        input.value = place.formatted_address || input.value;
        
        if (map && marker) {
            const newPos = { lat: newLat, lng: newLng };
            map.panTo(newPos);
            map.setZoom(17);
            marker.setPosition(newPos);
        }
    });
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&libraries=places&callback=_adminMapsReady">
</script>
</x-slot:scripts>
@endif

</x-layout.admin-layout>
