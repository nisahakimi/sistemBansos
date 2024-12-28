<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\WilayahController;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');  // Or any appropriate action for guests.
});

Route::get('/not-authorized', function () {
    return view('not-authorized');
})->name('not.authorized');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::middleware(['auth'])->group(
    function () {

        Route::get('/', function () {
            return view('welcome');
        });


        Route::get('/programs', [App\Http\Controllers\ProgramController::class, 'index'])->name('programs.index')->middleware('role:admin');;
        Route::get('/programs/create', [App\Http\Controllers\ProgramController::class, 'create'])->name('programs.create')->middleware('role:admin');;
        Route::post('/programs', [App\Http\Controllers\ProgramController::class, 'store'])->name('programs.store')->middleware('role:admin');;

        Route::get('/programs/{program}/edit', [App\Http\Controllers\ProgramController::class, 'edit'])->name('programs.edit')->middleware('role:admin');;
        Route::patch('/programs/{program}', [App\Http\Controllers\ProgramController::class, 'update'])->name('programs.update')->middleware('role:admin');;
        Route::delete('/programs/{program}', [App\Http\Controllers\ProgramController::class, 'destroy'])->name('programs.destroy')->middleware('role:admin');;
        // });

        //wilayah
        Route::get('/wilayahs', [App\Http\Controllers\WilayahController::class, 'index'])->name('wilayahs.index')->middleware('role:admin');;
        Route::get('/wilayahs/create', [App\Http\Controllers\WilayahController::class, 'create'])->name('wilayahs.create')->middleware('role:admin');;
        Route::post('/wilayahs', [App\Http\Controllers\WilayahController::class, 'store'])->name('wilayahs.store')->middleware('role:admin');;


        //laporan
        Route::get('/laporans', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporans.index');
        Route::get('/laporans/create', [App\Http\Controllers\LaporanController::class, 'create'])->name('laporans.create');
        //show
        Route::get('/laporans/{laporan}', [App\Http\Controllers\LaporanController::class, 'show'])->name('laporans.show');
        Route::get('/laporans/{laporan}/edit', [App\Http\Controllers\LaporanController::class, 'edit'])->name('laporans.edit');

        Route::get('/wilayahs/getKabupaten/{provinsi}', [WilayahController::class, 'getKabupaten']);
        Route::get('/wilayahs/getKecamatan/{kabupaten}', [WilayahController::class, 'getKecamatan']);

        //
        Route::get('api/dashboard', [LaporanController::class, 'dashboard'])->name('dashboard')->middleware('role:admin');;
    }
);
