<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sach;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class MuonController extends Controller
{

    public function index()
    {
        // xóa session sinh viên 
        Session::forget("ma_user");
        Session::forget("ten_user");
        Session::forget("sach");
        return view('pages.admin.muonsach.index');
    }




    public function findStudent(Request $request)
    {
        $data = $request->all();
        $tim_sinhvien = User::where('ma_user', '=', $data['ma_user'])->exists();

        if ($tim_sinhvien == 1) {
            $sinhvien = User::where('ma_user', '=', $data['ma_user'])->get();
            foreach ($sinhvien as $item) {
                Session::put('ten_user', $item->ten_user);
                Session::put('ma_user', $item->ma_user);
            }

            return view('pages.admin.muonsach.form');
        } else {
            $message = "Không tìm thấy sinh viên theo mã số sinh viên đã cung cấp. Vui lòng thử lại!!!";
            return redirect()->route('muon')->with('message', $message);
        }
    }

    public function findBook(Request $request)
    {

        /**
         * _ed <=> đã
         * _ex <=> tồn tại
         * _ing <=> đang mượn
         */

        $ma_user = Session::get('ma_user');
        $data = $request->all();
        $sach_ex = Sach::find($data['masach']);
        $sinhvien_muon_ed = DB::table('danhsachmuons')->where('ma_user', '=', $ma_user)->exists();
        $max_muon = 2;
        $message = "";

        $sach_muon_ing = $this->sqlBorrowing($ma_user);


        // check sách tồn tại theo id sách
        if (isset($sach_ex)) {
            // check số lượng của sách >0
            if ($sach_ex['soluong'] <= 0) {
                $message = "số lượng sách mượn đã hết";
            } else {
                // kiểm tra sinh viên đã mượn sách lần nào chưa
                if ($sinhvien_muon_ed == 1) {

                    // nếu duyệt data mà không thấy sinh viên đang mượn <=> mượn lại từ đầu
                    if ($sach_muon_ing == null) {
                        if ($this->checkDuplicateIdBook($sach_ex['id'])) {
                            $message = "sách đã mượn hoặc đã tìm kiếm";
                        } else {
                            if (!$this->countAndAddSesssion($sach_ex, $max_muon)) {
                                $message = "Mượn sách tối đa là 2 quyển";
                            }
                        }
                    } else {
                        $masach_ing = $sach_muon_ing[0]->masach;

                        if ($sach_ex['id'] == $masach_ing) {
                            $message = "sách đã mượn";
                        } else {
                            if (count($sach_muon_ing) < $max_muon) {
                                if ($this->checkDuplicateIdBook($sach_ex['id'])) {
                                    $message = "sách đã mượn hoặc đã tìm kiếm";
                                } else {
                                    if (!$this->countAndAddSesssionWithDatabase($sach_muon_ing, $sach_ex, $max_muon)) {
                                        $message = "Mượn tối đa là 2 quyển sách";
                                    }
                                }
                            } else {
                                $message = "Mượn tối đa là 2 quyển sách";
                            }
                        }
                    }
                } else {
                    if ($this->checkDuplicateIdBook($sach_ex['id'])) {
                        $message = "sách đã mượn hoặc đã tìm kiếm";
                    } else {
                        if (!$this->countAndAddSesssion($sach_ex, $max_muon)) {
                            $message = "mượn tối đa là 2 quyển sách";
                        }
                    }
                }
                // end kiểm tra sinh viên
            }
            // end check số lượng sách > 0
        } else {
            $message = "sách không tồn tại";
        }
        // end check tồn tại id sách

        return view("pages.admin.muonsach.form")->with('message', $message);
    }

    /**
     * câu sql lấy ra phần tử đang mượn trong data
     */
    private function sqlBorrowing($ma_user)
    {
        return DB::select("SELECT ds.id, ds.ma_user, ct.masach
                                FROM danhsachmuons ds
                                INNER JOIN chitietmuons ct 
                                ON ds.id = ct.mamuon
                                WHERE ds.ma_user = '$ma_user'
                                AND ct.trangthai = 0");
    }

    private function checkDuplicateIdBook($masach_ing)
    {

        if (Session::has('sach')) {
            $tmpsession = Session::get('sach');
            foreach ($tmpsession as $sach) {
                if ($sach->id == $masach_ing) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * + nếu có session thì đếm xem nó có mấy phần tử rồi
     *      ++ nếu < 2 thì thêm vào session
     *      ++ nếu >= thì return false
     * + nếu không có session thì thêm vào luôn session luôn & return true
     * @param array $sach_ex 
     * @param int $max_muon
     * @return boolean
     */
    private function countAndAddSesssion($sach_ex, $max_muon)
    {
        if (Session::has('sach')) {
            if (count(Session::get('sach')) < $max_muon) {
                Session::push('sach', $sach_ex);
            } else {
                return false;
            }
        } else {
            Session::push('sach', $sach_ex);
        }
        return true;
    }

    /**
     * + nếu có session thì đếm xem nó có mấy phần tử rồi cộng với số lượng phần tử đang mượn bên database
     *      ++ nếu < 2 thì thêm vào session
     *      ++ nếu >= thì return false
     * + nếu không có session thì thêm vào luôn session luôn & return true
     * @param array $sach_ex 
     * @param array $sach_muon_ing 
     * @param int $max_muon
     * @return boolean
     */
    private function countAndAddSesssionWithDatabase($sach_muon_ing, $sach_ex, $max_muon)
    {
        if (Session::has('sach')) {
            if ((count(Session::get('sach')) + count($sach_muon_ing)) < $max_muon && count($sach_muon_ing) < $max_muon) {
                Session::push('sach', $sach_ex);
            } else {
                return false;
            }
        } else {
            Session::push('sach', $sach_ex);
        }
        return true;
    }

    public function removeBookInSession($id)
    {
        if (Session::has('sach')) {
            $tmpsession = Session::get('sach');
            for ($i = 0; $i <= count($tmpsession); $i++) {
                if (isset($tmpsession[$i])) {
                    if ($tmpsession[$i]->id == $id) {
                        unset($tmpsession[$i]);
                        break;
                    }
                }
            }
        }
        Session::put('sach', $tmpsession);

        return view('pages.admin.muonsach.form');
    }

    public function muonAction()
    {
        $tmpsession = Session::get('sach');
        $daysBorrowLimit = 14;
        $monthReturnBooks = date("m");
        $yearReturnBooks = date("Y");
        $dayReturnBooks = date("d") + $daysBorrowLimit;

        $ngaymuon = date("Y-m-d");
        $ngaytra = date("Y-m-d", mktime(0, 0, 0,  $monthReturnBooks, $dayReturnBooks, $yearReturnBooks));


        if (Session::has('sach')) {
            $dataBorrow = array(
                "ma_user" => Session::get('ma_user'),
                "ten_user" => Session::get('ten_user'),
                "ngaymuon" => $ngaymuon,
                "ngaytra" => $ngaytra,
                "maadm" => 'admin'
            );

            DB::table('danhsachmuons')->insert($dataBorrow);

            $getIdMuon = DB::table('danhsachmuons')->where('ma_user', Session::get('ma_user'))->orderBy('id', 'DESC')->limit(1)->get();

            foreach ($tmpsession as $value) {
                $dataDetail = array(
                    "mamuon" => $getIdMuon[0]->id,
                    "masach" => $value->id,
                    "soluong" => 1,
                    "nhande" => $value->nhande,
                    "trangthai" => 0
                );

                DB::table('chitietmuons')->insert($dataDetail);
                $this->updateStockBook($dataDetail['masach']);
            }
            Session::forget('sach');
            Session::forget('ma_user');
            Session::forget('ten_user');

            return redirect()->route('muon')->with('success', "Mượn thành công");
        }
        return redirect()->route('dashboard');
    }

    private function updateStockBook($masach)
    {
        $sach_ex = DB::table('saches')->select('soluong')->where('id', $masach)->get();
        DB::table('saches')->where('id', $masach)->limit(1)->update(array('soluong' => ($sach_ex[0]->soluong - 1)));
    }

    public function show($id)
    {
        $sinhvien = User::find($id);
        return view('pages.admin.muonsach.form', compact('sinhvien'));
    }
}
