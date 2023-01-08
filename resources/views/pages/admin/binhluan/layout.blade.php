@extends('layouts.admin')
@section('main')
    <div class="row my-5 d-flex align-items-center">
        <div class="col-md-6 mb-1">
            <a href="{{ route('binh-luan.index') }}" class="nav-link text-capitalize fs-2 fw-bold">Bình luận</a>
        </div>
        <div class="col-md-6 mb-1">
            <form action="" class="input-group mb-3 ">
                <input type="text" class="form-control" placeholder="Tìm kiếm bình luận theo mã người dùng" name="key">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
    @yield('content')
@endsection
