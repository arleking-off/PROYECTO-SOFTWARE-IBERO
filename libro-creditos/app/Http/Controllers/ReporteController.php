<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Movimiento;

class ReporteController extends Controller
{
    // Reporte de cartera general
    public function cartera()
    {
        $clientes = Cliente::with('movimientos')->get()->map(function($cliente) {
            return [
                'id' => $cliente->id,
                'nombre' => $cliente->nombre,
                'alias' => $cliente->alias,
                'contacto' => $cliente->contacto,
                'saldo' => $cliente->saldo(),
                'ultimo_movimiento' => $cliente->movimientos()->latest()->first()?->fecha
            ];
        })->filter(function($cliente) {
            return $cliente['saldo'] > 0; // Solo clientes con deuda
        })->sortByDesc('saldo');

        return view('reportes.cartera', compact('clientes'));
    }

    // Reporte de morosidad (clientes con deuda > 30 días)
    public function morosidad()
    {
        $fechaLimite = now()->subDays(30);

        $clientes = Cliente::with('movimientos')->get()->map(function($cliente) use ($fechaLimite) {
            $ultimoMovimiento = $cliente->movimientos()->latest()->first();
            $saldo = $cliente->saldo();

            if ($saldo > 0 && $ultimoMovimiento && $ultimoMovimiento->fecha < $fechaLimite) {
                return [
                    'id' => $cliente->id,
                    'nombre' => $cliente->nombre,
                    'contacto' => $cliente->contacto,
                    'saldo' => $saldo,
                    'dias_mora' => now()->diffInDays($ultimoMovimiento->fecha)
                ];
            }
            return null;
        })->filter()->sortByDesc('dias_mora');

        return view('reportes.morosidad', compact('clientes'));
    }

    // Exportar cartera a CSV
    public function exportarCartera()
    {
        $clientes = Cliente::with('movimientos')->get()->filter(function($cliente) {
            return $cliente->saldo() > 0;
        })->sortByDesc(function($cliente) {
            return $cliente->saldo();
        });

        $filename = 'cartera_' . date('Y-m-d') . '.csv';

        $callback = function() use ($clientes) {
            $file = fopen('php://output', 'w');

            // Encabezados del CSV
            fputcsv($file, ['ID', 'Nombre', 'Alias', 'Contacto', 'Saldo']);

            // Datos
            foreach ($clientes as $cliente) {
                fputcsv($file, [
                    $cliente->id,
                    $cliente->nombre,
                    $cliente->alias,
                    $cliente->contacto,
                    number_format($cliente->saldo(), 2, '.', '')
                ]);
            }

            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream($callback, 200, $headers);
    }
}
