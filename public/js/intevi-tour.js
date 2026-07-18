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

    /*
    |--------------------------------------------------------------------------
    | DRIVER.JS: UNA SOLA CARGA PARA TODOS LOS TUTORIALES
    |--------------------------------------------------------------------------
    */

    function loadDriver() {
        if (window.driver?.js?.driver) {
            return Promise.resolve(
                window.driver.js.driver
            );
        }

        if (driverLoadingPromise) {
            return driverLoadingPromise;
        }

        driverLoadingPromise = new Promise(
            function (resolve, reject) {
                if (
                    !document.querySelector(
                        'link[data-intevi-driver-css]'
                    )
                ) {
                    const css =
                        document.createElement('link');

                    css.rel = 'stylesheet';
                    css.href = DRIVER_CSS_URL;
                    css.dataset.inteviDriverCss =
                        'true';

                    document.head.appendChild(css);
                }

                let script =
                    document.querySelector(
                        'script[data-intevi-driver-js]'
                    );

                if (!script) {
                    script =
                        document.createElement(
                            'script'
                        );

                    script.src = DRIVER_JS_URL;
                    script.dataset.inteviDriverJs =
                        'true';

                    document.head.appendChild(
                        script
                    );
                }

                function resolveDriver() {
                    const createDriver =
                        window.driver?.js?.driver;

                    if (!createDriver) {
                        driverLoadingPromise = null;

                        reject(
                            new Error(
                                'Driver.js cargó, pero window.driver.js.driver no está disponible.'
                            )
                        );

                        return;
                    }

                    resolve(createDriver);
                }

                if (
                    window.driver?.js?.driver
                ) {
                    resolveDriver();

                    return;
                }

                script.addEventListener(
                    'load',
                    resolveDriver,
                    {
                        once: true,
                    }
                );

                script.addEventListener(
                    'error',
                    function () {
                        driverLoadingPromise =
                            null;

                        reject(
                            new Error(
                                'No fue posible cargar Driver.js desde el CDN.'
                            )
                        );
                    },
                    {
                        once: true,
                    }
                );
            }
        );

        return driverLoadingPromise;
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCIONES COMPARTIDAS
    |--------------------------------------------------------------------------
    */

    function isVisible(element) {
        if (!element) {
            return false;
        }

        const style =
            window.getComputedStyle(element);

        return (
            style.display !== 'none' &&
            style.visibility !== 'hidden' &&
            element.getClientRects().length > 0
        );
    }

    function findVisibleElement(selectors) {
        const elements =
            document.querySelectorAll(selectors);

        for (const element of elements) {
            if (isVisible(element)) {
                return element;
            }
        }

        return null;
    }

    function destroyActiveTour() {
        if (!activeTour) {
            return;
        }

        try {
            activeTour.destroy();
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible cerrar el tutorial.',
                error
            );
        }

        activeTour = null;
    }

    function getDriverConfiguration(
        steps,
        onDestroyed
    ) {
        return {
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

            onDestroyed: onDestroyed,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | TUTORIALES DE CADA MÓDULO
    |--------------------------------------------------------------------------
    */

    function getMarker() {
        return document.querySelector(
            '[data-tour-page]'
        );
    }

    function getStorageKey(marker) {
        const page =
            marker.dataset.tourPage ||
            window.location.pathname;

        const version =
            marker.dataset.tourVersion ||
            '1';

        return `intevi:tour:${page}:v${version}`;
    }

    function getValidSide(value) {
        const sides = [
            'top',
            'right',
            'bottom',
            'left',
        ];

        return sides.includes(value)
            ? value
            : 'bottom';
    }

    function getValidAlign(value) {
        const alignments = [
            'start',
            'center',
            'end',
        ];

        return alignments.includes(value)
            ? value
            : 'center';
    }

    function buildModuleSteps() {
        return Array.from(
            document.querySelectorAll(
                '[data-tour-step]'
            )
        )
            .filter(isVisible)
            .sort(
                function (
                    first,
                    second
                ) {
                    return (
                        Number(
                            first.dataset
                                .tourOrder || 0
                        ) -
                        Number(
                            second.dataset
                                .tourOrder || 0
                        )
                    );
                }
            )
            .map(function (element) {
                return {
                    element: element,

                    popover: {
                        title:
                            element.dataset
                                .tourTitle ||
                            'Información',

                        description:
                            element.dataset
                                .tourDescription ||
                            'Conoce esta sección del sistema.',

                        side: getValidSide(
                            element.dataset
                                .tourSide
                        ),

                        align: getValidAlign(
                            element.dataset
                                .tourAlign
                        ),
                    },
                };
            });
    }

    function hasSeenTour(storageKey) {
        try {
            return (
                window.localStorage.getItem(
                    storageKey
                ) === 'seen'
            );
        } catch (error) {
            return false;
        }
    }

    function markTourAsSeen(
        storageKey
    ) {
        try {
            window.localStorage.setItem(
                storageKey,
                'seen'
            );
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible guardar el tutorial.',
                error
            );
        }
    }

    async function startModuleTour(
        force = false
    ) {
        const marker = getMarker();

        if (!marker) {
            console.warn(
                'INTEVI: falta data-tour-page en la vista.'
            );

            return;
        }

        const steps =
            buildModuleSteps();

        if (steps.length === 0) {
            console.warn(
                'INTEVI: no existen elementos data-tour-step visibles.'
            );

            return;
        }

        const storageKey =
            getStorageKey(marker);

        if (
            !force &&
            hasSeenTour(storageKey)
        ) {
            return;
        }

        try {
            const createDriver =
                await loadDriver();

            destroyActiveTour();

            activeTour = createDriver(
                getDriverConfiguration(
                    steps,
                    function () {
                        markTourAsSeen(
                            storageKey
                        );

                        activeTour = null;
                    }
                )
            );

            activeTour.drive();
        } catch (error) {
            console.error(
                'INTEVI: no se pudo iniciar el tutorial del módulo.',
                error
            );
        }
    }

    function initializeModuleTour() {
        window.clearTimeout(
            initializationTimer
        );

        initializationTimer =
            window.setTimeout(
                function () {
                    const marker =
                        getMarker();

                    if (!marker) {
                        return;
                    }

                    if (
                        marker.dataset
                            .tourAutostart ===
                        'true'
                    ) {
                        startModuleTour(
                            false
                        );
                    }
                },
                400
            );
    }

    /*
    |--------------------------------------------------------------------------
    | TUTORIAL GENERAL
    |--------------------------------------------------------------------------
    */

    function getGeneralTourAnchor() {
        const links =
            document.querySelectorAll(
                '.nav-sidebar a, ' +
                'a[data-intevi-global-tour]'
            );

        for (const link of links) {
            if (
                link.matches(
                    '[data-intevi-global-tour]'
                )
            ) {
                return link;
            }

            const rawHref =
                link.getAttribute('href') ||
                '';

            try {
                const url = new URL(
                    rawHref,
                    window.location.href
                );

                if (
                    url.hash ===
                    '#tutorial-general'
                ) {
                    return link;
                }
            } catch (error) {
                if (
                    rawHref.includes(
                        '#tutorial-general'
                    )
                ) {
                    return link;
                }
            }
        }

        return null;
    }

    function ensureGeneralTourButton() {
        if (getGeneralTourAnchor()) {
            return;
        }

        const sidebar =
            document.querySelector(
                'ul.nav-sidebar, .nav-sidebar'
            );

        if (!sidebar) {
            return;
        }

        const item =
            document.createElement('li');

        item.className = 'nav-item';

        item.innerHTML = `
            <a
                href="#tutorial-general"
                class="nav-link"
                data-intevi-global-tour
            >
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>Tutorial general</p>
            </a>
        `;

        sidebar.appendChild(item);
    }

    function addGeneralStep(
        steps,
        selectors,
        title,
        description,
        side = 'right',
        align = 'center'
    ) {
        const element =
            findVisibleElement(selectors);

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

    function buildGeneralSteps() {
        const steps = [];

        addGeneralStep(
            steps,
            '.content-wrapper, .wrapper',
            'Bienvenido a INTEVI',
            'Este recorrido te mostrará las principales secciones del sistema de inventario institucional.',
            'bottom',
            'center'
        );

        addGeneralStep(
            steps,
            '.brand-link',
            'INTEVI',
            'Desde este espacio puedes identificar la plataforma y regresar al área principal.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/dashboard"], ' +
                '.nav-sidebar a[href$="dashboard"]',
            'Panel de control',
            'Consulta indicadores, totales y movimientos recientes del inventario.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/inventario"], ' +
                '.nav-sidebar a[href$="inventario"]',
            'Inventario',
            'Registra, consulta y administra los bienes institucionales.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/resguardante"], ' +
                '.nav-sidebar a[href$="resguardante"]',
            'Resguardantes',
            'Administra las personas responsables de recibir y resguardar los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/marcas"], ' +
                '.nav-sidebar a[href$="marcas"]',
            'Marcas',
            'Gestiona el catálogo de marcas utilizado en el inventario.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/puestos"], ' +
                '.nav-sidebar a[href$="puestos"]',
            'Puestos',
            'Administra los puestos institucionales asociados a los resguardantes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/areadeasignacion"], ' +
                '.nav-sidebar a[href$="areadeasignacion"]',
            'Áreas de asignación',
            'Organiza las áreas administrativas donde se asignan los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/ubicacionfisica"], ' +
                '.nav-sidebar a[href$="ubicacionfisica"]',
            'Ubicaciones físicas',
            'Controla los edificios, oficinas y espacios donde se encuentran los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.user-menu',
            'Cuenta de usuario',
            'Desde aquí puedes consultar las opciones de tu cuenta y cerrar sesión.',
            'bottom',
            'end'
        );

        const generalButton =
            getGeneralTourAnchor();

        if (
            generalButton &&
            isVisible(generalButton)
        ) {
            steps.push({
                element: generalButton,

                popover: {
                    title:
                        'Tutorial general',

                    description:
                        'Puedes abrir nuevamente este recorrido desde esta opción.',

                    side: 'right',
                    align: 'center',
                },
            });
        }

        return steps;
    }

    async function startGeneralTour() {
        ensureGeneralTourButton();

        const steps =
            buildGeneralSteps();

        if (steps.length === 0) {
            console.warn(
                'INTEVI: no se encontraron elementos visibles para el tutorial general.'
            );

            return;
        }

        try {
            const createDriver =
                await loadDriver();

            destroyActiveTour();

            activeTour = createDriver(
                getDriverConfiguration(
                    steps,
                    function () {
                        activeTour = null;
                    }
                )
            );

            activeTour.drive();
        } catch (error) {
            console.error(
                'INTEVI: no se pudo iniciar el tutorial general.',
                error
            );
        }
    }

    function isGeneralTourTrigger(
        target
    ) {
        const link = target.closest(
            'a, [data-intevi-global-tour]'
        );

        if (!link) {
            return null;
        }

        if (
            link.matches(
                '[data-intevi-global-tour]'
            )
        ) {
            return link;
        }

        const rawHref =
            link.getAttribute('href') ||
            '';

        try {
            const url = new URL(
                rawHref,
                window.location.href
            );

            return (
                url.hash ===
                '#tutorial-general'
            )
                ? link
                : null;
        } catch (error) {
            return rawHref.includes(
                '#tutorial-general'
            )
                ? link
                : null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EVENTOS
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {
            const generalTrigger =
                isGeneralTourTrigger(
                    event.target
                );

            if (generalTrigger) {
                event.preventDefault();
                event.stopImmediatePropagation();

                startGeneralTour();

                return;
            }

            const moduleTrigger =
                event.target.closest(
                    '[data-tour-start]'
                );

            if (!moduleTrigger) {
                return;
            }

            event.preventDefault();

            startModuleTour(true);
        },
        true
    );

    function initializeAllTours() {
        ensureGeneralTourButton();
        initializeModuleTour();
    }

    if (
        document.readyState ===
        'loading'
    ) {
        document.addEventListener(
            'DOMContentLoaded',
            initializeAllTours,
            {
                once: true,
            }
        );
    } else {
        initializeAllTours();
    }

    document.addEventListener(
        'livewire:navigated',
        initializeAllTours
    );

    document.addEventListener(
        'livewire:navigating',
        destroyActiveTour
    );

    window.INTEVITour = {
        start: function () {
            startModuleTour(true);
        },

        reset: function () {
            const marker =
                getMarker();

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

            startModuleTour(true);
        },

        general: function () {
            startGeneralTour();
        },
    };

    console.log(
        '✅ INTEVI: tutorial de módulos y tutorial general cargados.'
    );
})();