<?php

/* Page Header Class */

class WEP_Page_Header {

    /* Init */
    public function __construct() {
        
        // Output
        self::render_header();
    }

    // Get Header - Endpoint =========================== */
    static public function render_header() {
        get_header();
    }
}
