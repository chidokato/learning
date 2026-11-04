@extends('backend.layouts.app')

@section('title', 'Quản lý Bài kiểm tra')
@section('page_title', 'Quản lý Bài kiểm tra')
@section('breadcrumb', 'Bài kiểm tra')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="card-title mb-1">Danh sách bài kiểm tra</h5>
            <p class="text-muted mb-0 small">Quản lý các bài kiểm tra, ngân hàng câu hỏi trắc nghiệm và thiết lập thời gian làm bài</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('backend.tests.create') }}" class="btn btn-primary">
                <i class="ri-add-line align-bottom me-1"></i> Thêm bài test mới
            </a>
        </div>
    </div>

    <!-- Thanh tìm kiếm & bộ lọc -->
    <div class="card-body border-bottom bg-light bg-opacity-25 py-3">
        <form action="{{ route('backend.tests.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên bài test..." value="{{ request('keyword') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="post_id" class="form-select">
                    <option value="">-- Tất cả khóa học --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ (string)request('post_id') === (string)$course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="topic_id" class="form-select">
                    <option value="">-- Tất cả Topic / Mục --</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}" {{ (string)request('topic_id') === (string)$topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ri-filter-3-line align-bottom me-1"></i> Lọc
                </button>
                @if(request()->hasAny(['keyword', 'post_id', 'topic_id']))
                    <a href="{{ route('backend.tests.index') }}" class="btn btn-outline-secondary" title="Đặt lại bộ lọc">
                        <i class="ri-refresh-line"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px;">ID</th>
                        <th>Tên bài test</th>
                        <th>Thuộc khóa học</th>
                        <th>Mục / Topic</th>
                        <th class="text-center" style="width: 100px;">Số câu hỏi</th>
                        <th class="text-center" style="width: 110px;">Thời gian</th>
                        <th class="text-center" style="width: 100px;">Số câu qua</th>
                        <th class="text-center" style="width: 120px;">Đặc biệt</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tests as $test)
                    <tr>
                        <td class="text-center text-muted fw-semibold">{{ $test->id }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $test->title }}</div>
                            <div class="text-muted small">Cập nhật: {{ $test->updated_at ? $test->updated_at->format('d/m/Y H:i') : '-' }}</div>
                        </td>
                        <td>
                            @if($test->post_id && $test->post)
                                <span class="badge bg-info text-dark">
                                    <i class="ri-book-open-line me-1"></i>{{ Str::limit($test->post->title, 30) }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border">Bài test chung</span>
                            @endif
                        </td>
                        <td>
                            @if($test->topics->isNotEmpty())
                                @foreach($test->topics as $tp)
                                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 me-1 mb-1">{{ $tp->name }}</span>
                                @endforeach
                            @elseif($test->topic)
                                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 me-1">{{ $test->topic->name }}</span>
                            @else
                                <span class="text-muted small fst-italic">-- Chưa chọn --</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-2 py-1 fs-6">
                                {{ $test->questions->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($test->duration && $test->duration > 0)
                                <span class="badge bg-primary px-2 py-1">
                                    <i class="ri-time-line me-1"></i>{{ $test->duration }} phút
                                </span>
                            @else
                                <span class="badge bg-light text-dark border">Không giới hạn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success fs-6 px-2 py-1">
                                {{ $test->pass_score }}/{{ $test->questions->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex align-items-center gap-2">
                                <button
                                    type="button"
                                    class="status-toggle {{ $test->is_special ? 'is-active' : 'is-inactive' }}"
                                    data-toggle-status
                                    data-url="{{ route('backend.tests.toggle-special', $test->id) }}"
                                    aria-pressed="{{ $test->is_special ? 'true' : 'false' }}"
                                    title="Bật/Tắt bài kiểm tra đặc biệt"
                                ></button>
                                <span class="status-toggle-label {{ $test->is_special ? 'text-success' : 'text-danger' }}" data-status-label>
                                    {{ $test->is_special ? 'Bật' : 'Tắt' }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('backend.tests.edit', $test->id) }}" class="btn btn-warning btn-sm text-dark" title="Chỉnh sửa chi tiết">
                                    <i class="ri-pencil-line align-bottom me-1"></i> Sửa
                                </a>
                                <form action="{{ route('backend.tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài kiểm tra này? Toàn bộ câu hỏi liên quan sẽ bị xóa.');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa bài test">
                                        <i class="ri-delete-bin-line align-bottom me-1"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted">
                                <i class="ri-file-list-3-line display-5 text-muted mb-3 d-block"></i>
                                <p class="mb-2 fs-5">Chưa có bài kiểm tra nào.</p>
                                <a href="{{ route('backend.tests.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ri-add-line me-1"></i> Thêm bài test mới ngay
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tests->hasPages() || $tests->total() > 0)
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-4 pt-2 border-top">
            <div class="text-muted small">
                Hiển thị từ <b>{{ $tests->firstItem() ?? 0 }}</b> đến <b>{{ $tests->lastItem() ?? 0 }}</b> trong tổng số <b>{{ $tests->total() }}</b> bài kiểm tra
            </div>
            <div>
                {{ $tests->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
