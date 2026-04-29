@props(['products' => []])

<div {{ $attributes->merge(['class' => 'grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6']) }}>
    @foreach ($products as $product)
        @php
            $isObj = is_object($product);
            $name = $isObj ? $product->name : $product['name'];
            $image = $isObj ? $product->image : ($product['image'] ?? '');
            $categoryName = $isObj ? ($product->category->name ?? '') : ($product['cat'] ?? $product['category'] ?? '');
            $price = $isObj ? $product->price_per_day : str_replace('$', '', $product['price'] ?? '0');
            $description = $isObj ? $product->description : ($product['desc'] ?? $product['description'] ?? '');
            $imgUrl = isset($image) && !str_starts_with($image, 'http') ? asset('images/' . $image) : $image;
        @endphp
        <x-product.card 
            :name="$name" 
            :image="$imgUrl" 
            :category="$categoryName" 
            :price="$price" 
            :description="$description" 
            :href="$isObj ? route('products.show', $product->slug) : '#'"
        />
    @endforeach
</div>
