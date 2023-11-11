
<?php

/* Page Footer Class */

class WEP_Page_Footer {

    /* Init */
    public function __construct() {
        // Output
        self::render_footer();
    }


    /* Get Footer Endpoint ============================ */
    static public function render_footer() {
        get_footer();
    }
}
