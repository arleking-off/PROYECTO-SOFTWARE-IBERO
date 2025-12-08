@extends('layouts.app')

@section('title', 'Historial de ' . $cliente->nombre)

@section('content')
    <!-- Encabezado del Cliente -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-clock-history"></i> Historial de Movimientos</h1>
            <h4 class="text-muted">{{ $cliente->nombre }}
                @if($cliente->alias)
                    <small class="text-muted">({{ $cliente->alias }})</small>
                @endif
            </h4>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Tarjetas de Estadísticas del Cliente -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">TOTAL FIADO</h6>
                    <h3 class="mb-0">${{ number_format($totalFiado, 0) }}</h3>
                    <small>Acumulado</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">TOTAL ABONADO</h6>
                    <h3 class="mb-0">${{ number_format($totalAbonado, 0) }}</h3>
                    <small>Pagado</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-{{ $saldo > 0 ? 'warning' : 'info' }} bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">SALDO ACTUAL</h6>
                    <h3 class="mb-0">${{ number_format($saldo, 0) }}</h3>
                    <small>{{ $saldo > 0 ? 'Pendiente' : 'Al día' }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">MOVIMIENTOS</h6>
                    <h3 class="mb-0">{{ $cantidadMovimientos }}</h3>
                    <small>Transacciones</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Información del Cliente</h6>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong>Estado:</strong>
                                <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($cliente->estado) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="mb-2"><strong>Contacto:</strong>
                                @if($cliente->contacto)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cliente->contacto) }}"
                                       target="_blank" class="text-decoration-none">
                                        <i class="bi bi-whatsapp text-success"></i> {{ $cliente->contacto }}
                                    </a>
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($ultimoMovimiento)
                        <div class="alert alert-info mb-0 mt-2">
                            <small>
                                <i class="bi bi-info-circle"></i>
                                <strong>Último movimiento:</strong>
                                {{ \Carbon\Carbon::parse($ultimoMovimiento->fecha)->format('d/m/Y') }} -
                                {{ ucfirst($ultimoMovimiento->tipo) }} de ${{ number_format($ultimoMovimiento->monto, 0) }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-3">Acciones Rápidas</h6>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('movimientos.create', ['cliente' => $cliente->id]) }}"
                           class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nuevo Movimiento
                        </a>
                        <a href="{{ route('clientes.edit', $cliente) }}"
                           class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Editar Cliente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Detalle de Movimientos ({{ $cantidadMovimientos }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th width="80">#</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Descripción</th>
                        <th>Saldo Después</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $saldoAcumulado = 0;
                        $movimientosOrdenados = $movimientos->reverse();
                    @endphp

                    @forelse($movimientosOrdenados as $index => $mov)
                        @php
                            if($mov->tipo == 'fiado') {
                                $saldoAcumulado += $mov->monto;
                            } else {
                                $saldoAcumulado -= $mov->monto;
                            }
                        @endphp
                        <tr>
                            <td class="text-muted">#{{ $movimientosOrdenados->count() - $index }}</td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($mov->created_at)->diffForHumans() }}</small>
                            </td>
                            <td>
                                    <span class="badge bg-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }}">
                                        <i class="bi bi-{{ $mov->tipo == 'fiado' ? 'arrow-up' : 'arrow-down' }}"></i>
                                        {{ ucfirst($mov->tipo) }}
                                    </span>
                            </td>
                            <td>
                                <strong class="text-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }}">
                                    {{ $mov->tipo == 'fiado' ? '+' : '-' }}${{ number_format($mov->monto, 0) }}
                                </strong>
                            </td>
                            <td>{{ $mov->descripcion ?? '-' }}</td>
                            <td>
                                    <span class="badge bg-{{ $saldoAcumulado > 0 ? 'warning' : 'success' }} fs-6">
                                        ${{ number_format($saldoAcumulado, 0) }}
                                    </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Este cliente no tiene movimientos registrados</p>
                                <a href="{{ route('movimientos.create', ['cliente' => $cliente->id]) }}"
                                   class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Registrar Primer Movimiento
                                </a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
