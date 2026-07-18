(function () {
    'use strict';

    /*
    |--------------------------------------------------------------------------
    | Configuración principal
    |--------------------------------------------------------------------------
    |
    | Cambia el número cuando quieras mostrar nuevamente una versión nueva
    | del tutorial a todos los usuarios.
    |
    */

    const STORAGE_KEY = 'intevi_tutorial_general_v1';

    let tourActivo = null;
    let inicioAutomaticoEjecutado = false;

    /**
     * Obtiene Driver.js desde el archivo cargado mediante CDN.
     */
    function obtenerDriver() {
        if (
            window.driver &&
            window.driver.js &&
            typeof window.driver.js.driver === 'function'
        ) {
            return window.driver.js.driver;
        }

        return null;
    }

    /**
     * Verifica si estamos en el dashboard.
     */
    function estamosEnDashboard() {
        const ruta = window.location.pathname.replace(/\/+$/, '');

        return ruta === '/dashboard';
    }

    /**
     * Abre el sidebar en dispositivos móviles.
     */
    function abrirSidebarEnMovil() {
        if (window.innerWidth >= 992) {
            return;
        }

        const body = document.body;

        if (body.classList.contains('sidebar-open')) {
            return;
        }

        const botonSidebar = document.querySelector(
            '[data-widget="pushmenu"]'
        );

        if (botonSidebar) {
            botonSidebar.click();
        }
    }

    /**
     * Pasos del tutorial.
     *
     * skipMissingElement permite omitir automáticamente opciones ocultas
     * por permisos o roles.
     */
    function obtenerPasos() {
        return [
            {
                popover: {
                    title: 'Bienvenido a INTEVI',
                    description:
                        'En menos de un minuto conocerás las principales opciones del sistema.',
                    side: 'bottom',
                    align: 'center',
                },
            },

            {
                element: '.brand-link',
                popover: {
                    title: 'INTEVI',
                    description:
                        'Desde este espacio puedes identificar el sistema y regresar al área principal.',
                    side: 'right',
                    align: 'start',
                },
            },

            {
                element: 'a[href$="/dashboard"]',
                popover: {
                    title: 'Panel de control',
                    description:
                        'Aquí encontrarás el resumen general, indicadores y actividad reciente del sistema.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: 'a[href$="/inventario"]',
                popover: {
                    title: 'Inventario',
                    description:
                        'Registra, consulta y administra los bienes que pertenecen a la institución.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: 'a[href$="/resguardante"]',
                popover: {
                    title: 'Resguardantes',
                    description:
                        'Administra las personas responsables de recibir y resguardar los bienes.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: 'a[href$="/marcas"]',
                popover: {
                    title: 'Marcas',
                    description:
                        'Registra las marcas utilizadas en los artículos del inventario.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: 'a[href$="/puestos"]',
                popover: {
                    title: 'Puestos',
                    description:
                        'Organiza los puestos institucionales de los resguardantes.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: 'a[href$="/areadeasignacion"]',
                popover: {
                    title: 'Áreas de asignación',
                    description:
                        'Configura las áreas administrativas donde pueden asignarse los bienes.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: 'a[href$="/ubicacionfisica"]',
                popover: {
                    title: 'Ubicaciones físicas',
                    description:
                        'Controla los edificios, oficinas, almacenes y espacios donde se encuentran los bienes.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                element: '.navbar-nav .user-menu',
                popover: {
                    title: 'Tu cuenta',
                    description:
                        'Desde aquí puedes consultar las opciones disponibles para tu usuario y cerrar sesión.',
                    side: 'bottom',
                    align: 'end',
                },
            },

            {
                element: '.js-intevi-tour',
                popover: {
                    title: 'Consultar nuevamente',
                    description:
                        'Puedes volver a iniciar este tutorial cuando lo necesites presionando esta opción.',
                    side: 'right',
                    align: 'center',
                },
            },

            {
                popover: {
                    title: 'Tutorial finalizado',
                    description:
                        'Ya conoces las secciones principales de INTEVI. Puedes comenzar a utilizar el sistema.',
                    side: 'bottom',
                    align: 'center',
                },
            },
        ];
    }

    /**
     * Inicia el tutorial.
     */
    function iniciarTutorial() {
        const driverFactory = obtenerDriver();

        if (!driverFactory) {
            console.error(
                'INTEVI: Driver.js no pudo cargarse. Revisa la conexión al CDN.'
            );

            return;
        }

        abrirSidebarEnMovil();

        if (
            tourActivo &&
            typeof tourActivo.isActive === 'function' &&
            tourActivo.isActive()
        ) {
            tourActivo.destroy();
        }

        tourActivo = driverFactory({
            animate: true,
            duration: 350,

            smoothScroll: true,
            allowClose: true,
            allowScroll: true,
            allowKeyboardControl: true,

            overlayColor: '#090b24',
            overlayOpacity: 0.72,
            overlayClickBehavior: 'close',

            stagePadding: 8,
            stageRadius: 12,
            popoverOffset: 12,

            showProgress: true,
            progressText: 'Paso {{current}} de {{total}}',

            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
            doneBtnText: 'Finalizar',

            popoverClass: 'intevi-tour-popover',

            /*
             * Omite elementos que no estén disponibles por permisos,
             * roles o cambios realizados por Livewire.
             */
            skipMissingElement: true,
            waitForElement: 500,

            steps: obtenerPasos(),

            onDestroyed: function () {
                try {
                    localStorage.setItem(STORAGE_KEY, 'completado');
                } catch (error) {
                    console.warn(
                        'INTEVI: no fue posible guardar el estado del tutorial.',
                        error
                    );
                }

                tourActivo = null;
            },
        });

        /*
         * Esperamos ligeramente para que AdminLTE termine de acomodar
         * el sidebar en móviles.
         */
        window.setTimeout(function () {
            tourActivo.drive();
        }, 250);
    }

    /**
     * Inicia automáticamente una sola vez en el dashboard.
     */
    function iniciarAutomaticamente() {
        if (inicioAutomaticoEjecutado) {
            return;
        }

        if (!estamosEnDashboard()) {
            return;
        }

        inicioAutomaticoEjecutado = true;

        try {
            const tutorialVisto = localStorage.getItem(STORAGE_KEY);

            if (tutorialVisto === 'completado') {
                return;
            }
        } catch (error) {
            console.warn(
                'INTEVI: no fue posible consultar el estado del tutorial.',
                error
            );
        }

        window.setTimeout(function () {
            iniciarTutorial();
        }, 900);
    }

    /**
     * Botón global del menú.
     *
     * Utilizamos delegación de eventos para que siga funcionando
     * después de actualizaciones del DOM realizadas por Livewire 3.
     */
    document.addEventListener('click', function (event) {
        const botonTutorial = event.target.closest('.js-intevi-tour');

        if (!botonTutorial) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        iniciarTutorial();
    });

    /**
     * Carga inicial normal.
     */
    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            iniciarAutomaticamente,
            { once: true }
        );
    } else {
        iniciarAutomaticamente();
    }

    /**
     * Compatibilidad cuando el proyecto utiliza wire:navigate.
     */
    document.addEventListener('livewire:navigated', function () {
        inicioAutomaticoEjecutado = false;

        window.setTimeout(function () {
            iniciarAutomaticamente();
        }, 250);
    });

    /**
     * Métodos disponibles desde la consola o cualquier otro botón.
     */
    window.InteviTour = {
        iniciar: iniciarTutorial,

        reiniciar: function () {
            try {
                localStorage.removeItem(STORAGE_KEY);
            } catch (error) {
                console.warn(
                    'INTEVI: no fue posible reiniciar el tutorial.',
                    error
                );
            }

            iniciarTutorial();
        },
    };
})();