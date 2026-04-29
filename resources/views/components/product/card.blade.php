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
])

<article class="group card overflow-hidden hover:shadow-elevated transition-all duration-300 hover:-translate-y-1"
         x-data>

    {{-- Image --}}
    <div class="relative overflow-hidden aspect-[4/3]">
        <img src="{{ $image ?: asset('images/product-chairs.png') }}"
             alt="{{ $name }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
             loading="lazy" />

        {{-- Category badge --}}
        @if($category)
        <span class="absolute top-3 left-3 badge badge-gold text-xs">{{ $category }}</span>
        @endif

        {{-- Availability badge --}}
        <span class="absolute top-3 right-3 badge {{ $available ? 'badge-available' : 'badge-unavailable' }} text-xs">
            {{ $available ? 'Available' : 'Booked' }}
        </span>

        {{-- Hover overlay --}}
        <div class="absolute inset-0 bg-brand-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <a href="{{ $id ? route('products.show', $id) : route('products') }}"
               class="btn bg-white text-brand-700 hover:bg-brand-50 border-transparent btn-sm shadow-lg translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                View Details
            </a>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-5">
        <h3 class="font-display font-semibold text-neutral-900 text-lg mb-1.5 leading-snug">{{ $name }}</h3>
        @if($description)
        <p class="text-neutral-500 text-sm mb-4 leading-relaxed line-clamp-2">{{ $description }}</p>
        @endif

        <div class="flex items-center justify-between mt-auto">
            <div>
                <span class="font-bold text-brand-600 text-xl">${{ $price }}</span>
                <span class="text-sm font-normal text-neutral-400">/day</span>
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
                    $dispatch('open-cart');
                "
                class="btn btn-primary btn-sm"
                {{ !$available ? 'disabled' : '' }}>
                @if($available)
                    Add to Cart
                @else
                    Unavailable
                @endif
            </button>
        </div>
    </div>
</article>
