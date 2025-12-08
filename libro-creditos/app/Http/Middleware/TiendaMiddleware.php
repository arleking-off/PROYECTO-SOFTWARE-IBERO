<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TiendaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('tienda_id')) {
            // Si no hay tienda seleccionada, redirigir a selección
            if ($request->user()->tiendas()->count() > 0) {
                return redirect()->route('tiendas.seleccionar');
            }
            // Si no tiene tiendas, redirigir a crear una
            return redirect()->route('tiendas.create')->with('error', 'Debes crear una tienda primero');
        }

        return $next($request);
    }
}
