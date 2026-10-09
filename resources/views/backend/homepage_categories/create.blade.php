@extends('backend.layouts.app')

@section('title', 'Thêm Danh mục Trang chủ')
@section('page_title', 'Thêm Danh mục Trang chủ')
@section('breadcrumb', 'Thêm Danh mục Trang chủ')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.homepage_categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.homepage_categories._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                    <a href="{{ route('backend.homepage_categories.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

