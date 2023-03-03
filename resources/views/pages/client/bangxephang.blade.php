@extends('layouts.client')
@section('main')
    <section class="section my-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center text-capitalize">bảng xếp hạng top 10</h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item " role="presentation">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home"
                                        role="tab" aria-controls="home" aria-selected="true" tabindex="-1">Sách mượn
                                        đọc
                                        nhiều nhất</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false" tabindex="-1">Sách Yêu thích nhất</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="my-5">
                                        @if ($sach_muon->isNotEmpty())
                                            @foreach ($sach_muon as $sachmuon)
                                                <x-book.books :sach='$sachmuon' />
                                            @endforeach
                                        @else
                                            <h3 class="alert-danger p-5">Không có dữ liệu</h3>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="my-5">
                                        @if ($sach_yeuthich->isNotEmpty())
                                            @foreach ($sach_yeuthich as $sachyeuthich)
                                                <x-book.books :sach='$sachyeuthich' />
                                            @endforeach
                                        @else
                                            <h3 class="alert-danger p-5">Không có dữ liệu</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
