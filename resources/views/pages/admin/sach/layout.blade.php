@extends('layouts.admin')
@section('main')
    <div class="row my-5 d-flex align-items-center">
        <div class="col-md-6 mb-1">
            <a class="text-capitalize text-decoration-none fs-2 d-block fw-bold " href="{{ route('sach.index') }}">Sách</a>
            <a href="{{ route('sach.create') }}" class="btn btn-primary mt-3">Thêm sách</a>
        </div>
        <div class="col-md-6 mb-1">
            <label for="" class="form-label">Tìm kiếm</label>
            <form action="" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm nhan đề sách..." name="key">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    @yield('content')
@endsection
