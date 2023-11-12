<?php

/* Content Page Class */
class WEP_Page_Content {

    /* Init */
    public function __construct($name = 'index', $args = array()) {

        // Output
        self::default($name, $args);
    }

    /* Sidebar Default */
    static function default($name, $args) {
        get_template_part('parts/content', $name, $args);
    }
}
