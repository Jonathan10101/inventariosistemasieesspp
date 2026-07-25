(function () {
    'use strict';

    /**
     * INTEVI - Controlador único de tutoriales.
     *
     * Este archivo controla:
     * - El tutorial general del sistema.
     * - Los tutoriales específicos de cada módulo.
     * - El inicio automático una sola vez.
     * - El inicio manual desde botones o desde el menú.
     * - La compatibilidad con Livewire.
     *
     * IMPORTANTE:
     * No cargues otro archivo de tutoriales junto con este.
     */

    const STORAGE_PREFIX = 'intevi:tour';
    const DEFAULT_VERSION = 1;
    const BOOT_DELAY_MS = 500;

    let activeDriver = null;
    let bootTimer = null;

    /**
     * Obtiene Driver.js desde la versión IIFE cargada por CDN.
     */
    function getDriverFactory() {
        return window.driver &&
            window.driver.js &&
            typeof window.driver.js.driver === 'function'
            ? window.driver.js.driver
            : null;
    }

    /**
     * Normaliza textos utilizados como identificadores.
     */
    function normalizeName(value) {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/\s+/g, '-');
    }

    /**
     * Devuelve el marcador de tutorial presente en la vista.
     *
     * Ejemplo:
     * <div
     *   data-tour-page="inventario"
     *   data-tour-version="1"
     *   data-tour-autostart="true"
     *   hidden
     * ></div>
     */
    function getPageMarker() {
        return document.querySelector('[data-tour-page]');
    }

    /**
     * Lee la configuración declarada por la vista.
     */
    function getPageConfig() {
        const marker = getPageMarker();

        if (!marker) {
            return null;
        }

        const parsedVersion = Number.parseInt(
            marker.dataset.tourVersion || String(DEFAULT_VERSION),
            10
        );

        return {
            page: normalizeName(marker.dataset.tourPage),
            version: Number.isFinite(parsedVersion) && parsedVersion > 0
                ? parsedVersion
                : DEFAULT_VERSION,
            autostart: marker.dataset.tourAutostart !== 'false',
        };
    }

    /**
     * Detecta el dashboard sin obligarte a agregar otro marcador especial.
     */
    function isDashboardPage() {
        const path = window.location.pathname
            .replace(/\/+$/, '')
            .toLowerCase();

        const config = getPageConfig();

        return path === '/dashboard' ||
            path.endsWith('/dashboard') ||
            config?.page === 'dashboard';
    }

    /**
     * Crea una llave separada por dominio, tutorial y versión.
     */
    function getStorageKey(tourName, version) {
        return [
            STORAGE_PREFIX,
            window.location.host,
            normalizeName(tourName),
            `v${version}`,
        ].join(':');
    }

    /**
     * Consulta si un tutorial ya fue visto o cerrado.
     */
    function hasSeenTour(tourName, version) {
        return localStorage.getItem(
            getStorageKey(tourName, version)
        ) !== null;
    }

    /**
     * Guarda el estado del tutorial.
     */
    function saveTourStatus(tourName, version, status) {
        localStorage.setItem(
            getStorageKey(tourName, version),
            JSON.stringify({
                status,
                savedAt: new Date().toISOString(),
            })
        );
    }

    /**
     * Determina si un elemento se puede destacar.
     */
    function isVisible(element) {
        if (!(element instanceof Element)) {
            return false;
        }

        const style = window.getComputedStyle(element);

        return style.display !== 'none' &&
            style.visibility !== 'hidden' &&
            element.getClientRects().length > 0;
    }

    /**
     * Devuelve el primer elemento visible de una lista de selectores.
     */
    function findFirstVisible(selectors) {
        for (const selector of selectors) {
            const element = document.querySelector(selector);

            if (isVisible(element)) {
                return element;
            }
        }

        return null;
    }

    /**
     * Crea un paso opcional del tutorial general.
     *
     * Si el elemento no existe por permisos, rol o vista,
     * simplemente no se agrega y el tutorial continúa.
     */
    function optionalStep({
        selectors,
        title,
        description,
        side = 'right',
        align = 'start',
    }) {
        const element = findFirstVisible(selectors);

        if (!element) {
            return null;
        }

        return {
            element,
            popover: {
                title,
                description,
                side,
                align,
            },
        };
    }

    /**
     * Tutorial general de INTEVI.
     *
     * Los selectores corresponden directamente a las URL
     * configuradas en config/adminlte.php.
     */
    function buildGeneralSteps() {
        return [
            {
                popover: {
                    title: 'Bienvenido a INTEVI',
                    description:
                        'Conoce las principales secciones del sistema de inventario y resguardos institucionales.',
                    side: 'bottom',
                    align: 'center',
                },
            },

            optionalStep({
                selectors: ['.brand-link'],
                title: 'INTEVI',
                description:
                    'Este es el acceso principal del sistema. Desde aquí puedes identificar la plataforma y volver al inicio.',
                side: 'bottom',
                align: 'center',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/dashboard"]',
                    '.nav-sidebar a[href*="/dashboard"]',
                ],
                title: 'Panel de Control',
                description:
                    'Aquí puedes consultar el resumen general, indicadores y actividad reciente del sistema.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/inventario"]',
                    '.nav-sidebar a[href*="/inventario"]',
                ],
                title: 'Inventario',
                description:
                    'Administra los bienes, equipos, números de serie, características y documentos asociados.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/resguardante"]',
                    '.nav-sidebar a[href*="/resguardante"]',
                ],
                title: 'Resguardantes',
                description:
                    'Registra y consulta a las personas responsables de los bienes institucionales.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/marcas"]',
                    '.nav-sidebar a[href*="/marcas"]',
                ],
                title: 'Marcas',
                description:
                    'Administra el catálogo de fabricantes y marcas utilizadas en el inventario.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/puestos"]',
                    '.nav-sidebar a[href*="/puestos"]',
                ],
                title: 'Puestos',
                description:
                    'Administra el catálogo de puestos asignados a los resguardantes.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/areadeasignacion"]',
                    '.nav-sidebar a[href*="/areadeasignacion"]',
                ],
                title: 'Áreas de asignación',
                description:
                    'Organiza los bienes de acuerdo con el área institucional que los utiliza.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href$="/ubicacionfisica"]',
                    '.nav-sidebar a[href*="/ubicacionfisica"]',
                ],
                title: 'Ubicaciones físicas',
                description:
                    'Consulta y administra los espacios físicos donde se encuentran los bienes.',
            }),

            optionalStep({
                selectors: [
                    '.nav-sidebar a[href*="/pulse"]',
                ],
                title: 'Monitor de sistema',
                description:
                    'Los usuarios autorizados pueden consultar información técnica y de rendimiento del sistema.',
            }),

            {
                popover: {
                    title: 'Tutorial terminado',
                    description:
                        'Cada módulo puede mostrar su propio tutorial. También puedes abrir nuevamente el tutorial general desde el menú lateral.',
                    side: 'bottom',
                    align: 'center',
                },
            },
        ].filter(Boolean);
    }

    /**
     * Valores permitidos por Driver.js.
     */
    function normalizeSide(value) {
        return ['top', 'right', 'bottom', 'left'].includes(value)
            ? value
            : 'bottom';
    }

    function normalizeAlign(value) {
        return ['start', 'center', 'end'].includes(value)
            ? value
            : 'start';
    }

    /**
     * Construye automáticamente el tutorial del módulo actual
     * con los elementos data-tour-step existentes en la vista.
     */
    function buildModuleSteps() {
        return Array.from(
            document.querySelectorAll('[data-tour-step]')
        )
            .filter(isVisible)
            .sort((first, second) => {
                const firstOrder = Number.parseInt(
                    first.dataset.tourOrder || '9999',
                    10
                );

                const secondOrder = Number.parseInt(
                    second.dataset.tourOrder || '9999',
                    10
                );

                return firstOrder - secondOrder;
            })
            .map((element, index) => ({
                element,
                popover: {
                    title:
                        element.dataset.tourTitle ||
                        `Paso ${index + 1}`,
                    description:
                        element.dataset.tourDescription ||
                        'Conoce esta función del módulo.',
                    side: normalizeSide(
                        element.dataset.tourSide || 'bottom'
                    ),
                    align: normalizeAlign(
                        element.dataset.tourAlign || 'start'
                    ),
                },
            }));
    }

    /**
     * Abre el menú lateral antes del tutorial general.
     */
    function prepareSidebar() {
        if (window.innerWidth >= 992) {
            document.body.classList.remove('sidebar-collapse');
        }
    }

    /**
     * Destruye cualquier tutorial que esté activo.
     */
    function destroyActiveTour() {
        if (
            activeDriver &&
            typeof activeDriver.isActive === 'function' &&
            activeDriver.isActive()
        ) {
            activeDriver.destroy();
        }

        activeDriver = null;
    }

    /**
     * Inicia un tutorial.
     */
    function startTour({
        name,
        version,
        steps,
        force = false,
    }) {
        const driverFactory = getDriverFactory();

        if (!driverFactory) {
            console.error(
                '[INTEVI TOUR] Driver.js no se encuentra cargado.'
            );
            return;
        }

        if (!Array.isArray(steps) || steps.length === 0) {
            console.warn(
                `[INTEVI TOUR] El tutorial "${name}" no tiene pasos visibles.`
            );
            return;
        }

        if (!force && hasSeenTour(name, version)) {
            return;
        }

        destroyActiveTour();

        let statusWasSaved = false;

        activeDriver = driverFactory({
            steps,
            animate: true,
            smoothScroll: true,
            allowClose: true,
            overlayOpacity: 0.72,
            overlayColor: '#000000',
            stagePadding: 8,
            stageRadius: 8,
            popoverOffset: 12,
            showProgress: true,
            progressText: 'Paso {{current}} de {{total}}',
            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            doneBtnText: 'Finalizar',
            popoverClass: 'intevi-driver-popover',

            onCloseClick: (
                element,
                step,
                options
            ) => {
                statusWasSaved = true;
                saveTourStatus(name, version, 'dismissed');
                options.driver.destroy();
            },

            onDoneClick: (
                element,
                step,
                options
            ) => {
                statusWasSaved = true;
                saveTourStatus(name, version, 'completed');
                options.driver.destroy();
            },

            onDestroyed: () => {
                if (!statusWasSaved) {
                    saveTourStatus(name, version, 'dismissed');
                }

                activeDriver = null;
            },
        });

        activeDriver.drive();
    }

    /**
     * Inicia el tutorial general.
     */
    function startGeneralTour(force = false) {
        prepareSidebar();

        startTour({
            name: 'general',
            version: DEFAULT_VERSION,
            steps: buildGeneralSteps(),
            force,
        });
    }

    /**
     * Inicia el tutorial del módulo actual.
     */
    function startCurrentModuleTour(force = false) {
        const config = getPageConfig();

        if (!config?.page) {
            console.warn(
                '[INTEVI TOUR] Esta vista no tiene data-tour-page.'
            );
            return;
        }

        startTour({
            name: `module:${config.page}`,
            version: config.version,
            steps: buildModuleSteps(),
            force,
        });
    }

    /**
     * Inicio automático.
     *
     * Prioridad:
     * 1. En dashboard se ejecuta el tutorial general.
     * 2. En las demás páginas se ejecuta el tutorial del módulo.
     */
    function boot() {
        const config = getPageConfig();

        if (isDashboardPage()) {
            startGeneralTour(false);
            return;
        }

        if (!config || !config.autostart || !config.page) {
            return;
        }

        const steps = buildModuleSteps();

        if (steps.length === 0) {
            return;
        }

        startTour({
            name: `module:${config.page}`,
            version: config.version,
            steps,
            force: false,
        });
    }

    /**
     * Evita dobles ejecuciones por DOMContentLoaded y Livewire.
     */
    function scheduleBoot() {
        window.clearTimeout(bootTimer);

        bootTimer = window.setTimeout(
            boot,
            BOOT_DELAY_MS
        );
    }

    /**
     * Reinicia el tutorial actual.
     */
    function resetCurrentTour() {
        if (isDashboardPage()) {
            localStorage.removeItem(
                getStorageKey('general', DEFAULT_VERSION)
            );
            return;
        }

        const config = getPageConfig();

        if (!config?.page) {
            return;
        }

        localStorage.removeItem(
            getStorageKey(
                `module:${config.page}`,
                config.version
            )
        );
    }

    /**
     * Reinicia todos los tutoriales del dominio actual.
     */
    function resetAllTours() {
        const prefix = [
            STORAGE_PREFIX,
            window.location.host,
        ].join(':');

        const keys = [];

        for (let index = 0; index < localStorage.length; index++) {
            const key = localStorage.key(index);

            if (key && key.startsWith(prefix)) {
                keys.push(key);
            }
        }

        keys.forEach((key) => localStorage.removeItem(key));
    }

    /**
     * Inicio manual:
     *
     * Menú general:
     * href="#tutorial-general"
     *
     * Botón del módulo:
     * data-tour-start="current"
     *
     * Botón general:
     * data-tour-start="general"
     */
    document.addEventListener('click', (event) => {
        const generalMenuLink = event.target.closest(
            'a[href="#tutorial-general"], a[href$="#tutorial-general"]'
        );

        if (generalMenuLink) {
            event.preventDefault();
            startGeneralTour(true);
            return;
        }

        const startButton = event.target.closest(
            '[data-tour-start]'
        );

        if (startButton) {
            event.preventDefault();

            if (startButton.dataset.tourStart === 'general') {
                startGeneralTour(true);
                return;
            }

            if (startButton.dataset.tourStart === 'current') {
                startCurrentModuleTour(true);
                return;
            }
        }

        const resetButton = event.target.closest(
            '[data-tour-reset]'
        );

        if (!resetButton) {
            return;
        }

        event.preventDefault();

        if (resetButton.dataset.tourReset === 'all') {
            resetAllTours();
            scheduleBoot();
            return;
        }

        resetCurrentTour();
        scheduleBoot();
    });

    /**
     * API pública para pruebas desde la consola.
     */
    window.InteviTour = {
        boot: scheduleBoot,
        startGeneral: () => startGeneralTour(true),
        startCurrent: () => startCurrentModuleTour(true),
        resetCurrent: resetCurrentTour,
        resetAll: resetAllTours,
    };

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            scheduleBoot,
            { once: true }
        );
    } else {
        scheduleBoot();
    }

    document.addEventListener(
        'livewire:initialized',
        scheduleBoot
    );

    document.addEventListener(
        'livewire:navigated',
        scheduleBoot
    );
})();
