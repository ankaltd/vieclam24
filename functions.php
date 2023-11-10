<?php
/**
 * WEP vieclam24-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  WEP
 * @since   WEP 0.1
 */

// Include Constants
require_once(__DIR__ . '/app/constants.php');

// Include Router
require_once(__DIR__ . '/app/wep-router.php');

// Include Autoload for core classes
require_once(__DIR__ . '/app/autoloader.php');

new Class_WEP_Functions();

// Setup Theme
// new WEP_Setup;


