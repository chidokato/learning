@extends('backend.layouts.app')

@section('title', 'Cập nhật người dùng: ' . $user->name)
@section('page_title', 'Cập nhật người dùng')
@section('breadcrumb', 'Cập nhật người dùng')

@section('content')
    <form id="user-form" action="{{ route('backend.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @include('backend.users._form', ['submitLabel' => 'Lưu thay đổi', 'user' => $user])
    </form>
@endsection
