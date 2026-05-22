# Valtwise — Laravel Coupon Aggregator

A full coupon aggregator site built with Laravel 11 + Blade.

## File Structure

```
app/
├── Http/Controllers/
│   ├── HomeController.php       ← homepage
│   ├── StoreController.php      ← store list + brand page
│   ├── CategoryController.php   ← category pages
│   └── TrackingController.php   ← affiliate click redirect (/go/:id)
├── Models/
│   ├── Store.php
│   ├── Category.php
│   ├── Coupon.php
│   └── Click.php

database/
├── migrations/                  ← 5 migration files
└── seeders/DatabaseSeeder.php   ← sample stores, categories, coupons

resources/views/
├── layouts/app.blade.php        ← main layout (navbar, footer, CSS)
├── home.blade.php               ← homepage
├── stores/
│   ├── index.blade.php          ← /stores (browse all)
│   └── show.blade.php           ← /store/:slug (brand page)
├── categories/
│   └── show.blade.php           ← /category/:slug
└── partials/
    └── coupon-card.blade.php    ← reusable coupon card

routes/web.php                   ← all routes
```

## Setup Steps

### 1. Create Laravel project
```bash
composer create-project laravel/laravel Valtwise
cd Valtwise
```

### 2. Copy files
Copy all files from this package into your Laravel project, matching the paths above.

### 3. Configure .env
```env
APP_NAME=Valtwise
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_DATABASE=Valtwise
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run migrations + seed
```bash
php artisan migrate
php artisan db:seed
```

### 5. Start server
```bash
php artisan serve
```

Visit http://localhost:8000

---

## Key Routes

| URL                     | Description                        |
|-------------------------|------------------------------------|
| `/`                     | Homepage — featured stores + deals |
| `/stores`               | Browse all stores                  |
| `/store/{slug}`         | Brand page with all coupons        |
| `/category/{slug}`      | Category page                      |
| `/go/{couponId}`        | Affiliate redirect + click log     |

---

## How Affiliate Tracking Works

1. User clicks "Get Deal" or "Reveal Code" on your site
2. They hit `/go/{couponId}` — your TrackingController
3. A `Click` record is saved (coupon_id, store_id, ip, user_agent)
4. `click_count` on the coupon is incremented
5. User is `302 redirect`ed to your **affiliate URL** (from `stores.affiliate_url_template`)
6. The affiliate network sets a tracking cookie on the user's browser
7. If the user buys, the network pays you commission

### Setting up your affiliate URL template

In `stores.affiliate_url_template`, store the network tracking URL with `{destination}` placeholder:

```
https://track.commissionfactory.com/click?AffiliateID=12345&MerchantID=9876&destinationURL={destination}
```

The `Store::buildAffiliateUrl()` method replaces `{destination}` automatically.

---

## Adding Coupons (Manual)

Use Tinker or build an admin panel:

```bash
php artisan tinker
```

```php
$store = \App\Models\Store::where('slug', 'nike')->first();

$store->coupons()->create([
    'title'           => '30% Off Everything',
    'code'            => 'SAVE30',
    'type'            => 'code',
    'discount_value'  => '30%',
    'is_verified'     => true,
    'is_active'       => true,
    'expires_at'      => now()->addDays(30),
    'destination_url' => 'https://www.nike.com',
]);
```

---

## Next Steps

- **Admin panel** — use `laravel-admin` or build a simple resource controller
- **Affiliate feed automation** — BullMQ/Horizon jobs pulling from CJ/CF APIs
- **Sitemap** — `spatie/laravel-sitemap` package
- **Caching** — `Cache::remember()` on store/home queries (TTL 1 hour)
- **Expiry cron** — `php artisan schedule:run` with a command that marks expired coupons


# 
``` bash
php artisan optimize:clear && php artisan config:clear && php artisan cache:clear && php artisan migrate && php artisan db:seed && php artisan serve --host=0.0.0.0 --port=$PORT
```


## Steps For sitemap
--  Step 1 — Laravel mein sitemap banao: composer require spatie/laravel-sitemap
-- Step 2 — routes/web.php mein add karo:
Route::get('/sitemap.xml', function() {
    $sitemap = Spatie\Sitemap\Sitemap::create()
        ->add(Spatie\Sitemap\Tags\Url::create('/'))
        ->add(Spatie\Sitemap\Tags\Url::create('/stores'));

    // Stores add karo
    App\Models\Store::active()->get()->each(function($store) use ($sitemap) {
        $sitemap->add('/store/' . $store->slug);
    });

    // Categories add karo
    App\Models\Category::all()->each(function($cat) use ($sitemap) {
        $sitemap->add('/category/' . $cat->slug);
    });

    return response($sitemap->render(), 200)
        ->header('Content-Type', 'text/xml');
});

Step 3 — Google Search Console mein submit karo:
search.google.com/search-console

Property add karo:
https://valtwise-production.up.railway.app

Sitemap section mein:
https://valtwise-production.up.railway.app/sitemap.xml
submit karo


