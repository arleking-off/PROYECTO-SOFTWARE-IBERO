@extends('layouts.app')

@section('title', 'Mis Tiendas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-shop-window"></i> Mis Tiendas</h1>
        <a href="{{ route('tiendas.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nueva Tienda
        </a>
    </div>

    @if(tienda_actual())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Tienda Activa:</strong> {{ tienda_actual()->nombre }}
            <a href="{{ route('tiendas.seleccionar') }}" class="alert-link ms-2">Cambiar</a>
        </div>
    @endif

    <div class="row">
        @forelse($tiendas as $tienda)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-{{ session('tienda_id') == $tienda->id ? 'primary' : 'light' }}
                            {{ session('tienda_id') == $tienda->id ? 'text-white' : '' }}">
                        <h5 class="mb-0">
                            {{ $tienda->nombre }}
                            @if(session('tienda_id') == $tienda->id)
                                <span class="badge bg-success float-end">Activa</span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <i class="bi bi-geo-alt text-muted"></i>
                            <strong>Dirección:</strong> {{ $tienda->direccion ?? 'No especificada' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone text-muted"></i>
                            <strong>Teléfono:</strong> {{ $tienda->telefono ?? 'No especificado' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-file-text text-muted"></i>
                            <strong>NIT:</strong> {{ $tienda->nit ?? 'No especificado' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-person-badge text-muted"></i>
                            <strong>Tu rol:</strong>
                            <span class="badge bg-{{ $tienda->pivot->rol == 'propietario' ? 'success' : 'primary' }}">
                            {{ ucfirst($tienda->pivot->rol) }}
                        </span>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-people text-muted"></i>
                            <strong>Clientes:</strong> {{ $tienda->clientes()->count() }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="btn-group w-100" role="group">
                            @if(session('tienda_id') != $tienda->id)
                                <form action="{{ route('tiendas.establecer', $tienda->id) }}" method="POST" class="flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                        <i class="bi bi-check2-circle"></i> Activar
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('tiendas.edit', $tienda) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> No tienes ninguna tienda creada.
                    <a href="{{ route('tiendas.create') }}" class="alert-link">Crear tu primera tienda</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
