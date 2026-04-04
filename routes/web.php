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
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('index');

/*
|--------------------------------------------------------------------------
| Guest Routes (Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.lupa_password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('auth.send_reset_code');

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

    Route::middleware('role:admin,super-admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('assets')->name('assets.')->group(function () {
            Route::get('/',                  [KelolaAsetController::class, 'index'])->name('index');
            Route::get('/create',            [KelolaAsetController::class, 'create'])->name('create');
            Route::post('/',                 [KelolaAsetController::class, 'store'])->name('store');
            Route::get('/trash',             [KelolaAsetController::class, 'trash'])->name('trash');
            Route::get('/{barang}/edit',     [KelolaAsetController::class, 'edit'])->name('edit');
            Route::put('/{barang}',          [KelolaAsetController::class, 'update'])->name('update');
            Route::delete('/{barang}',       [KelolaAsetController::class, 'destroy'])->name('destroy');
            Route::put('/{id}/restore',      [KelolaAsetController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force',     [KelolaAsetController::class, 'forceDelete'])->name('force_delete');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/',                  [KelolaDataUserController::class, 'index'])->name('index');
            Route::get('/create',            [KelolaDataUserController::class, 'create'])->name('create');
            Route::post('/',                 [KelolaDataUserController::class, 'store'])->name('store');
            Route::get('/trash',             [KelolaDataUserController::class, 'trash'])->name('trash');
            Route::get('/{user}/edit',       [KelolaDataUserController::class, 'edit'])->name('edit');
            Route::put('/{user}',            [KelolaDataUserController::class, 'update'])->name('update');
            Route::delete('/{user}',         [KelolaDataUserController::class, 'destroy'])->name('destroy');
            Route::put('/{user}/restore',    [KelolaDataUserController::class, 'restore'])->name('restore');
            Route::delete('/{user}/force',   [KelolaDataUserController::class, 'forceDelete'])->name('force_delete');
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',                  [KelolaLaporanController::class, 'index'])->name('index');
            Route::get('/create',            [KelolaLaporanController::class, 'create'])->name('create');
            Route::post('/',                 [KelolaLaporanController::class, 'store'])->name('store');
            Route::get('/trash',             [KelolaLaporanController::class, 'trash'])->name('trash');
            Route::get('/{id}/edit',         [KelolaLaporanController::class, 'edit'])->name('edit');
            Route::put('/{id}',              [KelolaLaporanController::class, 'update'])->name('update');
            Route::delete('/{id}',           [KelolaLaporanController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/restore',    [KelolaLaporanController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force',     [KelolaLaporanController::class, 'forceDelete'])->name('force_delete');
            Route::get('/export/pdf',        [KelolaLaporanController::class, 'exportPdf'])->name('export_pdf');
            Route::get('/export/excel',      [KelolaLaporanController::class, 'exportExcel'])->name('export_excel');
        });

        Route::prefix('approvals')->name('approvals.')->group(function () {
            Route::get('/',                  [KelolaPengajuanController::class, 'index'])->name('index');
            Route::put('/{id}/approve',      [KelolaPengajuanController::class, 'approve'])->name('approve');
            Route::put('/{id}/reject',       [KelolaPengajuanController::class, 'reject'])->name('reject');
        });
    });

    Route::middleware('role:peminjam')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/my-dashboard', [UserDashboardController::class, 'index'])->name('my.dashboard');
        Route::get('/borrow/{barang?}', [FormController::class, 'index'])->name('borrow');
        Route::post('/borrow', [FormController::class, 'store'])->name('borrow.store');
        Route::get('/rankings', [RankController::class, 'index'])->name('rankings');

        Route::get('/profile',   [UserDashboardController::class, 'profile'])->name('profile');
        Route::get('/history',   [UserDashboardController::class, 'riwayat'])->name('history');
        Route::get('/loans',     [UserDashboardController::class, 'pinjaman'])->name('loans');
        Route::get('/facilities', [UserDashboardController::class, 'sarpras'])->name('facilities');
        Route::get('/rank',      [UserDashboardController::class, 'rank'])->name('rank');
    });
});
