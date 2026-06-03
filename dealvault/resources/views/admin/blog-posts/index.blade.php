@extends('admin.layouts.app')
@section('title', 'Blog Posts')
@section('page-title', '📝 Blog Posts')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:12px">
  <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
    <form method="GET" action="{{ route('admin.blog-posts.index') }}" style="display:flex;gap:8px;flex-wrap:wrap">
      <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search posts..."
             style="padding:8px 12px;border:1px solid #334155;border-radius:6px;background:#0f172a;color:#f1f5f9;font-size:13px;width:180px">
      <select name="category" style="padding:8px 12px;border:1px solid #334155;border-radius:6px;background:#0f172a;color:#f1f5f9;font-size:13px">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ ($categoryId ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
      <select name="status" style="padding:8px 12px;border:1px solid #334155;border-radius:6px;background:#0f172a;color:#f1f5f9;font-size:13px">
        <option value="">All Status</option>
        <option value="published" {{ ($status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
        <option value="draft" {{ ($status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
      </select>
      <button type="submit" class="btn btn-blue btn-sm">Filter</button>
      @if($search || $categoryId || $status)
      <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-gray btn-sm">Clear</a>
      @endif
    </form>
    <span style="font-size:13px;color:#64748b">{{ $posts->total() }} posts</span>
  </div>
  <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-green">+ Add Post</a>
</div>

<div class="card" style="padding:0;overflow:hidden">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Post</th>
          <th>Category</th>
          <th>Status</th>
          <th>Views</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              @if($post->featured_image)
              <img src="{{ $post->featured_image }}" alt="" style="width:40px;height:40px;border-radius:6px;object-fit:cover">
              @else
              <div style="width:40px;height:40px;border-radius:6px;background:#1e293b;display:flex;align-items:center;justify-content:center;font-size:16px">📝</div>
              @endif
              <div>
                <div style="font-weight:500;color:#f1f5f9">{{ Str::limit($post->title, 40) }}</div>
                <div style="font-size:11px;color:#475569">/blog/{{ $post->slug }}</div>
              </div>
            </div>
          </td>
          <td>
            @if($post->category)
            <span class="badge badge-blue">{{ $post->category->name }}</span>
            @else
            <span style="color:#475569">—</span>
            @endif
          </td>
          <td>
            @if($post->is_published && $post->published_at && $post->published_at->isPast())
            <span class="badge badge-green">Published</span>
            @elseif($post->is_published && $post->published_at && $post->published_at->isFuture())
            <span class="badge badge-amber">Scheduled</span>
            @else
            <span class="badge badge-gray">Draft</span>
            @endif
            @if($post->is_featured)
            <span class="badge badge-amber" style="margin-left:4px">⭐</span>
            @endif
          </td>
          <td><span class="badge badge-gray">{{ number_format($post->views) }}</span></td>
          <td>
            <div style="font-size:12px;color:#94a3b8">
              {{ $post->published_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}
            </div>
            <div style="font-size:10px;color:#475569">{{ $post->read_time }} min read</div>
          </td>
          <td>
            <div style="display:flex;gap:6px">
              <a href="{{ route('admin.blog-posts.edit', $post) }}" class="btn btn-gray btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.blog-posts.toggle', $post) }}">
                @csrf
                <button class="btn btn-sm {{ $post->is_published ? 'btn-amber' : 'btn-green' }}">
                  {{ $post->is_published ? 'Unpublish' : 'Publish' }}
                </button>
              </form>
              <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}"
                    onsubmit="return confirm('Delete this post?')">
                @csrf @method('DELETE')
                <button class="btn btn-red btn-sm">Del</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center;color:#475569;padding:40px">
            No blog posts yet — <a href="{{ route('admin.blog-posts.create') }}" style="color:#4ade80">Write one!</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-top:20px">
  <div style="display:flex;align-items:center;gap:8px">
    <span style="font-size:13px;color:#64748b">Show</span>
    <select onchange="window.location.href=this.value" style="padding:6px 10px;border:1px solid #334155;border-radius:6px;background:#0f172a;color:#f1f5f9;font-size:13px">
      @foreach([10, 20, 50, 100] as $size)
      <option value="{{ request()->fullUrlWithQuery(['per_page' => $size]) }}" {{ ($perPage ?? 20) == $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    <span style="font-size:13px;color:#64748b">per page</span>
  </div>
  <div class="pagination">{{ $posts->links('vendor.pagination.admin') }}</div>
</div>
@endsection
