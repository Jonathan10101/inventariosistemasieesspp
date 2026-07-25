/**
 * INTEVI
 * Bloqueo global cuando no existe conexión.
 *
 * No depende de:
 * - Livewire
 * - jQuery
 * - Bootstrap
 * - Vite
 *
 * Los estilos se agregan desde este mismo archivo.
 */

(function () {
    'use strict';

    /*
     * Evita cargar el sistema dos veces.
     */
    if (window.__INTEVI_OFFLINE_GUARD__) {
        return;
    }

    window.__INTEVI_OFFLINE_GUARD__ = true;

    const CONFIG = {
        endpoint: '/conexion-intevi',
        timeout: 5000,
        onlineInterval: 15000,
        offlineInterval: 4000,
    };

    let overlay = null;
    let timer = null;
    let checking = false;

    /*
    |--------------------------------------------------------------------------
    | Crear estilos
    |--------------------------------------------------------------------------
    */

    function createStyles() {
        if (document.getElementById('intevi-offline-styles')) {
            return;
        }

        const style = document.createElement('style');

        style.id = 'intevi-offline-styles';

        style.textContent = `
            html.intevi-sin-conexion,
            body.intevi-sin-conexion {
                overflow: hidden !important;
            }

            #intevi-offline-overlay {
                position: fixed;
                inset: 0;
                z-index: 2147483647;

                display: flex;
                align-items: center;
                justify-content: center;

                padding: 20px;

                background: rgba(10, 14, 66, 0.97);

                opacity: 0;
                visibility: hidden;
                pointer-events: none;

                transition:
                    opacity 0.2s ease,
                    visibility 0.2s ease;

                font-family:
                    -apple-system,
                    BlinkMacSystemFont,
                    "Segoe UI",
                    Roboto,
                    Arial,
                    sans-serif;
            }

            #intevi-offline-overlay.intevi-visible {
                opacity: 1;
                visibility: visible;
                pointer-events: all;
            }

            .intevi-offline-card {
                width: 100%;
                max-width: 460px;

                padding: 36px 32px;

                background: #ffffff;
                border-radius: 16px;

                box-shadow:
                    0 24px 70px rgba(0, 0, 0, 0.35),
                    0 8px 25px rgba(0, 0, 0, 0.20);

                text-align: center;
            }

            .intevi-offline-icon {
                width: 90px;
                height: 90px;

                display: flex;
                align-items: center;
                justify-content: center;

                margin: 0 auto 18px;

                color: #171C63;
                background: rgba(23, 28, 99, 0.10);

                border-radius: 50%;
            }

            .intevi-offline-brand {
                margin-bottom: 10px;

                color: #171C63;

                font-size: 14px;
                font-weight: 900;
                letter-spacing: 3px;
            }

            .intevi-offline-title {
                margin: 0 0 14px;

                color: #171C63;

                font-size: 27px;
                font-weight: 800;
                line-height: 1.2;
            }

            .intevi-offline-description {
                margin: 0 0 22px;

                color: #4b5563;

                font-size: 15px;
                line-height: 1.6;
            }

            .intevi-offline-status {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;

                min-height: 46px;

                margin-bottom: 18px;
                padding: 11px 15px;

                color: #171C63;
                background: #f2f3f9;

                border: 1px solid rgba(23, 28, 99, 0.12);
                border-radius: 9px;

                font-size: 14px;
                font-weight: 700;
            }

            .intevi-offline-spinner {
                width: 18px;
                height: 18px;

                flex: 0 0 auto;

                border: 2px solid rgba(23, 28, 99, 0.22);
                border-top-color: #171C63;
                border-radius: 50%;

                animation: intevi-offline-girar 0.8s linear infinite;
            }

            .intevi-offline-button {
                width: 100%;

                padding: 13px 20px;

                color: #ffffff;
                background: #171C63;

                border: 0;
                border-radius: 8px;

                box-shadow: 0 8px 18px rgba(23, 28, 99, 0.22);

                font-size: 15px;
                font-weight: 800;

                cursor: pointer;
            }

            .intevi-offline-button:hover:not(:disabled) {
                background: #101447;
            }

            .intevi-offline-button:disabled {
                opacity: 0.65;
                cursor: wait;
            }

            .intevi-offline-help {
                margin: 17px 0 0;

                color: #6b7280;

                font-size: 12px;
                line-height: 1.5;
            }

            @keyframes intevi-offline-girar {
                to {
                    transform: rotate(360deg);
                }
            }

            @media (max-width: 576px) {
                .intevi-offline-card {
                    padding: 30px 22px;
                }

                .intevi-offline-title {
                    font-size: 23px;
                }

                .intevi-offline-description {
                    font-size: 14px;
                }
            }
        `;

        document.head.appendChild(style);
    }

    /*
    |--------------------------------------------------------------------------
    | Crear pantalla de bloqueo
    |--------------------------------------------------------------------------
    */

    function createOverlay() {
        const existingOverlay = document.getElementById(
            'intevi-offline-overlay'
        );

        if (existingOverlay) {
            overlay = existingOverlay;
            return overlay;
        }

        if (!document.body) {
            return null;
        }

        overlay = document.createElement('div');

        overlay.id = 'intevi-offline-overlay';
        overlay.setAttribute('role', 'alertdialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('aria-hidden', 'true');

        overlay.innerHTML = `
            <div class="intevi-offline-card">
                <div class="intevi-offline-icon">
                    <svg
                        width="58"
                        height="58"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path
                            d="M2 8.82C6.68 4.74 13.25 4.2 18.52 7.2"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />

                        <path
                            d="M5.5 12.32C8.22 10.14 11.74 9.58 14.9 10.65"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />

                        <path
                            d="M9 15.75C10.42 14.74 12.3 14.67 13.8 15.58"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />

                        <path
                            d="M12 19H12.01"
                            stroke="currentColor"
                            stroke-width="3"
                            stroke-linecap="round"
                        />

                        <path
                            d="M3 3L21 21"
                            stroke="currentColor"
                            stroke-width="2.4"
                            stroke-linecap="round"
                        />
                    </svg>
                </div>

                <div class="intevi-offline-brand">
                    INTEVI
                </div>

                <h1 class="intevi-offline-title">
                    Sin conexión
                </h1>

                <p class="intevi-offline-description">
                    INTEVI se bloqueó temporalmente para evitar
                    pérdidas o inconsistencias en la información.
                </p>

                <div class="intevi-offline-status">
                    <span
                        class="intevi-offline-spinner"
                        aria-hidden="true"
                    ></span>

                    <span data-intevi-offline-message>
                        Esperando conexión...
                    </span>
                </div>

                <button
                    type="button"
                    class="intevi-offline-button"
                    data-intevi-offline-retry
                >
                    Comprobar conexión
                </button>

                <p class="intevi-offline-help">
                    La aplicación se desbloqueará automáticamente
                    cuando regrese la conexión.
                </p>
            </div>
        `;

        document.body.appendChild(overlay);

        const retryButton = overlay.querySelector(
            '[data-intevi-offline-retry]'
        );

        retryButton?.addEventListener('click', function () {
            checkConnection(true);
        });

        return overlay;
    }

    /*
    |--------------------------------------------------------------------------
    | Cambiar mensaje
    |--------------------------------------------------------------------------
    */

    function setMessage(message, loading = false) {
        createOverlay();

        if (!overlay) {
            return;
        }

        const messageElement = overlay.querySelector(
            '[data-intevi-offline-message]'
        );

        const retryButton = overlay.querySelector(
            '[data-intevi-offline-retry]'
        );

        if (messageElement) {
            messageElement.textContent = message;
        }

        if (retryButton) {
            retryButton.disabled = loading;

            retryButton.textContent = loading
                ? 'Comprobando...'
                : 'Comprobar conexión';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar bloqueo
    |--------------------------------------------------------------------------
    */

    function showOffline(
        message = 'No fue posible conectarse con INTEVI.'
    ) {
        createStyles();
        createOverlay();

        if (!overlay) {
            return;
        }

        setMessage(message, false);

        overlay.classList.add('intevi-visible');
        overlay.setAttribute('aria-hidden', 'false');

        document.documentElement.classList.add(
            'intevi-sin-conexion'
        );

        document.body.classList.add('intevi-sin-conexion');

        scheduleCheck(CONFIG.offlineInterval);
    }

    /*
    |--------------------------------------------------------------------------
    | Ocultar bloqueo
    |--------------------------------------------------------------------------
    */

    function hideOffline() {
        createOverlay();

        if (overlay) {
            overlay.classList.remove('intevi-visible');
            overlay.setAttribute('aria-hidden', 'true');
        }

        document.documentElement.classList.remove(
            'intevi-sin-conexion'
        );

        document.body?.classList.remove(
            'intevi-sin-conexion'
        );

        scheduleCheck(CONFIG.onlineInterval);
    }

    /*
    |--------------------------------------------------------------------------
    | Programar comprobación
    |--------------------------------------------------------------------------
    */

    function scheduleCheck(milliseconds) {
        if (timer) {
            window.clearTimeout(timer);
        }

        timer = window.setTimeout(function () {
            checkConnection(false);
        }, milliseconds);
    }

    /*
    |--------------------------------------------------------------------------
    | Verificar conexión real
    |--------------------------------------------------------------------------
    */

    async function checkConnection(manual = false) {
        if (checking) {
            return;
        }

        checking = true;

        if (manual) {
            setMessage('Comprobando conexión...', true);
        }

        /*
         * Si el navegador confirma que no existe red,
         * bloqueamos inmediatamente.
         */
        if (navigator.onLine === false) {
            showOffline('Tu dispositivo no tiene conexión.');

            checking = false;
            return;
        }

        const controller = new AbortController();

        const timeoutId = window.setTimeout(function () {
            controller.abort();
        }, CONFIG.timeout);

        try {
            const url = new URL(
                CONFIG.endpoint,
                window.location.origin
            );

            url.searchParams.set(
                '_intevi',
                Date.now().toString()
            );

            const response = await fetch(url.toString(), {
                method: 'GET',
                cache: 'no-store',
                credentials: 'same-origin',
                redirect: 'follow',
                signal: controller.signal,
                headers: {
                    Accept: 'text/plain, */*',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'no-cache',
                },
            });

            if (!response.ok) {
                throw new Error(
                    'Respuesta del servidor: ' + response.status
                );
            }

            hideOffline();
        } catch (error) {
            showOffline(
                'No fue posible comunicarse con el servidor de INTEVI.'
            );
        } finally {
            window.clearTimeout(timeoutId);
            checking = false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Eventos del navegador
    |--------------------------------------------------------------------------
    */

    window.addEventListener('offline', function () {
        showOffline('Se perdió la conexión a Internet.');
    });

    window.addEventListener('online', function () {
        setMessage('Restableciendo conexión...', true);
        checkConnection(true);
    });

    window.addEventListener('pageshow', function () {
        checkConnection(false);
    });

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') {
            checkConnection(false);
        }
    });

    /*
     * Compatibilidad con Livewire.
     */
    document.addEventListener('livewire:navigated', function () {
        createStyles();
        createOverlay();
        checkConnection(false);
    });

    /*
    |--------------------------------------------------------------------------
    | Herramientas para comprobarlo manualmente
    |--------------------------------------------------------------------------
    */

    window.INTEVI_OFFLINE_TEST = {
        loaded: true,

        show: function () {
            showOffline('Prueba manual del bloqueo.');
        },

        hide: function () {
            hideOffline();
        },

        check: function () {
            checkConnection(true);
        },
    };

    /*
    |--------------------------------------------------------------------------
    | Inicialización
    |--------------------------------------------------------------------------
    */

    function initialize() {
        createStyles();
        createOverlay();

        if (navigator.onLine === false) {
            showOffline('Tu dispositivo no tiene conexión.');
        } else {
            checkConnection(false);
        }

        console.info(
            '[INTEVI] Detector de conexión cargado correctamente.'
        );
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initialize,
            { once: true }
        );
    } else {
        initialize();
    }
})();