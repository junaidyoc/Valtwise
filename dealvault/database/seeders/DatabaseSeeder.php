<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;



class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ── Categories ────────────────────────────────────────────────────────
        $categories = [
            ['name' => 'Apparel & Clothing',   'slug' => 'apparel-clothing',  'icon' => '👗'],
            ['name' => 'Electronics',           'slug' => 'electronics',       'icon' => '💻'],
            ['name' => 'Health & Beauty',       'slug' => 'health-beauty',     'icon' => '💄'],
            ['name' => 'Travel',                'slug' => 'travel',            'icon' => '✈️'],
            ['name' => 'Sports & Outdoors',     'slug' => 'sports-outdoors',   'icon' => '⚽'],
            ['name' => 'Food & Drinks',         'slug' => 'food-drinks',       'icon' => '🍔'],
            ['name' => 'Home & Garden',         'slug' => 'home-garden',       'icon' => '🏡'],
            ['name' => 'Babies & Kids',         'slug' => 'babies-kids',       'icon' => '🍼'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ── Stores + Coupons ──────────────────────────────────────────────────
        $stores = [
            [
                'name'                   => 'Nike',
                'slug'                   => 'nike',
                'website_url'            => 'https://www.nike.com',
                'description'            => 'Official Nike store. Shoes, clothing, and gear for every sport.',
                'cashback_rate'          => 4.00,
                'is_featured'            => true,
                'affiliate_url_template' => 'https://track.example-network.com/click?aid=YOUR_ID&mid=nike&url={destination}',
                'network'                => 'commission_factory',
                'categories'             => ['apparel-clothing', 'sports-outdoors'],
                'coupons'                => [
                    ['title' => '20% Off Sitewide', 'code' => 'NIKE20', 'type' => 'code', 'discount_value' => '20%', 'is_verified' => true, 'is_exclusive' => true, 'expires_at' => now()->addDays(30)],
                    ['title' => 'Free Shipping on Orders Over $50', 'code' => null, 'type' => 'deal', 'discount_value' => 'Free Ship', 'is_verified' => true, 'expires_at' => null],
                    ['title' => '15% Off Running Shoes', 'code' => 'RUN15', 'type' => 'code', 'discount_value' => '15%', 'is_verified' => false, 'expires_at' => now()->addDays(14)],
                ],
            ],
            [
                'name'                   => 'Booking.com',
                'slug'                   => 'booking-com',
                'website_url'            => 'https://www.booking.com',
                'description'            => 'Book hotels, flights, and car rentals worldwide.',
                'cashback_rate'          => 3.50,
                'is_featured'            => true,
                'affiliate_url_template' => 'https://track.example-network.com/click?aid=YOUR_ID&mid=booking&url={destination}',
                'network'                => 'cj',
                'categories'             => ['travel'],
                'coupons'                => [
                    ['title' => '10% Off Your First Hotel Booking', 'code' => 'FIRST10', 'type' => 'code', 'discount_value' => '10%', 'is_verified' => true, 'expires_at' => now()->addDays(60)],
                    ['title' => 'Up to 40% Off Secret Deals', 'code' => null, 'type' => 'deal', 'discount_value' => '40%', 'is_verified' => true, 'expires_at' => now()->addDays(7)],
                ],
            ],
            [
                'name'                   => 'Samsung',
                'slug'                   => 'samsung',
                'website_url'            => 'https://www.samsung.com',
                'description'            => 'Official Samsung store for phones, TVs, and home appliances.',
                'cashback_rate'          => 2.00,
                'is_featured'            => true,
                'affiliate_url_template' => 'https://track.example-network.com/click?aid=YOUR_ID&mid=samsung&url={destination}',
                'network'                => 'rakuten',
                'categories'             => ['electronics'],
                'coupons'                => [
                    ['title' => '$100 Off Galaxy S24', 'code' => 'GALAXY100', 'type' => 'code', 'discount_value' => '$100', 'is_verified' => true, 'is_exclusive' => true, 'expires_at' => now()->addDays(20)],
                    ['title' => '25% Off Monitors', 'code' => 'MONITOR25', 'type' => 'code', 'discount_value' => '25%', 'is_verified' => false, 'expires_at' => now()->addDays(10)],
                ],
            ],
            [
                'name'         => 'iHerb',
                'slug'         => 'iherb',
                'website_url'  => 'https://www.iherb.com',
                'description'  => 'Vitamins, supplements, and natural health products.',
                'cashback_rate'=> 5.00,
                'is_featured'  => true,
                'affiliate_url_template' => 'https://track.example-network.com/click?aid=YOUR_ID&mid=iherb&url={destination}',
                'network'      => 'commission_factory',
                'categories'   => ['health-beauty'],
                'coupons'      => [
                    ['title' => '15% Off First Order', 'code' => 'WELCOME15', 'type' => 'code', 'discount_value' => '15%', 'is_verified' => true, 'expires_at' => null],
                    ['title' => 'Extra 5% Off with App', 'code' => 'APP5', 'type' => 'code', 'discount_value' => '5%', 'is_verified' => true, 'expires_at' => now()->addDays(90)],
                ],
            ],
        ];

        foreach ($stores as $data) {
            $coupons    = $data['coupons'];
            $categorySlgs = $data['categories'];
            unset($data['coupons'], $data['categories']);

            $store = Store::firstOrCreate(['slug' => $data['slug']], array_merge($data, ['is_active' => true]));

            // Attach categories
            $categoryIds = Category::whereIn('slug', $categorySlgs)->pluck('id');
            $store->categories()->syncWithoutDetaching($categoryIds);

            // Create coupons
            foreach ($coupons as $couponData) {
                $store->coupons()->firstOrCreate(
                    ['title' => $couponData['title']],
                    array_merge($couponData, [
                        'is_active'      => true,
                        'click_count'    => rand(50, 2000),
                        'is_verified'    => $couponData['is_verified'] ?? false,
                        'is_exclusive'   => $couponData['is_exclusive'] ?? false,
                        'destination_url'=> $data['website_url'],
                    ])
                );
            }
        }

        $this->command->info('Seeded categories, stores, and coupons successfully.');
    }
}
