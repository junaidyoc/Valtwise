<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $subcategories = [
            'apparel-clothing' => [
                ['name' => 'Women\'s Fashion', 'icon' => '👗'],
                ['name' => 'Men\'s Fashion', 'icon' => '👔'],
                ['name' => 'Kids\' Clothing', 'icon' => '👶'],
                ['name' => 'Shoes & Footwear', 'icon' => '👟'],
                ['name' => 'Accessories', 'icon' => '👜'],
                ['name' => 'Activewear', 'icon' => '🏃'],
            ],
            'electronics' => [
                ['name' => 'Smartphones', 'icon' => '📱'],
                ['name' => 'Laptops & Computers', 'icon' => '💻'],
                ['name' => 'TVs & Home Theater', 'icon' => '📺'],
                ['name' => 'Headphones & Audio', 'icon' => '🎧'],
                ['name' => 'Cameras', 'icon' => '📷'],
                ['name' => 'Gaming', 'icon' => '🎮'],
            ],
            'health-beauty' => [
                ['name' => 'Skincare', 'icon' => '🧴'],
                ['name' => 'Makeup', 'icon' => '💄'],
                ['name' => 'Haircare', 'icon' => '💇'],
                ['name' => 'Fragrances', 'icon' => '🌸'],
                ['name' => 'Vitamins & Supplements', 'icon' => '💊'],
            ],
            'travel' => [
                ['name' => 'Flights', 'icon' => '✈️'],
                ['name' => 'Hotels', 'icon' => '🏨'],
                ['name' => 'Car Rentals', 'icon' => '🚗'],
                ['name' => 'Holiday Packages', 'icon' => '🏖️'],
                ['name' => 'Luggage', 'icon' => '🧳'],
            ],
            'sports-outdoors' => [
                ['name' => 'Fitness Equipment', 'icon' => '🏋️'],
                ['name' => 'Outdoor Gear', 'icon' => '🏕️'],
                ['name' => 'Cycling', 'icon' => '🚴'],
                ['name' => 'Running', 'icon' => '🏃'],
                ['name' => 'Team Sports', 'icon' => '⚽'],
            ],
            'food-drinks' => [
                ['name' => 'Groceries', 'icon' => '🛒'],
                ['name' => 'Restaurants', 'icon' => '🍽️'],
                ['name' => 'Food Delivery', 'icon' => '🚚'],
                ['name' => 'Wine & Spirits', 'icon' => '🍷'],
                ['name' => 'Coffee & Tea', 'icon' => '☕'],
            ],
            'home-garden' => [
                ['name' => 'Furniture', 'icon' => '🛋️'],
                ['name' => 'Kitchen', 'icon' => '🍳'],
                ['name' => 'Bedding', 'icon' => '🛏️'],
                ['name' => 'Garden & Outdoor', 'icon' => '🌱'],
                ['name' => 'Home Decor', 'icon' => '🖼️'],
            ],
            'babies-kids' => [
                ['name' => 'Baby Gear', 'icon' => '🍼'],
                ['name' => 'Toys', 'icon' => '🧸'],
                ['name' => 'Kids\' Fashion', 'icon' => '👕'],
                ['name' => 'School Supplies', 'icon' => '📚'],
            ],
        ];

        foreach ($subcategories as $parentSlug => $subs) {
            $parent = Category::where('slug', $parentSlug)->first();

            if (!$parent) {
                $this->command->warn("Parent category '{$parentSlug}' not found, skipping...");
                continue;
            }

            foreach ($subs as $sub) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($sub['name'])],
                    [
                        'name' => $sub['name'],
                        'icon' => $sub['icon'],
                        'parent_id' => $parent->id,
                    ]
                );
            }

            $this->command->info("Added " . count($subs) . " subcategories to '{$parent->name}'");
        }

        // Assign stores from parent categories to random subcategories
        $this->assignStoresToSubcategories();
    }

    private function assignStoresToSubcategories(): void
    {
        $this->command->info("\nAssigning stores to subcategories...");

        // Get all parent categories that have children
        $parentCategories = Category::parents()->with('children')->has('children')->get();

        foreach ($parentCategories as $parent) {
            // Get stores assigned to this parent category
            $stores = $parent->stores()->get();

            if ($stores->isEmpty()) {
                continue;
            }

            $subcategoryIds = $parent->children->pluck('id')->toArray();

            foreach ($stores as $store) {
                // Randomly pick 1-2 subcategories for each store
                $numSubs = min(rand(1, 2), count($subcategoryIds));
                $randomSubs = collect($subcategoryIds)->shuffle()->take($numSubs)->toArray();

                // Attach subcategories (sync without detaching to keep parent)
                $store->categories()->syncWithoutDetaching($randomSubs);
            }

            $this->command->info("Assigned {$stores->count()} stores to subcategories of '{$parent->name}'");
        }
    }
}
