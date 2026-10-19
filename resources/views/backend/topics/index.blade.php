@extends('backend.layouts.app')

@section('title', 'Topics')
@section('page_title', 'Topic (Chủ đề)')
@section('breadcrumb', 'Topic')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4 class="card-title mb-1">Quản lý Chủ đề / Topic</h4>
                <p class="text-muted mb-0 small">Phân chia rõ ràng giữa Topic Khóa học và Topic Bài kiểm tra</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('backend.topics.create') }}" class="btn btn-primary">
                    <i class="ri-add-line align-bottom me-1"></i> Thêm Chủ đề mới
                </a>
            </div>
        </div>
        
        <!-- Filter Tabs -->
        <div class="card-body border-bottom border-light pb-0 pt-3">
            <ul class="nav nav-tabs nav-tabs-custom border-bottom-0" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ empty($type) ? 'active' : '' }}" href="{{ route('backend.topics.index') }}">
                        <i class="ri-apps-2-line me-1"></i> Tất cả 
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill ms-1">{{ $counts['all'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($type ?? '') === 'course' ? 'active' : '' }}" href="{{ route('backend.topics.index', ['type' => 'course']) }}">
                        <i class="ri-book-open-line me-1 text-success"></i> Topic Khóa học
                        <span class="badge bg-success-subtle text-success rounded-pill ms-1">{{ $counts['course'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($type ?? '') === 'test' ? 'active' : '' }}" href="{{ route('backend.topics.index', ['type' => 'test']) }}">
                        <i class="ri-file-list-3-line me-1 text-primary"></i> Topic Bài kiểm tra
                        <span class="badge bg-primary-subtle text-primary rounded-pill ms-1">{{ $counts['test'] ?? 0 }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            @if ($topics->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="ri-price-tag-3-line display-5 text-muted mb-3 d-block"></i>
                    <p class="mb-2">Chưa có chủ đề nào trong mục này.</p>
                    <a href="{{ route('backend.topics.create', ['type' => $type ?? 'course']) }}" class="btn btn-sm btn-soft-primary">
                        <i class="ri-add-line me-1"></i> Tạo chủ đề mới
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Tên Chủ đề</th>
                                <th scope="col" style="width: 160px;">Phân loại</th>
                                <th scope="col">Slug</th>
                                <th scope="col" class="text-end" style="width: 120px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topics as $topic)
                                <tr>
                                    <td>{{ $loop->iteration + $topics->firstItem() - 1 }}</td>
                                    <td>
                                        <span class="fw-semibold text-dark fs-14">{{ $topic->name }}</span>
                                    </td>
                                    <td>
                                        @if(($topic->type ?? 'course') === 'test')
                                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 fs-12">
                                                <i class="ri-file-list-3-line me-1"></i> Bài kiểm tra
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 fs-12">
                                                <i class="ri-book-open-line me-1"></i> Khóa học
                                            </span>
                                        @endif
                                    </td>
                                    <td><code>{{ $topic->slug }}</code></td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('backend.topics.edit', $topic) }}" class="btn btn-sm btn-soft-info" title="Sửa">
                                                <i class="ri-pencil-fill"></i> Sửa
                                            </a>
                                            <form action="{{ route('backend.topics.destroy', $topic) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chủ đề này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Xóa">
                                                    <i class="ri-delete-bin-fill"></i> Xóa
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
