<div wire:ignore.self class="intevi-angular-form">
    <div class="modal-body p-0">

        <form wire:submit.prevent="save">

            {{-- TOPBAR --}}
            <div class="angular-topbar"></div>

            {{-- ENCABEZADO --}}
            <div class="angular-hero">
                <div>
                    <div class="angular-kicker">
                        <i class="fas fa-briefcase"></i>
                        Catálogo institucional
                    </div>

                    <h4 class="angular-title">
                        Editar área de asginación
                    </h4>

                    <p class="angular-subtitle">
                        Actualiza el nombre del área de asginación utilizado para la plataforma.
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

                {{-- SECCIÓN --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-id-badge"></i>
                        </div>

                        <div>
                            <h5>Información del área de asignación</h5>
                            <p>Modifica el nombre oficial del área de asginación que será usado en los resguardos institucionales.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('areaDeUso') has-error @enderror">
                                <i class="fas fa-briefcase angular-field-icon"></i>

                                <input
                                    id="areaDeUso"
                                    type="text"
                                    wire:model.defer="areaDeUso"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    oninput="this.value = this.value.toUpperCase()"
                                >

                                <label for="areaDeUso" class="angular-field-label">
                                    Nombre del área de asginación*
                                </label>

                                <small class="angular-help">
                                    Ejemplo: DELEGACIÓN ADMINISTRATIVA, DEPARTAMENTO DE COORDINACIÓN Y VINCULACIÓN, RECURSOS HUMANOS.
                                </small>

                                @error('areaDeUso')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ACCIONES --}}
                <div class="angular-actions">
                    <button type="submit" class="btn angular-btn-save  text-white">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save"></i>
                            Guardar cambios
                        </span>

                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner fa-spin  text-whites"></i>
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
</div>