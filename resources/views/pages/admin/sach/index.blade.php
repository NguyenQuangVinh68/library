@extends('pages.admin.sach.layout')
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
                <a href="{{ route('sach.index') }}" class="btn btn-light-secondary w-25 ">Trở lại</a>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="form-group">
                    @php
                        $khoas = App\Models\Khoa::all();
                        $nganhs = App\Models\Nganh::all();
                    @endphp
                    <label for="" class="form-label">Kiểm tra số lượng sách theo Khoa/Ngành</label>
                    <select name="nganh_khoa" id="nganh_khoa" class="form-select">
                        @foreach ($khoas as $khoa)
                            <option value="{{ $khoa->tenkhoa }}">Khoa {{ $khoa->tenkhoa }}</option>
                        @endforeach
                        @foreach ($nganhs as $nganh)
                            <option value="{{ $nganh->tennganh }}">Ngành {{ $nganh->tennganh }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row my-5" id="view-book">
            @if (isset($kq))
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nhan đề</th>
                                    <th>Tác giả</th>
                                    <th>Danh mục</th>
                                    <th>Khoa</th>
                                    <th>Ngành</th>
                                    <th>Ảnh bìa</th>
                                    <th>Thông tin xb</th>
                                    <th>Vị trí</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>PDF</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kq as $sach)
                                    <tr>
                                        <td>{{ $sach->id }}</td>
                                        <td>{{ $sach->nhande }}</td>
                                        <td class="text-capitalize">{{ $sach->tacgia }}</td>
                                        <td>{{ $sach->danhmuc }}</td>
                                        <td>
                                            {{ $sach->khoa == 'công nghệ thông tin - điện tử' ? 'CNTT-DT' : $sach->khoa }}
                                        </td>
                                        <td>{{ $sach->nganh }}</td>
                                        <td><img src="{{ asset('assets/images/books/' . $sach->anhbia) }}" alt=""
                                                class="w-50"></td>
                                        <td>{{ $sach->thongtinxb }}</td>
                                        <td>{{ $sach->vitri }}</td>
                                        <td>{{ $sach->soluong }}</td>
                                        <td>{{ $sach->gia }}</td>
                                        @if ($sach->file_pdf != null)
                                            <td><a href="{{ asset('assets/tailieu/' . $sach->file_pdf) }}" target="_blank"
                                                    alt="File pdf" class="nav-link">xem file</a></td>
                                        @else
                                            <td>không file</td>
                                        @endif
                                        <td>
                                            <a href="{{ route('sach.edit', $sach->id) }}" type="button"
                                                class="btn btn-outline-primary block "><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-outline-danger block "
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
                                                        Xóa ngành
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('sach.destroy', $sach->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <h4 class="text-center"> {{ $sach->nhande }}</h4>
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
                    </div>
                </div>
                {{-- pagination --}}
                {{ $kq->links('inc.pagination') }}
                {{-- end pagination --}}
            @endif
        </div>
    </section>

@endsection

@push('ajax')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
        $(document).ready(function() {
            $('#nganh_khoa').change(function(ev) {
                ev.preventDefault();
                var value_khoa_nganh = $('#nganh_khoa').val();
                var fillterURL = '{{ route('sach.loc') }}';

                $.ajax({
                    url: fillterURL,
                    method: "POST",
                    data: {
                        'khoa_nganh': value_khoa_nganh,
                    },
                    success: function(res) {
                        $('#view-book').html(res);
                        // console.log(res);
                    }
                })
            })
        })
    </script>
@endpush
