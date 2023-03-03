@extends('pages.admin.category.layout')
@section('content')
    <section class="section">
        @if (session('message'))
            <div class="alert alert-success mt-5">
                {{ session('message') }}
            </div>
        @endif
        @if (isset($message_404))
            <div class=" mt-5 text-center">
                <p class="fs-3 fw-bold  alert alert-danger">{{ $message_404 }}</p>
                <a href="{{ route('category.index') }}" class="btn btn-light-secondary w-25 ">Trở lại</a>
            </div>
        @endif

        <div class="row" id="table-head">
            <div class="col-12">
                <div class="table-responsive">
                    @if (isset($kq))
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Danh Mục</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kq as $danhmuc)
                                    <tr>
                                        <td>{{ $danhmuc->id }}</td>
                                        <td>{{ $danhmuc->tendm }}</td>
                                        <td>
                                            <a href="{{ route('category.edit', $danhmuc->id) }}" type="button"
                                                class="btn btn-outline-primary block"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-outline-danger block"
                                                data-bs-toggle="modal" data-bs-target="#cateogty{{ $danhmuc->id }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="cateogty{{ $danhmuc->id }}" data-bs-backdrop="static"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                        Xóa danh mục
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('category.destroy', $danhmuc->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $danhmuc->tendm }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn xóa danh mục này?</p>
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
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- pagination --}}
    @if (isset($kq))
        {{ $kq->links('inc.pagination') }}
    @endif
    {{-- end pagination --}}
@endsection
