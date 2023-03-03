@extends('layouts.auth')

@section('form')
    <div class=" auth-container">
        <form class="form-auth" action="{{ route('register') }}" method="POST">
            @csrf
            <h3 class="my-4 text-center">Đăng Kí</h3>
            <div class="form-auth__group">
                <label class="form-label">Mã sinh viên</label>
                <input type="text" class="form-control @error('ma_user') is-invalid @enderror" name="ma_user"
                    value="{{ old('ma_user') }}" placeholder="Nhập mã sinh viên" autocomplete="off">
                @error('ma_user')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-auth__group">
                <label class="form-label">Tên sinh viên</label>
                <input type="text" class="form-control @error('ten_user') is-invalid @enderror" name="ten_user"
                    value="{{ old('ten_user') }}" placeholder="Nhập tên sinh viên" autocomplete="off">
                @error('ten_user')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-auth__group">
                <label class="form-label">Email </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" placeholder="Nhập email" autocomplete="off">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-auth__group">
                <label class="form-label">Mật khẩu</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    placeholder="Nhập mật khẩu">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-auth__group">
                <button class="btn btn-primary w-100">Đăng kí</button>
            </div>
            <div class="form-auth__group">
                <p class="text-center">Bạn đã có tài khoản?<a href="{{ route('login') }}" class="fw-bold"> Đăng nhập</a></p>
            </div>
        </form>
    </div>
@endsection
