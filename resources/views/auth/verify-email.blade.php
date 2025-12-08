@extends('layouts.guest')

@section('title', 'Verificar Email')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <!-- Header -->
                    <div class="login-header">
                        <i class="bi bi-envelope-check-fill"></i>
                        <h2>Verifica tu Email</h2>
                        <p class="mt-2">Revisa tu bandeja de entrada</p>
                    </div>

                    <!-- Body -->
                    <div class="login-body">
                        <div class="mb-4 text-muted">
                            <p>Gracias por registrarte. Antes de continuar, verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar.</p>
                            <p>Si no recibiste el correo, con gusto te enviaremos otro.</p>
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> ¡Un nuevo enlace de verificación ha sido enviado!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="bi bi-envelope-paper"></i> Reenviar Email
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted text-decoration-none">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
