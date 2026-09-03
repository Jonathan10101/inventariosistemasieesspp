<div wire:ignore.self class="intevi-angular-form">
    <div class="modal-body p-0">

        <form wire:submit.prevent="save" enctype="multipart/form-data">

            {{-- TOPBAR --}}
            <div class="angular-topbar"></div>

            {{-- ENCABEZADO --}}
            <div class="angular-hero">
                <div>
                    <div class="angular-kicker">
                        <i class="fas fa-map-marker-alt"></i>
                        Catálogo institucional
                    </div>

                    <h4 class="angular-title">
                        Editar ubicación física
                    </h4>

                    <p class="angular-subtitle">
                        Actualiza el nombre de la ubicación física y su imagen de referencia para identificar mejor los bienes institucionales.
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
                        <span>Los campos marcados con (*) son obligatorios. La imagen es opcional.</span>
                    </div>
                </div>

                {{-- SECCIÓN: UBICACIÓN --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>

                        <div>
                            <h5>Información de la ubicación</h5>
                            <p>Modifica el nombre oficial del espacio físico registrado en el inventario.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('ubicacionfisica') has-error @enderror">
                                <i class="fas fa-map-marker-alt angular-field-icon"></i>

                                <input
                                    id="ubicacionfisica"
                                    type="text"
                                    wire:model.defer="ubicacionfisica"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    oninput="this.value = this.value.toUpperCase()"
                                >

                                <label for="ubicacionfisica" class="angular-field-label">
                                    Nombre de la ubicación física*
                                </label>

                                <small class="angular-help">
                                    Ejemplo: DIRECCIÓN GENERAL, AULA 1, ALMACÉN, OFICINA DE INFORMÁTICA.
                                </small>

                                @error('ubicacionfisica')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- SECCIÓN: IMAGEN --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-image"></i>
                        </div>

                        <div>
                            <h5>Imagen de referencia</h5>
                            <p>Actualiza la imagen de la ubicación física o conserva la imagen ya registrada.</p>
                        </div>
                    </div>

                    <label
                        for="imagenid"
                        class="angular-dropzone image-dropzone @error('imagen') has-error @enderror"
                    >
                        <input
                            id="imagenid"
                            type="file"
                            wire:model="imagen"
                            accept="image/png,image/jpeg,image/jpg,.png,.jpg,.jpeg"
                            class="angular-dropzone-input"
                        >

                        <div class="angular-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>

                        <strong>Subir imagen de la ubicación</strong>

                        <span>
                            Haz clic aquí o arrastra una imagen desde tu escritorio.
                        </span>

                        <small>
                            Formatos permitidos: PNG, JPG o JPEG.
                        </small>

                        <div class="dropzone-hint">
                            <i class="fas fa-mouse-pointer"></i>
                            Clic para seleccionar
                            <span></span>
                            <i class="fas fa-arrows-alt"></i>
                            Arrastrar y soltar
                        </div>

                        <div wire:loading wire:target="imagen" class="angular-upload-loading">
                            <i class="fas fa-spinner fa-spin"></i>
                            Cargando imagen...
                        </div>
                    </label>

                    @error('imagen')
                        <div class="angular-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    @if ($imagen)
                        <div class="angular-preview mt-3">
                            <div class="angular-preview-label">
                                <i class="fas fa-eye"></i>
                                Vista previa de la ubicación
                            </div>

                            @if (is_object($imagen))
                                <img
                                    src="{{ $imagen->temporaryUrl() }}"
                                    class="angular-preview-image"
                                    alt="Vista previa de la ubicación"
                                >
                            @else
                                <img
                                    src="{{ asset('storage/' . $imagen) }}"
                                    class="angular-preview-image"
                                    alt="Imagen actual de la ubicación"
                                >
                            @endif
                        </div>
                    @endif
                </div>

                {{-- ACCIONES --}}
                <div class="angular-actions">
                    <button type="submit" class="btn angular-btn-save text-white">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save"></i>
                            Guardar cambios
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

        .angular-field.has-error .form-control,
        .angular-dropzone.has-error {
            border-color: rgba(220, 38, 38, 0.55) !important;
            background: #fff7f7 !important;
        }

        .angular-field.has-error .angular-field-icon,
        .angular-field.has-error .angular-field-label {
            color: #dc2626;
        }

        .angular-dropzone {
            position: relative;
            display: block;
            padding: 24px;
            border-radius: 20px;
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            text-align: center;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.18s ease;
        }

        .angular-dropzone:hover {
            background: #ffffff;
            border-color: rgba(23, 28, 99, 0.48);
            box-shadow: 0 0 0 4px rgba(23, 28, 99, 0.06);
            transform: translateY(-1px);
        }

        .angular-dropzone-input {
            position: absolute;
            inset: 0;
            z-index: 20;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .angular-upload-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 13px;
            border-radius: 19px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .angular-dropzone strong {
            display: block;
            color: #0f172a;
            font-size: 15px;
            font-weight: 950;
        }

        .angular-dropzone span {
            display: block;
            margin-top: 5px;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .angular-dropzone small {
            display: block;
            margin-top: 5px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 650;
        }

        .dropzone-hint {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-size: 12px;
            font-weight: 900;
        }

        .dropzone-hint span {
            width: 4px;
            height: 4px;
            margin: 0 2px;
            border-radius: 999px;
            background: #cbd5e1;
        }

        .angular-upload-loading {
            position: relative;
            z-index: 30;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 12px;
            padding: 8px 11px;
            border-radius: 999px;
            background: rgba(23, 28, 99, 0.08);
            color: #171C63;
            font-size: 12px;
            font-weight: 900;
        }

        .angular-preview {
            padding: 15px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .angular-preview-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 12px;
            color: #64748b;
            font-size: 12px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.055em;
        }

        .angular-preview-image {
            max-width: 310px;
            max-height: 230px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
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

            .angular-preview-image {
                max-width: 100%;
            }
        }
    </style>
</div>