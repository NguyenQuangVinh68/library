@extends('pages.admin.binhluan.layout')
@section('content')
    <section class="section">
        @if (session('message'))
            <div class="alert alert-success mt-5">
                {{ session('message') }}
            </div>
        @endif

        @if ($kq->isNotEmpty())
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã trả lời</th>
                                    <th>Mã người dùng</th>
                                    <th>Tên người dùng</th>
                                    <th>Mã sách</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kq as $binhluan)
                                    <tr>
                                        <td>{{ $binhluan->id }}</td>
                                        <td>{{ $binhluan->traloi_id }}</td>
                                        <td>{{ $binhluan->ma_user }}</td>
                                        <td>{{ $binhluan->user->ten_user }}</td>
                                        <td>{{ $binhluan->sach_id }}</td>
                                        <td>{{ $binhluan->bl_noidung }}</td>
                                        <td>{{ $binhluan->status == 1 ? 'Hiện' : 'Ẩn' }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-outline-success block d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#binhluan{{ $binhluan->id }}"><i
                                                    class="bi bi-file-lock2-fill "></i></button>
                                        </td>
                                    </tr>

                                    {{-- thay đổi trạng thái --}}
                                    <div class="modal fade" id="binhluan{{ $binhluan->id }}" data-bs-backdrop="static"
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
                                                    <form action="{{ route('binh-luan.update', $binhluan->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $binhluan->bl_noidung }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn thay đổi trạng thái cho
                                                            "Nội dung bình luận này này" ?
                                                        </p>
                                                        <input type="hidden" value="{{ $binhluan->status == 1 ? 0 : 1 }}"
                                                            name="status" id="status">
                                                        <div class="d-flex gap-3 mt-5">
                                                            <button type="submit" class="btn btn-danger w-50">Ok,
                                                                thay đổi</button>
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
                    </div>
                </div>
            </div>
            {{-- pagination --}}
            {{ $kq->links('inc.pagination') }}
            {{-- end pagination --}}
        @else
            <div class="text-center">
                <h3 class="alert-danger  p-3">Không thấy dữ liệu</h3>
                <a href="{{ URL::previous() }} " class="btn btn-secondary mx-auto">Trở lại</a>
            </div>
        @endif

    </section>
@endsection
