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
            <div class="row">
                <div class="col-lg-3 col-12 ">
                    <div class="logo" style="">
                        <a href="#"><img src="{{ asset('assets/images/logo/logo_itc.png') }}" alt="Logo"
                                style="width:70px; height:70px; border-radius:100rem"></a>
                    </div>
                </div>
                <div class="col-lg-9 col-12 mt-4  d-flex justify-content-end ">
                    <div class="header-top-right gap-2">
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

                        <div class="dropdown">
                            <button class="btn fw-bold dropdown-toggle " type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Theme
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                                <div class="theme-toggle d-flex gap-2 align-items-center mt-2 justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true" role="img" class="iconify iconify--system-uicons"
                                        width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                        viewBox="0 0 21 21">
                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                                opacity=".3"></path>
                                            <g transform="translate(-210 -1)">
                                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                                <path
                                                    d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <div class="form-check form-switch fs-6">
                                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                            style="cursor: pointer" />
                                        <label class="form-check-label"></label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                        height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                        </path>
                                    </svg>
                                </div>
                            </ul>
                        </div>
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
                    <a href="#" class="menu-link">
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
