@extends('layouts.app')

@section('title', 'Editar Tienda')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Tienda</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tiendas.update', $tienda) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Tienda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre" value="{{ old('nombre', $tienda->nombre) }}" required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                   value="{{ old('direccion', $tienda->direccion) }}">
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                   value="{{ old('telefono', $tienda->telefono) }}">
                        </div>

                        <div class="mb-3">
                            <label for="nit" class="form-label">NIT / Identificación Tributaria</label>
                            <input type="text" class="form-control" id="nit" name="nit"
                                   value="{{ old('nit', $tienda->nit) }}">
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('tiendas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
