<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Tent',
                'icon'        => '⛺',
                'description' => 'Frame tents, pole tents, canopy tents, and complete tent packages for any outdoor event.',
                'image'       => 'images/categories/tent.png',
            ],
            [
                'name'        => 'Table',
                'icon'        => '🪞',
                'description' => 'Banquet tables, round tables, cocktail tables, farm tables, and folding tables.',
                'image'       => 'images/categories/table.png',
            ],
            [
                'name'        => 'Chair',
                'icon'        => '🪑',
                'description' => 'Chiavari chairs, folding chairs, cross-back chairs, ghost chairs, and specialty seating.',
                'image'       => 'images/categories/chair.png',
            ],
            [
                'name'        => 'Games',
                'icon'        => '🎲',
                'description' => 'Giant lawn games, casino tables, carnival games, and interactive entertainment for all ages.',
                'image'       => 'images/categories/games.png',
            ],
            [
                'name'        => 'Linens',
                'icon'        => '🎀',
                'description' => 'Table linens, tablecloths, napkins, chair covers, sashes, and custom fabric options.',
                'image'       => 'images/categories/linens.png',
            ],
            [
                'name'        => 'Tent Sidewalls & Accessories',
                'icon'        => '🏕️',
                'description' => 'Clear and solid sidewalls, tent lighting, flooring, HVAC units, and tent add-ons.',
                'image'       => 'images/categories/tent-sidewalls-accessories.png',
            ],
            [
                'name'        => 'Dance Floor',
                'icon'        => '💃',
                'description' => 'Portable dance floors in hardwood, white, black, LED, and custom designs.',
                'image'       => 'images/categories/dance-floor.png',
            ],
            [
                'name'        => 'Marquee Letters',
                'icon'        => '🔡',
                'description' => 'Light-up marquee letters and numbers, available in gold, silver, and custom sizes.',
                'image'       => 'images/categories/marquee-letters.png',
            ],
            [
                'name'        => 'Event Backdrop',
                'icon'        => '🖼️',
                'description' => 'Floral walls, sequin backdrops, balloon arches, and custom photo booth backgrounds.',
                'image'       => 'images/categories/event-backdrop.png',
            ],
            [
                'name'        => 'Wedding & Event Packages',
                'icon'        => '💍',
                'description' => 'All-inclusive rental packages for weddings, galas, corporate events, and milestone celebrations.',
                'image'       => 'images/categories/wedding-event-packages.png',
            ],
        ];

        foreach ($categories as $data) {
            $slug = Str::slug($data['name']);
            Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $data['name'],
                    'icon'        => $data['icon'],
                    'description' => $data['description'],
                    'image'       => $data['image'],
                ]
            );
        }
    }
}
