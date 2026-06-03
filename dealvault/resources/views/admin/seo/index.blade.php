@extends('admin.layouts.app')
@section('title', 'SEO Settings')
@section('page-title', 'Global SEO Settings')

@section('content')
<div style="max-width:700px">
    <div class="card">
        <form method="POST" action="{{ route('admin.seo.update') }}">
            @csrf
            <div class="form-grid">

                {{-- Site Identity --}}
                <div class="form-group full" style="margin-bottom:8px">
                    <div style="font-size:14px;font-weight:600;color:#10b981;margin-bottom:4px">Site Identity</div>
                </div>

                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] }}" placeholder="Valtwise">
                    <div style="font-size:11px;color:#64748b;margin-top:4px">Used in OG site_name tag</div>
                </div>

                <div class="form-group">
                    <label>Twitter Handle</label>
                    <input type="text" name="twitter_handle" value="{{ $settings['twitter_handle'] }}" placeholder="@valtwise">
                    <div style="font-size:11px;color:#64748b;margin-top:4px">Used in twitter:site tag</div>
                </div>

                <div class="form-group full">
                    <label>Default OG Image URL</label>
                    <input type="url" name="default_og_image" value="{{ $settings['default_og_image'] }}" placeholder="https://example.com/og-image.jpg">
                    <div style="font-size:11px;color:#64748b;margin-top:4px">Fallback image for social sharing</div>
                </div>

                {{-- Analytics & Verification --}}
                <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
                    <div style="font-size:14px;font-weight:600;color:#10b981;margin-bottom:4px">Analytics & Verification</div>
                </div>

                <div class="form-group">
                    <label>Google Analytics ID</label>
                    <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] }}" placeholder="G-XXXXXXXXXX">
                    <div style="font-size:11px;color:#64748b;margin-top:4px">GA4 Measurement ID</div>
                </div>

                <div class="form-group">
                    <label>Google Search Console</label>
                    <input type="text" name="google_search_console_verification" value="{{ $settings['google_search_console_verification'] }}" placeholder="Verification code">
                    <div style="font-size:11px;color:#64748b;margin-top:4px">Meta verification content</div>
                </div>

                {{-- Default Behavior --}}
                <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
                    <div style="font-size:14px;font-weight:600;color:#10b981;margin-bottom:4px">Default Behavior</div>
                </div>

                <div class="form-group">
                    <label>Default Robots</label>
                    <select name="default_robots">
                        <option value="index, follow" {{ $settings['default_robots'] == 'index, follow' ? 'selected' : '' }}>Index, Follow</option>
                        <option value="noindex, follow" {{ $settings['default_robots'] == 'noindex, follow' ? 'selected' : '' }}>NoIndex, Follow</option>
                        <option value="index, nofollow" {{ $settings['default_robots'] == 'index, nofollow' ? 'selected' : '' }}>Index, NoFollow</option>
                        <option value="noindex, nofollow" {{ $settings['default_robots'] == 'noindex, nofollow' ? 'selected' : '' }}>NoIndex, NoFollow</option>
                    </select>
                    <div style="font-size:11px;color:#64748b;margin-top:4px">Fallback for pages without custom robots</div>
                </div>

                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:24px">
                        <input type="checkbox" name="global_breadcrumbs_enabled" value="1" {{ $settings['global_breadcrumbs_enabled'] == '1' ? 'checked' : '' }}>
                        <span>Enable Breadcrumbs Globally</span>
                    </label>
                    <div style="font-size:11px;color:#64748b;margin-top:4px">Show breadcrumb navigation sitewide</div>
                </div>

            </div>

            <button type="submit" class="btn btn-green" style="margin-top:16px">Save Settings</button>
        </form>
    </div>

    {{-- Tips Card --}}
    <div class="card" style="margin-top:12px;background:#0f172a">
        <div class="card-title">SEO Tips</div>
        <div style="font-size:13px;color:#64748b;line-height:1.8">
            <strong style="color:#94a3b8">Per-Page SEO:</strong> You can override these defaults for individual stores, categories, and coupons by editing them.<br><br>
            <strong style="color:#94a3b8">OG Image:</strong> Recommended size is 1200x630 pixels for best display on social media.<br><br>
            <strong style="color:#94a3b8">GA4 ID:</strong> Find it in Google Analytics > Admin > Data Streams > Web stream details.
        </div>
    </div>
</div>
@endsection
