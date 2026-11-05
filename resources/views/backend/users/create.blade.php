@extends('backend.layouts.app')

@section('title', 'Thêm người dùng mới')
@section('page_title', 'Thêm người dùng')
@section('breadcrumb', 'Thêm người dùng')

@section('content')
    <form id="user-form" action="{{ route('backend.users.store') }}" method="POST" enctype="multipart/form-data">
        @include('backend.users._form', ['submitLabel' => 'Tạo người dùng mới'])
    </form>
@endsection
