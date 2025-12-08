<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'nit',
        'estado',
        'user_id'
    ];

    // Relación: una tienda pertenece a un propietario principal
    public function propietario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: una tienda tiene muchos usuarios con acceso
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'tienda_user')
            ->withPivot('rol')
            ->withTimestamps();
    }

    // Relación: una tienda tiene muchos clientes
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    // Relación: una tienda tiene muchos movimientos
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    // Metodo: cartera total de la tienda
    public function carteraTotal()
    {
        return $this->clientes()->get()->sum(function($cliente) {
            return $cliente->saldo();
        });
    }
}
