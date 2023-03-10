<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Binhluan;
use App\Models\Sach;
use App\Models\Nganh;
use App\Models\Danhmuc;
use App\Models\User;
use App\Models\Yeuthich;
use App\Models\MuonOnline;
use Illuminate\Support\Facades\File;

class SachClientController extends Controller
{

    public function __construct()
    {
        // return $this->middleware("auth", ['only' => ['yeuthich', 'binhluan', 'dangmuon', 'danhsachyeuthich', 'muonsach']]);
        return $this->middleware("auth", ['only' => ['dangmuon', 'danhsachyeuthich', 'taive']]);
    }

    public function search(Request $request)
    {
        $search = $request->key;
        $option_search = $request->select_search;
        if ($search != "") {
            $saches = Sach::orderBy("id", "DESC")->search()->paginate(10);
            $saches->appends(['select_search' => $option_search, 'key' => $search]);
        }

        return view("pages.client.sach", compact('saches'));
    }

    public function nganh($slugDanhmuc, $slugNganh)
    {
        $nganh = Nganh::where('slug', $slugNganh)->get()->first();
        $danhmuc = Danhmuc::where('slug', $slugDanhmuc)->get()->first();
        $saches = Sach::where('danhmuc', $danhmuc->tendm)->where('nganh', $nganh->tennganh)->paginate(10);
        return view('pages.client.sach', compact('saches'));
    }

    public function danhmuc($slug)
    {
        $danhmuc = Danhmuc::where('slug', $slug)->get()->first();
        $saches = Sach::where('danhmuc', $danhmuc->tendm)->paginate(10);
        return view('pages.client.sach', compact('saches'));
    }

    public function detail($sach_id)
    {
        $sach = Sach::find($sach_id);
        $sumPoint = 0;
        $danhgias = DB::table('danhgia')
            ->select('point')
            ->where('sach_id', $sach_id)
            ->get();
        // dd($danhgias);
        if ($danhgias->isNotEmpty()) {
            foreach ($danhgias as $danhgia) {
                $sumPoint += $danhgia->point;
            }
            $aveRate =  $sumPoint / count($danhgias);
        } else {
            $aveRate = 0;
        }


        if ($sach->file_pdf != null) {
            $size = "";
            $file = public_path('assets/tailieu/' . $sach->file_pdf);
            $size = $this->getFormattedFileSize(File::size($file));
            return view('pages.client.chitietsach', compact('sach', 'size', 'aveRate'));
        }
        return view('pages.client.chitietsach', compact('sach', 'aveRate'));
    }

    public function yeuthich(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $id_user = $data['id_user'];
            $user = User::find($id_user);
            $ma_user = $user['ma_user'];
            $masach = $data['book_id'];

            $existYeuthich = DB::table('yeuthichs')
                ->where('masach', $masach)
                ->where('ma_user', $ma_user)
                ->get()
                ->first();

            if (isset($existYeuthich) && $existYeuthich != null) {
                DB::table("yeuthichs")->where('masach', $masach)->where('ma_user', $ma_user)->delete();
                return response()->json(['action' => "remove", "message" => "???? x??a s??ch kh???i danh s??ch y??u th??ch"]);
            } else {
                DB::insert("insert into yeuthichs (ma_user,masach) values (?,?)", [$ma_user, $masach]);
                return response()->json(['action' => "add", "message" => "th??m s??ch danh s??ch y??u th??ch th??nh c??ng"]);
            }
        }
    }

    public function binhluan($sach_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bl_noidung' => 'required'
        ], [
            'bl_noidung.required' => 'kh??ng ???????c b??? tr???ng'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        } else {
            $ma_user = Auth::guard('web')->user()->ma_user;
            $data = [
                'ma_user' => $ma_user,
                'sach_id' => $sach_id,
                'bl_noidung' => $request->bl_noidung,
                'traloi_id' => $request->traloi_id ? $request->traloi_id : 0
            ];

            if ($binhluan = Binhluan::create($data)) {
                $comments = Binhluan::where(['traloi_id' => 0, 'sach_id' => $sach_id, 'status' => 1])->orderBy('id', 'DESC')->get();
                $totalComment = Binhluan::where('sach_id', $sach_id)->where('status', 1)->count();
                // return response()->json(['comment' => $comments]);
                return view('inc.client-list-comment', compact('comments', 'totalComment'));
            }
        }
    }

    public function dangmuon()
    {
        $title = "Danh s??ch ??ang m?????n";
        $ma_user = $ma_user = Auth::guard('web')->user()->ma_user;

        $datas =  DB::select("SELECT ct.nhande, ct.masach,ds.ngaymuon,ds.ngaytra
                                FROM danhsachmuons ds
                                INNER JOIN chitietmuons ct 
                                ON ds.id = ct.mamuon
                                WHERE ds.ma_user = '$ma_user'
                                AND ct.trangthai = 0");
        return view("pages.client.yeuthich-dangmuon", compact('datas', 'title'));
    }

    public function danhsachyeuthich()
    {
        $title = "Danh s??ch y??u th??ch";
        $ma_user = $ma_user = Auth::guard('web')->user()->ma_user;
        $datas = Yeuthich::where('ma_user', $ma_user)->get();
        return view("pages.client.yeuthich-dangmuon", compact('datas', 'title'));
    }

    public function muonsach(Request $request)
    {
        $flag = false;
        // date 
        $ma_user = Auth::guard('web')->user()->ma_user;
        $ten_user = Auth::guard('web')->user()->ten_user;
        $sach = Sach::find($request->id_sach);

        // sql trong data ???? m?????n
        $check_exists = DB::table('danhsachmuons')
            ->join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
            ->where('chitietmuons.trangthai', 0)
            ->where('danhsachmuons.ma_user', $ma_user)
            ->where('chitietmuons.masach', $request->id_sach)
            ->exists();
        $count_borrowing = DB::table('danhsachmuons')
            ->join('chitietmuons', 'danhsachmuons.id', '=', 'chitietmuons.mamuon')
            ->where('danhsachmuons.ma_user', $ma_user)
            ->where('chitietmuons.trangthai', 0)
            ->count();
        // sql ???? ????ng k?? m?????n online
        $check_exists_online = MuonOnline::where('trangthai', 0)
            ->where('masach', $request->id_sach)
            ->where('ma_user', $ma_user)
            ->exists();

        $count_brrrowing_online = MuonOnline::where('trangthai', 0)
            ->where('ma_user', $ma_user)
            ->count();

        // check s??? l?????ng t???n c???a s??ch
        if ($sach->soluong < 0) {
            $flag = true;
            return response()->json(['error' => 'S??? l?????ng s??ch m?????n ???? h???t']);
        } else {
            // check d??? li???u xem c?? th???a ??i???u ki???n kh??ng
            if ($check_exists) {
                $flag = true;
                return response()->json(['error' => 'S??ch ???? m?????n']);
            }
            if ($count_borrowing >= 2) {
                $flag = true;
                return response()->json(['error' => 'S??? l?????ng m?????n ???? v?????t m???c ?????i ??a l?? 2 quy???n']);
            }
            if ($check_exists_online) {
                $flag = true;
                return response()->json(['error' => 'S??ch ???? ????ng k?? m?????n, nh??ng ch??a l???y s??ch t???i th?? vi???n']);
            }
            if ($count_brrrowing_online >= 2) {
                $flag = true;
                return response()->json(['error' => 'S??ch ???? ????ng k?? m?????n ???? v?????t m???c ?????i ??a l?? 2 quy???n']);
            }

            // check flag
            if ($flag == false) {
                $data_muon_online = [
                    'ma_user' => $ma_user,
                    'ten_user' => $ten_user,
                    'masach' => $sach->id,
                    'nhande' => $sach->nhande
                ];

                $action = MuonOnline::create($data_muon_online);
                if ($action) {
                    $update_soluong = array(
                        'soluong' => $sach->soluong - 1
                    );
                    Sach::whereId($sach->id)->update($update_soluong);
                    return response()->json(['success' => '????ng k?? m?????n th??nh c??ng. Vui l??ng li??n h??? th?? vi???n ????? x??c nh???n m?????n s??ch']);
                } else {
                    return response()->json(['error' => '????ng k?? m?????n th???t b???i']);
                }
            }
            // end check flag
        }
        // end check s??? l?????ng t???n
    }

    public function taive($sach_id)
    {
        $sach = Sach::find($sach_id);
        $path = public_path('assets/tailieu/' . $sach->file_pdf);
        return response()->download($path);
    }

    public function danhgia(Request $request,  $sach_id)
    {

        if ($request->ajax()) {
            $sumPoint = 0;
            $flag = false;
            $user_id = Auth::id();
            $user_rating = DB::table('danhgia')->where('user_id', $user_id)->exists();

            // check ch??ng user
            if ($user_rating) {
                // update lai so diem ma user danh gia truoc do
                $flag =  DB::table('danhgia')
                    ->where('sach_id', $sach_id)
                    ->where('user_id', $user_id)
                    ->update(['point' => $request->point]);
            } else {
                // them moi danh gia
                $flag =  DB::insert('insert into danhgia (sach_id, user_id, point) values (?,?,?)', [$sach_id, $user_id, $request->point]);
            }

            // check l???i ??i???m trung b??nh
            $danhgias = DB::table('danhgia')
                ->select('point')
                ->where('sach_id', $sach_id)
                ->get();
            // dd($danhgias);
            if ($danhgias->isNotEmpty()) {
                foreach ($danhgias as $danhgia) {
                    $sumPoint += $danhgia->point;
                }
                $aveRate =  round($sumPoint / count($danhgias), 2);
            } else {
                $aveRate = 0;
            }



            if ($flag == false) {
                return response()->json(['error' => '????nh gi?? th???t b???i']);
            } else {
                return response()->json(['success' => '????nh gi?? th??nh c??ng', 'aveRate' => $aveRate]);
            }
        }
    }

    private function getFormattedFileSize($size)
    {
        switch (true) {
            case ($size / 1024 < 1):
                return $size . 'B';
            case ($size / pow(1024, 2) < 1):
                return round($size / 1024, 2) . 'KB';
            case ($size / pow(1024, 3) < 1):
                return round($size / pow(1024, 2), 2) . 'MB';
            case ($size / pow(1024, 4) < 1):
                return round($size / pow(1024, 3), 2) . 'GB';
            case ($size / pow(1024, 5) < 1):
                return round($size / pow(1024, 4), 2) . 'TB';
        }
    }
}
