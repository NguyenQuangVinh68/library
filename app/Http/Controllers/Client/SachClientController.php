<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Binhluan;
use App\Models\Ctmuon;
use App\Models\Sach;
use App\Models\Nganh;
use App\Models\Danhmuc;
use App\Models\User;
use App\Models\Yeuthich;
use App\Models\MuonOnline;
use Facade\FlareClient\Stacktrace\File;

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
            $saches = Sach::orderBy("id", "DESC")->search()->paginate(1);
            $saches->appends(['select_search' => $option_search, 'key' => $search]);
        }

        return view("pages.client.sach", compact('saches'));
    }

    public function nganh($slugDanhmuc, $slugNganh)
    {
        $nganh = Nganh::where('slug', $slugNganh)->get()->first();
        $danhmuc = Danhmuc::where('slug', $slugDanhmuc)->get()->first();
        $saches = Sach::where('danhmuc', $danhmuc->tendm)->where('nganh', $nganh->tennganh)->paginate(1);
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
        return view('pages.client.chitietsach', compact('sach'));
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
                return response()->json(['action' => "remove", "message" => "đã xóa sách khỏi danh sách yêu thích"]);
            } else {
                DB::insert("insert into yeuthichs (ma_user,masach) values (?,?)", [$ma_user, $masach]);
                return response()->json(['action' => "add", "message" => "thêm sách danh sách yêu thích thành công"]);
            }
        }
    }

    public function binhluan($sach_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bl_noidung' => 'required'
        ], [
            'bl_noidung.required' => 'không được bỏ trống'
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
                $comments = Binhluan::where(['traloi_id' => 0, 'sach_id' => $sach_id])->orderBy('id', 'DESC')->get();
                $totalComment = Binhluan::where('sach_id', $sach_id)->count();
                // return response()->json(['comment' => $comments]);
                return view('inc.client-list-comment', compact('comments', 'totalComment'));
            }
        }
    }

    public function dangmuon()
    {
        $title = "Danh sách đang mượn";
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
        $title = "Danh sách yêu thích";
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

        // sql trong data đã mượn
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
        // sql đã đăng kí mượn online
        $check_exists_online = MuonOnline::where('trangthai', 0)
            ->where('masach', $request->id_sach)
            ->where('ma_user', $ma_user)
            ->exists();

        $count_brrrowing_online = MuonOnline::where('trangthai', 0)
            ->where('ma_user', $ma_user)
            ->count();

        // check số lượng tồn của sách
        if ($sach->soluong < 0) {
            $flag = true;
            return response()->json(['error' => 'Số lượng sách mượn đã hết']);
        } else {
            // check dữ liệu xem có thỏa điều kiện không
            if ($check_exists) {
                $flag = true;
                return response()->json(['error' => 'Sách đã mượn']);
            }
            if ($count_borrowing >= 2) {
                $flag = true;
                return response()->json(['error' => 'Số lượng mượn đã vượt mức đối đa là 2 quyển']);
            }
            if ($check_exists_online) {
                $flag = true;
                return response()->json(['error' => 'Sách đã đăng kí mượn, nhưng chưa lấy sách tại thư viện']);
            }
            if ($count_brrrowing_online >= 2) {
                $flag = true;
                return response()->json(['error' => 'Sách đã đăng kí mượn đã vượt mức đối đa là 2 quyển']);
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
                    return response()->json(['success' => 'Đăng kí mượn thành công. Vui lòng liên hệ thư viện để xác nhận mượn sách']);
                } else {
                    return response()->json(['error' => 'Đăng kí mượn thất bại']);
                }
            }
            // end check flag
        }
        // end check số lượng tồn
    }

    public function taive($sach_id)
    {
        $sach = Sach::find($sach_id);
        $path = public_path('assets/tailieu/' . $sach->file_pdf);
        return response()->download($path);
    }
}
