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
                            <input type="text" name="title" class="form-control" placeholder="Nhập tên bài test..." required>
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
                        
                        <!-- CHỌN TOPIC / MỤC PHÂN CHIA BÀI TEST (CÓ THÊM NHANH) -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label mb-0 fw-semibold">
                                    <i class="ri-price-tag-3-line text-primary me-1"></i> Topic / Mục Bài kiểm tra
                                </label>
                                <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#quickAddTopicModal" title="Thêm nhanh Topic mới">
                                    <i class="ri-add-line"></i> + Thêm nhanh
                                </button>
                            </div>
                            <div class="border rounded p-2 bg-light bg-opacity-25" style="max-height: 140px; overflow-y: auto;" id="topic_checkboxes_container">
                                @forelse ($topics as $topic)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" name="topic_ids[]" value="{{ $topic->id }}" id="topic_{{ $topic->id }}">
                                        <label class="form-check-label user-select-none" for="topic_{{ $topic->id }}">
                                            {{ $topic->name }}
                                        </label>
                                    </div>
                                @empty
                                    <div class="text-muted small fst-italic py-1" id="topic_empty_text">Chưa có Topic bài kiểm tra nào. Bấm <b>"+ Thêm nhanh"</b> để tạo mới.</div>
                                @endforelse
                            </div>
                            <small class="text-muted">Topic riêng biệt dành cho bài kiểm tra (không chung với khóa học).</small>
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
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-upload-cloud-line me-1"></i> Import & Lưu
                        </button>
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
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Tên bài test</th>
                                <th>Thuộc khóa học</th>
                                <th>Mục / Topic</th>
                                <th class="text-center" style="width: 90px;">Số câu hỏi</th>
                                <th class="text-center" style="width: 100px;">Thời gian</th>
                                <th class="text-center" style="width: 90px;">Số câu qua</th>
                                <th class="text-center" style="width: 130px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tests as $test)
                            <tr>
                                <td>{{ $test->id }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $test->title }}</span>
                                </td>
                                <td>
                                    @if($test->post_id && $test->post)
                                        <span class="badge bg-info text-dark">Khóa: {{ Str::limit($test->post->title, 25) }}</span>
                                    @else
                                        <span class="badge bg-secondary">Bài test chung</span>
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
                                <td class="text-center">{{ $test->questions->count() }}</td>
                                <td class="text-center">
                                    @if($test->duration && $test->duration > 0)
                                        <span class="badge bg-primary">{{ $test->duration }} phút</span>
                                    @else
                                        <span class="badge bg-light text-dark border">Không giới hạn</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">
                                        {{ $test->pass_score }}/{{ $test->questions->count() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('backend.tests.edit', $test->id) }}" class="btn btn-warning btn-sm text-dark">
                                            <i class="ri-pencil-line align-bottom me-1"></i> Sửa
                                        </a>
                                        <form action="{{ route('backend.tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài kiểm tra này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-line align-bottom me-1"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Chưa có bài kiểm tra nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm Nhanh Topic -->
<div class="modal fade" id="quickAddTopicModal" tabindex="-1" aria-labelledby="quickAddTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickAddTopicModalLabel">
                    <i class="ri-price-tag-3-line me-1 text-primary"></i> Thêm nhanh Topic Bài kiểm tra
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="quick_add_topic_name" class="form-label fw-semibold">Tên Topic Bài kiểm tra <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="quick_add_topic_name" placeholder="Ví dụ: Kiểm tra chuyên môn, Đánh giá nội bộ..." autocomplete="off">
                    <div class="invalid-feedback" id="quick_add_topic_error"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn-quick-add-topic">
                    <i class="ri-check-line me-1"></i> Lưu và Chọn
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnQuickAdd = document.getElementById('btn-quick-add-topic');
    const nameInput = document.getElementById('quick_add_topic_name');
    const errorFeedback = document.getElementById('quick_add_topic_error');
    const container = document.getElementById('topic_checkboxes_container');
    const modalEl = document.getElementById('quickAddTopicModal');
    let modalInstance = null;

    if (modalEl && typeof bootstrap !== 'undefined') {
        modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    }

    if (btnQuickAdd && nameInput) {
        btnQuickAdd.addEventListener('click', function() {
            const name = nameInput.value.trim();
            if (!name) {
                nameInput.classList.add('is-invalid');
                errorFeedback.textContent = 'Vui lòng nhập tên Topic Bài kiểm tra.';
                return;
            }

            nameInput.classList.remove('is-invalid');
            errorFeedback.textContent = '';
            btnQuickAdd.disabled = true;
            btnQuickAdd.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang lưu...';

            fetch('{{ route("backend.topics.quick-add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: name, type: 'test' })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btnQuickAdd.disabled = false;
                btnQuickAdd.innerHTML = '<i class="ri-check-line me-1"></i> Lưu và Chọn';

                if (res.body.success && res.body.topic) {
                    const topic = res.body.topic;
                    const emptyText = document.getElementById('topic_empty_text');
                    if (emptyText) emptyText.remove();

                    // Check if already exists in checkboxes
                    let existingCheckbox = document.getElementById('topic_' + topic.id);
                    if (existingCheckbox) {
                        existingCheckbox.checked = true;
                    } else if (container) {
                        const div = document.createElement('div');
                        div.className = 'form-check mb-1';
                        div.innerHTML = `
                            <input class="form-check-input" type="checkbox" name="topic_ids[]" value="${topic.id}" id="topic_${topic.id}" checked>
                            <label class="form-check-label user-select-none" for="topic_${topic.id}">${topic.name}</label>
                        `;
                        container.appendChild(div);
                    }

                    nameInput.value = '';
                    if (modalInstance) {
                        modalInstance.hide();
                    } else if (typeof $ !== 'undefined') {
                        $('#quickAddTopicModal').modal('hide');
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Đã thêm Topic: ' + topic.name,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                } else {
                    nameInput.classList.add('is-invalid');
                    let msg = 'Đã có lỗi xảy ra.';
                    if (res.body.errors && res.body.errors.name) {
                        msg = res.body.errors.name[0];
                    } else if (res.body.message) {
                        msg = res.body.message;
                    }
                    errorFeedback.textContent = msg;
                }
            })
            .catch(err => {
                btnQuickAdd.disabled = false;
                btnQuickAdd.innerHTML = '<i class="ri-check-line me-1"></i> Lưu và Chọn';
                nameInput.classList.add('is-invalid');
                errorFeedback.textContent = 'Không thể kết nối đến máy chủ. Vui lòng thử lại.';
            });
        });

        // Enter key in input
        nameInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnQuickAdd.click();
            }
        });
    }
});
</script>
@endpush
@endsection
