<?php

/* Page Single Class */

class WEP_Page_Single {

    /* Init */
    public function __construct() {


        // Single Header
        add_action('wep_single_content_heading', array('WEP_Page_Single_View', 'render_wep_single_title'), 10);

        // Single Content Sections
        add_action('wep_single_content_sections', array('WEP_Page_Single_View', 'render_wep_single_meta'), 10);
        add_action('wep_single_content_sections', array('WEP_Page_Single_View', 'render_wep_single_summary'), 20);
        add_action('wep_single_content_sections', array('WEP_Page_Single_View', 'render_wep_single_content'), 30);
        add_action('wep_single_content_sections', array('WEP_Page_Single_View', 'render_wep_single_shared'), 40);
        add_action('wep_single_content_sections', array('WEP_Page_Single_View', 'render_wep_single_author'), 50);
        add_action('wep_single_content_sections', array('WEP_Page_Single_View', 'render_wep_single_comments'), 60);

        // Single Content Related Components
        add_action('wep_single_content_related_components', array('WEP_Page_Single_View', 'render_wep_single_related_before_after'), 10);
        add_action('wep_single_content_related_components', array('WEP_Page_Single_View', 'render_wep_single_faqs'), 20);

        // Single Sidebar
        add_action('wep_single_content_sidebar', array('WEP_Page_Single_View', 'render_sidebar'), 10);

        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        WEP_Tag::render_bs_tag('container', 'div', '');

        // Title
        WEP_Tag::render_bs_tag('row');
        WEP_Tag::render_bs_tag('col-12');
        WEP_Tag::render_bs_tag('wep_service__title_wrapper');

        /**
         * Hook: wep_single_content_heading.
         *
         * @hooked render_wep_single_title
         */
        do_action('wep_single_content_heading');

        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();

        WEP_Tag::render_bs_tag('row');

        // Page not have sidebar
        if (is_page()) :
            WEP_Tag::render_bs_tag('col-12 col-md-12');
        else :
            WEP_Tag::render_bs_tag('col-12 col-md-9');
        endif;

        // Begin Main Content
        WEP_Tag::render_bs_tag('wep_news_content');

        /* Start the Loop */
        while (have_posts()) :
            WEP_Tag::render_bs_tag('wep_content_html');

            the_post();

            /**
             * Hook: wep_single_content_sections.
             *
             * @hooked render_wep_single_meta - 10
             * @hooked render_wep_single_summary - 20
             * @hooked render_wep_single_content - 30
             * @hooked render_wep_single_shared - 40
             * @hooked render_wep_single_author - 50         
             */
            do_action('wep_single_content_sections');

            WEP_Tag::render_bs_close_tag();
        endwhile;
        // End of the loop.

        /**
         * Hook: wep_single_content_related_components.
         *
         * @hooked render_wep_single_related_before_after - 10
         * @hooked render_wep_single_faqs - 20
         * @hooked render_wep_single_comments - 30
         */
        do_action('wep_single_content_related_components');

        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        // End Main Content

        if (!is_page()) :
            /**
             * Hook: wep_single_content_sidebar.
             *
             * @hooked render_sidebar - 10
             */
            do_action('wep_single_content_sidebar');
        endif;

        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();

        /**
         * Hook: wep_after_single_content.
         *
         * @hooked not yet
         */
        do_action('wep_after_single_content');
    }
}
