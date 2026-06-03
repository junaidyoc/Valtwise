<?php

namespace Database\Seeders;

use App\Models\SaleEvent;
use Illuminate\Database\Seeder;

class SaleEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            // 1. January Sales (UK)
            [
                'name' => 'January Sales',
                'slug' => 'january-sales-2026',
                'emoji' => '🏷️',
                'subtitle_tags' => 'New Year Clearance, Winter Sales',
                'event_date' => '2026-01-01',
                'end_date' => '2026-01-31',
                'region' => 'uk',
                'description' => 'The January Sales are one of the biggest shopping events in the UK. Retailers clear out winter stock with discounts of up to 70% off across fashion, homeware, electronics, and more. Many sales start on Boxing Day and continue through January, with the best deals often found in the first two weeks. This is the perfect time to grab winter essentials, furniture, and big-ticket items at a fraction of their original price.',
                'categories' => 'Fashion, Home, Electronics, Beauty',
                'checklist' => [
                    'Make a wishlist of items you want before the sales start',
                    'Compare prices beforehand to spot genuine discounts',
                    'Check store opening times — many open early on January 1st',
                    'Sign up for retailer newsletters for early access codes',
                    'Don\'t forget to check online stores for exclusive web deals',
                ],
                'event_table' => [
                    ['event' => 'New Year\'s Day Sales', 'date' => 'Jan 1', 'categories' => 'All'],
                    ['event' => 'Winter Clearance', 'date' => 'Jan 1-15', 'categories' => 'Fashion'],
                    ['event' => 'Home & Furniture Sales', 'date' => 'All month', 'categories' => 'Home'],
                ],
                'density' => 'high',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],

            // 2. Valentine's Day (Global)
            [
                'name' => 'Valentine\'s Day Sale',
                'slug' => 'valentines-day-2026',
                'emoji' => '💝',
                'subtitle_tags' => 'Valentine\'s Gifts, Romance Deals',
                'event_date' => '2026-02-14',
                'end_date' => '2026-02-14',
                'region' => 'global',
                'description' => 'Valentine\'s Day brings excellent deals on gifts, beauty products, jewelry, and experiences. Both UK and Pakistan retailers offer special promotions on romantic gifts, flowers, chocolates, and dining experiences. Many sales start a week before February 14th, giving you plenty of time to find the perfect gift. Look out for bundle deals on beauty sets and fragrance collections.',
                'categories' => 'Gifts, Beauty, Jewelry, Flowers',
                'checklist' => [
                    'Order flowers and gifts early to avoid delivery delays',
                    'Look for 2-for-1 deals on fragrances and beauty sets',
                    'Check restaurant booking sites for special Valentine\'s menus',
                    'Compare prices on jewelry — many stores offer significant discounts',
                ],
                'event_table' => [
                    ['event' => 'Early Bird Gifts', 'date' => 'Feb 1-7', 'categories' => 'Gifts'],
                    ['event' => 'Valentine\'s Day', 'date' => 'Feb 14', 'categories' => 'All'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],

            // 3. Ramadan Sale (PK)
            [
                'name' => 'Ramadan Sale',
                'slug' => 'ramadan-sale-2026',
                'emoji' => '🌙',
                'subtitle_tags' => 'Ramadan Offers, Iftar Specials',
                'event_date' => '2026-03-01',
                'end_date' => '2026-03-29',
                'region' => 'pk',
                'description' => 'Ramadan is a major shopping season in Pakistan, with retailers offering special promotions throughout the holy month. Expect significant discounts on food and groceries, modest fashion, home decorations, and electronics. Many Pakistani brands launch exclusive Ramadan collections, and e-commerce platforms run flash sales during Sehr and Iftar times. This is also a great time to buy gifts for Eid ul Fitr.',
                'categories' => 'Food, Fashion, Home, Electronics',
                'checklist' => [
                    'Stock up on groceries and dates during weekly flash sales',
                    'Shop for Eid outfits early for the best selection',
                    'Look for bundle deals on home essentials and kitchen items',
                    'Check for Iftar and Sehr time flash sales on apps',
                    'Pre-order Eid gifts to avoid last-minute rush',
                ],
                'event_table' => [
                    ['event' => 'Ramadan Grocery Deals', 'date' => 'All month', 'categories' => 'Food'],
                    ['event' => 'Eid Collection Launch', 'date' => 'Mid-March', 'categories' => 'Fashion'],
                    ['event' => 'Flash Sales', 'date' => 'Daily', 'categories' => 'All'],
                ],
                'density' => 'high',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],

            // 4. Women's Day (Global)
            [
                'name' => 'International Women\'s Day',
                'slug' => 'womens-day-2026',
                'emoji' => '👩',
                'subtitle_tags' => 'Women\'s Day Deals',
                'event_date' => '2026-03-08',
                'end_date' => '2026-03-08',
                'region' => 'global',
                'description' => 'International Women\'s Day on March 8th brings special promotions on beauty, wellness, and self-care products. Many brands run week-long sales celebrating women, with discounts on skincare, makeup, fitness gear, and fashion. This is a great opportunity to treat yourself or find thoughtful gifts for the women in your life.',
                'categories' => 'Beauty, Wellness, Fashion, Fitness',
                'checklist' => [
                    'Look for spa and wellness deals and gift cards',
                    'Check beauty subscription boxes for special offers',
                    'Many fitness apps offer annual subscription discounts',
                ],
                'event_table' => [
                    ['event' => 'Women\'s Day Sale', 'date' => 'Mar 8', 'categories' => 'Beauty, Wellness'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],

            // 5. Eid ul Fitr (PK)
            [
                'name' => 'Eid ul Fitr Sale',
                'slug' => 'eid-ul-fitr-2026',
                'emoji' => '🎉',
                'subtitle_tags' => 'Eid Shopping, Chand Raat Deals',
                'event_date' => '2026-03-30',
                'end_date' => '2026-04-02',
                'region' => 'pk',
                'description' => 'Eid ul Fitr is the biggest shopping event in Pakistan, marking the end of Ramadan. Expect massive discounts on fashion, electronics, food, and home decor. Chand Raat (the night before Eid) sees special late-night sales and flash deals. Pakistani brands release exclusive Eid collections, and this is the best time to buy traditional clothing, jewelry, and gifts. E-commerce platforms often offer free shipping and extended return periods.',
                'categories' => 'Fashion, Electronics, Food, Home, Gifts',
                'checklist' => [
                    'Shop for Eid clothes at least a week before for alterations',
                    'Look for Chand Raat midnight flash sales',
                    'Buy mehndi and beauty supplies early',
                    'Check for electronics bundles — TVs and phones get big discounts',
                    'Order gifts with express shipping to ensure delivery',
                ],
                'event_table' => [
                    ['event' => 'Pre-Eid Fashion Sale', 'date' => 'Mar 20-29', 'categories' => 'Fashion'],
                    ['event' => 'Chand Raat Sale', 'date' => 'Mar 29', 'categories' => 'All'],
                    ['event' => 'Eid Days', 'date' => 'Mar 30-Apr 2', 'categories' => 'All'],
                ],
                'density' => 'peak',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],

            // 6. Easter Sale (UK)
            [
                'name' => 'Easter Sale',
                'slug' => 'easter-sale-2026',
                'emoji' => '🐣',
                'subtitle_tags' => 'Easter Weekend, Spring Deals',
                'event_date' => '2026-04-03',
                'end_date' => '2026-04-06',
                'region' => 'uk',
                'description' => 'Easter weekend in the UK brings excellent deals on travel, chocolate, gifts, and spring fashion. The long weekend (Good Friday to Easter Monday) sees many retailers offering special promotions. This is a great time to book spring holidays, update your wardrobe with new season arrivals, and stock up on Easter treats. Many home and garden stores also run spring sales.',
                'categories' => 'Travel, Gifts, Food, Fashion',
                'checklist' => [
                    'Book travel early — Easter getaways sell out fast',
                    'Look for chocolate and confectionery multi-buy deals',
                    'Check for spring fashion previews and new arrivals discounts',
                    'Garden centres often have Easter weekend promotions',
                ],
                'event_table' => [
                    ['event' => 'Good Friday Deals', 'date' => 'Apr 3', 'categories' => 'All'],
                    ['event' => 'Easter Weekend Sale', 'date' => 'Apr 3-6', 'categories' => 'Travel, Gifts'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],

            // 7. Mother's Day (Global)
            [
                'name' => 'Mother\'s Day',
                'slug' => 'mothers-day-2026',
                'emoji' => '💐',
                'subtitle_tags' => 'Mother\'s Day Gifts',
                'event_date' => '2026-05-10',
                'end_date' => '2026-05-10',
                'region' => 'global',
                'description' => 'Mother\'s Day is celebrated in May in both the UK (different date) and globally. This shopping event focuses on gifts, flowers, beauty products, and experiences. Retailers offer special Mother\'s Day bundles and personalized gift options. Many spas and restaurants run special promotions, and flower delivery services offer early-bird discounts for advance orders.',
                'categories' => 'Gifts, Beauty, Flowers, Experiences',
                'checklist' => [
                    'Order flowers at least a week in advance',
                    'Look for personalized gift options — many have lead times',
                    'Check spa and afternoon tea deals for experiences',
                    'Beauty gift sets often come with bonus products',
                ],
                'event_table' => [
                    ['event' => 'Mother\'s Day', 'date' => 'May 10', 'categories' => 'Gifts, Beauty'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],

            // 8. Eid ul Adha (PK)
            [
                'name' => 'Eid ul Adha Sale',
                'slug' => 'eid-ul-adha-2026',
                'emoji' => '🐑',
                'subtitle_tags' => 'Bakra Eid, Qurbani Deals',
                'event_date' => '2026-06-06',
                'end_date' => '2026-06-09',
                'region' => 'pk',
                'description' => 'Eid ul Adha (Bakra Eid) is another major shopping event in Pakistan. While the focus is on the religious observance, retailers still offer significant discounts on fashion, food, and home items. This is a great time to buy meat and groceries, traditional clothing, and household essentials. Many families also purchase new appliances and furniture during this period.',
                'categories' => 'Fashion, Food, Home, Appliances',
                'checklist' => [
                    'Pre-book Qurbani animals early for best prices',
                    'Stock up on spices and grocery essentials',
                    'Look for freezer deals for meat storage',
                    'Fashion sales continue from Eid ul Fitr',
                ],
                'event_table' => [
                    ['event' => 'Pre-Eid Sale', 'date' => 'Jun 1-5', 'categories' => 'Fashion, Food'],
                    ['event' => 'Eid ul Adha Days', 'date' => 'Jun 6-9', 'categories' => 'All'],
                ],
                'density' => 'high',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],

            // 9. Father's Day (Global)
            [
                'name' => 'Father\'s Day',
                'slug' => 'fathers-day-2026',
                'emoji' => '👔',
                'subtitle_tags' => 'Father\'s Day Gifts',
                'event_date' => '2026-06-21',
                'end_date' => '2026-06-21',
                'region' => 'global',
                'description' => 'Father\'s Day in June is a key gifting event with promotions on gadgets, fashion, grooming products, and experiences. Retailers offer special Father\'s Day bundles and deals on electronics, tools, and outdoor gear. This is also a great time to find deals on watches, wallets, and other traditional Father\'s Day gifts.',
                'categories' => 'Gadgets, Fashion, Grooming, Tools',
                'checklist' => [
                    'Check electronics stores for special Father\'s Day bundles',
                    'Grooming subscription boxes often have gift deals',
                    'Experience gifts (driving, golf) offer advance booking discounts',
                    'Personalized gifts need ordering a week ahead',
                ],
                'event_table' => [
                    ['event' => 'Father\'s Day', 'date' => 'Jun 21', 'categories' => 'Gadgets, Fashion'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 9,
            ],

            // 10. Summer Sale (UK)
            [
                'name' => 'Summer Sale',
                'slug' => 'summer-sale-2026',
                'emoji' => '☀️',
                'subtitle_tags' => 'Summer Clearance, EOSS',
                'event_date' => '2026-06-25',
                'end_date' => '2026-07-31',
                'region' => 'uk',
                'description' => 'The UK Summer Sale (End of Season Sale) runs from late June through July, offering massive discounts on spring/summer fashion, outdoor furniture, and travel deals. This is one of the best times to update your wardrobe with discounts of up to 70% off. High street and online retailers compete with increasingly better deals as the sale progresses. Don\'t miss the mid-season clearance around late July.',
                'categories' => 'Fashion, Home, Garden, Travel',
                'checklist' => [
                    'Best selection is in the first week — prices drop later',
                    'Check online at midnight when sales launch',
                    'Garden furniture gets heavily discounted toward end of July',
                    'Look for travel deals for late summer and autumn holidays',
                    'Sign up for VIP early access to major retailers',
                ],
                'event_table' => [
                    ['event' => 'Summer Sale Launch', 'date' => 'Late Jun', 'categories' => 'Fashion'],
                    ['event' => 'Mid-Sale Reductions', 'date' => 'Mid Jul', 'categories' => 'All'],
                    ['event' => 'Final Clearance', 'date' => 'Late Jul', 'categories' => 'All'],
                ],
                'density' => 'high',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 10,
            ],

            // 11. Amazon Prime Day (Global)
            [
                'name' => 'Amazon Prime Day',
                'slug' => 'amazon-prime-day-2026',
                'emoji' => '📦',
                'subtitle_tags' => 'Prime Day, Lightning Deals',
                'event_date' => '2026-07-14',
                'end_date' => '2026-07-15',
                'region' => 'global',
                'description' => 'Amazon Prime Day is a 48-hour shopping event exclusively for Prime members, typically held in mid-July. It offers some of the best deals of the year on electronics, Amazon devices, home goods, and much more. Many competing retailers also run their own sales during this period. Lightning deals launch throughout the event, so check regularly for new offers.',
                'categories' => 'Electronics, Home, Amazon Devices, All',
                'checklist' => [
                    'Ensure your Prime membership is active before the event',
                    'Add items to your wishlist beforehand to track price drops',
                    'Set deal alerts for specific products you want',
                    'Lightning deals are time-limited — act fast',
                    'Compare prices with other retailers running competing sales',
                    'Amazon devices (Echo, Kindle, Fire TV) get the biggest discounts',
                ],
                'event_table' => [
                    ['event' => 'Prime Day Early Deals', 'date' => 'Jul 12-13', 'categories' => 'All'],
                    ['event' => 'Prime Day', 'date' => 'Jul 14-15', 'categories' => 'All'],
                ],
                'density' => 'high',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 11,
            ],

            // 12. Back to School (UK)
            [
                'name' => 'Back to School Sale',
                'slug' => 'back-to-school-2026',
                'emoji' => '📚',
                'subtitle_tags' => 'School Supplies, Student Deals',
                'event_date' => '2026-08-01',
                'end_date' => '2026-08-31',
                'region' => 'uk',
                'description' => 'August is back-to-school season in the UK, with great deals on laptops, stationery, school uniforms, and student essentials. Retailers offer student discount programs and bundle deals. This is also a prime time for university students to get deals on tech, furniture, and home essentials for student accommodation.',
                'categories' => 'Electronics, Stationery, Fashion, Home',
                'checklist' => [
                    'Register for student discount cards (UNiDAYS, Student Beans)',
                    'Buy school uniforms in early August for best selection',
                    'Compare laptop deals across retailers — bundles vary',
                    'Stock up on stationery multi-buy offers',
                    'Check university essentials lists for dorm room deals',
                ],
                'event_table' => [
                    ['event' => 'School Uniform Sales', 'date' => 'Aug 1-15', 'categories' => 'Fashion'],
                    ['event' => 'Student Tech Deals', 'date' => 'All month', 'categories' => 'Electronics'],
                    ['event' => 'University Move-In Sales', 'date' => 'Late Aug', 'categories' => 'Home'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 12,
            ],

            // 13. Independence Day (PK)
            [
                'name' => 'Pakistan Independence Day',
                'slug' => 'pakistan-independence-day-2026',
                'emoji' => '🇵🇰',
                'subtitle_tags' => '14th August, Jashn-e-Azadi',
                'event_date' => '2026-08-14',
                'end_date' => '2026-08-14',
                'region' => 'pk',
                'description' => 'Pakistan Independence Day on August 14th is celebrated with special sales and promotions across all categories. Retailers offer patriotic deals with discounts on clothing (especially green and white themed items), electronics, and food. Many e-commerce platforms run Jashn-e-Azadi sales with significant discounts and flash deals.',
                'categories' => 'Fashion, Electronics, Food, All',
                'checklist' => [
                    'Look for patriotic-themed clothing and accessories',
                    'E-commerce platforms run 14% off promotions',
                    'Flash sales often start at midnight on August 14th',
                    'Check for bundle deals on electronics and appliances',
                ],
                'event_table' => [
                    ['event' => 'Jashn-e-Azadi Sale', 'date' => 'Aug 14', 'categories' => 'All'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 13,
            ],

            // 14. Halloween (UK)
            [
                'name' => 'Halloween',
                'slug' => 'halloween-2026',
                'emoji' => '🎃',
                'subtitle_tags' => 'Halloween Costumes, Spooky Deals',
                'event_date' => '2026-10-31',
                'end_date' => '2026-10-31',
                'region' => 'uk',
                'description' => 'Halloween has become a significant shopping event in the UK, with great deals on costumes, decorations, candy, and party supplies. Many retailers start their Halloween promotions from early October. This is also when autumn/winter fashion previews begin, and you can find early Black Friday teasers from some retailers.',
                'categories' => 'Costumes, Decorations, Food, Fashion',
                'checklist' => [
                    'Buy costumes in early October for best selection',
                    'Decorations go on clearance on November 1st',
                    'Look for multi-buy deals on Halloween candy',
                    'Check for early Black Friday preview deals',
                ],
                'event_table' => [
                    ['event' => 'Halloween Week', 'date' => 'Oct 25-31', 'categories' => 'Costumes, Decor'],
                    ['event' => 'Halloween Day', 'date' => 'Oct 31', 'categories' => 'All'],
                ],
                'density' => 'medium',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 14,
            ],

            // 15. Black Friday (Global)
            [
                'name' => 'Black Friday',
                'slug' => 'black-friday-2026',
                'emoji' => '🛍️',
                'subtitle_tags' => 'Black Friday, Mega Sales',
                'event_date' => '2026-11-27',
                'end_date' => '2026-11-29',
                'region' => 'global',
                'description' => 'Black Friday is the biggest shopping event of the year for both UK and Pakistan shoppers. Originating from the US, it now features massive discounts across virtually every category — electronics, fashion, home, beauty, and more. Many UK retailers start their Black Friday deals from early November, with the best deals on the Friday itself. In Pakistan, e-commerce platforms run Black Friday and 11.11 sales with similar discounts. Expect deals of 50-70% off on major purchases.',
                'categories' => 'Electronics, Fashion, Home, Beauty, All',
                'checklist' => [
                    'Research prices beforehand to identify genuine discounts',
                    'Create accounts and save payment details for faster checkout',
                    'Sign up for early access and email alerts from favorite stores',
                    'Check both UK and Pakistan sites for global deals',
                    'Lightning deals sell out fast — set reminders',
                    'Compare prices across retailers before purchasing',
                    'Don\'t forget cashback sites and browser extensions',
                ],
                'event_table' => [
                    ['event' => 'Early Black Friday', 'date' => 'Nov 20-26', 'categories' => 'All'],
                    ['event' => 'Black Friday', 'date' => 'Nov 27', 'categories' => 'All'],
                    ['event' => 'Black Friday Weekend', 'date' => 'Nov 28-29', 'categories' => 'All'],
                ],
                'density' => 'peak',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 15,
            ],

            // 16. Cyber Monday (Global)
            [
                'name' => 'Cyber Monday',
                'slug' => 'cyber-monday-2026',
                'emoji' => '💻',
                'subtitle_tags' => 'Cyber Monday, Online Deals',
                'event_date' => '2026-11-30',
                'end_date' => '2026-11-30',
                'region' => 'global',
                'description' => 'Cyber Monday follows Black Friday and focuses on online-exclusive deals, particularly on electronics, software, and tech products. Many retailers extend their Black Friday sales through Cyber Monday, while others save special deals for this day. This is the best time to buy software subscriptions, gaming products, and electronics that may have sold out during Black Friday.',
                'categories' => 'Electronics, Software, Gaming, Tech',
                'checklist' => [
                    'Best for software, streaming, and subscription deals',
                    'Gaming consoles and games often get Cyber Monday exclusives',
                    'Check for extended Black Friday deals that continue',
                    'Web hosting and domain deals are excellent on Cyber Monday',
                    'Last chance for November mega-sale prices',
                ],
                'event_table' => [
                    ['event' => 'Cyber Monday', 'date' => 'Nov 30', 'categories' => 'Electronics, Software'],
                ],
                'density' => 'peak',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 16,
            ],

            // 17. Christmas Sale (UK)
            [
                'name' => 'Christmas Sale',
                'slug' => 'christmas-sale-2026',
                'emoji' => '🎄',
                'subtitle_tags' => 'Christmas Shopping, Holiday Deals',
                'event_date' => '2026-12-01',
                'end_date' => '2026-12-25',
                'region' => 'uk',
                'description' => 'December is the festive shopping season in the UK, with retailers offering Christmas promotions on gifts, decorations, food, and more. While prices aren\'t always at their lowest (Boxing Day offers better discounts), there are excellent deals on gift sets, hampers, and seasonal items. Many retailers offer free gift wrapping and extended returns for Christmas purchases.',
                'categories' => 'Gifts, Food, Decorations, Fashion, All',
                'checklist' => [
                    'Order gifts early to avoid delivery cutoff dates',
                    'Check last posting dates for Christmas delivery',
                    'Gift sets often offer better value than individual items',
                    'Food hampers and advent calendars sell out early',
                    'Look for free gift wrapping offers',
                    'Save receipts — most stores extend returns until January',
                ],
                'event_table' => [
                    ['event' => 'December Gift Sales', 'date' => 'Dec 1-15', 'categories' => 'Gifts'],
                    ['event' => 'Last Minute Deals', 'date' => 'Dec 20-24', 'categories' => 'All'],
                    ['event' => 'Christmas Day', 'date' => 'Dec 25', 'categories' => 'Online only'],
                ],
                'density' => 'peak',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 17,
            ],

            // 18. Boxing Day (UK)
            [
                'name' => 'Boxing Day Sale',
                'slug' => 'boxing-day-2026',
                'emoji' => '🎁',
                'subtitle_tags' => 'Boxing Day, Post-Christmas Sales',
                'event_date' => '2026-12-26',
                'end_date' => '2026-12-31',
                'region' => 'uk',
                'description' => 'Boxing Day is one of the UK\'s biggest shopping events, with retailers offering massive post-Christmas discounts. Many sales start online at midnight on December 26th, with physical stores opening early. Expect discounts of 50-70% off across fashion, electronics, home, and more. This is the perfect time to buy big-ticket items, winter fashion, and home furnishings at heavily reduced prices.',
                'categories' => 'Fashion, Electronics, Home, All',
                'checklist' => [
                    'Many online sales start at midnight on December 26th',
                    'Physical stores often open early — check times',
                    'Best deals go fast — have a wishlist ready',
                    'Winter clothing gets the deepest discounts',
                    'Electronics and TVs often have Boxing Day exclusives',
                    'Sales continue into January — prices may drop further',
                    'Check click-and-collect for faster pickup',
                ],
                'event_table' => [
                    ['event' => 'Boxing Day Online', 'date' => 'Dec 26 midnight', 'categories' => 'All'],
                    ['event' => 'Boxing Day In-Store', 'date' => 'Dec 26', 'categories' => 'All'],
                    ['event' => 'Post-Boxing Day Sales', 'date' => 'Dec 27-31', 'categories' => 'All'],
                ],
                'density' => 'peak',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 18,
            ],
        ];

        foreach ($events as $event) {
            SaleEvent::updateOrCreate(
                ['slug' => $event['slug']],
                $event
            );
        }

        $this->command->info('Seeded ' . count($events) . ' sale events successfully!');
    }
}
