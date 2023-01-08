@extends('layouts.admin')
@section('main')
    <div class="row my-5 ">
        <div class="col-md-6 mb-1">
            <a class="text-capitalize text-decoration-none fs-2 d-block fw-bold " href="{{ route('thongke.index') }}">Thống
                kê</a>
        </div>
    </div>

    @yield('content')
@endsection
