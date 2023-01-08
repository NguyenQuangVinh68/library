@extends('pages.admin.nganh.layout')
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
                <a href="{{ route('nganh.index') }}" class="btn btn-light-secondary w-25 ">Trở lại</a>
            </div>
        @endif

        <?php
        use App\Models\Khoa;
        $khoas = Khoa::all();
        ?>
        <div class="row my-5" id="table-head">
            <div class="col-12">
                <div class="table-responsive">
                    @if (isset($nganhs))
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã ngành</th>
                                    <th>Tên ngành</th>
                                    <th>Tên Khoa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nganhs as $nganh)
                                    <tr>
                                        <td>{{ $nganh->id }}</td>
                                        <td>{{ $nganh->manganh }}</td>
                                        <td>{{ $nganh->tennganh }}</td>
                                        @foreach ($khoas as $khoa)
                                            @if ($khoa->id == $nganh->makhoa)
                                                <td>{{ $khoa->tenkhoa }}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{ route('nganh.edit', $nganh->id) }}" type="button"
                                                class="btn btn-outline-primary block"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-outline-danger block"
                                                data-bs-toggle="modal" data-bs-target="#modal{{ $nganh->id }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modal{{ $nganh->id }}" data-bs-backdrop="static"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                        Xóa ngành
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('nganh.destroy', $nganh->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $nganh->tennganh }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn xóa "NGÀNH" này?</p>
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
    @if (isset($nganhs))
        {{ $nganhs->links('inc.pagination') }}
    @endif
    {{-- end pagination --}}
@endsection
