<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaAsetController;
use App\Http\Controllers\Admin\KelolaDataUserController;
use App\Http\Controllers\Admin\KelolaLaporanController;
use App\Http\Controllers\Admin\KelolaPengajuanController;

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\FormController;
use App\Http\Controllers\User\RankController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('auth.lupa_password');
    Route::post('/lupa-password', [AuthController::class, 'sendResetCode'])->name('auth.send_reset_code');

    Route::get('/verify-code', [AuthController::class, 'showVerifyCode'])->name('auth.verify_code');
    Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('auth.verify_code_submit');

    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('auth.reset_password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset_password_submit');

    Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('auth.resend_code');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/kelola_aset', [KelolaAsetController::class, 'index'])->name('kelola_aset.index');
        Route::get('/kelola_aset/create', [KelolaAsetController::class, 'create'])->name('kelola_aset.create');
        Route::post('/kelola_aset', [KelolaAsetController::class, 'store'])->name('kelola_aset.store');
        Route::get('/kelola_aset/trash', [KelolaAsetController::class, 'trash'])->name('kelola_aset.trash');
        Route::get('/kelola_aset/{barang}/edit', [KelolaAsetController::class, 'edit'])->name('kelola_aset.edit');
        Route::put('/kelola_aset/{barang}', [KelolaAsetController::class, 'update'])->name('kelola_aset.update');
        Route::delete('/kelola_aset/{barang}', [KelolaAsetController::class, 'destroy'])->name('kelola_aset.destroy');
        Route::put('/kelola_aset/{id}/restore', [KelolaAsetController::class, 'restore'])->name('kelola_aset.restore');
        Route::delete('/kelola_aset/{id}/force', [KelolaAsetController::class, 'forceDelete'])->name('kelola_aset.force_delete');

        Route::get('/kelola_data_user', [KelolaDataUserController::class, 'index'])->name('kelola_data_user.index');
        Route::get('/kelola_data_user/create', [KelolaDataUserController::class, 'create'])->name('kelola_data_user.create');
        Route::post('/kelola_data_user', [KelolaDataUserController::class, 'store'])->name('kelola_data_user.store');
        Route::get('/kelola_data_user/trash', [KelolaDataUserController::class, 'trash'])->name('kelola_data_user.trash');
        Route::get('/kelola_data_user/{user}/edit', [KelolaDataUserController::class, 'edit'])->name('kelola_data_user.edit');
        Route::put('/kelola_data_user/{user}', [KelolaDataUserController::class, 'update'])->name('kelola_data_user.update');
        Route::delete('/kelola_data_user/{user}', [KelolaDataUserController::class, 'destroy'])->name('kelola_data_user.destroy');
        Route::put('/kelola_data_user/{user}/restore', [KelolaDataUserController::class, 'restore'])->name('kelola_data_user.restore');
        Route::delete('/kelola_data_user/{user}/force', [KelolaDataUserController::class, 'forceDelete'])->name('kelola_data_user.force_delete');

        Route::get('/kelola_laporan', [KelolaLaporanController::class, 'index'])->name('kelola_laporan.index');
        Route::get('/kelola_laporan/create', [KelolaLaporanController::class, 'create'])->name('kelola_laporan.create');
        Route::post('/kelola_laporan', [KelolaLaporanController::class, 'store'])->name('kelola_laporan.store');
        Route::get('/kelola_laporan/trash', [KelolaLaporanController::class, 'trash'])->name('kelola_laporan.trash');
        Route::get('/kelola_laporan/{id}/edit', [KelolaLaporanController::class, 'edit'])->name('kelola_laporan.edit');
        Route::put('/kelola_laporan/{id}', [KelolaLaporanController::class, 'update'])->name('kelola_laporan.update');
        Route::delete('/kelola_laporan/{id}', [KelolaLaporanController::class, 'destroy'])->name('kelola_laporan.destroy');
        Route::patch('/kelola_laporan/{id}/restore', [KelolaLaporanController::class, 'restore'])->name('kelola_laporan.restore');
        Route::delete('/kelola_laporan/{id}/force', [KelolaLaporanController::class, 'forceDelete'])->name('kelola_laporan.force_delete');
        Route::get('/kelola_laporan/export/pdf', [KelolaLaporanController::class, 'exportPdf'])->name('kelola_laporan.export_pdf');
        Route::get('/kelola_laporan/export/excel', [KelolaLaporanController::class, 'exportExcel'])->name('kelola_laporan.export_excel');

        Route::get('/kelola_pengajuan', [KelolaPengajuanController::class, 'index'])->name('kelola_pengajuan');
        Route::put('/kelola_pengajuan/{id}/approve', [KelolaPengajuanController::class, 'approve'])->name('kelola_pengajuan.approve');
        Route::put('/kelola_pengajuan/{id}/reject', [KelolaPengajuanController::class, 'reject'])->name('kelola_pengajuan.reject');
    });

    /*
    |--------------------------------------------------------------------------
    | Peminjam Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/form', [FormController::class, 'index'])->name('form');
        Route::get('/rank', [RankController::class, 'index'])->name('rank');
    });
});
