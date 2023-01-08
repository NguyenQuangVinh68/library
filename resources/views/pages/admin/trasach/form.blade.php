@extends('pages.admin.muonsach.layout')
@section('content')
    @if (session('message'))
        <div class="alert alert-danger mt-5">
            {{ session('message') }}
        </div>
    @endif
    <div class="container w-50 mx-auto">
        <div class="card">
            <div class="card-content">
                <div class="card-header">
                    <h4 class="text-center">Trả sách</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('tra.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tìm sinh viên</label>
                                    <input class="form-control" type="text" name="ma_user" id="ma_user"
                                        placeholder="Tìm sinh viên theo mã số">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                    Tìm
                                </button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                    Đặt lại
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
