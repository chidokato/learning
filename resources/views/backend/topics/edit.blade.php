@extends('backend.layouts.app')

@section('title', 'Sửa Chủ đề')
@section('page_title', 'Sửa Chủ đề')
@section('breadcrumb', 'Sửa Chủ đề')

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Sửa Chủ đề</h4>
                    <a href="{{ route('backend.topics.index') }}" class="btn btn-light btn-sm">Quay lại</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.topics.update', $topic) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Phân loại Topic <span class="text-danger">*</span></label>
                            <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="course" {{ old('type', $topic->type ?? 'course') === 'course' ? 'selected' : '' }}>Khóa học (Dành riêng cho Khóa học)</option>
                                <option value="test" {{ old('type', $topic->type ?? 'course') === 'test' ? 'selected' : '' }}>Bài kiểm tra (Dành riêng cho Đề thi / Test)</option>
                            </select>
                            <small class="text-muted">Phân loại giúp hiển thị đúng topic trong mục Khóa học hoặc Bài test.</small>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Tên Chủ đề <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $topic->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug (Tùy chọn)</label>
                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $topic->slug) }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card border mb-3">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Cấu hình SEO</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="seo_title" class="form-label">SEO Title</label>
                                    <input type="text" id="seo_title" name="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title', $topic->seo_title) }}">
                                    @error('seo_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="seo_description" class="form-label">SEO Description</label>
                                    <textarea id="seo_description" name="seo_description" rows="3" class="form-control @error('seo_description') is-invalid @enderror">{{ old('seo_description', $topic->seo_description) }}</textarea>
                                    @error('seo_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i> Cập nhật Chủ đề
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
