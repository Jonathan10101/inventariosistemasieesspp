(function () {
    'use strict';

    const DRIVER_VERSION = '1.6.0';

    const DRIVER_JS_URL =
        `https://cdn.jsdelivr.net/npm/driver.js@${DRIVER_VERSION}/dist/driver.js.iife.js`;

    const DRIVER_CSS_URL =
        `https://cdn.jsdelivr.net/npm/driver.js@${DRIVER_VERSION}/dist/driver.css`;

    let globalTour = null;
    let driverLoadingPromise = null;

    /**
     * Carga Driver.js y su CSS automáticamente.
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

            function resolveDriver() {
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

    /**
     * Comprueba si un elemento existe y está visible.
     */
    function getVisibleElement(selectors) {
        const element = document.querySelector(selectors);

        if (!element) {
            return null;
        }

        const style = window.getComputedStyle(element);

        if (
            style.display === 'none' ||
            style.visibility === 'hidden' ||
            element.getClientRects().length === 0
        ) {
            return null;
        }

        return element;
    }

    /**
     * Agrega un paso únicamente si el elemento existe.
     */
    function addStep(
        steps,
        selectors,
        title,
        description,
        side = 'right',
        align = 'center'
    ) {
        const element = getVisibleElement(selectors);

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

    /**
     * Construye el tutorial general.
     */
    function buildGlobalSteps() {
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

        addStep(
            steps,
            '.brand-link',
            'INTEVI',
            'Este es el acceso principal del sistema. Desde aquí puedes identificar la plataforma y regresar al área principal.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/dashboard"], a[href="dashboard"]',
            'Panel de control',
            'Aquí puedes consultar indicadores, totales y movimientos recientes del inventario.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/inventario"], a[href="inventario"]',
            'Inventario',
            'En este módulo puedes registrar, consultar y administrar los bienes institucionales.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/resguardante"], a[href="resguardante"]',
            'Resguardantes',
            'Aquí se administran las personas responsables de recibir y resguardar los bienes.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/marcas"], a[href="marcas"]',
            'Marcas',
            'Gestiona el catálogo de marcas disponibles para los bienes del inventario.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/puestos"], a[href="puestos"]',
            'Puestos',
            'Administra los puestos institucionales asociados a los resguardantes.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/areadeasignacion"], a[href="areadeasignacion"]',
            'Áreas de asignación',
            'Organiza las áreas administrativas donde se asignan los bienes institucionales.',
            'right'
        );

        addStep(
            steps,
            'a[href$="/ubicacionfisica"], a[href="ubicacionfisica"]',
            'Ubicaciones físicas',
            'Controla los edificios, oficinas, almacenes y espacios donde se encuentran los bienes.',
            'right'
        );

        addStep(
            steps,
            '.navbar-nav .user-menu, .user-menu',
            'Cuenta de usuario',
            'Desde esta opción puedes consultar tu cuenta y cerrar sesión.',
            'bottom',
            'end'
        );

        addStep(
            steps,
            'a[href="#tutorial-general"], a[href$="#tutorial-general"]',
            'Tutorial general',
            'Puedes volver a iniciar este recorrido cuando lo necesites desde esta opción.',
            'right'
        );

        steps.push({
            popover: {
                title: 'Recorrido finalizado',
                description:
                    'Ya conoces las principales secciones de INTEVI. Recuerda que cada módulo también cuenta con su propio tutorial.',
                side: 'bottom',
                align: 'center',
            },
        });

        return steps;
    }

    /**
     * Cierra el tutorial general.
     */
    function destroyGlobalTour() {
        if (!globalTour) {
            return;
        }

        try {
            globalTour.destroy();
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible cerrar el tutorial general.',
                error
            );
        }

        globalTour = null;
    }

    /**
     * Inicia el tutorial general.
     */
    async function startGlobalTour() {
        try {
            const createDriver = await loadDriver();

            destroyGlobalTour();

            globalTour = createDriver({
                steps: buildGlobalSteps(),

                animate: true,
                smoothScroll: true,

                allowClose: true,
                allowKeyboardControl: true,

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

                onDestroyed: function () {
                    globalTour = null;
                },
            });

            globalTour.drive();
        } catch (error) {
            console.error(
                'INTEVI: no se pudo iniciar el tutorial general.',
                error
            );
        }
    }

    /**
     * Escucha el botón del menú AdminLTE.
     */
    document.addEventListener('click', function (event) {
        const button = event.target.closest(
            '.js-intevi-global-tour, ' +
            '[data-global-tour-start], ' +
            'a[href="#tutorial-general"], ' +
            'a[href$="#tutorial-general"]'
        );

        if (!button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        startGlobalTour();
    });

    /**
     * Cierra el tour antes de navegar con Livewire.
     */
    document.addEventListener(
        'livewire:navigating',
        destroyGlobalTour
    );

    /**
     * Acceso opcional desde consola.
     */
    window.INTEVIGlobalTour = {
        start: startGlobalTour,
    };

    console.log(
        '✅ INTEVI: tutorial general cargado.'
    );
})();