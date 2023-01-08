@php
    use Illuminate\Support\Carbon;
    Carbon::setLocale('vi');
@endphp
<div class="row d-flex justify-content-center">
    <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card">
            <div class="card-body p-4">
                <h4 class="text-center mb-4 pb-2">Các bình luận ({{ $totalComment }})</h4>
                @foreach ($comments as $binhluan)
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-start mt-4 pb-3 border-bottom">
                                <img class="rounded-circle shadow-1-strong me-3"
                                    src="{{ asset('assets/images/faces/2.jpg') }}" alt="avatar" width="40"
                                    height="40">
                                <div class="flex-grow-1 flex-shrink-1">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-1">{{ $binhluan->user->ten_user }}&emsp;<span
                                                    class="small text-secondary">
                                                    {{ Carbon::parse($binhluan->created_at)->diffForHumans() }}</span>
                                            </h6>
                                        </div>
                                        <p class="small mb-0">{{ $binhluan->bl_noidung }}</p>

                                        {{-- btn  reply  --}}
                                        @if (Auth::id())
                                            <a href="" data-id_comment="{{ $binhluan->id }}"
                                                class="btn-show-form-reply"><i class="bi bi-reply-fill"></i></i><span
                                                    class="small">trả
                                                    lời</span></a>
                                        @else
                                            <a href="{{ route('login') }}"><span class="small">đăng
                                                    nhập để trả lời</span></a>
                                        @endif
                                        {{-- end btn reply --}}
                                        {{-- form reply comment --}}
                                        <div class="card formReply form-reply-{{ $binhluan->id }}" style="display:none">
                                            <div class="card-body ps-0">
                                                <div class="form-group mb-3">
                                                    <label for="exampleFormControlTextarea1" class="form-label">Nội
                                                        dung bình luận:</label>
                                                    <textarea class="form-control" id="tl_noidung{{ $binhluan->id }}" rows="3" placeholder="Nhập nội dung..."
                                                        style="resize: none" name="bl_noidung"></textarea>
                                                    <p id="bl_error" class="text-danger m-0"></p>
                                                    <button type="button" data-id_comment="{{ $binhluan->id }}"
                                                        class="btn btn-primary mt-3 btn-send-comment-reply"
                                                        type="button">Gửi bình
                                                        luận</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end form reply comment --}}
                                    </div>

                                    {{-- reply --}}
                                    @foreach ($binhluan->replies as $reply)
                                        <div class="d-flex flex-start mt-4">
                                            <a class="me-3" href="#">
                                                <img class="rounded-circle shadow-1-strong"
                                                    src="{{ asset('assets/images/faces/1.jpg') }}" alt="avatar"
                                                    width="40" height="40">
                                            </a>
                                            <div class="flex-grow-1 flex-shrink-1">
                                                <div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-1">{{ $reply->user->ten_user }}&emsp;<span
                                                                class="small text-secondary">
                                                                {{ Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                                                        </h6>
                                                    </div>
                                                    <p class="small mb-0">{{ $reply->bl_noidung }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
