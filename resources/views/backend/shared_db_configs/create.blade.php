@extends('backend.layouts.app')

@section('title', 'Thêm cấu hình DB dùng chung')
@section('page_title', 'Thêm cấu hình DB dùng chung')
@section('breadcrumb', 'Thêm cấu hình DB dùng chung')

@section('content')
    <form action="{{ route('backend.shared-db-configs.store') }}" method="POST">
        @include('backend.shared_db_configs._form', ['config' => $config])

        <div class="d-flex align-items-center justify-content-end gap-2 mt-3">
            <a href="{{ route('backend.shared-db-configs.index') }}" class="btn btn-light">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line align-bottom me-1"></i> Lưu cấu hình DB
            </button>
        </div>
    </form>
@endsection
