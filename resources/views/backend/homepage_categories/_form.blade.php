<style>
    .svg-preview svg {
        width: 100% !important;
        height: 100% !important;
    }
</style>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Tiêu đề (Title)</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $homepageCategory->title ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Đường dẫn (Link)</label>
        <input type="text" name="link" class="form-control" value="{{ old('link', $homepageCategory->link ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Màu sắc chủ đạo (Mã Hex)</label>
        <div class="input-group">
            <input type="color" id="colorPicker" class="form-control form-control-color p-1" style="max-width: 50px; height: 38px;" value="{{ old('color', $homepageCategory->color ?? '#0ab99d') }}">
            <input type="text" id="colorText" name="color" class="form-control" value="{{ old('color', $homepageCategory->color ?? '#0ab99d') }}" placeholder="#0ab99d" pattern="^#[0-9A-Fa-f]{6}$" title="Mã màu hợp lệ bắt đầu bằng # và có 6 ký tự (VD: #ff0000)">
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const picker = document.getElementById('colorPicker');
                const text = document.getElementById('colorText');
                
                picker.addEventListener('input', function() {
                    text.value = this.value;
                });
                
                text.addEventListener('input', function() {
                    if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                        picker.value = this.value;
                    }
                });
            });
        </script>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Hình ảnh Icon (Image Icon)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        @if(isset($homepageCategory) && $homepageCategory->image)
            <div class="mt-2">
                <img src="{{ asset($homepageCategory->image) }}" height="60" alt="icon">
            </div>
        @elseif(isset($homepageCategory) && $homepageCategory->svg_icon)
            <div class="mt-2 svg-preview d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #f8f9fa; padding: 10px; border-radius: 5px; color: {{ $homepageCategory->color ?? '#0ab99d' }};">
                {!! $homepageCategory->svg_icon !!}
            </div>
            <small class="text-muted d-block mt-1">Đang dùng SVG cũ. Bạn có thể tải ảnh mới lên để thay thế hoặc giữ nguyên.</small>
        @endif
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Thứ tự hiển thị</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $homepageCategory->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active', $homepageCategory->is_active ?? 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ old('is_active', $homepageCategory->is_active ?? 1) == 0 ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>
</div>
