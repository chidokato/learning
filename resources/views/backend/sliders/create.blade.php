@extends('backend.layouts.app')

@section('title', 'Thêm Slider')
@section('page_title', 'Thêm Slider')
@section('breadcrumb', 'Thêm Slider')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.sliders._form')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                    <a href="{{ route('backend.sliders.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection