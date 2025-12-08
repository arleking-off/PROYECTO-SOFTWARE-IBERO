@extends('layouts.app')

@section('title', 'Reporte de Cartera')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-wallet2"></i> Reporte de Cartera</h1>
        <a href="{{ route('reportes.exportar') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Exportar a CSV
        </a>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-warning bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">CARTERA TOTAL</h6>
                    <h2 class="mb-0">${{ number_format($totalCartera, 0) }}</h2>
                    <small><i class="bi bi-wallet2"></i> Total por cobrar</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-info bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">CLIENTES CON DEUDA</h6>
                    <h2 class="mb-0">{{ $cantidadClientes }}</h2>
                    <small><i class="bi bi-people"></i> Total</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Clientes -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Detalle de Cartera por Cliente</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th width="150">Saldo</th>
                        <th width="200">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clientes as $index => $cliente)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $cliente->nombre }}</strong>
                                @if($cliente->alias)
                                    <br><small class="text-muted">{{ $cliente->alias }}</small>
                                @endif
                            </td>
                            <td>
                                @if($cliente->contacto)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cliente->contacto) }}?text=Hola {{ $cliente->nombre }}, tienes un saldo pendiente de ${{ number_format($cliente->saldo_actual, 0) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-success">
                                        <i class="bi bi-whatsapp"></i> {{ $cliente->contacto }}
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
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">No hay clientes con saldo pendiente</p>
                                <p class="text-success">¡Excelente! Todos los clientes están al día</p>
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
                        <strong>Total de clientes:</strong> {{ $cantidadClientes }}
                    </div>
                    <div class="col-md-6 text-end">
                        <strong>Cartera Total:</strong>
                        <span class="text-danger fs-5">
                        ${{ number_format($totalCartera, 0) }}
                    </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
