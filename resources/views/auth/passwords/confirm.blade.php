@extends('layouts.auth')

@section('fomr')
    <div class=" auth-container">
        <form class="form-auth" action="{{ route('password.confirm') }}" method="POST">
            @csrf
            <h3 class="my-4 text-center">Xác nhận mật khẩu</h3>
            <div class="form-auth__group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    autocomplete="current-password" placeholder="Nhập mật khẩu">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-auth__group">
                <a href="{{ route('password.request') }}" class="d-block text-center ">Quên mật khẩu ?</a>
            </div>
            <div class="form-auth__group">
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </div>
            <div class="form-auth__group">
                <p class="text-center">Bạn chưa có tài khoản?<a href="{{ route('register') }}" class="fw-bold"> Đăng kí</a>
                </p>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Confirm Password') }}</div>

                    <div class="card-body">
                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Confirm Password') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
