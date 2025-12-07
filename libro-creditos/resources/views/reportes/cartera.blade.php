@extends('layouts.app')

@section('title', 'Reporte de Cartera')

@section('content')

    <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reporte de Cartera</h1>
        <div>
            <a href="{{ route('reportes.exportar') }}" class="btn btn-success">
                📥 Exportar a CSV
            </a>
            <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="alert alert-info">
        <strong>Total de Clientes con Deuda:</strong> {{ $clientes->count() }}
        <br>
        <strong>Cartera Total:</strong> ${{ number_format($clientes->sum('saldo'), 0) }}
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Alias</th>
            <th>Contacto</th>
            <th>Saldo</th>
            <th>Último Movimiento</th>
        </tr>
        </thead>
        <tbody>
        @forelse($clientes as $cliente)
            <tr>
                <td>{{ $cliente['id'] }}</td>
                <td>{{ $cliente['nombre'] }}</td>
                <td>{{ $cliente['alias'] ?? '-' }}</td>
                <td>{{ $cliente['contacto'] ?? '-' }}</td>
                <td class="text-danger fw-bold">
                    ${{ number_format($cliente['saldo'], 0) }}
                </td>
                <td>{{ $cliente['ultimo_movimiento'] ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No hay clientes con deuda pendiente
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
