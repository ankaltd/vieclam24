<?php

/* Page Contact Class */

class WEP_Page_Contact {

    /* Init */
    public function __construct() {

        // Content Sections
        add_action('wep_contact_content_sections', array('WEP_Page_Contact_View', 'render_wep_contact_information'), 10);
        add_action('wep_contact_content_sections', array('WEP_Page_Contact_View', 'render_wep_contact_map'), 20);
        add_action('wep_contact_content_sections', array('WEP_Page_Contact_View', 'render_wep_contact_form'), 30);

        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        WEP_Tag::render_bs_tag('container', 'div', 'Đây là trang liên hệ');

        /**
         * Hook: wep_before_contact_content.
         *
         * @hooked not yet
         */
        do_action('wep_before_contact_content');

        /* Start the Loop */
        while (have_posts()) :
            the_post();
            WEP_Tag::render_bs_tag(array('tag' => 'h2'));
            the_title();
            WEP_Tag::render_bs_close_tag('h2');
            the_content();
        endwhile;
        // End of the loop.

        /**
         * Hook: wep_contact_content_sections.
         *
         * @hooked render_wep_contact_information - 10
         * @hooked render_wep_contact_form - 20
         * @hooked render_wep_contact_map - 30
         */
        do_action('wep_contact_content_sections');

        /**
         * Hook: wep_after_contact_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_contact_content');

        WEP_Tag::render_bs_close_tag();
    }
}
