<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Color coverage  : Gold, White, Silver, Black, Rose Gold, Ivory
     * Material coverage: Wood, Plastic, Metal, Acrylic, Glass, Fabric
     */
    public function run(): void
    {
        // ── Categories ───────────────────────────────────────────────
        $seating   = Category::create(['name' => 'Seating',   'slug' => 'seating']);
        $ceremony  = Category::create(['name' => 'Ceremony',  'slug' => 'ceremony']);
        $tableware = Category::create(['name' => 'Tableware', 'slug' => 'tableware']);
        $lighting  = Category::create(['name' => 'Lighting',  'slug' => 'lighting']);
        $furniture = Category::create(['name' => 'Furniture', 'slug' => 'furniture']);
        $decor     = Category::create(['name' => 'Decor',     'slug' => 'decor']);

        // ────────────────────────────────────────────────────────────
        // SEATING  (5 products — 5 unique images)
        // ────────────────────────────────────────────────────────────
        Product::create([
            'category_id'   => $seating->id,
            'name'          => 'Gold Chiavari Chair',
            'slug'          => 'gold-chiavari-chair',
            'price_per_day' => 4,
            'total_quantity' => 150,
            'color'         => 'Gold',
            'material'      => 'Wood',
            'image'         => 'product-chairs.png',          // existing
            'status'        => 'available',
            'description'   => 'Elegant gold chiavari chairs with white cushioned seats. Perfect for weddings and formal events.',
        ]);

        Product::create([
            'category_id'   => $seating->id,
            'name'          => 'White Folding Chair',
            'slug'          => 'white-folding-chair',
            'price_per_day' => 2.50,
            'total_quantity' => 200,
            'color'         => 'White',
            'material'      => 'Plastic',
            'image'         => 'chair-folding-white.png',
            'status'        => 'available',
            'description'   => 'Lightweight white folding chairs ideal for outdoor ceremonies, receptions, and garden parties.',
        ]);

        Product::create([
            'category_id'   => $seating->id,
            'name'          => 'Silver Cross-Back Chair',
            'slug'          => 'silver-cross-back-chair',
            'price_per_day' => 5,
            'total_quantity' => 80,
            'color'         => 'Silver',
            'material'      => 'Metal',
            'image'         => 'chair-crossback-silver.png',
            'status'        => 'available',
            'description'   => 'Brushed silver metal cross-back dining chair with a linen cushion. A rustic-modern favourite for barn and garden weddings.',
        ]);

        Product::create([
            'category_id'   => $seating->id,
            'name'          => 'Black Bentwood Chair',
            'slug'          => 'black-bentwood-chair',
            'price_per_day' => 3.50,
            'total_quantity' => 100,
            'color'         => 'Black',
            'material'      => 'Wood',
            'image'         => 'chair-bentwood-black.png',
            'status'        => 'available',
            'description'   => 'Sleek black bentwood chair with timeless curved lines. Versatile for elegant banquets and cocktail events.',
        ]);

        Product::create([
            'category_id'   => $seating->id,
            'name'          => 'Rose Gold Ghost Chair',
            'slug'          => 'rose-gold-ghost-chair',
            'price_per_day' => 7,
            'total_quantity' => 60,
            'color'         => 'Rose Gold',
            'material'      => 'Acrylic',
            'image'         => 'chair-ghost-rosegold.png',
            'status'        => 'available',
            'description'   => 'Modern transparent acrylic ghost chair with a rose gold metallic sheen. Stunning for luxury and contemporary wedding receptions.',
        ]);

        // ────────────────────────────────────────────────────────────
        // CEREMONY  (3 products — 3 unique images)
        // ────────────────────────────────────────────────────────────
        Product::create([
            'category_id'   => $ceremony->id,
            'name'          => 'Floral Wedding Arch',
            'slug'          => 'floral-wedding-arch',
            'price_per_day' => 120,
            'total_quantity' => 3,
            'color'         => 'White',
            'material'      => 'Metal',
            'image'         => 'product-arch.png',            // existing
            'status'        => 'available',
            'description'   => 'Stunning floral arch with fresh white roses and eucalyptus. Makes a breathtaking ceremony backdrop.',
        ]);

        Product::create([
            'category_id'   => $ceremony->id,
            'name'          => 'Rustic Wooden Arch',
            'slug'          => 'rustic-wooden-arch',
            'price_per_day' => 85,
            'total_quantity' => 4,
            'color'         => 'Ivory',
            'material'      => 'Wood',
            'image'         => 'arch-rustic-wooden.png',
            'status'        => 'available',
            'description'   => 'Handcrafted rustic wooden arch with a natural finish. A timeless choice for barn and outdoor weddings.',
        ]);

        Product::create([
            'category_id'   => $ceremony->id,
            'name'          => 'Gold Metal Arch',
            'slug'          => 'gold-metal-arch',
            'price_per_day' => 95,
            'total_quantity' => 5,
            'color'         => 'Gold',
            'material'      => 'Metal',
            'image'         => 'arch-gold-metal.png',
            'status'        => 'available',
            'description'   => 'Sleek geometric gold metal arch. The perfect frame for your vows, draped with florals or fabric.',
        ]);

        // ────────────────────────────────────────────────────────────
        // TABLEWARE  (3 products — 3 unique images)
        // ────────────────────────────────────────────────────────────
        Product::create([
            'category_id'   => $tableware->id,
            'name'          => 'Luxury Table Setting',
            'slug'          => 'luxury-table-setting',
            'price_per_day' => 18,
            'total_quantity' => 120,
            'color'         => 'Gold',
            'material'      => 'Glass',
            'image'         => 'product-tableware.png',       // existing
            'status'        => 'available',
            'description'   => 'Complete premium table setting with white and gold dinnerware, crystal glasses, and silverware.',
        ]);

        Product::create([
            'category_id'   => $tableware->id,
            'name'          => 'Silver Charger Plate Set',
            'slug'          => 'silver-charger-plate-set',
            'price_per_day' => 8,
            'total_quantity' => 200,
            'color'         => 'Silver',
            'material'      => 'Metal',
            'image'         => 'tableware-silver-charger.png',
            'status'        => 'available',
            'description'   => 'Elegant silver charger plates with a beaded rim. Set of 10, perfect for formal dinner reception tables.',
        ]);

        Product::create([
            'category_id'   => $tableware->id,
            'name'          => 'Crystal Glassware Set',
            'slug'          => 'crystal-glassware-set',
            'price_per_day' => 12,
            'total_quantity' => 150,
            'color'         => 'Silver',
            'material'      => 'Glass',
            'image'         => 'tableware-crystal-glass.png',
            'status'        => 'available',
            'description'   => 'Sparkling crystal wine and champagne glasses. Set of 12 for an opulent table presentation.',
        ]);

        // ────────────────────────────────────────────────────────────
        // LIGHTING  (3 products — 3 unique images)
        // ────────────────────────────────────────────────────────────
        Product::create([
            'category_id'   => $lighting->id,
            'name'          => 'String Bistro Lights',
            'slug'          => 'string-bistro-lights',
            'price_per_day' => 45,
            'total_quantity' => 20,
            'color'         => 'Gold',
            'material'      => 'Metal',
            'image'         => 'product-lighting.png',        // existing
            'status'        => 'available',
            'description'   => 'Warm Edison-style bistro lights to create a magical atmosphere for your evening event.',
        ]);

        Product::create([
            'category_id'   => $lighting->id,
            'name'          => 'Fairy Light Curtain',
            'slug'          => 'fairy-light-curtain',
            'price_per_day' => 35,
            'total_quantity' => 15,
            'color'         => 'White',
            'material'      => 'Metal',
            'image'         => 'lighting-fairy-curtain.png',
            'status'        => 'available',
            'description'   => 'Shimmering white fairy light curtain backdrop. Perfect for photo walls and head tables.',
        ]);

        Product::create([
            'category_id'   => $lighting->id,
            'name'          => 'Gold Lantern Cluster',
            'slug'          => 'gold-lantern-cluster',
            'price_per_day' => 55,
            'total_quantity' => 10,
            'color'         => 'Gold',
            'material'      => 'Metal',
            'image'         => 'lighting-gold-lanterns.png',
            'status'        => 'available',
            'description'   => 'Cluster of varying-height gold lanterns with warm candle-effect lights. Stunning centrepiece or aisle decor.',
        ]);

        // ────────────────────────────────────────────────────────────
        // FURNITURE  (3 products — 3 unique images)
        // ────────────────────────────────────────────────────────────
        Product::create([
            'category_id'   => $furniture->id,
            'name'          => 'Velvet Lounge Set',
            'slug'          => 'velvet-lounge-set',
            'price_per_day' => 250,
            'total_quantity' => 4,
            'color'         => 'Ivory',
            'material'      => 'Fabric',
            'image'         => 'product-lounge.png',          // existing
            'status'        => 'available',
            'description'   => 'Sophisticated ivory velvet sofa with two matching armchairs and a gold coffee table.',
        ]);

        Product::create([
            'category_id'   => $furniture->id,
            'name'          => 'White Farm Table',
            'slug'          => 'white-farm-table',
            'price_per_day' => 75,
            'total_quantity' => 12,
            'color'         => 'White',
            'material'      => 'Wood',
            'image'         => 'furniture-farm-table.png',
            'status'        => 'available',
            'description'   => 'Classic white farm-style rectangular table. Seats up to 8 guests. Great for outdoor receptions.',
        ]);

        Product::create([
            'category_id'   => $furniture->id,
            'name'          => 'Gold Sweetheart Table',
            'slug'          => 'gold-sweetheart-table',
            'price_per_day' => 90,
            'total_quantity' => 5,
            'color'         => 'Gold',
            'material'      => 'Metal',
            'image'         => 'furniture-sweetheart-table.png',
            'status'        => 'available',
            'description'   => 'Elegant gold sweetheart table for the bride and groom. Features a curved design with a draped satin cloth.',
        ]);

        // ────────────────────────────────────────────────────────────
        // DECOR  (4 products — 4 unique images)
        // ────────────────────────────────────────────────────────────
        Product::create([
            'category_id'   => $decor->id,
            'name'          => 'Vintage Backdrop',
            'slug'          => 'vintage-backdrop',
            'price_per_day' => 85,
            'total_quantity' => 6,
            'color'         => 'Ivory',
            'material'      => 'Wood',
            'image'         => 'product-backdrop.png',        // existing
            'status'        => 'available',
            'description'   => 'Beautifully aged vintage wood backdrop, perfect for photo booths or head tables.',
        ]);

        Product::create([
            'category_id'   => $decor->id,
            'name'          => 'Gold Geometric Sphere',
            'slug'          => 'gold-geometric-sphere',
            'price_per_day' => 25,
            'total_quantity' => 20,
            'color'         => 'Gold',
            'material'      => 'Metal',
            'image'         => 'decor-gold-sphere.png',
            'status'        => 'available',
            'description'   => 'Striking gold geometric sphere centrepiece. Available in multiple sizes to suit any table layout.',
        ]);

        Product::create([
            'category_id'   => $decor->id,
            'name'          => 'White Floral Wall Panel',
            'slug'          => 'white-floral-wall-panel',
            'price_per_day' => 110,
            'total_quantity' => 4,
            'color'         => 'White',
            'material'      => 'Fabric',
            'image'         => 'decor-floral-wall.png',
            'status'        => 'available',
            'description'   => 'Lush white artificial floral wall panel. An Instagram-worthy backdrop for any celebration.',
        ]);

        Product::create([
            'category_id'   => $decor->id,
            'name'          => 'Rose Gold Candle Holders',
            'slug'          => 'rose-gold-candle-holders',
            'price_per_day' => 15,
            'total_quantity' => 50,
            'color'         => 'Rose Gold',
            'material'      => 'Metal',
            'image'         => 'decor-rosegold-candles.png',
            'status'        => 'available',
            'description'   => 'Set of 5 rose gold pillar candle holders in varying heights. Creates a romantic, warm ambiance.',
        ]);

        // ── 3 extra products to reach 24 total (3 perfect pages of 9) ─
        Product::create([
            'category_id'   => $ceremony->id,
            'name'          => 'Ivory Unity Candle Stand',
            'slug'          => 'ivory-unity-candle-stand',
            'price_per_day' => 30,
            'total_quantity' => 10,
            'color'         => 'Ivory',
            'material'      => 'Metal',
            'image'         => 'ceremony-unity-candle.png',
            'status'        => 'available',
            'description'   => 'Elegant ivory unity candle set on silver metal stands. A meaningful and beautiful addition to any wedding ceremony.',
        ]);

        Product::create([
            'category_id'   => $tableware->id,
            'name'          => 'Gold Flatware Set',
            'slug'          => 'gold-flatware-set',
            'price_per_day' => 10,
            'total_quantity' => 300,
            'color'         => 'Gold',
            'material'      => 'Metal',
            'image'         => 'tableware-gold-flatware.png',
            'status'        => 'available',
            'description'   => 'Gleaming gold-plated flatware set (fork, knife, spoon). Adds a regal touch to any reception table.',
        ]);

        Product::create([
            'category_id'   => $lighting->id,
            'name'          => 'Black LED Uplights',
            'slug'          => 'black-led-uplights',
            'price_per_day' => 60,
            'total_quantity' => 16,
            'color'         => 'Black',
            'material'      => 'Plastic',
            'image'         => 'product-lighting.png',
            'status'        => 'available',
            'description'   => 'Sleek black LED uplighting fixtures that wash venue walls in warm colour. Set of 4, wireless and battery-powered.',
        ]);
    }
}
