<?php

/**
 * Class Web Interface Block Model Data
 */

class WIB_Wrapper_Model extends WIB_Base_Model {

    public function __construct() {

        // CUSTOM DATA BEFOR INPUT HERE ...

        // Danh sách tham số mặc định
        $att_defaults = array(
            'id' => '',
            'link' => '',
            'title' => '',
            'width' => '200',
            'height' => 'auto',
        );

        // Danh sách trường giá trị và giá trị mặc định
        $field_defaults = array(
            'wep_logo' => '',
            'wep_link' => '',
            'wep_title' => '',
            'wep_width' => '200',
            'wep_height' => 'auto',
        );

        // Tạo một mảng tương ứng giữa các key của $att_defaults và $field_defaults
        $key_mapping = array(
            'id' => 'wep_logo',
            'link' => 'wep_link',
            'title' => 'wep_title',
            'width' => 'wep_width',
            'height' => 'wep_height',
        );

        // call base model
        parent::__construct($att_defaults, $field_defaults, $key_mapping);
    }

    public function get_shortcode_data($atts, $acf_option = false, $acf_used = false) {        

        // call base model 
        $atts = parent::get_shortcode_data($atts, $acf_option = true, $acf_used = false);

        // CUSTOM CODE BEFORE OUT PUT HERE ...

        return $atts;
    }
    
}
