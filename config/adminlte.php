<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TÍTULO
    |--------------------------------------------------------------------------
    */
    'title' => 'Sistema Integral de Resguardos | IEESSPP',
    'title_prefix' => '',
    'title_postfix' => '',

    'use_ico_only' => true,
    'use_full_favicon' => true,

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | LOGO
    |--------------------------------------------------------------------------
    */
    'logo' => '<b style="font-weight:600; color:#171C63;">Resguardos</b> <span style="color:#1E2761;">IEESSPP</span>',
    'logo_img' => 'vendor/adminlte/dist/img/logocircularieesspp.png',
    'logo_img_class' => 'brand-image elevation-1',
    'logo_img_alt' => 'Logo IEESSPP',

    /*
    |--------------------------------------------------------------------------
    | PRELOADER (DESACTIVADO)
    |--------------------------------------------------------------------------
    */
    'preloader' => [
        'enabled' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | MENÚ DE USUARIO
    |--------------------------------------------------------------------------
    */
    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-[#171C63] text-white',
    'usermenu_image' => false,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | LAYOUT
    |--------------------------------------------------------------------------
    */
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => false,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | CLASES DE INTERFAZ
    |--------------------------------------------------------------------------
    */
    'classes_body' => 'sidebar-mini layout-fixed bg-light',
    'classes_brand' => 'bg-[#171C63] text-center border-0',
    'classes_brand_text' => 'fw-semibold text-white',
    'classes_content_wrapper' => '',
    'classes_content_header' => 'border-0 mb-3 rounded-1',
    'classes_content' => 'pt-3',
    'classes_sidebar' => 'sidebar-dark elevation-2',
    'classes_sidebar_nav' => '',
    'classes_topnav' => '',
    'classes_topnav_nav' => '',
    'classes_topnav_container' => 'container-fluid bg-[#171C63]',

    /*
    |--------------------------------------------------------------------------
    | COLORES
    |--------------------------------------------------------------------------
    */
    'colors' => [
        'primary' => '#171C63',
        'secondary' => '#1E2761',
        'light' => '#f8f9fa',
        'muted' => '#6c757d',
        'success' => '#198754',
        'danger' => '#dc3545',
    ],

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    */
    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 250,

    /*
    |--------------------------------------------------------------------------
    | MENÚ PRINCIPAL
    |--------------------------------------------------------------------------
    */
    'menu' => [
        [
            'text' => 'Dashboard',
            'url' => 'dashboard',
            'icon' => 'fas fa-home',
        ],
        [
            'text' => 'Inventario',
            'url' => 'inventario',
            'icon' => 'fas fa-box',
        ],
        [
            'text' => 'Marcas',
            'url' => 'marcas',
            'icon' => 'fas fa-tags',
            'can' => 'marcas.create',
        ],
        [
            'text' => 'Resguardantes',
            'icon' => 'fas fa-users',
            'submenu' => [
                ['text' => 'Usuarios', 'url' => 'resguardante'],
                ['text' => 'Puestos', 'url' => 'puestos'],
            ],
        ],
        [
            'text' => 'Ubicaciones',
            'icon' => 'fas fa-map-marker-alt',
            'submenu' => [
                ['text' => 'Ubicación Física', 'url' => 'ubicacionfisica'],
                ['text' => 'Área de Asignación', 'url' => 'areadeasignacion'],
            ],
        ],



    ],

    /*
    |--------------------------------------------------------------------------
    | PLUGINS
    |--------------------------------------------------------------------------
    */
    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css'],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11'],
            ],
        ],
    ],

    'livewire' => true,

    /*
    |--------------------------------------------------------------------------
    | CSS PERSONALIZADO
    |--------------------------------------------------------------------------
    */
    'custom_css' => [
    'css/custom-adminlte.css', // solo la ruta relativa desde public
s    ],
];
