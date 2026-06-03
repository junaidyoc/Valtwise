@extends('admin.layouts.app')
@section('title', 'Edit Blog Category')
@section('page-title', '✏️ Edit Blog Category')

@section('content')
<div class="card" style="max-width:600px">
  <form method="POST" action="{{ route('admin.blog-categories.update', $category) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label>Category Name <span style="color:#ef4444">*</span></label>
      <input type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="e.g. Saving Tips" required>
      @error('name')
      <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label>Slug</label>
      <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="saving-tips">
      <div style="font-size:11px;color:#475569;margin-top:4px">Current URL: /blog/category/{{ $category->slug }}</div>
      @error('slug')
      <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" rows="4" placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
      @error('description')
      <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
        Active
      </label>
      <div style="font-size:11px;color:#475569;margin-top:4px">Inactive categories won't show on the frontend.</div>
    </div>

    <div style="display:flex;gap:10px;margin-top:24px">
      <button type="submit" class="btn btn-green">💾 Save Changes</button>
      <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-gray">Cancel</a>
    </div>
  </form>
</div>
@endsection
