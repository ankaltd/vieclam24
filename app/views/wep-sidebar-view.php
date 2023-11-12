<?php


/* Sidebar View Class */

class WEP_Sidebar_View {


    /* All Widgets ==================================== */

    // Post Same Category
    static function render_wep_widgets_post_same_category() {
        get_template_part('parts/widget/list-post', 'same-category', array('heading' => 'Tin cùng chuyên mục'));
    }

    // Filter
    static function render_wep_widgets_filter_service() {
        get_template_part('parts/offcanvas/filter-service', null, array('heading' => 'Lọc dịch vụ'));
    }

    // Commitments
    static function render_wep_widgets_service_commitments() {
        WEP_Shortcode::render('[wep_service_commitments]', array('heading' => 'Cam kết cửa hàng'));
    }

    // Shop Address
    static function render_wep_widgets_service_shop_address() {
        WEP_Shortcode::render('[wep_single_service_shop_address]', array('heading' => 'Hệ thống cửa hàng'));
    }

    // Service Same Category
    static function render_wep_widgets_service_same_category() {
        get_template_part('parts/widget/list-service-same-category', null, array('heading' => 'Danh mục khác'));
    }

    // TOC
    static function render_wep_widgets_toc() {
        get_template_part('parts/single-post/post-toc', null, array('heading' => 'Mục lục'));
    }

    // Post Categories
    static function render_wep_widgets_post_categories() {
        get_template_part('parts/widget/categories-post', null, array('heading' => 'Chuyên mục tin'));
    }

    // Service Related
    static function render_wep_widgets_list_service_related() {
        //get_template_part('parts/widget/list-service', 'related', array('heading' => 'Dịch vụ liên quan'));
    }

    // Product Related
    static function render_wep_widgets_list_product_related() {
        //get_template_part('parts/widget/list-product', 'related', array('heading' => 'Sản phẩm liên quan'));
    }

    // Posts Related
    static function render_wep_widgets_list_post_related() {
        get_template_part('parts/widget/list-post', 'related', array('heading' => 'Bài viết liên quan'));
    }
}
