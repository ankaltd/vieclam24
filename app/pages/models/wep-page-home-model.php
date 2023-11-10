<?php

/* Page Home Model Class */

class WEP_Page_Home_Model {

    // Get data of section by field name
    static function get_home_section_data($field_name) {
        global $home_options;

        return $home_options[$field_name];
    }
}
