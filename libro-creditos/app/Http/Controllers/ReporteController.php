<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function cartera()
    {
        $tiendaId = session('tienda_id');

        $clientes = Cliente::where('tienda_id', $tiendaId)
            ->where('estado', 'activo')
            ->get()
            ->map(function($cliente) {
                $cliente->saldo_actual = $cliente->saldo();
                return $cliente;
            })
            ->filter(function($cliente) {
                return $cliente->saldo_actual > 0;
            })
            ->sortByDesc('saldo_actual');

        // Calcular total sumando el atributo temporal saldo_actual
        $totalCartera = $clientes->sum('saldo_actual');
        $cantidadClientes = $clientes->count();

        return view('reportes.cartera', compact('clientes', 'totalCartera', 'cantidadClientes'));
    }


    public function morosidad()
    {
        $tiendaId = session('tienda_id');
        $fechaLimite = Carbon::now()->subDays(30);

        $clientes = Cliente::where('tienda_id', $tiendaId)
            ->where('estado', 'activo')
            ->get()
            ->map(function($cliente) use ($fechaLimite) {
                $saldo = $cliente->saldo();

                if ($saldo > 0) {
                    $ultimoMovimiento = $cliente->movimientos()
                        ->orderBy('fecha', 'desc')
                        ->first();

                    if ($ultimoMovimiento && $ultimoMovimiento->fecha < $fechaLimite) {
                        $cliente->saldo_actual = $saldo;
                        $cliente->ultimo_movimiento = $ultimoMovimiento->fecha;
                        $cliente->dias_mora = Carbon::parse($ultimoMovimiento->fecha)
                            ->diffInDays(Carbon::now());
                        return $cliente;
                    }
                }

                return null;
            })
            ->filter()
            ->sortByDesc('dias_mora');

        $totalMorosos = $clientes->count();
        $totalDeudaMorosa = $clientes->sum('saldo_actual');

        return view('reportes.morosidad', compact('clientes', 'totalMorosos', 'totalDeudaMorosa'));
    }

    public function exportarCartera()
    {
        $tiendaId = session('tienda_id');

        $clientes = Cliente::where('tienda_id', $tiendaId)
            ->where('estado', 'activo')
            ->get()
            ->map(function($cliente) {
                $cliente->saldo_actual = $cliente->saldo();
                return $cliente;
            })
            ->filter(function($cliente) {
                return $cliente->saldo_actual > 0;
            });

        $filename = 'cartera_' . tienda_actual()->nombre . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($clientes) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Nombre', 'Alias', 'Contacto', 'Saldo']);

            foreach ($clientes as $cliente) {
                fputcsv($file, [
                    $cliente->id,
                    $cliente->nombre,
                    $cliente->alias,
                    $cliente->contacto,
                    number_format($cliente->saldo_actual, 0)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
