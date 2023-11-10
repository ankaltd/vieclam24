<?php

/**

 * Custom CSS Files to enqueue

 *

 *

 * Datas Structure

 *

 * [

 *     'handle'         => CSS file Identifier

 *     'path'           => CSS file path

 *     'dependencies'   => CSS Files dependencies

 *     'version'        => CSS File version

 *     'media'          => CSS file active on media

 * ];

 *

 * You can use "wep_css_files" filter to add CSS Files on enqueue process

 *

 */

return apply_filters('wep_css_files', [

    [

        'handle'        => 'wep-font',
        'path'          => 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Lexend+Deca:wght@100;200;300;400;500;600;700;800;900&display=swap',
        'dependencies'  => [],
        'version'       => '1.0.0',
        'media'         => 'all'
    ],
    [

        'handle'        => 'wep-icons',
        'path'          => THEME_URL . '/node_modules/bootstrap-icons/font/bootstrap-icons.min.css',
        'dependencies'  => ['wep-font'],
        'version'       => '1.0.0',
        'media'         => 'all'
    ],
    [

        'handle'        => 'wep-splide',
        'path'          => THEME_URL . '/assets/js/splide/dist/css/splide.min.css',
        'dependencies'  => ['wep-font'],
        'version'       => '1.0.0',
        'media'         => 'all'
    ],
    [

        'handle'        => 'wep-stylesheet',
        'path'          => THEME_URL . '/assets/wep.css',
        'dependencies'  => ['wep-font','wep-icons'],
        'version'       => '1.0.0',
        'media'         => 'all'
    ]
]);
