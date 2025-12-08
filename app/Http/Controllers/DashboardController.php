<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tiendaId = session('tienda_id');

        // Estadísticas generales
        $totalClientes = Cliente::where('tienda_id', $tiendaId)
            ->where('estado', 'activo')
            ->count();

        $totalCartera = Cliente::where('tienda_id', $tiendaId)
            ->get()
            ->sum(function($cliente) {
                return $cliente->saldo();
            });

        $totalFiadoMes = Movimiento::where('tienda_id', $tiendaId)
            ->where('tipo', 'fiado')
            ->whereMonth('fecha', date('m'))
            ->whereYear('fecha', date('Y'))
            ->sum('monto');

        $totalAbonadoMes = Movimiento::where('tienda_id', $tiendaId)
            ->where('tipo', 'abono')
            ->whereMonth('fecha', date('m'))
            ->whereYear('fecha', date('Y'))
            ->sum('monto');

        // Top 5 deudores
        $topDeudores = Cliente::where('tienda_id', $tiendaId)
            ->where('estado', 'activo')
            ->get()
            ->map(function($cliente) {
                $cliente->saldo_actual = $cliente->saldo();
                return $cliente;
            })
            ->sortByDesc('saldo_actual')
            ->take(5);

        // Últimos movimientos
        $ultimosMovimientos = Movimiento::where('tienda_id', $tiendaId)
            ->with('cliente')
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalClientes',
            'totalCartera',
            'totalFiadoMes',
            'totalAbonadoMes',
            'topDeudores',
            'ultimosMovimientos'
        ));
    }
}
