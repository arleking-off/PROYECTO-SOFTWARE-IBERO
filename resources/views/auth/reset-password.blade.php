@extends('layouts.guest')

@section('title', 'Restablecer Contraseña')

@section('content')
<div class="auth-container">
    <!-- Header -->
    <div class="auth-icon">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    
    <h1 class="auth-title">Nueva Contraseña</h1>
    <p class="auth-subtitle">Ingresa tu nueva contraseña</p>

    <!-- Formulario -->
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       placeholder="tu@email.com"
                       value="{{ old('email', $request->email) }}" 
                       required 
                       autofocus>
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="••••••••"
                       required>
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="••••••••"
                       required>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-2"></i>Restablecer Contraseña
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        <p style="font-size: 12px;">© 2025 Libro de Créditos</p>
    </div>
</div>
@endsection
