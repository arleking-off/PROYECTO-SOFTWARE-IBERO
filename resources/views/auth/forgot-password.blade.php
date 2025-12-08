@extends('layouts.guest')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="auth-container">
    <!-- Header -->
    <div class="auth-icon">
        <i class="bi bi-key-fill"></i>
    </div>
    
    <h1 class="auth-title">Recuperar Contraseña</h1>
    <p class="auth-subtitle">Te enviaremos un enlace de recuperación</p>
    
    <!-- Mensaje de éxito -->
    @if (session('status'))
        <div class="alert alert-success" role="alert" style="border-radius: 10px; margin-bottom: 25px;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
        </div>
    @endif

    <p style="color: #4a5568; font-size: 14px; margin-bottom: 25px; line-height: 1.6;">
        ¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu correo electrónico y te enviaremos un enlace para crear una nueva.
    </p>

    <!-- Formulario -->
    <form method="POST" action="{{ route('password.email') }}">
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

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-envelope-paper me-2"></i>Enviar Enlace de Recuperación
        </button>

        <!-- Back to Login Link -->
        <div class="auth-link">
            <a href="{{ route('login') }}">
                <i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesión
            </a>
        </div>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        <p style="font-size: 12px;">© 2025 Libro de Créditos</p>
    </div>
</div>
@endsection
