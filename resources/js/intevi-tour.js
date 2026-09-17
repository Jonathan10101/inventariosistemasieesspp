import { driver as createDriver } from 'driver.js';
import 'driver.js/dist/driver.css';

console.log('✅ INTEVI: intevi-tour.js cargó correctamente');

window.inteviTourLoaded = true;

let activeTour = null;
let initializationTimer = null;

/**
 * Obtiene el ID del usuario.
 */
function getCurrentUserId() {
    const meta = document.querySelector('meta[name="auth-user-id"]');

    return meta?.content || 'guest';
}

/**
 * Busca el marcador del tour.
 */
function getTourPageMarker() {
    return document.querySelector('[data-tour-page]');
}

/**
 * Genera la clave para localStorage.
 */
function getStorageKey(marker) {
    const userId = getCurrentUserId();
    const page = marker.dataset.tourPage || window.location.pathname;
    const version = marker.dataset.tourVersion || '1';

    return `intevi:tour:${userId}:${page}:v${version}`;
}

/**
 * Comprueba si un elemento está visible.
 */
function isElementVisible(element) {
    if (!element) {
        return false;
    }

    const styles = window.getComputedStyle(element);

    return (
        styles.display !== 'none' &&
        styles.visibility !== 'hidden' &&
        element.getClientRects().length > 0
    );
}

/**
 * Valida la posición del cuadro.
 */
function getValidSide(value) {
    const allowed = ['top', 'right', 'bottom', 'left'];

    return allowed.includes(value) ? value : 'bottom';
}

/**
 * Valida la alineación del cuadro.
 */
function getValidAlign(value) {
    const allowed = ['start', 'center', 'end'];

    return allowed.includes(value) ? value : 'center';
}

/**
 * Construye los pasos leyendo el HTML.
 */
function buildTourSteps() {
    return Array.from(document.querySelectorAll('[data-tour-step]'))
        .filter(isElementVisible)
        .sort((firstElement, secondElement) => {
            const firstOrder = Number(
                firstElement.dataset.tourOrder || 0
            );

            const secondOrder = Number(
                secondElement.dataset.tourOrder || 0
            );

            return firstOrder - secondOrder;
        })
        .map((element) => ({
            element,

            popover: {
                title:
                    element.dataset.tourTitle ||
                    'Información importante',

                description:
                    element.dataset.tourDescription ||
                    'En esta sección puedes realizar acciones dentro del sistema.',

                side: getValidSide(element.dataset.tourSide),

                align: getValidAlign(element.dataset.tourAlign),
            },
        }));
}

/**
 * Comprueba si el usuario ya vio el tour.
 */
function userHasSeenTour(storageKey) {
    try {
        return window.localStorage.getItem(storageKey) === 'seen';
    } catch (error) {
        console.warn(
            'No fue posible consultar el estado del tour:',
            error
        );

        return false;
    }
}

/**
 * Marca el tour como visto.
 */
function markTourAsSeen(storageKey) {
    try {
        window.localStorage.setItem(storageKey, 'seen');
    } catch (error) {
        console.warn(
            'No fue posible guardar el estado del tour:',
            error
        );
    }
}

/**
 * Cierra el tour activo.
 */
function destroyActiveTour() {
    if (!activeTour) {
        return;
    }

    try {
        activeTour.destroy();
    } catch (error) {
        console.warn('No fue posible cerrar el tour:', error);
    }

    activeTour = null;
}

/**
 * Inicia el tour.
 */
export function startInteviTour(force = false) {
    const marker = getTourPageMarker();

    if (!marker) {
        return;
    }

    const steps = buildTourSteps();

    if (steps.length === 0) {
        console.warn(
            'La página tiene un marcador de tour, pero no contiene elementos data-tour-step.'
        );

        return;
    }

    const storageKey = getStorageKey(marker);

    if (!force && userHasSeenTour(storageKey)) {
        return;
    }

    destroyActiveTour();

    activeTour = createDriver({
        steps,

        animate: true,
        smoothScroll: true,
        allowClose: true,
        allowKeyboardControl: true,

        overlayColor: '#080b2f',
        overlayOpacity: 0.76,

        stagePadding: 10,
        stageRadius: 14,
        popoverOffset: 14,

        showProgress: true,
        progressText: 'Paso {{current}} de {{total}}',

        nextBtnText: 'Siguiente',
        prevBtnText: 'Anterior',
        doneBtnText: 'Finalizar',

        popoverClass: 'intevi-tour-popover',

        onDestroyed: () => {
            markTourAsSeen(storageKey);
            activeTour = null;
        },
    });

    activeTour.drive();
}

/**
 * Inicializa automáticamente el tour.
 */
function initializeCurrentPageTour() {
    window.clearTimeout(initializationTimer);

    initializationTimer = window.setTimeout(() => {
        const marker = getTourPageMarker();

        if (!marker) {
            return;
        }

        const autoStart =
            marker.dataset.tourAutostart !== 'false';

        if (autoStart) {
            startInteviTour(false);
        }
    }, 450);
}

/**
 * Botón para repetir el recorrido.
 */
document.addEventListener('click', (event) => {
    const startButton = event.target.closest('[data-tour-start]');

    if (!startButton) {
        return;
    }

    event.preventDefault();

    startInteviTour(true);
});

/**
 * Compatibilidad con Livewire.
 */
document.addEventListener(
    'livewire:navigated',
    initializeCurrentPageTour
);

/**
 * Páginas sin wire:navigate.
 */
if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initializeCurrentPageTour,
        { once: true }
    );
} else {
    initializeCurrentPageTour();
}

/**
 * Cierra el tour antes de navegar.
 */
document.addEventListener('livewire:navigating', () => {
    destroyActiveTour();
});

/**
 * Acceso global.
 */
window.INTEVITour = {
    start() {
        startInteviTour(true);
    },

    reset() {
        const marker = getTourPageMarker();

        if (!marker) {
            return;
        }

        try {
            window.localStorage.removeItem(
                getStorageKey(marker)
            );
        } catch (error) {
            console.warn(
                'No fue posible reiniciar el recorrido:',
                error
            );
        }

        startInteviTour(true);
    },
};