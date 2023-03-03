<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sach_new = DB::table('saches')->orderBy('id', 'DESC')->limit(5)->get();

        $user_top = DB::table('danhsachmuons')
            ->select('danhsachmuons.*', DB::raw('count(danhsachmuons.id) as slmuon'))
            ->join('chitietmuons', 'chitietmuons.mamuon', 'danhsachmuons.id')
            ->groupBy('danhsachmuons.ma_user')
            ->limit(5)
            ->orderBy('slmuon', 'DESC')
            ->get();

        $sach_mat = DB::table('danhsachmats')
            ->join('users', 'danhsachmats.ma_user', '=', 'users.ma_user')
            ->select('danhsachmats.*', 'users.ten_user')
            ->limit(5)
            ->get();

        return view("pages.admin.dashboard", compact('sach_new', 'user_top', 'sach_mat'));
    }
}
