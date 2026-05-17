<x-layout.app-layout>
    <x-slot:title>{{ $product->name }}</x-slot>
    <x-slot:metaDescription>{{ Str::limit($product->description, 160) }}</x-slot>

    @php
        $mainImage   = $product->image ? asset($product->image) : asset('images/products/product-chairs.png');
        $galleryUrls = $product->images->map(fn($img) => asset($img->image))->values()->toArray();
        $allImages   = array_merge([$mainImage], $galleryUrls);
    @endphp

    <x-section class="bg-cream" aria-label="Product detail" x-data="{
        allImages: {{ json_encode($allImages) }},
        activeImage: {{ json_encode($allImages[0]) }},
        qty: 1,
        maxQty: {{ $product->total_quantity }},
        qtyError: '',
        inc() {
            if (this.qty >= this.maxQty) {
                this.qtyError = 'Only ' + this.maxQty + ' units available.';
            } else {
                this.qty++;
                this.qtyError = '';
            }
        },
        dec() { if (this.qty > 1) { this.qty--; this.qtyError = ''; } },
        addToCart() {
            Alpine.store('cart').add({
                id: {{ $product->id }},
                name: '{{ addslashes($product->name) }}',
                image: this.activeImage,
                category: '{{ addslashes($product->category?->name ?? '') }}',
                price: {{ (float) $product->price_per_day }},
                qty: this.qty,
            });
        }
    }">
        <x-container>

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-neutral-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-base">Home</a>
                <span>/</span>
                <a href="{{ route('products') }}" class="hover:text-brand-600 transition-base">Products</a>
                @if ($product->category)
                    <span>/</span>
                    <a href="{{ route('products', ['category' => $product->category->slug]) }}"
                        class="hover:text-brand-600 transition-base">{{ $product->category->name }}</a>
                @endif
                <span>/</span>
                <span class="text-neutral-700 font-medium">{{ $product->name }}</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-12 xl:gap-16 items-start">

                {{-- ── Image Gallery ── --}}
                <div class="space-y-3 lg:sticky lg:top-24">

                    {{-- Main Image --}}
                    <div class="aspect-square rounded-2xl overflow-hidden bg-neutral-100 shadow-elevated">
                        <img :src="activeImage" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-all duration-500" loading="eager" />
                    </div>

                    {{-- Thumbnails --}}
                    <div class="grid grid-cols-4 gap-2.5">
                        <template x-for="(img, i) in allImages" :key="i">
                            <button @click="activeImage = img"
                                :class="activeImage === img
                                    ? 'border-brand-500 opacity-100 shadow-sm'
                                    : 'border-transparent opacity-55 hover:opacity-90 hover:border-neutral-300'"
                                class="aspect-square rounded-xl overflow-hidden border-2 transition-all duration-200"
                                :aria-label="'View image ' + (i + 1)">
                                <img :src="img" :alt="'{{ $product->name }} image ' + (i + 1)"
                                    class="w-full h-full object-cover" loading="lazy" />
                            </button>
                        </template>
                    </div>
                </div>

                {{-- ── Product Info ── --}}
                <div class="space-y-6">

                    {{-- Title & Badges --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            @if ($product->category)
                                <x-badge variant="gold" class="text-xs">{{ $product->category->name }}</x-badge>
                            @endif
                            <x-badge variant="{{ $product->status === 'available' ? 'available' : 'unavailable' }}"
                                class="text-xs">
                                {{ $product->status === 'available' ? '✓ Available' : '✗ Unavailable' }}
                            </x-badge>
                        </div>
                        <h1 class="font-display text-3xl sm:text-4xl font-bold text-neutral-900 leading-tight mb-3">
                            {{ $product->name }}
                        </h1>
                        <div class="flex items-baseline gap-2">
                            <span class="font-bold text-brand-600 text-4xl">${{ number_format($product->price_per_day, 2) }}</span>
                            <span class="text-neutral-400 text-lg">/ day</span>
                        </div>
                    </div>

                    {{-- Attributes --}}
                    @if ($product->color || $product->material)
                        <div class="flex flex-wrap gap-3">
                            @if ($product->color)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-neutral-100 text-sm text-neutral-600 font-medium">
                                    <span class="w-2 h-2 rounded-full bg-neutral-400"></span>{{ $product->color }}
                                </span>
                            @endif
                            @if ($product->material)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-neutral-100 text-sm text-neutral-600 font-medium">
                                    <span class="w-2 h-2 rounded-full bg-neutral-400"></span>{{ $product->material }}
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Description --}}
                    @if ($product->description)
                        <div class="prose prose-sm text-neutral-500 leading-relaxed border-t border-neutral-100">
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif

                    {{-- Stock info --}}
                    <div class="flex items-center gap-2 text-sm text-neutral-500 border-t border-neutral-100">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>{{ $product->total_quantity }} units available</span>
                    </div>

                    {{-- Qty + Add to Cart --}}
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 bg-neutral-50 rounded-xl px-3 py-2 border"
                             :class="qtyError ? 'border-red-400' : 'border-neutral-200'">
                            <button @click="dec" class="qty-btn" aria-label="Decrease quantity">−</button>
                            <span class="w-10 text-center font-bold text-lg text-neutral-800" x-text="qty"></span>
                            <button @click="inc" class="qty-btn" aria-label="Increase quantity">+</button>
                        </div>
                        <x-button @click="addToCart" class="btn-lg flex-1 shadow-glow" :disabled="$product->status !== 'available'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ $product->status === 'available' ? 'Add to Cart' : 'Unavailable' }}
                        </x-button>
                    </div>
                    <p x-show="qtyError" x-text="qtyError" class="text-red-500 text-sm mt-1"></p>

                    {{-- Trust Badges --}}
                    <div class="grid grid-cols-3 gap-3 pt-4 border-t border-neutral-100">
                        @foreach ([['🚚', 'Free Delivery', 'On all orders over $200'], ['✨', 'Sanitized', 'Cleaned after every use'], ['🔄', 'Flexible', 'Easy date changes']] as [$icon, $title, $sub])
                            <div class="text-center p-3 bg-neutral-50 rounded-xl border border-neutral-100">
                                <span class="text-xl">{{ $icon }}</span>
                                <p class="font-semibold text-neutral-800 text-xs mt-1">{{ $title }}</p>
                                <p class="text-neutral-400 text-[10px] mt-0.5">{{ $sub }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Specifications --}}
                    @if (!empty($product->product_specification))
                        <div class="border-t border-neutral-100 pt-6">
                            {{-- Header --}}
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-8 h-8 rounded-xl bg-brand-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-neutral-800">Specifications</h3>
                            </div>

                            {{-- Spec Grid --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($product->product_specification as $key => $value)
                                    <div class="group flex items-start gap-3 bg-neutral-50 hover:bg-white border border-neutral-100 hover:border-brand-100 hover:shadow-sm rounded-2xl px-4 py-3.5 transition-all duration-200">
                                        <div class="w-1.5 h-1.5 rounded-full bg-brand-400 mt-2 flex-shrink-0"></div>
                                        <div class="min-w-0">
                                            <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider leading-none mb-1">{{ $key }}</p>
                                            <p class="text-sm font-bold text-neutral-800 leading-snug break-words">{{ $value }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Related Products --}}
            @if ($related->isNotEmpty())
                <div class="mt-20">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <span class="badge badge-gold mb-2">You Might Also Like</span>
                            <h2 class="font-display text-2xl font-semibold text-neutral-900">Related Items</h2>
                        </div>
                        <a href="{{ route('products') }}" class="btn btn-outline btn-sm hidden sm:inline-flex">View All</a>
                    </div>
                    <x-product.grid :products="$related" />
                </div>
            @endif

        </x-container>
    </x-section>

</x-layout.app-layout>
