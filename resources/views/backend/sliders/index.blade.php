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