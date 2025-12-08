@extends('layouts.guest')

@section('title', 'Registrarse')

@section('content')
<div class="auth-container">
    <!-- Header -->
    <div class="auth-icon">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    
    <h1 class="auth-title">Crear Cuenta</h1>
    <p class="auth-subtitle">Sistema de Gestión para Tiendas</p>
    
    <h3 class="section-title">Registrarse</h3>

    <!-- Formulario -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       placeholder="Juan Pérez"
                       value="{{ old('name') }}" 
                       required 
                       autofocus>
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

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
                       value="{{ old('email') }}" 
                       required>
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
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
            <i class="bi bi-person-check me-2"></i>Registrarse
        </button>

        <!-- Login Link -->
        <div class="auth-link">
            <a href="{{ route('login') }}">
                ¿Ya tienes una cuenta? <strong>Iniciar Sesión</strong>
            </a>
        </div>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        <p><i class="bi bi-shield-check me-1"></i>Acceso seguro y protegido</p>
        <p style="font-size: 12px;">© 2025 Libro de Créditos. Todos los derechos reservados.</p>
    </div>
</div>
@endsection
