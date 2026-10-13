@extends('backend.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý Bài Kiểm Tra</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm bài test mới (Import Excel)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.tests.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tên bài test</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chọn Khóa học (Không bắt buộc)</label>
                            <select name="post_id" class="form-select">
                                <option value="">-- Bài kiểm tra chung (Không thuộc khóa nào) --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số câu đúng để qua (VD: 35)</label>
                            <input type="number" name="pass_score" class="form-control" value="8" required min="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thời gian làm bài (phút)</label>
                            <input type="number" name="duration" class="form-control" placeholder="Ví dụ: 45 (Để trống hoặc 0 nếu không giới hạn)" min="0">
                            <small class="text-muted">Nhập số phút cho phép làm bài. Để 0 hoặc trống nếu không giới hạn.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Excel</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Import & Lưu</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Danh sách bài kiểm tra</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên bài test</th>
                                <th>Thuộc khóa học</th>
                                <th>Số câu hỏi</th>
                                <th>Thời gian</th>
                                <th>Số câu qua</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tests as $test)
                            <tr>
                                <td>{{ $test->id }}</td>
                                <td>{{ $test->title }}</td>
                                <td>
                                    @if($test->post_id)
                                        <span class="badge bg-info">Khóa học (ID: {{ $test->post_id }})</span>
                                    @else
                                        <span class="badge bg-secondary">Bài test chung</span>
                                    @endif
                                </td>
                                <td>{{ $test->questions->count() }}</td>
                                <td>
                                    @if($test->duration && $test->duration > 0)
                                        <span class="badge bg-primary">{{ $test->duration }} phút</span>
                                    @else
                                        <span class="badge bg-light text-dark border">Không giới hạn</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success fs-6">
                                        {{ $test->pass_score }}/{{ $test->questions->count() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-warning btn-sm text-dark btn-edit-test"
                                            data-id="{{ $test->id }}"
                                            data-title="{{ $test->title }}"
                                            data-post-id="{{ $test->post_id ?? '' }}"
                                            data-pass-score="{{ $test->pass_score }}"
                                            data-duration="{{ $test->duration ?? 0 }}"
                                            data-url="{{ route('backend.tests.update', $test->id) }}">
                                            Sửa
                                        </button>
                                        <form action="{{ route('backend.tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài kiểm tra này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chỉnh sửa Bài kiểm tra -->
<div class="modal fade" id="editTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editTestForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa bài kiểm tra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên bài test</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn Khóa học</label>
                        <select name="post_id" id="edit_post_id" class="form-select">
                            <option value="">-- Bài kiểm tra chung (Không thuộc khóa nào) --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Số câu đúng để qua</label>
                            <input type="number" name="pass_score" id="edit_pass_score" class="form-control" required min="1">
                            <small class="text-muted">VD: 35 (học viên đúng >= 35 câu sẽ qua)</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Thời gian làm bài (phút)</label>
                            <input type="number" name="duration" id="edit_duration" class="form-control" placeholder="0 nếu không giới hạn" min="0">
                            <small class="text-muted">Nhập số phút (0 là không giới hạn)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit-test');
        const editModalEl = document.getElementById('editTestModal');
        const editForm = document.getElementById('editTestForm');
        const editTitle = document.getElementById('edit_title');
        const editPostId = document.getElementById('edit_post_id');
        const editPassScore = document.getElementById('edit_pass_score');
        const editDuration = document.getElementById('edit_duration');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                editForm.action = this.dataset.url;
                editTitle.value = this.dataset.title;
                editPostId.value = this.dataset.postId || '';
                editPassScore.value = this.dataset.passScore;
                editDuration.value = this.dataset.duration || 0;
                
                const modal = new bootstrap.Modal(editModalEl);
                modal.show();
            });
        });
    });
</script>
@endsection
