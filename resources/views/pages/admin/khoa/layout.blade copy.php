@extends('layouts.admin')
@section('main')
    <div class="row my-5 ">
        <div class="col-md-6 mb-1">
            <h1 class="text-capitalize">danh mục</h1>
            <a href="{{ route('category.create') }}" class="btn btn-primary mt-3">Thêm danh mục</a>
        </div>
        <div class="col-md-6 mb-1">
            <form action="" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm tên thư mục..." name="key">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    @yield('content')
@endsection
