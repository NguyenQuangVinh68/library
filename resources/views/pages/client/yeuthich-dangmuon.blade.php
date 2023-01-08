@extends('layouts.client')
@section('main')
    <div class="container my-5">
        @if (count($datas) > 0)
            <h3 class="text-center">{{ $title }}</h3>
            <section class="section">
                <div class="row my-5" id="table-head">
                    <div class="col-12">
                        <div class="table-responsive">

                            <table class="table mb-0">
                                <thead class="thead-dark">
                                    @if ($title == 'Danh sách yêu thích')
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã sách</th>
                                            <th>Nhan đề</th>
                                            <th>Ảnh bìa</th>
                                            <th>Tác Giả</th>
                                            <th>Action</th>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã sách</th>
                                            <th>Nhan đề</th>
                                            <th>Ngày mượn</th>
                                            <th>Ngày ngày trả</th>
                                        </tr>
                                    @endif
                                </thead>
                                @php
                                    $id = 0;
                                @endphp
                                <tbody>

                                    @if ($title == 'Danh sách yêu thích')
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td>{{ ++$id }}</td>
                                                <td>{{ $data->masach }}</td>
                                                <td class="text-capitalize">{{ $data->sach->nhande }}</td>
                                                <td class="text-capitalize">
                                                    <img src="{{ asset('assets/images/books/' . $data->sach->anhbia) }}"
                                                        alt="book" class="w-25">
                                                </td>
                                                <td class="text-capitalize">{{ $data->sach->tacgia }}</td>
                                                <td>

                                                    <button type="button" class="btn btn-outline-primary block"
                                                        data-bs-toggle="modal" data-bs-target="#role4">Mượn</button>

                                                    <button type="button" class="btn btn-outline-danger block "
                                                        data-bs-toggle="modal" data-bs-target="#delete4"><i
                                                            class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>

                                            {{-- modal --}}
                                            <div class="modal fade" id="role4" data-bs-backdrop="static"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                Thay đổi vai trò
                                                            </h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">X</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="http://localhost:8000/admin/user/4"
                                                                method="POST">
                                                            </form>
                                                            <input type="hidden" name="_method" value="PUT"> <input
                                                                type="hidden" name="_token"
                                                                value="tLxfAIj6AtxfywVUSk8zGdwflnhvTv6dDgBONQGA">
                                                            <h4 class="text-center"> nguyễn thanh bình</h4>
                                                            <p class="text-center">Bạn có trắc chắn muốn thay đổi vai trò
                                                                cho
                                                                "Người dùng này" ?
                                                            </p>
                                                            <input type="hidden" value="1" name="role"
                                                                id="role">
                                                            <div class="d-flex gap-3 mt-5">
                                                                <button type="submit" class="btn btn-danger w-50">Ok,
                                                                    thay đổi</button>
                                                                <button class="btn btn-secondary w-50" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- end danh sach yeu thích --}}
                                    @else
                                        {{-- danhsach muon --}}
                                        @foreach ($datas as $data)
                                            <tr class="{{ $data->ngaytra == date('Y-m-d') ? 'bg-danger' : '' }}">
                                                <td>{{ ++$id }}</td>
                                                <td class="text-capitalize">{{ $data->masach }}</td>
                                                <td class="text-capitalize">{{ $data->nhande }}</td>
                                                <td class="text-capitalize">{{ $data->ngaymuon }}</td>
                                                <td class="text-capitalize">{{ $data->ngaytra }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <h3 class="text-center p-3 alert-danger">Không có dữ liệu</h3>
        @endif
    </div>
@endsection
