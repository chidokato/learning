@extends('backend.layouts.app')

@section('title', 'Thêm bài kiểm tra mới')
@section('page_title', 'Thêm bài kiểm tra mới')
@section('breadcrumb', 'Thêm mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-11">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h5 class="card-title mb-1">Thêm bài test mới (Import Excel)</h5>
                    <p class="text-muted mb-0 small">Điền thông tin bài kiểm tra và tải lên file Excel câu hỏi trắc nghiệm</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('backend.tests.sample-excel') }}" class="btn btn-soft-success btn-sm">
                        <i class="ri-file-download-line align-bottom me-1"></i> Tải file mẫu Excel
                    </a>
                    <a href="{{ route('backend.tests.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> Quay lại danh sách
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('backend.tests.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Tên bài test -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên bài test <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" placeholder="Nhập tên bài test..." value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Chọn Khóa học -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Chọn Khóa học (Không bắt buộc)</label>
                            <select name="post_id" class="form-select @error('post_id') is-invalid @enderror">
                                <option value="">-- Bài kiểm tra chung (Không thuộc khóa nào) --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('post_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Gán bài kiểm tra này vào một khóa học hoặc để trống làm bài kiểm tra chung.</small>
                            @error('post_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Topic / Mục Bài kiểm tra (có thêm nhanh) -->
                        <div class="col-md-6 mb-3">
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
                                        <input class="form-check-input" type="checkbox" name="topic_ids[]" value="{{ $topic->id }}" id="topic_{{ $topic->id }}" {{ in_array($topic->id, (array)old('topic_ids', [])) ? 'checked' : '' }}>
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
                    </div>

                    <div class="row">
                        <!-- Số câu đúng để qua -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Số câu đúng để qua (VD: 35) <span class="text-danger">*</span></label>
                            <input type="number" name="pass_score" class="form-control @error('pass_score') is-invalid @enderror" value="{{ old('pass_score', 8) }}" required min="1">
                            <small class="text-muted">Số câu trả lời đúng tối thiểu để đạt bài kiểm tra.</small>
                            @error('pass_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thời gian làm bài -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Thời gian làm bài (phút)</label>
                            <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" placeholder="Ví dụ: 45 (Để trống hoặc 0 nếu không giới hạn)" value="{{ old('duration') }}" min="0">
                            <small class="text-muted">Nhập số phút cho phép làm bài. Để 0 hoặc trống nếu không giới hạn.</small>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Đánh dấu bài test đặc biệt -->
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_special" name="is_special" value="1" {{ old('is_special') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-primary" for="is_special">
                            <i class="ri-star-fill text-warning me-1"></i> Đặc biệt (Bài kiểm tra đặc biệt)
                        </label>
                        <div class="text-muted small">Đánh dấu bài test này là bài kiểm tra đặc biệt.</div>
                    </div>

                    <!-- File Excel -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">File Excel chứa câu hỏi & đáp án <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                        <small class="text-muted">Chỉ chấp nhận tệp có định dạng .xlsx, .xls hoặc .csv.</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hướng dẫn định dạng file Excel -->
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="ri-information-line fs-5 mt-1 text-info"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading fw-bold mb-1 text-info">Quy cách định dạng file Excel nhập liệu:</h6>
                                <ul class="mb-2 ps-3 small text-muted">
                                    <li><b>Dòng 1:</b> Dòng tiêu đề các cột (Hệ thống sẽ tự động bỏ qua dòng đầu).</li>
                                    <li><b>Cột A:</b> Nhập "Câu 1", "Câu 2"... đối với dòng câu hỏi; nhập "A", "B", "C", "D"... đối với dòng đáp án.</li>
                                    <li><b>Cột B:</b> Nội dung câu hỏi hoặc nội dung câu trả lời. Nếu câu hỏi có chữ "nhiều", hệ thống tự nhận là câu hỏi nhiều đáp án.</li>
                                    <li><b>Cột C:</b> Đánh dấu <code>x</code> hoặc <code>đúng</code> hoặc <code>1</code> đối với các đáp án đúng.</li>
                                </ul>
                                <a href="{{ route('backend.tests.sample-excel') }}" class="btn btn-sm btn-outline-primary bg-white fw-semibold">
                                    <i class="ri-download-2-line me-1"></i> Tải file Excel mẫu (.xlsx)
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Nút bấm hành động -->
                    <div class="d-flex align-items-center gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="ri-upload-cloud-line me-1"></i> Import & Lưu bài test
                        </button>
                        <a href="{{ route('backend.tests.index') }}" class="btn btn-light px-4 py-2">
                            Hủy bỏ
                        </a>
                    </div>
                </form>
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
