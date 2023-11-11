<?php


/* Sidebar Class */
class WEP_Page_Sidebar {

    /* Init */
    public function __construct($current_page = '') {
        // Output
        if (($current_page === 'post') || is_single('post')) :
            self::for_post();

        elseif (($current_page === 'product') || function_exists('is_product')) :
            self::for_product();

        elseif (($current_page === 'category') || is_category()) :
            self::for_category();

        elseif (($current_page === 'product-category') || function_exists('is_product_category')) :
            self::for_product_category();

        else :
            self::default();
        endif;
    }

    /* Sidebar Default */
    static function default() {
        get_sidebar();
    }

    /* Sidebar Post */
    static function for_post() {
        WEP_Tag::render_bs_tag('col-12 col-md-3 single_post_sidebar');

        /**
         * Hook: wep_before_sidebar_post.
         *
         * @hooked not yet
         */
        do_action('wep_before_sidebar_post');

        /**
         * Hook: wep_sidebar_post_widgets.
         *
         * @hooked render_wep_widgets_toc - 10
         * @hooked render_wep_widgets_post_categories - 20
         * @hooked render_wep_widgets_list_service_related - 30
         * @hooked render_wep_widgets_list_product_related - 40
         * @hooked render_wep_widgets_list_post_related - 40
         */
        do_action('wep_sidebar_post_widgets');

        /**
         * Hook: wep_after_sidebar_post.
         *
         * @hooked not yet
         */
        do_action('wep_after_sidebar_post');

        WEP_Tag::render_bs_close_tag();
        /* End Column Sidebar */
    }

    /* Sidebar Product */
    static function for_product() {

        /* Begin Column Sidebar */
        WEP_Tag::render_bs_tag('col-12 col-md-3');
        WEP_Tag::render_bs_tag(array('class' => 'wep_sidebar scrollable_ver'));

        /**
         * Hook: wep_before_sidebar_product.
         *
         * @hooked not yet
         */
        do_action('wep_before_sidebar_product');

        /**
         * Hook: wep_sidebar_product_widgets.
         *
         * @hooked render_wep_widgets_service_commitments - 10
         * @hooked render_wep_widgets_service_shop_address - 20
         * @hooked render_wep_widgets_service_same_category - 30
         */
        do_action('wep_sidebar_product_widgets');

        /**
         * Hook: wep_after_sidebar_product.
         *
         * @hooked not yet
         */
        do_action('wep_after_sidebar_product');

        WEP_Tag::render_bs_close_tag();
        /* End Column Sidebar */

        WEP_Tag::render_bs_close_tag();
        /* End Column Sidebar */
    }

    /* Sidebar Category */
    static function for_category() {
        /* Begin Column Sidebar */
        WEP_Tag::render_bs_tag('col-12 col-md-3');

        /**
         * Hook: wep_sidebar_category_widgets.
         *
         * @hooked render_wep_widgets_post_categories - 10
         * @hooked render_wep_widgets_post_same_category - 20
         */
        do_action('wep_sidebar_category_widgets');

        WEP_Tag::render_bs_close_tag();
        /* End Column Sidebar */
    }

    /* Sidebar Product Category */
    static function for_product_category() {
        /* Begin Column Sidebar */
        WEP_Tag::render_bs_tag('wep_sidebar scrollable_ver');

        /**
         * Hook: wep_sidebar_product_category_widgets.
         *
         * @hooked render_wep_widgets_filter_service - 10
         */
        do_action('wep_sidebar_product_category_widgets');


        WEP_Tag::render_bs_close_tag();
        /* End Column Sidebar */
    }
}
