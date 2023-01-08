<article>
    <div class="card">
        <div class="card-header pb-2">

            <h4 class="card-title text-capitalize">
                <a href="{{ route('sach.chitiet', ['sach_id' => $sach->id]) }}" class="nav-link">{{ $sach->nhande }}</a>
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2  col-4">
                    <a href="{{ route('sach.chitiet', ['sach_id' => $sach->id]) }}" class="nav-link">
                        <img src="{{ asset('assets/images/books/' . $sach->anhbia) }}" alt="book" class="w-100">
                    </a>
                </div>
                <div class="col-lg-10 col-8">
                    <p class="card-title fw-bold">Thông tin suất bản: <span class="text-capitalize"
                            style="font-weight:100"><i>{{ $sach->thongtinxb }}</i></span>
                    </p>
                    <p class="card-title fw-bold">Tác giả: <span class="text-capitalize"
                            style="font-weight:100; "><i>{{ $sach->tacgia }}</i></span>
                    </p>
                    <p class="card-title
                                fw-bold">Chuyên ngành: <span
                            class="text-capitalize" style="font-weight:100 "><i>{{ $sach->nganh }}</i></span></p>
                    <p class="card-title fw-bold">Mã sách: <span
                            style="font-weight:100"><i>{{ $sach->id }}</i></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

</article>
