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
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);

    // Lupa Password - Step 1: Input Email
    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('auth.lupa_password');
    Route::post('/lupa-password', [AuthController::class, 'sendResetCode'])->name('auth.send_reset_code');

    // Lupa Password - Step 2: Verifikasi Kode
    Route::get('/verify-code', [AuthController::class, 'showVerifyCode'])->name('auth.verify_code');
    Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('auth.verify_code_submit');

    // Lupa Password - Step 3: Reset Password
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('auth.reset_password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset_password_submit');

    // Resend Code
    Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('auth.resend_code');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/kelola_aset', [KelolaAsetController::class, 'index'])->name('kelola_aset');
        Route::get('/kelola_data_user', [KelolaDataUserController::class, 'index'])->name('kelola_data_user');
        Route::get('/kelola_laporan', [KelolaLaporanController::class, 'index'])->name('kelola_laporan');
        Route::get('/kelola_pengajuan', [KelolaPengajuanController::class, 'index'])->name('kelola_pengajuan');
>>>>>>> 0c85189 (Backend v2 "Revisi route dan pembuatan controller admin")
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

        // Tambahkan route peminjam lainnya di sini
        // Route::get('/pinjam', [PeminjamanController::class, 'create'])->name('pinjam.create');
        // Route::get('/riwayat', [PeminjamanController::class, 'history'])->name('riwayat');
    });
});

Route::get('/form', function () {
    return view('form');
});
