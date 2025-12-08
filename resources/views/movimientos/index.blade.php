@extends('layouts.app')

@section('title', 'Movimientos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-arrow-left-right"></i> Historial de Movimientos</h1>
        <a href="{{ route('movimientos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Movimiento
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Descripción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($movimientos as $mov)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</td>
                            <td><strong>{{ $mov->cliente->nombre }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }}">
                                    <i class="bi bi-{{ $mov->tipo == 'fiado' ? 'arrow-up' : 'arrow-down' }}"></i>
                                    {{ ucfirst($mov->tipo) }}
                                </span>
                            </td>
                            <td class="fw-bold">${{ number_format($mov->monto, 0) }}</td>
                            <td>{{ $mov->descripcion ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2">No hay movimientos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
