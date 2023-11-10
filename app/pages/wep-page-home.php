<?php

/* Page Home Class */

class WEP_Page_Home {

    // private $data_section_serivce = array();

    /* Init */
    public function __construct() {

        /** 
         * Main Content Sections  
         *          
         * @class WEP_Page_Home_View
         * @see render_wep_home_select_device()
         * @see render_wep_home_service_iphone()
         * @see render_wep_home_service_apple_watch()
         * @see render_wep_home_service_samsung()
         * @see render_wep_home_product_accessory()
         * @see render_wep_home_news_featured() 
         */

        // $this->data_section_serivce = WEP_Page_Home_Model::get_home_section_data('wep_section_service_by_device__wep_section_service_device_list');

        add_action('wep_home_content_sections', array('WEP_Page_Home_View', 'render_wep_home_select_device'), 10);

        add_action('wep_home_content_sections', function () { WEP_Page_Home_View::render_wep_home_service_iphone(0); }, 20);

        add_action('wep_home_content_sections', function () { WEP_Page_Home_View::render_wep_home_service_apple_watch(1); }, 30);

        add_action('wep_home_content_sections', function () { WEP_Page_Home_View::render_wep_home_service_samsung(2); }, 40);

        // add_action('wep_home_content_sections', array('WEP_Page_Home_View', 'render_wep_home_service_iphone'), 20);
        // add_action('wep_home_content_sections', array('WEP_Page_Home_View', 'render_wep_home_service_apple_watch'), 30);
        // add_action('wep_home_content_sections', array('WEP_Page_Home_View', 'render_wep_home_service_samsung'), 40);

        add_action('wep_home_content_sections', array('WEP_Page_Home_View', 'render_wep_home_product_accessory'), 50);
        add_action('wep_home_content_sections', array('WEP_Page_Home_View', 'render_wep_home_news_featured'), 60);

        /** 
         * Bottom Content Sections 
         * 
         * @class WEP_Page_Home_View
         * @see render_wep_home_news_guide()
         * @see render_wep_home_news_service()
         */
        add_action('wep_home_content_bottom', array('WEP_Page_Home_View', 'render_wep_home_news_guide'), 10);
        add_action('wep_home_content_bottom', array('WEP_Page_Home_View', 'render_wep_home_news_service'), 20);

        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        /**
         * Hook: wep_before_home_content.
         *
         * @hooked not yet
         */
        do_action('wep_before_home_content');

        // #WEP Main
        WEP_Tag::render_bs_tag(['id' => 'wep_main']);

        // Begin Container
        WEP_Tag::render_bs_tag(['class' => 'container']);

        /**
         * Hook: wep_home_content_sections.
         * 
         * @class WEP_Page_Home_View
         * @hooked render_wep_home_select_device - 10
         * @hooked render_wep_home_service_iphone - 20
         * @hooked render_wep_home_service_apple_watch - 30
         * @hooked render_wep_home_service_samsung - 40
         * @hooked render_wep_home_product_accessory - 50
         * @hooked render_wep_home_news_featured - 60
         */
        do_action('wep_home_content_sections');

        // End of container
        WEP_Tag::render_bs_close_tag();

        // End #WEP Main
        WEP_Tag::render_bs_close_tag();

        // Begin of bottom
        WEP_Tag::render_bs_tag('container');
        WEP_Tag::render_bs_tag('row');

        /**
         * Hook: wep_home_content_bottom.
         *
         * @class WEP_Page_Home_View
         * @hooked render_wep_home_news_guide
         * @hooked render_wep_home_news_service
         */
        do_action('wep_home_content_bottom');

        // End of bottom
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();

        /**
         * Hook: wep_after_home_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_home_content');
    }
}
