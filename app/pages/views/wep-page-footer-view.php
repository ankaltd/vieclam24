
<?php

/* Page Footer View Class */

class WEP_Page_Footer_View {

    /* ========= All get methods output to page template ============== */

    // Footer Generals
    static function render_footer_general() {
        get_template_part('parts/footer/footer-general');
    }

    // Render footer top
    static function render_wep_footer_top() {
        get_template_part('parts/footer/footer-top');
    }

    // Render footer bottom
    static function render_wep_footer_bottom() {
        get_template_part('parts/footer/footer-bottom');
    }

    // Render footer chatters
    static function render_wep_footer_chatters() {
        get_template_part('parts/footer/footer-chatters');
    }

    // Render footer sticky
    static function render_footer_sticky() {
        if (is_single()) :
            get_template_part('parts/footer/footer-sticky', get_post_type(), array('heading' => '21. Detail Footer Sticky for ' . get_post_type()));        
        elseif (is_page_template('templates/single-service-temp.php') || (is_product())) :
            get_template_part('parts/footer/footer-sticky', 'product', array('heading' => '22. Detail Footer Sticky Service'));
        elseif (is_page_template('templates/single-temp.php')) :
            get_template_part('parts/footer/footer-sticky', 'post', array('heading' => '23. Detail Footer Sticky Post'));
        else :
            get_template_part('parts/footer/footer-sticky', 'nav',  array('heading' => '24. General Footer Sticky'));
        endif;

        if (is_product_category()) :
            get_template_part('parts/footer/footer-sticky', 'nav',  array('heading' => '24. General Footer Sticky'));
        endif;
    }

    // Render footer after
    static function render_wep_footer_end() {
        get_template_part('parts/footer/footer', 'end');
    }
}
