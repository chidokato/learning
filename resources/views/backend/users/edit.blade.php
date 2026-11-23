@extends('backend.layouts.app')

@section('title', 'Sửa Tài khoản')
@section('page_title', 'Sửa Tài khoản')
@section('breadcrumb', 'Sửa Tài khoản')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Cập nhật tài khoản</h4>
            <div class="d-flex gap-2">
                <button type="submit" form="user-form" class="btn btn-primary">Cập nhật tài khoản</button>
                <a href="{{ route('backend.users.index') }}" class="btn btn-light">Quay lại</a>
            </div>
        </div>
        <div class="card-body">
            <form id="user-form" action="{{ route('backend.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('backend.users._form', ['submitLabel' => 'Cập nhật tài khoản', 'user' => $user])
            </form>
        </div>
    </div>
@endsection
