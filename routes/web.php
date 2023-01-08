<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Admin\DanhmucController;
use App\Http\Controllers\Admin\KhoaController;
use App\Http\Controllers\Admin\NganhController;
use App\Http\Controllers\Admin\SachController;
use App\Http\Controllers\Admin\VitriController;
use App\Http\Controllers\Admin\MuonController;
use App\Http\Controllers\Admin\TraController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MuonOnlineController;
use App\Http\Controllers\Admin\ThongkeController;
use App\Http\Controllers\Admin\BinhluanController;

// client
use App\Http\Controllers\Client\IndexController;
use App\Http\Controllers\Client\SachClientController;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/home', function () {
//     return redirect('/');
// });

// Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
// Route::get('register', [AuthController::class, 'register'])->name('register');
// Route::post('post-register', [AuthController::class, 'postRegister'])->name('register.post');
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('search', [SachClientController::class, 'search'])->name('sach.search');
Route::get('danhmuc/{slug}', [SachClientController::class, 'danhmuc'])->name('sach.danhmuc');
Route::get('danhmuc/{slugDanhmuc}/nganh/{slugNganh}', [SachClientController::class, 'nganh'])->name('sach.nganh');
Route::get('sach/{sach_id}', [SachClientController::class, 'detail'])->name('sach.chitiet');
Route::post('yeuthich', [SachClientController::class, 'yeuthich'])->name('sach.yeuthich');
Route::get('sach-dang-muon', [SachClientController::class, 'dangmuon'])->name('sach.dangmuon');
Route::get('danh-sach-yeu-thich', [SachClientController::class, 'danhsachyeuthich'])->name('sach.danhsachyeuthich');
Route::get('taive/{sach_id}', [SachClientController::class, 'taive'])->name('sach.taive');


Route::prefix('ajax')->group(function () {
    Route::post('binh-luan/{sach_id}', [SachClientController::class, 'binhluan'])->name('ajax.binhluan');
    Route::post('muon-sach', [SachClientController::class, 'muonsach'])->name('ajax.muonsach');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('', function () {
        return view("pages.admin.dashboard");
    })->name('dashboard');
    Route::resource("danh-muc", DanhmucController::class)->except(['show']);
    Route::resource("khoa", KhoaController::class)->except(['show']);
    Route::resource("binh-luan", BinhluanController::class)->only(['index', 'update']);
    Route::resource("nganh", NganhController::class)->except(['show']);
    Route::resource("vitri", VitriController::class)->except(['show']);
    Route::resource("user", UserController::class)->except(['show']);

    // sách
    // Route::resource("sach", SachController::class)->except(['show']);
    Route::prefix('sach')->group(function () {
        Route::get('', [SachController::class, 'index'])->name('sach.index');
        Route::post('store', [SachController::class, 'store'])->name('sach.store');
        Route::get('create', [SachController::class, 'create'])->name('sach.create');
        Route::put('{sach}', [SachController::class, 'update'])->name('sach.update');
        Route::delete('{sach}', [SachController::class, 'destroy'])->name('sach.destroy');
        Route::get('{sach}/edit', [SachController::class, 'edit'])->name('sach.edit');
        Route::post('loc', [SachController::class, 'loc_khoa_nganh'])->name('sach.loc');
        Route::get('loc', [SachController::class, 'loc_khoa_nganh']);
    });
    // hoạt động
    Route::group(['prefix' => 'hoat-dong'], function () {
        // mượn
        Route::get('muon', [MuonController::class, 'index'])->name('muon');
        Route::post('muon', [MuonController::class, 'findStudent'])->name('tim-sinhvien');
        Route::post('tim-sach', [MuonController::class, 'findBook'])->name('tim-sach');
        Route::delete('muon/{masach?}', [MuonController::class, 'removeBookInSession'])->name('xoa-sach');
        Route::get('muon-action', [MuonController::class, 'muonAction'])->name('muon-action');
        // trả
        Route::resource('tra', TraController::class);
        Route::post('tra/action', [TraController::class, 'tra'])->name('tra-action');
        Route::post('tra/mat', [TraController::class, 'mat'])->name('mat');
        // muon online
        Route::get('online/muon', [MuonOnlineController::class, 'index'])->name('muon.online');
        Route::get('online/muon/xac-nhan/{id_dangki?}', [MuonOnlineController::class, 'xacnhan'])->name('muon.online.xacnhan');
    });

    // Thống kê
    Route::prefix('thongke')->group(function () {
        Route::get('index', [ThongkeController::class, 'index'])->name('thongke.index');
        Route::post('loctheomuc', [ThongkeController::class, 'loctheomuc'])->name('thongke.loctheomuc');
        Route::post('tuychinh', [ThongkeController::class, 'tuychinh'])->name('thongke.tuychinh');
    });
});

Route::get('test', function () {
    $kq = App\Models\Sach::orderBy('id', 'DESC')
        ->where('khoa', 'kế toán')
        ->orWhere('nganh', 'kế toán')
        ->get();
    dd($kq);
});
