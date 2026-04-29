@props(['products' => []])

<div {{ $attributes->merge(['class' => 'grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6']) }}>
    @foreach ($products as $product)
        <x-product.card 
            :name="$product['name']" 
            :image="isset($product['image']) && !str_starts_with($product['image'], 'http') ? asset('images/' . $product['image']) : ($product['image'] ?? '')" 
            :category="$product['cat'] ?? $product['category'] ?? ''" 
            :price="str_replace('$', '', $product['price'] ?? '0')" 
            :description="$product['desc'] ?? $product['description'] ?? ''" 
        />
    @endforeach
</div>
