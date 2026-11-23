@extends('backend.layouts.app')

@section('title', 'Thêm Tài khoản')
@section('page_title', 'Thêm Tài khoản')
@section('breadcrumb', 'Thêm Tài khoản')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Thêm tài khoản mới</h4>
            <div class="d-flex gap-2">
                <button type="submit" form="user-form" class="btn btn-primary">Lưu tài khoản</button>
                <a href="{{ route('backend.users.index') }}" class="btn btn-light">Quay lại</a>
            </div>
        </div>
        <div class="card-body">
            <form id="user-form" action="{{ route('backend.users.store') }}" method="POST" enctype="multipart/form-data">
                @include('backend.users._form', ['submitLabel' => 'Lưu tài khoản'])
            </form>
        </div>
    </div>
@endsection
