@extends('layouts.guest')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <!-- Header -->
                    <div class="login-header">
                        <i class="bi bi-key-fill"></i>
                        <h2>Recuperar Contraseña</h2>
                        <p class="mt-2">Te enviaremos un enlace de recuperación</p>
                    </div>

                    <!-- Body -->
                    <div class="login-body">
                        <div class="mb-4 text-muted">
                            <p>¿Olvidaste tu contraseña? No hay problema. Solo ingresa tu correo electrónico y te enviaremos un enlace para crear una nueva.</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>¡Ups!</strong> Hay algunos problemas:
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="tu@email.com"
                                           required
                                           autofocus>
                                </div>
                                @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="bi bi-envelope-paper"></i> Enviar Enlace de Recuperación
                                </button>
                            </div>

                            <!-- Back to Login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    <i class="bi bi-arrow-left"></i> Volver al inicio de sesión
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="text-center mt-4">
                    <small class="copyright-text">
                        &copy; {{ date('Y') }} Libro de Créditos
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
