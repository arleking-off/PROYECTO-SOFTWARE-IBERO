<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['tienda_id','nombre', 'alias', 'contacto', 'estado'];
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

// Metodo para calcular el saldo
    public function saldo()
    {
        $fiados = $this->movimientos()->where('tipo', 'fiado')->sum('monto');
        $abonos = $this->movimientos()->where('tipo', 'abono')->sum('monto');
        return $fiados - $abonos;
    }
    // Relación: un cliente pertenece a una tienda
    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }
}
