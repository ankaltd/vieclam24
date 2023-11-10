<?php



/**

 * Custom CSS Files to enqueue to Editor

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

return apply_filters('wep_css_files_editor', [

    [

        'handle'        => 'wep-stylesheet',

        'path'          => THEME_URL . '/assets/wep.min.css',

        'dependencies'  => ['wep-font'],

        'version'       => '1.0.0',

        'media'         => 'all'

    ],

    [

        'handle'        => 'wep-font',

        'path'          => 'https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100;200;300;400;500;600;700;800;900&display=swap',

        'dependencies'  => [],

        'version'       => '1.0.0',

        'media'         => 'all'

    ],

]);

