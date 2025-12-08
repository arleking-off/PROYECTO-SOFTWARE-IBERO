@extends('layouts.app')

@section('title', 'Nuevo Movimiento')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-square"></i> Registrar Movimiento</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('movimientos.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">-- Seleccione un cliente --</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ (old('cliente_id') == $cliente->id || (isset($clienteSeleccionado) && $clienteSeleccionado == $cliente->id)) ? 'selected' : '' }}>
                                        {{ $cliente->nombre }}
                                        @if($cliente->saldo() > 0)
                                            - Debe: ${{ number_format($cliente->saldo(), 0) }}
                                        @else
                                            - Al día ✓
                                        @endif
                                    </option>
                                @endforeach
                            </select>

                            @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Movimiento <span class="text-danger">*</span></label>
                            <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">-- Seleccione --</option>
                                <option value="fiado" {{ old('tipo') == 'fiado' ? 'selected' : '' }}>
                                    📤 Compra Fiada (aumenta la deuda)
                                </option>
                                <option value="abono" {{ old('tipo') == 'abono' ? 'selected' : '' }}>
                                    📥 Abono/Pago (disminuye la deuda)
                                </option>
                            </select>
                            @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Monto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="monto" class="form-control @error('monto') is-invalid @enderror"
                                       step="0.01" value="{{ old('monto') }}" required>
                            </div>
                            @error('monto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                   value="{{ old('fecha', date('Y-m-d')) }}" required>
                            @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción (opcional)</label>
                            <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion') }}</textarea>
                            <small class="text-muted">Ej: Pan, leche y huevos</small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Guardar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
