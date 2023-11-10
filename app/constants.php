<?php

/** 
 * Defined constants using global
 */

global $current_page;

define('THEME_URL',                 get_template_directory_uri());
define('THEME_DIR',                 get_template_directory());
define('THEME_ASSET',               THEME_URL . '/assets');
define('THEME_CSS',                 THEME_ASSET . '/css');
define('THEME_JS',                  THEME_ASSET . '/js');
define('THEME_IMG',                 THEME_ASSET . '/images');
define('THEME_APP',                 THEME_DIR . '/app');
define('THEME_CONFIG',              THEME_APP . '/config');
define('THEME_MODEL',               THEME_APP . '/models');
define('THEME_VIEW',                THEME_APP . '/views');
define('THEME_CONTROLLER',          THEME_APP . '/controllers');
define('THEME_TEMPLATE',            THEME_DIR . '/templates');
define('THEME_BLOCK',               THEME_DIR . '/blocks');
define('THEME_SHORTCODE',           THEME_DIR . '/shortcodes');
define('THEME_PART',                THEME_DIR . '/parts');
define('THEME_ADMIN',               THEME_APP . '/admin');
define('THEME_CLASS',               THEME_APP . '/classes');
define('THEME_INC',                 THEME_APP . '/includes');
define('THEME_PAGE',                THEME_APP . '/pages');
define('THEME_ADMIN_TEMPLATE',      THEME_ADMIN . '/templates');
define('THEME_ADMIN_ASSET',         THEME_APP . '/assets');
define('THEME_ADMIN_CSS',           THEME_ADMIN_ASSET . '/css');
define('THEME_ADMIN_JS',            THEME_ADMIN_ASSET . '/js');
define('THEME_ADMIN_IMG',           THEME_ADMIN_ASSET . '/images');
define('LANG_DOMAIN',               'vieclam24');
define('SHOW_HINT',                 false);
