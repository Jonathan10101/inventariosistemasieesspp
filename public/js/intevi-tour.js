(function () {
    'use strict';

    /**
     * INTEVI TOUR
     * Tutorial completamente local, sin Driver.js, CDN, Vite ni dependencias externas.
     */

    const STORAGE_PREFIX = 'intevi:tour';
    const DEFAULT_VERSION = 1;
    const START_DELAY_MS = 650;
    const MOBILE_BREAKPOINT = 680;
    const HIGHLIGHT_PADDING = 8;

    let activeTour = null;
    let bootTimer = null;

    function normalizeName(value) {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/\s+/g, '-');
    }

    function parseVersion(value, fallback = DEFAULT_VERSION) {
        const version = Number.parseInt(value, 10);
        return Number.isFinite(version) && version > 0 ? version : fallback;
    }

    function getMarker() {
        return document.querySelector('[data-tour-page]');
    }

    function getPageConfig() {
        const marker = getMarker();

        if (!marker) {
            return null;
        }

        return {
            marker,
            page: normalizeName(marker.dataset.tourPage),
            version: parseVersion(marker.dataset.tourVersion),
            general: marker.dataset.tourGeneral === 'true',
            generalVersion: parseVersion(
                marker.dataset.tourGeneralVersion || marker.dataset.tourVersion
            ),
            autostart: marker.dataset.tourAutostart !== 'false',
        };
    }

    function isDashboard() {
        const path = window.location.pathname
            .replace(/\/+$/, '')
            .toLowerCase();
        const config = getPageConfig();

        return path === '/dashboard' ||
            path.endsWith('/dashboard') ||
            config?.page === 'dashboard';
    }

    function storageKey(name, version) {
        return [
            STORAGE_PREFIX,
            window.location.host,
            normalizeName(name),
            `v${version}`,
        ].join(':');
    }

    function hasSeen(name, version) {
        try {
            return localStorage.getItem(storageKey(name, version)) !== null;
        } catch (error) {
            console.warn('[INTEVI TOUR] No se pudo consultar localStorage.', error);
            return false;
        }
    }

    function saveStatus(name, version, status) {
        try {
            localStorage.setItem(
                storageKey(name, version),
                JSON.stringify({ status, savedAt: new Date().toISOString() })
            );
        } catch (error) {
            console.warn('[INTEVI TOUR] No se pudo guardar el estado.', error);
        }
    }

    function removeStatus(name, version) {
        try {
            localStorage.removeItem(storageKey(name, version));
        } catch (error) {
            console.warn('[INTEVI TOUR] No se pudo reiniciar el tutorial.', error);
        }
    }

    function isVisible(element) {
        if (!(element instanceof Element)) {
            return false;
        }

        const style = window.getComputedStyle(element);
        return style.display !== 'none' &&
            style.visibility !== 'hidden' &&
            element.getClientRects().length > 0;
    }

    function findVisible(selectors) {
        for (const selector of selectors) {
            const element = document.querySelector(selector);

            if (isVisible(element)) {
                return element;
            }
        }

        return null;
    }

    function optionalStep(selectors, title, description, side = 'right', align = 'start') {
        const element = findVisible(selectors);

        if (!element) {
            return null;
        }

        return {
            element,
            title,
            description,
            side,
            align,
        };
    }

    function buildGeneralSteps() {
        return [
            {
                element: null,
                title: 'Bienvenido a INTEVI',
                description:
                    'Conoce las principales secciones del sistema de inventario y resguardo institucional.',
                side: 'center',
                align: 'center',
            },
            optionalStep(
                ['.brand-link'],
                'INTEVI',
                'Este es el acceso principal y la identidad de la plataforma.',
                'bottom',
                'center'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/dashboard"]', '.nav-sidebar a[href*="dashboard"]'],
                'Panel de Control',
                'Aquí puedes consultar el resumen general y los indicadores principales del sistema.'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/inventario"]', '.nav-sidebar a[href*="inventario"]'],
                'Inventario',
                'Registra y administra bienes, equipos, números de serie y documentos asociados.'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/resguardante"]', '.nav-sidebar a[href*="resguardante"]'],
                'Resguardantes',
                'Administra a las personas responsables de los bienes institucionales.'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/marcas"]', '.nav-sidebar a[href*="marcas"]'],
                'Marcas',
                'Consulta y administra el catálogo de marcas utilizadas en el inventario.'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/puestos"]', '.nav-sidebar a[href*="puestos"]'],
                'Puestos',
                'Administra los puestos correspondientes a los resguardantes.'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/areadeasignacion"]', '.nav-sidebar a[href*="areadeasignacion"]'],
                'Áreas de asignación',
                'Organiza los bienes según el área institucional que los utiliza.'
            ),
            optionalStep(
                ['.nav-sidebar a[href$="/ubicacionfisica"]', '.nav-sidebar a[href*="ubicacionfisica"]'],
                'Ubicaciones físicas',
                'Administra los edificios, oficinas y espacios donde se encuentran los bienes.'
            ),
            {
                element: null,
                title: 'Tutorial terminado',
                description:
                    'Puedes volver a abrir este recorrido desde Tutorial general en el menú lateral.',
                side: 'center',
                align: 'center',
            },
        ].filter(Boolean);
    }

    function normalizeSide(value) {
        return ['top', 'right', 'bottom', 'left', 'center'].includes(value)
            ? value
            : 'bottom';
    }

    function normalizeAlign(value) {
        return ['start', 'center', 'end'].includes(value)
            ? value
            : 'start';
    }

    function buildModuleSteps() {
        return Array.from(document.querySelectorAll('[data-tour-step]'))
            .filter(isVisible)
            .sort((a, b) => {
                const orderA = Number.parseInt(a.dataset.tourOrder || '9999', 10);
                const orderB = Number.parseInt(b.dataset.tourOrder || '9999', 10);
                return orderA - orderB;
            })
            .map((element, index) => ({
                element,
                title: element.dataset.tourTitle || `Paso ${index + 1}`,
                description:
                    element.dataset.tourDescription ||
                    'Conoce esta función del módulo.',
                side: normalizeSide(element.dataset.tourSide || 'bottom'),
                align: normalizeAlign(element.dataset.tourAlign || 'start'),
            }));
    }

    function prepareSidebar() {
        if (window.innerWidth >= 992) {
            document.body.classList.remove('sidebar-collapse');
        }
    }

    function clamp(value, min, max) {
        return Math.min(Math.max(value, min), max);
    }

    class InteviGuidedTour {
        constructor({ name, version, steps }) {
            this.name = name;
            this.version = version;
            this.steps = steps;
            this.index = 0;
            this.destroyed = false;
            this.elements = {};
            this.originalOverflow = '';

            this.onResize = this.position.bind(this);
            this.onScroll = this.position.bind(this);
            this.onKeyDown = this.handleKeyDown.bind(this);
        }

        start() {
            this.createElements();
            this.bindEvents();
            document.body.classList.add('intevi-tour-active');
            this.show(0);
        }

        createElements() {
            const overlay = document.createElement('div');
            overlay.className = 'intevi-tour-overlay';
            overlay.setAttribute('aria-hidden', 'true');

            const highlight = document.createElement('div');
            highlight.className = 'intevi-tour-highlight';
            highlight.setAttribute('aria-hidden', 'true');

            const popover = document.createElement('section');
            popover.className = 'intevi-tour-popover';
            popover.setAttribute('role', 'dialog');
            popover.setAttribute('aria-modal', 'true');
            popover.setAttribute('aria-labelledby', 'intevi-tour-title');
            popover.innerHTML = `
                <button type="button" class="intevi-tour-close" aria-label="Cerrar tutorial">&times;</button>
                <div class="intevi-tour-progress"></div>
                <h2 id="intevi-tour-title" class="intevi-tour-title"></h2>
                <div class="intevi-tour-description"></div>
                <div class="intevi-tour-footer">
                    <button type="button" class="intevi-tour-button intevi-tour-prev">Anterior</button>
                    <button type="button" class="intevi-tour-button intevi-tour-next">Siguiente</button>
                </div>
            `;

            document.body.appendChild(overlay);
            document.body.appendChild(highlight);
            document.body.appendChild(popover);

            this.elements = {
                overlay,
                highlight,
                popover,
                close: popover.querySelector('.intevi-tour-close'),
                progress: popover.querySelector('.intevi-tour-progress'),
                title: popover.querySelector('.intevi-tour-title'),
                description: popover.querySelector('.intevi-tour-description'),
                previous: popover.querySelector('.intevi-tour-prev'),
                next: popover.querySelector('.intevi-tour-next'),
            };
        }

        bindEvents() {
            this.elements.close.addEventListener('click', () => this.close('dismissed'));
            this.elements.previous.addEventListener('click', () => this.previous());
            this.elements.next.addEventListener('click', () => this.next());
            window.addEventListener('resize', this.onResize);
            window.addEventListener('scroll', this.onScroll, true);
            document.addEventListener('keydown', this.onKeyDown);
        }

        unbindEvents() {
            window.removeEventListener('resize', this.onResize);
            window.removeEventListener('scroll', this.onScroll, true);
            document.removeEventListener('keydown', this.onKeyDown);
        }

        handleKeyDown(event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                this.close('dismissed');
                return;
            }

            if (event.key === 'ArrowRight' || event.key === 'Enter') {
                event.preventDefault();
                this.next();
                return;
            }

            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                this.previous();
            }
        }

        show(index) {
            if (this.destroyed) {
                return;
            }

            this.index = clamp(index, 0, this.steps.length - 1);
            const step = this.steps[this.index];

            this.elements.progress.textContent =
                `Paso ${this.index + 1} de ${this.steps.length}`;
            this.elements.title.textContent = step.title;
            this.elements.description.textContent = step.description;
            this.elements.previous.disabled = this.index === 0;
            this.elements.previous.hidden = this.index === 0;
            this.elements.next.textContent =
                this.index === this.steps.length - 1 ? 'Finalizar' : 'Siguiente';

            if (step.element && isVisible(step.element)) {
                const rect = step.element.getBoundingClientRect();
                const outsideViewport =
                    rect.top < 15 ||
                    rect.bottom > window.innerHeight - 15;

                if (outsideViewport) {
                    step.element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest',
                    });
                    window.setTimeout(() => this.position(), 320);
                }
            }

            this.position();
            this.elements.next.focus({ preventScroll: true });
        }

        position() {
            if (this.destroyed) {
                return;
            }

            const step = this.steps[this.index];
            const { overlay, highlight, popover } = this.elements;

            if (!step.element || !isVisible(step.element)) {
                overlay.classList.add('is-visible');
                highlight.classList.remove('is-visible');
                popover.classList.add('is-centered');
                popover.style.left = '50%';
                popover.style.top = '50%';
                return;
            }

            overlay.classList.remove('is-visible');
            popover.classList.remove('is-centered');

            const rect = step.element.getBoundingClientRect();
            const top = Math.max(4, rect.top - HIGHLIGHT_PADDING);
            const left = Math.max(4, rect.left - HIGHLIGHT_PADDING);
            const width = Math.min(
                window.innerWidth - left - 4,
                rect.width + HIGHLIGHT_PADDING * 2
            );
            const height = Math.min(
                window.innerHeight - top - 4,
                rect.height + HIGHLIGHT_PADDING * 2
            );

            highlight.style.top = `${top}px`;
            highlight.style.left = `${left}px`;
            highlight.style.width = `${Math.max(width, 1)}px`;
            highlight.style.height = `${Math.max(height, 1)}px`;
            highlight.classList.add('is-visible');

            if (window.innerWidth <= MOBILE_BREAKPOINT) {
                popover.style.left = '12px';
                popover.style.top = 'auto';
                popover.style.bottom = '12px';
                popover.style.width = 'calc(100vw - 24px)';
                return;
            }

            popover.style.bottom = 'auto';
            popover.style.width = '';

            const gap = 16;
            const popoverRect = popover.getBoundingClientRect();
            const popoverWidth = popoverRect.width || 360;
            const popoverHeight = popoverRect.height || 220;
            const side = normalizeSide(step.side);
            let popoverTop;
            let popoverLeft;

            if (side === 'left') {
                popoverTop = top + (height - popoverHeight) / 2;
                popoverLeft = left - popoverWidth - gap;
            } else if (side === 'top') {
                popoverTop = top - popoverHeight - gap;
                popoverLeft = left + (width - popoverWidth) / 2;
            } else if (side === 'bottom') {
                popoverTop = top + height + gap;
                popoverLeft = left + (width - popoverWidth) / 2;
            } else {
                popoverTop = top + (height - popoverHeight) / 2;
                popoverLeft = left + width + gap;
            }

            if (popoverLeft < 12 || popoverLeft + popoverWidth > window.innerWidth - 12) {
                popoverLeft = clamp(
                    left + (width - popoverWidth) / 2,
                    12,
                    window.innerWidth - popoverWidth - 12
                );
            }

            if (popoverTop < 12 || popoverTop + popoverHeight > window.innerHeight - 12) {
                const below = top + height + gap;
                const above = top - popoverHeight - gap;
                popoverTop = below + popoverHeight <= window.innerHeight - 12
                    ? below
                    : Math.max(12, above);
            }

            popover.style.left = `${clamp(
                popoverLeft,
                12,
                window.innerWidth - popoverWidth - 12
            )}px`;
            popover.style.top = `${clamp(
                popoverTop,
                12,
                window.innerHeight - popoverHeight - 12
            )}px`;
        }

        previous() {
            if (this.index > 0) {
                this.show(this.index - 1);
            }
        }

        next() {
            if (this.index >= this.steps.length - 1) {
                this.close('completed');
                return;
            }

            this.show(this.index + 1);
        }

        close(status) {
            saveStatus(this.name, this.version, status);
            this.destroy();
        }

        destroy() {
            if (this.destroyed) {
                return;
            }

            this.destroyed = true;
            this.unbindEvents();
            document.body.classList.remove('intevi-tour-active');

            Object.values(this.elements).forEach((element) => {
                if (element instanceof Element && element.parentNode) {
                    if (
                        element === this.elements.overlay ||
                        element === this.elements.highlight ||
                        element === this.elements.popover
                    ) {
                        element.remove();
                    }
                }
            });

            activeTour = null;
        }
    }

    function destroyActive() {
        if (activeTour) {
            activeTour.destroy();
        }
    }

    function startTour({ name, version, steps, force = false }) {
        if (!Array.isArray(steps) || steps.length === 0) {
            console.warn(`[INTEVI TOUR] "${name}" no tiene pasos visibles.`);
            return false;
        }

        if (!force && hasSeen(name, version)) {
            console.info(`[INTEVI TOUR] "${name}" versión ${version} ya fue visto.`);
            return false;
        }

        destroyActive();
        activeTour = new InteviGuidedTour({ name, version, steps });
        activeTour.start();
        console.info(`[INTEVI TOUR] Iniciado: ${name}, versión ${version}.`);
        return true;
    }

    function startGeneral(force = false) {
        const config = getPageConfig();
        prepareSidebar();

        window.setTimeout(() => {
            startTour({
                name: 'general',
                version: config?.generalVersion || DEFAULT_VERSION,
                steps: buildGeneralSteps(),
                force,
            });
        }, 120);
    }

    function startCurrent(force = false) {
        const config = getPageConfig();

        if (!config?.page) {
            console.warn('[INTEVI TOUR] La vista no tiene data-tour-page.');
            return;
        }

        startTour({
            name: `module:${config.page}`,
            version: config.version,
            steps: buildModuleSteps(),
            force,
        });
    }

    function boot() {
        const config = getPageConfig();

        if (!config || !config.autostart || activeTour) {
            return;
        }

        if (config.general || isDashboard()) {
            startGeneral(false);
            return;
        }

        const steps = buildModuleSteps();

        if (steps.length > 0) {
            startTour({
                name: `module:${config.page}`,
                version: config.version,
                steps,
                force: false,
            });
        }
    }

    function scheduleBoot() {
        window.clearTimeout(bootTimer);
        bootTimer = window.setTimeout(boot, START_DELAY_MS);
    }

    function resetCurrent() {
        const config = getPageConfig();

        if (config?.general || isDashboard()) {
            removeStatus('general', config?.generalVersion || DEFAULT_VERSION);
            return;
        }

        if (config?.page) {
            removeStatus(`module:${config.page}`, config.version);
        }
    }

    function resetAll() {
        const prefix = `${STORAGE_PREFIX}:${window.location.host}:`;
        const keys = [];

        try {
            for (let index = 0; index < localStorage.length; index++) {
                const key = localStorage.key(index);

                if (key && key.startsWith(prefix)) {
                    keys.push(key);
                }
            }

            keys.forEach((key) => localStorage.removeItem(key));
        } catch (error) {
            console.warn('[INTEVI TOUR] No se pudieron reiniciar los tutoriales.', error);
        }
    }

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element
            ? event.target
            : event.target?.parentElement;

        if (!target) {
            return;
        }

        const generalLink = target.closest(
            'a[href="#tutorial-general"], a[href$="#tutorial-general"]'
        );

        if (generalLink) {
            event.preventDefault();
            startGeneral(true);
            return;
        }

        const startButton = target.closest('[data-tour-start]');

        if (startButton) {
            event.preventDefault();

            if (startButton.dataset.tourStart === 'general') {
                startGeneral(true);
            } else if (startButton.dataset.tourStart === 'current') {
                startCurrent(true);
            }
            return;
        }

        const resetButton = target.closest('[data-tour-reset]');

        if (!resetButton) {
            return;
        }

        event.preventDefault();

        if (resetButton.dataset.tourReset === 'all') {
            resetAll();
        } else {
            resetCurrent();
        }

        scheduleBoot();
    }, true);

    window.InteviTour = {
        boot: scheduleBoot,
        startGeneral: () => startGeneral(true),
        startCurrent: () => startCurrent(true),
        resetCurrent,
        resetAll,
        status: () => ({
            markerFound: Boolean(getMarker()),
            config: getPageConfig(),
            active: Boolean(activeTour),
            dependency: 'none',
        }),
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', scheduleBoot, { once: true });
    } else {
        scheduleBoot();
    }

    document.addEventListener('livewire:initialized', scheduleBoot);
    document.addEventListener('livewire:navigated', scheduleBoot);
})();
