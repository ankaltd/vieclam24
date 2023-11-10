<?php

/* Page Contact View Class */

class WEP_Page_Contact_View {    

    /* ========= All get methods output to page template ============== */

    // Information
    static function render_wep_contact_information() {
        get_template_part('parts/contact/contact', 'information', array('heading' => 'Thông tin'));
    }

    // Form
    static function render_wep_contact_form() {
        get_template_part('parts/contact/contact', 'form', array('heading' => 'Liên hệ'));
    }

    // Map
    static function render_wep_contact_map() {

        get_template_part('parts/contact/contact', 'map', array('heading' => 'Hệ thống cửa hàng'));
    }
}
