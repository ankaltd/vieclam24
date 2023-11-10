<?php

/* Page Category_Product Class */

class WEP_Page_Category_Product {

    /* Init */
    public function __construct() {

        // Category Before Content
        add_action('wep_category_before_content', array('WEP_Page_Category_Product_View', 'render_wep_category_product_top_description'), 10);
        add_action('wep_category_before_content', array('WEP_Page_Category_Product_View', 'render_wep_common_keywords'), 20);
        add_action('wep_category_before_content', array('WEP_Page_Category_Product_View', 'render_wep_category_product_title'), 30);

        // Category Service Sidebar
        add_action('wep_category_sidebar', array('WEP_Page_Category_Product_View', 'render_sidebar'), 10);

        // Category Product Content Sections
        add_action('wep_category_product_content_sections', array('WEP_Woocommerce', 'wep_custom_catalog_ordering'), 10);
        add_action('wep_category_product_content_sections', array('WEP_Page_Category_Product_View', 'render_wep_category_product_filtering'), 20);
        add_action('wep_category_product_content_sections', array('WEP_Page_Category_Product_View', 'render_wep_category_product_grid'), 30);

        // Bottom Content
        add_action('wep_bottom_category_product_content', array('WEP_Page_Category_Product_View', 'render_wep_category_product_bottom_description'), 10);
        add_action('wep_bottom_category_product_content', array('WEP_Page_Category_Product_View', 'render_wep_category_product_faqs'), 20);
        add_action('wep_bottom_category_product_content', array('WEP_Page_Category_Product_View', 'render_wep_category_product_comments'), 30);

        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        /* Begin Container */
        WEP_Tag::render_bs_tag(
            array(
                'id' => 'wep_main',
                'class' => 'container wep_category_service',
                'tag' => 'div'
            )
        );

        /* Begin Row */
        WEP_Tag::render_bs_tag('row');
        WEP_Tag::render_bs_tag('col-12');
        /**
         * Hook: wep_category_before_content.
         *
         * @hooked render_wep_category_product_top_description - 10
         * @hooked render_wep_common_keywords - 20
         * @hooked render_wep_category_product_title - 20
         */
        do_action('wep_category_before_content');

        WEP_Tag::render_bs_close_tag();

        /* Begin Column Sidebar */
        WEP_Tag::render_bs_tag('col-12 col-md-3 d-none d-lg-block wep_category_sidebar');

        /**
         * Hook: wep_category_sidebar.
         *
         * @hooked render_sidebar - 10         
         */
        do_action('wep_category_sidebar');

        WEP_Tag::render_bs_close_tag();
        /* End Column Sidebar */

        /* Begin Column Main */
        WEP_Tag::render_bs_tag('col-12 col-md-9 wep_category_main');


        /**
         * Hook: wep_category_product_content_sections.
         *
         * @hooked render_wep_category_product_sorting - 10
         * @hooked render_wep_category_product_grid - 20
         * @hooked render_wep_category_product_pagenav - 30        
         */
        do_action('wep_category_product_content_sections');

        WEP_Tag::render_bs_close_tag();
        /* End Column Main */


        /**
         * Hook: wep_after_category_product_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_category_product_content');

        WEP_Tag::render_bs_close_tag();
        /* End Row */

        /* Begin Row */
        WEP_Tag::render_bs_tag('row');
        WEP_Tag::render_bs_tag('col-12');

        /**
         * Hook: wep_bottom_category_product_content.
         *
         * @hooked render_wep_category_product_bottom_description - 10
         * @hooked render_wep_category_product_faqs - 20
         * @hooked render_wep_category_product_comments - 30
         *          
         **/
        do_action('wep_bottom_category_product_content');

        WEP_Tag::render_bs_close_tag();
        /* End cols */

        WEP_Tag::render_bs_close_tag();
        /* End Row */

        WEP_Tag::render_bs_close_tag();
        /* End Container */
    }
}
