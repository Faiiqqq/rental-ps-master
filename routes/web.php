<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PlaystationController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\LaporanController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pelanggan', [PelangganController::class, 'index']);

    Route::resource('transaksi', TransaksiController::class);
    Route::patch(
        'transaksi/{id}/selesai',
        [TransaksiController::class, 'selesai']
    )->name('transaksi.selesai');

    Route::middleware('role:admin,operator,pelanggan')->group(function () {

        Route::resource('user', UserController::class);
        Route::resource('playstation', PlaystationController::class);
    });

    Route::patch('transaksi/{id}/approve', [TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::patch('transaksi/{id}/reject', [TransaksiController::class, 'reject'])->name('transaksi.reject');

    Route::patch('transaksi/{id}/request-return', [TransaksiController::class, 'requestReturn'])->name('transaksi.requestReturn');

    Route::patch('transaksi/{id}/approve-return', [TransaksiController::class, 'approveReturn'])->name('transaksi.approveReturn');
    Route::patch('transaksi/{id}/reject-return', [TransaksiController::class, 'rejectReturn'])->name('transaksi.rejectReturn');

    Route::get('/log-activity', [LogActivityController::class, 'index'])->name('log.index');


    Route::middleware(['auth', 'role:admin,operator'])->group(function () {

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/cetak', [LaporanController::class, 'process'])->name('laporan.process');
    });
});
