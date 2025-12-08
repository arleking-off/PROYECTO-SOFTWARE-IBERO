@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <!-- Header -->
                    <div class="login-header">
                        <i class="bi bi-book-fill"></i>
                        <h2>Libro de Créditos</h2>
                        <p class="mt-2">Sistema de Gestión para Tiendas</p>
                    </div>

                    <!-- Body -->
                    <div class="login-body">
                        <h4 class="text-center mb-4 text-dark">Iniciar Sesión</h4>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
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

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
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

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="••••••••"
                                           required>
                                </div>
                                @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">
                                    Recordarme
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                </button>
                            </div>

                            <!-- Forgot Password -->
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                                        <i class="bi bi-question-circle"></i> ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="text-center py-3 bg-light">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Acceso seguro y protegido
                        </small>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="text-center mt-4">
                    <small class="copyright-text">
                        &copy; {{ date('Y') }} Libro de Créditos. Todos los derechos reservados.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
