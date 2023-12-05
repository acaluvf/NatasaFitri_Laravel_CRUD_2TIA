<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PegawaiController;

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

Route::get('/', function () {
    return view('template/master');
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('buku', BukuController::class);
Route::resource('pegawai', PegawaiController::class);