@extends('backend.layouts.app')

@section('title', 'Sửa Danh mục Trang chủ')
@section('page_title', 'Sửa Danh mục Trang chủ')
@section('breadcrumb', 'Sửa Danh mục Trang chủ')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.homepage_categories.update', $homepageCategory) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('backend.homepage_categories._form', ['homepageCategory' => $homepageCategory])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="{{ route('backend.homepage_categories.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

