<div class="hp-wrap hp-timeline">

    @forelse ($historiales as $historial)

        <span class="hp-dot" aria-hidden="true"></span>

        <div class="hp-card">

            {{-- Header --}}
            <div class="hp-head">
                <div>
                    <div class="hp-chips mb-2">
                        <span class="hp-chip hp-chip-primary">
                            {{ $historial->estadouso->estado }}
                        </span>
                        <span class="hp-chip">
                            Cantidad: {{ $historial->resguardo->cantidad }}
                        </span>
                        <span class="hp-chip">
                            {{ $historial->ubicacionFisica->descripcion }}
                        </span>
                    </div>

                    <h6 class="hp-title">
                        {{ $historial->resguardante->nombre1 }} {{ $historial->resguardante->nombre2 }}
                        {{ $historial->resguardante->apellido1 }} {{ $historial->resguardante->apellido2 }}
                    </h6>

                    <div class="hp-sub">
                        <span class="me-3">
                            <i class="far fa-calendar-alt"></i>
                            Asignación: <b>{{ $historial->fecha_asignacion }}</b>
                        </span>
                        <span>
                            <i class="fas fa-unlock"></i>
                            Liberación: <b>{{ $historial->fecha_liberacion ?? 'N/A' }}</b>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="hp-grid">

                {{-- Imagen --}}
                <div>
                    @if ($historial->imagen_evidencia)
                        <a href="{{ asset('storage/' . $historial->imagen_evidencia) }}" target="_blank" style="text-decoration:none;">
                            <div class="hp-media">
                                <img src="{{ asset('storage/' . $historial->imagen_evidencia) }}" alt="Evidencia">
                            </div>
                            <div class="text-center mt-2" style="font-size:.9rem; color:#64748b;">Ver evidencia</div>
                        </a>
                    @else
                        <div class="hp-media" style="border-style:dashed;">
                            Sin imagen
                        </div>
                    @endif
                </div>

                {{-- Datos --}}
                <div>
                    <div class="hp-kv">
                        <div class="hp-item">
                            <div class="hp-label">Estado de uso</div>
                            <div class="hp-value">{{ $historial->estadouso->estado }}</div>
                        </div>

                        <div class="hp-item">
                            <div class="hp-label">Cantidad</div>
                            <div class="hp-value">{{ $historial->resguardo->cantidad }}</div>
                        </div>

                        <div class="hp-item">
                            <div class="hp-label">Ubicación física</div>
                            <div class="hp-value">{{ $historial->ubicacionFisica->descripcion }}</div>
                        </div>

                        <div class="hp-item">
                            <div class="hp-label">Fecha de liberación</div>
                            <div class="hp-value">{{ $historial->fecha_liberacion ?? 'N/A' }}</div>
                        </div>
                    </div>

                    @php $user = Auth::user(); @endphp

                    @if ($user->hasRole('Administrador') || $user->hasRole('Delegacion') || $user->hasRole('Subdirector') ||  $user->hasRole('Director') || $user->id == $historial->resguardante_id)
                        <div class="hp-footer">
                            <a href="{{ Storage::url($historial->resguardo_pdf) }}" target="_blank" class="hp-btn">
                                <i class="fas fa-download"></i>
                                Descargar Resguardo
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    @empty
        <div class="hp-card text-center" style="color:#64748b;">
            <div style="font-weight:800; color:#0f172a; font-size:1.1rem;">No se encontró historial</div>
            <div style="margin-top:6px;">Aún no hay registros para mostrar.</div>
        </div>
    @endforelse

    <div class="mt-3 d-flex justify-content-end">
        {{ $historiales->links() }}
    </div>

    
<style>
    .hp-wrap { display: grid; gap: 18px; }
    .hp-card {
        background: #fff;
        border: 1px solid rgba(15, 23, 42, .08);
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 12px 30px rgba(2, 6, 23, .06);
    }
    .hp-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
    }
    .hp-title { margin: 0; font-weight: 800; color: #0f172a; font-size: 1.02rem; line-height: 1.35; }
    .hp-sub { color: #64748b; font-size: .9rem; line-height: 1.4; margin-top: 4px; }
    .hp-chips { display: flex; flex-wrap: wrap; gap: 8px; }
    .hp-chip {
        border-radius: 999px;
        padding: 7px 10px;
        font-size: .86rem;
        border: 1px solid rgba(15, 23, 42, .08);
        background: #f8fafc;
        color: #0f172a;
        font-weight: 600;
        white-space: nowrap;
    }
    .hp-chip-primary { background: rgba(23, 28, 99, .10); border-color: rgba(23, 28, 99, .18); color: #171C63; }
    .hp-grid { display: grid; grid-template-columns: 140px 1fr; gap: 16px; }
    @media (max-width: 768px){ .hp-grid { grid-template-columns: 1fr; } }

    .hp-media {
        width: 140px; height: 140px;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(15, 23, 42, .10);
        background: #f1f5f9;
        display:flex; align-items:center; justify-content:center;
        color:#64748b; font-weight:600;
    }
    .hp-media img { width: 100%; height: 100%; object-fit: cover; display:block; }
    .hp-kv { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; margin-top: 12px; }
    @media (max-width: 992px){ .hp-kv { grid-template-columns: 1fr; } }

    .hp-item {
        border: 1px solid rgba(15, 23, 42, .08);
        background: #fbfdff;
        border-radius: 14px;
        padding: 12px 12px;
    }
    .hp-label { font-size: .78rem; color: #64748b; margin-bottom: 3px; }
    .hp-value { font-weight: 750; color: #0f172a; font-size: .98rem; line-height: 1.4; }

    .hp-footer {
        display:flex;
        justify-content: flex-end;
        margin-top: 14px;
    }
    .hp-btn {
        display:inline-flex;
        align-items:center;
        gap:10px;
        border-radius: 14px;
        padding: .72rem 1.05rem;
        background: #171C63;
        color: #fff !important;
        text-decoration: none;
        font-weight: 700;
        border: 1px solid rgba(23, 28, 99, .0);
        box-shadow: 0 14px 30px rgba(23, 28, 99, .22);
        transition: transform .08s ease, box-shadow .12s ease;
    }
    .hp-btn:hover { transform: translateY(-1px); box-shadow: 0 18px 38px rgba(23, 28, 99, .28); }
    .hp-btn:active { transform: translateY(0px); }

    /* Timeline */
    .hp-timeline { position: relative; padding-left: 20px; }
    .hp-timeline:before {
        content:"";
        position:absolute;
        left: 8px; top: 10px; bottom: 10px;
        width: 2px;
        background: rgba(15, 23, 42, .10);
        border-radius: 999px;
    }
    .hp-dot {
        position:absolute;
        left: 2px;
        width: 14px; height: 14px;
        border-radius: 999px;
        background: #171C63;
        box-shadow: 0 8px 18px rgba(23, 28, 99, .28);
        margin-top: 22px;
    }
</style>

</div>

