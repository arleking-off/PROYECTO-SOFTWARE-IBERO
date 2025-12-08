<?php

use App\Models\Tienda;

if (!function_exists('tienda_actual')) {
    function tienda_actual()
    {
        $tiendaId = session('tienda_id');

        if ($tiendaId) {
            return Tienda::find($tiendaId);
        }

        return null;
    }
}

if (!function_exists('tienda_id')) {
    function tienda_id()
    {
        return session('tienda_id');
    }
}
