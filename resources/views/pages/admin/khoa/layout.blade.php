@extends('layouts.admin')
@section('main')
    <div class="row my-5 ">
        <div class="col-md-6 mb-1">
            <a class="text-capitalize text-decoration-none fs-2 d-block fw-bold " href="{{ route('khoa.index') }}">khoa</a>
            <a href="{{ route('khoa.create') }}" class="btn btn-primary mt-3">Thêm khoa</a>
        </div>
        <div class="col-md-6 mb-1">
            <form action="" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm tên khoa..." name="key">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    @yield('content')
@endsection
