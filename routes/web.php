<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TiendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Rutas de gestión de tiendas (sin middleware de tienda)
    Route::get('/tiendas/seleccionar', [TiendaController::class, 'seleccionar'])->name('tiendas.seleccionar');
    Route::post('/tiendas/establecer/{id}', [TiendaController::class, 'establecer'])->name('tiendas.establecer');
    Route::resource('tiendas', TiendaController::class);

    // Rutas que requieren tienda seleccionada
    Route::middleware(['tienda'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Clientes
        Route::resource('clientes', ClienteController::class);
        Route::get('/clientes/{id}/historial', [ClienteController::class, 'historial'])->name('clientes.historial');
        Route::post('/clientes/{id}/cambiar-estado', [ClienteController::class, 'cambiarEstado'])->name('clientes.cambiarEstado');

        // Movimientos
        Route::resource('movimientos', MovimientoController::class);

        // Reportes
        Route::get('/reportes/cartera', [ReporteController::class, 'cartera'])->name('reportes.cartera');
        Route::get('/reportes/morosidad', [ReporteController::class, 'morosidad'])->name('reportes.morosidad');
        Route::get('/reportes/exportar-cartera', [ReporteController::class, 'exportarCartera'])->name('reportes.exportar');
    });
});

require __DIR__.'/auth.php';
