@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Cliente</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alias" class="form-label">Alias / Apodo</label>
                            <input type="text" class="form-control" id="alias" name="alias"
                                   value="{{ old('alias', $cliente->alias) }}">
                            <small class="text-muted">Ej: Don Pedro, La Señora del 2do piso</small>
                        </div>

                        <div class="mb-3">
                            <label for="contacto" class="form-label">Teléfono / WhatsApp</label>
                            <input type="text" class="form-control" id="contacto" name="contacto"
                                   value="{{ old('contacto', $cliente->contacto) }}">
                            <small class="text-muted">Ej: 3001234567</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Estado actual:</strong>
                            <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'secondary' }}">
                                {{ ucfirst($cliente->estado) }}
                            </span>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Actualizar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
