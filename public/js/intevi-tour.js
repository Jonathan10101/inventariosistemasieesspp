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


(function () {
    'use strict';

    const DRIVER_VERSION = '1.6.0';

    const DRIVER_JS_URL =
        `https://cdn.jsdelivr.net/npm/driver.js@${DRIVER_VERSION}/dist/driver.js.iife.js`;

    const DRIVER_CSS_URL =
        `https://cdn.jsdelivr.net/npm/driver.js@${DRIVER_VERSION}/dist/driver.css`;

    let generalTour = null;
    let driverPromise = null;

    function loadGeneralDriver() {
        if (window.driver?.js?.driver) {
            return Promise.resolve(window.driver.js.driver);
        }

        if (driverPromise) {
            return driverPromise;
        }

        driverPromise = new Promise(function (resolve, reject) {
            if (!document.querySelector('link[data-intevi-general-driver-css]')) {
                const css = document.createElement('link');

                css.rel = 'stylesheet';
                css.href = DRIVER_CSS_URL;
                css.dataset.inteviGeneralDriverCss = 'true';

                document.head.appendChild(css);
            }

            let script = document.querySelector(
                'script[data-intevi-general-driver-js]'
            );

            if (!script) {
                script = document.createElement('script');

                script.src = DRIVER_JS_URL;
                script.dataset.inteviGeneralDriverJs = 'true';

                document.head.appendChild(script);
            }

            function resolveDriver() {
                const createDriver = window.driver?.js?.driver;

                if (!createDriver) {
                    reject(
                        new Error(
                            'Driver.js no quedó disponible.'
                        )
                    );

                    return;
                }

                resolve(createDriver);
            }

            if (window.driver?.js?.driver) {
                resolveDriver();
                return;
            }

            script.addEventListener(
                'load',
                resolveDriver,
                { once: true }
            );

            script.addEventListener(
                'error',
                function () {
                    reject(
                        new Error(
                            'No se pudo cargar Driver.js.'
                        )
                    );
                },
                { once: true }
            );
        });

        return driverPromise;
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

    function findVisibleElement(selectors) {
        const elements = document.querySelectorAll(selectors);

        for (const element of elements) {
            if (isVisible(element)) {
                return element;
            }
        }

        return null;
    }

    function addGeneralStep(
        steps,
        selectors,
        title,
        description,
        side = 'right',
        align = 'center'
    ) {
        const element = findVisibleElement(selectors);

        if (!element) {
            return;
        }

        steps.push({
            element: element,

            popover: {
                title: title,
                description: description,
                side: side,
                align: align,
            },
        });
    }

    function ensureGeneralTourButton() {
        const sidebar = document.querySelector(
            '.nav-sidebar'
        );

        if (!sidebar) {
            console.warn(
                'INTEVI: no se encontró el menú lateral.'
            );

            return;
        }

        if (
            document.getElementById(
                'intevi-global-tour-button'
            )
        ) {
            return;
        }

        const menuItem = document.createElement('li');

        menuItem.className = 'nav-item';
        menuItem.dataset.inteviGlobalTourItem = 'true';

        menuItem.innerHTML = `
            <a
                href="#"
                id="intevi-global-tour-button"
                class="nav-link"
                data-intevi-global-tour
            >
                <i class="nav-icon fas fa-graduation-cap"></i>

                <p>
                    Tutorial general
                </p>
            </a>
        `;

        const firstHeader = sidebar.querySelector(
            '.nav-header'
        );

        if (firstHeader) {
            sidebar.insertBefore(
                menuItem,
                firstHeader
            );
        } else {
            sidebar.appendChild(menuItem);
        }

        console.log(
            '✅ INTEVI: botón del tutorial general agregado.'
        );
    }

    function buildGeneralSteps() {
        const steps = [
            {
                popover: {
                    title: 'Bienvenido a INTEVI',
                    description:
                        'Este recorrido te mostrará las principales secciones del sistema de inventario institucional.',
                    side: 'bottom',
                    align: 'center',
                },
            },
        ];

        addGeneralStep(
            steps,
            '.brand-link',
            'INTEVI',
            'Este es el acceso principal del sistema. Desde aquí puedes identificar la plataforma.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/dashboard"], a[href="dashboard"]',
            'Panel de control',
            'Consulta indicadores, totales y movimientos recientes del inventario.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/inventario"], a[href="inventario"]',
            'Inventario',
            'Registra, consulta y administra los bienes institucionales.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/resguardante"], a[href="resguardante"]',
            'Resguardantes',
            'Administra las personas responsables de recibir y resguardar los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/marcas"], a[href="marcas"]',
            'Marcas',
            'Gestiona el catálogo de marcas utilizado en los registros del inventario.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/puestos"], a[href="puestos"]',
            'Puestos',
            'Administra los puestos institucionales asociados a los resguardantes.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/areadeasignacion"], a[href="areadeasignacion"]',
            'Áreas de asignación',
            'Organiza las áreas administrativas donde son asignados los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            'a[href$="/ubicacionfisica"], a[href="ubicacionfisica"]',
            'Ubicaciones físicas',
            'Controla los edificios, oficinas y espacios donde se encuentran los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.user-menu, .navbar-nav .dropdown-user',
            'Cuenta de usuario',
            'Desde aquí puedes consultar tu cuenta y cerrar sesión.',
            'bottom',
            'end'
        );

        addGeneralStep(
            steps,
            '#intevi-global-tour-button',
            'Tutorial general',
            'Puedes abrir nuevamente este recorrido desde esta opción.',
            'right'
        );

        steps.push({
            popover: {
                title: 'Recorrido finalizado',
                description:
                    'Ya conoces las principales secciones de INTEVI. Cada módulo también cuenta con su propio tutorial.',
                side: 'bottom',
                align: 'center',
            },
        });

        return steps;
    }

    function destroyGeneralTour() {
        if (!generalTour) {
            return;
        }

        try {
            generalTour.destroy();
        } catch (error) {
            console.warn(
                'INTEVI: error al cerrar el tutorial general.',
                error
            );
        }

        generalTour = null;
    }

    async function startGeneralTour() {
        try {
            ensureGeneralTourButton();

            const createDriver =
                await loadGeneralDriver();

            destroyGeneralTour();

            const steps = buildGeneralSteps();

            generalTour = createDriver({
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
                    generalTour = null;
                },
            });

            generalTour.drive();
        } catch (error) {
            console.error(
                'INTEVI: no se pudo iniciar el tutorial general.',
                error
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Captura el clic antes que AdminLTE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {
            const button = event.target.closest(
                '#intevi-global-tour-button, ' +
                '[data-intevi-global-tour]'
            );

            if (!button) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            startGeneralTour();
        },
        true
    );

    function initializeGeneralTour() {
        window.setTimeout(
            ensureGeneralTourButton,
            300
        );
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initializeGeneralTour
        );
    } else {
        initializeGeneralTour();
    }

    document.addEventListener(
        'livewire:navigated',
        initializeGeneralTour
    );

    window.INTEVIGeneralTour = {
        start: startGeneralTour,
    };

    console.log(
        '✅ INTEVI: tutorial general integrado.'
    );
})();