(function () {
    'use strict';

    const DRIVER_VERSION = '1.6.0';

    const DRIVER_JS_URL =
        `https://cdn.jsdelivr.net/npm/driver.js@${DRIVER_VERSION}/dist/driver.js.iife.js`;

    const DRIVER_CSS_URL =
        `https://cdn.jsdelivr.net/npm/driver.js@${DRIVER_VERSION}/dist/driver.css`;

    let activeTour = null;
    let initializationTimer = null;
    let driverLoadingPromise = null;

    /**
     * Carga automáticamente Driver.js y su CSS.
     */
    function loadDriver() {
        if (window.driver?.js?.driver) {
            return Promise.resolve(window.driver.js.driver);
        }

        if (driverLoadingPromise) {
            return driverLoadingPromise;
        }

        driverLoadingPromise = new Promise(function (resolve, reject) {
            if (!document.querySelector('link[data-intevi-driver-css]')) {
                const css = document.createElement('link');

                css.rel = 'stylesheet';
                css.href = DRIVER_CSS_URL;
                css.dataset.inteviDriverCss = 'true';

                document.head.appendChild(css);
            }

            let script = document.querySelector(
                'script[data-intevi-driver-js]'
            );

            if (!script) {
                script = document.createElement('script');

                script.src = DRIVER_JS_URL;
                script.defer = true;
                script.dataset.inteviDriverJs = 'true';

                document.head.appendChild(script);
            }

            function driverLoaded() {
                const createDriver = window.driver?.js?.driver;

                if (!createDriver) {
                    reject(
                        new Error(
                            'Driver.js cargó, pero no se encontró window.driver.js.driver.'
                        )
                    );

                    return;
                }

                resolve(createDriver);
            }

            if (window.driver?.js?.driver) {
                driverLoaded();

                return;
            }

            script.addEventListener('load', driverLoaded, {
                once: true,
            });

            script.addEventListener(
                'error',
                function () {
                    reject(
                        new Error(
                            'No fue posible descargar Driver.js.'
                        )
                    );
                },
                {
                    once: true,
                }
            );
        });

        return driverLoadingPromise;
    }

    function getMarker() {
        return document.querySelector('[data-tour-page]');
    }

    function getStorageKey(marker) {
        const page =
            marker.dataset.tourPage ||
            window.location.pathname;

        const version =
            marker.dataset.tourVersion || '1';

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

    function getValidSide(value) {
        const validSides = [
            'top',
            'right',
            'bottom',
            'left',
        ];

        return validSides.includes(value)
            ? value
            : 'bottom';
    }

    function getValidAlign(value) {
        const validAlignments = [
            'start',
            'center',
            'end',
        ];

        return validAlignments.includes(value)
            ? value
            : 'center';
    }

    function buildSteps() {
        return Array.from(
            document.querySelectorAll('[data-tour-step]')
        )
            .filter(isVisible)
            .sort(function (first, second) {
                return (
                    Number(first.dataset.tourOrder || 0) -
                    Number(second.dataset.tourOrder || 0)
                );
            })
            .map(function (element) {
                return {
                    element: element,

                    popover: {
                        title:
                            element.dataset.tourTitle ||
                            'Información',

                        description:
                            element.dataset
                                .tourDescription ||
                            'Conoce esta sección del sistema.',

                        side: getValidSide(
                            element.dataset.tourSide
                        ),

                        align: getValidAlign(
                            element.dataset.tourAlign
                        ),
                    },
                };
            });
    }

    function hasSeenTour(storageKey) {
        try {
            return (
                window.localStorage.getItem(storageKey) ===
                'seen'
            );
        } catch (error) {
            return false;
        }
    }

    function markTourAsSeen(storageKey) {
        try {
            window.localStorage.setItem(
                storageKey,
                'seen'
            );
        } catch (error) {
            console.warn(
                'No fue posible guardar el tutorial.',
                error
            );
        }
    }

    function destroyTour() {
        if (!activeTour) {
            return;
        }

        try {
            activeTour.destroy();
        } catch (error) {
            console.warn(
                'No fue posible cerrar el tutorial.',
                error
            );
        }

        activeTour = null;
    }

    async function startTour(force = false) {
        const marker = getMarker();

        if (!marker) {
            console.warn(
                'INTEVI: falta data-tour-page en la vista.'
            );

            return;
        }

        const steps = buildSteps();

        if (steps.length === 0) {
            console.warn(
                'INTEVI: no existen elementos data-tour-step visibles.'
            );

            return;
        }

        const storageKey = getStorageKey(marker);

        if (!force && hasSeenTour(storageKey)) {
            return;
        }

        try {
            const createDriver = await loadDriver();

            destroyTour();

            activeTour = createDriver({
                steps: steps,

                animate: true,
                smoothScroll: true,
                allowClose: true,
                allowKeyboardControl: true,

                showProgress: true,
                progressText:
                    'Paso {{current}} de {{total}}',

                nextBtnText: 'Siguiente',
                prevBtnText: 'Anterior',
                doneBtnText: 'Finalizar',

                overlayColor: '#080b2f',
                overlayOpacity: 0.72,

                stagePadding: 8,
                stageRadius: 10,
                popoverOffset: 12,

                onDestroyed: function () {
                    markTourAsSeen(storageKey);
                    activeTour = null;
                },
            });

            activeTour.drive();
        } catch (error) {
            console.error(
                'INTEVI: no se pudo iniciar el tutorial.',
                error
            );
        }
    }

    function initializeTour() {
        window.clearTimeout(initializationTimer);

        initializationTimer = window.setTimeout(
            function () {
                const marker = getMarker();

                if (!marker) {
                    return;
                }

                if (
                    marker.dataset.tourAutostart ===
                    'true'
                ) {
                    startTour(false);
                }
            },
            500
        );
    }

    document.addEventListener(
        'click',
        function (event) {
            const button = event.target.closest(
                '[data-tour-start]'
            );

            if (!button) {
                return;
            }

            event.preventDefault();

            startTour(true);
        }
    );

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
            {
                once: true,
            }
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

            try {
                window.localStorage.removeItem(
                    getStorageKey(marker)
                );
            } catch (error) {
                console.warn(error);
            }

            startTour(true);
        },
    };

    console.log(
        '✅ INTEVI: sistema de tutoriales cargado.'
    );
})();