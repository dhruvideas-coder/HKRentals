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

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-neutral-100 overflow-hidden">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 md:p-10 space-y-8 md:space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                        
                        {{-- Godown Address --}}
                        <div class="md:col-span-2">
                            <label for="godown_address" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">
                                Godown Address
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
                                       placeholder="Search for godown address..."
                                       autocomplete="off"
                                       class="block w-full pl-12 pr-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold shadow-sm" required>
                            </div>
                            @error('godown_address') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Hidden Coordinates --}}
                        <input type="hidden" name="godown_lat" id="godown_lat" value="{{ old('godown_lat', $settings->godown_lat) }}">
                        <input type="hidden" name="godown_lng" id="godown_lng" value="{{ old('godown_lng', $settings->godown_lng) }}">

                        {{-- Godown Map --}}
                        <div class="md:col-span-2 mt-2">
                            <label class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Pin Exact Location</label>
                            <div class="relative w-full h-[300px] rounded-2xl overflow-hidden border border-neutral-200 shadow-inner bg-neutral-50">
                                @if($mapsKey)
                                    <div id="adminMapCanvas" class="w-full h-full"></div>
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-neutral-400 p-6 text-center">
                                        Google Maps key is missing. Please add it to your .env file to enable the map.
                                    </div>
                                @endif
                            </div>
                            <p class="text-[10px] text-neutral-400 font-medium mt-2 ml-1">Search above or drag the pin on the map to set the precise godown location.</p>
                        </div>

                        {{-- Delivery Distance --}}
                        <div class="pt-6 border-t border-neutral-100">
                            <label for="free_delivery_distance" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Free Delivery Distance</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="free_delivery_distance" id="free_delivery_distance" inputmode="decimal" value="{{ old('free_delivery_distance', $settings->free_delivery_distance) }}"
                                       class="block w-full px-6 pr-12 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold shadow-sm text-lg" required>
                                <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                    <span class="text-neutral-400 font-bold">km</span>
                                </div>
                            </div>
                            @error('free_delivery_distance') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Charge Per Km --}}
                        <div class="pt-6 border-t border-neutral-100">
                            <label for="charge_per_km" class="block text-[11px] font-bold text-neutral-500 uppercase tracking-wider mb-2 ml-1">Charge Per Additional km</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <span class="text-neutral-500 font-bold">$</span>
                                </div>
                                <input type="number" step="0.01" name="charge_per_km" id="charge_per_km" inputmode="decimal" value="{{ old('charge_per_km', $settings->charge_per_km) }}"
                                       class="block w-full pl-10 pr-6 py-4 bg-neutral-50 border border-neutral-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all text-neutral-800 font-semibold shadow-sm text-lg" required>
                            </div>
                            @error('charge_per_km') <p class="mt-2 text-xs font-semibold text-red-600 ml-1">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                <div class="px-6 md:px-10 py-6 md:py-8 bg-neutral-50/50 border-t border-neutral-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-neutral-400 font-medium italic text-center sm:text-left">These settings apply immediately to new orders.</p>
                    <button type="submit" class="w-full sm:w-auto justify-center px-8 py-3 bg-brand-600 text-white rounded-xl font-bold shadow-lg shadow-brand-200 hover:bg-brand-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
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
