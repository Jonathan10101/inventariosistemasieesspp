/**
 * INTEVI - Bloqueo global cuando no existe conexión
 *
 * Características:
 * - No depende de Livewire.
 * - No depende de jQuery.
 * - No depende de Bootstrap.
 * - No depende de Vite.
 * - Compatible con navegación normal y wire:navigate.
 */

(function () {
    'use strict';

    /*
     * Evita que el script se registre más de una vez.
     */
    if (window.__inteviOfflineGuardLoaded) {
        return;
    }

    window.__inteviOfflineGuardLoaded = true;

    const CONFIG = {
        endpoint: '/conexion-intevi',

        /*
         * Tiempo máximo para esperar respuesta del servidor.
         */
        timeout: 5000,

        /*
         * Frecuencia de comprobación cuando existe conexión.
         */
        onlineInterval: 15000,

        /*
         * Frecuencia de comprobación cuando no existe conexión.
         */
        offlineInterval: 5000,
    };

    let timer = null;
    let checking = false;

    /**
     * Crea el bloqueo visual.
     */
    function createOverlay() {
        let overlay = document.getElementById('intevi-offline-overlay');

        if (overlay) {
            return overlay;
        }

        if (!document.body) {
            return null;
        }

        overlay = document.createElement('div');
        overlay.id = 'intevi-offline-overlay';
        overlay.className = 'intevi-offline-overlay';
        overlay.setAttribute('aria-hidden', 'true');
        overlay.setAttribute('aria-live', 'assertive');
        overlay.setAttribute('role', 'alertdialog');
        overlay.setAttribute('aria-modal', 'true');

        overlay.innerHTML = `
            <div class="intevi-offline-card">
                <div class="intevi-offline-icon" aria-hidden="true">
                    <svg
                        viewBox="0 0 24 24"
                        width="64"
                        height="64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
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
                    Sin conexión a Internet
                </h1>

                <p class="intevi-offline-description">
                    La aplicación se bloqueó temporalmente para evitar
                    pérdidas o inconsistencias en la información.
                </p>

                <div class="intevi-offline-status">
                    <span
                        class="intevi-offline-spinner"
                        aria-hidden="true"
                    ></span>

                    <span data-intevi-offline-status>
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
                    INTEVI se desbloqueará automáticamente cuando
                    se restablezca la conexión.
                </p>
            </div>
        `;

        document.body.appendChild(overlay);

        const retryButton = overlay.querySelector(
            '[data-intevi-offline-retry]'
        );

        if (retryButton) {
            retryButton.addEventListener('click', function () {
                checkConnection(true);
            });
        }

        return overlay;
    }

    /**
     * Actualiza el mensaje mostrado.
     */
    function setStatus(message, isChecking = false) {
        const overlay = createOverlay();

        if (!overlay) {
            return;
        }

        const status = overlay.querySelector(
            '[data-intevi-offline-status]'
        );

        const button = overlay.querySelector(
            '[data-intevi-offline-retry]'
        );

        if (status) {
            status.textContent = message;
        }

        if (button) {
            button.disabled = isChecking;
            button.textContent = isChecking
                ? 'Comprobando...'
                : 'Comprobar conexión';
        }
    }

    /**
     * Bloquea toda la aplicación.
     */
    function blockApplication() {
        const overlay = createOverlay();

        if (!overlay) {
            return;
        }

        overlay.classList.add('is-visible');
        overlay.setAttribute('aria-hidden', 'false');

        document.documentElement.classList.add('intevi-is-offline');
        document.body.classList.add('intevi-is-offline');

        scheduleNextCheck(CONFIG.offlineInterval);
    }

    /**
     * Desbloquea la aplicación.
     */
    function unblockApplication() {
        const overlay = document.getElementById(
            'intevi-offline-overlay'
        );

        if (overlay) {
            overlay.classList.remove('is-visible');
            overlay.setAttribute('aria-hidden', 'true');
        }

        document.documentElement.classList.remove(
            'intevi-is-offline'
        );

        if (document.body) {
            document.body.classList.remove('intevi-is-offline');
        }

        scheduleNextCheck(CONFIG.onlineInterval);
    }

    /**
     * Programa la siguiente comprobación.
     */
    function scheduleNextCheck(milliseconds) {
        if (timer) {
            window.clearTimeout(timer);
        }

        timer = window.setTimeout(function () {
            checkConnection(false);
        }, milliseconds);
    }

    /**
     * Comprueba la conexión real contra Laravel.
     */
    async function checkConnection(manualCheck = false) {
        if (checking) {
            return;
        }

        checking = true;

        if (manualCheck) {
            setStatus('Comprobando conexión...', true);
        }

        /*
         * El navegador ya detectó que no existe red.
         */
        if (!navigator.onLine) {
            blockApplication();
            setStatus('Esperando conexión...', false);
            checking = false;
            return;
        }

        const controller = new AbortController();

        const timeoutId = window.setTimeout(function () {
            controller.abort();
        }, CONFIG.timeout);

        try {
            const separator = CONFIG.endpoint.includes('?')
                ? '&'
                : '?';

            const url =
                CONFIG.endpoint +
                separator +
                'timestamp=' +
                Date.now();

            const response = await fetch(url, {
                method: 'GET',
                cache: 'no-store',
                credentials: 'same-origin',
                redirect: 'follow',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'no-cache',
                },
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(
                    'El servidor respondió con estado ' +
                    response.status
                );
            }

            unblockApplication();
        } catch (error) {
            blockApplication();

            setStatus(
                'No fue posible conectar con INTEVI.',
                false
            );
        } finally {
            window.clearTimeout(timeoutId);
            checking = false;
        }
    }

    /**
     * El navegador perdió completamente la red.
     */
    window.addEventListener('offline', function () {
        blockApplication();
        setStatus('Se perdió la conexión a Internet.', false);
    });

    /**
     * El navegador informa que regresó la red.
     *
     * No desbloqueamos inmediatamente. Primero comprobamos que
     * el servidor de INTEVI realmente responda.
     */
    window.addEventListener('online', function () {
        setStatus('Restableciendo conexión...', true);
        checkConnection(true);
    });

    /**
     * Compatibilidad con navegación de Livewire.
     */
    document.addEventListener('livewire:navigated', function () {
        createOverlay();
        checkConnection(false);
    });

    /**
     * Inicialización.
     */
    function initialize() {
        createOverlay();
        checkConnection(false);
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