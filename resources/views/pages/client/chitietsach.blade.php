@extends('layouts.client')
@section('main')
    <h3 class="thongbao p-5 text-center" style="display: none;"></h3>
    @if (isset($sach))
        <div class="container mt-5">
            <x-book.book-detail :sach="$sach" />
        </div>

        {{-- comment --}}
        <div class="container">
            <x-comment :sach="$sach" />
        </div>
        {{-- end comment --}}

        {{-- script --}}
        @push('ajax')
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })

                // get id user
                var id_user = "{{ Auth::id() }}";
                var sach = "{{ $sach->id }}";

                // yêu thích
                $(document).on('click', '#wishList', function(ev) {
                    ev.preventDefault();
                    var book_id = $(this).data("bookid");

                    if (id_user) {
                        $.ajax({
                            url: '{{ route('sach.yeuthich') }}',
                            method: "POST",
                            data: {
                                book_id: book_id,
                                id_user: id_user
                            },
                            success: function(response) {
                                if (response.action == "add") {
                                    $('#wishList').html(
                                        `<i class="bi bi-heart-fill text-danger "></i>`)
                                    $(".thongbao").fadeIn();
                                    $(".thongbao").css("background", "#198754");
                                    $(".thongbao").text(response.message);
                                    setTimeout(() => {
                                        $(".thongbao").fadeOut();
                                    }, 1000);
                                } else {
                                    $('#wishList').html(
                                        `<i class="bi bi-heart-fill text-white "></i>`)
                                    $(".thongbao").fadeIn();
                                    $(".thongbao").css("background", "#dc3545");
                                    $(".thongbao").text(response.message);
                                    setTimeout(() => {
                                        $(".thongbao").fadeOut();
                                    }, 1000);
                                }
                            }
                        })
                    } else {
                        window.location.href = "/login";
                    }
                });

                // // đánh giá
                $("#rateYo").rateYo({
                    starWidth: "20px",
                    normalFill: "#A0A0A0",
                    fullStar: false,
                    rating: 5,
                    onSet: function(rating, rateYoInstance) {
                        $("#rating").val(rating);
                        alert(rating);
                    }
                });

                // bình luận
                $(document).on('click', '#btn-binhluan', function(ev) {
                    ev.preventDefault();
                    if (id_user) {
                        var bl_noidung = $('#bl_noidung').val();
                        var _binhluanURL = '{{ route('ajax.binhluan', $sach->id) }}';
                        $.ajax({
                            url: _binhluanURL,
                            type: 'POST',
                            data: {
                                'bl_noidung': bl_noidung,
                            },
                            success: function(response) {
                                if (response.error) {
                                    $('#bl_error').html(response.error)
                                } else {
                                    $('#bl_error').html("")
                                    $('#bl_noidung').val("");
                                    $('#list-comment').html(response);
                                    // console.log(response);
                                }
                            },
                        });
                    } else {
                        window.location.href = "/login";
                    }
                })

                // reply form
                $(document).on('click', '.btn-show-form-reply', function(ev) {
                    ev.preventDefault();
                    var id_comment = $(this).data('id_comment')
                    var form_reply = '.form-reply-' + id_comment;

                    // ẩn hiện form trả lời
                    $('.formReply').slideUp();
                    $(form_reply).slideDown();
                })

                // reply send
                $(document).on('click', '.btn-send-comment-reply', function(ev) {
                    ev.preventDefault();

                    var id_comment = $(this).data('id_comment')

                    // lấy nội dung từ form trả lời
                    var id_comment_reply = '#tl_noidung' + id_comment;
                    var bl_reply_noidung = $(id_comment_reply).val();

                    var _binhluanURL = '{{ route('ajax.binhluan', $sach->id) }}';
                    $.ajax({
                        url: _binhluanURL,
                        type: 'POST',
                        data: {
                            'bl_noidung': bl_reply_noidung,
                            'traloi_id': id_comment
                        },
                        success: function(response) {
                            if (response.error) {
                                $('#bl_error').html(response.error)
                            } else {
                                $('#bl_error').html("")
                                $('#bl_noidung').val("");
                                $('#list-comment').html(response);
                                // console.log(response);
                            }
                        },
                    });

                })

                // mượn sách
                $(document).on('click', '.btn-muonsach', function(ev) {

                    ev.preventDefault();
                    if (id_user) {
                        var id_sach = $(this).data('id_sach')
                        var _muonsachURL = '{{ route('ajax.muonsach') }}';
                        $.ajax({
                            url: _muonsachURL,
                            type: 'POST',
                            data: {
                                'id_sach': id_sach,
                            },
                            success: function(response) {
                                if (response.error) {
                                    $(".thongbao").fadeIn();
                                    $(".thongbao").css("background", "#dc3545");
                                    $(".thongbao").text(response.error);
                                    setTimeout(() => {
                                        $(".thongbao").fadeOut();
                                    }, 10000);
                                } else {
                                    $(".thongbao").fadeIn();
                                    $(".thongbao").css("background", "#198754");
                                    $(".thongbao").text(response.success);
                                    setTimeout(() => {
                                        $(".thongbao").fadeOut();
                                    }, 10000);
                                }
                            },
                        });
                    } else {
                        window.location.href = "/login";
                    }
                })
            </script>
        @endpush
        {{-- end script --}}
    @else
        <div class="container my-5">
            <h3 class="alert-danger p-3 text-center">Không có dữ liệu</h3>
        </div>
    @endif
@endsection
