<?php

class WEP_Page_Header_Model {
    private static $option_file = THEME_CONFIG . '/option-json/general.json';

    /* Get options */
    static function get_option() {
        $options = WEP_Helper::getJsonAsArray(self::$option_file);

        return $options;
    }

    
}
