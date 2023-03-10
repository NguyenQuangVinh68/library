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
use App\Http\Controllers\Admin\DashboardController;

// client
use App\Http\Controllers\Client\IndexController;
use App\Http\Controllers\Client\SachClientController;
use App\Http\Controllers\Client\BangxephangController;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('search', [SachClientController::class, 'search'])->name('sach.search');
Route::get('danhmuc/{slug}', [SachClientController::class, 'danhmuc'])->name('sach.danhmuc');
Route::get('danhmuc/{slugDanhmuc}/nganh/{slugNganh}', [SachClientController::class, 'nganh'])->name('sach.nganh');
Route::get('sach/{sach_id}', [SachClientController::class, 'detail'])->name('sach.chitiet');
Route::post('yeuthich', [SachClientController::class, 'yeuthich'])->name('sach.yeuthich');
Route::get('sach-dang-muon', [SachClientController::class, 'dangmuon'])->name('sach.dangmuon');
Route::get('danh-sach-yeu-thich', [SachClientController::class, 'danhsachyeuthich'])->name('sach.danhsachyeuthich');
Route::get('taive/{sach_id}', [SachClientController::class, 'taive'])->name('sach.taive');
Route::post('danhgia/{sach_id}', [SachClientController::class, 'danhgia'])->name('sach.danhgia');
Route::get('bangxephang', [BangxephangController::class, 'index'])->name('bangxephang');


Route::prefix('ajax')->group(function () {
    Route::post('binh-luan/{sach_id}', [SachClientController::class, 'binhluan'])->name('ajax.binhluan');
    Route::post('muon-sach', [SachClientController::class, 'muonsach'])->name('ajax.muonsach');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource("danh-muc", DanhmucController::class)->except(['show']);
    Route::resource("khoa", KhoaController::class)->except(['show']);
    Route::resource("binh-luan", BinhluanController::class)->only(['index', 'update']);
    Route::resource("nganh", NganhController::class)->except(['show']);
    Route::resource("vitri", VitriController::class)->except(['show']);

    // user
    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('user.index');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::put('{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::post('import', [UserController::class, 'import'])->name('user.import');
    });
    // end user

    // s??ch
    Route::prefix('sach')->group(function () {
        Route::get('', [SachController::class, 'index'])->name('sach.index');
        Route::post('store', [SachController::class, 'store'])->name('sach.store');
        Route::get('create', [SachController::class, 'create'])->name('sach.create');
        Route::put('{sach}', [SachController::class, 'update'])->name('sach.update');
        Route::delete('{sach}', [SachController::class, 'destroy'])->name('sach.destroy');
        Route::get('{sach}/edit', [SachController::class, 'edit'])->name('sach.edit');
        Route::post('loc', [SachController::class, 'loc_khoa_nganh'])->name('sach.loc');
    });
    // end s??ch

    // ho???t ?????ng
    Route::group(['prefix' => 'hoat-dong'], function () {
        // m?????n
        Route::get('muon', [MuonController::class, 'index'])->name('muon');
        Route::post('muon', [MuonController::class, 'findStudent'])->name('tim-sinhvien');
        Route::post('tim-sach', [MuonController::class, 'findBook'])->name('tim-sach');
        Route::delete('muon/{masach?}', [MuonController::class, 'removeBookInSession'])->name('xoa-sach');
        Route::get('muon-action', [MuonController::class, 'muonAction'])->name('muon-action');
        // tr???
        Route::prefix('tra')->group(function () {
            Route::get('', [TraController::class, 'index'])->name('tra.index');
            Route::get('create', [TraController::class, 'create'])->name('tra.create');
            Route::post('store', [TraController::class, 'store'])->name('tra.store');
            Route::post('action', [TraController::class, 'tra'])->name('tra.action');
        });
        // m???t
        Route::post('mat', [TraController::class, 'mat'])->name('mat');
        // gia h???n m?????n
        Route::prefix('giahan')->group(function () {
            Route::get('{id}', [TraController::class, 'giahan'])->name('giahan.index');
            Route::post('', [TraController::class, 'store_giahan'])->name('giahan.post');
        });
        // m?????n online
        Route::get('online/muon', [MuonOnlineController::class, 'index'])->name('muon.online');
        Route::get('online/muon/xac-nhan/{id_dangki?}', [MuonOnlineController::class, 'xacnhan'])->name('muon.online.xacnhan');
    });
    // end ho???t ?????ng

    // Th???ng k??
    Route::prefix('thongke')->group(function () {
        Route::get('index', [ThongkeController::class, 'index'])->name('thongke.index');
        Route::post('loctheomuc', [ThongkeController::class, 'loctheomuc'])->name('thongke.loctheomuc');
        Route::post('tuychinh', [ThongkeController::class, 'tuychinh'])->name('thongke.tuychinh');
    });
});
