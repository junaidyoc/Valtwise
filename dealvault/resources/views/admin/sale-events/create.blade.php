@extends('admin.layouts.app')
@section('title', 'Add Sale Event')
@section('page-title', 'Add Sale Event')

@section('content')
<div style="max-width:800px">
    <a href="{{ route('admin.sale-events.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

    <div class="card">
        <form method="POST" action="{{ route('admin.sale-events.store') }}">
            @csrf
            <div class="form-grid">

                <div class="form-group">
                    <label>Event Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Black Friday">
                </div>

                <div class="form-group">
                    <label>Emoji</label>
                    <input type="text" name="emoji" value="{{ old('emoji') }}" maxlength="10"
                           placeholder="e.g. 🛒">
                </div>

                <div class="form-group">
                    <label>Start Date *</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" required>
                </div>

                <div class="form-group">
                    <label>End Date <span style="color:#64748b;font-weight:400">(optional)</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}">
                </div>

                <div class="form-group">
                    <label>Region *</label>
                    <select name="region" required>
                        <option value="global" {{ old('region') === 'global' ? 'selected' : '' }}>🌍 Global</option>
                        <option value="uk" {{ old('region') === 'uk' ? 'selected' : '' }}>🇬🇧 UK Only</option>
                        <option value="pk" {{ old('region') === 'pk' ? 'selected' : '' }}>🇵🇰 Pakistan Only</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deal Density *</label>
                    <select name="density" required>
                        <option value="low" {{ old('density') === 'low' ? 'selected' : '' }}>Low - Few deals</option>
                        <option value="medium" {{ old('density', 'medium') === 'medium' ? 'selected' : '' }}>Medium - Moderate deals</option>
                        <option value="high" {{ old('density') === 'high' ? 'selected' : '' }}>High - Many deals</option>
                        <option value="peak" {{ old('density') === 'peak' ? 'selected' : '' }}>Peak - Best deals of year</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Subtitle Tags <span style="color:#64748b;font-weight:400">(comma separated)</span></label>
                    <input type="text" name="subtitle_tags" value="{{ old('subtitle_tags') }}"
                           placeholder="e.g. Biggest Sale, Up to 80% Off">
                </div>

                <div class="form-group full">
                    <label>Categories <span style="color:#64748b;font-weight:400">(comma separated)</span></label>
                    <input type="text" name="categories" value="{{ old('categories') }}"
                           placeholder="e.g. Electronics, Fashion, Home">
                </div>

                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description" rows="3"
                              placeholder="Brief description of the sale event...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Shopping Checklist <span style="color:#64748b;font-weight:400">(one per line)</span></label>
                    <textarea name="checklist" rows="4"
                              placeholder="Create wishlists early&#10;Compare prices&#10;Check return policies">{{ old('checklist') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="form-group" style="display:flex;flex-direction:column;gap:10px;justify-content:flex-end">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        Featured Event
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="is_active" value="1" checked>
                        Active
                    </label>
                </div>

                {{-- Collapsible SEO Settings --}}
                <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
                    <button type="button" onclick="toggleSeoSection()" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;padding:0;text-align:left">
                        <span id="seoToggleIcon" style="transition:transform .2s;color:#10b981">&#9654;</span>
                        <span style="font-size:14px;font-weight:600;color:#10b981">SEO Settings</span>
                        <span style="font-size:11px;color:#64748b;margin-left:auto">Click to expand</span>
                    </button>
                </div>

                <div id="seoSection" style="display:none" class="form-grid full">
                    {{-- Basic Meta --}}
                    <div class="form-group full" style="margin-top:12px">
                        <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Basic SEO</div>
                    </div>

                    <div class="form-group full">
                        <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" maxlength="70" id="metaTitle"
                               placeholder="Leave empty for auto-generated title">
                        <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-top:4px">
                            <span>Title will be auto-generated from event name</span>
                            <span id="metaTitleCount">0/70</span>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
                        <textarea name="meta_description" rows="2" maxlength="160" id="metaDesc"
                                  placeholder="Leave empty for auto-generated description">{{ old('meta_description') }}</textarea>
                        <div style="text-align:right;font-size:11px;color:#64748b;margin-top:4px">
                            <span id="metaDescCount">0/160</span>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label>Focus Keyword</label>
                        <input type="text" name="focus_keyword" value="{{ old('focus_keyword') }}" maxlength="50"
                               placeholder="e.g. black friday deals uk">
                    </div>

                    {{-- Open Graph --}}
                    <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
                        <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Open Graph (Facebook/LinkedIn)</div>
                    </div>

                    <div class="form-group full">
                        <label>OG Title <span style="color:#64748b;font-weight:400">(leave empty for meta title)</span></label>
                        <input type="text" name="og_title" value="{{ old('og_title') }}" maxlength="90">
                    </div>

                    <div class="form-group full">
                        <label>OG Description</label>
                        <textarea name="og_description" rows="2" maxlength="200">{{ old('og_description') }}</textarea>
                    </div>

                    <div class="form-group full">
                        <label>OG Image URL</label>
                        <input type="url" name="og_image" value="{{ old('og_image') }}" placeholder="Leave empty for default">
                    </div>

                    {{-- Technical SEO --}}
                    <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
                        <div style="font-size:12px;font-weight:600;color:#a78bfa;margin-bottom:8px">Technical SEO</div>
                    </div>

                    <div class="form-group full">
                        <label>Canonical URL <span style="color:#64748b;font-weight:400">(leave empty for auto)</span></label>
                        <input type="url" name="canonical_url" value="{{ old('canonical_url') }}">
                    </div>

                    <div class="form-group">
                        <label>Robots Index</label>
                        <select name="robots_index">
                            <option value="index" selected>Index</option>
                            <option value="noindex">NoIndex</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Robots Follow</label>
                        <select name="robots_follow">
                            <option value="follow" selected>Follow</option>
                            <option value="nofollow">NoFollow</option>
                        </select>
                    </div>

                    <div class="form-group full" style="margin-top:12px">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                            <input type="checkbox" name="sitemap_include" value="1" checked>
                            Include in Sitemap
                        </label>
                    </div>
                </div>

            </div>

            <div style="display:flex;gap:10px;margin-top:16px">
                <button type="submit" class="btn btn-green">Add Event</button>
                <a href="{{ route('admin.sale-events.index') }}" class="btn btn-gray">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleSeoSection() {
    const section = document.getElementById('seoSection');
    const icon = document.getElementById('seoToggleIcon');
    if (section.style.display === 'none') {
        section.style.display = 'grid';
        icon.style.transform = 'rotate(90deg)';
    } else {
        section.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}

document.getElementById('metaTitle')?.addEventListener('input', function() {
    document.getElementById('metaTitleCount').textContent = this.value.length + '/70';
});
document.getElementById('metaDesc')?.addEventListener('input', function() {
    document.getElementById('metaDescCount').textContent = this.value.length + '/160';
});
</script>
@endpush
@endsection
