<?php

/* Page Category View Class */

class WEP_Page_Category_View {   


    /* ========= All get methods output to page template ============== */

    // Keywords
    static function render_wep_common_keywords() {
        get_template_part('parts/common/keyword', 'buttons', array('heading' => 'Dịch vụ thông dụng'));
    }

    // Category Title
    static function render_wep_category_title() {
        get_template_part('parts/single-post/post', 'cat-title', array('heading' => 'TIN TỨC CÔNG NGHỆ'));
    }

    // Category List
    static function render_wep_category_news_list() {
        get_template_part('parts/category/news', 'list', array('heading' => 'Liệt kê'));
    }

    // Category PageNav
    static function render_wep_category_pagenav() {
        get_template_part('parts/category/pagenavi', 'number', array('heading' => 'Phân trang'));
    }

    // Category Sidebar
    static function render_sidebar() {
        /* Get Sidebar Category */
        new WEP_Sidebar('category');
    }
}
