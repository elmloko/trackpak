<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => '',
    'title_postfix' => '| TrackingBo',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Tracking</b>BO',
    'logo_img' => 'vendor/adminlte/dist/img/AGBClogo.png',
    'logo_img_class' => 'brand-image img-circle',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'TrackingBO',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AGBClogo.png',
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
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AGBClogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 100,
            'height' => 100,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-dark',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark navbar-danger',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        ['header' => 'PAQUETERIA POSTAL'],
        [
            'text' => 'Dashboard',
            'url' => '/dashboard',
            'icon' => 'fas fa-user',
        ],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-users',
            'can'  => 'users.index',
            'submenu' => [
                [
                    'text' => 'Personal AGBC',
                    'url' => 'users',
                    'icon' => 'fas fa-user',
                ],
                [
                    'text' => 'Roles',
                    'url' => 'roles',
                    'icon' => 'fas fa-users-cog',
                ],
                [
                    'text' => 'Permisos',
                    'url' => 'permissions',
                    'icon' => 'fas fa-key',
                ],
                [
                    'text' => 'Accesos',
                    'url' => 'role-has-permissions',
                    'icon' => 'fas fa-key',
                ],
            ],
        ],
        [
            'text' => 'Paquetes Ordinarios',
            'icon' => 'fas fa-archive',
            'can'  => '',
            'submenu' => [
                [
                    'text' => 'Todos Paquetes',
                    'url' => 'packages',
                    'icon' => 'fas fa-box',
                    'can'  => 'packages',
                ],
                [
                    'text' => 'Clasificacion',
                    'icon' => 'fas fa-cube ',
                    'can'  => 'packages.clasificacion',
                    'submenu' => [
                        [
                            'text' => 'Registro Paquetes',
                            'url' => 'packages/clasificacion',
                            'icon' => 'fas fa-clipboard-list',
                            'can'  => 'packages.clasificacion',
                        ],
                        [
                            'text' => 'Inventario Clasificacion',
                            'url' => 'packages/entregasclasificacion',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.clasificacion',
                        ],
                        [
                            'text' => 'Reencaminar Paquetes',
                            'url' => 'test/redirigidos',
                            'icon' => 'fas fa-paper-plane',
                            'can'  => 'packages.clasificacion',
                        ],
                    ],
                ],
                [
                    'text' => 'Ventanilla DD',
                    'icon' => 'fas fa-window-maximize',
                    'can'  => 'packages.ventanilla',
                    'submenu' => [
                        [
                            'text' => 'Entregas Ventanilla DD',
                            'url' => 'packages/ventanilla',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.ventanilla',
                        ],
                        [
                            'text' => 'Inventario Ventanilla DD',
                            'url' => 'test/deleteado',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.delete',
                        ],
                    ],
                ],
                [
                    'text' => 'Ventanilla DND',
                    'icon' => 'fas fa-window-maximize',
                    'can'  => 'packages.dnd',
                    'submenu' => [
                        [
                            'text' => 'Entregas Ventanilla DND',
                            'url' => 'packages/ventanilladnd',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.dnd',
                        ],
                        [
                            'text' => 'Inventario Ventanilla DND',
                            'url' => 'test/deleteadodnd',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.dnd',
                        ],
                    ],
                ],
                [
                    'text' => 'Ventanilla UNICA',
                    'icon' => 'fas fa-window-maximize',
                    'can'  => 'packages.unica',
                    'submenu' => [
                        [
                            'text' => 'Recibir Correspondencia',
                            'url' => 'packages/ventanillaunicarecibir',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.unica',
                        ],
                        [
                            'text' => 'Entregar Correspondencia',
                            'url' => 'packages/ventanillaunica',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.unica',
                        ],
                        [
                            'text' => 'Inventario Correspondencia',
                            'url' => 'test/deleteadounica',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.unica',
                        ],
                    ],
                ],
                [
                    'text' => 'Casillas',
                    'icon' => 'fas fa-archive',
                    'can'  => 'packages.casillas',
                    'submenu' => [
                        [
                            'text' => 'Entregas Casillas',
                            'url' => 'packages/casillas',
                            'icon' => 'fas fa-box',
                            // 'can'  => '	packages.casillas',
                        ],
                        [
                            'text' => 'Inventario Casillas',
                            'url' => 'packages/casillasinventario',
                            'icon' => 'fas fa-suitcase',
                            // 'can'  => '	packages.casillas',
                        ],
                    ],
                ],
                [
                    'text' => 'ECA',
                    'icon' => 'fas fa-archive',
                    'can'  => 'packages.eca',
                    'submenu' => [
                        [
                            'text' => 'Entregas ECA',
                            'url' => 'packages/eca',
                            'icon' => 'fas fa-box',
                            'can'  => 'packages.eca',
                        ],
                        [
                            'text' => 'Inventario ECA',
                            'url' => 'packages/ecainventario',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.eca',
                        ],
                    ],
                ],
                [
                    'text' => 'VENTANILLA 7',
                    'icon' => 'fas fa-archive',
                    'can'  => 'packages.encomiendas',
                    'submenu' => [
                        [
                            'text' => 'Recibir Paqueteria',
                            'url' => 'packages/ventanilladdrecibir',
                            'icon' => 'fas fa-box',
                            'can'  => 'packages.encomiendas',
                        ],
                        [
                            'text' => 'Entregas Paqueteria',
                            'url' => 'packages/encomiendas',
                            'icon' => 'fas fa-box',
                            'can'  => 'packages.encomiendas',
                        ],
                        [
                            'text' => 'Inventario Paqueteria',
                            'url' => 'packages/encomiendasinventario',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.encomiendas',
                        ],
                    ],
                ],
                [
                    'text' => 'Traspazo de Ventanillas',
                    'url' => 'traspasoventanillas',
                    'icon' => 'fas fa-box',
                    'can'  => 'packages.ventanilla',
                ],
            ],
        ],
        [
            'text' => 'Paquetes Certificados',
            'icon' => 'fas fa-archive',
            'can'  => '',
            'submenu' => [
                [
                    'text' => 'Todos Paquetes',
                    'url' => 'internationals',
                    'icon' => 'fas fa-box',
                    'can'  => 'packages',
                ],
                [
                    'text' => 'Ventanilla DD',
                    'icon' => 'fas fa-window-maximize',
                    'can'  => 'packages.ventanilla',
                    'submenu' => [
                        [
                            'text' => 'Entregas Ventanilla DD',
                            'url' => 'internationals/ventanilladd',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.ventanilla',
                        ],
                        [
                            'text' => 'Inventario Ventanilla DD',
                            'url' => 'internationals/deleteadodd',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.delete',
                        ],
                    ],
                ],
                [
                    'text' => 'Ventanilla DND',
                    'icon' => 'fas fa-window-maximize',
                    'can'  => 'packages.dnd',
                    'submenu' => [
                        [
                            'text' => 'Entregas Ventanilla DND',
                            'url' => 'internationals/ventanilladnd',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.dnd',
                        ],
                        [
                            'text' => 'Inventario Ventanilla DND',
                            'url' => 'internationals/deleteadodnd',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.dnd',
                        ],
                    ],
                ],
                [
                    'text' => 'Ventanilla Casillas',
                    'icon' => 'fas fa-window-maximize',
                    'can'  => 'packages.casillas',
                    'submenu' => [
                        [
                            'text' => 'Entregas Ventanilla Casillas',
                            'url' => 'internationals/ventanillacasillas',
                            'icon' => 'fas fa-truck',
                            'can'  => 'packages.casillas',
                        ],
                        [
                            'text' => 'Inventario Ventanilla Casillas',
                            'url' => 'internationals/deleteadocasillas',
                            'icon' => 'fas fa-suitcase',
                            'can'  => 'packages.casillas',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Urbano',
            'icon' => 'fas fa-building',
            'can'  => 'packages.urbano',
            'submenu' => [
                [
                    'text' => 'Distribución Paquetes',
                    'url' => 'packages/distribuicioncartero',
                    'icon' => 'fas fa-box-open',
                    'can'  => 'packages.distribuicioncartero',
                ],
                [
                    'text' => 'Entregas Cartero',
                    'url' => 'packages/carteros',
                    'icon' => 'fas fa-cubes',
                    'can'  => 'packages.inventariocartero',
                ],
                [
                    'text' => 'Despacho Cartero',
                    'url' => 'packages/despachocartero',
                    'icon' => 'fas fa-envelope-open-text',
                    'can'  => 'packages.inventariocartero',
                ],
                [
                    'text' => 'Inventario Cartero',
                    'url' => 'packages/inventariocartero',
                    'icon' => 'fas fa-suitcase',
                    'can'  => 'packages.inventariocartero',
                ],
                [
                    'text' => 'Entregas Domicilio',
                    'url' => 'packages/carterosgeneral',
                    'icon' => 'fas fa-cubes',
                    'can'  => 'packages.ventanilla',
                ],
                [
                    'text' => 'Despacho Domicilio',
                    'url' => 'packages/despachocarterogeneral',
                    'icon' => 'fas fa-envelope-open-text',
                    'can'  => 'packages.ventanilla',
                ],
                [
                    'text' => 'Inventario Domicilio',
                    'url' => 'packages/generalcartero',
                    'icon' => 'fas fa-suitcase',
                    'can'  => 'packages.generalcartero',
                ],

            ],
        ],
        [
            'text' => 'Rezago',
            'icon' => 'fas fa-database',
            'can'  => 'packages.ventanilla',
            'submenu' => [
                [
                    'text' => 'Prerezago',
                    'url' => 'packages/prerezago',
                    'icon' => 'fas fa-cloud',
                    'can'  => 'packages.prerezago',
                ],
                [
                    'text' => 'Inventario Rezago',
                    'url' => 'packages/rezago',
                    'icon' => 'fas fa-hdd',
                    'can'  => 'packages.rezago',
                ],
            ],
        ],
        [
            'text' => 'Eventos',
            'url' => 'events',
            'icon' => 'fas fa-calendar-alt',
            'can'  => 'packages',
        ],
        // [
        //     'text' => 'Mensajeria',
        //     'url' => 'mensajes',
        //     'icon' => 'fas fa-calendar-alt',
        //     'can'  => 'users.index',
        // ],
        [
            'text' => 'Rendimiento',
            'url' => '/pulse',
            'can'  => 'users.index',
            'icon' => 'fas fa-user',
        ],
        [
            'text' => 'Logs',
            'url' => '/log-viewer',
            'can'  => 'users.index',
            'icon' => 'fas fa-user',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
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
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
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
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
