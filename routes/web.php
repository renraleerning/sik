<?php
	
	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\LoginController;
	use App\Http\Controllers\TransaksiController;
	
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
	
	Route::get('/', [LoginController::class, 'login'])->name('login');
	Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
	Route::get('home', [TransaksiController::class, 'index'])->name('home')->middleware('auth');
    Route::resource('/transaksi', \App\Http\Controllers\TransaksiController::class);
    Route::get('barang', [TransaksiController::class, 'barang'])->name('barang');
	Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

	Route::resource('/barang', \App\Http\Controllers\BarangController::class);
