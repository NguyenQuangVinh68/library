@extends('layouts.admin')
@section('main')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/iconly.css') }}">
    @endpush
    <div class="page-content">
        <section class="row">
            <div class="col-12 ">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi bi-eye-fill"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-8
                                                col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold text-capitalize">
                                            Lượt truy cập
                                        </h6>
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold text-capitalize">Tổng sách</h6>
                                        <h6 class="font-extrabold mb-0">
                                            @php
                                                $tongsach = App\Models\Sach::count();
                                            @endphp
                                            {{ $tongsach <= 0 ? 0 : $tongsach }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold text-capitalize">số lượt mượn</h6>
                                        <h6 class="font-extrabold mb-0">
                                            @php
                                                $sachmuon = Illuminate\Support\Facades\DB::table('chitietmuons')
                                                    ->join('danhsachmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                                                    ->count();
                                            @endphp
                                            {{ $sachmuon <= 0 ? 0 : $sachmuon }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-bookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Tổng Sách mất</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ empty($sach_mat) ? 0 : count($sach_mat) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row">
            {{-- sách new --}}
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sách mới nhất</h4>
                    </div>
                    @if (empty($sach_new))
                        <h3 class="alert-danger p-2">Không có dữ liệu</h3>
                    @else
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nhan đề</th>
                                                <th>Ảnh bìa</th>
                                                <th>Tác giả</th>
                                                <th>Vị trí</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sach_new as $sach)
                                                <tr>
                                                    <td>{{ $sach->id }}</td>
                                                    <td>{{ $sach->nhande }}</td>
                                                    <td><img src="{{ asset('assets/images/books/' . $sach->anhbia) }}"
                                                            alt="anhbia" class="w-100"></td>
                                                    <td>{{ $sach->tacgia }}</td>
                                                    <td>{{ $sach->vitri }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            {{-- end sách new --}}

            {{-- top user --}}
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Top người dùng mượn nhiều nhất </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên người dùng</th>
                                            <th>Số lượng sách đã và đang mượn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_top as $user)
                                            <tr>
                                                <td>{{ $user->ma_user }}</td>
                                                <td>{{ $user->ten_user }}</td>
                                                <td>{{ $user->slmuon }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end top user --}}

            {{-- mất sách --}}
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách mất</h4>
                    </div>
                    @if (empty($sach_mat))
                        <h3 class="alert-danger p-2">Không có dữ liệu</h3>
                    @else
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>Mã người dùng</th>
                                                <th>Tên người dùng</th>
                                                <th>Mã sách</th>
                                                <th>Nhan đề sách</th>
                                                <th>Ngày báo mất</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sach_mat as $sach)
                                                <tr>
                                                    <td>{{ $sach->ma_user }}</td>
                                                    <td>{{ $sach->ten_user }}</td>
                                                    <td>{{ $sach->masach }}</td>
                                                    {{-- <td>{{ $sach->user->ten_user }}</td> --}}
                                                    <td>{{ $sach->nhande }}</td>
                                                    <td>{{ $sach->ngaybaomat }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{-- end sách mất --}}
        </section>

    </div>
@endsection
