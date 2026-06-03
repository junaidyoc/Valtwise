@extends('admin.layouts.app')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div style="max-width:700px">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">Back</a>

    <div class="card">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')
            <div class="form-grid">

                <div class="form-group">
                    <label>Category Name *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Icon (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="e.g. 🛒">
                </div>

                <div class="form-group">
                    <label>Parent Category</label>
                    <select name="parent_id">
                        <option value="">None (Top Level)</option>
                        @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->icon }} {{ $parent->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Category description...">{{ old('description', $category->description) }}</textarea>
                </div>

                {{-- Collapsible SEO Settings --}}
                <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
                    <button type="button" onclick="toggleSeoSection()" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;padding:0;text-align:left">
                        <span id="seoToggleIcon" style="transition:transform .2s;color:#10b981">&#9654;</span>
                        <span style="font-size:14px;font-weight:600;color:#10b981">SEO Settings</span>
                        <span style="font-size:11px;color:#64748b;margin-left:auto">Click to expand</span>
                    </button>
                </div>

                <div id="seoSection" style="display:none">
                    {{-- Basic Meta --}}
                    <div class="form-group full" style="margin-top:12px">
                        <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Basic SEO</div>
                    </div>

                    <div class="form-group full">
                        <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" maxlength="70" id="metaTitle"
                               placeholder="Leave empty for auto-generated title">
                        <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-top:4px">
                            <span>Auto: {{ $category->name }} Coupons & Deals {{ date('F Y') }} — Valtwise</span>
                            <span id="metaTitleCount">{{ strlen($category->meta_title ?? '') }}/70</span>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
                        <textarea name="meta_description" rows="2" maxlength="160" id="metaDesc"
                                  placeholder="Leave empty for auto-generated description">{{ old('meta_description', $category->meta_description) }}</textarea>
                        <div style="text-align:right;font-size:11px;color:#64748b;margin-top:4px">
                            <span id="metaDescCount">{{ strlen($category->meta_description ?? '') }}/160</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Focus Keyword</label>
                        <input type="text" name="focus_keyword" value="{{ old('focus_keyword', $category->focus_keyword) }}" maxlength="50"
                               placeholder="e.g. electronics deals">
                    </div>

                    {{-- Open Graph --}}
                    <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
                        <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Open Graph (Facebook/LinkedIn)</div>
                    </div>

                    <div class="form-group full">
                        <label>OG Title <span style="color:#64748b;font-weight:400">(leave empty for meta title)</span></label>
                        <input type="text" name="og_title" value="{{ old('og_title', $category->og_title) }}" maxlength="90">
                    </div>

                    <div class="form-group full">
                        <label>OG Description</label>
                        <textarea name="og_description" rows="2" maxlength="200">{{ old('og_description', $category->og_description) }}</textarea>
                    </div>

                    <div class="form-group full">
                        <label>OG Image URL</label>
                        <input type="url" name="og_image" value="{{ old('og_image', $category->og_image) }}" placeholder="Leave empty for default">
                    </div>

                    {{-- Twitter --}}
                    <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
                        <div style="font-size:12px;font-weight:600;color:#38bdf8;margin-bottom:8px">Twitter Card</div>
                    </div>

                    <div class="form-group full">
                        <label>Twitter Title <span style="color:#64748b;font-weight:400">(leave empty for OG title)</span></label>
                        <input type="text" name="twitter_title" value="{{ old('twitter_title', $category->twitter_title) }}" maxlength="90">
                    </div>

                    <div class="form-group full">
                        <label>Twitter Description</label>
                        <textarea name="twitter_description" rows="2" maxlength="200">{{ old('twitter_description', $category->twitter_description) }}</textarea>
                    </div>

                    <div class="form-group full">
                        <label>Twitter Image URL</label>
                        <input type="url" name="twitter_image" value="{{ old('twitter_image', $category->twitter_image) }}" placeholder="Leave empty for OG image">
                    </div>

                    {{-- Technical SEO --}}
                    <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
                        <div style="font-size:12px;font-weight:600;color:#a78bfa;margin-bottom:8px">Technical SEO</div>
                    </div>

                    <div class="form-group full">
                        <label>Canonical URL <span style="color:#64748b;font-weight:400">(leave empty for auto)</span></label>
                        <input type="url" name="canonical_url" value="{{ old('canonical_url', $category->canonical_url) }}">
                    </div>

                    <div class="form-group">
                        <label>Robots Index</label>
                        <select name="robots_index">
                            <option value="index" {{ old('robots_index', $category->robots_index ?? 'index') == 'index' ? 'selected' : '' }}>Index</option>
                            <option value="noindex" {{ old('robots_index', $category->robots_index ?? '') == 'noindex' ? 'selected' : '' }}>NoIndex</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Robots Follow</label>
                        <select name="robots_follow">
                            <option value="follow" {{ old('robots_follow', $category->robots_follow ?? 'follow') == 'follow' ? 'selected' : '' }}>Follow</option>
                            <option value="nofollow" {{ old('robots_follow', $category->robots_follow ?? '') == 'nofollow' ? 'selected' : '' }}>NoFollow</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Schema Type</label>
                        <select name="schema_type">
                            <option value="CollectionPage" {{ old('schema_type', $category->schema_type ?? 'CollectionPage') == 'CollectionPage' ? 'selected' : '' }}>CollectionPage</option>
                            <option value="ItemList" {{ old('schema_type', $category->schema_type ?? '') == 'ItemList' ? 'selected' : '' }}>ItemList</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
                            <input type="checkbox" name="sitemap_include" value="1" {{ old('sitemap_include', $category->sitemap_include ?? true) ? 'checked' : '' }}>
                            Include in Sitemap
                        </label>
                    </div>

                    <div class="form-group">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
                            <input type="checkbox" name="breadcrumb_enable" value="1" {{ old('breadcrumb_enable', $category->breadcrumb_enable ?? true) ? 'checked' : '' }}>
                            Enable Breadcrumbs
                        </label>
                    </div>
                </div>

            </div>

            <div style="display:flex;gap:10px;margin-top:16px">
                <button type="submit" class="btn btn-green">Save Changes</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-gray">Cancel</a>
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
        section.style.display = 'contents';
        icon.style.transform = 'rotate(90deg)';
    } else {
        section.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    }
}

// Character counters
document.getElementById('metaTitle')?.addEventListener('input', function() {
    document.getElementById('metaTitleCount').textContent = this.value.length + '/70';
});
document.getElementById('metaDesc')?.addEventListener('input', function() {
    document.getElementById('metaDescCount').textContent = this.value.length + '/160';
});
</script>
@endpush
@endsection
