<?php

/* Page Header View Class */

class WEP_Page_Header_View {
    /* ========= All get methods output to page template ============== */

    // Render header meta
    static function render_wep_header_meta() {
        get_template_part('parts/header/header', 'meta');
    }

    // Render header top
    static function render_wep_header_top() {
        get_template_part('parts/header/header', 'top');
    }

    // Render header middle
    static function render_wep_header_middle() {
        get_template_part('parts/header/header', 'middle');
    }

    // Render header bottom
    static function render_wep_header_bottom() {
        get_template_part('parts/header/header', 'bottom');
    }

    // Render header end
    static function render_wep_header_general() {

        get_template_part('parts/popup/search', 'result');

        // Main Navigation
        WEP_Tag::render_bs_tag('bvdt_headnav header__row d-flex');

        WEP_Shortcode::render('[wep_main_nav]');

        WEP_Tag::render_bs_close_tag();

        // Begin General Top Sections
        WEP_Tag::render_bs_tag('container page_header');

        get_template_part('parts/header/header', 'general');

        // End General Top Sections
        WEP_Tag::render_bs_close_tag();
    }
}
