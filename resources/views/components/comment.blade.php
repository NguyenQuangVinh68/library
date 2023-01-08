<div class="container">
    <h3>Bình luận</h3>
    {{-- form comment --}}
    <form action="" method="POST">
        @method('POST')
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    @if (Auth::guard('web')->check())
                        <label for="exampleFormControlTextarea1" class="form-label"><span
                                class="text-capitalize">{{ Auth::guard('web')->user()->ten_user }}</span> bình
                            luận:</label>
                    @else
                        <label for="exampleFormControlTextarea1" class="form-label">Nội dung bình luận:</label>
                    @endif
                    <textarea class="form-control " id="bl_noidung" rows="3" placeholder="Nhập nội dung..." style="resize: none"></textarea>
                    <p id="bl_error" class="text-danger m-0"></p>
                    <button class="btn btn-primary mt-3" type="button" id="btn-binhluan">Gửi bình luận</button>
                </div>
            </div>
        </div>
    </form>
    {{-- end form comment --}}

    {{-- hiện thị comment --}}
   
    <section class="w-100 p-4 " style="border-radius: .5rem .5rem 0 0;" id="list-comment">
        @if (count($sach->binhluan) > 0)
            @include('inc.client-list-comment', [
                'comments' => $sach->binhluan,
                'totalComment' => count($sach->count_binhluan),
            ])
        @endif
    </section>
    {{-- end hiện thị comment --}}
</div>
