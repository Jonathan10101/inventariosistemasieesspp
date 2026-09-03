@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link
        rel="stylesheet"
        href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}"
    >

    <style>
        :root {
            --intevi-primary: #171c63;
            --intevi-primary-dark: #0c103e;
            --intevi-primary-soft: rgba(23, 28, 99, 0.08);
            --intevi-accent: #16b89b;
            --intevi-text: #111827;
            --intevi-muted: #64748b;
            --intevi-border: #d8dee9;
            --intevi-surface: #ffffff;
            --intevi-surface-soft: #f8fafc;
            --intevi-danger: #dc2626;
            --intevi-danger-soft: #fff1f2;
            --intevi-success: #047857;
        }

        html {
            min-height: 100%;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | Contenedor principal
        |--------------------------------------------------------------------------
        |
        | AdminLTE utiliza Flexbox con dirección en columna.
        | Se centra horizontalmente con align-items y verticalmente
        | con justify-content.
        |
        */

        body.login-page,
        body.register-page {
            width: 100%;
            min-width: 100%;
            min-height: 100vh !important;
            min-height: 100dvh !important;
            height: auto !important;
            margin: 0;
            padding: 24px;

            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;

            position: relative;
            overflow-x: hidden;
            overflow-y: auto;

            background:
                radial-gradient(
                    circle at 12% 12%,
                    rgba(37, 99, 235, 0.20),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 15%,
                    rgba(22, 184, 155, 0.16),
                    transparent 26%
                ),
                linear-gradient(
                    135deg,
                    #080b24 0%,
                    #171c63 48%,
                    #090d2f 100%
                ) !important;
        }

        body.login-page::before,
        body.register-page::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;

            background-image:
                linear-gradient(
                    rgba(255, 255, 255, 0.035) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.035) 1px,
                    transparent 1px
                );

            background-size: 42px 42px;
            mask-image: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0.85),
                transparent 90%
            );
        }

        body.login-page::after,
        body.register-page::after {
            content: "";
            position: fixed;
            width: 440px;
            height: 440px;
            right: -180px;
            bottom: -190px;
            z-index: 0;
            border-radius: 50%;
            background: rgba(22, 184, 155, 0.13);
            filter: blur(70px);
            pointer-events: none;
        }

        /*
        |--------------------------------------------------------------------------
        | Caja del login
        |--------------------------------------------------------------------------
        */

        .login-box {
            width: 430px !important;
            max-width: 100% !important;
            margin: auto !important;
            flex: 0 0 auto;
            position: relative;
            z-index: 2;
        }

        .login-logo,
        .login-box-msg {
            display: none !important;
        }

        .login-box .card {
            width: 100%;
            margin: 0;
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.98);

            box-shadow:
                0 32px 80px rgba(2, 6, 23, 0.45),
                0 8px 24px rgba(2, 6, 23, 0.18);

            overflow: hidden;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .login-box .card::before {
            content: "";
            display: block;
            width: 100%;
            height: 5px;

            background: linear-gradient(
                90deg,
                var(--intevi-accent) 0%,
                #4070f4 45%,
                var(--intevi-primary) 100%
            );
        }

        .login-card-body {
            width: 100%;
            padding: 34px 34px 28px;
            border-radius: 0;
            background: transparent;
        }

        /*
        |--------------------------------------------------------------------------
        | Encabezado
        |--------------------------------------------------------------------------
        */

        .intevi-login-header {
            width: 100%;
            margin-bottom: 28px;
            text-align: center;
        }

        .intevi-login-header > a {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .intevi-logo-shell {
            width: 78px;
            height: 78px;
            margin: 0 auto 15px;
            padding: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid rgba(23, 28, 99, 0.10);
            border-radius: 22px;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f1f5f9
                );

            box-shadow:
                0 16px 35px rgba(23, 28, 99, 0.14),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .intevi-logo {
            width: 58px;
            height: 58px;
            display: block;
            object-fit: contain;
        }

        .intevi-login-title {
            margin: 0;
            color: var(--intevi-primary);
            font-size: 29px;
            font-weight: 900;
            letter-spacing: 0.09em;
            line-height: 1;
            text-align: center;
        }

        .intevi-login-product {
            margin: 8px 0 0;
            color: var(--intevi-text);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .intevi-login-description {
            max-width: 310px;
            margin: 7px auto 0;
            color: var(--intevi-muted);
            font-size: 13px;
            line-height: 1.55;
        }

        /*
        |--------------------------------------------------------------------------
        | Alertas
        |--------------------------------------------------------------------------
        */

        .intevi-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;

            margin-bottom: 18px;
            padding: 13px 14px;

            border: 1px solid #fecdd3;
            border-left: 4px solid var(--intevi-danger);
            border-radius: 12px;

            background: var(--intevi-danger-soft);
            color: #991b1b;

            animation: inteviAlertIn 0.24s ease both;
        }

        .intevi-alert.success {
            border-color: #a7f3d0;
            border-left-color: var(--intevi-success);
            background: #ecfdf5;
            color: #065f46;
        }

        .intevi-alert-icon {
            width: 28px;
            height: 28px;
            flex: 0 0 28px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;
            background: rgba(220, 38, 38, 0.10);
            color: var(--intevi-danger);
        }

        .intevi-alert.success .intevi-alert-icon {
            background: rgba(4, 120, 87, 0.10);
            color: var(--intevi-success);
        }

        .intevi-alert strong {
            display: block;
            margin-bottom: 2px;
            font-size: 13px;
            font-weight: 900;
        }

        .intevi-alert span {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            line-height: 1.45;
        }

        @keyframes inteviAlertIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Formulario
        |--------------------------------------------------------------------------
        */

        .intevi-form-group {
            width: 100%;
            margin-bottom: 18px;
        }

        .intevi-field-label {
            display: block;
            margin: 0 0 7px;
            color: #334155;
            font-size: 12.5px;
            font-weight: 800;
        }

        .intevi-field {
            width: 100%;
            min-height: 54px;

            display: flex;
            align-items: center;

            border: 1px solid var(--intevi-border);
            border-radius: 12px;
            background: var(--intevi-surface);
            overflow: hidden;

            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .intevi-field:hover {
            border-color: #b9c2d0;
        }

        .intevi-field:focus-within {
            border-color: var(--intevi-primary);
            background: #ffffff;

            box-shadow:
                0 0 0 4px rgba(23, 28, 99, 0.09),
                0 10px 24px rgba(15, 23, 42, 0.06);
        }

        .intevi-field.has-error {
            border-color: var(--intevi-danger);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.07);
        }

        .intevi-field-icon {
            width: 52px;
            min-width: 52px;
            align-self: stretch;

            display: flex;
            align-items: center;
            justify-content: center;

            border-right: 1px solid #edf1f6;
            background: var(--intevi-surface-soft);
            color: #667085;
            font-size: 15px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease;
        }

        .intevi-field:focus-within .intevi-field-icon {
            color: var(--intevi-primary);
            background: var(--intevi-primary-soft);
        }

        .intevi-field.has-error .intevi-field-icon {
            color: var(--intevi-danger);
            background: rgba(220, 38, 38, 0.06);
        }

        .intevi-field-input {
            min-width: 0;
            width: 100%;
            height: 52px;
            flex: 1;

            padding: 0 14px;

            border: 0 !important;
            outline: 0 !important;
            border-radius: 0 !important;

            background: transparent !important;
            color: var(--intevi-text);

            font-size: 14px;
            font-weight: 600;

            box-shadow: none !important;
        }

        .intevi-field-input::placeholder {
            color: #9aa4b2;
            font-weight: 500;
        }

        .intevi-password-toggle {
            width: 50px;
            min-width: 50px;
            height: 52px;
            padding: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 0;
            border-left: 1px solid #edf1f6;
            outline: 0 !important;

            background: transparent;
            color: #667085;
            cursor: pointer;

            box-shadow: none !important;

            transition:
                color 0.18s ease,
                background-color 0.18s ease;
        }

        .intevi-password-toggle:hover,
        .intevi-password-toggle:focus {
            background: var(--intevi-primary-soft);
            color: var(--intevi-primary);
        }

        .intevi-field-help {
            display: block;
            margin: 7px 3px 0;
            color: var(--intevi-muted);
            font-size: 11.8px;
            line-height: 1.4;
        }

        .intevi-field-error {
            display: block;
            margin: 7px 3px 0;
            color: var(--intevi-danger);
            font-size: 11.8px;
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | Opciones de sesión
        |--------------------------------------------------------------------------
        */

        .intevi-login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 2px 0 20px;
        }

        .intevi-remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin: 0;

            color: var(--intevi-muted);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
        }

        .intevi-remember input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: var(--intevi-primary);
        }

        .intevi-recovery-link {
            color: var(--intevi-primary);
            font-size: 12.5px;
            font-weight: 800;
            text-decoration: none;
        }

        .intevi-recovery-link:hover {
            color: var(--intevi-primary-dark);
            text-decoration: underline;
        }

        /*
        |--------------------------------------------------------------------------
        | Botón
        |--------------------------------------------------------------------------
        */

        .intevi-login-button {
            width: 100%;
            min-height: 50px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;

            padding: 0 18px;

            border: 0;
            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--intevi-primary) 0%,
                    #222d86 55%,
                    var(--intevi-primary-dark) 100%
                );

            color: #ffffff;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 0.01em;

            box-shadow:
                0 15px 30px rgba(23, 28, 99, 0.27);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .intevi-login-button:hover,
        .intevi-login-button:focus {
            color: #ffffff;
            transform: translateY(-1px);
            filter: brightness(1.04);

            box-shadow:
                0 19px 36px rgba(23, 28, 99, 0.34);
        }

        .intevi-login-button:disabled {
            cursor: wait;
            opacity: 0.90;
            transform: none;
            filter: none;
        }

        /*
        |--------------------------------------------------------------------------
        | Pie del formulario
        |--------------------------------------------------------------------------
        */

        .intevi-login-footer {
            margin-top: 24px;
            padding-top: 18px;

            border-top: 1px solid #e9edf3;

            color: var(--intevi-muted);
            text-align: center;
            font-size: 11.5px;
            line-height: 1.6;
        }

        .intevi-login-footer strong {
            color: var(--intevi-primary);
            font-weight: 900;
        }

        /*
        |--------------------------------------------------------------------------
        | Teléfonos móviles
        |--------------------------------------------------------------------------
        */

        @media (max-width: 575.98px) {
            body.login-page,
            body.register-page {
                width: 100% !important;
                min-height: 100vh !important;
                min-height: 100dvh !important;
                height: auto !important;

                padding-top: calc(16px + env(safe-area-inset-top));
                padding-right: calc(14px + env(safe-area-inset-right));
                padding-bottom: calc(16px + env(safe-area-inset-bottom));
                padding-left: calc(14px + env(safe-area-inset-left));

                align-items: center !important;
                justify-content: center !important;

                overflow-x: hidden;
                overflow-y: auto;
            }

            .login-box {
                width: 100% !important;
                max-width: 430px !important;
                margin: auto !important;
            }

            .login-box .card {
                width: 100%;
                margin: 0;
                border-radius: 17px;
            }

            .login-card-body {
                width: 100%;
                padding: 27px 20px 23px;
            }

            .intevi-login-header {
                margin-bottom: 24px;
            }

            .intevi-logo-shell {
                width: 70px;
                height: 70px;
                margin-bottom: 13px;
                border-radius: 19px;
            }

            .intevi-logo {
                width: 52px;
                height: 52px;
            }

            .intevi-login-title {
                font-size: 26px;
            }

            .intevi-field {
                min-height: 52px;
            }

            .intevi-field-icon {
                width: 48px;
                min-width: 48px;
            }

            .intevi-field-input {
                height: 50px;
                padding-right: 11px;
                padding-left: 11px;
                font-size: 13.5px;
            }

            .intevi-password-toggle {
                width: 46px;
                min-width: 46px;
                height: 50px;
            }

            .intevi-login-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Pantallas pequeñas con poca altura
        |--------------------------------------------------------------------------
        |
        | Cuando el contenido no cabe, se coloca naturalmente desde arriba
        | mediante los márgenes automáticos y se permite hacer scroll.
        |
        */

        @media (max-width: 575.98px) and (max-height: 680px) {
            body.login-page,
            body.register-page {
                justify-content: flex-start !important;
            }

            .login-box {
                margin-top: auto !important;
                margin-bottom: auto !important;
            }

            .login-card-body {
                padding-top: 23px;
                padding-bottom: 20px;
            }

            .intevi-login-header {
                margin-bottom: 20px;
            }

            .intevi-logo-shell {
                width: 64px;
                height: 64px;
                margin-bottom: 11px;
            }

            .intevi-logo {
                width: 47px;
                height: 47px;
            }

            .intevi-form-group {
                margin-bottom: 15px;
            }

            .intevi-login-footer {
                margin-top: 20px;
                padding-top: 15px;
            }
        }
    </style>
@stop

@php
    $login_url = View::getSection('login_url')
        ?? config('adminlte.login_url', 'login');

    $register_url = View::getSection('register_url')
        ?? config('adminlte.register_url', 'register');

    $password_reset_url = View::getSection('password_reset_url')
        ?? config('adminlte.password_reset_url', 'password/reset');
@endphp

@if (config('adminlte.use_route_url', false))
    @php
        $login_url = $login_url
            ? route($login_url)
            : '';

        $register_url = $register_url
            ? route($register_url)
            : '';

        $password_reset_url = $password_reset_url
            ? route($password_reset_url)
            : '';
    @endphp
@else
    @php
        $login_url = $login_url
            ? url($login_url)
            : '';

        $register_url = $register_url
            ? url($register_url)
            : '';

        $password_reset_url = $password_reset_url
            ? url($password_reset_url)
            : '';
    @endphp
@endif

@section('auth_header')
@stop

@section('auth_body')
    <div class="intevi-login-header">
        <a
            href="{{ url('/') }}"
            class="text-decoration-none"
            aria-label="Ir al inicio de INTEVI"
        >
            <div class="intevi-logo-shell">
                <img
                    src="{{ asset('images/intevi logo.png') }}"
                    alt="Logo de INTEVI"
                    class="intevi-logo"
                >
            </div>

            <h1 class="intevi-login-title">
                INTEVI
            </h1>
        </a>
    </div>

    @if (session('status'))
        <div
            class="intevi-alert success"
            role="status"
        >
            <span class="intevi-alert-icon">
                <i class="fas fa-check"></i>
            </span>

            <div>
                <strong>
                    Operación completada
                </strong>

                <span>
                    {{ session('status') }}
                </span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div
            class="intevi-alert"
            role="alert"
        >
            <span class="intevi-alert-icon">
                <i class="fas fa-exclamation"></i>
            </span>

            <div>
                <strong>
                    No se pudo iniciar sesión
                </strong>

                <span>
                    {{ session('error') }}
                </span>
            </div>
        </div>
    @endif

    <form
        action="{{ $login_url }}"
        method="POST"
        autocomplete="off"
        id="loginForm"
        onsubmit="return mostrarCargandoLogin(event);"
    >
        @csrf

        <div class="intevi-form-group">
            <label
                for="email"
                class="intevi-field-label"
            >
                Correo electrónico
            </label>

            <div
                class="intevi-field
                    @error('email') has-error @enderror"
            >
                <span
                    class="intevi-field-icon"
                    aria-hidden="true"
                >
                    <i class="fas fa-envelope"></i>
                </span>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="intevi-field-input"
                    value="{{ old('email') }}"
                    placeholder="nombre@institucion.com"
                    autocomplete="email"
                    inputmode="email"
                    autocapitalize="none"
                    spellcheck="false"
                    autofocus
                    required
                    oninput="
                        this.value =
                            this.value
                                .trimStart()
                                .toLowerCase()
                    "
                >
            </div>

            @error('email')
                <span class="intevi-field-error">
                    {{ $message }}
                </span>
            @else
                <span class="intevi-field-help">
                    Utiliza el correo asociado a tu cuenta institucional.
                </span>
            @enderror
        </div>

        <div class="intevi-form-group">
            <label
                for="password"
                class="intevi-field-label"
            >
                Contraseña
            </label>

            <div
                class="intevi-field
                    @error('password') has-error @enderror"
            >
                <span
                    class="intevi-field-icon"
                    aria-hidden="true"
                >
                    <i class="fas fa-lock"></i>
                </span>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="intevi-field-input"
                    placeholder="Introduce tu contraseña"
                    autocomplete="current-password"
                    required
                >

                <button
                    type="button"
                    class="intevi-password-toggle"
                    id="togglePassword"
                    aria-label="Mostrar contraseña"
                    aria-pressed="false"
                >
                    <i
                        class="fas fa-eye"
                        id="togglePasswordIcon"
                    ></i>
                </button>
            </div>

            @error('password')
                <span class="intevi-field-error">
                    {{ $message }}
                </span>
            @else
                <span class="intevi-field-help">
                    La contraseña distingue entre mayúsculas y minúsculas.
                </span>
            @enderror
        </div>

        <button
            type="submit"
            class="intevi-login-button"
            id="loginButton"
        >
            <span id="loginText">
                <i class="fas fa-arrow-right mr-1"></i>
                Entrar al sistema
            </span>

            <span
                id="loginLoading"
                style="display: none;"
            >
                <i class="fas fa-spinner fa-spin mr-1"></i>
                Validando acceso...
            </span>
        </button>

        <div class="intevi-login-footer">
            <strong>
                Inventario y resguardo institucional
            </strong>
        </div>
    </form>
@stop

@section('auth_footer')
@stop

@section('adminlte_js')
    <script>
        function mostrarCargandoLogin(event) {
            event.preventDefault();

            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loginLoading = document.getElementById('loginLoading');

            if (
                !form ||
                !button ||
                !loginText ||
                !loginLoading
            ) {
                return true;
            }

            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }

            button.disabled = true;
            button.setAttribute('aria-busy', 'true');

            loginText.style.display = 'none';
            loginLoading.style.display = 'inline-flex';
            loginLoading.style.alignItems = 'center';
            loginLoading.style.justifyContent = 'center';

            window.setTimeout(function () {
                form.submit();
            }, 250);

            return false;
        }

        document.addEventListener(
            'DOMContentLoaded',
            function () {
                const passwordInput =
                    document.getElementById('password');

                const togglePassword =
                    document.getElementById('togglePassword');

                const togglePasswordIcon =
                    document.getElementById('togglePasswordIcon');

                if (
                    !passwordInput ||
                    !togglePassword ||
                    !togglePasswordIcon
                ) {
                    return;
                }

                togglePassword.addEventListener(
                    'click',
                    function () {
                        const passwordIsHidden =
                            passwordInput.type === 'password';

                        passwordInput.type =
                            passwordIsHidden
                                ? 'text'
                                : 'password';

                        togglePasswordIcon.classList.toggle(
                            'fa-eye',
                            !passwordIsHidden
                        );

                        togglePasswordIcon.classList.toggle(
                            'fa-eye-slash',
                            passwordIsHidden
                        );

                        togglePassword.setAttribute(
                            'aria-label',
                            passwordIsHidden
                                ? 'Ocultar contraseña'
                                : 'Mostrar contraseña'
                        );

                        togglePassword.setAttribute(
                            'aria-pressed',
                            passwordIsHidden
                                ? 'true'
                                : 'false'
                        );

                        passwordInput.focus();
                    }
                );
            }
        );
    </script>
@stop