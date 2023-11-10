<?php

/* Page Search View Class */

class WEP_Page_Search_View {  

    /* ========= All get methods output to page template ============== */

    // Select Device Section
    static function render_wep_search_select_device() {
        get_template_part('parts/search/select', 'device', array('heading' => 'Lựa chọn thiết bị cần sửa chữa'));
    }

    // Service iPhone Section
    static function render_wep_search_service_iphone() {
        get_template_part('parts/search/service', 'device', array('heading' => 'Sửa iPhone'));
    }

    // Service Apple Watch Section
    static function render_wep_search_service_apple_watch() {

        get_template_part('parts/search/service', 'device', array('heading' => 'Sửa Apple Watch'));
    }

    // Service Samsung Section
    static function render_wep_search_service_samsung() {

        get_template_part('parts/search/service', 'device', array('heading' => 'Sửa điện thoại Samsung'));
    }

    // Product Accessory Section
    static function render_wep_search_product_accessory() {
        get_template_part('parts/search/product', 'accessory', array('heading' => '9. Phụ kiện'));
    }

    // Featured News Section
    static function render_wep_search_news_featured() {
        get_template_part('parts/search/news', 'featured', array('heading' => '10. Tin tức công nghệ'));
    }

    // Featured News Guide Section
    static function render_wep_search_news_guide() {
        get_template_part('parts/search/news', 'haft', array('category' => 'guide'));
    }

    // Featured News Service Section
    static function render_wep_search_news_service() {
        get_template_part('parts/search/news', 'haft', array('category' => 'service'));
    }
}
