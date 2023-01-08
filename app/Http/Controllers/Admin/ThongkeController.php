<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Sach;
use App\Models\Ctmuon;
use App\Models\Muonsach;
use App\Models\Trasach;
use App\Models\Matsach;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ThongkeController extends Controller
{
    public function index()
    {
        $nganhs = Nganh::all();
        $khoas = Khoa::all();

        $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
            ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
            ->where('danhsachmuons.ngaymuon',  Carbon::now()->format('Y-m-d'))
            ->select('saches.*', 'danhsachmuons.ma_user', 'danhsachmuons.ngaymuon')
            ->get();
        $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
            ->where('danhsachtras.ngaytra',  Carbon::now()->format('Y-m-d'))
            ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra',)
            ->get();
        $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
            ->where('danhsachmats.ngaybaomat',  Carbon::now()->format('Y-m-d'))
            ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
            ->get();
        return view('pages.admin.thongke.index', compact('khoas', 'nganhs', 'danhsachmuon', 'danhsachtra', 'danhsachmat'));
    }

    public function loctheomuc(Request $request)
    {
        $thoigian_cuthe = $request->thoigian_cuthe;
        $thoi_gian = $request->thoi_gian;
        $chuyennganh = $request->chuyennganh;


        $danhsachmuon = $this->get_muon($thoi_gian, $thoigian_cuthe, $chuyennganh);
        $danhsachtra = $this->get_tra($thoi_gian, $thoigian_cuthe, $chuyennganh);
        $danhsachmat = $this->get_mat($thoi_gian, $thoigian_cuthe, $chuyennganh);

        return view('inc.admin-list-thongke', compact('danhsachmuon', 'danhsachtra', 'danhsachmat'));
    }

    public function tuychinh(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tungay' => 'required',
            'denngay' => 'required'
        ], [
            'tungay.required' => 'không bỏ trống trường này',
            'denngay.required' => 'không bỏ trống trường này',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->get('*')]);
        } else {
            $tungay = Carbon::parse($request->tungay)->format('Y-m-d');
            $denngay = Carbon::parse($request->denngay)->format('Y-m-d');
            $danhsachmuon = $this->get_muon_tuychinh($tungay, $denngay);
            $danhsachtra = $this->get_tra_tuychinh($tungay, $denngay);
            $danhsachmat = $this->get_mat_tuychinh($tungay, $denngay);
            return view('inc.admin-list-thongke', compact('danhsachmuon', 'danhsachtra', 'danhsachmat'));
        }
    }

    // thống kê theo kiểu mặc định
    private function get_muon($thoi_gian, $thoigian_cuthe, $chuyennganh)
    {
        $danhsachmuon = null;
        if ($chuyennganh == null || $chuyennganh == '') {
            if ($thoi_gian == 'ngay') {
                $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                    ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
                    ->where('danhsachmuons.ngaymuon',  Carbon::parse(($thoigian_cuthe))->format('Y-m-d'))
                    ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
                    ->get();
            } else if ($thoi_gian == 'thang') {
                $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                    ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
                    ->whereYear('danhsachmuons.ngaymuon',  Carbon::parse(($thoigian_cuthe))->format('Y'))
                    ->whereMonth('danhsachmuons.ngaymuon', Carbon::parse(($thoigian_cuthe))->format('m'))
                    ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
                    ->get();
            } else {
                $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                    ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
                    ->whereYear('danhsachmuons.ngaymuon', $thoigian_cuthe)
                    ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
                    ->get();
            }
        } else {
            if ($thoi_gian == 'ngay') {
                $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                    ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
                    ->where('danhsachmuons.ngaymuon',  Carbon::parse(($thoigian_cuthe))->format('Y-m-d'))
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
                    ->get();
            } else if ($thoi_gian == 'thang') {
                $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                    ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
                    ->whereYear('danhsachmuons.ngaymuon',  Carbon::parse(($thoigian_cuthe))->format('Y'))
                    ->whereMonth('danhsachmuons.ngaymuon', Carbon::parse(($thoigian_cuthe))->format('m'))
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
                    ->get();
            } else {
                $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
                    ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
                    ->whereYear('danhsachmuons.ngaymuon', $thoigian_cuthe)
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
                    ->get();
            }
        }

        return $danhsachmuon;
    }

    private function get_tra($thoi_gian, $thoigian_cuthe, $chuyennganh)
    {
        $danhsachtra = null;
        if ($chuyennganh == '' || $chuyennganh == null) {
            if ($thoi_gian == 'ngay') {
                $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
                    ->where('danhsachtras.ngaytra',  Carbon::parse(($thoigian_cuthe))->format('Y-m-d'))
                    ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
                    ->get();
            } else if ($thoi_gian == 'thang') {
                $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
                    ->whereYear('danhsachtras.ngaytra',  Carbon::parse(($thoigian_cuthe))->format('Y'))
                    ->whereMonth('danhsachtras.ngaytra', Carbon::parse(($thoigian_cuthe))->format('m'))
                    ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
                    ->get();
            } else {
                $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
                    ->whereYear('danhsachtras.ngaytra', $thoigian_cuthe)
                    ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
                    ->get();
            }
        } else {
            if ($thoi_gian == 'ngay') {
                $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
                    ->where('danhsachtras.ngaytra',  Carbon::parse(($thoigian_cuthe))->format('Y-m-d'))
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
                    ->get();
            } else if ($thoi_gian == 'thang') {
                $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
                    ->whereYear('danhsachtras.ngaytra',  Carbon::parse(($thoigian_cuthe))->format('Y'))
                    ->whereMonth('danhsachtras.ngaytra', Carbon::parse(($thoigian_cuthe))->format('m'))
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
                    ->get();
            } else {
                $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
                    ->whereYear('danhsachtras.ngaytra', $thoigian_cuthe)
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
                    ->get();
            }
        }

        return $danhsachtra;
    }

    private function get_mat($thoi_gian, $thoigian_cuthe, $chuyennganh)
    {
        $danhsachmat = null;
        if ($chuyennganh == null || $chuyennganh == '') {
            if ($thoi_gian == 'ngay') {
                $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
                    ->where('danhsachmats.ngaybaomat',  Carbon::parse(($thoigian_cuthe))->format('Y-m-d'))
                    ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
                    ->get();
            } else if ($thoi_gian == 'thang') {
                $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
                    ->whereYear('danhsachmats.ngaybaomat',  Carbon::parse(($thoigian_cuthe))->format('Y'))
                    ->whereMonth('danhsachmats.ngaybaomat', Carbon::parse(($thoigian_cuthe))->format('m'))
                    ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
                    ->get();
            } else {
                $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
                    ->whereYear('danhsachmats.ngaybaomat', $thoigian_cuthe)
                    ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
                    ->get();
            }
        } else {
            if ($thoi_gian == 'ngay') {
                $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
                    ->where('danhsachmats.ngaybaomat',  Carbon::parse(($thoigian_cuthe))->format('Y-m-d'))
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
                    ->get();
            } else if ($thoi_gian == 'thang') {
                $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
                    ->whereYear('danhsachmats.ngaybaomat',  Carbon::parse(($thoigian_cuthe))->format('Y'))
                    ->whereMonth('danhsachmats.ngaybaomat', Carbon::parse(($thoigian_cuthe))->format('m'))
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
                    ->get();
            } else {
                $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
                    ->whereYear('danhsachmats.ngaybaomat', $thoigian_cuthe)
                    ->where('saches.khoa', $chuyennganh)
                    ->orWhere('saches.nganh', $chuyennganh)
                    ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
                    ->get();
            }
        }

        return $danhsachmat;
    }

    // thống kê theo ngày tháng tùy chọn
    private function get_muon_tuychinh($tungay, $denngay)
    {
        $danhsachmuon = Muonsach::join('chitietmuons', 'chitietmuons.mamuon', '=', 'danhsachmuons.id')
            ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
            ->whereBetween('danhsachmuons.ngaymuon', [$tungay, $denngay])
            ->select('saches.*', 'danhsachmuons.ma_user',  'danhsachmuons.ngaymuon')
            ->get();
        return $danhsachmuon;
    }

    private function get_tra_tuychinh($tungay, $denngay)
    {
        $danhsachtra = Trasach::join('saches', 'danhsachtras.masach', '=', 'saches.id')
            ->whereBetween('danhsachtras.ngaytra', [$tungay, $denngay])
            ->select('saches.*', 'danhsachtras.ma_user', 'danhsachtras.ngaytra')
            ->get();
        return $danhsachtra;
    }

    private function get_mat_tuychinh($tungay, $denngay)
    {
        $danhsachmat = Matsach::join('saches', 'danhsachmats.masach', '=', 'saches.id')
            ->whereBetween('danhsachmats.ngaybaomat', [$tungay, $denngay])
            ->select('saches.*', 'danhsachmats.ma_user', 'danhsachmats.ngaybaomat')
            ->get();
        return $danhsachmat;
    }
}
