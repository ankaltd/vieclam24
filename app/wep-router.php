<?php

class WEP_Router {

    // Init
    public function __construct() {

        // default rounting
        self::route();
    }

    // Get current page template file
    static function wep_page_template() {
        return get_page_template_slug();
    }

    // Routing Control
    static function route() {
    }
}
