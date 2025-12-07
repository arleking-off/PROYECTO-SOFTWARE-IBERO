<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('clientes', ClienteController::class);
    Route::resource('movimientos', MovimientoController::class);
    Route::get('/reportes/cartera', [ReporteController::class, 'cartera'])->name('reportes.cartera');
    Route::get('/reportes/morosidad', [ReporteController::class, 'morosidad'])->name('reportes.morosidad');
    Route::get('/reportes/exportar-cartera', [ReporteController::class, 'exportarCartera'])->name('reportes.exportar');

});

require __DIR__.'/auth.php';
