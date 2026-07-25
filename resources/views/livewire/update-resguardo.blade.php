<div wire:ignore.self class="intevi-angular-form">
    <div class="modal-body p-0">

        <form wire:submit.prevent="save" enctype="multipart/form-data">

            {{-- TOPBAR --}}
            <div class="angular-topbar"></div>

            {{-- ENCABEZADO --}}
            <div class="angular-hero">
                <div>
                    <div class="angular-kicker">
                        <i class="fas fa-pen-to-square"></i>
                        Actualización institucional
                    </div>

                    <h4 class="angular-title">
                        Editar inventario / resguardo
                    </h4>

                    <p class="angular-subtitle">
                        Actualiza la información del bien, ubicación, institución y datos administrativos del resguardo.
                    </p>
                </div>
            </div>

            <div class="angular-body">

                {{-- AVISO --}}
                <div class="angular-alert mb-4">
                    <div class="angular-alert-icon">
                        <i class="fas fa-circle-info"></i>
                    </div>

                    <div>
                        <strong>Edición controlada</strong>
                        <span>Los campos marcados con (*) son obligatorios. Algunos campos pueden estar protegidos por permisos.</span>
                    </div>
                </div>

                {{-- SECCIÓN: INFORMACIÓN GENERAL --}}
                @can('inventario.edit')
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h5>Información general del bien</h5>
                            <p>Datos principales para identificar el inventario institucional.</p>
                        </div>
                        
                    </div>
                    @endcan

                    <div class="row">

                        @can('inventario.edit')
                            <div class="col-md-12">
                                <div class="angular-field angular-floating @error('descripcion') has-error @enderror">
                                    <i class="fas fa-box angular-field-icon"></i>

                                    <input
                                        id="descripcionid"
                                        type="text"
                                        wire:model.defer="descripcion"
                                        class="form-control text-uppercase"
                                        placeholder=" "
                                        autocomplete="off"
                                        oninput="this.value = this.value.toUpperCase()"
                                    >

                                    <label for="descripcionid" class="angular-field-label">
                                        Descripción*
                                    </label>

                                    <small class="angular-help">
                                        Ejemplo: LAPTOP DELL LATITUDE, IMPRESORA HP, ESCRITORIO, SILLA, ETC.
                                    </small>

                                    @error('descripcion')
                                        <div class="angular-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('inventario.edit')
                            <div class="col-md-12">
                                <div class="angular-field angular-select @error('marca_id') has-error @enderror">
                                    <i class="fas fa-tags angular-field-icon"></i>

                                    <label for="marcaid" class="angular-field-label">
                                        Marca*
                                    </label>

                                    <select
                                        id="marcaid"
                                        wire:model.defer="marca_id"
                                        class="form-control"
                                    >
                                        <option value="">Seleccione...</option>

                                        @foreach($marcas as $marca)
                                            <option value="{{ $marca->id }}">
                                                {{ $marca->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('marca_id')
                                        <div class="angular-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('inventario.edit')
                            <div class="col-md-12">
                                <div class="angular-field angular-floating @error('modelo') has-error @enderror">
                                    <i class="fas fa-laptop angular-field-icon"></i>

                                    <input
                                        id="modeloid"
                                        type="text"
                                        wire:model.defer="modelo"
                                        class="form-control text-uppercase"
                                        placeholder=" "
                                        autocomplete="off"
                                        oninput="this.value = this.value.toUpperCase()"
                                    >

                                    <label for="modeloid" class="angular-field-label">
                                        Modelo*
                                    </label>

                                    <small class="angular-help">
                                        Si no aplica, puedes dejarlo como N/A según tu validación.
                                    </small>

                                    @error('modelo')
                                        <div class="angular-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        @can('inventario.edit')
                        <div class="col-md-12">
                            <div class="angular-field angular-floating @error('nserie') has-error @enderror">
                                <i class="fas fa-barcode angular-field-icon"></i>

                                <input
                                    id="numerodeserieid"
                                    type="text"
                                    wire:model.defer="nserie"
                                    class="form-control text-uppercase"
                                    placeholder=" "
                                    autocomplete="off"
                                    oninput="this.value = this.value.toUpperCase()"
                                >

                                <label for="numerodeserieid" class="angular-field-label">
                                    No. de serie*
                                </label>

                                <small class="angular-help">
                                    Ingresa el número de serie del bien. Si no aplica, usa el criterio definido por la institución.
                                </small>

                                @error('nserie')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endcan

                    </div>
                </div>

                {{-- SECCIÓN: ESTADO Y UBICACIÓN --}}
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-map-location-dot"></i>
                        </div>

                        <div>
                            <h5>Estado, área y ubicación</h5>
                            <p>Define la clasificación institucional y la ubicación física del bien.</p>
                        </div>
                    </div>

                    <div class="row">

                        {{-- Oculto como lo tenías originalmente --}}
                        <div class="col-md-12" style="display:none;">
                            <div class="angular-field angular-select @error('estado_uso_id') has-error @enderror">
                                <i class="fas fa-check-circle angular-field-icon"></i>

                                <label for="estadodeusoid" class="angular-field-label">
                                    Estado de uso*
                                </label>

                                <select
                                    id="estadodeusoid"
                                    wire:model.defer="estado_uso_id"
                                    class="form-control"
                                >
                                    <option value="">Seleccione...</option>

                                    @foreach($estadosdeuso as $estadodeuso)
                                        <option value="{{ $estadodeuso->id }}">
                                            {{ $estadodeuso->estado }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('estado_uso_id')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        @can('inventario.update')
                            <div class="col-md-12">
                                <div class="angular-field angular-select @error('area_de_uso_id') has-error @enderror">
                                    <i class="fas fa-sitemap angular-field-icon"></i>

                                    <label for="areadeasignacionid" class="angular-field-label">
                                        Área de asignación*
                                    </label>

                                    <select
                                        id="areadeasignacionid"
                                        wire:model.defer="area_de_uso_id"
                                        class="form-control"
                                    >
                                        <option value="">Seleccione...</option>

                                        @foreach($areasdeasignacion as $areadeasignacion)
                                            <option value="{{ $areadeasignacion->id }}">
                                                {{ $areadeasignacion->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('area_de_uso_id')
                                        <div class="angular-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endcan

                        <div class="col-md-12">
                            <div class="angular-field angular-select @error('ubicacion_fisicas_id') has-error @enderror">
                                <i class="fas fa-location-dot angular-field-icon"></i>

                                <label for="ubicacionfisicaid" class="angular-field-label">
                                    Ubicación física*
                                </label>

                                <select
                                    id="ubicacionfisicaid"
                                    wire:model.live="ubicacion_fisicas_id"
                                    class="form-control"
                                >
                                    <option value="">Seleccione...</option>

                                    @foreach($ubicacionesifiscas as $ubicacionifisca)
                                        <option value="{{ $ubicacionifisca->id }}">
                                            {{ $ubicacionifisca->descripcion }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('ubicacion_fisicas_id')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @if($ubicacion_img_url)
                                <div class="angular-preview mt-2">
                                    <div class="angular-preview-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Imagen de la ubicación seleccionada
                                    </div>

                                    <img
                                        src="{{ $ubicacion_img_url }}"
                                        alt="Imagen de ubicación"
                                        class="angular-preview-image"
                                    >
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- SECCIÓN: RESPONSABLE / COMENTADO ORIGINALMENTE --}}
                {{--
                <div class="angular-section mb-4">
                    <div class="angular-section-header">
                        <div class="angular-section-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>

                        <div>
                            <h5>Responsable del resguardo</h5>
                            <p>Activa esta sección únicamente si tu flujo permite corregir resguardante.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="angular-field angular-floating">
                                <i class="fas fa-lock angular-field-icon"></i>

                                <input
                                    type="password"
                                    class="form-control"
                                    wire:model.live="edit_password"
                                    placeholder=" "
                                >

                                <label class="angular-field-label">
                                    Contraseña de autorización
                                </label>

                                <small class="angular-help">
                                    Solo para corregir errores. Para asignar a otra persona, usa + Añadir Nuevo Resguardo.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="angular-field angular-select @error('resguardante_id') has-error @enderror">
                                <i class="fas fa-id-badge angular-field-icon"></i>

                                <label for="resguardanteid" class="angular-field-label">
                                    Resguardante*
                                </label>

                                <select
                                    id="resguardanteid"
                                    wire:model.defer="resguardante_id"
                                    class="form-control"
                                    @disabled(!$canEditResguardante)
                                >
                                    <option value="">Seleccione...</option>

                                    @foreach($resguardantes as $resguardante)
                                        <option value="{{ $resguardante->id }}">
                                            {{ $resguardante->nombre1 }}
                                            {{ $resguardante->nombre2 }}
                                            {{ $resguardante->apellido1 }}
                                            {{ $resguardante->apellido2 }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('resguardante_id')
                                    <div class="angular-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
                --}}

        

                {{-- PDF OPCIONAL: SOLO FUNCIONA SI TU COMPONENTE TIENE public $resguardo_pdf --}}
                {{-- 
                @if(property_exists($this, 'resguardo_pdf'))
                    <div class="angular-section mb-4">
                        <div class="angular-section-header">
                            <div class="angular-section-icon pdf-section">
                                <i class="fas fa-file-pdf"></i>
                            </div>

                            <div>
                                <h5>Documento de resguardo</h5>
                                <p>Actualiza el PDF firmado si necesitas reemplazar el documento del resguardo.</p>
                            </div>
                        </div>

                        <label
                            for="resguardo_pdf_upload"
                            class="angular-dropzone pdf-dropzone @error('resguardo_pdf') has-error @enderror"
                        >
                            <input
                                id="resguardo_pdf_upload"
                                type="file"
                                wire:model="resguardo_pdf"
                                accept="application/pdf,.pdf"
                                class="angular-dropzone-input"
                            >

                            <div class="angular-upload-icon pdf">
                                <i class="fas fa-file-pdf"></i>
                            </div>

                            <strong>Subir PDF del resguardo</strong>

                            <span>
                                Haz clic aquí o arrastra el PDF desde tu escritorio.
                            </span>

                            <small>
                                Solo archivo PDF. Tamaño recomendado: máximo 10 MB.
                            </small>

                            <div class="dropzone-hint">
                                <i class="fas fa-mouse-pointer"></i>
                                Clic para seleccionar
                                <span></span>
                                <i class="fas fa-arrows-alt"></i>
                                Arrastrar y soltar
                            </div>

                            <div wire:loading wire:target="resguardo_pdf" class="angular-upload-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                Cargando PDF...
                            </div>
                        </label>

                        @if($resguardo_pdf)
                            <div class="pdf-selected-card mt-3">
                                <div class="pdf-selected-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>

                                <div>
                                    <strong>PDF seleccionado correctamente</strong>

                                    <p>
                                        @if(is_object($resguardo_pdf) && method_exists($resguardo_pdf, 'getClientOriginalName'))
                                            {{ $resguardo_pdf->getClientOriginalName() }}
                                        @else
                                            Documento listo para guardar
                                        @endif
                                    </p>
                                </div>

                                <div class="pdf-selected-check">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        @endif

                        @error('resguardo_pdf')
                            <div class="angular-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
                --}}

                {{-- ACCIONES --}}
                <div class="angular-actions">
                    <button type="submit" class="btn angular-btn-save  text-white">
                        <span wire:loading.remove wire:target="save">
                            <i class="fas fa-save"></i>
                            Guardar cambios
                        </span>

                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner fa-spin"></i>
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

        .angular-section-icon.pdf-section {
            background: #fff1f2;
            color: #be123c;
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
            padding: 18px 14px 7px 46px;
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
            top: 7px;
            left: 46px;
            z-index: 4;
            margin: 0;
            color: #64748b;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.055em;
            pointer-events: none;
        }

        .angular-floating .form-control {
            padding: 15px 14px 8px 46px !important;
        }

        .angular-floating .angular-field-label {
            top: 15px;
            left: 46px;
            color: #64748b;
            font-size: 14px;
            font-weight: 800;
            text-transform: none;
            letter-spacing: 0;
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
            padding-top: 18px;
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

        .angular-upload-icon.pdf {
            background: #fff1f2;
            color: #be123c;
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

        .pdf-selected-card {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px;
            border-radius: 18px;
            background: #fff7f7;
            border: 1px solid #fecdd3;
        }

        .pdf-selected-icon {
            width: 45px;
            height: 45px;
            border-radius: 15px;
            background: #ffe4e6;
            color: #be123c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
        }

        .pdf-selected-card strong {
            display: block;
            color: #0f172a;
            font-size: 14px;
            font-weight: 950;
        }

        .pdf-selected-card p {
            margin: 2px 0 0;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            word-break: break-word;
        }

        .pdf-selected-check {
            margin-left: auto;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: #dcfce7;
            color: #15803d;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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

            .pdf-selected-card {
                align-items: flex-start;
            }
        }
    </style>
</div>