<?php

/* Page Header Class */

class WEP_Page_Header {

    /* Init */
    public function __construct() {

        // Header Meta 
        add_action('wep_before_header', array('WEP_Page_Header_View', 'render_wep_header_meta'), 10);

        // Header Sections
        add_action('wep_header_sections', array('WEP_Page_Header_View', 'render_wep_header_top'), 10);
        add_action('wep_header_sections', array('WEP_Page_Header_View', 'render_wep_header_middle'), 20);
        add_action('wep_header_sections', array('WEP_Page_Header_View', 'render_wep_header_bottom'), 30);

        // Header End 
        add_action('wep_after_header', array('WEP_Page_Header_View', 'render_wep_header_general'), 10);

        // Output
        self::render_header();
    }

    // Get Header - Endpoint =========================== */
    static public function render_header() {

        /**
         * Hook: wep_before_header.
         * 
         * @class: WEP_Page_Header_View
         * 
         * @hooked render_wep_header_meta
         */
        do_action('wep_before_header');

        /* Begin Header */
        WEP_Tag::render_bs_tag(['tag' => 'header', 'class' => 'header', 'id' => 'wep_header']);
        WEP_Tag::render_bs_tag('container p-3');

        /**
         * Hook: wep_header_sections.
         *
         * @class: WEP_Page_Header_View
         * 
         * @hooked render_wep_header_top - 10
         * @hooked render_wep_header_middle - 20
         * @hooked render_wep_header_bottom - 30
         */
        do_action('wep_header_sections');

        /* End Header */
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag('header');

        /**
         * Hook: wep_after_header.
         * 
         * @class: WEP_Page_Header_View
         * 
         * @hooked render_wep_header_general.
         */
        do_action('wep_after_header');
    }
}
