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
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        .auth-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgb(12, 9, 101);
            background: linear-gradient(99deg, rgba(12, 9, 101, 0.949544783733806) 6%, rgba(41, 89, 176, 0.9103290974592962) 47%, rgba(39, 88, 180, 0.6890405820531338) 100%);
        }

        .form-auth {
            width: 400px;
            margin: 0 auto;
            padding: 2rem 3rem;
            border-radius: 10px;
            background: #262424;
        }

        .form-auth h3 {
            color: #fff !important;
        }

        .form-auth__group {
            margin-bottom: 25px;
        }

        .form-auth__group a {
            text-decoration: none;
            font-weight: 400;
            color: #c2c0d2 !important;
        }

        .form-auth__group input {
            background: #262424 !important;
            boder: 1px solid #c1bcbc !important;
            color: #fff !important;
        }

        .form-auth__group input:focus {
            outline: none;
            box-shadow: 0 0 0 0.1rem rgba(255, 255, 255, 0.803) !important;
        }

        .form-control {
            color: #fff !important;
        }

        .form-label {
            color: #fff !important;
        }

        @media (max-width: 376px) {
            .form-auth {
                width: 100%;
                margin: 0 10px;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <main>
        @yield('form')
    </main>

    {{-- script --}}
    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/changTabData.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
