<?php

/* Page Single View Class */

class WEP_Page_Single_View {

    /* ========= All get methods output to page template ============== */

    // Single Title
    static function render_wep_single_title() {
        get_template_part('parts/single-post/post', 'title', array('heading' => 'XE ĐIỆN TẠI MỸ TỒN GẦN 10 VẠN CHIẾC, VINFAST BÁN ĐƯỢC BAO NHIÊU?'));
    }

    // Single Meta
    static function render_wep_single_meta() {
        if (!is_page()) :
            get_template_part('parts/single-post/post', 'meta', array('heading' => 'Ngày đăng')); // author - date
        endif;
    }

    // Single Summary
    static function render_wep_single_summary() {
        if (!is_page()) :
            get_template_part('parts/single-post/post', 'summary', array('heading' => 'Tóm tắt'));
        endif;
    }

    // Single Content
    static function render_wep_single_content() {
        get_template_part('parts/single-post/post', 'content', array('heading' => 'Nội dung'));
    }

    // Single Shared
    static function render_wep_single_shared() {
        if (!is_page()) :

            get_template_part('parts/single-post/post', 'shared', array('heading' => 'Chia sẻ'));
        endif;
    }

    // Single Author
    static function render_wep_single_author() {
        if (!is_page()) :
            get_template_part('parts/single-post/post', 'author', array('heading' => 'Tác giả'));
        endif;
    }

    // Single Related Posts
    static function render_wep_single_related_before_after() {

        if (!is_page()) :
            global $general_options;
            $show_on_detail = $general_options['wep_other_detail_news_options__wep_detail_news_service_show'];

            if (in_array('related', $show_on_detail)) :
                get_template_part('parts/single-post/post', 'related-before-after', array('heading' => 'Bài viết liên quan'));
            endif;
        endif;
    }

    // Single FAQs
    static function render_wep_single_faqs() {
        global $general_options;
        $show_on_detail = $general_options['wep_other_detail_news_options__wep_detail_news_service_show'];

        if (in_array('faqs', $show_on_detail)) :
            get_template_part('parts/single-post/post', 'faqs', array('heading' => 'Câu hỏi thường gặp'));
        endif;
    }

    // Single Comments
    static function render_wep_single_comments() {
        global $general_options;
        $show_on_detail = $general_options['wep_other_detail_news_options__wep_detail_news_service_show'];

        if (in_array('comments', $show_on_detail)) :
            get_template_part('parts/comments/comments', 'post', array('heading' => 'Hỏi đáp'));
            
        endif;
    }

    // Single Sidebar
    static function render_sidebar() {
        /* Get Sidebar Single */
        new WEP_Sidebar();
    }
}
