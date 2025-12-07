@extends('layouts.app')

@section('title', 'Reporte de Cartera')

@section('content')

    <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reporte de Morosidad</h1>
        <a href="{{ route('reportes.cartera') }}" class="btn btn-secondary">Volver</a>
    </div>

    <div class="alert alert-warning">
        <strong>⚠️ Clientes con más de 30 días sin movimiento:</strong> {{ $clientes->count() }}
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Saldo</th>
            <th>Días en Mora</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        @forelse($clientes as $cliente)
            <tr class="table-{{ $cliente['dias_mora'] > 60 ? 'danger' : 'warning' }}">
                <td>{{ $cliente['nombre'] }}</td>
                <td>{{ $cliente['contacto'] ?? '-' }}</td>
                <td class="fw-bold">${{ number_format($cliente['saldo'], 0) }}</td>
                <td>{{ $cliente['dias_mora'] }} días</td>
                <td>
                    @if($cliente['contacto'])
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cliente['contacto']) }}"
                           class="btn btn-sm btn-success" target="_blank">
                            📱 WhatsApp
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-success">
                    ✅ ¡Excelente! No hay clientes morosos
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

