(function () {
    'use strict';

    const STORAGE_PREFIX = 'intevi:tour';
    const DRIVER_WAIT_LIMIT = 80;
    const DRIVER_WAIT_INTERVAL = 100;

    let activeDriver = null;
    let activeTourMaySave = false;
    let bootTimer = null;

    function getDriverFactory() {
        return window.driver &&
            window.driver.js &&
            typeof window.driver.js.driver === 'function'
            ? window.driver.js.driver
            : null;
    }

    function waitForDriver(attempt) {
        const factory = getDriverFactory();

        if (factory) {
            return Promise.resolve(factory);
        }

        if (attempt >= DRIVER_WAIT_LIMIT) {
            return Promise.reject(
                new Error('Driver.js no fue cargado por AdminLTE.')
            );
        }

        return new Promise(function (resolve) {
            window.setTimeout(resolve, DRIVER_WAIT_INTERVAL);
        }).then(function () {
            return waitForDriver(attempt + 1);
        });
    }

    function getMarker() {
        return document.querySelector('[data-tour-page]');
    }

    function normalizeName(value) {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/\s+/g, '-');
    }

    function parseVersion(value, fallback) {
        const parsed = Number.parseInt(value, 10);
        return Number.isFinite(parsed) && parsed > 0
            ? parsed
            : fallback;
    }

    function getPageConfig() {
        const marker = getMarker();

        if (!marker) {
            return null;
        }

        return {
            marker: marker,
            page: normalizeName(marker.dataset.tourPage),
            version: parseVersion(marker.dataset.tourVersion, 1),
            general: marker.dataset.tourGeneral === 'true',
            generalVersion: parseVersion(
                marker.dataset.tourGeneralVersion,
                parseVersion(marker.dataset.tourVersion, 1)
            ),
            autostart: marker.dataset.tourAutostart === 'true',
        };
    }

    function storageKey(name, version) {
        return [
            STORAGE_PREFIX,
            window.location.host,
            normalizeName(name),
            'v' + version,
        ].join(':');
    }

    function hasSeen(name, version) {
        try {
            return window.localStorage.getItem(
                storageKey(name, version)
            ) === 'seen';
        } catch (error) {
            return false;
        }
    }

    function markSeen(name, version) {
        try {
            window.localStorage.setItem(
                storageKey(name, version),
                'seen'
            );
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible guardar el tutorial.',
                error
            );
        }
    }

    function resetTour(name, version) {
        try {
            window.localStorage.removeItem(
                storageKey(name, version)
            );
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible reiniciar el tutorial.',
                error
            );
        }
    }

    function resetAllTours() {
        const prefix = STORAGE_PREFIX + ':' + window.location.host + ':';
        const keys = [];

        try {
            for (let index = 0; index < window.localStorage.length; index++) {
                const key = window.localStorage.key(index);

                if (key && key.indexOf(prefix) === 0) {
                    keys.push(key);
                }
            }

            keys.forEach(function (key) {
                window.localStorage.removeItem(key);
            });
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible reiniciar los tutoriales.',
                error
            );
        }
    }

    function isVisible(element) {
        if (!element) {
            return false;
        }

        const style = window.getComputedStyle(element);

        return style.display !== 'none' &&
            style.visibility !== 'hidden' &&
            element.getClientRects().length > 0;
    }

    function firstVisible(selectors) {
        const elements = document.querySelectorAll(selectors);

        for (const element of elements) {
            if (isVisible(element)) {
                return element;
            }
        }

        return null;
    }

    function validSide(value) {
        return ['top', 'right', 'bottom', 'left'].includes(value)
            ? value
            : 'bottom';
    }

    function validAlign(value) {
        return ['start', 'center', 'end'].includes(value)
            ? value
            : 'center';
    }

    function addGeneralStep(
        steps,
        selectors,
        title,
        description,
        side,
        align
    ) {
        const element = firstVisible(selectors);

        if (!element) {
            return;
        }

        steps.push({
            element: element,
            popover: {
                title: title,
                description: description,
                side: side || 'right',
                align: align || 'center',
            },
        });
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
            'Desde aquí identificas la plataforma y puedes regresar al panel principal.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/dashboard"], .nav-sidebar a[href$="dashboard"]',
            'Panel de Control',
            'Consulta el resumen general y los indicadores principales del sistema.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/inventario"], .nav-sidebar a[href$="inventario"]',
            'Inventario',
            'Registra, consulta y administra los bienes institucionales.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/resguardante"], .nav-sidebar a[href$="resguardante"]',
            'Resguardantes',
            'Administra a las personas responsables de los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/marcas"], .nav-sidebar a[href$="marcas"]',
            'Marcas',
            'Gestiona el catálogo de marcas utilizadas en el inventario.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/puestos"], .nav-sidebar a[href$="puestos"]',
            'Puestos',
            'Administra los puestos institucionales de los resguardantes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/areadeasignacion"], .nav-sidebar a[href$="areadeasignacion"]',
            'Áreas de asignación',
            'Organiza las áreas donde se asignan los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href$="/ubicacionfisica"], .nav-sidebar a[href$="ubicacionfisica"]',
            'Ubicaciones físicas',
            'Controla los edificios, oficinas y espacios donde se encuentran los bienes.',
            'right'
        );

        addGeneralStep(
            steps,
            '.navbar-nav .user-menu, .user-menu',
            'Cuenta de usuario',
            'Desde aquí puedes consultar las opciones de tu cuenta y cerrar sesión.',
            'bottom',
            'end'
        );

        addGeneralStep(
            steps,
            '.nav-sidebar a[href="#tutorial-general"], .nav-sidebar a[href$="#tutorial-general"]',
            'Tutorial general',
            'Desde esta opción puedes repetir el recorrido cuando lo necesites.',
            'right'
        );

        steps.push({
            popover: {
                title: 'Recorrido finalizado',
                description:
                    'Ya conoces las secciones principales de INTEVI. Cada módulo también cuenta con su propio tutorial.',
                side: 'bottom',
                align: 'center',
            },
        });

        return steps;
    }

    function buildModuleSteps() {
        return Array.from(
            document.querySelectorAll('[data-tour-step]')
        )
            .filter(isVisible)
            .sort(function (first, second) {
                return Number(first.dataset.tourOrder || 0) -
                    Number(second.dataset.tourOrder || 0);
            })
            .map(function (element, index) {
                return {
                    element: element,
                    popover: {
                        title:
                            element.dataset.tourTitle ||
                            'Paso ' + (index + 1),
                        description:
                            element.dataset.tourDescription ||
                            'Conoce esta sección del sistema.',
                        side: validSide(
                            element.dataset.tourSide
                        ),
                        align: validAlign(
                            element.dataset.tourAlign
                        ),
                    },
                };
            });
    }

    function destroyActiveTour(saveStatus) {
        if (!activeDriver) {
            return;
        }

        activeTourMaySave = Boolean(saveStatus);

        try {
            activeDriver.destroy();
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible cerrar el tutorial.',
                error
            );
            activeDriver = null;
        }
    }

    function createDriverConfig(steps, name, version) {
        return {
            steps: steps,
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
            popoverClass: 'intevi-driver-popover',
            onCloseClick: function (element, step, options) {
                activeTourMaySave = true;
                options.driver.destroy();
            },
            onDoneClick: function (element, step, options) {
                activeTourMaySave = true;
                options.driver.destroy();
            },
            onDestroyed: function () {
                if (activeTourMaySave) {
                    markSeen(name, version);
                }

                activeTourMaySave = false;
                activeDriver = null;
            },
        };
    }

    async function startTour(name, version, steps, force) {
        if (!Array.isArray(steps) || steps.length === 0) {
            console.warn(
                'INTEVI: el tutorial no tiene pasos visibles:',
                name
            );
            return false;
        }

        if (!force && hasSeen(name, version)) {
            return false;
        }

        try {
            const createDriver = await waitForDriver(0);

            destroyActiveTour(false);
            activeTourMaySave = false;

            activeDriver = createDriver(
                createDriverConfig(steps, name, version)
            );

            activeDriver.drive();

            console.log(
                '✅ INTEVI: tutorial iniciado:',
                name,
                'versión',
                version
            );

            return true;
        } catch (error) {
            console.error(
                'INTEVI: no se pudo iniciar el tutorial.',
                error
            );
            return false;
        }
    }

    function startGeneral(force) {
        const config = getPageConfig();
        const version = config ? config.generalVersion : 1;

        if (window.innerWidth >= 992) {
            document.body.classList.remove('sidebar-collapse');
        }

        window.setTimeout(function () {
            startTour(
                'general',
                version,
                buildGeneralSteps(),
                Boolean(force)
            );
        }, 250);
    }

    function startCurrent(force) {
        const config = getPageConfig();

        if (!config || !config.page) {
            console.warn(
                'INTEVI: falta data-tour-page en la vista.'
            );
            return;
        }

        startTour(
            'module:' + config.page,
            config.version,
            buildModuleSteps(),
            Boolean(force)
        );
    }

    function boot() {
        const config = getPageConfig();

        if (!config || !config.autostart || activeDriver) {
            return;
        }

        if (config.general) {
            startGeneral(false);
            return;
        }

        startCurrent(false);
    }

    function scheduleBoot() {
        window.clearTimeout(bootTimer);
        bootTimer = window.setTimeout(boot, 650);
    }

    document.addEventListener(
        'click',
        function (event) {
            const rawTarget = event.target;
            const target = rawTarget instanceof Element
                ? rawTarget
                : rawTarget && rawTarget.parentElement;

            if (!target) {
                return;
            }

            const generalTrigger = target.closest(
                'a[href="#tutorial-general"], a[href$="#tutorial-general"], [data-intevi-global-tour]'
            );

            if (generalTrigger) {
                event.preventDefault();
                event.stopImmediatePropagation();
                startGeneral(true);
                return;
            }

            const moduleTrigger = target.closest(
                '[data-tour-start]'
            );

            if (moduleTrigger) {
                event.preventDefault();

                const requested = String(
                    moduleTrigger.dataset.tourStart || ''
                ).toLowerCase();

                if (requested === 'general') {
                    startGeneral(true);
                } else {
                    /*
                     * También acepta data-tour-start sin valor,
                     * que es como están tus vistas actuales.
                     */
                    startCurrent(true);
                }
                return;
            }

            const resetTrigger = target.closest(
                '[data-tour-reset]'
            );

            if (!resetTrigger) {
                return;
            }

            event.preventDefault();

            const config = getPageConfig();
            const resetType = String(
                resetTrigger.dataset.tourReset || 'current'
            ).toLowerCase();

            if (resetType === 'all') {
                resetAllTours();
            } else if (config && config.general) {
                resetTour('general', config.generalVersion);
            } else if (config) {
                resetTour(
                    'module:' + config.page,
                    config.version
                );
            }

            scheduleBoot();
        },
        true
    );

    document.addEventListener(
        'livewire:navigating',
        function () {
            destroyActiveTour(false);
        }
    );

    document.addEventListener(
        'livewire:navigated',
        scheduleBoot
    );

    document.addEventListener(
        'livewire:initialized',
        scheduleBoot
    );

    window.INTEVITour = {
        start: function () {
            startCurrent(true);
        },
        current: function () {
            startCurrent(true);
        },
        general: function () {
            startGeneral(true);
        },
        reset: function () {
            const config = getPageConfig();

            if (!config) {
                return;
            }

            if (config.general) {
                resetTour('general', config.generalVersion);
                startGeneral(true);
            } else {
                resetTour(
                    'module:' + config.page,
                    config.version
                );
                startCurrent(true);
            }
        },
        resetAll: function () {
            resetAllTours();
        },
        status: function () {
            return {
                driverLoaded: Boolean(getDriverFactory()),
                markerFound: Boolean(getMarker()),
                config: getPageConfig(),
                active: Boolean(activeDriver),
            };
        },
    };

    console.log(
        '✅ INTEVI: controlador único de tutoriales cargado.'
    );

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            scheduleBoot,
            { once: true }
        );
    } else {
        scheduleBoot();
    }
})();
