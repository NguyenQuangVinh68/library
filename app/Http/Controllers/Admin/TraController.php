<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Muonsach;
use App\Models\Trasach;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->txtsearch;

        if ($search != '') {
            $kq = DB::table('danhsachmuons')
                ->select('danhsachmuons.id', 'danhsachmuons.ma_user', 'danhsachmuons.ngaytra', 'danhsachmuons.ngaymuon', 'danhsachmuons.ten_user', 'chitietmuons.nhande', 'chitietmuons.trangthai', 'chitietmuons.masach')
                ->join('chitietmuons', 'danhsachmuons.id', '=', 'chitietmuons.mamuon')
                ->where([
                    [function ($query) use ($search) {
                        $query->where('chitietmuons.nhande', 'like', '%' . $search . '%')
                            ->orWhere('danhsachmuons.ma_user', 'like', '%' . $search . '%');
                    }],
                    ['chitietmuons.trangthai', '=', '0']
                ])
                ->paginate(7);
            $kq->appends(['q' => $search]);
        } else {
            $kq = DB::table('danhsachmuons')
                ->select('danhsachmuons.id', 'danhsachmuons.ma_user', 'danhsachmuons.ngaytra', 'danhsachmuons.ngaymuon', 'danhsachmuons.ten_user', 'chitietmuons.nhande', 'chitietmuons.trangthai', 'chitietmuons.masach')
                ->join('chitietmuons', 'danhsachmuons.id', '=', 'chitietmuons.mamuon')
                ->where('chitietmuons.trangthai', '=', '0')
                ->paginate(7);
        }

        return view('pages.admin.trasach.index', compact('kq'));
    }


    // gia hạn
    public function giahan($id)
    {
        return view('pages.admin.trasach.form_giahan', compact('id'));
    }

    public function store_giahan(Request $request)
    {
        $request->validate([
            'songay_giahan' => 'required|integer',
        ]);
        $muonsach = Muonsach::find($request->mamuon);
        if ($muonsach) {
            $ngay_tra_moi = Carbon::parse($muonsach->ngaytra)->addDay($request->songay_giahan)->format('Y-m-d');
            $muonsach->update(['ngaytra' => $ngay_tra_moi]);
            return redirect()->route('tra.create');
        } else {
            return redirect()->route('tra.create');
        }
    }

    // end gia hạn


    public function tra(Request $request)
    {
        // tt = 1 <=> trả
        $tt = 1;
        $message = "Trả sách thành công";
        $data = $request->all();
        unset($data['_token']);

        DB::table('danhsachtras')->insert($data);

        $this->updateStockBook($data['masach']);
        $this->updateTrangthaiMuon($data['mamuon'], $data['masach'], $tt);

        $kq = $this->sqlBorrowing($data['ma_user']);
        return view('pages.admin.trasach.index', compact('kq', 'message'));
    }

    public function mat(Request $request)
    {
        // tt = 2 <=> mất
        $message = "Báo mất sách thành công";
        $tt = 2;
        $data = $request->all();
        unset($data['_token']);

        $this->updateTrangthaiMuon($data['mamuon'], $data['masach'], $tt);
        unset($data['mamuon']);

        DB::table('danhsachmats')->insert($data);
        $kq = $this->sqlBorrowing($data['ma_user']);

        if ($kq == null) {
            return redirect()->route('tra.create');
        } else {
            return view('pages.admin.trasach.index', compact('kq', 'message'));
        }
    }

    /**
     * câu sql lấy ra phần tử đang mượn trong data
     */
    private function sqlBorrowing($ma_user)
    {
        return DB::select("SELECT ds.id, ds.ma_user, ct.masach, ds.ngaytra, ds.ngaymuon, ds.ten_user, ct.nhande, ct.trangthai
                                FROM danhsachmuons ds
                                INNER JOIN chitietmuons ct 
                                ON ds.id = ct.mamuon
                                WHERE ds.ma_user like '%$ma_user%'
                                AND ct.trangthai = 0
                            ");
    }

    private function updateStockBook($masach)
    {
        $sach_ex = DB::table('saches')->select('soluong')->where('id', $masach)->get();
        DB::table('saches')->where('id', $masach)->limit(1)->update(array('soluong' => ($sach_ex[0]->soluong - 1)));
    }

    private function updateTrangthaiMuon($mamuon, $masach, $tt)
    {
        if ($tt == 2) {
            DB::table('chitietmuons')->where('mamuon', $mamuon)
                ->where('masach', $masach)
                ->update(array('trangthai' => 2));
        } else {

            DB::table('chitietmuons')->where('mamuon', $mamuon)
                ->where('masach', $masach)
                ->update(array('trangthai' => 1));
        }
    }
}
