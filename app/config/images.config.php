<?php

/**
 * Custom image sizes
 *
 *
 * Datas Structure
 *
 * [
 *    'image_id'    => custom image size's identifer
 *    'width'       => image's width
 *    'height'      => image's height
 *    'crop'        => do you want to crop this image ?
 * ];
 *
 * You can use "wep_images_configuration" filter to change custom image sizes
 *
 */
return apply_filters('wep_images_configuration', [
    [
        'image_id'  => 'wep_thumb_service',
        'width'     => 320,
        'height'    => 320,
        'crop'      => true
    ],
    [
        'image_id'  => 'wep_thumb_solution',
        'width'     => 735,
        'height'    => 597,
        'crop'      => true
    ],
    [
        'image_id'  => 'wep_thumb_news',
        'width'     => 376,
        'height'    => 276,
        'crop'      => true
    ],
    [
        'image_id'  => 'wep_thumb_client',
        'width'     => 100,
        'height'    => 100,
        'crop'      => false
    ],
    [
        'image_id'  => 'wep_thumb_featured_large',
        'width'     => 595,
        'height'    => 396,
        'crop'      => true
    ],
    [
        'image_id'  => 'wep_thumb_featured_small',
        'width'     => 150,
        'height'    => 100,
        'crop'      => true
    ],
   
    [
        'image_id'  => 'wep_thumb_widget',
        'width'     => 186,
        'height'    => 84,
        'crop'      => true
    ],
    [
        'image_id'  => 'wep_thumb_category',
        'width'     => 241,
        'height'    => 161,
        'crop'      => true
    ],
    [
        'image_id'  => 'wep_thumb_slide',
        'width'     => 1920,
        'height'    => 879,
        'crop'      => true
    ],
]);
