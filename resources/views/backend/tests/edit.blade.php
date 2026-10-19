@extends('backend.layouts.app')

@section('title', 'Chỉnh sửa bài kiểm tra: ' . $test->title)

@push('styles')
<style>
    .question-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
        background: #fff;
    }
    .question-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .question-card.active-target {
        border-color: #0ab39c;
        box-shadow: 0 0 0 3px rgba(10, 179, 156, 0.25);
    }
    .question-header {
        padding: 12px 16px;
        background-color: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        cursor: pointer;
        user-select: none;
    }
    .question-card.collapsed .question-body {
        display: none;
    }
    .question-card.collapsed .collapse-icon {
        transform: rotate(-90deg);
    }
    .collapse-icon {
        transition: transform 0.2s ease;
    }
    .answer-row {
        background: #fbfcfe;
        border: 1px solid #edf2f7;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }
    .answer-row:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .answer-row.is-correct {
        background: #ecfdf5;
        border-color: #a7f3d0;
    }
    .answer-correct-check {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #0ab39c;
    }
    .answer-label-badge {
        width: 32px;
        font-weight: 700;
        text-align: center;
        background: #e2e8f0;
        border-radius: 4px;
        padding: 4px 0;
        display: inline-block;
    }
    .answer-row.is-correct .answer-label-badge {
        background: #0ab39c;
        color: #fff;
    }
    .nav-pills-questions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    .nav-pill-q {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        transition: all 0.15s;
    }
    .nav-pill-q:hover {
        background: #0ab39c;
        color: #fff;
        border-color: #0ab39c;
    }
    .nav-pill-q.has-error {
        border-color: #f06548;
        background: #fef2f2;
        color: #b91c1c;
    }
    .sticky-bottom-actions {
        position: sticky;
        bottom: 15px;
        z-index: 99;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        padding: 12px 20px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chỉnh sửa Bài kiểm tra</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('backend.admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.tests.index') }}">Bài kiểm tra</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Edit Form -->
    <form id="editTestForm" action="{{ route('backend.tests.update', $test->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="questions_data" id="questions_data_input">

        <!-- Top Header Actions -->
        <div class="card mb-3">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('backend.tests.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ri-arrow-left-line me-1"></i> Quay lại
                        </a>
                        <h5 class="mb-0 text-truncate" style="max-width: 450px;">
                            {{ $test->title }}
                        </h5>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-question-top">
                            <i class="ri-add-line me-1"></i> Thêm câu hỏi
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit-form">
                            <i class="ri-save-line me-1"></i> Lưu thay đổi
                        </button>
                        <button type="submit" name="save_and_exit" value="1" class="btn btn-success btn-sm btn-submit-form">
                            <i class="ri-check-line me-1"></i> Lưu & Thoát
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Test Settings -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fs-14">
                            <i class="ri-settings-4-line text-primary me-1"></i> Cài đặt bài kiểm tra
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên bài kiểm tra <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $test->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Thuộc khóa học</label>
                            <select name="post_id" class="form-select">
                                <option value="">-- Bài kiểm tra chung (Không thuộc khóa nào) --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ (string)$test->post_id === (string)$course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Chọn khóa học nếu bài test này bắt buộc cho khóa học đó.</small>
                        </div>

                        <!-- CHỌN TOPIC / MỤC PHÂN CHIA BÀI TEST (CÓ THÊM NHANH) -->
                        @php
                            $selectedTopicIds = old('topic_ids', $test->topics->pluck('id')->toArray());
                            if (empty($selectedTopicIds) && $test->topic_id) {
                                $selectedTopicIds = [$test->topic_id];
                            }
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label fw-bold mb-0">
                                    <i class="ri-price-tag-3-line text-primary me-1"></i> Topic / Mục Bài kiểm tra
                                </label>
                                <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#quickAddTopicModal" title="Thêm nhanh Topic mới">
                                    <i class="ri-add-line"></i> + Thêm nhanh
                                </button>
                            </div>
                            <div class="border rounded p-2 bg-light bg-opacity-25" style="max-height: 140px; overflow-y: auto;" id="topic_checkboxes_container">
                                @forelse ($topics as $topic)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" name="topic_ids[]" value="{{ $topic->id }}" id="topic_{{ $topic->id }}" {{ in_array($topic->id, $selectedTopicIds) ? 'checked' : '' }}>
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

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Số câu đúng để qua <span class="text-danger">*</span></label>
                                <input type="number" name="pass_score" id="input_pass_score" class="form-control" value="{{ old('pass_score', $test->pass_score) }}" required min="1">
                                <small class="text-muted">VD: 35 (học viên đúng &ge; 35 câu sẽ ĐẠT)</small>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-bold">Thời gian làm (phút)</label>
                                <input type="number" name="duration" class="form-control" value="{{ old('duration', $test->duration ?? 0) }}" placeholder="0" min="0">
                                <small class="text-muted">0 hoặc để trống = Không giới hạn</small>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Quick Stats -->
                        <div>
                            <h6 class="fs-13 text-uppercase text-muted fw-bold mb-2">Thống kê bài kiểm tra</h6>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Tổng số câu hỏi:</span>
                                <span class="badge bg-primary fs-12" id="stat-total-q">{{ $test->questions->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Câu 1 đáp án:</span>
                                <span class="badge bg-info fs-12" id="stat-single-q">{{ $test->questions->where('type', 'single_choice')->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Câu nhiều đáp án:</span>
                                <span class="badge bg-purple text-white fs-12" style="background-color: #6f42c1;" id="stat-multi-q">{{ $test->questions->where('type', 'multiple_choice')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation Pills Card -->
                <div class="card mb-3 position-sticky" style="top: 80px;">
                    <div class="card-header bg-light d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 fs-14">
                            <i class="ri-list-check text-success me-1"></i> Danh mục câu hỏi
                        </h5>
                        <small class="text-muted">Nhấn số để tới câu đó</small>
                    </div>
                    <div class="card-body p-2">
                        <div class="nav-pills-questions" id="quickNavContainer">
                            <!-- Injected by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Questions and Answers List -->
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header bg-light d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="card-title mb-0 fs-15">
                                <i class="ri-questionnaire-line text-primary me-1"></i> Nội dung các câu hỏi & đáp án
                            </h5>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" id="searchQuestionInput" class="form-control" placeholder="Tìm câu hỏi...">
                                <span class="input-group-text"><i class="ri-search-line"></i></span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnCollapseAll" title="Thu gọn tất cả">
                                <i class="ri-arrow-up-s-line me-1"></i> Thu gọn
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnExpandAll" title="Mở rộng tất cả">
                                <i class="ri-arrow-down-s-line me-1"></i> Mở rộng
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" id="btnAddQuestionMain">
                                <i class="ri-add-line me-1"></i> Thêm câu hỏi
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <div id="questionsContainer">
                            @foreach($test->questions as $qIndex => $question)
                                @php
                                    $qOrder = $qIndex + 1;
                                    $isMulti = $question->type === 'multiple_choice';
                                @endphp
                                <div class="question-card" id="question_card_{{ $question->id }}" data-question-id="{{ $question->id }}" data-order="{{ $qOrder }}">
                                    <!-- Header -->
                                    <div class="question-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2 flex-grow-1 text-truncate me-2" onclick="toggleQuestionCard(this)">
                                            <i class="ri-arrow-down-s-line collapse-icon fs-16 text-muted"></i>
                                            <span class="badge bg-primary fs-12 q-badge-order">Câu {{ $qOrder }}</span>
                                            <span class="badge {{ $isMulti ? 'bg-purple text-white' : 'bg-info' }} fs-11 q-badge-type" style="{{ $isMulti ? 'background-color: #6f42c1 !important;' : '' }}">
                                                {{ $isMulti ? 'Nhiều đáp án' : '1 đáp án' }}
                                            </span>
                                            <span class="text-muted fs-13 text-truncate q-preview-text">
                                                {{ $question->content }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <button type="button" class="btn btn-link link-secondary p-1" onclick="moveQuestion(this, -1)" title="Chuyển lên">
                                                <i class="ri-arrow-up-line fs-14"></i>
                                            </button>
                                            <button type="button" class="btn btn-link link-secondary p-1" onclick="moveQuestion(this, 1)" title="Chuyển xuống">
                                                <i class="ri-arrow-down-line fs-14"></i>
                                            </button>
                                            <button type="button" class="btn btn-link link-primary p-1" onclick="duplicateQuestion(this)" title="Nhân bản câu này">
                                                <i class="ri-file-copy-line fs-14"></i>
                                            </button>
                                            <button type="button" class="btn btn-link link-danger p-1" onclick="deleteQuestion(this)" title="Xóa câu hỏi">
                                                <i class="ri-delete-bin-line fs-14"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Body -->
                                    <div class="question-body p-3">
                                        <div class="row mb-3">
                                            <div class="col-md-9 mb-2 mb-md-0">
                                                <label class="form-label fw-bold fs-13">
                                                    Nội dung câu hỏi <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control question-content" rows="2" placeholder="Nhập nội dung câu hỏi..." oninput="updateQuestionPreview(this)" required>{{ $question->content }}</textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold fs-13">Hình thức đáp án</label>
                                                <select class="form-select form-select-sm question-type" onchange="handleQuestionTypeChange(this)">
                                                    <option value="single_choice" {{ !$isMulti ? 'selected' : '' }}>1 đáp án đúng</option>
                                                    <option value="multiple_choice" {{ $isMulti ? 'selected' : '' }}>Nhiều đáp án đúng</option>
                                                </select>
                                                <small class="text-muted d-block mt-1">1 đáp án dùng nút tròn, nhiều đáp án dùng ô vuông.</small>
                                            </div>
                                        </div>

                                        <!-- Answers list -->
                                        <div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <label class="form-label fw-bold fs-13 mb-0">
                                                    Danh sách đáp án <span class="text-muted fw-normal">(Tích chọn ô để đặt đáp án ĐÚNG)</span>:
                                                </label>
                                                <button type="button" class="btn btn-outline-success btn-sm py-0 px-2 fs-12" onclick="addAnswerRow(this)">
                                                    <i class="ri-add-line"></i> Thêm đáp án
                                                </button>
                                            </div>

                                            <div class="answers-container">
                                                @foreach($question->answers as $aIndex => $answer)
                                                    <div class="answer-row d-flex align-items-center gap-2 {{ $answer->is_correct ? 'is-correct' : '' }}" data-answer-id="{{ $answer->id }}">
                                                        <div>
                                                            <input type="{{ $isMulti ? 'checkbox' : 'radio' }}" 
                                                                   name="correct_q_{{ $question->id }}" 
                                                                   class="answer-correct-check" 
                                                                   title="Tích chọn nếu là đáp án đúng"
                                                                   {{ $answer->is_correct ? 'checked' : '' }}
                                                                   onchange="handleCorrectCheckChange(this)">
                                                        </div>
                                                        <div>
                                                            <input type="text" class="form-control form-control-sm answer-label text-center fw-bold px-1" 
                                                                   value="{{ $answer->label ?: chr(65 + ($aIndex % 26)) }}" 
                                                                   style="width: 38px;" title="Nhãn (A, B, C...)">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <input type="text" class="form-control form-control-sm answer-content" 
                                                                   value="{{ $answer->content }}" 
                                                                   placeholder="Nội dung đáp án..." required>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-sm btn-outline-danger p-1" onclick="deleteAnswerRow(this)" title="Xóa đáp án">
                                                                <i class="ri-close-line fs-14"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Empty state if 0 questions -->
                        <div id="noQuestionsNotice" class="text-center py-5 {{ $test->questions->count() > 0 ? 'd-none' : '' }}">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title bg-light text-primary rounded-circle fs-36">
                                    <i class="ri-questionnaire-line"></i>
                                </div>
                            </div>
                            <h5>Chưa có câu hỏi nào trong bài test</h5>
                            <p class="text-muted">Nhấn nút bên dưới để bắt đầu tạo câu hỏi mới cho bài kiểm tra này.</p>
                            <button type="button" class="btn btn-primary" onclick="addNewQuestion()">
                                <i class="ri-add-line me-1"></i> Thêm câu hỏi đầu tiên
                            </button>
                        </div>

                        <!-- Bottom Add Button -->
                        <div class="text-center mt-3 pt-3 border-top">
                            <button type="button" class="btn btn-outline-primary" onclick="addNewQuestion()">
                                <i class="ri-add-line me-1"></i> Thêm câu hỏi mới
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sticky Bottom Action Bar -->
                <div class="sticky-bottom-actions d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-13 text-muted">Tổng số:</span>
                        <span class="badge bg-primary fs-13" id="bottom-q-badge">{{ $test->questions->count() }} câu hỏi</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addNewQuestion()">
                            <i class="ri-add-line me-1"></i> Thêm câu hỏi
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm btn-submit-form">
                            <i class="ri-save-line me-1"></i> Lưu thay đổi
                        </button>
                        <button type="submit" name="save_and_exit" value="1" class="btn btn-success btn-sm btn-submit-form">
                            <i class="ri-check-line me-1"></i> Lưu & Thoát
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initQuickNav();
        updateStats();

        // Xử lý thêm nhanh Topic
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

            nameInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    btnQuickAdd.click();
                }
            });
        }

        // Top button add question
        const btnAddTop = document.getElementById('btn-add-question-top');
        if (btnAddTop) {
            btnAddTop.addEventListener('click', addNewQuestion);
        }

        const btnAddMain = document.getElementById('btnAddQuestionMain');
        if (btnAddMain) {
            btnAddMain.addEventListener('click', addNewQuestion);
        }

        // Expand / Collapse all
        document.getElementById('btnExpandAll').addEventListener('click', function () {
            document.querySelectorAll('.question-card').forEach(card => card.classList.remove('collapsed'));
        });

        document.getElementById('btnCollapseAll').addEventListener('click', function () {
            document.querySelectorAll('.question-card').forEach(card => card.classList.add('collapsed'));
        });

        // Search question
        const searchInput = document.getElementById('searchQuestionInput');
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.question-card').forEach(card => {
                const text = card.querySelector('.question-content').value.toLowerCase();
                const preview = card.querySelector('.q-preview-text').textContent.toLowerCase();
                if (!query || text.includes(query) || preview.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Intercept form submission to serialize questions
        const form = document.getElementById('editTestForm');
        form.addEventListener('submit', function (e) {
            const questions = [];
            const questionCards = document.querySelectorAll('.question-card');
            let hasError = false;
            let errorMessage = '';

            questionCards.forEach((qCard, qIdx) => {
                const qId = qCard.dataset.questionId || null;
                const qContentInput = qCard.querySelector('.question-content');
                const qContent = qContentInput.value.trim();
                const qType = qCard.querySelector('.question-type').value;

                if (!qContent) {
                    hasError = true;
                    errorMessage = `Câu ${qIdx + 1} đang để trống nội dung câu hỏi!`;
                    qCard.classList.remove('collapsed');
                    qContentInput.focus();
                    return;
                }

                const answers = [];
                let correctCount = 0;
                const answerRows = qCard.querySelectorAll('.answer-row');

                if (answerRows.length < 2) {
                    hasError = true;
                    errorMessage = `Câu ${qIdx + 1} phải có ít nhất 2 đáp án!`;
                    qCard.classList.remove('collapsed');
                    return;
                }

                answerRows.forEach((aRow, aIdx) => {
                    const aId = aRow.dataset.answerId || null;
                    const aLabel = aRow.querySelector('.answer-label').value.trim() || String.fromCharCode(65 + aIdx);
                    const aContent = aRow.querySelector('.answer-content').value.trim();
                    const isCorrect = aRow.querySelector('.answer-correct-check').checked;

                    if (!aContent) {
                        hasError = true;
                        errorMessage = `Câu ${qIdx + 1}, đáp án ${aLabel} chưa có nội dung!`;
                        qCard.classList.remove('collapsed');
                        aRow.querySelector('.answer-content').focus();
                        return;
                    }

                    if (isCorrect) correctCount++;

                    answers.push({
                        id: aId,
                        label: aLabel,
                        content: aContent,
                        is_correct: isCorrect ? 1 : 0
                    });
                });

                if (hasError) return;

                if (correctCount === 0) {
                    hasError = true;
                    errorMessage = `Câu ${qIdx + 1} chưa chọn đáp án đúng nào! Vui lòng tích chọn ít nhất 1 đáp án đúng.`;
                    qCard.classList.remove('collapsed');
                    return;
                }

                questions.push({
                    id: qId,
                    content: qContent,
                    type: qType,
                    order: qIdx + 1,
                    answers: answers
                });
            });

            if (hasError) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông tin chưa hợp lệ',
                        text: errorMessage,
                        confirmButtonText: 'Đã hiểu'
                    });
                } else {
                    alert(errorMessage);
                }
                return false;
            }

            // Put serialized JSON into hidden input
            document.getElementById('questions_data_input').value = JSON.stringify(questions);
        });
    });

    // Toggle card body collapse
    function toggleQuestionCard(el) {
        const card = el.closest('.question-card');
        card.classList.toggle('collapsed');
    }

    // Update real-time preview in card header
    function updateQuestionPreview(textarea) {
        const card = textarea.closest('.question-card');
        const preview = card.querySelector('.q-preview-text');
        preview.textContent = textarea.value.trim() || '(Nội dung câu hỏi trống)';
    }

    // Handle change of question type (single vs multiple)
    function handleQuestionTypeChange(select) {
        const card = select.closest('.question-card');
        const isMulti = select.value === 'multiple_choice';
        const typeBadge = card.querySelector('.q-badge-type');
        const qId = card.dataset.questionId || 'new_' + Math.random().toString(36).substr(2, 9);

        if (isMulti) {
            typeBadge.textContent = 'Nhiều đáp án';
            typeBadge.className = 'badge bg-purple text-white fs-11 q-badge-type';
            typeBadge.style.backgroundColor = '#6f42c1';
        } else {
            typeBadge.textContent = '1 đáp án';
            typeBadge.className = 'badge bg-info fs-11 q-badge-type';
            typeBadge.style.backgroundColor = '';
        }

        // Change inputs
        const checks = card.querySelectorAll('.answer-correct-check');
        let foundFirst = false;
        checks.forEach(input => {
            input.type = isMulti ? 'checkbox' : 'radio';
            input.name = `correct_q_${qId}`;
            if (!isMulti) {
                if (input.checked) {
                    if (foundFirst) {
                        input.checked = false;
                        input.closest('.answer-row').classList.remove('is-correct');
                    } else {
                        foundFirst = true;
                    }
                }
            }
        });

        updateStats();
    }

    // Handle change of is_correct checkbox/radio
    function handleCorrectCheckChange(input) {
        const card = input.closest('.question-card');
        const isMulti = card.querySelector('.question-type').value === 'multiple_choice';
        const answerRows = card.querySelectorAll('.answer-row');

        if (!isMulti) {
            // Radio behavior: highlight only the selected row
            answerRows.forEach(row => {
                const check = row.querySelector('.answer-correct-check');
                if (check === input) {
                    row.classList.add('is-correct');
                } else {
                    check.checked = false;
                    row.classList.remove('is-correct');
                }
            });
        } else {
            // Checkbox behavior
            const row = input.closest('.answer-row');
            if (input.checked) {
                row.classList.add('is-correct');
            } else {
                row.classList.remove('is-correct');
            }

            // Auto-detect: if user checked multiple answers while on single_choice
            const checkedCount = card.querySelectorAll('.answer-correct-check:checked').length;
            if (checkedCount > 1 && !isMulti) {
                const typeSelect = card.querySelector('.question-type');
                typeSelect.value = 'multiple_choice';
                handleQuestionTypeChange(typeSelect);
            }
        }
    }

    // Add new answer row
    function addAnswerRow(btn) {
        const container = btn.closest('.question-body').querySelector('.answers-container');
        const card = btn.closest('.question-card');
        const isMulti = card.querySelector('.question-type').value === 'multiple_choice';
        const qId = card.dataset.questionId || 'new_' + Math.random().toString(36).substr(2, 9);
        const count = container.querySelectorAll('.answer-row').length;
        const nextLabel = String.fromCharCode(65 + (count % 26));

        const row = document.createElement('div');
        row.className = 'answer-row d-flex align-items-center gap-2';
        row.innerHTML = `
            <div>
                <input type="${isMulti ? 'checkbox' : 'radio'}" 
                       name="correct_q_${qId}" 
                       class="answer-correct-check" 
                       title="Tích chọn nếu là đáp án đúng"
                       onchange="handleCorrectCheckChange(this)">
            </div>
            <div>
                <input type="text" class="form-control form-control-sm answer-label text-center fw-bold px-1" 
                       value="${nextLabel}" 
                       style="width: 38px;" title="Nhãn (A, B, C...)">
            </div>
            <div class="flex-grow-1">
                <input type="text" class="form-control form-control-sm answer-content" 
                       placeholder="Nội dung đáp án..." required>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-outline-danger p-1" onclick="deleteAnswerRow(this)" title="Xóa đáp án">
                    <i class="ri-close-line fs-14"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.answer-content').focus();
    }

    // Delete answer row
    function deleteAnswerRow(btn) {
        const container = btn.closest('.answers-container');
        if (container.querySelectorAll('.answer-row').length <= 2) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    text: 'Mỗi câu hỏi cần tối thiểu 2 đáp án lựa chọn.',
                    confirmButtonText: 'Đã hiểu'
                });
            } else {
                alert('Mỗi câu hỏi cần tối thiểu 2 đáp án lựa chọn.');
            }
            return;
        }

        const row = btn.closest('.answer-row');
        row.remove();
    }

    // Add new blank question
    function addNewQuestion() {
        const container = document.getElementById('questionsContainer');
        const count = container.querySelectorAll('.question-card').length;
        const newOrder = count + 1;
        const tempId = 'new_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);

        const card = document.createElement('div');
        card.className = 'question-card active-target';
        card.id = `question_card_${tempId}`;
        card.dataset.order = newOrder;

        card.innerHTML = `
            <div class="question-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-grow-1 text-truncate me-2" onclick="toggleQuestionCard(this)">
                    <i class="ri-arrow-down-s-line collapse-icon fs-16 text-muted"></i>
                    <span class="badge bg-primary fs-12 q-badge-order">Câu ${newOrder}</span>
                    <span class="badge bg-info fs-11 q-badge-type">1 đáp án</span>
                    <span class="text-muted fs-13 text-truncate q-preview-text">
                        (Câu hỏi mới chưa có nội dung)
                    </span>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button type="button" class="btn btn-link link-secondary p-1" onclick="moveQuestion(this, -1)" title="Chuyển lên">
                        <i class="ri-arrow-up-line fs-14"></i>
                    </button>
                    <button type="button" class="btn btn-link link-secondary p-1" onclick="moveQuestion(this, 1)" title="Chuyển xuống">
                        <i class="ri-arrow-down-line fs-14"></i>
                    </button>
                    <button type="button" class="btn btn-link link-primary p-1" onclick="duplicateQuestion(this)" title="Nhân bản câu này">
                        <i class="ri-file-copy-line fs-14"></i>
                    </button>
                    <button type="button" class="btn btn-link link-danger p-1" onclick="deleteQuestion(this)" title="Xóa câu hỏi">
                        <i class="ri-delete-bin-line fs-14"></i>
                    </button>
                </div>
            </div>

            <div class="question-body p-3">
                <div class="row mb-3">
                    <div class="col-md-9 mb-2 mb-md-0">
                        <label class="form-label fw-bold fs-13">
                            Nội dung câu hỏi <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control question-content" rows="2" placeholder="Nhập nội dung câu hỏi..." oninput="updateQuestionPreview(this)" required></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold fs-13">Hình thức đáp án</label>
                        <select class="form-select form-select-sm question-type" onchange="handleQuestionTypeChange(this)">
                            <option value="single_choice" selected>1 đáp án đúng</option>
                            <option value="multiple_choice">Nhiều đáp án đúng</option>
                        </select>
                        <small class="text-muted d-block mt-1">1 đáp án dùng nút tròn, nhiều đáp án dùng ô vuông.</small>
                    </div>
                </div>

                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label fw-bold fs-13 mb-0">
                            Danh sách đáp án <span class="text-muted fw-normal">(Tích chọn ô để đặt đáp án ĐÚNG)</span>:
                        </label>
                        <button type="button" class="btn btn-outline-success btn-sm py-0 px-2 fs-12" onclick="addAnswerRow(this)">
                            <i class="ri-add-line"></i> Thêm đáp án
                        </button>
                    </div>

                    <div class="answers-container">
                        ${['A', 'B', 'C', 'D'].map((label, idx) => `
                            <div class="answer-row d-flex align-items-center gap-2 ${idx === 0 ? 'is-correct' : ''}">
                                <div>
                                    <input type="radio" 
                                           name="correct_q_${tempId}" 
                                           class="answer-correct-check" 
                                           title="Tích chọn nếu là đáp án đúng"
                                           ${idx === 0 ? 'checked' : ''}
                                           onchange="handleCorrectCheckChange(this)">
                                </div>
                                <div>
                                    <input type="text" class="form-control form-control-sm answer-label text-center fw-bold px-1" 
                                           value="${label}" 
                                           style="width: 38px;" title="Nhãn (A, B, C...)">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control form-control-sm answer-content" 
                                           placeholder="Nội dung đáp án ${label}..." required>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-danger p-1" onclick="deleteAnswerRow(this)" title="Xóa đáp án">
                                        <i class="ri-close-line fs-14"></i>
                                    </button>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;

        container.appendChild(card);
        document.getElementById('noQuestionsNotice').classList.add('d-none');

        // Scroll and focus
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            card.classList.remove('active-target');
            card.querySelector('.question-content').focus();
        }, 600);

        reindexQuestions();
    }

    // Duplicate question
    function duplicateQuestion(btn) {
        const sourceCard = btn.closest('.question-card');
        const clone = sourceCard.cloneNode(true);
        delete clone.dataset.questionId;
        clone.removeAttribute('id');

        const tempId = 'dup_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
        clone.id = `question_card_${tempId}`;

        // Clear answer IDs on cloned rows
        clone.querySelectorAll('.answer-row').forEach(row => {
            delete row.dataset.answerId;
        });

        // Update radio names
        const isMulti = clone.querySelector('.question-type').value === 'multiple_choice';
        clone.querySelectorAll('.answer-correct-check').forEach(input => {
            input.name = `correct_q_${tempId}`;
        });

        sourceCard.after(clone);
        clone.scrollIntoView({ behavior: 'smooth', block: 'center' });
        clone.classList.add('active-target');
        setTimeout(() => clone.classList.remove('active-target'), 1000);

        reindexQuestions();
    }

    // Delete question
    function deleteQuestion(btn) {
        const card = btn.closest('.question-card');
        const order = card.dataset.order;

        const doDelete = () => {
            card.remove();
            reindexQuestions();
            const container = document.getElementById('questionsContainer');
            if (container.querySelectorAll('.question-card').length === 0) {
                document.getElementById('noQuestionsNotice').classList.remove('d-none');
            }
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: `Xác nhận xóa Câu ${order}?`,
                text: "Câu hỏi này và tất cả các đáp án đi kèm sẽ bị xóa.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Xóa câu này',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    doDelete();
                }
            });
        } else {
            if (confirm(`Bạn có chắc muốn xóa Câu ${order}?`)) {
                doDelete();
            }
        }
    }

    // Move question up / down
    function moveQuestion(btn, direction) {
        const card = btn.closest('.question-card');
        if (direction === -1 && card.previousElementSibling && card.previousElementSibling.classList.contains('question-card')) {
            card.parentNode.insertBefore(card, card.previousElementSibling);
            reindexQuestions();
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (direction === 1 && card.nextElementSibling && card.nextElementSibling.classList.contains('question-card')) {
            card.parentNode.insertBefore(card.nextElementSibling, card);
            reindexQuestions();
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Re-index question badges and orders
    function reindexQuestions() {
        const cards = document.querySelectorAll('.question-card');
        cards.forEach((card, index) => {
            const order = index + 1;
            card.dataset.order = order;
            const badge = card.querySelector('.q-badge-order');
            if (badge) badge.textContent = `Câu ${order}`;
        });
        initQuickNav();
        updateStats();
    }

    // Quick Navigator pills
    function initQuickNav() {
        const container = document.getElementById('quickNavContainer');
        if (!container) return;
        container.innerHTML = '';

        const cards = document.querySelectorAll('.question-card');
        cards.forEach((card, index) => {
            const order = index + 1;
            const a = document.createElement('a');
            a.className = 'nav-pill-q';
            a.href = '#';
            a.textContent = order;
            a.title = `Tới Câu ${order}`;
            a.addEventListener('click', function (e) {
                e.preventDefault();
                card.classList.remove('collapsed');
                card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                card.classList.add('active-target');
                setTimeout(() => card.classList.remove('active-target'), 1200);
            });
            container.appendChild(a);
        });
    }

    // Update stats counters
    function updateStats() {
        const total = document.querySelectorAll('.question-card').length;
        let single = 0;
        let multi = 0;

        document.querySelectorAll('.question-card').forEach(card => {
            const type = card.querySelector('.question-type').value;
            if (type === 'multiple_choice') multi++;
            else single++;
        });

        const statTotal = document.getElementById('stat-total-q');
        const statSingle = document.getElementById('stat-single-q');
        const statMulti = document.getElementById('stat-multi-q');
        const bottomBadge = document.getElementById('bottom-q-badge');

        if (statTotal) statTotal.textContent = total;
        if (statSingle) statSingle.textContent = single;
        if (statMulti) statMulti.textContent = multi;
        if (bottomBadge) bottomBadge.textContent = `${total} câu hỏi`;
    }
</script>
@endpush
