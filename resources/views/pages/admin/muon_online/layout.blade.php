@extends('layouts.admin')
@section('main')
    <section>
        <div class="row my-5 ">
            <div class="col-md-6 mb-1">
                <a class="text-capitalize nav-link fs-4 fw-bold " href="{{ route('muon.online') }}">đăng kí mượn online</a>
            </div>
            <div class="col-md-6 mb-1">
                <form action="" class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Tìm kiếm theo mã sinh viên" name="key">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </section>
    @yield('content')
@endsection
