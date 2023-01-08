<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.trasach.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.trasach.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $kq = $this->sqlBorrowing($data['ma_user']);

        if ($kq != null) {
            return view('pages.admin.trasach.index', compact('kq'));
        } else {
            return redirect()->route('tra.create')->with('message', "Sinh viên hiện chưa mượn sách");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

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
                                WHERE ds.ma_user = '$ma_user'
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
