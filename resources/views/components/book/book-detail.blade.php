<article>
    <div class="card">
        <div class="card-header pb-2">
            <h4 class="card-title text-capitalize">{{ $sach->nhande }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2 col-md-3 col-lg-2 col-12">
                    <img src="{{ asset('assets/images/books/' . $sach->anhbia) }}" alt="book" class="w-100 ">

                </div>
                <div class="col-sm-10 col-md-9 col-lg-10 col-12">
                    <p class="card-title fw-bold">Tác giả: <span class="text-capitalize"
                            style="font-weight:100">{{ $sach->tacgia }}</span></p>
                    {{-- rating --}}
                    <div class="d-flex gap-2">
                        <div id="rateYo"></div>
                        <div class="fw-bold"><span id="display-ave-rating">{{ $rate }}</span><span>/5</span> </div>
                    </div>
                    {{-- end reating --}}
                    <p class="card-title fw-bold">Thông tin suất bản: <span class="text-capitalize"
                            style="font-weight:100">{{ $sach->thongtinxb }}</span>
                    </p>
                    <p class="card-title fw-bold">Chuyên ngành: <span class="text-capitalize"
                            style="font-weight:100">{{ $sach->nganh }}</span>
                    </p>

                    <p class="card-title fw-bold">Vị trí: <span class="text-capitalize"
                            style="font-weight:100">{{ $sach->vitri }}</span></p>
                    <p class="card-title fw-bold">Số lượng hiện có: <span class="text-capitalize"
                            style="font-weight:100">{{ $sach->soluong }}</span></p>
                    <p class="card-title fw-bold">Mã sách: <span class="text-capitalize"
                            style="font-weight:100">{{ $sach->id }}</span></p>
                    <p class="card-title fw-bold">Yêu thích:
                        <span id="wishList" data-bookid="{{ $sach->id }}" style="cursor: pointer">
                            @php
                                use Illuminate\Support\Facades\DB;
                                use App\Models\User;
                                if (Auth::id()) {
                                    $user = User::find(Auth::id());
                                    if (isset($user)) {
                                        $yeuthich = DB::table('yeuthichs')
                                            ->where('masach', $sach->id)
                                            ->where('ma_user', $user['ma_user'])
                                            ->exists();
                                    }
                                }
                            @endphp
                            <i
                                class="bi bi-heart-fill {{ isset($user) ? ($yeuthich ? 'text-danger' : 'text-white') : 'text-white' }} "></i>
                        </span>
                    </p>
                    @if (isset($size))
                        <a class=" btn btn-info mb-2 text-bottom col-12 col-md-5 col-lg-4"
                            href="{{ route('sach.taive', $sach->id) }}"><i class="bi bi-download"></i>&ensp;Tải sách
                            <span>({{ $size }})</span> </a>
                    @endif

                    <button class="mb-2 btn btn-primary btn-muonsach col-12 col-md-5 col-lg-3"
                        data-id_sach="{{ $sach->id }}" {{ $sach->soluong <= 0 ? 'disabled' : 'ok' }}>Đăng kí mượn
                        sách</button>

                </div>
            </div>
        </div>
    </div>
</article>
