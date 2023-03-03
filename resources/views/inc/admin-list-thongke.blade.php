<div class="row" id="">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Kết quả</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#danhsachmuon" role="tab"
                            aria-selected="true">Danh sách mượn</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#danhsachtra" role="tab"
                            aria-selected="false" tabindex="-1">Danh sách trả</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#danhsachmat" role="tab"
                            aria-selected="false" tabindex="-1">Danh sách mất</a>
                    </li>
                </ul>

                {{-- view tab nav --}}
                <div class="tab-content" id="myTabContent">

                    {{-- sach đã mượn --}}
                    <div class="tab-pane fade show active" id="danhsachmuon" role="tabpanel">
                        @if ($danhsachmuon->count() <= 0)
                            <h2 class="alert-danger text-center my-5 p-3">Không có dữ liệu sách mượn</h2>
                        @else
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title text-center ">Sách đã mượn</h2>
                                </div>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table  mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Mã sách</th>
                                                    <th>Mã sinh viên</th>
                                                    <th>Tên sinh viên</th>
                                                    <th>Nhan đề</th>
                                                    <th>Khoa</th>
                                                    <th>Ngành</th>
                                                    <th>Tác giả</th>
                                                    <th>Ngày mượn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($danhsachmuon as $muon)
                                                    <tr>
                                                        <td>{{ $muon->id }}</td>
                                                        <td>{{ $muon->ma_user }}</td>
                                                        <td class="text-capitalize">{{ $muon->user->ten_user }}</td>
                                                        <td>{{ $muon->nhande }}</td>
                                                        <td>{{ $muon->khoa }}</td>
                                                        <td>{{ $muon->nganh }}</td>
                                                        <td>{{ $muon->tacgia }}</td>
                                                        <td>{{ $muon->ngaymuon }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- end sách mươn --}}

                    {{-- danh sách trả --}}
                    <div class="tab-pane fade" id="danhsachtra" role="tabpanel">
                        @if ($danhsachtra->count() <= 0)
                            <h2 class="alert-danger text-center my-5 p-3">Không có dữ liệu sách trả</h2>
                        @else
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title text-center ">Sách đã trả</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table  mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Mã sách</th>
                                                        <th>Mã sinh viên</th>
                                                        <th>Tên sinh viên</th>
                                                        <th>Nhan đề</th>
                                                        <th>Khoa</th>
                                                        <th>Ngành</th>
                                                        <th>Tác giả</th>
                                                        <th>Ngày trả</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($danhsachtra as $tra)
                                                        <tr>
                                                            <td>{{ $tra->id }}</td>
                                                            <td>{{ $tra->ma_user }}</td>
                                                            <td class="text-capitalize">{{ $tra->user->ten_user }}</td>
                                                            <td>{{ $tra->nhande }}</td>
                                                            <td>{{ $tra->khoa }}</td>
                                                            <td>{{ $tra->nganh }}</td>
                                                            <td>{{ $tra->tacgia }}</td>
                                                            <td>{{ $tra->ngaytra }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    </div>
                    {{-- end danh sách trả --}}

                    {{-- danh sách mất --}}
                    <div class="tab-pane fade" id="danhsachmat" role="tabpanel">
                        @if ($danhsachmat->count() <= 0)
                            <h2 class="alert-danger text-center my-5 p-3">Không có dữ liệu sách báo mất</h2>
                        @else
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title text-center ">Sách đã mất</h2>
                                    </div>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table  mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Mã sách</th>

                                                        <th>Mã sinh viên</th>
                                                        <th>Nhan đề</th>
                                                        <th>Khoa</th>
                                                        <th>Ngành</th>
                                                        <th>Tác giả</th>
                                                        <th>Ngày báo mất</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($danhsachmat as $mat)
                                                        <tr>
                                                            <td>{{ $mat->id }}</td>
                                                            <td>{{ $mat->ma_user }}</td>
                                                            <td>{{ $mat->nhande }}</td>
                                                            <td>{{ $mat->khoa }}</td>
                                                            <td>{{ $mat->nganh }}</td>
                                                            <td>{{ $mat->tacgia }}</td>
                                                            <td>{{ $mat->ngaybaomat }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- end danh sách mất --}}
                </div>
                {{-- end tab nav --}}
            </div>
        </div>
    </div>
    {{-- end col-12 --}}
</div>
