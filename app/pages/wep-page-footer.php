
<?php

/* Page Footer Class */

class WEP_Page_Footer {

    /* Init */
    public function __construct() {        

        // Footer General
        add_action('wep_before_footer', array('WEP_Page_Footer_View', 'render_footer_general'), 10);

        // Footer Sections
        add_action('wep_footer_sections', array('WEP_Page_Footer_View', 'render_wep_footer_top'), 10);
        add_action('wep_footer_sections', array('WEP_Page_Footer_View', 'render_wep_footer_bottom'), 20);
        add_action('wep_footer_sections', array('WEP_Page_Footer_View', 'render_wep_footer_chatters'), 30);

        // Footer Sticky
        add_action('wep_footer_sticky', array('WEP_Page_Footer_View', 'render_footer_sticky'), 10);

        // Footer End
        add_action('wep_after_footer', array('WEP_Page_Footer_View', 'render_wep_footer_end'), 10);

        // Output
        self::render_footer();
    }


    /* Get Footer Endpoint ============================ */
    static public function render_footer() {        

        /**
         * Hook: wep_before_footer.
         *
         * @hooked render_footer_general - 10
         */
        do_action('wep_before_footer');

        WEP_Tag::render_bs_tag(['tag' => 'footer', 'class' => 'footer', 'id' => 'wep_footer']);

        /* Begin Footer content */
        WEP_Tag::render_bs_tag('container p-3');

        /**
         * Hook: wep_footer_sections.
         *
         * @hooked render_wep_footer_top - 10
         * @hooked render_wep_footer_bottom - 20
         * @hooked render_wep_footer_chatters - 30
         */
        do_action('wep_footer_sections');

        WEP_Tag::render_bs_close_tag();
        /* End of Footer Content */

        /**
         * Hook: wep_footer_sticky.
         *
         * @hooked render_wep_footer_sticky - 10         
         */
        do_action('wep_footer_sticky');

        WEP_Tag::render_bs_close_tag('footer');


        /**
         * Hook: wep_after_footer.
         *
         * @hooked render_wep_footer_end - 10
         */
        do_action('wep_after_footer');
    }
}
