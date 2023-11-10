<?php

/* Page Single Product View Class */

class WEP_Page_Single_Product_View {

    /* ========= All get methods output to page template ============== */

    // Sticky
    static function render_wep_single_product_header_sticky() {
        get_template_part('parts/single-product/service-header-sticky', null, array('heading' => 'Product Sticky'));
    }

    // Title
    static function render_wep_single_product_title() {
        get_template_part('parts/single-product/service', 'title', array('heading' => 'Tên dịch vụ - sản phẩm'));
    }

    // Shared
    static function render_wep_single_product_shared() {
        get_template_part('parts/single-product/service', 'shared', array('heading' => 'Chia sẻ'));
    }

    // Gallery
    static function render_wep_single_product_gallery() {
        get_template_part('parts/single-product/service', 'gallery', array('heading' => 'Hình ảnh sản phẩm'));
    }

    // Detail
    static function render_wep_single_product_service_detail() {
        get_template_part('parts/single-product/service', 'detail', array('heading' => 'Chi tiết dịch vụ'));
    }

    // Meta
    static function render_wep_single_product_meta() {
        get_template_part('parts/single-product/service', 'meta', array('heading' => 'Giá - Thời gian - Bảo hành')); // pricing - time- warranty 
    }

    // Attributes
    static function render_wep_single_product_attributes() {
        get_template_part('parts/single-product/service', 'attributes', array('heading' => 'Chọn loại - kích thước'));
    }

    // Offters
    static function render_wep_single_product_offters() {
        get_template_part('parts/single-product/service', 'offers', array('heading' => 'Ưu đãi'));
    }

    // Booking
    static function render_wep_single_product_cta_booking() {
        get_template_part('parts/single-product/service', 'cta-booking', array('heading' => 'Đặt lịch dịch vụ - Hotline - Zalo'));
    }

    // Suggestion
    static function render_wep_single_product_suggestion() {
        get_template_part('parts/single-product/service', 'suggestion', array('heading' => 'Gợi ý tìm kiếm Google'));
    }

    // Real Photos
    static function render_wep_single_product_real_photos() {
        get_template_part('parts/single-product/service', 'real-photos', array('heading' => 'Hình ảnh thực'));
    }

    // Tabs
    static function render_wep_single_product_tabs() {

        /**
         * Hook: wep_single_product_before_tabs.
         *
         * @hooked nothing
         */
        do_action('wep_single_product_before_tabs');

        get_template_part('parts/single-product/service', 'tabs', array('heading' => 'Tab thông tin thêm'));

        /**
         * Hook: wep_single_product_after_tabs.
         *
         * @hooked render_wep_single_product_after_tabs - 10
         */
        do_action('wep_single_product_after_tabs');
    }

    // Add Related after WEP Tab
    static function render_wep_single_product_after_tabs() {

        $product_id = get_the_ID();

        // Lấy thông số
        $related_products_show = WEP_Option_Model::get_group_field('wep_single_service_related', 'wep_single_service_related_show', $product_id);      

        if ($related_products_show) :
            WEP_Tag::render_bs_tag(array(
                'tag' => 'section',
                'class' => 'wep_service__related shadow p-3 mb-3',
                'prop' => 'pid="' . $product_id . '"'
            ));

            /* Empy for load Ajax Related Here */
            WEP_Tag::render_bs_tag(array(
                'class' => 'related_products',
                'id' => 'single_related_products',
            ));

            WEP_Tag::render_bs_close_tag();

            WEP_Tag::render_bs_close_tag('section');

        endif;
    }

    // FAQS
    static function render_wep_single_product_faqs() {

        $current_faqs_show = false;
        $current_using_global = true;
        $current_select_set = true;
        $current_selected_set_id = null;
        $current_selected_faqs = null;
        $current_cat_selected_set_id = null;
        $current_cat_selected_faqs = null;


        // default faqs
        global $general_options;
        $show_faqs_option = $general_options['wep_other_detail_service_options__wep_show_faqs_on'];
        $default_faqs_set = $general_options['wep_general_category_service_options__wep_general_product_cat_faqs_default'];


        // Get current option
        $product_id = get_the_ID();
        $current_select_set = WEP_Option_Model::get_group_field('wep_single_service_faqs', 'wep_single_service_faqs_select_set', $product_id);

        // => get selected set / faqs
        if ($current_select_set) :
            $current_selected_set_id = WEP_Option_Model::get_group_field('wep_single_service_faqs', 'wep_single_service_faqs_select_a_set', $product_id);
        else :
            $current_selected_faqs = WEP_Option_Model::get_group_field('wep_single_service_faqs', 'wep_single_service_faqs_select_multi_item', $product_id);
        endif;

        // category faqs        
        $current_categories = WEP_Product_Model::get_product_categories($product_id);
        if ($current_categories) :

            $keys = array_keys($current_categories);
            $main_category_id = $keys[0];

            // get showing
            $show_faqs_cat_option = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_show_faqs', 'product_cat', 'wep_product_cat_faqs', $main_category_id);

            // get set by category
            if ($show_faqs_cat_option) :
                $current_category_use_global = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_use_general_faqs', 'product_cat', 'wep_product_cat_faqs', $main_category_id);

                // Nếu không sử dụng global
                if (!$current_category_use_global) :

                    // no using global
                    $current_using_global = false;

                    $current_cat_selected_used_set = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_use_type_faqs', 'product_cat', 'wep_product_cat_faqs', $main_category_id);
                    if ($current_cat_selected_used_set == 'set') :
                        $current_select_set = true;
                        $current_cat_selected_set_id = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_use_set_faqs', 'product_cat', 'wep_product_cat_faqs', $main_category_id);

                        // Nếu không chọn thì dùng mặc global
                        if (!$current_cat_selected_set_id) :
                            $current_cat_selected_set_id = $default_faqs_set;
                            $current_selected_set_id = $current_cat_selected_set_id;
                        else :
                            $current_selected_set_id = $current_cat_selected_set_id;
                        endif;
                    else :
                        $current_select_set = false;
                        $current_cat_selected_faqs = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_use_custom_faqs', 'product_cat', 'wep_product_cat_faqs', $main_category_id);
                        if ($current_cat_selected_faqs) :
                            $current_selected_faqs = $current_cat_selected_faqs;
                        endif;

                    endif;

                else :
                    // using global
                    $current_using_global = true;
                    $current_faqs_show = $show_faqs_option;
                    $current_selected_set_id = $default_faqs_set;
                endif;
            endif;

            // is showing
            $current_faqs_show = $show_faqs_cat_option; // show by category            

        endif;

        // Nếu chi tiết không chọn bộ hay gì sẽ dùng phần category và global
        // Chọn theo bộ hay theo danh sách faqs
        if ($current_select_set) : // nếu chọn theo bộ

            // Láy ID của bộ faqs
            $current_selected_set_id = WEP_Option_Model::get_group_field('wep_single_service_faqs', 'wep_single_service_faqs_select_a_set', $product_id);
            // Nếu không có chọn thì lấy theo category
            if (!$current_selected_set_id) :
                $current_selected_set_id = $current_cat_selected_set_id;
            endif;
        else : // nếu chọn theo danh sách

            // nếu chọn theo danh sách thì lấy list ids của faqs
            $current_selected_faqs = WEP_Option_Model::get_group_field('wep_single_service_faqs', 'wep_single_service_faqs_select_multi_item', $product_id);
            // Nếu không có chọn thì lấy theo category
            if (!$current_selected_faqs) :
                $current_selected_faqs = $current_cat_selected_faqs;
            endif;
        endif;


        // Kết quả cần render
        $faqs_result = array(
            'heading' => 'Câu hỏi thường gặp',
            'faqs_global' => $current_using_global,
            'faqs_used_set' => $current_select_set,
            'faqs_show' => $current_faqs_show,
            'faqs_set_id' => $current_selected_set_id,
            'faqs_ids' => $current_selected_faqs,
        );

        if ($current_faqs_show) :

            // Gán biến global để truy cập từ bên ngoài
            global $wep_faqs_result;
            $wep_faqs_result = $faqs_result;

            get_template_part('parts/comments/comments-faqs', null);

        endif;
    }

    // Comments
    static function render_wep_single_product_comments() {
        global $general_options;
        $show_comment_option = $general_options['wep_other_detail_service_options__wep_show_comments_on'];
        $show_comment_on_service = in_array('service', $show_comment_option);

        if ($show_comment_on_service) :
        //get_template_part('parts/comments/comments', 'service', array('heading' => 'Hỏi đáp'));
        endif;
    }

    // Review
    static function render_wep_single_product_review() {

        global $general_options;
        $show_review_option = $general_options['wep_other_detail_service_options__wep_show_review_on'];
        $show_review_on_service = in_array('service', $show_review_option);

        if ($show_review_on_service) :
            get_template_part('parts/single-product/service-review', null, array('heading' => 'Đánh giá'));
        endif;
    }

    // Review
    static function render_wep_get_sidebar() {
        /* Get Sidebar Single */

        new WEP_Sidebar('product');
    }
}
