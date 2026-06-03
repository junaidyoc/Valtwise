@extends('admin.layouts.app')
@section('title', 'Add Blog Category')
@section('page-title', '➕ Add Blog Category')

@section('content')
<div class="card" style="max-width:600px">
  <form method="POST" action="{{ route('admin.blog-categories.store') }}">
    @csrf

    <div class="form-group">
      <label>Category Name <span style="color:#ef4444">*</span></label>
      <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Saving Tips" required>
      @error('name')
      <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label>Slug</label>
      <input type="text" name="slug" value="{{ old('slug') }}" placeholder="saving-tips (auto-generated if empty)">
      <div style="font-size:11px;color:#475569;margin-top:4px">URL-friendly identifier. Leave empty to auto-generate from name.</div>
      @error('slug')
      <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" rows="4" placeholder="Brief description of this category...">{{ old('description') }}</textarea>
      @error('description')
      <div style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
        Active
      </label>
      <div style="font-size:11px;color:#475569;margin-top:4px">Inactive categories won't show on the frontend.</div>
    </div>

    <div style="display:flex;gap:10px;margin-top:24px">
      <button type="submit" class="btn btn-green">✅ Add Category</button>
      <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-gray">Cancel</a>
    </div>
  </form>
</div>
@endsection
