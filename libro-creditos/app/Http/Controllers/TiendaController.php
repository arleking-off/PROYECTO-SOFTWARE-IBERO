<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiendaController extends Controller
{
    // Mostrar selector de tiendas
    public function seleccionar()
    {
        $tiendas = Auth::user()->tiendas;

        if ($tiendas->count() === 1) {
            session(['tienda_id' => $tiendas->first()->id]);
            return redirect()->route('dashboard');
        }

        return view('tiendas.seleccionar', compact('tiendas'));
    }

    // Establecer tienda activa
    public function establecer($id)
    {
        $tienda = Auth::user()->tiendas()->findOrFail($id);
        session(['tienda_id' => $tienda->id]);

        return redirect()->route('dashboard')->with('success', 'Tienda seleccionada: ' . $tienda->nombre);
    }

    // Listar tiendas del usuario
    public function index()
    {
        $tiendas = Auth::user()->tiendas;
        return view('tiendas.index', compact('tiendas'));
    }

    // Mostrar formulario de crear tienda
    public function create()
    {
        return view('tiendas.create');
    }

    // Guardar nueva tienda
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'nit' => 'nullable'
        ]);

        $tienda = Tienda::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'nit' => $request->nit,
            'user_id' => Auth::id()
        ]);

        // Agregar el usuario creador con rol propietario
        $tienda->usuarios()->attach(Auth::id(), ['rol' => 'propietario']);

        // Establecer como tienda activa
        session(['tienda_id' => $tienda->id]);

        return redirect()->route('dashboard')->with('success', 'Tienda creada exitosamente');
    }

    // Mostrar formulario de editar
    public function edit($id)
    {
        $tienda = Auth::user()->tiendas()->findOrFail($id);
        return view('tiendas.edit', compact('tienda'));
    }

    // Actualizar tienda
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|min:3',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'nit' => 'nullable'
        ]);

        $tienda = Auth::user()->tiendas()->findOrFail($id);
        $tienda->update($request->all());

        return redirect()->route('tiendas.index')->with('success', 'Tienda actualizada exitosamente');
    }
}
