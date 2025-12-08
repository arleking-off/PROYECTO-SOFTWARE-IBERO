<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: Tiendas donde el usuario es propietario principal
     */
    public function tiendasPropias()
    {
        return $this->hasMany(Tienda::class);
    }

    /**
     * Relación: Todas las tiendas a las que el usuario tiene acceso
     * (incluyendo aquellas donde es propietario, administrador o auxiliar)
     */
    public function tiendas()
    {
        return $this->belongsToMany(Tienda::class, 'tienda_user')
            ->withPivot('rol')
            ->withTimestamps();
    }

    /**
     * Metodo Helper: Obtener la tienda actualmente seleccionada
     */
    public function tiendaActual()
    {
        $tiendaId = session('tienda_id');

        if ($tiendaId) {
            return $this->tiendas()->find($tiendaId);
        }

        return null;
    }

    /**
     * Metodo Helper: Verificar si el usuario tiene acceso a una tienda específica
     */
    public function tieneAccesoA($tiendaId)
    {
        return $this->tiendas()->where('tiendas.id', $tiendaId)->exists();
    }

    /**
     * Metodo Helper: Obtener el rol del usuario en una tienda específica
     */
    public function rolEnTienda($tiendaId)
    {
        $tienda = $this->tiendas()->where('tiendas.id', $tiendaId)->first();

        return $tienda ? $tienda->pivot->rol : null;
    }

    /**
     * Metodo Helper: Verificar si es propietario de una tienda
     */
    public function esPropietarioDe($tiendaId)
    {
        return $this->rolEnTienda($tiendaId) === 'propietario';
    }

    /**
     * Metodo Helper: Verificar si es administrador o propietario de una tienda
     */
    public function esAdministradorDe($tiendaId)
    {
        $rol = $this->rolEnTienda($tiendaId);
        return in_array($rol, ['propietario', 'administrador']);
    }
}
