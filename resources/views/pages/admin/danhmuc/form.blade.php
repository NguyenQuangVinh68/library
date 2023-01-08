@extends('pages.admin.danhmuc.layout')
@section('content')
    <div class="w-50 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">{{ isset($danhmuc) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục' }}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" autocomplete="off"
                        action="{{ isset($danhmuc) ? route('danh-muc.update', $danhmuc->id) : route('danh-muc.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($danhmuc))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên danh mục</label>
                                        <input type="text" id="slug" class="form-control" name="tendm"
                                            placeholder="Nhập tên danh mục"
                                            value="{{ isset($danhmuc) ? $danhmuc->tendm : '' }}" onkeyup="ChangeToSlug()">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input type="text" id="convert_slug" class="form-control" name="slug"
                                            placeholder="Nhập tên danh mục"
                                            value="{{ isset($danhmuc) ? $danhmuc->slug : '' }}">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        {{ isset($danhmuc) ? 'Cập nhật' : 'Thêm' }}
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
