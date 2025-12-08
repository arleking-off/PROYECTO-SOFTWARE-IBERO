@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-people-fill"></i> Lista de Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Cliente
        </a>
    </div>

    <!-- Formulario de Búsqueda -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('clientes.index') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               name="buscar"
                               class="form-control"
                               placeholder="Buscar por nombre, alias o teléfono..."
                               value="{{ $buscar ?? '' }}"
                               autofocus>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>

            @if($buscar)
                <div class="mt-2">
                    <small class="text-muted">
                        Mostrando resultados para: <strong>"{{ $buscar }}"</strong>
                        <a href="{{ route('clientes.index') }}" class="ms-2 text-decoration-none">
                            <i class="bi bi-x-circle"></i> Limpiar búsqueda
                        </a>
                    </small>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabla de Clientes (Vista Desktop) -->
    <div class="card shadow-sm d-none d-md-block">
        <div class="card-body">
            @if($clientes->count() > 0)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Se encontraron <strong>{{ $clientes->count() }}</strong> cliente(s)
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Alias</th>
                        <th>Contacto</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th width="240">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clientes as $cliente)
                        <tr class="{{ $cliente->estado == 'inactivo' ? 'table-secondary' : '' }}">
                            <td>{{ $cliente->id }}</td>
                            <td><strong>{{ $cliente->nombre }}</strong></td>
                            <td>{{ $cliente->alias ?? '-' }}</td>
                            <td>
                                @if($cliente->contacto)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cliente->contacto) }}"
                                       target="_blank"
                                       class="text-decoration-none">
                                        <i class="bi bi-whatsapp text-success"></i> {{ $cliente->contacto }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                            <span class="badge bg-{{ $cliente->saldo() > 0 ? 'danger' : 'success' }} fs-6">
                                ${{ number_format($cliente->saldo(), 0) }}
                            </span>
                            </td>
                            <td>
                            <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($cliente->estado) }}
                            </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('clientes.historial', $cliente->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="Ver historial">
                                        <i class="bi bi-clock-history"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $cliente) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Editar cliente">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('movimientos.create', ['cliente' => $cliente->id]) }}"
                                       class="btn btn-sm btn-primary"
                                       title="Nuevo movimiento">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <form action="{{ route('clientes.cambiarEstado', $cliente->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Está seguro de {{ $cliente->estado == 'activo' ? 'inactivar' : 'activar' }} este cliente?');">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm btn-{{ $cliente->estado == 'activo' ? 'danger' : 'success' }}"
                                                title="{{ $cliente->estado == 'activo' ? 'Inactivar' : 'Activar' }} cliente">
                                            <i class="bi bi-{{ $cliente->estado == 'activo' ? 'x-circle' : 'check-circle' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">
                                    @if($buscar)
                                        No se encontraron clientes con "<strong>{{ $buscar }}</strong>"
                                    @else
                                        No hay clientes registrados
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Vista Móvil (Cards) -->
    <div class="d-md-none">
        @forelse($clientes as $cliente)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="mb-1">{{ $cliente->nombre }}</h5>
                            @if($cliente->alias)
                                <small class="text-muted">{{ $cliente->alias }}</small>
                            @endif
                        </div>
                        <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'secondary' }}">
                        {{ ucfirst($cliente->estado) }}
                    </span>
                    </div>

                    <div class="mb-2">
                        <strong>Saldo:</strong>
                        <span class="badge bg-{{ $cliente->saldo() > 0 ? 'danger' : 'success' }} fs-6">
                        ${{ number_format($cliente->saldo(), 0) }}
                    </span>
                    </div>

                    @if($cliente->contacto)
                        <div class="mb-3">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cliente->contacto) }}"
                               target="_blank"
                               class="btn btn-success btn-sm w-100">
                                <i class="bi bi-whatsapp"></i> {{ $cliente->contacto }}
                            </a>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <a href="{{ route('clientes.historial', $cliente->id) }}"
                           class="btn btn-info btn-sm">
                            <i class="bi bi-clock-history"></i> Ver Historial
                        </a>
                        <div class="btn-group">
                            <a href="{{ route('clientes.edit', $cliente) }}"
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a href="{{ route('movimientos.create', ['cliente' => $cliente->id]) }}"
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Movimiento
                            </a>
                            <form action="{{ route('clientes.cambiarEstado', $cliente->id) }}"
                                  method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('¿Está seguro?');">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm btn-{{ $cliente->estado == 'activo' ? 'danger' : 'success' }}">
                                    <i class="bi bi-{{ $cliente->estado == 'activo' ? 'x-circle' : 'check-circle' }}"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">
                <i class="bi bi-inbox"></i>
                @if($buscar)
                    No se encontraron clientes con "<strong>{{ $buscar }}</strong>"
                @else
                    No hay clientes registrados
                @endif
            </div>
        @endforelse
    </div>


@endsection
