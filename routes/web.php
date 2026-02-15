<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//halaman public
Route::view('/', 'home')->name('home');
Route::view('/rank', 'rank')->name('rank');
Route::view('/auth/login', 'auth.login')->name('auth.login');
Route::view('/auth/lupa_password', 'auth.lupa_password')->name('auth.lupa_password');


//halaman admin
Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/kelola_aset/index', 'admin.kelola_aset.index')->name('admin.kelola_aset.index');
Route::view('/admin/kelola_data_user/index', 'admin.kelola_data_user.index')->name('admin.kelola_data_user.index');
Route::view('/admin/kelola_pengajuan/index', 'admin.kelola_pengajuan.index')->name('admin.kelola_pengajuan.index');
Route::view('/admin/laporan/index', 'admin.laporan.index')->name('admin.laporan.index');
