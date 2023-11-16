<?php

/**

 * Custom Javascript Files to enqueue

 *

 *

 * Datas Structure

 *

 * [
 *     'handle'         => JS file Identifier
 *     'path'           => JS file path
 *     'dependencies'   => JS Files dependencies
 *     'version'        => JS File version
 *     'in_footer'      => JS file loaded in footer
 * ];
 *

 * You can use "wep_js_files" filter to change Javascript files loaded

 *

 */

return apply_filters('wep_js_files', [
    [
        'handle'        => 'splide-js',
        'path'          => THEME_URL . '/assets/js/splide/dist/js/splide.min.js',
        'dependencies'  => [],
        'version'       => '1.0.0',
        'in_footer'     => true
    ],
]);
