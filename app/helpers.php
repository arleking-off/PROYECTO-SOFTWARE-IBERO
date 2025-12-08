<?php

if (!function_exists('tienda_actual')) {
    /**
     * Obtiene la tienda actualmente seleccionada por el usuario
     */
    function tienda_actual()
    {
        if (!auth()->check()) {
            return null;
        }

        // Si hay una tienda en sesión, devolverla
        if (session()->has('tienda_id')) {
            $tiendaId = session('tienda_id');
            return auth()->user()->tiendas()->find($tiendaId);
        }

        // Si el usuario solo tiene una tienda, devolverla automáticamente
        $tiendas = auth()->user()->tiendas;
        
        if ($tiendas->count() === 1) {
            $tienda = $tiendas->first();
            session(['tienda_id' => $tienda->id]);
            return $tienda;
        }

        // Si tiene múltiples tiendas, devolver la primera
        if ($tiendas->count() > 0) {
            $tienda = $tiendas->first();
            session(['tienda_id' => $tienda->id]);
            return $tienda;
        }

        return null;
    }
}
