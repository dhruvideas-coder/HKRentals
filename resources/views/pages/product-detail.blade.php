@extends('layouts.app')

@section('title', 'Gold Chiavari Chairs')
@section('meta_description', 'View full details, pricing, and availability for our premium rental items.')

@section('content')

{{-- ══════════════════════════════════════════════════════════
     PRODUCT DETAIL — Full Page
══════════════════════════════════════════════════════════ --}}
<section class="py-10 bg-cream" aria-label="Product detail" x-data="{
    activeImage: '{{ asset('images/product-chairs.png') }}',
    qty: 1,
    startDate: '',
    endDate: '',
    inc() { this.qty++ },
    dec() { if(this.qty > 1) this.qty-- },
    addToCart() {
        Alpine.store('cart').add({
            id: {{ $product['id'] ?? 1 }},
            name: '{{ addslashes($product['name'] ?? 'Gold Chiavari Chairs') }}',
            image: this.activeImage,
            category: '{{ $product['cat'] ?? 'Seating' }}',
            price: {{ $product['price'] ?? 4 }},
            qty: this.qty,
            dateRange: this.startDate && this.endDate ? this.startDate + ' → ' + this.endDate : null,
        });
        $dispatch('open-cart');
    }
}">
<div class="container-sk">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-neutral-400 mb-8" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-base">Home</a>
        <span>/</span>
        <a href="{{ route('products') }}" class="hover:text-brand-600 transition-base">Products</a>
        <span>/</span>
        <span class="text-neutral-700 font-medium">{{ $product['name'] ?? 'Gold Chiavari Chairs' }}</span>
    </nav>

    <div class="grid lg:grid-cols-2 gap-12 xl:gap-16 items-start">

        {{-- ── Image Gallery ── --}}
        <div class="space-y-3 lg:sticky lg:top-24">

            {{-- Main Image --}}
            <div class="aspect-square rounded-2xl overflow-hidden bg-neutral-100 shadow-elevated">
                <img :src="activeImage"
                     alt="Product image"
                     class="w-full h-full object-cover transition-all duration-500"
                     loading="eager" />
            </div>

            {{-- Thumbnails --}}
            @php
            $thumbs = [
                asset('images/product-chairs.png'),
                asset('images/product-arch.png'),
                asset('images/product-tableware.png'),
                asset('images/product-lighting.png'),
            ];
            @endphp
            <div class="grid grid-cols-4 gap-2.5">
                @foreach($thumbs as $thumb)
                <button @click="activeImage = '{{ $thumb }}'"
                        class="aspect-square rounded-xl overflow-hidden border-2 transition-all duration-200"
                        :class="activeImage === '{{ $thumb }}' ? 'border-brand-500 opacity-100 shadow-sm' : 'border-transparent opacity-60 hover:opacity-85'"
                        aria-label="View image">
                    <img src="{{ $thumb }}" alt="" class="w-full h-full object-cover" loading="lazy" />
                </button>
                @endforeach
            </div>
        </div>

        {{-- ── Product Info ── --}}
        <div class="space-y-6">

            {{-- Title & Badges --}}
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="badge badge-gold text-xs">{{ $product['cat'] ?? 'Seating' }}</span>
                    <span class="badge badge-available text-xs">✓ Available</span>
                </div>
                <h1 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 leading-tight mb-3">
                    {{ $product['name'] ?? 'Gold Chiavari Chairs' }}
                </h1>
                <div class="flex items-baseline gap-2">
                    <span class="font-bold text-brand-600 text-4xl">${{ $product['price'] ?? '4' }}</span>
                    <span class="text-neutral-400 text-lg">/ day</span>
                </div>
            </div>

            {{-- Description --}}
            <div class="prose prose-sm text-neutral-500 leading-relaxed border-t border-neutral-100 pt-6">
                <p>{{ $product['desc'] ?? 'Elegant gold chiavari chairs with white cushioned seats. Crafted from durable resin with a polished gold finish, these chairs add a touch of luxury to any wedding, gala, or formal event. Perfect for both indoor and outdoor settings.' }}</p>
                <ul class="mt-4 space-y-1 text-sm text-neutral-500 list-disc list-inside">
                    <li>Weight capacity: 300 lbs per chair</li>
                    <li>Dimensions: 36"H × 16"W × 14"D</li>
                    <li>Available as individual chairs or full table sets</li>
                    <li>White, ivory, or blush cushion options included</li>
                </ul>
            </div>

            {{-- Date Picker --}}
            <div class="grid grid-cols-2 gap-4 bg-neutral-50 p-5 rounded-xl border border-neutral-100">
                <div>
                    <label class="form-label text-xs">Event Start Date</label>
                    <input type="date" x-model="startDate" class="form-input text-sm" />
                </div>
                <div>
                    <label class="form-label text-xs">Event End Date</label>
                    <input type="date" x-model="endDate" class="form-input text-sm" />
                </div>
            </div>

            {{-- Qty + Add to Cart --}}
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 bg-neutral-50 rounded-xl px-3 py-2 border border-neutral-200">
                    <button @click="dec" class="qty-btn" aria-label="Decrease quantity">−</button>
                    <span class="w-10 text-center font-bold text-lg text-neutral-800" x-text="qty"></span>
                    <button @click="inc" class="qty-btn" aria-label="Increase quantity">+</button>
                </div>
                <button @click="addToCart" class="btn btn-primary btn-lg flex-1 shadow-glow">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Add to Cart
                </button>
            </div>

            {{-- Trust Badges --}}
            <div class="grid grid-cols-3 gap-3 pt-4 border-t border-neutral-100">
                @foreach([['🚚','Free Delivery','On all orders over $200'],['✨','Sanitized','Cleaned after every use'],['🔄','Flexible','Easy date changes']] as [$icon,$title,$sub])
                <div class="text-center p-3 bg-neutral-50 rounded-xl border border-neutral-100">
                    <span class="text-xl">{{ $icon }}</span>
                    <p class="font-semibold text-neutral-800 text-xs mt-1">{{ $title }}</p>
                    <p class="text-neutral-400 text-[10px] mt-0.5">{{ $sub }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- Related Products --}}
    <div class="mt-20">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="badge badge-gold mb-2">You Might Also Like</span>
                <h2 class="font-display text-2xl font-semibold text-neutral-900">Related Items</h2>
            </div>
            <a href="{{ route('products') }}" class="btn btn-outline btn-sm hidden sm:inline-flex">View All</a>
        </div>

        @php
        $related = [
            ['id'=>2,'image'=>asset('images/product-arch.png'),   'name'=>'Floral Wedding Arch', 'cat'=>'Ceremony', 'price'=>120,'desc'=>'Stunning floral arch with fresh white roses.','available'=>true],
            ['id'=>3,'image'=>asset('images/product-tableware.png'),'name'=>'Luxury Table Setting','cat'=>'Tableware','price'=>18,'desc'=>'Complete premium table setting with gold dinnerware.','available'=>true],
            ['id'=>4,'image'=>asset('images/product-lighting.png'), 'name'=>'String Light Canopy','cat'=>'Lighting',  'price'=>85,'desc'=>'Romantic Edison bulb canopy for outdoor receptions.','available'=>false],
            ['id'=>5,'image'=>asset('images/product-lounge.png'),   'name'=>'White Lounge Suite', 'cat'=>'Furniture','price'=>200,'desc'=>'Luxurious white tufted sofa and armchair set.','available'=>true],
        ];
        @endphp
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $r)
            <x-product-card
                :id="$r['id']"
                :name="$r['name']"
                :image="$r['image']"
                :category="$r['cat']"
                :price="$r['price']"
                :description="$r['desc']"
                :available="$r['available']"
            />
            @endforeach
        </div>
    </div>

</div>
</section>

@endsection
