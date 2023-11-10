<?php

/* Page Home View Class */

class WEP_Page_Home_View {

    /* ========= All get methods output to page template ============== */

    // Select Device Section
    static function render_wep_home_select_device() {
        get_template_part('parts/home/select', 'device', array('heading' => 'Lựa chọn thiết bị cần sửa chữa'));
    }

    // Service iPhone Section
    static function render_wep_home_service_iphone($index) {
        get_template_part('parts/home/service', 'device', array('index' => $index));
    }

    // Service Apple Watch Section
    static function render_wep_home_service_apple_watch($index) {
        get_template_part('parts/home/service', 'device', array('index' => $index));
    }

    // Service Samsung Section
    static function render_wep_home_service_samsung($index) {
        get_template_part('parts/home/service', 'device', array('index' => $index));
    }

    // Product Accessory Section
    static function render_wep_home_product_accessory() {
        get_template_part('parts/home/product', 'accessory', array('heading' => '9. Phụ kiện'));
    }

    // Featured News Section
    static function render_wep_home_news_featured() {
        get_template_part('parts/home/news', 'featured', array('heading' => '10. Tin tức công nghệ'));
    }

    // Featured News Guide Section
    static function render_wep_home_news_guide() {
        get_template_part('parts/home/news', 'haft', array('category' => 'guide'));
    }

    // Featured News Service Section
    static function render_wep_home_news_service() {
        get_template_part('parts/home/news', 'haft', array('category' => 'service'));
    }
}
