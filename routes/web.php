<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CutiIzinController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::resource('karyawan', \App\Http\Controllers\Admin\KaryawanController::class);
    
    Route::resource('absensi', \App\Http\Controllers\Admin\AbsensiController::class)
        ->only(['index', 'show']);
    
    Route::get('absensi/create', [\App\Http\Controllers\Admin\AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('absensi/store', [\App\Http\Controllers\Admin\AbsensiController::class, 'store'])->name('absensi.store');

    Route::resource('cuti-izin', CutiIzinController::class);

    Route::get('absensi/export', [\App\Http\Controllers\Admin\AbsensiController::class, 'export'])->name('absensi.export');
});

require __DIR__.'/auth.php';
