@extends('pages.admin.muon_online.layout')
@section('content')

    @if (session('message'))
        <div class="alert alert-success mt-5">
            {{ session('message') }}
        </div>
    @endif
    @if (count($data) > 0)
        <section class="section">
            <h3 class="my-5 text-center">Danh sách đã đăng kí mượn online</h3>
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã người dùng</th>
                                    <th>Tên người dùng</th>
                                    <th>Mã sách</th>
                                    <th>Nhan đề</th>
                                    <th>Ngày đăng kí mượn</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $muon)
                                    <tr>
                                        <td>{{ $muon->id }}</td>
                                        <td>{{ $muon->ma_user }}</td>
                                        <td class="text-capitalize">{{ $muon->ten_user }}</td>
                                        <td>{{ $muon->masach }}</td>
                                        <td class="text-capitalize">{{ $muon->nhande }}</td>
                                        <td class="text-capitalize">{{ date_format($muon->created_at, 'Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('muon.online.xacnhan', ['id_dangki' => $muon->id]) }}"
                                                type="button" class="btn btn-outline-primary block">Xác
                                                nhận cho mượn</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @if (isset($data))
            {{ $data->links('inc.pagination') }}
        @endif
    @else
        <div class="my-5">
            <h3 class="alert-danger text-capitalize p-3 text-center">Không có dữ liệu</h3>
        </div>
    @endif
@endsection
