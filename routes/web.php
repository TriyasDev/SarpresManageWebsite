<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaAsetController;
use App\Http\Controllers\Admin\KelolaDataUserController;
use App\Http\Controllers\Admin\KelolaLaporanController;
use App\Http\Controllers\Admin\KelolaPengajuanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

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

        Route::get('/kelola_aset', [KelolaAsetController::class, 'index'])->name('kelola_aset');
        Route::post('/kelola_aset', [KelolaAsetController::class, 'store'])->name('kelola_aset.store');
        Route::put('/kelola_aset/{id}', [KelolaAsetController::class, 'update'])->name('kelola_aset.update');
        Route::delete('/kelola_aset/{id}', [KelolaAsetController::class, 'destroy'])->name('kelola_aset.destroy');

        Route::get('/kelola_data_user', [KelolaDataUserController::class, 'index'])->name('kelola_data_user');

        Route::get('/kelola_laporan', [KelolaLaporanController::class, 'index'])->name('kelola_laporan');
        Route::post('/kelola_laporan', [KelolaLaporanController::class, 'store'])->name('kelola_laporan.store');
        Route::delete('/kelola_laporan/trash', [KelolaLaporanController::class, 'trash'])->name('kelola_laporan.trash');
        Route::get('/kelola_laporan/{id}/edit', [KelolaLaporanController::class, 'show'])->name('kelola_laporan.show');
        Route::put('/kelola_laporan/{id}', [KelolaLaporanController::class, 'update'])->name('kelola_laporan.update');
        Route::delete('/kelola_laporan/{id}/force', [KelolaLaporanController::class, 'forceDelete'])->name('kelola_laporan.force_delete');
        Route::get('/kelola_laporan/export/pdf', [KelolaLaporanController::class, 'exportPdf'])->name('kelola_laporan.export_pdf');
        Route::get('/kelola_laporan/export/excel', [KelolaLaporanController::class, 'exportExcel'])->name('kelola_laporan.export_excel');

        Route::get('/kelola_pengajuan', [KelolaPengajuanController::class, 'index'])->name('kelola_pengajuan');
    });

    /*
    |--------------------------------------------------------------------------
    | Peminjam Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {
        Route::get('/', function () {
            return view('home');
        })->name('home');
    });
});

Route::get('/form', function () {
    return view('form');
});



// Tambahkan di dalam group admin yang sudah ada
Route::get('/kelola-data-user', [KelolaDataUserController::class, 'index'])
    ->name('admin.kelola-data-user.index');

Route::post('/kelola-data-user', [KelolaDataUserController::class, 'store'])
    ->name('admin.kelola-data-user.store');

Route::put('/kelola-data-user/{user}', [KelolaDataUserController::class, 'update'])
    ->name('admin.kelola-data-user.update');

Route::delete('/kelola-data-user/{user}', [KelolaDataUserController::class, 'destroy'])
    ->name('admin.kelola-data-user.destroy');
