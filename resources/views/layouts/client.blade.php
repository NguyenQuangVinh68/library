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
        .icon_theme {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 2.2rem;
            width: 2.2rem;
            cursor: pointer;
            background: #435ebe;
            border-radius: 100vh;
        }

        .img_icon {
            width: 1rem;
            heigh: 1rem;
            z-index: 1000000;
        }

        @media only screen and (max-width:769px) {
            .font-login {
                font-size: 13px
            }
        }
    </style>
</head>

@php
    $theme = \Cookie::get('theme');
    if ($theme != 'theme-dark' && $theme != 'theme-light') {
        $theme = 'theme-dark';
        $icon_img = '/assets/images/icon/sun.png';
    }
@endphp

<body class="{{ $theme }}">

    {{-- <div id="toggle-theme" class="icon_theme ">
        <img src={{ isset($icon_img) ? $icon_img : ($theme == 'theme-dark' ? '/assets/images/icon/sun.png' : '/assets/images/icon/moon.png') }}
            id="img_icon" class="img_icon " alt="">
    </div> --}}

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
    <script src="{{ asset('assets/js/client.js') }}"></script>
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

    <script>
        // toggle theme
        var toggle_icon = document.getElementById('toggle-theme')
        var body = document.getElementsByTagName('body')[0];
        var dark_theme_class = 'theme-dark';
        var light_theme_class = 'theme-light';
        toggle_icon.addEventListener('click', function() {
            if (body.classList.contains(dark_theme_class)) {
                body.classList.remove(dark_theme_class);
                body.classList.add(light_theme_class);
                document.images['img_icon'].src = '/assets/images/icon/moon.png';
                setCookie('theme', 'theme-light');
            } else {
                body.classList.remove(light_theme_class);
                body.classList.add(dark_theme_class);
                document.images['img_icon'].src = '/assets/images/icon/sun.png';
                setCookie('theme', 'theme-dark');
            }
        })

        function setCookie(name, value) {
            var d = new Date();
            d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            var a = name + "=" + value + ";" + expires
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }
    </script>
</body>

</html>
