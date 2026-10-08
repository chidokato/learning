<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tiêu đề (Title)</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Tiêu đề phụ (Subtitle)</label>
        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Chữ trên nút (Button Text)</label>
        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Link nút (Button Link)</label>
        <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $slider->button_link ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Ảnh chính</label>
        <input type="file" name="image" class="form-control">
        @if(isset($slider) && $slider->image)
            <div class="mt-2">
                <img src="{{ $slider->image_url }}" height="80">
            </div>
        @endif
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Thứ tự hiển thị</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active', $slider->is_active ?? 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ old('is_active', $slider->is_active ?? 1) == 0 ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>
</div>