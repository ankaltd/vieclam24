<?php

/* Content Page Class */
class WEP_Page_Content {

    /* Init */
    public function __construct($name = 'index') {

        // Output
        self::default($name);
    }

    /* Sidebar Default */
    static function default($name) {
        get_template_part('parts/content', $name);
    }
}
