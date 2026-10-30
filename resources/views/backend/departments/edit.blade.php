@extends('backend.layouts.app')

@section('title', 'Sửa phòng ban')
@section('page_title', 'Sửa phòng ban')
@section('breadcrumb', 'Sửa phòng ban')

@section('content')
    <form action="{{ route('backend.departments.update', $department) }}" method="POST">
        @method('PUT')
        @include('backend.departments._form', ['department' => $department])

        <div class="d-flex align-items-center justify-content-end gap-2 mt-3">
            <a href="{{ route('backend.departments.index') }}" class="btn btn-light">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">Cập nhật phòng ban</button>
        </div>
    </form>
@endsection
