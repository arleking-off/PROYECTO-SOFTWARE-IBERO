<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $tiendaId = session('tienda_id');
        $buscar = $request->get('buscar');

        $clientes = Cliente::where('tienda_id', $tiendaId)
            ->when($buscar, function($query, $buscar) {
                return $query->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('alias', 'LIKE', "%{$buscar}%")
                    ->orWhere('contacto', 'LIKE', "%{$buscar}%");
            })
            ->orderBy('nombre')
            ->get();

        return view('clientes.index', compact('clientes', 'buscar'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3',
            'alias' => 'nullable',
            'contacto' => 'nullable'
        ]);

        Cliente::create([
            'tienda_id' => session('tienda_id'),
            'nombre' => $request->nombre,
            'alias' => $request->alias,
            'contacto' => $request->contacto,
            'estado' => 'activo'
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    public function edit(Cliente $cliente)
    {
        if ($cliente->tienda_id != session('tienda_id')) {
            abort(403, 'No tienes permiso para editar este cliente');
        }

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        if ($cliente->tienda_id != session('tienda_id')) {
            abort(403, 'No tienes permiso para editar este cliente');
        }

        $request->validate([
            'nombre' => 'required|min:3',
            'alias' => 'nullable',
            'contacto' => 'nullable'
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function cambiarEstado($id)
    {
        $cliente = Cliente::where('tienda_id', session('tienda_id'))
            ->findOrFail($id);

        $cliente->estado = $cliente->estado == 'activo' ? 'inactivo' : 'activo';
        $cliente->save();

        $mensaje = $cliente->estado == 'activo'
            ? 'Cliente activado correctamente'
            : 'Cliente inactivado correctamente';

        return redirect()->route('clientes.index')
            ->with('success', $mensaje);
    }

    public function historial($id)
    {
        $cliente = Cliente::where('tienda_id', session('tienda_id'))
            ->with('movimientos')
            ->findOrFail($id);

        $movimientos = $cliente->movimientos()
            ->orderBy('fecha', 'desc')
            ->get();

        $totalFiado = $cliente->movimientos()->where('tipo', 'fiado')->sum('monto');
        $totalAbonado = $cliente->movimientos()->where('tipo', 'abono')->sum('monto');
        $saldo = $totalFiado - $totalAbonado;
        $cantidadMovimientos = $movimientos->count();
        $ultimoMovimiento = $movimientos->first();

        return view('clientes.historial', compact(
            'cliente',
            'movimientos',
            'totalFiado',
            'totalAbonado',
            'saldo',
            'cantidadMovimientos',
            'ultimoMovimiento'
        ));
    }
}
