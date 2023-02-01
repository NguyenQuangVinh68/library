@extends('layouts.client')
@section('main')
    <h3 class="thongbao p-5 text-center" style="display: none;"></h3>
    @if (isset($sach))
        <div class="container mt-5">
            @if (isset($size))
                <x-book.book-detail :sach="$sach" :rate="$aveRate" :size="$size" />
            @else
                <x-book.book-detail :sach="$sach" :rate="$aveRate" />
            @endif
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
                    halfStar: true,
                    rating: 5,
                    onSet: function(rating, rateYoInstance) {
                        if (id_user) {
                            $("#rating").val(rating);
                            const _ratingURL = '{{ route('sach.danhgia', $sach->id) }}'
                            $.ajax({
                                url: _ratingURL,
                                type: 'POST',
                                data: {
                                    'point': rating,
                                },
                                success: function(response) {

                                    if (response.error) {
                                        $(".bg-thongbao-danhgia").removeClass('bg-success');
                                        $(".icon-thongbao-danhgia").removeClass('bi-check-circle-fill');

                                        $(".bg-thongbao-danhgia").addClass('bg-danger');
                                        $(".icon-thongbao-danhgia").addClass('bi-x-circle-fill');
                                        $(".text-content_thongbao").html(response.error)
                                    } else {
                                        $(".bg-thongbao-danhgia").removeClass('bg-danger');
                                        $(".icon-thongbao-danhgia").removeClass('bi-x-circle-fill');

                                        $(".icon-thongbao-danhgia").addClass('bi-check-circle-fill');
                                        $(".bg-thongbao-danhgia").addClass('bg-success');
                                        $(".text-content_thongbao").html(response.success)
                                        $("span#display-ave-rating").html(response.aveRate)
                                    }
                                    $(".thongbao_danhgia").addClass('show');
                                    $(".thongbao_danhgia").fadeIn();
                                    setTimeout(() => {
                                        $(".thongbao_danhgia").removeClass('show');
                                        $(".thongbao_danhgia").fadeOut();
                                    }, 1000);
                                },
                            })
                        } else {
                            window.location.href = "/login";
                        }
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

    <div class="modal  thongbao_danhgia " id="success" tabindex="-1" aria-labelledby="myModalLabel110"
        style="display: none; background-color:rgba(1,1,1,0.5) ">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body bg-thongbao-danhgia">
                    <div class="text-center">
                        <h5 class=" text-center m-0 text-capitalize text-content_thongbao"></h5>
                        <i class="bi icon-thongbao-danhgia " style="font-size: 100px"></i>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
