<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'INTEVI',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => true,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    */
    'logo' => '
        <div style="
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            
        ">
            <img
                src="/images/intevi logo.png"
                alt="Logo de INTEVI"
                style="
                    width: 38px;
                    height: 38px;
                    object-fit: contain;
                    display: block;
                    margin: 0px !important;
                    padding: 0px !important;
                "
            >

            <strong style="
                display: block;
                margin: 0px !important;
                padding: 0px !important;
                color: #171C63;
                font-size: 17px;
                font-weight: 900;
                line-height: 1;
                letter-spacing: 1px;
            ">
                INTEVI
            </strong>
        </div>
    ',

    'logo_img' => null,
    'logo_img_class' => '',
    'logo_img_xl' => null,
    'logo_img_xl_class' => '',
    'logo_img_alt' => '',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    */

    'preloader' => [
        'enabled' => false,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/logoicono.ico',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => 'sidebar-mini layout-fixed layout-navbar-fixed',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-0',
    'classes_sidebar_nav' => 'nav-flat nav-child-indent',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container-fluid',

    /*
    |--------------------------------------------------------------------------
    | Sidebar Config
    |--------------------------------------------------------------------------
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar
    |--------------------------------------------------------------------------
    */

    'right_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    'use_route_url' => false,
    'dashboard_url' => '/dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => '',
    'laravel_js_path' => '',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Assets
    |--------------------------------------------------------------------------
    */

    'css' => [
        'css/intevi-adminlte.css',

        //'css/intevi-componentes.css',
    ],

    'js' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    */

    'menu' => [
        [
            'text' => 'Panel de Control',
            'url'  => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        ['header' => 'GESTIÓN PRINCIPAL'],

        [
            'text' => 'Inventario',
            'url'  => 'inventario',
            'icon' => 'fas fa-boxes',
        ],
        /*
        [
            'text' => 'Resguardos',
            'url'  => 'resguardos',
            'icon' => 'fas fa-file-signature',
        ],
        */
        [
            'text' => 'Resguardantes',
            'url'  => 'resguardante',
            'icon' => 'fas fa-user-shield',
            'can' => 'resguardante.create'
        ],

        [
            'header' => 'CATÁLOGOS',
            'can' => 'marcas.create'
        ],

        [
            'text' => 'Marcas',
            'url'  => 'marcas',
            'icon' => 'fas fa-tags',
            'can' => 'marcas.create'
        ],
        [
            'text' => 'Puestos',
            'url'  => 'puestos',
            'icon' => 'fas fa-briefcase',
            'can' => 'puestos.create'
        ],
        [
            'text' => 'Áreas de asignación',
            'url'  => 'areadeasignacion',
            'icon' => 'fas fa-sitemap',
            'can' => 'areadeasignacion.create'
        ],
        [
            'text' => 'Ubicaciones físicas',
            'url'  => 'ubicacionfisica',
            'icon' => 'fas fa-map-marker-alt',
            'can' => 'ubicacionfisica.create'
        ],

        ['header' => 'ADMINISTRACIÓN', 'can' => 'viewPulse'],
        /*
        [
            'text' => 'Usuarios',
            'url'  => 'usuarios',
            'icon' => 'fas fa-users-cog',
        ],
        
        [
            'text' => 'Roles y permisos',
            'url'  => 'roles',
            'icon' => 'fas fa-user-lock',
        ],
        */
        [
            'text' => 'Monitor de sistema',
            'url' => env('PULSE_PATH', 'pulse'),
            'icon' => 'fas fa-fw fa-heartbeat',
            'can' => 'viewPulse',
        ],
        [
            'text' => 'Tutorial general',
            'url' => '#tutorial-general',
            'icon' => 'fas fa-graduation-cap',
            'can' => 'resguardante.create'
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    */

    'plugins' => [
        'Datatables' => ['active' => false],
        'Select2' => ['active' => false],
        'Chartjs' => ['active' => false],
        'Sweetalert2' => ['active' => false],
        'Pace' => ['active' => false],
        'DriverJs' => [
            'active' => true,

            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/driver.js@1.7.0/dist/driver.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/driver.js@1.7.0/dist/driver.js.iife.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/intevi-tour.js',
                ],
                
            ],
        ],
        'InteviOffline' => [
            'active' => true,

            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/intevi-offline.js',
                    'defer' => true,
                ],
            ],
        ],
        'Clarity' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/intevi-clarity.js',
                ],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    */

    'iframe' => [
        'default_tab' => ['url' => null, 'title' => null],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    */

    'livewire' => false,
];
