<?php
$dir = __DIR__.'/../resources/views/backend/sliders';
if(!is_dir($dir)) mkdir($dir, 0777, true);

$index = <<<'EOD'
@extends('backend.layouts.app')

@section('title', 'Sliders')
@section('page_title', 'Quản lý Slider')
@section('breadcrumb', 'Sliders')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Quản lý Slider</h4>
            <a href="{{ route('backend.sliders.create') }}" class="btn btn-primary">Thêm Slide</a>
        </div>
        <div class="card-body">
            @if ($sliders->isEmpty())
                <div class="text-center text-muted py-4">Chưa có slide nào.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Subtitle</th>
                                <th>Thứ tự</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td><img src="{{ $slider->image_url }}" alt="" height="50"></td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->subtitle }}</td>
                                    <td>{{ $slider->sort_order }}</td>
                                    <td>
                                        <span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $slider->is_active ? 'Hiện' : 'Ẩn' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('backend.sliders.edit', $slider) }}" class="btn btn-sm btn-soft-info"><i class="las la-pen"></i></a>
                                        <form action="{{ route('backend.sliders.destroy', $slider) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger"><i class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
EOD;
file_put_contents("$dir/index.blade.php", $index);

$create = <<<'EOD'
@extends('backend.layouts.app')

@section('title', 'Thêm Slider')
@section('page_title', 'Thêm Slider')
@section('breadcrumb', 'Thêm Slider')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.sliders._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                    <a href="{{ route('backend.sliders.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
EOD;
file_put_contents("$dir/create.blade.php", $create);

$edit = <<<'EOD'
@extends('backend.layouts.app')

@section('title', 'Sửa Slider')
@section('page_title', 'Sửa Slider')
@section('breadcrumb', 'Sửa Slider')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('backend.sliders._form', ['slider' => $slider])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="{{ route('backend.sliders.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
EOD;
file_put_contents("$dir/edit.blade.php", $edit);

$form = <<<'EOD'
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
EOD;
file_put_contents("$dir/_form.blade.php", $form);
