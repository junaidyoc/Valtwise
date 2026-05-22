@extends('admin.layouts.app')
@section('title', 'Categories')
@section('page-title', '📁 Categories')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start">

  {{-- Add Category --}}
  <div class="card">
    <div class="card-title">➕ Add New Category</div>
    <form method="POST" action="{{ route('admin.categories.store') }}">
      @csrf
      <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="name" placeholder="e.g. Fashion" required>
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
    <div class="card-title">📋 All Categories ({{ $categories->count() }})</div>
    @forelse($categories as $cat)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #334155">
      <div style="display:flex;align-items:center;gap:10px">
        <span style="font-size:20px">{{ $cat->icon ?? '🏷️' }}</span>
        <div>
          <div style="font-size:13px;font-weight:500;color:#f1f5f9">{{ $cat->name }}</div>
          <div style="font-size:11px;color:#475569">{{ $cat->stores_count }} stores</div>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
            onsubmit="return confirm('Delete {{ $cat->name }}?')">
        @csrf @method('DELETE')
        <button class="btn btn-red btn-sm">Delete</button>
      </form>
    </div>
    @empty
    <div style="color:#475569;font-size:13px">No categories yet</div>
    @endforelse
  </div>
</div>
@endsection
