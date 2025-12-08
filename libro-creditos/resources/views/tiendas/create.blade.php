@extends('layouts.app')

@section('title', 'Crear Tienda')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Tienda</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tiendas.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Tienda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                   value="{{ old('direccion') }}">
                            <small class="text-muted">Ej: Calle 123 #45-67, Barrio Centro</small>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                   value="{{ old('telefono') }}">
                            <small class="text-muted">Ej: 3001234567</small>
                        </div>

                        <div class="mb-3">
                            <label for="nit" class="form-label">NIT / Identificación Tributaria</label>
                            <input type="text" class="form-control" id="nit" name="nit"
                                   value="{{ old('nit') }}">
                            <small class="text-muted">Opcional</small>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Crear Tienda
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
