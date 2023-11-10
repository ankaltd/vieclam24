<?php

/* Page Search Class */

class WEP_Page_Search {

    /* Init */
    public function __construct() {       

        // Main Content Sections
        // add_action('wep_search_content_sections', array('WEP_Page_Search_View', 'render_wep_search_select_device'), 10);
        
        // Bottom Content Sections
        // add_action('wep_search_content_bottom', array('WEP_Page_Search_View', 'render_wep_search_news_guide'), 10);
        
        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        /**
         * Hook: wep_before_search_content.
         *
         * @hooked not yet
         */
        do_action('wep_before_search_content');

        // #WEP Main
        WEP_Tag::render_bs_tag(['id' => 'wep_main', 'class' => 'shadow',]);

        // Begin Container
        WEP_Tag::render_bs_tag(['class' => 'container']);

        /**
         * Hook: wep_search_content_sections.
         *
         * @hooked render_wep_search_select_device - 10
         * @hooked render_wep_search_service_iphone - 20
         * @hooked render_wep_search_service_apple_watch - 30
         * @hooked render_wep_search_service_samsung - 40
         * @hooked render_wep_search_product_accessory - 50
         * @hooked render_wep_search_news_featured - 60
         */
        do_action('wep_search_content_sections');

        // End of container
        WEP_Tag::render_bs_close_tag();

        // End #WEP Main
        WEP_Tag::render_bs_close_tag();

        // Begin of bottom
        WEP_Tag::render_bs_tag('container p-0');
        WEP_Tag::render_bs_tag('row');

        /**
         * Hook: wep_search_content_bottom.
         *
         * @hooked render_wep_search_news_guide
         * @hooked render_wep_search_news_service
         */
        do_action('wep_search_content_bottom');

        // End of bottom
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        

        /**
         * Hook: wep_after_search_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_search_content');
    }

   
}
