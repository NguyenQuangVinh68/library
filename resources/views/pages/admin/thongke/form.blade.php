@extends('pages.admin.sach.layout')
@section('content')
    @if (session('message'))
        <div class="alert alert-danger mt-5">
            {{ session('message') }}
        </div>
    @endif
    <?php
    
    ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">{{ isset($sach) ? 'Chỉnh sửa sách' : 'Thêm sách' }}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" autocomplete="off"
                        action="{{ isset($sach) ? route('sach.update', $sach->id) : route('sach.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($sach))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label>Nhan đề</label>
                                        <input required type="text" id="nhande" class="form-control" name="nhande"
                                            placeholder="Nhập nhan đề" value="{{ isset($sach) ? $sach->nhande : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Tác giả</label>
                                        <input required type="text" id="tacgia" class="form-control" name="tacgia"
                                            placeholder="Nhập tác giả" value="{{ isset($sach) ? $sach->tacgia : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Danh mục</label>
                                        {{-- <fieldset class="form-group">
                                            <select name="danhmuc" id="danhmuc" class="form-select">
                                                @foreach ($danhmucs as $danhmuc)
                                                    <option value="{{ $danhmuc->tendm }}"
                                                        {{ isset($sach) ? ($sach->danhmuc == $danhmuc->tendm ? 'selected' : '') : '' }}>
                                                        {{ $danhmuc->tendm }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset> --}}
                                        <fieldset class="form-group">
                                            <select class="form-select" id="basicSelect">
                                                <option>IT</option>
                                                <option>Blade Runner</option>
                                                <option>Thor Ragnarok</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Ảnh bìa</label>
                                        <input type="file" id="anhbia" class="form-control" name="anhbia"
                                            placeholder="Chọn hình ảnh" {{ isset($sach) ? '' : 'required' }}>
                                        @if (isset($sach))
                                            <img src="{{ asset('assets/images/books/' . $sach->anhbia) }}" alt=""
                                                style="width:10%">
                                        @endif
                                        {!! $errors->first('anhbia', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Ngành</label>
                                        <select name="nganh" id="nganh" class="form-select">
                                            @foreach ($nganhs as $nganh)
                                                <option value="{{ $nganh->id }}"
                                                    {{ isset($sach) ? ($sach->nganh == $nganh->tennganh ? 'selected' : '') : '' }}>
                                                    {{ $nganh->tennganh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Thông tin xuất bản</label>
                                        <input required type="text" id="thongtinxb" class="form-control"
                                            name="thongtinxb" placeholder="Nhập thông tin xuất bản"
                                            value="{{ isset($sach) ? $sach->thongtinxb : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Vị trí</label>
                                        <select name="vitri" id="vitri" class="form-select">
                                            @foreach ($vitris as $vitri)
                                                <option value="{{ $vitri->tenvitri }}"
                                                    {{ isset($sach) ? ($sach->vitri == $vitri->tenvitri ? 'selected' : '') : '' }}>
                                                    {{ $vitri->tenvitri }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input required type="text" id="soluong" class="form-control" name="soluong"
                                            placeholder="Nhập số lượng" value="{{ isset($sach) ? $sach->soluong : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input required type="text" id="gia" class="form-control" name="gia"
                                            placeholder="Nhập giá sách" value="{{ isset($sach) ? $sach->gia : '' }}">
                                    </div>
                                </div>
                                {{-- btn --}}
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        {{ isset($sach) ? 'Cập nhật' : 'Thêm' }}
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
