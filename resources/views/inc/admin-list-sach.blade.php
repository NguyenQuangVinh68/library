@if (count($kq) > 0)
    <div class="col-12">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nhan đề</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        <th>Khoa</th>
                        <th>Ngành</th>
                        <th>Ảnh bìa</th>
                        <th>Thông tin xb</th>
                        <th>Vị trí</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kq as $sach)
                        <tr>
                            <td>{{ $sach->id }}</td>
                            <td>{{ $sach->nhande }}</td>
                            <td class="text-capitalize">{{ $sach->tacgia }}</td>
                            <td>{{ $sach->danhmuc }}</td>
                            <td>
                                {{ $sach->khoa == 'công nghệ thông tin - điện tử' ? 'CNTT-DT' : $sach->khoa }}
                            </td>
                            <td>{{ $sach->nganh }}</td>
                            <td><img src="{{ asset('assets/images/books/' . $sach->anhbia) }}" alt=""
                                    class="w-50"></td>
                            <td>{{ $sach->thongtinxb }}</td>
                            <td>{{ $sach->vitri }}</td>
                            <td>{{ $sach->soluong }}</td>
                            <td>{{ $sach->gia }}</td>
                            <td>
                                <a href="{{ route('sach.edit', $sach->id) }}" type="button"
                                    class="btn btn-outline-primary block "><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger block " data-bs-toggle="modal"
                                    data-bs-target="#modal{{ $sach->id }}"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modal{{ $sach->id }}" data-bs-backdrop="static"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                            Xóa ngành
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">X</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('sach.destroy', $sach->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <h4 class="text-center"> {{ $sach->nhande }}</h4>
                                            <p class="text-center">Bạn có trắc chắn muốn xóa "NGÀNH" này?</p>
                                            <div class="d-flex gap-3 mt-5">
                                                <button type="submit" class="btn btn-danger w-50">Ok,
                                                    xóa</button>
                                                <button class="btn btn-secondary w-50" type="button"
                                                    data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <h3 class="p-3 text-center alert-danger">Không có dữ liệu</h3>
@endif
