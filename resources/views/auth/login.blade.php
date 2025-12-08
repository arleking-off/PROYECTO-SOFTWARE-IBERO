@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="auth-container">
    <!-- Header -->
    <div class="auth-icon">
        <i class="bi bi-book-fill"></i>
    </div>
    
    <h1 class="auth-title">Libro de Créditos</h1>
    <p class="auth-subtitle">Sistema de Gestión para Tiendas</p>
    
    <h3 class="section-title">Iniciar Sesión</h3>

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                       required 
                       autofocus>
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

        <!-- Remember Me -->
        <div class="form-check">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="remember" 
                   id="remember">
            <label class="form-check-label" for="remember">
                Recordarme
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
        </button>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="auth-link">
                <a href="{{ route('password.request') }}">
                    <i class="bi bi-question-circle me-1"></i>¿Olvidaste tu contraseña?
                </a>
            </div>
        @endif
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        <p><i class="bi bi-shield-check me-1"></i>Acceso seguro y protegido</p>
        <p style="font-size: 12px;">© 2025 Libro de Créditos. Todos los derechos reservados.</p>
    </div>
</div>
@endsection
