<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            // ── 1. Fashion & Clothing ─────────────────────────────────────
            [
                'name'        => 'Fashion & Clothing',
                'slug'        => 'fashion-clothing',
                'icon'        => '👗',
                'description' => 'Find the best fashion discount codes and vouchers from top UK & Pakistan clothing brands. Save on ASOS, Nike, SHEIN and 50+ more stores.',
                'children'    => [
                    ['name' => "Women's Fashion",   'slug' => 'womens-fashion',   'icon' => '👒'],
                    ['name' => "Men's Fashion",     'slug' => 'mens-fashion',     'icon' => '👔'],
                    ['name' => 'Kids Clothing',     'slug' => 'kids-clothing',    'icon' => '👕'],
                    ['name' => 'Shoes & Footwear',  'slug' => 'shoes-footwear',   'icon' => '👟'],
                    ['name' => 'Bags & Accessories','slug' => 'bags-accessories', 'icon' => '👜'],
                    ['name' => 'Jewellery',         'slug' => 'jewellery',        'icon' => '💍'],
                    ['name' => 'Watches',           'slug' => 'watches',          'icon' => '⌚'],
                    ['name' => 'Sportswear',        'slug' => 'sportswear',       'icon' => '🏃'],
                    ['name' => 'Ethnic Wear',       'slug' => 'ethnic-wear',      'icon' => '🥻'],
                ],
            ],

            // ── 2. Electronics ───────────────────────────────────────────
            [
                'name'        => 'Electronics',
                'slug'        => 'electronics',
                'icon'        => '💻',
                'description' => 'Best electronics promo codes and deals. Save on Samsung, Apple, Currys and more tech brands in UK & Pakistan.',
                'children'    => [
                    ['name' => 'Mobile Phones',      'slug' => 'mobile-phones',      'icon' => '📱'],
                    ['name' => 'Laptops',            'slug' => 'laptops',            'icon' => '💻'],
                    ['name' => 'Tablets',            'slug' => 'tablets',            'icon' => '📲'],
                    ['name' => 'TVs & Audio',        'slug' => 'tvs-audio',          'icon' => '📺'],
                    ['name' => 'Cameras',            'slug' => 'cameras',            'icon' => '📷'],
                    ['name' => 'Gaming',             'slug' => 'gaming',             'icon' => '🎮'],
                    ['name' => 'Smart Home',         'slug' => 'smart-home',         'icon' => '🏠'],
                    ['name' => 'Accessories',        'slug' => 'tech-accessories',   'icon' => '🔌'],
                    ['name' => 'Printers',           'slug' => 'printers',           'icon' => '🖨️'],
                    ['name' => 'Wearables',          'slug' => 'wearables',          'icon' => '⌚'],
                ],
            ],

            // ── 3. Health & Beauty ───────────────────────────────────────
            [
                'name'        => 'Health & Beauty',
                'slug'        => 'health-beauty',
                'icon'        => '💄',
                'description' => 'Verified health and beauty discount codes. Save on iHerb, Boots, Holland & Barrett and more beauty brands.',
                'children'    => [
                    ['name' => 'Skincare',         'slug' => 'skincare',          'icon' => '🧴'],
                    ['name' => 'Makeup',           'slug' => 'makeup',            'icon' => '💄'],
                    ['name' => 'Hair Care',        'slug' => 'hair-care',         'icon' => '💇'],
                    ['name' => 'Vitamins & Supplements', 'slug' => 'vitamins-supplements', 'icon' => '💊'],
                    ['name' => 'Fragrances',       'slug' => 'fragrances',        'icon' => '🌹'],
                    ['name' => 'Personal Care',    'slug' => 'personal-care',     'icon' => '🪥'],
                    ['name' => 'Pharmacy',         'slug' => 'pharmacy',          'icon' => '🏥'],
                    ['name' => 'Fitness',          'slug' => 'fitness',           'icon' => '🏋️'],
                    ['name' => 'Eye Care',         'slug' => 'eye-care',          'icon' => '👁️'],
                    ['name' => 'Dental Care',      'slug' => 'dental-care',       'icon' => '🦷'],
                ],
            ],

            // ── 4. Travel ────────────────────────────────────────────────
            [
                'name'        => 'Travel',
                'slug'        => 'travel',
                'icon'        => '✈️',
                'description' => 'Best travel discount codes for hotels, flights, holidays and car rentals. Save with Booking.com, Airbnb and more.',
                'children'    => [
                    ['name' => 'Hotels',           'slug' => 'hotels',           'icon' => '🏨'],
                    ['name' => 'Flights',          'slug' => 'flights',          'icon' => '✈️'],
                    ['name' => 'Holiday Packages', 'slug' => 'holiday-packages', 'icon' => '🌴'],
                    ['name' => 'Car Rental',       'slug' => 'car-rental',       'icon' => '🚗'],
                    ['name' => 'Trains & Buses',   'slug' => 'trains-buses',     'icon' => '🚂'],
                    ['name' => 'Cruises',          'slug' => 'cruises',          'icon' => '🚢'],
                    ['name' => 'Travel Insurance', 'slug' => 'travel-insurance', 'icon' => '🛡️'],
                    ['name' => 'Luggage',          'slug' => 'luggage',          'icon' => '🧳'],
                    ['name' => 'Airport Parking',  'slug' => 'airport-parking',  'icon' => '🅿️'],
                    ['name' => 'Activities & Tours','slug' => 'activities-tours','icon' => '🗺️'],
                ],
            ],

            // ── 5. Sports & Outdoors ──────────────────────────────────────
            [
                'name'        => 'Sports & Outdoors',
                'slug'        => 'sports-outdoors',
                'icon'        => '⚽',
                'description' => 'Sports equipment and outdoor gear discount codes. Save on Nike, Adidas, Sports Direct and more.',
                'children'    => [
                    ['name' => 'Football',         'slug' => 'football',         'icon' => '⚽'],
                    ['name' => 'Cricket',          'slug' => 'cricket',          'icon' => '🏏'],
                    ['name' => 'Running',          'slug' => 'running',          'icon' => '🏃'],
                    ['name' => 'Gym & Fitness',    'slug' => 'gym-fitness',      'icon' => '💪'],
                    ['name' => 'Cycling',          'slug' => 'cycling',          'icon' => '🚴'],
                    ['name' => 'Swimming',         'slug' => 'swimming',         'icon' => '🏊'],
                    ['name' => 'Outdoor & Camping','slug' => 'outdoor-camping',  'icon' => '⛺'],
                    ['name' => 'Yoga & Pilates',   'slug' => 'yoga-pilates',     'icon' => '🧘'],
                    ['name' => 'Sports Nutrition', 'slug' => 'sports-nutrition', 'icon' => '🥤'],
                    ['name' => 'Water Sports',     'slug' => 'water-sports',     'icon' => '🏄'],
                ],
            ],

            // ── 6. Home & Garden ─────────────────────────────────────────
            [
                'name'        => 'Home & Garden',
                'slug'        => 'home-garden',
                'icon'        => '🏡',
                'description' => 'Home decor, furniture and garden discount codes. Save on IKEA, Wayfair, Dunelm and more.',
                'children'    => [
                    ['name' => 'Furniture',        'slug' => 'furniture',        'icon' => '🛋️'],
                    ['name' => 'Bedding',          'slug' => 'bedding',          'icon' => '🛏️'],
                    ['name' => 'Kitchen',          'slug' => 'kitchen',          'icon' => '🍳'],
                    ['name' => 'Garden',           'slug' => 'garden',           'icon' => '🌱'],
                    ['name' => 'Lighting',         'slug' => 'lighting',         'icon' => '💡'],
                    ['name' => 'DIY & Tools',      'slug' => 'diy-tools',        'icon' => '🔧'],
                    ['name' => 'Cleaning',         'slug' => 'cleaning',         'icon' => '🧹'],
                    ['name' => 'Home Decor',       'slug' => 'home-decor',       'icon' => '🖼️'],
                    ['name' => 'Appliances',       'slug' => 'appliances',       'icon' => '🫙'],
                    ['name' => 'Security',         'slug' => 'home-security',    'icon' => '🔒'],
                ],
            ],

            // ── 7. Food & Drinks ─────────────────────────────────────────
            [
                'name'        => 'Food & Drinks',
                'slug'        => 'food-drinks',
                'icon'        => '🍔',
                'description' => 'Food delivery and grocery discount codes. Save on Deliveroo, Foodpanda, HelloFresh and more.',
                'children'    => [
                    ['name' => 'Food Delivery',    'slug' => 'food-delivery',    'icon' => '🛵'],
                    ['name' => 'Groceries',        'slug' => 'groceries',        'icon' => '🛒'],
                    ['name' => 'Meal Kits',        'slug' => 'meal-kits',        'icon' => '📦'],
                    ['name' => 'Restaurants',      'slug' => 'restaurants',      'icon' => '🍽️'],
                    ['name' => 'Coffee & Tea',     'slug' => 'coffee-tea',       'icon' => '☕'],
                    ['name' => 'Alcohol & Wine',   'slug' => 'alcohol-wine',     'icon' => '🍷'],
                    ['name' => 'Snacks',           'slug' => 'snacks',           'icon' => '🍿'],
                    ['name' => 'Health Food',      'slug' => 'health-food',      'icon' => '🥗'],
                ],
            ],

            // ── 8. Babies & Kids ─────────────────────────────────────────
            [
                'name'        => 'Babies & Kids',
                'slug'        => 'babies-kids',
                'icon'        => '🍼',
                'description' => 'Baby and kids discount codes. Save on toys, clothing and essentials for children.',
                'children'    => [
                    ['name' => 'Baby Essentials',  'slug' => 'baby-essentials',  'icon' => '🍼'],
                    ['name' => 'Toys & Games',     'slug' => 'toys-games',       'icon' => '🧸'],
                    ['name' => 'Kids Clothing',    'slug' => 'kids-clothing-2',  'icon' => '👶'],
                    ['name' => 'School Supplies',  'slug' => 'school-supplies',  'icon' => '✏️'],
                    ['name' => 'Kids Tech',        'slug' => 'kids-tech',        'icon' => '📱'],
                    ['name' => 'Baby Food',        'slug' => 'baby-food',        'icon' => '🥣'],
                    ['name' => 'Prams & Strollers','slug' => 'prams-strollers',  'icon' => '👶'],
                    ['name' => 'Kids Books',       'slug' => 'kids-books',       'icon' => '📚'],
                ],
            ],

            // ── 9. Software & Tools ──────────────────────────────────────
            [
                'name'        => 'Software & Tools',
                'slug'        => 'software-tools',
                'icon'        => '🛠️',
                'description' => 'Software and online tools discount codes. Save on Namecheap, Hostinger, NordVPN, Canva and more.',
                'children'    => [
                    ['name' => 'Web Hosting',      'slug' => 'web-hosting',      'icon' => '🌐'],
                    ['name' => 'Domain Names',     'slug' => 'domain-names',     'icon' => '🔗'],
                    ['name' => 'VPN',              'slug' => 'vpn',              'icon' => '🔒'],
                    ['name' => 'Design Tools',     'slug' => 'design-tools',     'icon' => '🎨'],
                    ['name' => 'Productivity',     'slug' => 'productivity',     'icon' => '📊'],
                    ['name' => 'Antivirus',        'slug' => 'antivirus',        'icon' => '🛡️'],
                    ['name' => 'Cloud Storage',    'slug' => 'cloud-storage',    'icon' => '☁️'],
                    ['name' => 'Email Marketing',  'slug' => 'email-marketing',  'icon' => '📧'],
                    ['name' => 'SEO Tools',        'slug' => 'seo-tools',        'icon' => '📈'],
                    ['name' => 'AI Tools',         'slug' => 'ai-tools',         'icon' => '🤖'],
                ],
            ],

            // ── 10. Finance ──────────────────────────────────────────────
            [
                'name'        => 'Finance',
                'slug'        => 'finance',
                'icon'        => '💳',
                'description' => 'Financial services and money transfer discount codes. Save with Wise, Revolut and more.',
                'children'    => [
                    ['name' => 'Money Transfer',   'slug' => 'money-transfer',   'icon' => '💸'],
                    ['name' => 'Credit Cards',     'slug' => 'credit-cards',     'icon' => '💳'],
                    ['name' => 'Insurance',        'slug' => 'insurance',        'icon' => '🛡️'],
                    ['name' => 'Crypto',           'slug' => 'crypto',           'icon' => '🪙'],
                    ['name' => 'Savings',          'slug' => 'savings',          'icon' => '🏦'],
                    ['name' => 'Loans',            'slug' => 'loans',            'icon' => '📋'],
                    ['name' => 'Tax',              'slug' => 'tax',              'icon' => '🧾'],
                ],
            ],

            // ── 11. Pets ─────────────────────────────────────────────────
            [
                'name'        => 'Pets',
                'slug'        => 'pets',
                'icon'        => '🐾',
                'description' => 'Pet food, accessories and vet services discount codes. Save on your furry friends.',
                'children'    => [
                    ['name' => 'Dog',              'slug' => 'dog',              'icon' => '🐕'],
                    ['name' => 'Cat',              'slug' => 'cat',              'icon' => '🐈'],
                    ['name' => 'Pet Food',         'slug' => 'pet-food',         'icon' => '🦴'],
                    ['name' => 'Pet Accessories',  'slug' => 'pet-accessories',  'icon' => '🎾'],
                    ['name' => 'Vet Services',     'slug' => 'vet-services',     'icon' => '🏥'],
                    ['name' => 'Pet Insurance',    'slug' => 'pet-insurance',    'icon' => '🛡️'],
                ],
            ],

            // ── 12. Automotive ───────────────────────────────────────────
            [
                'name'        => 'Automotive',
                'slug'        => 'automotive',
                'icon'        => '🚗',
                'description' => 'Car parts, accessories and services discount codes. Save on MOT, insurance and more.',
                'children'    => [
                    ['name' => 'Car Parts',        'slug' => 'car-parts',        'icon' => '🔧'],
                    ['name' => 'Car Insurance',    'slug' => 'car-insurance',    'icon' => '🛡️'],
                    ['name' => 'Car Accessories',  'slug' => 'car-accessories',  'icon' => '🚘'],
                    ['name' => 'Tyres',            'slug' => 'tyres',            'icon' => '⭕'],
                    ['name' => 'MOT & Servicing',  'slug' => 'mot-servicing',    'icon' => '🔩'],
                    ['name' => 'Electric Vehicles','slug' => 'electric-vehicles','icon' => '⚡'],
                    ['name' => 'Car Hire',         'slug' => 'car-hire',         'icon' => '🔑'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            // Check if parent category already exists
            $parent = Category::where('slug', $categoryData['slug'])->first();

            if (!$parent) {
                $parent = Category::create($categoryData);
                $this->command->info("Created category: {$parent->name}");
            } else {
                $this->command->info("Category exists: {$parent->name}");
            }

            // Create children
            foreach ($children as $childData) {
                $childData['parent_id'] = $parent->id;

                // Check if child already exists
                $existingChild = Category::where('slug', $childData['slug'])->first();

                if (!$existingChild) {
                    Category::create($childData);
                    $this->command->info("  - Created subcategory: {$childData['name']}");
                }
            }
        }

        $this->command->info('');
        $this->command->info('Categories seeded successfully!');
        $this->command->info('Total: ' . Category::count() . ' categories');
    }
}
