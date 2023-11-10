<?php

/* Page Category Class */

class WEP_Page_Category {

    /* Init */
    public function __construct() {

        // Category Before Content
        add_action('wep_category_before_content', array('WEP_Page_Category_View', 'render_wep_common_keywords'), 10);

        // Category Title
        add_action('wep_category_heading', array('WEP_Page_Category_View', 'render_wep_category_title'), 10);

        // Main Content Sections
        add_action('wep_category_content', array('WEP_Page_Category_View', 'render_wep_category_news_list'), 10);

        // Category After Content
        add_action('wep_category_after_content', array('WEP_Page_Category_View', 'render_wep_category_pagenav'), 10);

        // Category Sidebar
        add_action('wep_category_sidebar', array('WEP_Page_Category_View', 'render_sidebar'), 10);

        // Output
        self::render_content();
    }

    /* Get Content - Endpoint ========================================== */
    static public function render_content() {

        WEP_Tag::render_bs_tag('container', 'div', 'Đây là trang chuyên mục bài viết');

        // Begin Row
        WEP_Tag::render_bs_tag('row');

        WEP_Tag::render_bs_tag('col-12');

        /**
         * Hook: wep_category_before_content.
         *
         * @hooked render_wep_common_keywords - 10
         */
        do_action('wep_before_category_content');

        WEP_Tag::render_bs_close_tag();

        WEP_Tag::render_bs_close_tag();

        // End Row

        // Title
        WEP_Tag::render_bs_tag('row');
        WEP_Tag::render_bs_tag('col-12');
        WEP_Tag::render_bs_tag('wep_service__title_wrapper');

        /**
         * Hook: wep_category_heading.
         *
         * @hooked render_wep_category_title - 10
         */
        do_action('wep_category_heading');

        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();

        // Begin Row 2
        WEP_Tag::render_bs_tag('row');

        // Begin Main Content
        WEP_Tag::render_bs_tag('col-12 col-md-9');

        WEP_Tag::render_bs_tag('wep_news_category');

        do_action('wep_category_content');


        /* Start the Loop */
        // while (have_posts()) :
        //     the_post();

        //     /**
        //      * Hook: wep_category_content.
        //      *
        //      * @hooked render_wep_category_news_list - 10
        //      */
        //     do_action('wep_category_content');

        //     the_content();
        // endwhile;
        // End of the loop.

        /**
         * Hook: wep_category_after_content.
         *
         * @hooked render_wep_category_pagenav - 10
         */
        do_action('wep_category_after_content');

        WEP_Tag::render_bs_close_tag();

        WEP_Tag::render_bs_close_tag();
        // End of Main Content

        /**
         * Hook: wep_category_sidebar.
         *
         * @hooked render_sidebar - 10
         */
        do_action('wep_category_sidebar');


        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
        // End of Row 2
    }

}
