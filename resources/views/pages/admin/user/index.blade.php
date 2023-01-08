@extends('pages.admin.user.layout')
@section('content')
    <section class="section">
        @if (session('message'))
            <div class="alert alert-success mt-5">
                {{ session('message') }}
            </div>
        @endif

        @if ($kq->isNotEmpty())
            <div class="row my-5" id="table-head">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã số </th>
                                    <th>Tên tài khoản</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kq as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->ma_user }}</td>
                                        <td class="text-capitalize">{{ $user->ten_user }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role == 1 ? 'admin' : 'sinh viên' }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            {{-- btn change role --}}
                                            <button type="button"
                                                class="btn btn-outline-success block d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#role{{ $user->id }}"><i
                                                    class="bi bi-file-lock2-fill "></i></button>
                                            {{-- href change user --}}
                                            <a href="{{ route('user.edit', $user->id) }}" type="button"
                                                class="btn btn-outline-primary block d-flex align-items-center"><i
                                                    class="bi bi-pencil"></i></a>
                                            {{-- btn delete user --}}
                                            <button type="button"
                                                class="btn btn-outline-danger block d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#delete{{ $user->id }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>

                                    {{-- change role --}}
                                    <div class="modal fade" id="role{{ $user->id }}" data-bs-backdrop="static"
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
                                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $user->ten_user }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn thay đổi vai trò cho
                                                            "Người dùng này" ?
                                                        </p>
                                                        <input type="hidden" value="{{ $user->role == 1 ? 0 : 1 }}"
                                                            name="role" id="role">
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
                                    {{-- end change role --}}

                                    {{-- delete user --}}
                                    <div class="modal fade" id="delete{{ $user->id }}" data-bs-backdrop="static"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                        Xóa người dùng
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $user->ten_user }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn xóa "Người Dùng" này?
                                                        </p>
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
                                    {{-- end delete user --}}
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
