<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Route::get('/kelola_aset', [BarangController::class, 'index'])->name('barang.index');
        // Route::get('/kelola_data_user', [KelolaDataUserController::class, 'index'])->name('peminjaman.index');
        // Route::get('/kelola_pengajuan', [KelolaPengajuanController::class, 'index'])->name('peminjaman.index');
        // Route::get('/laporan', [LaporanController::class, 'index'])->name('peminjaman.index');
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
