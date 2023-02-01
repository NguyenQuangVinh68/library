@extends('pages.admin.muonsach.layout')
@section('content')
    <div class="container w-50 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Thêm số ngày gia hạn</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('giahan.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Số ngày gia hạn</label>
                        <input type="hidden" name="mamuon" value="{{ $id }}">
                        <input type="text" class="form-control @error('songay_giahan') is-invalid @enderror"
                            name="songay_giahan" placeholder="Nhập số ngày cần gia hạn">
                        @error('songay_giahan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="submit" class="btn btn-primary mt-2">Gia hạn</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
