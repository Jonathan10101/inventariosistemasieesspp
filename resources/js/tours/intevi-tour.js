import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';
import '../../css/intevi-tour.css';

/*
|--------------------------------------------------------------------------
| Tour guiado reutilizable para INTEVI
|--------------------------------------------------------------------------
|
| Para crear un tour en una vista:
|
| 1. Agrega un marcador:
|
|    <div
|        data-tour-page="dashboard"
|        data-tour-version="1"
|        data-tour-autostart="true"
|        hidden
|    ></div>
|
| 2. Agrega data-tour-step a los elementos que quieras explicar.
|
*/

let activeTour = null;
let initializationTimer = null;

/**
 * Obtiene el ID del usuario para que cada usuario
 * tenga su propio registro de recorridos vistos.
 */
function getCurrentUserId() {
    const meta = document.querySelector('meta[name="auth-user-id"]');

    return meta?.content || 'guest';
}

/**
 * Busca el marcador que identifica el tour de la página.
 */
function getTourPageMarker() {
    return document.querySelector('[data-tour-page]');
}

/**
 * Genera una clave única para localStorage.
 */
function getStorageKey(marker) {
    const userId = getCurrentUserId();
    const page = marker.dataset.tourPage || window.location.pathname;
    const version = marker.dataset.tourVersion || '1';

    return `intevi:tour:${userId}:${page}:v${version}`;
}

/**
 * Determina si el elemento realmente está visible.
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
 * Valida la posición del cuadro informativo.
 */
function getValidSide(value) {
    const allowed = ['top', 'right', 'bottom', 'left'];

    return allowed.includes(value) ? value : 'bottom';
}

/**
 * Valida la alineación del cuadro informativo.
 */
function getValidAlign(value) {
    const allowed = ['start', 'center', 'end'];

    return allowed.includes(value) ? value : 'center';
}

/**
 * Construye automáticamente los pasos leyendo el HTML.
 */
function buildTourSteps() {
    return Array.from(document.querySelectorAll('[data-tour-step]'))
        .filter(isElementVisible)
        .sort((firstElement, secondElement) => {
            const firstOrder = Number(firstElement.dataset.tourOrder || 0);
            const secondOrder = Number(secondElement.dataset.tourOrder || 0);

            return firstOrder - secondOrder;
        })
        .map((element) => {
            return {
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
            };
        });
}

/**
 * Consulta si el usuario ya vio el tour.
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
 * Registra que el usuario ya vio o cerró el recorrido.
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
 * Elimina de forma segura cualquier recorrido abierto.
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
 * Inicia el recorrido de la página actual.
 *
 * force = true permite repetir el recorrido aunque
 * el usuario ya lo haya visto.
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

    activeTour = driver({
        steps,

        animate: true,
        duration: 350,

        smoothScroll: true,
        allowScroll: true,
        allowClose: true,

        overlayColor: '#080b2f',
        overlayOpacity: 0.76,
        overlayClickBehavior: 'close',

        stagePadding: 10,
        stageRadius: 14,
        popoverOffset: 14,

        showProgress: true,
        progressText: 'Paso {{current}} de {{total}}',

        nextBtnText: 'Siguiente',
        prevBtnText: 'Anterior',
        doneBtnText: 'Finalizar',

        popoverClass: 'intevi-tour-popover',

        /*
         * Si un elemento no existe en cierto rol o dispositivo,
         * el recorrido continúa sin generar errores.
         */
        skipMissingElement: true,

        onDestroyed: () => {
            markTourAsSeen(storageKey);
            activeTour = null;
        },
    });

    activeTour.drive();
}

/**
 * Inicializa automáticamente el tour cuando carga
 * una página o termina una navegación de Livewire.
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

/*
|--------------------------------------------------------------------------
| Botón para repetir el recorrido
|--------------------------------------------------------------------------
*/

document.addEventListener('click', (event) => {
    const startButton = event.target.closest('[data-tour-start]');

    if (!startButton) {
        return;
    }

    event.preventDefault();

    startInteviTour(true);
});

/*
|--------------------------------------------------------------------------
| Compatibilidad con wire:navigate
|--------------------------------------------------------------------------
|
| livewire:navigated se ejecuta en la primera carga y también después
| de navegar mediante wire:navigate.
|
*/

document.addEventListener(
    'livewire:navigated',
    initializeCurrentPageTour
);

/*
|--------------------------------------------------------------------------
| Respaldo para páginas sin wire:navigate
|--------------------------------------------------------------------------
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

/*
|--------------------------------------------------------------------------
| Cerrar el recorrido antes de cambiar de página
|--------------------------------------------------------------------------
*/

document.addEventListener('livewire:navigating', () => {
    destroyActiveTour();
});

/*
|--------------------------------------------------------------------------
| Acceso opcional desde la consola o cualquier otro script
|--------------------------------------------------------------------------
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