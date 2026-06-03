<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoSettingsController extends Controller
{
    /**
     * Display SEO settings form
     */
    public function index()
    {
        $settings = [
            'site_name' => SeoSetting::get('site_name', 'Valtwise'),
            'default_og_image' => SeoSetting::get('default_og_image'),
            'twitter_handle' => SeoSetting::get('twitter_handle'),
            'google_analytics_id' => SeoSetting::get('google_analytics_id'),
            'google_search_console_verification' => SeoSetting::get('google_search_console_verification'),
            'default_robots' => SeoSetting::get('default_robots', 'index, follow'),
            'global_breadcrumbs_enabled' => SeoSetting::get('global_breadcrumbs_enabled', '1'),
        ];

        return view('admin.seo.index', compact('settings'));
    }

    /**
     * Update SEO settings
     */
    public function update(Request $request)
    {
        $fields = [
            'site_name',
            'default_og_image',
            'twitter_handle',
            'google_analytics_id',
            'google_search_console_verification',
            'default_robots',
            'global_breadcrumbs_enabled',
        ];

        foreach ($fields as $field) {
            $value = $request->input($field);
            // Handle checkbox for global_breadcrumbs_enabled
            if ($field === 'global_breadcrumbs_enabled') {
                $value = $request->has($field) ? '1' : '0';
            }
            SeoSetting::set($field, $value);
        }

        SeoSetting::clearCache();

        return back()->with('success', 'SEO settings updated successfully!');
    }
}
