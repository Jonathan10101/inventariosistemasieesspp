(function () {
    'use strict';

    let activeTour = null;
    let initializationTimer = null;

    function getMarker() {
        return document.querySelector('[data-tour-page]');
    }

    function getStorageKey(marker) {
        const page = marker.dataset.tourPage || window.location.pathname;
        const version = marker.dataset.tourVersion || '1';

        return `intevi:tour:${page}:v${version}`;
    }

    function isVisible(element) {
        if (!element) {
            return false;
        }

        const style = window.getComputedStyle(element);

        return (
            style.display !== 'none' &&
            style.visibility !== 'hidden' &&
            element.getClientRects().length > 0
        );
    }

    function buildSteps() {
        return Array.from(
            document.querySelectorAll('[data-tour-step]')
        )
            .filter(isVisible)
            .sort((a, b) => {
                return Number(a.dataset.tourOrder || 0) -
                    Number(b.dataset.tourOrder || 0);
            })
            .map((element) => ({
                element: element,

                popover: {
                    title:
                        element.dataset.tourTitle ||
                        'Información',

                    description:
                        element.dataset.tourDescription ||
                        'Conoce esta sección del sistema.',

                    side:
                        element.dataset.tourSide ||
                        'bottom',

                    align:
                        element.dataset.tourAlign ||
                        'center',
                },
            }));
    }

    function destroyTour() {
        if (!activeTour) {
            return;
        }

        try {
            activeTour.destroy();
        } catch (error) {
            console.warn(error);
        }

        activeTour = null;
    }

    function startTour(force = false) {
        const marker = getMarker();

        if (!marker) {
            return;
        }

        const steps = buildSteps();

        if (steps.length === 0) {
            console.warn(
                'No existen elementos con data-tour-step.'
            );

            return;
        }

        const storageKey = getStorageKey(marker);

        if (
            !force &&
            localStorage.getItem(storageKey) === 'seen'
        ) {
            return;
        }

        const createDriver =
            window.driver?.js?.driver;

        if (!createDriver) {
            console.error('Driver.js no está cargado.');

            return;
        }

        destroyTour();

        activeTour = createDriver({
            steps: steps,

            animate: true,
            smoothScroll: true,
            allowClose: true,

            showProgress: true,
            progressText: 'Paso {{current}} de {{total}}',

            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            doneBtnText: 'Finalizar',

            overlayColor: '#080b2f',
            overlayOpacity: 0.72,

            stagePadding: 8,
            stageRadius: 10,
            popoverOffset: 12,

            skipMissingElement: true,

            onDestroyed: function () {
                localStorage.setItem(storageKey, 'seen');
                activeTour = null;
            },
        });

        activeTour.drive();
    }

    function initializeTour() {
        window.clearTimeout(initializationTimer);

        initializationTimer = window.setTimeout(function () {
            const marker = getMarker();

            if (!marker) {
                return;
            }

            if (marker.dataset.tourAutostart === 'true') {
                startTour(false);
            }
        }, 500);
    }

    document.addEventListener('click', function (event) {
        const button = event.target.closest(
            '[data-tour-start]'
        );

        if (!button) {
            return;
        }

        event.preventDefault();

        startTour(true);
    });

    document.addEventListener(
        'livewire:navigated',
        initializeTour
    );

    document.addEventListener(
        'livewire:navigating',
        destroyTour
    );

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initializeTour,
            { once: true }
        );
    } else {
        initializeTour();
    }

    window.INTEVITour = {
        start: function () {
            startTour(true);
        },

        reset: function () {
            const marker = getMarker();

            if (!marker) {
                return;
            }

            localStorage.removeItem(
                getStorageKey(marker)
            );

            startTour(true);
        },
    };
})();