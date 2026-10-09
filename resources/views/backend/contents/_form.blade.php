@csrf

@php
    $currentImage = old('existing_image', $post->image ?? '');
    $imagePreview = $currentImage ? asset($currentImage) : '';
    $isCourse = in_array($type, ['course', 'product']);
@endphp

<div
    class="row backend-content-form"
    id="backend-content-form"
    data-url-base="{{ url('/') }}"
    data-slug-prefix="{{ $isCourse ? 'courses' : 'tin-tuc' }}"
>
    <div class="col-xl-9">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ $isCourse ? 'Course Title' : 'Tieu de' }}</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug ?? '') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if (! $isCourse)
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="summary" class="form-label">{{ $isCourse ? 'Short Description / Overview' : 'Mo ta ngan' }}</label>
                            <textarea id="summary" name="summary" rows="3" class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $post->summary ?? '') }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif



                    

                    @if ($isCourse)
                        <div class="col-12">
                            <div class="mb-0">
                                <ul class="nav nav-tabs" id="courseContentTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary-tab-pane" type="button" role="tab" aria-controls="summary-tab-pane" aria-selected="true">Short Description / Overview</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab" aria-controls="content-tab-pane" aria-selected="false">Nội dung khóa học</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="what-to-learn-tab" data-bs-toggle="tab" data-bs-target="#what-to-learn-tab-pane" type="button" role="tab" aria-controls="what-to-learn-tab-pane" aria-selected="false">Bạn sẽ học được gì</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="course-includes-tab" data-bs-toggle="tab" data-bs-target="#course-includes-tab-pane" type="button" role="tab" aria-controls="course-includes-tab-pane" aria-selected="false">Khóa học này bao gồm</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="course-requirements-tab" data-bs-toggle="tab" data-bs-target="#course-requirements-tab-pane" type="button" role="tab" aria-controls="course-requirements-tab-pane" aria-selected="false">Yêu cầu khóa học</button>
                                    </li>
                                </ul>
                                <div class="tab-content border border-top-0 p-3" id="courseContentTabsContent">
                                    <div class="tab-pane fade show active" id="summary-tab-pane" role="tabpanel" aria-labelledby="summary-tab" tabindex="0">
                                        <label for="summary" class="visually-hidden">Short Description / Overview</label>
                                        <textarea id="summary" name="summary" rows="8" class="form-control editor @error('summary') is-invalid @enderror">{{ old('summary', $post->summary ?? '') }}</textarea>
                                        @error('summary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                                        <textarea id="content" name="content" rows="8" class="form-control editor @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="what-to-learn-tab-pane" role="tabpanel" aria-labelledby="what-to-learn-tab" tabindex="0">
                                        <textarea id="what_to_learn" name="what_to_learn" rows="8" class="form-control editor @error('what_to_learn') is-invalid @enderror">{{ old('what_to_learn', $post->what_to_learn ?? '') }}</textarea>
                                        @error('what_to_learn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="course-includes-tab-pane" role="tabpanel" aria-labelledby="course-includes-tab" tabindex="0">
                                        <textarea id="course_includes" name="course_includes" rows="8" class="form-control editor @error('course_includes') is-invalid @enderror">{{ old('course_includes', $post->course_includes ?? '') }}</textarea>
                                        @error('course_includes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="course-requirements-tab-pane" role="tabpanel" aria-labelledby="course-requirements-tab" tabindex="0">
                                        <textarea id="course_requirements" name="course_requirements" rows="8" class="form-control editor @error('course_requirements') is-invalid @enderror">{{ old('course_requirements', $post->course_requirements ?? '') }}</textarea>
                                        @error('course_requirements')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="mb-0">
                                <label for="content" class="form-label">Noi dung</label>
                                <textarea id="content" name="content" rows="8" class="form-control editor @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border">
            <div class="card-header">
                <h5 class="card-title mb-0">Cau hinh SEO</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="seo_title" class="form-label">Title</label>
                            <input type="text" id="seo_title" name="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title', $post->seo_title ?? '') }}" placeholder="Nhap SEO title">
                            @error('seo_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="seo_description" class="form-label">Description</label>
                            <textarea id="seo_description" name="seo_description" rows="3" class="form-control @error('seo_description') is-invalid @enderror" placeholder="Nhap SEO description">{{ old('seo_description', $post->seo_description ?? '') }}</textarea>
                            @error('seo_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="form-label mb-0">Hien thi</label>
                            </div>
                            <div class="col-lg-10">
                                <div id="seo-link-preview" class="text-muted">{{ url('/') }}/san-pham/slug</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="col-xl-3">
        <div class="card border">
            <div class="card-body">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Khong chon</option>
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" {{ (string) old('category_id', $post->category_id ?? '') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($isCourse)
                    <div class="mb-3">
                        <label for="seller_id" class="form-label">Instructor / Teacher</label>
                        <div class="d-flex gap-2 align-items-start">
                            <div class="flex-grow-1">
                                <select id="seller_id" name="seller_id" class="form-select @error('seller_id') is-invalid @enderror">
                                    <option value="">Select Instructor / Teacher</option>
                                    @foreach ($sellerOptions as $id => $name)
                                        <option value="{{ $id }}" {{ (string) old('seller_id', $post->seller_id ?? '') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('seller_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#quickAddInstructorModal" title="Thêm nhanh">
                                <i class="ri-add-line"></i> Thêm
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="topic_ids" class="form-label">Topic (Chủ đề)</label>
                        <div class="d-flex gap-2 align-items-start">
                            <div class="flex-grow-1">
                                <div class="border rounded p-2 @error('topic_ids') border-danger @enderror" style="max-height: 200px; overflow-y: auto;" id="topic_checkboxes_container">
                                    @php
                                        $currentTopics = old('topic_ids', $selectedTopics ?? []);
                                    @endphp
                                    @foreach ($topicOptions ?? [] as $id => $name)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="topic_ids[]" value="{{ $id }}" id="topic_{{ $id }}" {{ in_array($id, $currentTopics) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="topic_{{ $id }}">
                                                {{ $name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('topic_ids')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#quickAddTopicModal" title="Thêm nhanh">
                                <i class="ri-add-line"></i> Thêm
                            </button>
                        </div>
                    </div>
                @endif


                <div class="card border mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $isCourse ? 'Course Thumbnail' : 'Hinh anh' }}</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="existing_image" value="{{ $currentImage }}">
                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                        <input type="file" id="image_file" name="image_file" class="d-none" accept="image/*">
                        

                        <div class="d-flex flex-column gap-2">
                            <button type="button" id="image-preview-box" class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden p-0 w-100 content-image-dropzone content-image-dropzone--cover">
                                <img id="image-preview" src="{{ $imagePreview }}" alt="Preview" class="w-100 h-100 object-fit-cover {{ $imagePreview ? '' : 'd-none' }}">
                                <div id="image-placeholder" class="text-center text-muted px-3 {{ $imagePreview ? 'd-none' : '' }}">
                                    <div class="display-6 mb-2">
                                        <i class="ri-image-line"></i>
                                    </div>
                                    <div class="fw-semibold">NO IMAGE</div>
                                    <div>{{ $isCourse ? 'Click or drop thumbnail here' : 'Click hoac drop anh vao day' }}</div>
                                </div>
                            </button>
                            <button type="button" id="remove-image-trigger" class="btn btn-soft-danger btn-sm align-self-start {{ $imagePreview ? '' : 'd-none' }}">{{ $isCourse ? 'Remove Thumbnail' : 'Bo anh dai dien' }}</button>
                        </div>

                        @error('image_file')
                            <div class="text-danger small mt-3">{{ $message }}</div>
                        @enderror

                        
                    </div>
                </div>

                @if ($isCourse)
                    <div class="card border mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Tài liệu bài học (PDF / PPTX)</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $currentPdf = old('existing_pdf_file', $post->pdf_file ?? '');
                            @endphp
                            <input type="hidden" name="existing_pdf_file" value="{{ $currentPdf }}">
                            <input type="hidden" name="remove_pdf_file" id="remove_pdf_file" value="0">
                            <input type="file" id="pdf_file_input" name="pdf_file_input" class="d-none" accept=".pdf,.pptx,application/pdf,application/vnd.openxmlformats-officedocument.presentationml.presentation">

                            <div class="d-flex flex-column gap-2">
                                <button type="button" id="pdf-preview-box" class="border rounded bg-light d-flex flex-column align-items-center justify-content-center overflow-hidden p-3 w-100 text-center" style="min-height: 140px; border-style: dashed !important; border-color: #cbd5e1 !important;">
                                    <div id="pdf-file-display" class="{{ $currentPdf ? '' : 'd-none' }} w-100">
                                        <div class="display-6 mb-2 text-danger">
                                            <i class="ri-file-pdf-2-line"></i>
                                        </div>
                                        <div class="fw-semibold text-dark text-truncate px-2 mb-1" id="pdf-filename">
                                            {{ $currentPdf ? basename($currentPdf) : '' }}
                                        </div>
                                        <span class="badge bg-soft-success text-success mb-2">Đã tải tài liệu lên</span>
                                        @if ($currentPdf)
                                            <div>
                                                <a href="{{ asset($currentPdf) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1" onclick="event.stopPropagation()">Xem file tài liệu</a>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="pdf-placeholder" class="text-center text-muted px-3 {{ $currentPdf ? 'd-none' : '' }}">
                                        <div class="display-6 mb-2 text-primary">
                                            <i class="ri-upload-cloud-2-line"></i>
                                        </div>
                                        <div class="fw-semibold text-dark">Click hoặc thả file PDF / PPTX vào đây</div>
                                        <div class="small text-muted mt-1">Hỗ trợ tài liệu bài giảng cho học viên</div>
                                    </div>
                                </button>
                                <button type="button" id="remove-pdf-trigger" class="btn btn-soft-danger btn-sm align-self-start {{ $currentPdf ? '' : 'd-none' }}">
                                    Bỏ tài liệu bài giảng
                                </button>
                            </div>

                            @error('pdf_file_input')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $post->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ $isCourse ? 'Active Course' : 'Hien thi ' . strtolower($typeLabel) }}</label>
                </div>

                @if ($isCourse)
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured Course</label>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@if ($isCourse)
    <div class="modal fade" id="quickAddInstructorModal" tabindex="-1" aria-labelledby="quickAddInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickAddInstructorModalLabel">Thêm nhanh Instructor / Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quick_add_instructor_name" class="form-label">Tên Instructor</label>
                        <input type="text" class="form-control" id="quick_add_instructor_name" placeholder="Nhập tên...">
                        <div class="invalid-feedback" id="quick_add_instructor_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btn-quick-add-instructor">Lưu và Chọn</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#btn-quick-add-instructor').on('click', function() {
                    const nameInput = $('#quick_add_instructor_name');
                    const name = nameInput.val().trim();
                    const errorFeedback = $('#quick_add_instructor_error');
                    
                    if (!name) {
                        nameInput.addClass('is-invalid');
                        errorFeedback.text('Vui lòng nhập tên Instructor.');
                        return;
                    }
                    
                    nameInput.removeClass('is-invalid');
                    errorFeedback.text('');
                    
                    const btn = $(this);
                    btn.prop('disabled', true).text('Đang lưu...');
                    
                    $.ajax({
                        url: '{{ route("backend.users.quick-add") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: name
                        },
                        success: function(response) {
                            if (response.success) {
                                // Add to select
                                const newOption = new Option(response.user.name, response.user.id, true, true);
                                $('#seller_id').append(newOption).trigger('change');
                                
                                // Close modal & reset
                                $('#quickAddInstructorModal').modal('hide');
                                nameInput.val('');
                            }
                        },
                        error: function(xhr) {
                            nameInput.addClass('is-invalid');
                            if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.name) {
                                errorFeedback.text(xhr.responseJSON.errors.name[0]);
                            } else {
                                errorFeedback.text('Có lỗi xảy ra, vui lòng thử lại.');
                            }
                        },
                        complete: function() {
                            btn.prop('disabled', false).text('Lưu và Chọn');
                        }
                    });
                });
            });
        </script>
    @endpush
@endif

@if ($isCourse)
    <div class="modal fade" id="quickAddTopicModal" tabindex="-1" aria-labelledby="quickAddTopicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickAddTopicModalLabel">Thêm nhanh Topic (Chủ đề)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quick_add_topic_name" class="form-label">Tên Chủ đề</label>
                        <input type="text" class="form-control" id="quick_add_topic_name" placeholder="Nhập tên chủ đề...">
                        <div class="invalid-feedback" id="quick_add_topic_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btn-quick-add-topic">Lưu và Chọn</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#btn-quick-add-topic').on('click', function() {
                    const nameInput = $('#quick_add_topic_name');
                    const name = nameInput.val().trim();
                    const errorFeedback = $('#quick_add_topic_error');
                    
                    if (!name) {
                        nameInput.addClass('is-invalid');
                        errorFeedback.text('Vui lòng nhập tên Chủ đề.');
                        return;
                    }
                    
                    nameInput.removeClass('is-invalid');
                    errorFeedback.text('');
                    
                    const btn = $(this);
                    btn.prop('disabled', true).text('Đang lưu...');
                    
                    $.ajax({
                        url: '{{ route("backend.topics.quick-add") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: name
                        },
                        success: function(response) {
                            if (response.success) {
                                // Add to checkboxes
                                const newCheckboxHtml = `
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="topic_ids[]" value="${response.topic.id}" id="topic_${response.topic.id}" checked>
                                        <label class="form-check-label" for="topic_${response.topic.id}">
                                            ${response.topic.name}
                                        </label>
                                    </div>
                                `;
                                $('#topic_checkboxes_container').append(newCheckboxHtml);
                                
                                // Close modal & reset
                                $('#quickAddTopicModal').modal('hide');
                                nameInput.val('');
                            }
                        },
                        error: function(xhr) {
                            nameInput.addClass('is-invalid');
                            if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.name) {
                                errorFeedback.text(xhr.responseJSON.errors.name[0]);
                            } else {
                                errorFeedback.text('Có lỗi xảy ra, vui lòng thử lại.');
                            }
                        },
                        complete: function() {
                            btn.prop('disabled', false).text('Lưu và Chọn');
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
