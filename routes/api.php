<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::resource('laporans', LaporanController::class);
    Route::post('/laporans/{id}/approve', [LaporanController::class, 'approve'])->name('laporans.api.approve')->middleware('role:admin');
    Route::post('/laporans/{id}/reject', [LaporanController::class, 'reject'])->name('laporans.reject')->middleware('role:admin');
    Route::get('dashboard', [LaporanController::class, 'dashboard'])->middleware('role:admin');
});

// Route::middleware(['auth', 'checkRole:admin'])->group(function () {
//     // Protected routes
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });
