@extends('pages.admin.muonsach.layout')
@section('content')
    @if (isset($message) && $message != null)
        <div class="alert alert-danger ">
            <p class="text-capitalize">{{ $message }}</p>
        </div>
    @endif
    <div class="w-50 mx-auto">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Mượn sách</h4>
            </div>
            <div class="card-content">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mã số sinh viên</label>
                                    <input disabled type="text" class="form-control disable"
                                        value="{{ Session::has('ma_user') ? Session::get('ma_user') : '' }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Tên sinh viên</label>
                                    <input disabled type="text" class="form-control "
                                        value="{{ Session::has('ten_user') ? Session::get('ten_user') : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="form form-vertical" autocomplete="off" action="{{ route('tim-sach') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mã sách</label>
                                        <input type="text" id="masach" class="form-control" name="masach"
                                            placeholder="Nhập mã sách" value="">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Tìm</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Đặt lại</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- hiện sách sau mỗi lần tìm kiếm --}}
    @if (Session::has('sach'))
        @if (Session::get('sach') != null)
            @php
                $tmpsession = Session::get('sach');
            @endphp
            <div class="row my-5" id="table-head">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nhan đề</th>
                                    <th>Tác giả</th>
                                    <th>Ảnh bìa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tmpsession as $sach)
                                    <tr>
                                        <td>{{ $sach->id }}</td>
                                        <td>{{ $sach->nhande }}</td>
                                        <td>{{ $sach->tacgia }}</td>
                                        <td><img src="{{ asset('assets/images/books/' . $sach->anhbia) }}" alt=""
                                                class="w-25"></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger block"
                                                data-bs-toggle="modal" data-bs-target="#modal{{ $sach->id }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modal{{ $sach->id }}" data-bs-backdrop="static"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                        Xóa sách
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('xoa-sach', ['masach' => $sach->id]) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $sach->nhande }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn xóa "sách" đang tìm
                                                            kiếm này?</p>
                                                        <div class="d-flex gap-3 mt-5">
                                                            <button type="submit" class="btn btn-danger w-50">Ok,
                                                                xóa</button>
                                                            <button class="btn btn-secondary w-50" type="button"
                                                                data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- button mượn --}}
                        <div class="text-end mt-5">
                            <a href="{{ route('muon-action') }}" class="btn btn-primary">Đăng kí mượn</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
