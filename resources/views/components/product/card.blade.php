{{--
    Product Card Component
    Props: name, image, category, price, description, available (true|false|null), id
--}}
@props([
    'name'        => 'Product',
    'image'       => '',
    'category'    => '',
    'price'       => '0',
    'description' => '',
    'available'   => true,
    'id'          => null,
    'href'        => '#',
])

<article class="group card flex flex-col h-full overflow-hidden hover:shadow-elevated transition-all duration-300 hover:-translate-y-1"
         x-data>

    {{-- Image --}}
    <div class="relative overflow-hidden aspect-[4/3] flex-shrink-0">
        <img src="{{ $image ?: asset('images/product-chairs.png') }}"
             alt="{{ $name }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
             loading="lazy" />

        {{-- Category badge --}}
        @if($category)
        <span class="absolute top-3 left-3 badge badge-gold text-[10px] sm:text-xs">{{ $category }}</span>
        @endif

        {{-- Availability badge --}}
        <span class="absolute top-3 right-3 badge {{ $available ? 'badge-available' : 'badge-unavailable' }} text-[10px] sm:text-xs">
            {{ $available ? 'Available' : 'Booked' }}
        </span>

        {{-- Hover overlay --}}
        <div class="absolute inset-0 bg-brand-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <a href="{{ $href }}"
               class="btn bg-white text-brand-700 hover:bg-brand-50 border-transparent btn-sm shadow-lg translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                View Details
            </a>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-5 flex flex-col flex-1">
        <h3 class="font-display font-semibold text-neutral-900 text-lg mb-1.5 leading-snug line-clamp-1">{{ $name }}</h3>
        
        @if($description)
        <p class="text-neutral-500 text-sm leading-relaxed line-clamp-2 flex-1">{{ $description }}</p>
        @else
        <div class="flex-1"></div>
        @endif

        <div class="flex items-center justify-between gap-1 pt-4 border-t border-neutral-50 flex-nowrap">
            <div class="flex items-baseline gap-1 whitespace-nowrap">
                <span class="font-bold text-brand-600 text-base sm:text-lg leading-none">${{ $price }}</span>
                <span class="text-[9px] sm:text-[10px] font-normal text-neutral-400 uppercase tracking-wider">/ day</span>
            </div>
            <button
                @click="
                    Alpine.store('cart').add({
                        id: {{ $id ?? 0 }},
                        name: '{{ addslashes($name) }}',
                        image: '{{ $image }}',
                        category: '{{ $category }}',
                        price: {{ (float) $price }},
                        qty: 1,
                    });
                "
                class="btn btn-primary btn-sm px-2 sm:px-4 flex-shrink-0"
                {{ !$available ? 'disabled' : '' }}>
                <span class="hidden xl:inline">Add to Cart</span>
                <span class="xl:hidden">+ Cart</span>
            </button>
        </div>
    </div>
</article>
