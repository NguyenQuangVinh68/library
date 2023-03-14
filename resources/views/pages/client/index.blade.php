@extends('layouts.client')

@section('main')
    <div class="banner text-white">
        <div class="d-flex align-items-center justify-content-center" style="height: 450px;">
            <div>
                <h1 id="title_search" class="mb-4">Tìm kiếm sách trong thư viện</h1>
                <div class=" ">
                    <x-form-search />
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="my-5 container">
            <h3 class="text-center ">7 đầu sách mới nhất</h3>
            <div class="slider my-5">
                @php
                    use App\Models\Sach;
                    $saches = Sach::orderBy('id', 'DESC')
                        ->limit(10)
                        ->get();
                @endphp
                @foreach ($saches as $sach)
                    <div class="card border-0">
                        <div class="card-body " style=" background-color: transparent !important;">
                            <a href="{{ route('sach.chitiet', ['sach_id' => $sach->id]) }}">
                                <img class="w-100" src="{{ asset('assets/images/books/' . $sach->anhbia) }}"
                                    alt="">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('slick')
    <script src="{{ asset('assets/js/slick-custom.js') }}"></script>
@endpush
