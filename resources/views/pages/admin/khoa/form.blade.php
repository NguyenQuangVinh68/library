@extends('pages.admin.khoa.layout')
@section('content')
    @if (session('message'))
        <div class="alert alert-danger mt-5">
            {{ session('message') }}
        </div>
    @endif

    <div class="w-50 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">{{ isset($khoa) ? 'Chỉnh sửa khoa' : 'Thêm khoa' }}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" autocomplete="off"
                        action="{{ isset($khoa) ? route('khoa.update', $khoa->id) : route('khoa.store') }}" method="POST">
                        @csrf
                        @if (isset($khoa))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên khoa</label>
                                        <input type="text" class="form-control" name="tenkhoa" id="slug"
                                            onkeyup="ChangeToSlug()" placeholder="Nhập tên khoa"
                                            value="{{ isset($khoa) ? $khoa->tenkhoa : '' }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input type="text" class="form-control" name="slug" id="convert_slug"
                                            placeholder="Nhập tên khoa" value="{{ isset($khoa) ? $khoa->slug : '' }}">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        {{ isset($khoa) ? 'Cập nhật' : 'Thêm' }}
                                    </button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                        Đặt lại
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
