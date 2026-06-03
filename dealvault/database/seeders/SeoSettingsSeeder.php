<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use Illuminate\Database\Seeder;

class SeoSettingsSeeder extends Seeder
{
    /**
     * Seed the default SEO settings.
     */
    public function run(): void
    {
        $settings = [
            // Site Identity
            [
                'key' => 'site_name',
                'value' => 'Valtwise',
            ],
            [
                'key' => 'default_og_image',
                'value' => '/images/og-default.jpg',
            ],
            [
                'key' => 'twitter_handle',
                'value' => '@valtwise',
            ],

            // Analytics & Verification
            [
                'key' => 'google_analytics_id',
                'value' => '', // e.g., G-XXXXXXXXXX
            ],
            [
                'key' => 'google_search_console_verification',
                'value' => '', // e.g., abc123xyz
            ],

            // Default Behavior
            [
                'key' => 'default_robots',
                'value' => 'index, follow',
            ],
            [
                'key' => 'global_breadcrumbs_enabled',
                'value' => '1',
            ],
        ];

        foreach ($settings as $setting) {
            SeoSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }

        $this->command->info('SEO settings seeded successfully!');
    }
}
