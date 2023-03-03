@php
    use App\Models\Khoa;
    use App\Models\Nganh;
    use App\Models\Danhmuc;
    use App\Models\Sach;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    
    $nganhs = Nganh::all();
    $khoas = Khoa::all();
    $danhmucs = Danhmuc::all();
    
@endphp

<header class="">
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-3 ">
                    <div class="logo" style="">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo/logo_itc.png') }}"
                                alt="Logo" style="width:70px; height:70px; border-radius:100rem"></a>
                    </div>
                </div>
                <div class="col-lg-9 col-9 d-flex justify-content-end ">
                    <div class="header-top-right d-flex gap-2 align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="dropdown-item">
                                    <span class="font-login btn fw-bold">Đăng nhập</span>
                                </a>
                            @endif
                        @else
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{-- <div class="avatar avatar-md2">
                                        <img src="assets/images/faces/1.jpg" alt="Avatar">
                                    </div> --}}
                                    <div class="text">
                                        <h6 class="user-dropdown-name text-capitalize">
                                            {{ Str::words(Auth::user()->ten_user, 2, ' ...') }}</h6>
                                        <p class="user-dropdown-status text-sm text-muted text-capitalize">
                                            {{ Auth::user()->role == 0 ? 'sinh viên' : 'admin' }}
                                        </p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown"
                                    style="">
                                    <li><a class="dropdown-item" href="#">My Account</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                            Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>

                                    </li>
                                </ul>
                            </div>

                        @endguest
                        <!-- Burger button responsive -->
                        <a href="#" class="burger-btn d-block d-xl-none">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- header search --}}
    @if (url()->current() != route('home'))
        <div class="search-main border-bottom">
            <div class="search-main__header">
                <x-form-search />
            </div>
        </div>
    @endif
    {{-- menu --}}

    <nav class="main-navbar">
        <div class="container">
            <ul>
                <li class="menu-item">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span><i class="bi bi-house-door-fill"></i>Trang chủ</span>
                    </a>
                </li>

                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <span><i class="bi bi-file-earmark-medical-fill"></i>
                            Danh mục</span>
                    </a>
                    @if (isset($danhmucs))
                        <div class="submenu">
                            <div class="submenu-group-wrapper">
                                <ul class="submenu-group">
                                    @foreach ($danhmucs as $danhmuc)
                                        @php
                                            // Kiểm tra xem có sách nào nằm trong danh mục hiện tại không
                                            $issetCategoryInKhoa = DB::table('saches')
                                                ->join('khoas', 'khoas.tenkhoa', '=', 'saches.khoa')
                                                ->join('danhmucs', 'danhmucs.tendm', '=', 'saches.danhmuc')
                                                ->where('saches.danhmuc', $danhmuc->tendm)
                                                ->exists();
                                        @endphp
                                        @if ($issetCategoryInKhoa)
                                            <li class="submenu-item {{ $issetCategoryInKhoa == 1 ? 'has-sub' : '' }}">
                                                <a href="{{ route('sach.danhmuc', ['slug' => $danhmuc->slug]) }}"
                                                    class="submenu-link text-capitalize">{{ $danhmuc->tendm }}</a>

                                                @if ($issetCategoryInKhoa)
                                                    <ul class="subsubmenu">
                                                        <li class="subsubmenu-item">
                                                            <div class="submenu-group-wrapper">
                                                                @if (isset($khoas))
                                                                    @foreach ($khoas as $khoa)
                                                                        @php
                                                                            // kiểm tra xem có khoa nào sẽ xuất hiện hay không
                                                                            $issetCategoryInBookKhoa = DB::table('saches')
                                                                                ->join('khoas', 'khoas.tenkhoa', '=', 'saches.khoa')
                                                                                ->join('danhmucs', 'danhmucs.tendm', '=', 'saches.danhmuc')
                                                                                ->where('danhmucs.tendm', $danhmuc->tendm)
                                                                                ->where('saches.khoa', $khoa->tenkhoa)
                                                                                ->exists();
                                                                            
                                                                        @endphp
                                                                        @if ($issetCategoryInBookKhoa)
                                                                            <ul class="submenu-group">
                                                                                <li class="submenu-item">
                                                                                    <p
                                                                                        class="subsubmenu-link text-capitalize">
                                                                                        {{ $khoa->tenkhoa == 'công nghệ thông tin - điện tử' ? 'CNTT-DT' : $khoa->tenkhoa }}
                                                                                    </p>
                                                                                </li>
                                                                                <hr>
                                                                                @foreach ($nganhs as $nganh)
                                                                                    @php
                                                                                        // kiểm tra xem có khoa nào sẽ xuất hiện hay không
                                                                                        $issetCategoryInBookNganh = DB::table('saches')
                                                                                            ->join('khoas', 'khoas.tenkhoa', '=', 'saches.khoa')
                                                                                            ->join('danhmucs', 'danhmucs.tendm', '=', 'saches.danhmuc')
                                                                                            ->where('danhmucs.tendm', $danhmuc->tendm)
                                                                                            ->where('saches.nganh', $nganh->tennganh)
                                                                                            ->exists();
                                                                                    @endphp

                                                                                    @if ($issetCategoryInBookNganh)
                                                                                        @if ($nganh->makhoa == $khoa->id)
                                                                                            <li class="submenu-item">
                                                                                                <a href="{{ route('sach.nganh', ['slugDanhmuc' => $danhmuc->slug, 'slugNganh' => $nganh->slug]) }}"
                                                                                                    class="subsubmenu-link text-capitalize">
                                                                                                    {{ $nganh->tennganh }}
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </li>

                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </li>

                <li class="menu-item active ">
                    <a href="{{ route('bangxephang') }}" class="menu-link">
                        <span><i class="bi bi-award-fill"></i>Bảng xếp hạng</span>
                    </a>
                </li>
                @auth
                    <li class="menu-item active ">
                        <a href="{{ route('sach.dangmuon') }}" class="menu-link">
                            <span><i class="bi bi-book-fill"></i>Đanh sách mượn</span>
                        </a>
                    </li>
                    <li class="menu-item active ">
                        <a href="{{ route('sach.danhsachyeuthich') }}" class="menu-link">
                            <span><i class="bi bi-heart-fill"></i>Yêu thích</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    {{-- end menu --}}
</header>
