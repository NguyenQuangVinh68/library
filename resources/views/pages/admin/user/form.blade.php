@extends('pages.admin.user.layout')
@section('content')
    @if (session('message'))
        <div class="alert alert-danger mt-5">
            {{ session('message') }}
        </div>
    @endif

    <div class="container">
        <div class=" w-50 mx-auto form__content">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title text-center">
                        {{ isset($user) ? 'Chỉnh sửa thông tin người dùng' : 'Thêm người dùng' }}
                    </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" autocomplete="off"
                            action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @else
                                @method('POST')
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <label>Mã số</label>
                                            <input required type="text" id="ma_user"
                                                class="form-control @error('ma_user') is-invalid @enderror" name="ma_user"
                                                placeholder="Nhập mã số" value="{{ isset($user) ? $user->ma_user : '' }}">
                                            @error('ma_user')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <label>Tên</label>
                                            <input required type="text" id="ten_user"
                                                class="form-control @error('ten_user') is-invalid @enderror" name="ten_user"
                                                placeholder="Nhập tên" value="{{ isset($user) ? $user->ten_user : '' }}">
                                            @error('ten_user')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <label>Email</label>
                                            <input required type="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                placeholder="Nhập email" value="{{ isset($user) ? $user->email : '' }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- @if (!isset($user)) --}}
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <label>Password</label>
                                            <input required type="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="Nhập password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- @endif --}}
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <label>Vai trò</label>
                                            <select name="role" id="role" class="form-select">
                                                <option value="0"
                                                    {{ isset($user) ? ($user->role == 0 ? 'selected' : '') : '' }}>Sinh
                                                    viên</option>
                                                <option value="1"
                                                    {{ isset($user) ? ($user->role == 1 ? 'selected' : '') : '' }}>Admin
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- btn --}}
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                    {{ isset($user) ? 'Cập nhật' : 'Thêm' }}
                                </button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                    Đặt lại
                                </button>
                            </div>
                            {{-- end btn --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
