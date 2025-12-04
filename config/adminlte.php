<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'Sistema Integral de Resguardos | IEESSPP',
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

    'logo' => '<b>RESGUARDOS IEESSPP</b>',
    'logo_img' => 'vendor/adminlte/dist/img/logocircularieessppQUITARMAYUSCULAS.png',
    'logo_img_class' => 'brand-image',
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

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',

    // ⭐ Sidebar institucional con tu color + estilos
    'classes_sidebar' => 'sidebar-ieesspp elevation-4',

    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

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
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    */

    'menu' => [

        // 🔹 Pantalla completa
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // 🔹 Dashboard
        /*
        [
            'text' => 'Panel principal',
            'url' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        */

        // 🔹 Inventario
        [
            'text' => 'Inventario',
            'url' => 'inventario',
            'icon' => 'fas fa-boxes',
            'can' => 'inventario.index',
        ],

        // 🔹 Marcas
        [
            'text' => 'Marcas',
            'url' => 'marcas',
            'icon' => 'fas fa-copyright',
            'can' => 'marcas.edit',
        ],

        // 🔹 Resguardantes
        [
            'text' => 'Resguardantes',
            'icon' => 'fas fa-user-shield',
            'can' => 'resguardante.index',
            'submenu' => [
                [
                    'text' => 'Usuarios',
                    'url' => 'resguardante',
                    'icon' => 'fas fa-id-badge',
                    'can' => 'puestos.index'

                ],
                [
                    'text' => 'Puestos',
                    'url' => 'puestos',
                    'icon' => 'fas fa-briefcase',
                    'can' => 'puestos.edit'
                ],
            ],
        ],

        // 🔹 Ubicaciones
        [
            'text' => 'Ubicaciones',
            'icon' => 'fas fa-map-marked-alt',
            'can' => 'ubicacionfisica.index',
            'submenu' => [
                [
                    'text' => 'Ubicación física',
                    'url' => 'ubicacionfisica',
                    'icon' => 'fas fa-map-marker-alt',
                    'can' => 'ubicacionfisica.index'
                ],
                [
                    'text' => 'Área de asignación',
                    'url' => 'areadeasignacion',
                    'icon' => 'fas fa-building',
                    'can' => 'ubicacionfisica.edit'
                ],
            ],
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
