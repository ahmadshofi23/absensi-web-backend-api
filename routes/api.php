<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\CutiIzinController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('absensi/masuk', [AbsensiController::class, 'masuk']);
    Route::post('absensi/pulang', [AbsensiController::class, 'pulang']);
    Route::get('absensi/riwayat', [AbsensiController::class, 'riwayat']);

    Route::get('absensi/cuti-izin', [CutiIzinController::class, 'index']);
    Route::post('absensi/cuti-izin', [CutiIzinController::class, 'store']);


    // dimatikan dulu karena harus setting docker
    // Route::get('notifications', [NotificationController::class, 'index']);
    // Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});
