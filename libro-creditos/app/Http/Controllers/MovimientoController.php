<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Cliente;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index()
    {
        $tiendaId = session('tienda_id');

        $movimientos = Movimiento::where('tienda_id', $tiendaId)
            ->with('cliente')
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('movimientos.index', compact('movimientos'));
    }

    public function create(Request $request)
    {
        $tiendaId = session('tienda_id');

        $clientes = Cliente::where('tienda_id', $tiendaId)
            ->where('estado', 'activo')
            ->orderBy('nombre')
            ->get();

        $clienteSeleccionado = $request->get('cliente');

        return view('movimientos.create', compact('clientes', 'clienteSeleccionado'));
    }

    public function store(Request $request)
    {
        $tiendaId = session('tienda_id');

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|in:fiado,abono',
            'monto' => 'required|numeric|min:1',
            'fecha' => 'required|date',
            'descripcion' => 'nullable'
        ]);

        // Verificar que el cliente pertenece a la tienda actual
        $cliente = Cliente::where('tienda_id', $tiendaId)
            ->findOrFail($request->cliente_id);

        Movimiento::create([
            'tienda_id' => $tiendaId,
            'cliente_id' => $request->cliente_id,
            'tipo' => $request->tipo,
            'monto' => $request->monto,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('movimientos.index')
            ->with('success', 'Movimiento registrado exitosamente');
    }

    public function show(Movimiento $movimiento)
    {
        if ($movimiento->tienda_id != session('tienda_id')) {
            abort(403, 'No tienes permiso para ver este movimiento');
        }

        return view('movimientos.show', compact('movimiento'));
    }
}
