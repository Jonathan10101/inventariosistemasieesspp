(function () {
    'use strict';

    const CONFIG = {
        checkInterval: 15000,
        requestTimeout: 6000,
        restoredMessageDuration: 3500,
    };

    let networkStatus = 'online';
    let restoredTimeout = null;

    function createNetworkBanner() {
        if (document.getElementById('intevi-network-banner')) {
            return;
        }

        const banner = document.createElement('div');

        banner.id = 'intevi-network-banner';
        banner.className = 'intevi-network-banner';
        banner.setAttribute('role', 'alert');
        banner.setAttribute('aria-live', 'assertive');

        banner.innerHTML = `
            <div class="intevi-network-banner__content">
                <span
                    id="intevi-network-icon"
                    class="intevi-network-banner__icon"
                    aria-hidden="true"
                >
                    <i class="fas fa-wifi"></i>
                </span>

                <div class="intevi-network-banner__text">
                    <strong id="intevi-network-title">
                        Sin conexión con INTEVI
                    </strong>

                    <span id="intevi-network-message">
                        Verifica tu conexión a internet. Los cambios no podrán guardarse.
                    </span>
                </div>
            </div>
        `;

        document.body.appendChild(banner);
    }

    function getBannerElements() {
        return {
            banner: document.getElementById('intevi-network-banner'),
            icon: document.getElementById('intevi-network-icon'),
            title: document.getElementById('intevi-network-title'),
            message: document.getElementById('intevi-network-message'),
        };
    }

    function setNetworkStatus(status) {
        createNetworkBanner();

        const previousStatus = networkStatus;
        networkStatus = status;

        const elements = getBannerElements();

        if (!elements.banner) {
            return;
        }

        clearTimeout(restoredTimeout);

        document.documentElement.setAttribute(
            'data-intevi-network-status',
            status
        );

        elements.banner.classList.remove(
            'is-offline',
            'is-checking',
            'is-online'
        );

        if (status === 'offline') {
            elements.banner.classList.add('is-visible', 'is-offline');

            elements.icon.innerHTML =
                '<i class="fas fa-wifi-slash"></i>';

            elements.title.textContent =
                'Sin conexión con INTEVI';

            elements.message.textContent =
                'Verifica tu conexión a internet. Los cambios no podrán guardarse.';

            document.body.classList.add('intevi-is-offline');

            return;
        }

        if (status === 'checking') {
            elements.banner.classList.add('is-visible', 'is-checking');

            elements.icon.innerHTML =
                '<i class="fas fa-circle-notch fa-spin"></i>';

            elements.title.textContent =
                'Restableciendo conexión';

            elements.message.textContent =
                'Estamos comprobando la conexión con INTEVI.';

            document.body.classList.add('intevi-is-offline');

            return;
        }

        document.body.classList.remove('intevi-is-offline');

        if (
            previousStatus === 'offline' ||
            previousStatus === 'checking'
        ) {
            elements.banner.classList.add('is-visible', 'is-online');

            elements.icon.innerHTML =
                '<i class="fas fa-check-circle"></i>';

            elements.title.textContent =
                'Conexión restablecida';

            elements.message.textContent =
                'Ya puedes continuar trabajando normalmente.';

            restoredTimeout = setTimeout(function () {
                elements.banner.classList.remove('is-visible', 'is-online');
            }, CONFIG.restoredMessageDuration);
        } else {
            elements.banner.classList.remove('is-visible');
        }
    }

    async function checkApplicationConnection() {
        if (!navigator.onLine) {
            setNetworkStatus('offline');
            return false;
        }

        const controller = new AbortController();

        const timeout = setTimeout(function () {
            controller.abort();
        }, CONFIG.requestTimeout);

        try {
            const response = await fetch(
                '/up?intevi_check=' + Date.now(),
                {
                    method: 'GET',
                    cache: 'no-store',
                    credentials: 'same-origin',
                    signal: controller.signal,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                }
            );

            clearTimeout(timeout);

            if (!response.ok) {
                throw new Error(
                    'INTEVI respondió con estado ' + response.status
                );
            }

            setNetworkStatus('online');

            return true;
        } catch (error) {
            clearTimeout(timeout);

            setNetworkStatus('offline');

            return false;
        }
    }

    function isActionRequiringConnection(element) {
        if (!element) {
            return false;
        }

        if (element.closest('[data-offline-allowed]')) {
            return false;
        }

        return Boolean(
            element.closest(
                [
                    '[wire\\:click]',
                    '[wire\\:submit]',
                    'button[type="submit"]',
                    'input[type="submit"]',
                    '[data-requires-online]',
                ].join(',')
            )
        );
    }

    function showOfflineReminder() {
        setNetworkStatus('offline');

        const banner = document.getElementById(
            'intevi-network-banner'
        );

        if (!banner) {
            return;
        }

        banner.classList.remove('intevi-network-shake');

        void banner.offsetWidth;

        banner.classList.add('intevi-network-shake');
    }

    document.addEventListener(
        'click',
        function (event) {
            if (networkStatus === 'online') {
                return;
            }

            if (!isActionRequiringConnection(event.target)) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            showOfflineReminder();
        },
        true
    );

    document.addEventListener(
        'submit',
        function (event) {
            if (networkStatus === 'online') {
                return;
            }

            if (event.target.closest('[data-offline-allowed]')) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            showOfflineReminder();
        },
        true
    );

    window.addEventListener('offline', function () {
        setNetworkStatus('offline');
    });

    window.addEventListener('online', function () {
        setNetworkStatus('checking');
        checkApplicationConnection();
    });

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
            checkApplicationConnection();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        createNetworkBanner();
        checkApplicationConnection();

        setInterval(
            checkApplicationConnection,
            CONFIG.checkInterval
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Integración global con Livewire 3
    |--------------------------------------------------------------------------
    |
    | Si una petición Livewire falla por conexión, evitamos que aparezca
    | únicamente el error genérico y mostramos el aviso global de INTEVI.
    |
    */
    document.addEventListener('livewire:init', function () {
        if (
            typeof Livewire === 'undefined' ||
            typeof Livewire.hook !== 'function'
        ) {
            return;
        }

        Livewire.hook('request', function ({ succeed, fail }) {
            succeed(function () {
                if (networkStatus !== 'online') {
                    setNetworkStatus('online');
                }
            });

            fail(function ({ status, preventDefault }) {
                if (
                    !status ||
                    status === 0 ||
                    !navigator.onLine
                ) {
                    if (typeof preventDefault === 'function') {
                        preventDefault();
                    }

                    setNetworkStatus('offline');
                }
            });
        });
    });
})();