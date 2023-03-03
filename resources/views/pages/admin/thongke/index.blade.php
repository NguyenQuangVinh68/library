@extends('pages.admin.thongke.layout')
@section('content')
    @inject('carbon', 'Carbon\Carbon')
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

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#macdinh" role="tab"
                            aria-controls="home" aria-selected="false" tabindex="-1">Lọc theo mục</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tuychinh" role="tab"
                            aria-controls="profile" aria-selected="true">Tùy chỉnh</a>
                    </li>
                </ul>

                {{-- content --}}
                <div class="tab-content" id="myTabContent">

                    {{-- defauld --}}
                    <div class="tab-pane fade active show" id="macdinh" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Thời gian</label>
                                                        <select class="form-select" id="thoigian" name="thoigian">
                                                            <option value="ngay">Ngày</option>
                                                            <option value="thang">Tháng</option>
                                                            <option value="nam">Năm</option>
                                                        </select>
                                                    </div>

                                                    {{-- view current option --}}
                                                    <div class=" position-relative " style="width: 100%; height:90px">
                                                        <div
                                                            class="position-absolute w-100 top-0 start-0 thoigian hien_ngay ">
                                                            <label for="">Chọn ngày cụ thể</label>
                                                            <input type="date" class="form-control" id="ngaycuthe">
                                                        </div>
                                                        <div class="position-absolute w-100 top-0 start-0 thoigian hien_thang "
                                                            style="display:none;">
                                                            <label for="">Chọn tháng cụ thể</label>
                                                            <input type="month" class="form-control" id="thangcuthe">
                                                        </div>
                                                        <div class="position-absolute w-100 top-0 start-0 thoigian hien_nam "
                                                            style="display:none;">
                                                            <label for="">Chọn năm cụ thể</label>
                                                            <select class="form-select" id="namcuthe">
                                                                @for ($year = $carbon::now()->year - 5; $year <= $carbon::now()->year + 2; $year++)
                                                                    <option
                                                                        {{ $year == $carbon::now()->format('Y-m-d') ? 'selected' : '' }}>
                                                                        {{ $year }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>

                                                    </div>
                                                    {{-- end view current option --}}
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Chuyên ngành</label>
                                                        <select class="form-select" id="inputGroupSelect01"
                                                            name="chuyennganh">
                                                            <option value="">Chọn khoa/ngành</option>
                                                            @foreach ($khoas as $khoa)
                                                                <option value="{{ $khoa->tenkhoa }}">Khoa
                                                                    {{ $khoa->tenkhoa }}
                                                                </option>
                                                            @endforeach
                                                            @foreach ($nganhs as $nganh)
                                                                <option value="{{ $nganh->tennganh }}">Ngành
                                                                    {{ $nganh->tennganh }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button class="btn btn-primary btn-macdinh">Thống kê</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end defauld --}}

                    {{-- tùy chỉnh --}}
                    <div class="tab-pane fade" id="tuychinh" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Từ ngày</label>
                                                        <input type="date" class="form-control" name="tungay" required>
                                                        <span class="error_tungay message_error text-danger fw-bold"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Đến ngày</label>
                                                        <input type="date" class="form-control" name="denngay"
                                                            required>
                                                        <span
                                                            class="error_denngay message_error text-danger fw-bold"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button class="btn btn-primary btn-tuychinh">Thống
                                                        kê</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end tùy chỉnh --}}
                </div>
                {{-- end content --}}
            </div>
        </div>
    </section>
    {{-- hiện thị kết quả thống kê --}}
    <section class="hienthi_thongke" id="hienthi_thongke">
        <h2 class="card-title text-center my-2">Thống kê hoạt động trong ngày hôm nay</h2>
        @include('inc.admin-list-thongke', ['danhsachmuon', 'danhsachtra', 'danhsachmat'])
    </section>

    {{-- pagination --}}
    {{-- @if (isset($kq))
        {{ $kq->links('inc.pagination') }}
    @endif --}}
    {{-- end pagination --}}
@endsection

@push('ajax')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
            // change option => view current option
            $("#thoigian").change(function() {
                var value_thoigian = $(this).val();
                // ẩn hiện theo lựa chọn
                $('.thoigian').slideUp();
                $('.hien_' + value_thoigian).slideDown();
            })

            // tab mặc định có thời gian và ngành
            $('.btn-macdinh').click(function(ev) {
                ev.preventDefault();
                var thoi_gian = $('select[name="thoigian"]').val()
                var chuyen_nganh = $('select[name="chuyennganh"]').val()
                var thongKeURL = '{{ route('thongke.loctheomuc') }}';
                var thoigian_cuthe = null;
                console.log(chuyen_nganh);
                // lấy dữ liệu theo option


                if (thoi_gian == 'ngay') {
                    thoigian_cuthe = $('#ngaycuthe').val();
                    $('#ngaycuthe').change(function(ev) {
                        ev.preventDefault();
                        thoigian_cuthe = $(this).val();
                    })

                } else if (thoi_gian == 'thang') {
                    thoigian_cuthe = $('#thangcuthe').val();
                    $('#thangcuthe').change(function(ev) {
                        ev.preventDefault();
                        thoigian_cuthe = $(this).val();
                    })

                } else {
                    thoigian_cuthe = $('#namcuthe').val();
                    $('#thangcuthe').change(function(ev) {
                        ev.preventDefault();
                        thoigian_cuthe = $(this).val();
                    })
                }

                $.ajax({
                    url: thongKeURL,
                    method: 'POST',
                    data: {
                        'thoi_gian': thoi_gian,
                        'thoigian_cuthe': thoigian_cuthe,
                        'chuyennganh': chuyen_nganh
                    },
                    beforeSend: function() {
                        $('#hienthi_thongke').html('<h1 class"text-center">Loading ...</h1>');
                    },
                    success: function(res) {
                        $('#hienthi_thongke').html(res);
                    }
                })
            })

            // tab tùy chỉnh
            $('.btn-tuychinh').click(function(ev) {
                ev.preventDefault();
                var tungay = $('input[name="tungay"]').val();
                var denngay = $('input[name="denngay"]').val();
                var tuychinhURL = '{{ route('thongke.tuychinh') }}';

                $.ajax({
                    url: tuychinhURL,
                    method: "POST",
                    data: {
                        'tungay': tungay,
                        'denngay': denngay
                    },
                    beforeSend: function() {
                        $('.message_error').html("");
                        $('#hienthi_thongke').html('<h1 class"text-center">Loading ...</h1>');
                    },
                    success: function(res) {
                        if (res.error) {
                            $.each(res.error, function(prefix, val) {
                                $('span.error_' + prefix).html(val);
                            })

                        } else {
                            $('input[name="tungay"]').val("");
                            $('input[name="denngay"]').val("");
                            // console.log(res);
                            $('#hienthi_thongke').html(res);
                        }
                    }
                })
            })
        })
    </script>
@endpush
