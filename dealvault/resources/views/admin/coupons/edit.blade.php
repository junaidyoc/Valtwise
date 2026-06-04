@extends('admin.layouts.app')
@section('title', 'Edit Coupon')
@section('page-title', '✏️ Edit Coupon')

@section('content')
<div style="max-width:700px">
  <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray btn-sm" style="margin-bottom:16px">← Back</a>

  <div class="card">
    <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
      @csrf @method('PUT')
      <div class="form-grid">

        <div class="form-group full">
          <label>Store</label>
          <select name="store_id" required>
            @foreach($stores as $store)
            <option value="{{ $store->id }}" {{ $coupon->store_id == $store->id ? 'selected' : '' }}>
              {{ $store->name }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="form-group full">
          <label>Coupon Title</label>
          <input type="text" name="title" value="{{ $coupon->title }}" required>
        </div>

        <div class="form-group">
          <label>Type</label>
          <select name="type">
            <option value="code" {{ $coupon->type == 'code' ? 'selected' : '' }}>Code</option>
            <option value="deal" {{ $coupon->type == 'deal' ? 'selected' : '' }}>Deal</option>
            <option value="sale" {{ $coupon->type == 'sale' ? 'selected' : '' }}>Sale</option>
          </select>
        </div>

        <div class="form-group">
          <label>Discount Value</label>
          <input type="text" name="discount_value" value="{{ $coupon->discount_value }}">
        </div>

        <div class="form-group full">
          <label>Coupon Code</label>
          <input type="text" name="code" value="{{ $coupon->code }}"
                 style="font-family:monospace;text-transform:uppercase">
        </div>

        <div class="form-group full">
          <label>Destination URL</label>
          <input type="url" name="destination_url" value="{{ $coupon->destination_url }}">
        </div>

        <div class="form-group full">
          <label>Description</label>
          <textarea name="description" rows="2">{{ $coupon->description }}</textarea>
        </div>

        <div class="form-group">
          <label>Expiry Date</label>
          <input type="date" name="expires_at"
                 value="{{ $coupon->expires_at?->format('Y-m-d') }}">
        </div>

        <div class="form-group" style="display:flex;flex-direction:column;gap:10px;justify-content:flex-end">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_verified" value="1"
                   {{ $coupon->is_verified ? 'checked' : '' }}>
            Verified
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_exclusive" value="1"
                   {{ $coupon->is_exclusive ? 'checked' : '' }}>
            Exclusive
          </label>
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_active" value="1"
                   {{ $coupon->is_active ? 'checked' : '' }}>
            Active
          </label>
        </div>

        {{-- SEO Settings --}}
        <div class="form-group full" style="margin-top:16px;padding-top:16px;border-top:1px solid #334155">
          <div style="font-size:14px;font-weight:600;color:#10b981;margin-bottom:12px">SEO Settings <span style="font-weight:400;color:#64748b">(Optional)</span></div>
        </div>


        <div class="form-group full">
          <label>Meta Title <span style="color:#64748b;font-weight:400">(max 70 chars)</span></label>
          <input type="text" name="meta_title" value="{{ old('meta_title', $coupon->meta_title) }}" maxlength="70" id="metaTitle"
                 placeholder="Leave empty for auto-generated title">
          <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-top:4px">
            <span>Auto: {{ $coupon->title }} at {{ $coupon->store->name ?? 'Store' }} — Valtwise</span>
            <span id="metaTitleCount">{{ strlen($coupon->meta_title ?? '') }}/70</span>
          </div>
        </div>

        <div class="form-group full">
          <label>Meta Description <span style="color:#64748b;font-weight:400">(max 160 chars)</span></label>
          <textarea name="meta_description" rows="2" maxlength="160" id="metaDesc"
                    placeholder="Leave empty for auto-generated description">{{ old('meta_description', $coupon->meta_description) }}</textarea>
          <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-top:4px">
            <span>Auto: Save with {{ $coupon->title }} from {{ $coupon->store->name ?? 'Store' }}. {{ $coupon->discount_value ? $coupon->discount_value . ' off!' : 'Get this deal now!' }}</span>
            <span id="metaDescCount">{{ strlen($coupon->meta_description ?? '') }}/160</span>
          </div>
        </div>

        <div class="form-group">
          <label>Focus Keyword</label>
          <input type="text" name="focus_keyword" value="{{ old('focus_keyword', $coupon->focus_keyword) }}" maxlength="50"
                 placeholder="e.g. discount code">
        </div>

      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn-green">💾 Save Changes</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
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
