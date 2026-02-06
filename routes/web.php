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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/aset', function () {
    return view('admin.aset');
});
Route::get('/page', function () {
    return view('landing-page.page');
});
Route::get('/login', function () {
    return view('Login.login');
});
Route::get('/lupa', function () {
    return view('Login.lupa-sandi');
});
Route::get('/daftar', function () {
    return view('Login.daftar');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/pengajuan', function () {
    return view('admin.pengajuan');
});
Route::get('/laporan', function () {
    return view('admin.laporan');
});
Route::get('/user', function () {
    return view('admin.user');
});
