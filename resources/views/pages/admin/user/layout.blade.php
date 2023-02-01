@extends('layouts.admin')
@section('main')
    <div class="row my-5 ">
        <div class="col-md-6 mb-1">
            <a class="text-capitalize text-decoration-none fs-2 d-block fw-bold " href="{{ route('user.index') }}">Người
                dùng</a>
            <a href="{{ route('user.create') }}" class="btn btn-primary mt-3">Thêm người dùng</a>
            <button type="button" class="btn btn-success block mt-3 " data-bs-toggle="modal" data-bs-target="#border-less">
                Nhập file
            </button>

            <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1"
                aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import CSV</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('user.import') }}" class="input-group mb-3"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control" name="import">
                                <button class="btn btn-primary" type="submit">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <form action="" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm người dùng theo tên" name="key">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    @yield('content')
@endsection
