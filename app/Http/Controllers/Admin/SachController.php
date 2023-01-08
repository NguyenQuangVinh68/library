<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Vitri;
use App\Models\Danhmuc;


class SachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->key;
        $option_search = $request->select_search;

        $message_404 = "Không tìm thấy dữ liệu";

        if ($search != "") {
            $kq = Sach::orderBy("id", "DESC")->search()->paginate(1);
            $kq->appends(['select_search' => $option_search, 'key' => $search]);
        } else {
            $kq = Sach::orderBy("id", "DESC")->paginate(2);
        }

        if (count($kq) > 0) {
            return view("pages.admin.sach.index", compact('kq'));
        } else {
            return view("pages.admin.sach.index", compact('message_404'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $danhmucs = Danhmuc::all();
        $vitris = Vitri::all();
        $nganhs = Nganh::all();
        return view("pages.admin.sach.form", compact('danhmucs',  'nganhs', 'vitris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sach $sach)
    {

        // check image

        $request->validate([
            'anhbia' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file_pdf' => 'required|file|mimes:pdf'
        ]);

        $data = $request->all();
        $sach->nhande =  Str::lower($data['nhande']);
        $sach->tacgia =  Str::lower($data['tacgia']);
        $sach->danhmuc =  Str::lower($data['danhmuc']);
        $sach->nganh =  Str::lower($data['nganh']);
        $sach->thongtinxb =  Str::lower($data['thongtinxb']);
        $sach->vitri =  Str::lower($data['vitri']);
        $sach->soluong =  Str::lower($data['soluong']);
        $sach->gia =  Str::lower($data['gia']);

        $get_image = $data['anhbia'];
        $get_pdf = $data['file_pdf'];

        // path
        $path_img = 'assets/images/books';
        $path_pdf = 'assets/tailieu';



        if (Sach::where('nhande', $sach->nhande)->where('tacgia', $sach->tacgia)->exists()) {
            return redirect()->route('sach.create')->with('message', 'Sach và tác giả đã tồn tại. Vui lòng kiểm tra lại!!!');
        } else {

            // xu ly file pdf
            $get_name_pdf = $get_pdf->getClientOriginalName();
            $name_pdf = current(explode('.', $get_name_pdf));
            $new_pdf = $name_pdf . rand(0, 99) . '.' . $get_pdf->getClientOriginalExtension();
            $get_pdf->move(public_path($path_pdf), $new_pdf);
            $sach->file_pdf = $new_pdf;

            // xử lý file hình ảnh
            $new_anhbia = time() . '.' . $request->anhbia->extension();
            $get_image->move(public_path($path_img), $new_anhbia);
            $sach->anhbia = $new_anhbia;

            // check ngành học phù hợp với khoa
            $nganh = Nganh::find($sach->nganh);
            $khoa = Khoa::find($nganh->makhoa);

            $sach->nganh = Str::lower($nganh->tennganh);
            $sach->khoa = Str::lower($khoa->tenkhoa);

            $sach->save();
            return redirect()->route("sach.index")->with("message", "Thêm sách thành công");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $danhmucs = Danhmuc::all();
        $vitris = Vitri::all();
        $nganhs = Nganh::all();

        $sach = Sach::find($id);
        return view('pages.admin.sach.form', compact('sach', 'danhmucs', 'vitris', 'nganhs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $sach = Sach::find($id);
        $sach->nhande =  Str::lower($data['nhande']);
        $sach->tacgia =  Str::lower($data['tacgia']);
        $sach->danhmuc =  Str::lower($data['danhmuc']);
        $sach->nganh =  Str::lower($data['nganh']);
        $sach->thongtinxb =  Str::lower($data['thongtinxb']);
        $sach->vitri =  Str::lower($data['vitri']);
        $sach->soluong =  Str::lower($data['soluong']);
        $sach->gia =  Str::lower($data['gia']);
        // path
        $path_img = 'assets/images/books';
        $path_pdf = 'assets/tailieu';


        if ($request->hasFile('anhbia')) {

            $request->validate([
                'anhbia' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $destination = 'assets/images/books/' . $sach->anhbia;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $anhbia = time() . '.' . $request->anhbia->extension();
            $request->anhbia->move(public_path($path_img), $anhbia);
            $sach->anhbia = $anhbia;
        }

        // file pdf
        if ($request->hasFile('file_pdf')) {
            $request->validate([
                'file_pdf' => 'required|file|mimes:pdf'
            ]);
            $destination = 'assets/tailieu/' . $sach->file_pdf;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $get_name_pdf = $request->file_pdf->getClientOriginalName();
            $name_pdf = current(explode('.', $get_name_pdf));
            $new_pdf = $name_pdf . rand(0, 99) . '.' . $request->file_pdf->getClientOriginalExtension();
            $request->file_pdf->move(public_path($path_pdf), $new_pdf);
            $sach->file_pdf = $new_pdf;
        }

        // check ngành học phù hợp với khoa
        $nganh = Nganh::find($sach->nganh);
        $khoa = Khoa::find($nganh->makhoa);

        $sach->nganh = Str::lower($nganh->tennganh);
        $sach->khoa = Str::lower($khoa->tenkhoa);

        $sach->save();
        return redirect()->route("sach.index")->with("message", "Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sach = Sach::find($id);
        $sach->delete();
        return redirect()->route("sach.index")->with("message", "Xóa sách thành công");
    }

    public function loc_khoa_nganh(Request $request)
    {
        if ($request->ajax()) {
            $kq = Sach::orderBy('id', 'DESC')
                ->where('khoa', $request->khoa_nganh)
                ->orWhere('nganh', $request->khoa_nganh)
                ->get();
            // return response()->json(['kq' => $kq]);
            return view('inc.admin-list-sach', compact('kq'));
        }
    }
}
