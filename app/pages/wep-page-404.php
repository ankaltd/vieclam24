<?php

/* Page 404 Class */

class WEP_Page_404 {

    /* Init */
    public function __construct() {       

        // Main Content Sections
        // add_action('wep_404_content_sections', array($this, 'render_wep_404_select_device'), 10);

        // Output
        self::get_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function get_content() {

        /**
         * Hook: wep_before_404_content.
         *
         * @hooked not yet
         */
        do_action('wep_before_404_content');

        // #WEP Main
        WEP_Tag::render_bs_tag(['id' => 'wep_main', 'class' => 'shadow',]);

        // Begin Container
        WEP_Tag::render_bs_tag(['class' => 'container']);

        /**
         * Hook: wep_404_content_sections.
         *
         * @hooked render_wep_404_select_device - 10
         * @hooked render_wep_404_service_iphone - 20
         * @hooked render_wep_404_service_apple_watch - 30
         * @hooked render_wep_404_service_samsung - 40
         * @hooked render_wep_404_product_accessory - 50
         * @hooked render_wep_404_news_featured - 60
         */
        do_action('wep_404_content_sections');

        // End of container
        WEP_Tag::render_bs_close_tag();

        // End #WEP Main
        WEP_Tag::render_bs_close_tag();

        // Begin of bottom
        WEP_Tag::render_bs_tag('container p-0');
        WEP_Tag::render_bs_tag('row');

        /**
         * Hook: wep_404_content_bottom.
         *
         * @hooked render_wep_404_news_guide
         * @hooked render_wep_404_news_service
         */
        do_action('wep_404_content_bottom');

        // End of bottom
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        

        /**
         * Hook: wep_after_404_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_404_content');
    }

    /* ========= All get methods output to page template ============== */

    // Select Device Section
    public function render_wep_404_select_device() {
        get_template_part('parts/404/select', 'device', array('heading' => 'Lựa chọn thiết bị cần sửa chữa'));
    }
}
