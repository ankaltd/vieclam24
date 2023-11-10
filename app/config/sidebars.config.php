<?php

/** 
 * Custom Sidebar defined
 * 
 * 
 * Datas Structure
 *
 * [
 *      'name'          => esc_html__('Right', LANG_DOMAIN),
 *      'id'            => 'sidebar-1',
 *      'description'   => esc_html__('Add widgets here to appear in your right sidebar.', LANG_DOMAIN),
 *      'before_widget' => '<section id="%1$s" class="widget %2$s">',
 *      'after_widget'  => '</section>',
 *      'before_title'  => '<h2 class="widget-title">',
 *      'after_title'   => '</h2>',
 * ];
 *
 * You can use "wep_sidebar_list" filter to change load custom menus endpoint
 *
 */
return apply_filters('wep_sidebar_list', [
    array(
        'name'          => esc_html__('Right', LANG_DOMAIN),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your right sidebar.', LANG_DOMAIN),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ),
    array(
        'name'          => esc_html__('Footer', LANG_DOMAIN),
        'id'            => 'sidebar-2',
        'description'   => esc_html__('Add widgets here to appear in your footer.', LANG_DOMAIN),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    )
]);
