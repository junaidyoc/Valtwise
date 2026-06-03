<?php

namespace App\Http\Controllers;

use App\Models\SaleEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaleCalendarController extends Controller
{
    /**
     * Show individual event page with full SEO
     */
    public function show(string $slug)
    {
        $event = SaleEvent::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $year = $event->event_date->format('Y');

        // Get related events (same region or global, same month)
        $relatedEvents = SaleEvent::active()
            ->where('id', '!=', $event->id)
            ->where(function ($q) use ($event) {
                $q->where('region', $event->region)
                  ->orWhere('region', 'global');
            })
            ->byYear($year)
            ->orderByDate()
            ->limit(4)
            ->get();

        // Get stores with active coupons for this category
        $suggestedStores = [];
        if ($event->categories) {
            $categories = $event->categories_array;
            $suggestedStores = \App\Models\Store::where('is_active', true)
                ->whereHas('coupons', function ($q) {
                    $q->where('is_active', true)
                      ->where(function ($sq) {
                          $sq->whereNull('expires_at')
                             ->orWhere('expires_at', '>', now());
                      });
                })
                ->limit(6)
                ->get();
        }

        // Get next/previous events
        $nextEvent = SaleEvent::active()
            ->where('event_date', '>', $event->event_date)
            ->orderBy('event_date', 'asc')
            ->first();

        $prevEvent = SaleEvent::active()
            ->where('event_date', '<', $event->event_date)
            ->orderBy('event_date', 'desc')
            ->first();

        return view('pages.sale-event', compact(
            'event',
            'relatedEvents',
            'suggestedStores',
            'nextEvent',
            'prevEvent',
            'year'
        ));
    }

    public function index()
    {
        $year = Carbon::now()->year;

        // Get all active events for the year, ordered by date
        $allEvents = SaleEvent::active()
            ->byYear($year)
            ->orderByDate()
            ->get();

        // Group events by month
        $eventsByMonth = $allEvents->groupBy(function ($event) {
            return $event->event_date->format('F');
        });

        // Get currently active events (running now)
        $activeEvents = SaleEvent::currentlyActive()->get();

        // Get next 3 upcoming events
        $upcomingEvents = SaleEvent::upcoming()->limit(3)->get();

        // Get featured events
        $featuredEvents = SaleEvent::active()
            ->byYear($year)
            ->featured()
            ->orderByDate()
            ->get();

        // Calculate density per month
        $monthDensity = $this->calculateMonthDensity($allEvents);

        // Stats
        $stats = [
            'total_events' => $allEvents->count(),
            'months' => $eventsByMonth->count(),
            'countries' => 2,
            'categories' => $this->getUniqueCategories($allEvents),
        ];

        // Best time to buy data
        $bestTimeToBuy = $this->getBestTimeToBuyData();

        // FAQ data
        $faqs = $this->getFaqData($year);

        return view('pages.sale-calendar', compact(
            'allEvents',
            'eventsByMonth',
            'activeEvents',
            'upcomingEvents',
            'featuredEvents',
            'monthDensity',
            'stats',
            'bestTimeToBuy',
            'faqs',
            'year'
        ));
    }

    /**
     * Calculate sale density for each month
     */
    private function calculateMonthDensity($events): array
    {
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        $density = [];

        foreach ($months as $month) {
            $monthEvents = $events->filter(function ($event) use ($month) {
                return $event->event_date->format('F') === $month;
            });

            // Determine density based on events and their density levels
            if ($monthEvents->isEmpty()) {
                $density[$month] = ['level' => 'low', 'percent' => 20, 'label' => 'Low'];
            } else {
                // Find the highest density level among events this month
                $maxDensity = $monthEvents->max(function ($event) {
                    return match($event->density) {
                        'peak' => 4,
                        'high' => 3,
                        'medium' => 2,
                        'low' => 1,
                        default => 2,
                    };
                });

                $density[$month] = match($maxDensity) {
                    4 => ['level' => 'peak', 'percent' => 100, 'label' => 'Peak'],
                    3 => ['level' => 'high', 'percent' => 75, 'label' => 'High'],
                    2 => ['level' => 'medium', 'percent' => 50, 'label' => 'Medium'],
                    default => ['level' => 'low', 'percent' => 25, 'label' => 'Low'],
                };
            }

            // Add event count
            $density[$month]['events'] = $monthEvents->count();
        }

        return $density;
    }

    /**
     * Get unique categories count
     */
    private function getUniqueCategories($events): int
    {
        $allCategories = [];

        foreach ($events as $event) {
            if (!empty($event->categories)) {
                $cats = array_map('trim', explode(',', $event->categories));
                $allCategories = array_merge($allCategories, $cats);
            }
        }

        return count(array_unique($allCategories));
    }

    /**
     * Best time to buy data
     */
    private function getBestTimeToBuyData(): array
    {
        return [
            [
                'category' => 'Fashion',
                'best_month' => 'July/August',
                'why' => 'Summer Sale + End of Season Sale discounts up to 70% off',
            ],
            [
                'category' => 'Electronics',
                'best_month' => 'November/July',
                'why' => 'Black Friday mega deals + Amazon Prime Day offers',
            ],
            [
                'category' => 'Travel',
                'best_month' => 'January/June',
                'why' => 'January Sales for flights + Summer holiday early bird deals',
            ],
            [
                'category' => 'Beauty',
                'best_month' => 'November/February',
                'why' => 'Black Friday beauty hauls + Valentine\'s Day gift sets',
            ],
            [
                'category' => 'Home & Garden',
                'best_month' => 'January/December',
                'why' => 'January Sales clearance + Boxing Day home deals',
            ],
            [
                'category' => 'Software',
                'best_month' => 'November',
                'why' => 'Cyber Monday exclusive software and subscription deals',
            ],
            [
                'category' => 'Food & Groceries',
                'best_month' => 'March/June',
                'why' => 'Ramadan bulk deals + Eid special offers in Pakistan',
            ],
            [
                'category' => 'Gifts',
                'best_month' => 'February/May/December',
                'why' => 'Valentine\'s, Mother\'s Day + Christmas gift promotions',
            ],
        ];
    }

    /**
     * FAQ data
     */
    private function getFaqData(int $year): array
    {
        return [
            [
                'question' => "When is Black Friday {$year}?",
                'answer' => "Black Friday {$year} falls on November 27th. However, many UK retailers start their Black Friday deals from early November, with some beginning as early as November 1st. The best deals are typically available from November 20th onwards.",
            ],
            [
                'question' => "When is Boxing Day sale {$year}?",
                'answer' => "Boxing Day {$year} is on December 26th. Most UK retailers launch their Boxing Day sales at midnight online, with physical stores opening early morning. Many sales continue into January as part of the wider January Sales.",
            ],
            [
                'question' => "When is Eid ul Fitr {$year}?",
                'answer' => "Eid ul Fitr {$year} is expected around March 30-31 (subject to moon sighting confirmation). Pakistani retailers typically start Eid sales 2-3 weeks before, with the biggest discounts on fashion, electronics, and home items.",
            ],
            [
                'question' => "When is Eid ul Adha {$year}?",
                'answer' => "Eid ul Adha {$year} is expected around June 6-7 (subject to moon sighting). This is another major shopping event in Pakistan with sales across all categories, particularly fashion and food items.",
            ],
            [
                'question' => "When is Amazon Prime Day {$year}?",
                'answer' => "Amazon Prime Day {$year} is typically held in mid-July (exact dates announced by Amazon 2-3 weeks prior). It's a 48-hour event exclusive to Prime members with major discounts on electronics, home goods, and Amazon devices.",
            ],
            [
                'question' => "What is the biggest sale event in the UK?",
                'answer' => "Black Friday (late November) and Boxing Day (December 26th) are the two biggest sale events in the UK. Black Friday has become the largest single shopping day, while Boxing Day/January Sales offer the longest discount period.",
            ],
            [
                'question' => "What is the biggest sale event in Pakistan?",
                'answer' => "Eid ul Fitr and Eid ul Adha are the biggest shopping events in Pakistan. Additionally, Independence Day (August 14th) and 11.11 (Singles Day) have grown significantly in recent years with major e-commerce platforms.",
            ],
            [
                'question' => "How can I get notified about upcoming sales?",
                'answer' => "Bookmark this Sale Calendar page and check back regularly. You can also follow your favorite stores on Valtwise to see their latest coupons and deals as soon as they go live.",
            ],
        ];
    }
}
