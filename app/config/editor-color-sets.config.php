<?php

/**
 * Custom Editor color sets
 *
 *
 * Datas Structure
 *
 *
 * You can use "wep_editor_color_sets" filter to change load custom menus endpoint
 *
 */

// Editor color palette.
$black     = '#000000';
$dark_gray = '#28303D';
$gray      = '#39414D';
$green     = '#D1E4DD';
$blue      = '#D1DFE4';
$purple    = '#D1D1E4';
$red       = '#E4D1D1';
$orange    = '#E4DAD1';
$yellow    = '#EEEADD';
$white     = '#FFFFFF';

return apply_filters('wep_editor_color_sets', [
    array(
        'name'  => esc_html__('Black', LANG_DOMAIN),
        'slug'  => 'black',
        'color' => $black,
    ),
    array(
        'name'  => esc_html__('Dark gray', LANG_DOMAIN),
        'slug'  => 'dark-gray',
        'color' => $dark_gray,
    ),
    array(
        'name'  => esc_html__('Gray', LANG_DOMAIN),
        'slug'  => 'gray',
        'color' => $gray,
    ),
    array(
        'name'  => esc_html__('Green', LANG_DOMAIN),
        'slug'  => 'green',
        'color' => $green,
    ),
    array(
        'name'  => esc_html__('Blue', LANG_DOMAIN),
        'slug'  => 'blue',
        'color' => $blue,
    ),
    array(
        'name'  => esc_html__('Purple', LANG_DOMAIN),
        'slug'  => 'purple',
        'color' => $purple,
    ),
    array(
        'name'  => esc_html__('Red', LANG_DOMAIN),
        'slug'  => 'red',
        'color' => $red,
    ),
    array(
        'name'  => esc_html__('Orange', LANG_DOMAIN),
        'slug'  => 'orange',
        'color' => $orange,
    ),
    array(
        'name'  => esc_html__('Yellow', LANG_DOMAIN),
        'slug'  => 'yellow',
        'color' => $yellow,
    ),
    array(
        'name'  => esc_html__('White', LANG_DOMAIN),
        'slug'  => 'white',
        'color' => $white,
    ),
]);
