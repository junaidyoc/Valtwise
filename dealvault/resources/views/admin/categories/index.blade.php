@extends('admin.layouts.app')
@section('title', 'Categories')
@section('page-title', '📁 Categories')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start">

  {{-- Add Category / Subcategory --}}
  <div class="card">
    <div class="card-title">➕ Add New Category</div>
    <form method="POST" action="{{ route('admin.categories.store') }}">
      @csrf
      <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="name" placeholder="e.g. Fashion" required>
      </div>
      <div class="form-group">
        <label>Parent Category (optional - leave empty for main category)</label>
        <select name="parent_id" style="width:100%;padding:8px 12px;background:#1e293b;border:1px solid #334155;border-radius:6px;color:#f1f5f9;font-size:13px">
          <option value="">— None (Main Category) —</option>
          @foreach($parentCategories as $parent)
            <option value="{{ $parent->id }}">{{ $parent->icon ?? '🏷️' }} {{ $parent->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Icon (Emoji)</label>
        <input type="text" name="icon" placeholder="👗" maxlength="4">
      </div>
      <button type="submit" class="btn btn-green">Add Category</button>
    </form>
  </div>

  {{-- Categories List --}}
  <div class="card">
    <div class="card-title">📋 All Categories ({{ $categories->count() }} main, {{ $categories->sum('children_count') }} sub)</div>
    @forelse($categories as $cat)
    {{-- Parent Category --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #334155">
      <div style="display:flex;align-items:center;gap:10px">
        <span style="font-size:20px">{{ $cat->icon ?? '🏷️' }}</span>
        <div>
          <div style="font-size:13px;font-weight:600;color:#f1f5f9">{{ $cat->name }}</div>
          <div style="font-size:11px;color:#475569">
            {{ $cat->stores_count }} stores
            @if($cat->children_count > 0)
              · {{ $cat->children_count }} subcategories
            @endif
          </div>
        </div>
      </div>
      <div style="display:flex;gap:6px">
        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-blue btn-sm">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
              onsubmit="return confirm('Delete {{ $cat->name }}?{{ $cat->children_count > 0 ? ' This will fail because it has subcategories.' : '' }}')" style="margin:0">
          @csrf @method('DELETE')
          <button class="btn btn-red btn-sm">Delete</button>
        </form>
      </div>
    </div>

    {{-- Subcategories --}}
    @foreach($cat->children as $sub)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0 8px 32px;border-bottom:1px solid #1e293b">
      <div style="display:flex;align-items:center;gap:8px">
        <span style="color:#475569">↳</span>
        <span style="font-size:16px">{{ $sub->icon ?? '🏷️' }}</span>
        <div>
          <div style="font-size:12px;font-weight:500;color:#94a3b8">{{ $sub->name }}</div>
          <div style="font-size:10px;color:#475569">{{ $sub->stores_count }} stores</div>
        </div>
      </div>
      <div style="display:flex;gap:6px">
        <a href="{{ route('admin.categories.edit', $sub) }}" class="btn btn-blue btn-sm" style="font-size:10px;padding:4px 8px">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $sub) }}"
              onsubmit="return confirm('Delete subcategory {{ $sub->name }}?')" style="margin:0">
          @csrf @method('DELETE')
          <button class="btn btn-red btn-sm" style="font-size:10px;padding:4px 8px">Delete</button>
        </form>
      </div>
    </div>
    @endforeach
    @empty
    <div style="color:#475569;font-size:13px">No categories yet</div>
    @endforelse
  </div>
</div>
@endsection
