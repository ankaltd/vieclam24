<?php

/**
 * Custom menus endpoint
 *
 *
 * Datas Structure
 *
 * [
 *     'menu_id' => Menu name
 * ];
 *
 * You can use "wep_menus_list" filter to change load custom menus endpoint
 *
 */
return apply_filters('wep_menus_list', [
    'main-menu'     => __('Main menu', LANG_DOMAIN),
    'footer-menu'   => __('Footer menu', LANG_DOMAIN)
]);
