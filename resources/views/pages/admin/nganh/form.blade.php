@extends('pages.admin.nganh.layout')
@section('content')
    @if (session('message'))
        <div class="alert alert-danger mt-5">
            {{ session('message') }}
        </div>
    @endif
    <?php
    use App\Models\Khoa;
    
    $khoas = Khoa::all();
    ?>
    <div class="w-50 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">{{ isset($nganh) ? 'Chỉnh sửa ngành' : 'Thêm ngành' }}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" autocomplete="off"
                        action="{{ isset($nganh) ? route('nganh.update', $nganh->id) : route('nganh.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($nganh))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Mã ngành</label>
                                        <input required type="text" id="manganh" class="form-control" name="manganh"
                                            placeholder="Nhập mã ngành..."
                                            value="{{ isset($nganh) ? $nganh->manganh : '' }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên ngành</label>
                                        <input required type="text" id="slug" class="form-control" name="tennganh"
                                            placeholder="Nhập tên ngành..."
                                            value="{{ isset($nganh) ? $nganh->tennganh : '' }}" onkeyup="ChangeToSlug()">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input required type="text" id="convert_slug" class="form-control" name="slug"
                                            placeholder="Nhập tên slug" value="{{ isset($nganh) ? $nganh->slug : '' }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên khoa</label>
                                        <select name="makhoa" id="makhoa" class="form-select">
                                            @foreach ($khoas as $khoa)
                                                <option value="{{ $khoa->id }}"
                                                    {{ isset($nganh) ? ($khoa->id == $nganh->makhoa ? 'selected' : '') : '' }}>
                                                    {{ $khoa->tenkhoa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        {{ isset($nganh) ? 'Cập nhật' : 'Thêm' }}
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
