@extends('backend.layouts.app')

@section('title', 'Topics')
@section('page_title', 'Topic (Chủ đề)')
@section('breadcrumb', 'Topic')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Quản lý Chủ đề</h4>
            <a href="{{ route('backend.topics.create') }}" class="btn btn-primary">Thêm Chủ đề</a>
        </div>
        <div class="card-body">
            @if ($topics->isEmpty())
                <div class="text-muted">Chưa có chủ đề nào.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Tên Chủ đề</th>
                                <th scope="col">Slug</th>
                                <th scope="col" class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topics as $topic)
                                <tr>
                                    <td>{{ $loop->iteration + $topics->firstItem() - 1 }}</td>
                                    <td><span class="fw-medium">{{ $topic->name }}</span></td>
                                    <td>{{ $topic->slug }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('backend.topics.edit', $topic) }}" class="btn btn-sm btn-soft-info" title="Sửa">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('backend.topics.destroy', $topic) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chủ đề này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Xóa">
                                                    <i class="ri-delete-bin-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $topics->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
