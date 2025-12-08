@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h1>

    <!-- Tarjetas de Estadísticas -->
    <div class="row g-3 mb-4">
        <!-- Total Clientes -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 bg-primary bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">CLIENTES ACTIVOS</h6>
                    <h2 class="mb-0">{{ $totalClientes }}</h2>
                    <small><i class="bi bi-people"></i> Total</small>
                </div>
            </div>
        </div>

        <!-- Cartera Total -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 bg-danger bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">CARTERA TOTAL</h6>
                    <h2 class="mb-0">${{ number_format($totalCartera, 0) }}</h2>
                    <small><i class="bi bi-wallet2"></i> Por cobrar</small>
                </div>
            </div>
        </div>

        <!-- Fiado este mes -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 bg-warning bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">FIADO ESTE MES</h6>
                    <h2 class="mb-0">${{ number_format($totalFiadoMes, 0) }}</h2>
                    <small><i class="bi bi-arrow-up-circle"></i> {{ date('F') }}</small>
                </div>
            </div>
        </div>

        <!-- Abonado este mes -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 bg-success bg-gradient text-white">
                <div class="card-body">
                    <h6 class="card-title text-white-50 mb-2">ABONADO ESTE MES</h6>
                    <h2 class="mb-0">${{ number_format($totalAbonadoMes, 0) }}</h2>
                    <small><i class="bi bi-arrow-down-circle"></i> {{ date('F') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top 5 Deudores -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-trophy"></i> Top 5 Deudores</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Vista Desktop -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Saldo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($topDeudores as $index => $cliente)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $cliente->nombre }}</strong>
                                        @if($cliente->alias)
                                            <br><small class="text-muted">{{ $cliente->alias }}</small>
                                        @endif
                                    </td>
                                    <td>
                                            <span class="badge bg-danger fs-6">
                                                ${{ number_format($cliente->saldo_actual, 0) }}
                                            </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">
                                        No hay clientes con deuda
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Vista Móvil -->
                    <div class="d-md-none p-3">
                        @forelse($topDeudores as $index => $cliente)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <div class="badge bg-primary me-2">{{ $index + 1 }}</div>
                                    <strong>{{ $cliente->nombre }}</strong>
                                    @if($cliente->alias)
                                        <br><small class="text-muted ms-4">{{ $cliente->alias }}</small>
                                    @endif
                                </div>
                                <span class="badge bg-danger fs-6">
                                    ${{ number_format($cliente->saldo_actual, 0) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-muted">No hay clientes con deuda</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimos Movimientos -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Últimos Movimientos</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Vista Desktop -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ultimosMovimientos as $mov)
                                <tr>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $mov->cliente->nombre }}</strong>
                                    </td>
                                    <td>
                                            <span class="badge bg-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }}">
                                                {{ ucfirst($mov->tipo) }}
                                            </span>
                                    </td>
                                    <td>
                                        <strong class="text-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }}">
                                            ${{ number_format($mov->monto, 0) }}
                                        </strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        No hay movimientos registrados
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Vista Móvil -->
                    <div class="d-md-none p-3">
                        @forelse($ultimosMovimientos as $mov)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>{{ $mov->cliente->nombre }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar"></i>
                                            {{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }}">
                                        {{ ucfirst($mov->tipo) }}
                                    </span>
                                </div>
                                <div class="text-end">
                                    <strong class="text-{{ $mov->tipo == 'fiado' ? 'danger' : 'success' }} fs-5">
                                        ${{ number_format($mov->monto, 0) }}
                                    </strong>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No hay movimientos registrados</p>
                        @endforelse
                    </div>
                </div>
                @if($ultimosMovimientos->count() > 0)
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('movimientos.index') }}" class="text-decoration-none">
                            Ver todos los movimientos <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center g-3">
                        <div class="col-6 col-md-3">
                            <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-person-plus d-block fs-1 mb-2"></i>
                                <span class="d-none d-md-inline">Nuevo Cliente</span>
                                <span class="d-md-none small">Cliente</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('movimientos.create') }}" class="btn btn-outline-success btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-plus-circle d-block fs-1 mb-2"></i>
                                <span class="d-none d-md-inline">Nuevo Movimiento</span>
                                <span class="d-md-none small">Movimiento</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('reportes.cartera') }}" class="btn btn-outline-warning btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-wallet2 d-block fs-1 mb-2"></i>
                                <span class="d-none d-md-inline">Ver Cartera</span>
                                <span class="d-md-none small">Cartera</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('reportes.morosidad') }}" class="btn btn-outline-danger btn-lg w-100 h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-exclamation-triangle d-block fs-1 mb-2"></i>
                                <span class="d-none d-md-inline">Ver Morosidad</span>
                                <span class="d-md-none small">Morosidad</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
