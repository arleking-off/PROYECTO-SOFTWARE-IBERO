@extends('layouts.app')

@section('title', 'Reporte de Morosidad')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-exclamation-triangle"></i> Reporte de Morosidad</h1>
        <a href="{{ route('reportes.cartera') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Ver Cartera Completa
        </a>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-danger bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">CLIENTES MOROSOS</h6>
                    <h2 class="mb-0">{{ $totalMorosos }}</h2>
                    <small><i class="bi bi-people"></i> Con más de 30 días sin pagar</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-warning bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">DEUDA MOROSA</h6>
                    <h2 class="mb-0">${{ number_format($totalDeudaMorosa, 0) }}</h2>
                    <small><i class="bi bi-wallet2"></i> Total en mora</small>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-warning">
        <i class="bi bi-info-circle"></i>
        <strong>Nota:</strong> Este reporte muestra clientes con saldo pendiente y que no han realizado ningún movimiento en los últimos 30 días.
    </div>

    <!-- Tabla de Clientes Morosos -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Clientes con Morosidad</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Saldo</th>
                        <th>Último Movimiento</th>
                        <th>Días en Mora</th>
                        <th width="200">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clientes as $index => $cliente)
                        <tr class="table-{{ $cliente->dias_mora > 60 ? 'danger' : 'warning' }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $cliente->nombre }}</strong>
                                @if($cliente->alias)
                                    <br><small class="text-muted">{{ $cliente->alias }}</small>
                                @endif
                            </td>
                            <td>
                                @if($cliente->contacto)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cliente->contacto) }}?text=Hola {{ $cliente->nombre }}, te recordamos que tienes un saldo pendiente de ${{ number_format($cliente->saldo_actual, 0) }}. Tu último pago fue hace {{ $cliente->dias_mora }} días."
                                       target="_blank"
                                       class="btn btn-sm btn-success">
                                        <i class="bi bi-whatsapp"></i> Contactar
                                    </a>
                                @else
                                    <span class="text-muted">Sin contacto</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-danger fs-6">
                                    ${{ number_format($cliente->saldo_actual, 0) }}
                                </span>
                            </td>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($cliente->ultimo_movimiento)->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $cliente->dias_mora > 60 ? 'danger' : 'warning' }} fs-6">
                                    {{ $cliente->dias_mora }} días
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('clientes.historial', $cliente->id) }}"
                                       class="btn btn-sm btn-info"
                                       title="Ver historial">
                                        <i class="bi bi-clock-history"></i>
                                    </a>
                                    <a href="{{ route('movimientos.create', ['cliente' => $cliente->id]) }}"
                                       class="btn btn-sm btn-primary"
                                       title="Registrar abono">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-check-circle" style="font-size: 3rem; color: green;"></i>
                                <p class="mt-2 text-success"><strong>¡Excelente!</strong></p>
                                <p>No hay clientes en situación de morosidad</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($clientes->count() > 0)
            <div class="card-footer bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Total de morosos:</strong> {{ $totalMorosos }}
                    </div>
                    <div class="col-md-6 text-end">
                        <strong>Deuda Morosa:</strong>
                        <span class="text-danger fs-5">
                        ${{ number_format($totalDeudaMorosa, 0) }}
                    </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
