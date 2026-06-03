@extends('admin.layouts.app')
@section('title', 'Blog Categories')
@section('page-title', '📁 Blog Categories')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start">

  {{-- Add Category --}}
  <div class="card">
    <div class="card-title">➕ Add New Blog Category</div>
    <form method="POST" action="{{ route('admin.blog-categories.store') }}">
      @csrf
      <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="name" placeholder="e.g. Saving Tips" required>
      </div>
      <div class="form-group">
        <label>Slug (optional - auto-generated from name)</label>
        <input type="text" name="slug" placeholder="saving-tips">
      </div>
      <div class="form-group">
        <label>Description (optional)</label>
        <textarea name="description" rows="3" placeholder="Brief description of this category..."></textarea>
      </div>
      <div class="form-group">
        <label>
          <input type="checkbox" name="is_active" value="1" checked> Active
        </label>
      </div>
      <button type="submit" class="btn btn-green">Add Category</button>
    </form>
  </div>

  {{-- Categories List --}}
  <div class="card">
    <div class="card-title">📋 All Blog Categories ({{ $categories->total() }})</div>

    @if($search)
    <div style="margin-bottom:12px;font-size:12px;color:#94a3b8">
      Showing results for "{{ $search }}"
      <a href="{{ route('admin.blog-categories.index') }}" style="color:#22c55e;margin-left:8px">Clear</a>
    </div>
    @endif

    <form method="GET" style="margin-bottom:16px;display:flex;gap:8px">
      <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search categories..."
             style="flex:1;padding:8px 12px;background:#1e293b;border:1px solid #334155;border-radius:6px;color:#f1f5f9;font-size:13px">
      <button type="submit" class="btn btn-blue">Search</button>
    </form>

    @forelse($categories as $cat)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #334155">
      <div>
        <div style="font-size:14px;font-weight:600;color:#f1f5f9;display:flex;align-items:center;gap:8px">
          {{ $cat->name }}
          @if(!$cat->is_active)
          <span style="font-size:9px;background:#ef4444;color:#fff;padding:2px 6px;border-radius:4px">INACTIVE</span>
          @endif
        </div>
        <div style="font-size:11px;color:#475569">
          {{ $cat->posts_count }} posts · /blog/category/{{ $cat->slug }}
        </div>
        @if($cat->description)
        <div style="font-size:11px;color:#64748b;margin-top:4px">{{ Str::limit($cat->description, 60) }}</div>
        @endif
      </div>
      <div style="display:flex;gap:6px">
        <a href="{{ route('admin.blog-categories.edit', $cat) }}" class="btn btn-blue btn-sm">Edit</a>
        <form method="POST" action="{{ route('admin.blog-categories.destroy', $cat) }}"
              onsubmit="return confirm('Delete {{ $cat->name }}?{{ $cat->posts_count > 0 ? ' This will unlink ' . $cat->posts_count . ' posts.' : '' }}')" style="margin:0">
          @csrf @method('DELETE')
          <button class="btn btn-red btn-sm">Delete</button>
        </form>
      </div>
    </div>
    @empty
    <div style="color:#475569;font-size:13px">No blog categories yet</div>
    @endforelse

    <div style="margin-top:16px">
      {{ $categories->links('vendor.pagination.admin') }}
    </div>
  </div>
</div>
@endsection
