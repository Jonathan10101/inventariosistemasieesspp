<div wire:ignore.self class="intevi-angular-form">
    <div class="modal-body p-0">

        <form wire:submit.prevent="save">

            {{-- TOPBAR --}}
            <div class="angular-topbar"></div>

            {{-- ENCABEZADO --}}
            <div class="angular-hero">
                <div>
                    <div class="angular-kicker">
                        <i class="fas fa-user-shield"></i>
                        Gestión institucional
                    </div>

                    <h4 class="angular-title">
                        Registrar resguardante
                    </h4>

                    <p class="angular-subtitle">
                        Captura los datos del responsable que tendrá asignados bienes del inventario institucional.
                    </p>
                </div>
            </div>

            <div class="angular-body">

                {{-- AVISO --}}
                <div class="angular-alert mb-4">
                    <div class="angular-alert-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>

                    <div>
                        <strong>Captura segura</strong>
                        <span>Los campos marcados con (*) son obligatorios.</span>
                    </div>
                </div>

                {{-- SECCIÓN: DATOS PERSONALES --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-id-card"></i>
                        </div>

                        <div>
                            <h5>Datos personales</h5>
                            <p>Registra el nombre completo del resguardante de forma clara y sin espacios al inicio.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('nombre1') has-error @enderror">
                                <i class="fas fa-user angular-field-icon"></i>

                                <input
                                    id="nombre1label"
                                    type="text"
                                    wire:model.defer="nombre1"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    onkeydown="if(event.key === ' ') event.preventDefault()"
                                    oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')"
                                >

                                <label for="nombre1label" class="angular-field-label">
                                    Primer nombre*
                                </label>

                                @error('nombre1')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('nombre2') has-error @enderror">
                                <i class="fas fa-user angular-field-icon"></i>

                                <input
                                    id="nombre2label"
                                    type="text"
                                    wire:model.defer="nombre2"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    onkeydown="if(event.key === ' ') event.preventDefault()"
                                    oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')"
                                >

                                <label for="nombre2label" class="angular-field-label">
                                    Segundo nombre
                                </label>

                                @error('nombre2')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('apellido1') has-error @enderror">
                                <i class="fas fa-user-tag angular-field-icon"></i>

                                <input
                                    id="apellido1label"
                                    type="text"
                                    wire:model.defer="apellido1"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    onkeydown="if(event.key === ' ') event.preventDefault()"
                                    oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')"
                                >

                                <label for="apellido1label" class="angular-field-label">
                                    Primer apellido*
                                </label>

                                @error('apellido1')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('apellido2') has-error @enderror">
                                <i class="fas fa-user-tag angular-field-icon"></i>

                                <input
                                    id="apellido2label"
                                    type="text"
                                    wire:model.defer="apellido2"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    onkeydown="if(event.key === ' ') event.preventDefault()"
                                    oninput="this.value = this.value.toUpperCase().replace(/^\s+/, '')"
                                >

                                <label for="apellido2label" class="angular-field-label">
                                    Segundo apellido
                                </label>

                                @error('apellido2')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        @error('nombreCompleto')
                            <div class="col-md-12">
                                <div class="angular-error mb-0">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                    </div>
                </div>

                {{-- SECCIÓN: ADSCRIPCIÓN --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-building-columns"></i>
                        </div>

                        <div>
                            <h5>Adscripción institucional</h5>
                            <p>Selecciona la subdirección y el puesto correspondiente del resguardante.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="angular-field angular-select @error('area_id') has-error @enderror">
                                <i class="fas fa-building angular-field-icon"></i>

                                <label for="area_id" class="angular-field-label">
                                    Área*
                                </label>

                                <select
                                    id="area_id"
                                    wire:model.defer="area_id"
                                    class="form-control"
                                >
                                    <option value="">Selecciona una opción</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">
                                            {{ $area->nombre }}
                                        </option>
                                    @endforeach
                                   
                                </select>

                                @error('area_id')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-select @error('puesto_id') has-error @enderror">
                                <i class="fas fa-briefcase angular-field-icon"></i>

                                <label for="puesto" class="angular-field-label">
                                    Puesto*
                                </label>

                                <select
                                    id="puesto"
                                    wire:model.defer="puesto_id"
                                    class="form-control"
                                >
                                    <option value="">Seleccione...</option>

                                    @foreach($puestos as $puesto)
                                        <option value="{{ $puesto->id }}">
                                            {{ $puesto->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('puesto_id')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ACCESO --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-lock"></i>
                        </div>

                        <div>
                            <h5>Datos de acceso</h5>
                            <p>Actualiza correo y contraseña del resguardante cuando sea necesario.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('email') has-error @enderror">
                                <i class="fas fa-envelope angular-field-icon"></i>

                                <input
                                    id="emaillabel"
                                    type="text"
                                    wire:model.defer="email"
                                    class="form-control"
                                    placeholder=" "
                                    autocomplete="off"
                                    oninput="this.value = this.value.toLowerCase().replace(/\s/g, '')"
                                >

                                <label for="emaillabel" class="angular-field-label">
                                    Email
                                </label>

                                <small class="angular-help">
                                    Escribe el correo sin espacios.
                                </small>

                                @error('email')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-floating angular-password-field @error('password') has-error @enderror">
                                <i class="fas fa-key angular-field-icon"></i>

                                <input
                                    id="passwordlabel"
                                    type="password"
                                    wire:model.defer="password"
                                    class="form-control"
                                    placeholder=" "
                                    autocomplete="new-password"
                                >

                                <label for="passwordlabel" class="angular-field-label">
                                    Password
                                </label>

                                <button
                                    type="button"
                                    class="angular-password-toggle"
                                    onclick="togglePasswordResguardante()"
                                    title="Mostrar/Ocultar contraseña"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>

                                @error('password')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-select @error('rol') has-error @enderror">
                                <i class="fas fa-briefcase angular-field-icon"></i>

                                <label for="puesto" class="angular-field-label">
                                    Rol en el sistema*
                                </label>

                                <select
                                    id="puesto"
                                    wire:model.defer="rol"
                                    class="form-control"
                                >
                                    <option value="">Seleccione...</option>

                                    @foreach($roles as $rol)
                                        <option value="{{ $puesto->id }}">
                                            {{ $rol->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('rol')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>


                    </div>
                </div>

                
                @error('storage')
                    <div
                        style="
                            display: flex;
                            align-items: flex-start;
                            gap: 12px;
                            padding: 16px 18px;
                            margin-bottom: 20px;
                            color: #8f1d1d;
                            background: #fff1f1;
                            border: 1px solid #f5baba;
                            border-left: 5px solid #c62828;
                            border-radius: 12px;
                            box-shadow: 0 6px 18px rgba(198, 40, 40, 0.08);
                        "
                        role="alert"
                    >
                        <div
                            style="
                                display: flex;
                                width: 38px;
                                min-width: 38px;
                                height: 38px;
                                align-items: center;
                                justify-content: center;
                                color: #ffffff;
                                background: #c62828;
                                border-radius: 10px;
                            "
                        >
                            <i class="fas fa-database"></i>
                        </div>

                        <div>
                            <strong
                                style="
                                    display: block;
                                    margin-bottom: 4px;
                                    font-size: 15px;
                                "
                            >
                                Almacenamiento lleno
                            </strong>

                            <span style="font-size: 14px;">
                                {{ $message }}
                            </span>
                        </div>
                    </div>
                @enderror

                {{-- ACCIONES --}}
                <div class="angular-actions">
                    <button type="submit" class="btn angular-btn-save text-white">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save"></i>
                            Guardar resguardante
                        </span>

                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner fa-spin text-white"></i>
                            Guardando...
                        </span>
                    </button>
                </div>

            </div>
        </form>

    </div>

    <style>
        .intevi-angular-form {
            background: #ffffff;
            color: #111827;
            border-radius: 0 0 18px 18px;
            overflow: hidden;
        }

        .angular-topbar {
            height: 5px;
            background: linear-gradient(90deg, #171C63, #2563eb, #06b6d4);
        }

        .angular-hero {
            padding: 24px;
            background:
                radial-gradient(circle at top left, rgba(23, 28, 99, 0.12), transparent 34%),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid #edf2f7;
        }

        .angular-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.04em;
        }

        .angular-title {
            margin: 0;
            color: #0f172a;
            font-size: 22px;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .angular-subtitle {
            margin: 7px 0 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
        }

        .angular-body {
            padding: 24px;
            background: #ffffff;
        }

        .angular-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            border-radius: 16px;
            background: rgba(23, 28, 99, 0.07);
            color: #171C63;
            border: 1px solid rgba(23, 28, 99, 0.08);
        }

        .angular-alert-icon {
            width: 38px;
            height: 38px;
            border-radius: 13px;
            background: rgba(23, 28, 99, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .angular-alert strong {
            display: block;
            color: #171C63;
            font-size: 13px;
            font-weight: 950;
        }

        .angular-alert span {
            display: block;
            margin-top: 1px;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .angular-section {
            padding: 20px;
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.055);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .angular-section:hover {
            transform: translateY(-1px);
            box-shadow: 0 20px 46px rgba(15, 23, 42, 0.075);
        }

        .angular-section-header {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            margin-bottom: 18px;
        }

        .angular-section-icon {
            width: 45px;
            height: 45px;
            border-radius: 15px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .angular-section-header h5 {
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 950;
        }

        .angular-section-header p {
            margin: 3px 0 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.45;
        }

        .angular-field {
            position: relative;
            margin-bottom: 18px;
        }

        .angular-field .form-control {
            width: 100%;
            min-height: 54px;
            padding: 15px 14px 8px 46px !important;
            border-radius: 15px !important;
            border: 1px solid #dbe3ef !important;
            background: #f8fafc !important;
            color: #0f172a !important;
            font-size: 14px;
            font-weight: 700;
            box-shadow: none !important;
            outline: none !important;
            transition: all 0.18s ease;
        }

        .angular-field .form-control:focus {
            background: #ffffff !important;
            border-color: rgba(23, 28, 99, 0.48) !important;
            box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.09) !important;
        }

        .angular-field-icon {
            position: absolute;
            left: 16px;
            top: 18px;
            z-index: 3;
            color: #171C63;
            font-size: 15px;
            pointer-events: none;
        }

        .angular-field-label {
            position: absolute;
            top: 15px;
            left: 46px;
            z-index: 4;
            margin: 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 800;
            text-transform: none;
            letter-spacing: 0;
            pointer-events: none;
            transition: all 0.18s ease;
        }

        .angular-floating:focus-within .angular-field-label,
        .angular-floating .form-control:not(:placeholder-shown) ~ .angular-field-label {
            top: -8px;
            left: 38px;
            padding: 0 7px;
            border-radius: 999px;
            background: #ffffff;
            color: #171C63;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.055em;
        }

        .angular-select .form-control {
            padding-top: 18px !important;
        }

        .angular-select .angular-field-label {
            top: 7px;
            color: #64748b;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.055em;
        }

        .angular-help {
            display: block;
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }

        .angular-error {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 8px;
            color: #dc2626;
            font-size: 12px;
            font-weight: 850;
        }

        .angular-field.has-error .form-control {
            border-color: rgba(220, 38, 38, 0.55) !important;
            background: #fff7f7 !important;
        }

        .angular-field.has-error .angular-field-icon,
        .angular-field.has-error .angular-field-label {
            color: #dc2626;
        }

        .angular-password-field .form-control {
            padding-right: 52px !important;
        }

        .angular-password-toggle {
            position: absolute;
            right: 10px;
            top: 9px;
            z-index: 5;
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 12px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .angular-password-toggle:hover {
            background: #171C63;
            color: #ffffff;
        }

        .angular-actions {
            position: sticky;
            bottom: 0;
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 0 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.72), #ffffff 45%);
            backdrop-filter: blur(10px);
        }

        .angular-btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 19px;
            border: none;
            border-radius: 13px;
            background: linear-gradient(135deg, #171C63 0%, #26318f 100%);
            color: #ffffff;
            font-weight: 950;
            box-shadow: 0 14px 28px rgba(23, 28, 99, 0.24);
            transition: all 0.18s ease;
        }

        .angular-btn-save span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .angular-btn-save:hover {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(23, 28, 99, 0.32);
        }

        @media (max-width: 576px) {
            .angular-hero,
            .angular-body {
                padding: 18px;
            }

            .angular-section {
                padding: 16px;
            }

            .angular-title {
                font-size: 20px;
            }

            .angular-actions {
                align-items: stretch;
            }

            .angular-btn-save {
                width: 100%;
            }
        }
    </style>

    <script>
        function togglePasswordResguardante() {
            const input = document.getElementById('passwordlabel');
            const icon = document.querySelector('.angular-password-toggle i');

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';

                if (icon) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            } else {
                input.type = 'password';

                if (icon) {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        }
    </script>
</div>