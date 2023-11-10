<?php

/**
 * Custom Editor font sizes
 *
 *
 * Datas Structure
 *
 *
 * You can use "wep_editor_font_sizes" filter to change load custom menus endpoint
 *
 */
return apply_filters('wep_editor_font_sizes', [
    array(
        'name'      => esc_html__('Extra small', LANG_DOMAIN),
        'shortName' => esc_html_x('XS', 'Font size', LANG_DOMAIN),
        'size'      => 16,
        'slug'      => 'extra-small',
    ),
    array(
        'name'      => esc_html__('Small', LANG_DOMAIN),
        'shortName' => esc_html_x('S', 'Font size', LANG_DOMAIN),
        'size'      => 18,
        'slug'      => 'small',
    ),
    array(
        'name'      => esc_html__('Normal', LANG_DOMAIN),
        'shortName' => esc_html_x('M', 'Font size', LANG_DOMAIN),
        'size'      => 20,
        'slug'      => 'normal',
    ),
    array(
        'name'      => esc_html__('Large', LANG_DOMAIN),
        'shortName' => esc_html_x('L', 'Font size', LANG_DOMAIN),
        'size'      => 24,
        'slug'      => 'large',
    ),
    array(
        'name'      => esc_html__('Extra large', LANG_DOMAIN),
        'shortName' => esc_html_x('XL', 'Font size', LANG_DOMAIN),
        'size'      => 40,
        'slug'      => 'extra-large',
    ),
    array(
        'name'      => esc_html__('Huge', LANG_DOMAIN),
        'shortName' => esc_html_x('XXL', 'Font size', LANG_DOMAIN),
        'size'      => 96,
        'slug'      => 'huge',
    ),
    array(
        'name'      => esc_html__('Gigantic', LANG_DOMAIN),
        'shortName' => esc_html_x('XXXL', 'Font size', LANG_DOMAIN),
        'size'      => 144,
        'slug'      => 'gigantic',
    ),
]);
