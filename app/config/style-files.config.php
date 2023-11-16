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
        'path'          => 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
        'dependencies'  => [],
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

        'handle'        => 'wep-home',
        'path'          => THEME_URL . '/assets/css/home.css',
        'dependencies'  => ['wep-font'],
        'version'       => '1.0.0',
        'media'         => 'all'
    ]
]);
