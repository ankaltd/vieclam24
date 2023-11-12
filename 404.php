<?php

/**
 * Template Name: Not found
 * Description: Page template 404 Not found.
 *
 */

new WEP_Page_Header();

$search_enabled = get_theme_mod('search_enabled', '1'); // Get custom meta-value.

new WEP_Page_Content('404', array('search_enabled' => $search_enabled));

new WEP_Page_Footer();
