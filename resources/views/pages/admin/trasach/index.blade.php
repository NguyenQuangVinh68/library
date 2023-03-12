@extends('pages.admin.muonsach.layout')
@section('content')
    <section class="section">

        @if (session('message'))
            <div class="alert alert-danger mt-5">
                {{ session('message') }}
            </div>
        @endif

        @if (isset($message) && $message != null)
            <div class="alert alert-success ">
                <p class="text-capitalize">{{ $message }}</p>
            </div>
        @endif
        <div class="container  d-flex justify-content-around align-items-center mb-5">
            <h4 class="text-center ">Sách đang mượn</h4>
            <form class="form form-vertical" action="">
                <div class="row ">
                    <div class="col-9 p-0">
                        <input class="form-control" type="text" name="txtsearch" id="txtsearch"
                            placeholder="Nhập mã sinh viên hoặc tên sách"
                            value="{{ Request::get('txtsearch') ? Request::get('txtsearch') : '' }}">
                    </div>
                    <div class="col-3 p-0">
                        <button class="btn btn-primary" type="submit">Tìm</button>
                    </div>
                </div>
            </form>
        </div>
        @if (count($kq) > 0)
            <div class="row my-5" id="table-head">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Mã sinh viên</th>
                                    <th>Tên sinh viên</th>
                                    <th>Mã sách</th>
                                    <th>Nhan đề</th>
                                    <th>Ngày mượn</th>
                                    <th>Ngày trả</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kq as $muon)
                                    <tr class="{{ $muon->ngaytra == date('Y-m-d') ? 'bg-danger' : '' }}">
                                        <td>{{ $muon->ma_user }}</td>
                                        <td class="text-capitalize">{{ $muon->ten_user }}</td>
                                        <td>{{ $muon->masach }}</td>
                                        <td class="w-25">{{ $muon->nhande }}</td>
                                        <td>{{ $muon->ngaymuon }}</td>
                                        <td>{{ $muon->ngaytra }}</td>
                                        <td>
                                            <a href="{{ route('giahan.index', $muon->id) }}"
                                                class="btn btn-outline-success">Gia
                                                hạn</a>
                                            <button type="button"
                                                class="btn {{ $muon->ngaytra == date('Y-m-d') ? 'btn-outline-light' : 'btn-outline-primary' }} block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#tra{{ $muon->id }}">Trả</button>
                                            <button type="button"
                                                class="btn {{ $muon->ngaytra == date('Y-m-d') ? 'btn-outline-secondary' : 'btn-outline-danger' }} block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#mat{{ $muon->id }}">Mất</button>
                                        </td>
                                    </tr>

                                    {{-- trả sách --}}
                                    <div class="modal fade" id="tra{{ $muon->id }}" data-bs-backdrop="static"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                        Trả sách
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('tra.action') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="mamuon" value="{{ $muon->id }}">
                                                        <input type="hidden" name="masach" value="{{ $muon->masach }}">
                                                        <input type="hidden" name="nhande" value="{{ $muon->nhande }}">
                                                        <input type="hidden" name="ma_user" value="{{ $muon->ma_user }}">
                                                        <input type="hidden" name="maadm" value="admin">
                                                        <input type="hidden" name="ngaytra" value="{{ date('Y-m-d') }}">
                                                        <h4 class="text-center"> {{ $muon->nhande }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn muốn trả "SÁCH" này?</p>
                                                        <div class="d-flex gap-3 mt-5">
                                                            <button type="submit" class="btn btn-danger w-50">Ok,
                                                                trả</button>
                                                            <button class="btn btn-secondary w-50" type="button"
                                                                data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- end trả sách --}}

                                    {{-- mất sách --}}
                                    <div class="modal " id="mat{{ $muon->id }}" data-bs-backdrop="static"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">
                                                        Mất sách
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">X</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('mat') }}" method="POST">
                                                        @csrf
                                                        @php
                                                            $tienphat = DB::table('saches')
                                                                ->select('gia')
                                                                ->where('id', $muon->masach)
                                                                ->limit(1)
                                                                ->get();
                                                        @endphp
                                                        {{-- data --}}
                                                        <input type="hidden" name="masach"
                                                            value="{{ $muon->masach }}">
                                                        <input type="hidden" name="nhande"
                                                            value="{{ $muon->nhande }}">
                                                        <input type="hidden" name="ma_user"
                                                            value="{{ $muon->ma_user }}">
                                                        <input type="hidden" name="mamuon"
                                                            value="{{ $muon->id }}">
                                                        <input type="hidden" name="maadm" value="admin">
                                                        <input type="hidden" name="ngaybaomat"
                                                            value="{{ date('Y-m-d') }}">
                                                        <input type="hidden" name="tienphat"
                                                            value="{{ $tienphat[0]->gia * 2 }}">
                                                        {{-- end data --}}

                                                        <h4 class="text-center"> {{ $muon->nhande }}</h4>
                                                        <p class="text-center">Bạn có trắc chắn "Sách" này đã mất</p>
                                                        <div class="d-flex gap-3 mt-5">
                                                            <button type="submit" class="btn btn-danger w-50">Ok,
                                                                mất</button>
                                                            <button class="btn btn-secondary w-50" type="button"
                                                                data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- end mất sách --}}
                                @endforeach
                            </tbody>
                        </table>

                        {{-- @push('ajax')
                            <script>
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                })

                                var ma_uer = $('#ma_user').val()

                                $('#btn-timsv').click(function(ev) {
                                    ev.preventDefault();
                                    $.ajax({
                                        url: '{{ route('ajax.muonsach') }}',
                                        type: 'POST',
                                        data:{ma_uer},
                                        success: function(){

                                        }
                                    })
                                })
                            </script>
                        @endpush --}}
                    </div>
                </div>
            </div>
            @if (isset($kq))
                {{ $kq->links('inc.pagination') }}
            @endif
        @else
            <div class="">
                <h3 class="p-5 alert-danger fs-3 fw-bold text-center">Không có dữ liệu</h3>
            </div>
        @endif
    </section>
@endsection
