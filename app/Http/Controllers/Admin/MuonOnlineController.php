<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ctmuon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Models\MuonOnline;
use App\Models\Muonsach;

class MuonOnlineController extends Controller
{
    public function index()
    {
        $data = MuonOnline::orderBy('id', 'DESC')->where('trangthai', 0)->search()->paginate(10);
        return view('pages.admin.muon_online.index', compact('data'));
    }

    public function xacnhan($id_dangki)
    {
        $muon = MuonOnline::find($id_dangki);
        $ngaytra = Carbon::parse($muon->created_at)->addDays(14)->format('Y-m-d');
        $data_danhsachmuon = array(
            'ma_user' => $muon->ma_user,
            'ten_user' => $muon->ten_user,
            'ngaymuon' => date_format($muon->created_at, 'Y-m-d'),
            'ngaytra' => $ngaytra
        );

        // thêm vào bảng danhsachmuon và chitietmuon
        Muonsach::create($data_danhsachmuon);

        $mamuon = Muonsach::orderBy('id', 'DESC')->get()->first();

        $data_chitietmuon = array(
            'mamuon' => $mamuon->id,
            'masach' => $muon->masach,
            'nhande' => $muon->nhande
        );
        Ctmuon::create($data_chitietmuon);

        // end thêm vào bảng danhsachmuon và chitietmuon
        $update_trangthai = array('trangthai' => 1);
        MuonOnline::whereId($id_dangki)->update($update_trangthai);
        return redirect()->back()->with('message', "Xác nhận mượn thành công");
    }
}
