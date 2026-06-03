@extends('admin.layouts.app')
@section('title', 'Edit Blog Post')
@section('page-title', '✏️ Edit Blog Post')

@section('content')
<div style="max-width:800px">
  <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid #334155">
      <div>
        <div style="font-size:11px;color:#64748b">Editing post</div>
        <div style="font-size:16px;font-weight:600;color:#f1f5f9">{{ $post->title }}</div>
      </div>
      <div style="display:flex;gap:8px;align-items:center">
        @if($post->is_published)
        <span class="badge badge-green">Published</span>
        @else
        <span class="badge badge-gray">Draft</span>
        @endif
        <span class="badge badge-blue">{{ number_format($post->views) }} views</span>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.blog-posts.update', $post) }}">
      @csrf
      @method('PUT')
      <div class="form-grid">

        <div class="form-group full">
          <label>Post Title <span style="color:#ef4444">*</span></label>
          <input type="text" name="title" id="postTitle" value="{{ old('title', $post->title) }}"
                 placeholder="e.g. 10 Best Ways to Save Money on Online Shopping" required>
          @error('title')
          <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group full">
          <label>Slug</label>
          <input type="text" name="slug" id="postSlug" value="{{ old('slug', $post->slug) }}"
                 placeholder="10-best-ways-to-save-money">
          <div style="font-size:11px;color:#475569;margin-top:4px">Current URL: /blog/{{ $post->slug }}</div>
          @error('slug')
          <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group full">
          <label>Content <span style="color:#ef4444">*</span></label>
          <textarea name="content" rows="15" placeholder="Write your blog post content here... HTML is supported." required>{{ old('content', $post->content) }}</textarea>
          <div style="font-size:11px;color:#475569;margin-top:4px">Supports HTML formatting. Use &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, etc.</div>
          @error('content')
          <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group full">
          <label>Excerpt</label>
          <textarea name="excerpt" rows="3" maxlength="500" placeholder="Brief summary of the post (shown in listings)...">{{ old('excerpt', $post->excerpt) }}</textarea>
          <div style="font-size:11px;color:#475569;margin-top:4px">Max 500 characters. Auto-generated from content if empty.</div>
        </div>

        <div class="form-group">
          <label>Category</label>
          <select name="category_id" style="width:100%">
            <option value="">— No Category —</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Featured Image URL</label>
          <input type="url" name="featured_image" value="{{ old('featured_image', $post->featured_image) }}"
                 placeholder="https://example.com/image.jpg">
          @if($post->featured_image)
          <div style="margin-top:8px">
            <img src="{{ $post->featured_image }}" alt="" style="max-width:200px;border-radius:6px">
          </div>
          @endif
        </div>

        {{-- Collapsible SEO Settings --}}
        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <button type="button" onclick="toggleSeoSection()" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;width:100%;padding:0;text-align:left">
            <span id="seoToggleIcon" style="transition:transform .2s;color:#10b981">&#9654;</span>
            <span style="font-size:14px;font-weight:600;color:#10b981">SEO Settings</span>
            <span style="font-size:11px;color:#64748b;margin-left:auto">Optional - Click to expand</span>
          </button>
        </div>

        <div id="seoSection" style="display:none">
          {{-- SEO Preview Box --}}
          <div class="form-group full" style="margin-top:12px;margin-bottom:16px">
            <div style="background:#0f172a;border:1px solid #334155;border-radius:8px;padding:16px">
              <div style="font-size:11px;font-weight:600;color:#10b981;margin-bottom:12px;text-transform:uppercase;letter-spacing:0.05em">
                🔍 Google Search Preview (Auto-generated)
              </div>
              <div style="font-family:Arial,sans-serif">
                <div style="font-size:18px;color:#8ab4f8;margin-bottom:4px;line-height:1.3" id="seoPreviewTitle">{{ $post->seo_title }}</div>
                <div style="font-size:12px;color:#bdc1c6;margin-bottom:4px">{{ url('/blog/' . $post->slug) }}</div>
                <div style="font-size:13px;color:#bdc1c6;line-height:1.4" id="seoPreviewDesc">{{ $post->seo_description }}</div>
              </div>
            </div>
          </div>

          {{-- Basic Meta --}}
          <div class="form-group full">
            <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Basic SEO</div>
          </div>

          <div class="form-group full">
            <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" maxlength="70" id="metaTitle"
                   placeholder="Leave empty for auto-generated title">
            <div style="display:flex;justify-content:space-between;font-size:11px;margin-top:4px">
              <span style="color:#10b981">✓ Will use: {{ $post->meta_title ? 'Custom' : 'Auto-generated' }}</span>
              <span style="color:#64748b" id="metaTitleCount">{{ strlen($post->meta_title ?? '') }}/70</span>
            </div>
          </div>

          <div class="form-group full">
            <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
            <textarea name="meta_description" rows="2" maxlength="160" id="metaDesc"
                      placeholder="Leave empty for auto-generated description">{{ old('meta_description', $post->meta_description) }}</textarea>
            <div style="display:flex;justify-content:space-between;font-size:11px;margin-top:4px">
              <span style="color:#10b981">✓ Will use: {{ $post->meta_description ? 'Custom' : 'Auto-generated from ' . ($post->excerpt ? 'excerpt' : 'content') }}</span>
              <span style="color:#64748b" id="metaDescCount">{{ strlen($post->meta_description ?? '') }}/160</span>
            </div>
          </div>

          <div class="form-group full">
            <label>Focus Keyword</label>
            <input type="text" name="focus_keyword" value="{{ old('focus_keyword', $post->focus_keyword) }}" maxlength="50"
                   placeholder="e.g. save money online shopping">
          </div>

          {{-- Open Graph --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#60a5fa;margin-bottom:8px">Open Graph (Facebook/LinkedIn)</div>
          </div>

          <div class="form-group full">
            <label>OG Title <span style="color:#64748b;font-weight:400">(leave empty for meta title)</span></label>
            <input type="text" name="og_title" value="{{ old('og_title', $post->og_title) }}" maxlength="90">
          </div>

          <div class="form-group full">
            <label>OG Description</label>
            <textarea name="og_description" rows="2" maxlength="200">{{ old('og_description', $post->og_description) }}</textarea>
          </div>

          <div class="form-group full">
            <label>OG Image URL</label>
            <input type="url" name="og_image" value="{{ old('og_image', $post->og_image) }}" placeholder="Leave empty to use featured image">
          </div>

          {{-- Technical SEO --}}
          <div class="form-group full" style="margin-top:16px;padding-top:12px;border-top:1px dashed #334155">
            <div style="font-size:12px;font-weight:600;color:#a78bfa;margin-bottom:8px">Technical SEO</div>
          </div>

          <div class="form-group full">
            <label>Canonical URL <span style="color:#64748b;font-weight:400">(leave empty for auto)</span></label>
            <input type="url" name="canonical_url" value="{{ old('canonical_url', $post->canonical_url) }}">
            <div style="font-size:11px;margin-top:4px">
              <span style="color:#10b981">✓ Will use: </span>
              <span style="color:#64748b">{{ $post->seo_canonical }}</span>
            </div>
          </div>

          <div class="form-group">
            <label>Robots Index</label>
            <select name="robots_index">
              <option value="index" {{ old('robots_index', $post->robots_index) == 'index' ? 'selected' : '' }}>Index</option>
              <option value="noindex" {{ old('robots_index', $post->robots_index) == 'noindex' ? 'selected' : '' }}>NoIndex</option>
            </select>
          </div>

          <div class="form-group">
            <label>Robots Follow</label>
            <select name="robots_follow">
              <option value="follow" {{ old('robots_follow', $post->robots_follow) == 'follow' ? 'selected' : '' }}>Follow</option>
              <option value="nofollow" {{ old('robots_follow', $post->robots_follow) == 'nofollow' ? 'selected' : '' }}>NoFollow</option>
            </select>
          </div>

          <div class="form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:20px">
              <input type="checkbox" name="sitemap_include" value="1" {{ old('sitemap_include', $post->sitemap_include) ? 'checked' : '' }}>
              Include in Sitemap
            </label>
          </div>
        </div>

        {{-- Publishing Options --}}
        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <div style="font-size:12px;font-weight:600;color:#f59e0b;margin-bottom:12px">Publishing Options</div>
        </div>

        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
            <span>Published</span>
          </label>
          @if($post->published_at)
          <div style="font-size:11px;color:#475569;margin-top:4px">Published: {{ $post->published_at->format('M d, Y H:i') }}</div>
          @endif
        </div>

        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
            <span>⭐ Featured Post</span>
          </label>
        </div>

      </div>

      <div style="display:flex;gap:10px;margin-top:24px">
        <button type="submit" class="btn btn-green">💾 Save Changes</button>
        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-blue">👁️ Preview</a>
        <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-gray">Cancel</a>
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

// SEO Preview Updates
const postTitle = document.getElementById('postTitle');
const metaTitle = document.getElementById('metaTitle');
const metaDesc = document.getElementById('metaDesc');
const seoPreviewTitle = document.getElementById('seoPreviewTitle');
const seoPreviewDesc = document.getElementById('seoPreviewDesc');
const excerpt = document.querySelector('textarea[name="excerpt"]');
const content = document.querySelector('textarea[name="content"]');

function updateSeoPreview() {
  // Update title preview
  if (metaTitle && metaTitle.value.trim()) {
    seoPreviewTitle.textContent = metaTitle.value;
  } else if (postTitle) {
    seoPreviewTitle.textContent = postTitle.value + ' — Valtwise Blog';
  }

  // Update description preview
  if (metaDesc && metaDesc.value.trim()) {
    seoPreviewDesc.textContent = metaDesc.value;
  } else if (excerpt && excerpt.value.trim()) {
    seoPreviewDesc.textContent = excerpt.value.substring(0, 155) + (excerpt.value.length > 155 ? '...' : '');
  } else if (content && content.value.trim()) {
    const plainText = content.value.replace(/<[^>]*>/g, '');
    seoPreviewDesc.textContent = plainText.substring(0, 155) + (plainText.length > 155 ? '...' : '');
  }
}

// Add event listeners
postTitle?.addEventListener('input', updateSeoPreview);
metaTitle?.addEventListener('input', function() {
  document.getElementById('metaTitleCount').textContent = this.value.length + '/70';
  updateSeoPreview();
});
metaDesc?.addEventListener('input', function() {
  document.getElementById('metaDescCount').textContent = this.value.length + '/160';
  updateSeoPreview();
});
excerpt?.addEventListener('input', updateSeoPreview);
content?.addEventListener('input', updateSeoPreview);
</script>
@endpush
@endsection
