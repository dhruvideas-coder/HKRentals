<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $c1 = \App\Models\Category::create(['name' => 'Seating', 'slug' => 'seating']);
        $c2 = \App\Models\Category::create(['name' => 'Ceremony', 'slug' => 'ceremony']);
        $c3 = \App\Models\Category::create(['name' => 'Tableware', 'slug' => 'tableware']);
        \App\Models\Category::create(['name' => 'Lighting', 'slug' => 'lighting']);
        \App\Models\Category::create(['name' => 'Furniture', 'slug' => 'furniture']);
        \App\Models\Category::create(['name' => 'Decor', 'slug' => 'decor']);

        \App\Models\Product::create([
            'category_id' => $c1->id, 
            'name' => 'Gold Chiavari Chairs', 
            'slug' => 'gold-chiavari-chairs', 
            'price_per_day' => 4, 
            'image' => 'product-chairs.png', 
            'description' => 'Elegant gold chiavari chairs with white cushioned seats. Perfect for weddings and formal events.'
        ]);

        \App\Models\Product::create([
            'category_id' => $c2->id, 
            'name' => 'Floral Wedding Arch', 
            'slug' => 'floral-wedding-arch', 
            'price_per_day' => 120, 
            'image' => 'product-arch.png', 
            'description' => 'Stunning floral arch with fresh white roses and eucalyptus. Makes a breathtaking ceremony backdrop.'
        ]);

        \App\Models\Product::create([
            'category_id' => $c3->id, 
            'name' => 'Luxury Table Setting', 
            'slug' => 'luxury-table-setting', 
            'price_per_day' => 18, 
            'image' => 'product-tableware.png', 
            'description' => 'Complete premium table setting with white and gold dinnerware, crystal glasses, and silverware.'
        ]);

        \App\Models\Product::create([
            'category_id' => \App\Models\Category::where('slug', 'decor')->first()->id, 
            'name' => 'Vintage Backdrop', 
            'slug' => 'vintage-backdrop', 
            'price_per_day' => 85, 
            'image' => 'product-backdrop.png', 
            'description' => 'Beautifully aged vintage wood backdrop, perfect for photo booths or head tables.'
        ]);

        \App\Models\Product::create([
            'category_id' => \App\Models\Category::where('slug', 'lighting')->first()->id, 
            'name' => 'String Bistro Lights', 
            'slug' => 'string-bistro-lights', 
            'price_per_day' => 45, 
            'image' => 'product-lighting.png', 
            'description' => 'Warm Edison-style bistro lights to create a magical atmosphere for your evening event.'
        ]);

        \App\Models\Product::create([
            'category_id' => \App\Models\Category::where('slug', 'furniture')->first()->id, 
            'name' => 'Velvet Lounge Set', 
            'slug' => 'velvet-lounge-set', 
            'price_per_day' => 250, 
            'image' => 'product-lounge.png', 
            'description' => 'Sophisticated emerald velvet sofa with two matching armchairs and a gold coffee table.'
        ]);
    }
}
