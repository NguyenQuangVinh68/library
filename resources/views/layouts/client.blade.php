<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app_client.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <style>
        @media only screen and (max-width:769px) {
            .font-login {
                font-size: 13px
            }
        }
    </style>
</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>

    {{-- @if (session('thongbao'))
        @php
            echo '<script>
                alert("'.$thongbao .'")
            </script>';
        @endphp
    @endif --}}

    <div id="app" class="layout-horizontal">

        @include('inc.client-header')

        {{-- main --}}
        @yield('main')
        {{-- endmain --}}

        @include('inc.client-footer')

        <div id="back-header" style="display:none">
            <div class="fixed-bottom text-white d-flex justify-content-center align-items-center end-0 mb-3 me-3 "
                style=" width:40px;height:40px;background: #f953c6;  /* fallback for old browsers */
                background: -webkit-linear-gradient(120deg, #b91d73, #f953c6);  /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(120deg, #b91d73, #f953c6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                
            ">
                <a href="#app" class="nav-link "><i class="bi bi-chevron-up fs-3 fw-bold"></i></a>
            </div>
        </div>

    </div>

    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/horizontal-layout.js') }}"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('assets/js/jquery.rateyo.min.js') }}"></script>
    @stack('slick')
    @stack('ajax')

    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                var showAfter = 100;
                if ($(this).scrollTop() > showAfter) {
                    $('#back-header').fadeIn()
                } else {
                    $('#back-header').fadeOut()

                }
            })
            $('#back-header').click(function(ev) {
                ev.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 200)
                return false
            })
        })
    </script>
</body>

</html>
