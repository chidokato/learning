@extends('backend.layouts.app')

@section('title', 'Danh mục Trang chủ')
@section('page_title', 'Danh mục Trang chủ')
@section('breadcrumb', 'Danh mục Trang chủ')

@section('content')
    <style>
        .svg-preview svg {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách Danh mục</h5>
            <a href="{{ route('backend.homepage_categories.create') }}" class="btn btn-primary">Thêm mới</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Icon</th>
                        <th>Link</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->title }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" height="40" alt="icon">
                            @elseif($category->svg_icon)
                                <div class="svg-preview d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background:#f8f9fa; border-radius:4px; padding:5px; color: {{ $category->color ?? '#000' }};">
                                    {!! $category->svg_icon !!}
                                </div>
                            @endif
                        </td>
                        <td>{{ $category->link }}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Hiện</span>
                            @else
                                <span class="badge bg-danger">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('backend.homepage_categories.edit', $category) }}" class="btn btn-sm btn-info">Sửa</a>
                            <form action="{{ route('backend.homepage_categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
