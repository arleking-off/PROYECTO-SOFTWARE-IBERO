@extends('layouts.app')

@section('title', 'Seleccionar Tienda')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-shop"></i> Selecciona una Tienda</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Tienes acceso a múltiples tiendas. Selecciona con cuál deseas trabajar:
                    </p>

                    <div class="row">
                        @forelse($tiendas as $tienda)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-shop-window"></i> {{ $tienda->nombre }}
                                        </h5>

                                        @if($tienda->direccion)
                                            <p class="card-text text-muted mb-2">
                                                <i class="bi bi-geo-alt"></i> {{ $tienda->direccion }}
                                            </p>
                                        @endif

                                        @if($tienda->telefono)
                                            <p class="card-text text-muted mb-2">
                                                <i class="bi bi-telephone"></i> {{ $tienda->telefono }}
                                            </p>
                                        @endif

                                        <div class="mt-3">
                                        <span class="badge bg-{{ $tienda->pivot->rol == 'propietario' ? 'success' : ($tienda->pivot->rol == 'administrador' ? 'primary' : 'secondary') }}">
                                            {{ ucfirst($tienda->pivot->rol) }}
                                        </span>
                                        </div>

                                        <form action="{{ route('tiendas.establecer', $tienda->id) }}" method="POST" class="mt-3">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-box-arrow-in-right"></i> Acceder
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> No tienes acceso a ninguna tienda.
                                    <a href="{{ route('tiendas.create') }}" class="alert-link">Crear una nueva tienda</a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <hr>

                    <div class="text-center">
                        <a href="{{ route('tiendas.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Crear Nueva Tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
