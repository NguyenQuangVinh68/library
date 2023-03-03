<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BangxephangController extends Controller
{
    public function index()
    {

        $sach_muon = DB::table('danhsachmuons')
            ->select('saches.*', DB::raw('count(chitietmuons.id) as tongmuon'))
            ->join('chitietmuons', 'danhsachmuons.id', '=', 'chitietmuons.mamuon')
            ->join('saches', 'chitietmuons.masach', '=', 'saches.id')
            ->groupBy('chitietmuons.masach')
            ->orderBy('tongmuon', 'DESC')
            ->limit(10)
            ->get();

        $sach_yeuthich = DB::table('yeuthichs')
            ->join('saches', 'yeuthichs.masach', '=', 'saches.id')
            ->select('saches.*', DB::raw('count(yeuthichs.masach) as tongyeuthich'))
            ->orderBy('tongyeuthich', 'DESC')
            ->get();

        return view('pages.client.bangxephang', compact('sach_muon', 'sach_yeuthich'));
    }
}
