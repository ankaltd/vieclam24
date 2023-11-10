<?php

/**
 * Custom Javascript Files to enqueue to Admin
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
 * You can use "wep_js_files_admin" filter to change Javascript files loaded
 *
 */
return apply_filters('wep_js_files_admin', [
    [
        'handle'        => 'admin-sticky-js',
        'path'          => THEME_URL . '/app/assets/js/wep-admin-sticky.js',
        'dependencies'  => ['jquery'],
        'version'       => '1.0.0',
        'in_footer'     => true
    ],
    [
        'handle'        => 'wep-admin-scripts-js',
        'path'          => THEME_URL . '/app/assets/js/wep-admin-scripts.js',
        'dependencies'  => ['jquery'],
        'version'       => '1.0.0',
        'in_footer'     => true
    ]
]);
