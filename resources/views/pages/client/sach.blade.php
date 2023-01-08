@extends('layouts.client')
@section('main')
    @if ($saches->isNotEmpty())
        <div class="mt-5">
            <div class="container">
                @foreach ($saches as $sach)
                    <x-book.books :sach='$sach' />
                @endforeach
            </div>
        </div>
        @if (method_exists($saches, 'links'))
            {{ $saches->links('inc.pagination') }}
        @endif
    @else
        <div class=" container my-5">
            <div class="alert-danger p-3">
                <h3 class="mb-0 text-center">Không có dữ liệu</h3>
            </div>
        </div>
    @endif

@endsection
