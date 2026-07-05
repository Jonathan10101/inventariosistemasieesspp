@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <style>
        :root {
            --intevi-primary: #171C63;
            --intevi-primary-dark: #080D2B;
            --intevi-accent: #16D6B2;
            --intevi-text: #111827;
            --intevi-muted: #6B7280;
            --intevi-border: #E5E7EB;
            --intevi-light: #F8FAFC;
            --intevi-danger: #DC3545;
            --intevi-danger-bg: #FFF1F2;
            --intevi-danger-border: #FDA4AF;
        }

        body.login-page,
        body.register-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at 15% 18%, rgba(22, 214, 178, .22), transparent 27%),
                radial-gradient(circle at 85% 18%, rgba(99, 102, 241, .24), transparent 28%),
                radial-gradient(circle at 50% 100%, rgba(22, 214, 178, .13), transparent 35%),
                linear-gradient(135deg, #050816 0%, #11194D 48%, #060A20 100%) !important;
            position: relative;
            overflow: hidden;
        }

        body.login-page::before,
        body.register-page::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size: 42px 42px;
            pointer-events: none;
        }

        body.login-page::after,
        body.register-page::after {
            content: "";
            position: fixed;
            width: 420px;
            height: 420px;
            right: -170px;
            bottom: -180px;
            background: rgba(22, 214, 178, .17);
            filter: blur(75px);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-box {
            width: 380px;
            max-width: 92%;
            position: relative;
            z-index: 2;
        }

        .login-logo,
        .login-box-msg {
            display: none !important;
        }

        .card {
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 12px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 28px 70px rgba(0, 0, 0, .42);
            backdrop-filter: blur(18px);
            overflow: hidden;
        }

        .card::before {
            content: "";
            display: block;
            height: 4px;
            background: linear-gradient(90deg, var(--intevi-accent), #6574FF, var(--intevi-primary));
        }

        .login-card-body {
            padding: 0 26px 22px;
            background: transparent;
        }

        .login-title-bar {
            margin: 0 -26px 22px;
            padding: 15px 20px 13px;
            background: #FFFFFF;
            border-bottom: 1px solid #EEF1F6;
            color: var(--intevi-primary);
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 2.8px;
            text-align: center;
            text-transform: uppercase;
        }

        .login-top {
            text-align: center;
            margin-bottom: 18px;
        }

        .intevi-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .intevi-mark {
            width: 42px;
            height: 42px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--intevi-primary), var(--intevi-primary-dark));
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 15px;
            box-shadow: 0 12px 24px rgba(23, 28, 99, .28);
        }

        .intevi-brand h1 {
            margin: 0;
            color: var(--intevi-primary);
            font-size: 28px;
            font-weight: 900;
            letter-spacing: .8px;
            line-height: 1;
        }

        .login-subtitle {
            margin: 0;
            color: var(--intevi-muted);
            font-size: 13.5px;
            line-height: 1.35;
        }

        .tech-line {
            width: 76px;
            height: 3px;
            margin: 13px auto 0;
            border-radius: 99px;
            background: linear-gradient(90deg, transparent, var(--intevi-accent), transparent);
        }

        .login-error-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 0 0 15px;
            padding: 11px 12px;
            border: 1px solid var(--intevi-danger-border);
            border-left: 4px solid var(--intevi-danger);
            border-radius: 8px;
            background: var(--intevi-danger-bg);
            color: #991B1B;
            animation: errorFade .25s ease both;
        }

        .login-error-box i {
            margin-top: 2px;
            color: var(--intevi-danger);
            font-size: 15px;
        }

        .login-error-box strong {
            display: block;
            margin-bottom: 2px;
            font-size: 13.2px;
            font-weight: 800;
        }

        .login-error-box span {
            display: block;
            font-size: 12.7px;
            line-height: 1.35;
            font-weight: 500;
        }

        @keyframes errorFade {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 13px;
        }

        .input-group {
            border: 1px solid var(--intevi-border);
            border-radius: 8px;
            background: #FFFFFF;
            overflow: hidden;
            transition: all .2s ease;
        }

        .input-group:focus-within {
            border-color: rgba(23, 28, 99, .75);
            box-shadow:
                0 0 0 3px rgba(23, 28, 99, .10),
                0 10px 24px rgba(17, 24, 39, .06);
        }

        .input-group.has-error {
            border-color: var(--intevi-danger);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, .08);
        }

        .input-group.has-error .input-group-text,
        .input-group.has-error .btn-password-toggle {
            color: var(--intevi-danger);
        }

        .input-group-text {
            height: 44px;
            border: 0;
            background: #FFFFFF;
            color: #7A8192;
            min-width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-group .form-control {
            height: 44px;
            border: 0 !important;
            background: #FFFFFF;
            color: var(--intevi-text);
            font-size: 14.5px;
            box-shadow: none !important;
        }

        .input-group .form-control::placeholder {
            color: #9CA3AF;
        }

        .btn-password-toggle {
            width: 44px;
            height: 44px;
            border: 0;
            background: #FFFFFF;
            color: #7A8192;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            outline: none !important;
            box-shadow: none !important;
            transition: all .2s ease;
        }

        .btn-password-toggle:hover {
            color: var(--intevi-primary);
            background: #F5F7FB;
        }

        .invalid-feedback {
            display: block;
            margin-top: 6px;
            font-size: 12.5px;
            font-weight: 600;
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 2px 0 16px;
            font-size: 12.8px;
        }

        .login-options label {
            color: var(--intevi-muted);
            font-weight: 500;
        }

        .login-options a {
            color: var(--intevi-primary);
            font-weight: 800;
            text-decoration: none;
        }

        .login-options a:hover {
            text-decoration: underline;
        }

        .btn-intevi-login {
            height: 44px;
            border: 0;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--intevi-primary), var(--intevi-primary-dark));
            color: #FFFFFF;
            font-size: 14.5px;
            font-weight: 800;
            box-shadow: 0 14px 28px rgba(23, 28, 99, .28);
            transition: all .2s ease;
        }

        .btn-intevi-login:hover {
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(23, 28, 99, .35);
        }

        .btn-intevi-login:disabled {
            opacity: .92;
            cursor: not-allowed;
            transform: none !important;
        }

        .login-footer {
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #EEF1F6;
            color: var(--intevi-muted);
            text-align: center;
            font-size: 11.8px;
            line-height: 1.45;
        }

        .login-footer strong {
            color: var(--intevi-primary);
        }

        .alert {
            border: 0;
            border-radius: 8px;
            padding: 9px 11px;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .login-card-body {
                padding: 0 20px 20px;
            }

            .login-title-bar {
                margin: 0 -20px 20px;
            }

            .intevi-brand h1 {
                font-size: 25px;
            }

            .login-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 7px;
            }
        }
    </style>
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('auth_header')
@stop

@section('auth_body')
    <div class="login-title-bar">
        LOGIN
    </div>

    <div class="login-top">
        <div class="intevi-brand">
            <h1>INTEVI</h1>
        </div>

        <p class="login-subtitle">
            Acceso seguro al control inteligente de inventarios
        </p>

        <div class="tech-line"></div>
    </div>

    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="login-error-box" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>No se pudo iniciar sesión</strong>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="login-error-box" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Credenciales incorrectas</strong>
                <span>
                    {{ $errors->first('email') ?: $errors->first('password') ?: 'Verifica tu correo electrónico y contraseña.' }}
                </span>
            </div>
        </div>
    @endif

    <form action="{{ $login_url }}" method="post" autocomplete="off" id="loginForm" onsubmit="return mostrarCargandoLogin(event);">
        @csrf

        <div class="form-group">
            <div class="input-group @if($errors->any()) has-error @endif">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="Correo electrónico"
                    autocomplete="email"
                    autofocus
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <div class="input-group @if($errors->any()) has-error @endif">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Contraseña"
                    autocomplete="current-password"
                    required
                >

                <div class="input-group-append">
                    <button
                        type="button"
                        class="btn-password-toggle"
                        id="togglePassword"
                        aria-label="Mostrar contraseña"
                    >
                        <span class="fas fa-eye" id="togglePasswordIcon"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="login-options">
            <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Recordarme</label>
            </div>

            @if($password_reset_url)
                <a href="{{ $password_reset_url }}">
                    Recuperar acceso
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-intevi-login btn-block w-100 text-white" id="loginButton">
            <span id="loginText">
                <i class="fas fa-arrow-right mr-1"></i>
                Entrar al sistema
            </span>

            <span id="loginLoading" style="display: none;">
                <i class="fas fa-spinner fa-spin mr-1"></i>
                Validando acceso...
            </span>
        </button>
    </form>

    <div class="login-footer">
        <strong>INTEVI</strong> · Inventarios institucionales
        <br>
        Versión 1.1.0 alpha
    </div>

    <script>
        function mostrarCargandoLogin(event) {
            event.preventDefault();

            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loginLoading = document.getElementById('loginLoading');

            if (button && loginText && loginLoading) {
                button.disabled = true;
                loginText.style.display = 'none';
                loginLoading.style.display = 'inline-block';
            }

            setTimeout(function () {
                form.submit();
            }, 350);

            return false;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput && togglePassword && togglePasswordIcon) {
                togglePassword.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';

                    passwordInput.type = isPassword ? 'text' : 'password';

                    togglePasswordIcon.classList.toggle('fa-eye', !isPassword);
                    togglePasswordIcon.classList.toggle('fa-eye-slash', isPassword);

                    togglePassword.setAttribute(
                        'aria-label',
                        isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
                    );

                    passwordInput.focus();
                });
            }
        });
    </script>
@stop

@section('auth_footer')
@stop

@section('adminlte_js')
@stop