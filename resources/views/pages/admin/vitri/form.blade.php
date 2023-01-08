@extends('pages.admin.vitri.layout')
@section('content')
    @if (session('message'))
        <div class="alert alert-danger mt-5">
            {{ session('message') }}
        </div>
    @endif
    <div class="w-50 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">{{ isset($vitri) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục' }}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" autocomplete="off"
                        action="{{ isset($vitri) ? route('vitri.update', $vitri->id) : route('vitri.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($vitri))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên vị trí</label>
                                        <input type="text" id="tenvitri" class="form-control" name="tenvitri"
                                            placeholder="Nhập tên vị trí"
                                            value="{{ isset($vitri) ? $vitri->tenvitri : '' }}">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        {{ isset($vitri) ? 'Cập nhật' : 'Thêm' }}
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
