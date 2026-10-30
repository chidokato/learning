@extends('backend.layouts.app')

@section('title', 'Thêm phòng ban')
@section('page_title', 'Thêm phòng ban')
@section('breadcrumb', 'Thêm phòng ban')

@section('content')
    <form action="{{ route('backend.departments.store') }}" method="POST">
        @include('backend.departments._form', ['department' => new \App\Models\Department()])

        <div class="d-flex align-items-center justify-content-end gap-2 mt-3">
            <a href="{{ route('backend.departments.index') }}" class="btn btn-light">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">Lưu phòng ban</button>
        </div>
    </form>
@endsection
