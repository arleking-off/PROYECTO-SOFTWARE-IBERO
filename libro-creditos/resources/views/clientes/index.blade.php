@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-people-fill"></i> Lista de Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Cliente
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
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
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td><strong>{{ $cliente->nombre }}</strong></td>
                            <td>{{ $cliente->alias ?? '-' }}</td>
                            <td>{{ $cliente->contacto ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $cliente->saldo() > 0 ? 'danger' : 'success' }}">
                                    ${{ number_format($cliente->saldo(), 0) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($cliente->estado) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2">No hay clientes registrados</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
