<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = ['cliente_id', 'tipo', 'monto', 'fecha', 'descripcion'];

// Relación: un movimiento pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

}
