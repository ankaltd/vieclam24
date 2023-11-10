<?php

/* Page Category Product View Class */

class WEP_Page_Category_Product_View {

    /* ========= All get methods output to page template ============== */

    // Top Description
    static function render_wep_category_product_top_description() {
        get_template_part('parts/category-product/service-description', 'top', array('heading' => 'Mô tả trên'));
    }

    // Keywords
    static function render_wep_common_keywords() {
        if (is_product_category()) {
            $category = get_queried_object();
            $category_id = $category->term_id;
            if ($category_id) :

                $wep_use_product_cat_services_list = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_services_list_used', 'product_cat', 'wep_product_cat_popular_services', $category_id);
                $wep_product_cat_list_keywords = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_services_list', 'product_cat', 'wep_product_cat_popular_services', $category_id);
                $wep_product_cat_list_custom = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_services_list_custom', 'product_cat', 'wep_product_cat_popular_services', $category_id);
                $wep_product_cat_list_link_custom = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_services_list_content', 'product_cat', 'wep_product_cat_popular_services', $category_id);

                if ($wep_use_product_cat_services_list) :
                    if (($wep_product_cat_list_custom && $wep_product_cat_list_link_custom) || (!$wep_product_cat_list_custom && $wep_product_cat_list_keywords)) :
                        get_template_part('parts/common/keyword-buttons', null, array('heading' => 'Dịch vụ thông dụng'));
                    endif;
                endif;
            endif;
        }
    }

    // Category Title
    static function render_wep_category_product_title() {
        WEP_Tag::render_bs_tag(array('tag' => 'h2', 'class' => 'mb-3 wep_section_heading wep_border--bottom'));
        woocommerce_page_title();
        WEP_Tag::render_bs_close_tag('h2');
    }

    // Category Sidebar
    static function render_sidebar() {
        /* Get Sidebar Category Service */
        new WEP_Sidebar('product-category');
    }

    // Sorting
    static function render_wep_category_product_sorting() {
        get_template_part('parts/category-product/service-sorting', null, array('heading' => 'Sắp xếp...'));
    }

    // Filtering
    static function render_wep_category_product_filtering() {
        get_template_part('parts/category-product/service-filtering', null, array('heading' => 'Sắp xếp...'));
    }

    // Grid
    static function render_wep_category_product_grid() {
        get_template_part('parts/category-product/service-grid', null, array('heading' => 'Danh sách dịch vụ'));
    }

    // Grid Item
    static function render_wep_category_product_content_item() {
        get_template_part('parts/category-product/service-item', null, array('heading' => 'Mục dịch vụ'));
    }

    // PageNav Temp
    static function render_wep_category_product_pagenav() {
        get_template_part('parts/category-product/service-pagenav', null, array('heading' => 'Phân trang dịch vụ'));
    }

    // Render PageNav
    static function render_wep_product_pagenav($current_page, $total_pages, $total_products) {
        echo '<section class="wep_pagenav">';

        $pagination = paginate_links(
            array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%/',
                'current' => $current_page,
                'total' => $total_pages - 1,
                'type' => 'list', // Loại phân trang
            )
        );

        // Tùy chỉnh mẫu HTML cho danh sách phân trang
        $pagination = str_replace('<ul class=\'page-numbers\'>', '<ul class="pagination">', $pagination);
        $pagination = str_replace('<li>', '<li class="page-item">', $pagination);
        $pagination = str_replace('page-numbers', 'page-item', $pagination);
        $pagination = str_replace('current', 'page-item active', $pagination);
        $pagination = str_replace('<span class="page-numbers dots">', '<li class="page-item disabled"><span class="page-link">...</span></li>', $pagination);
        $pagination = str_replace('<a class="page-numbers"', '<a class="page-link"', $pagination);
        $pagination = str_replace('<a class="page-item"', '<a class="page-link"', $pagination);
        $pagination = str_replace('</a>', '</a></li>', $pagination);

        echo $pagination;

        echo '</section>';
    }

    // Bottom Description
    static function render_wep_category_product_bottom_description() {
        get_template_part('parts/category-product/service-description-bottom', null, array('heading' => 'Mô tả dưới'));
    }

    // Category FAQs
    static function render_wep_category_product_faqs() {

        $current_faqs_show = false;
        $current_using_global = true;
        $current_select_set = true;
        $current_cat_selected_set_id = null;
        $current_cat_selected_faqs = null;


        // default faqs
        global $general_options;
        $show_faqs_option = $general_options['wep_other_detail_service_options__wep_show_faqs_on'];
        $default_faqs_set = $general_options['wep_general_category_service_options__wep_general_product_cat_faqs_default'];

        // category faqs        

        if (is_product_category()) {
            $category = get_queried_object();
            $category_id = $category->term_id;
            if ($category_id) :

                $main_category_id = $category_id;

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
                            endif;
                        else :
                            $current_select_set = false;
                            $current_cat_selected_faqs = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_use_custom_faqs', 'product_cat', 'wep_product_cat_faqs', $main_category_id);

                        endif;

                    else :
                        // using global
                        $current_using_global = true;
                        $current_faqs_show = $show_faqs_option;
                        $current_cat_selected_set_id = $default_faqs_set;
                    endif;
                endif;

                // is showing
                $current_faqs_show = $show_faqs_cat_option; // show by category   
            endif;
        }

        // Kết quả cần render
        $faqs_result = array(
            'heading' => 'Câu hỏi thường gặp',
            'faqs_global' => $current_using_global,
            'faqs_used_set' => $current_select_set,
            'faqs_show' => $current_faqs_show,
            'faqs_set_id' => $current_cat_selected_set_id,
            'faqs_ids' => $current_cat_selected_faqs,
        );


        // Kiểm tra xem có hiện FAQs không
        $show_faqs = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_show_faqs', 'product_cat', 'wep_product_cat_faqs');
        if ($show_faqs) :

            // Gán biến global để truy cập từ bên ngoài
            global $wep_faqs_result;
            $wep_faqs_result = $faqs_result;

            // get_template_part('parts/common/faqs', null, array('heading' => 'Câu hỏi thường gặp'));
            get_template_part('parts/comments/comments-faqs', null);
        endif;
    }

    // Category Comments
    static function render_wep_category_product_comments() {
        // Kiểm tra xem có hiển thị comments không
        global $general_options;
        $show_components = $general_options['wep_general_category_service_options__wep_general_category_service_components'];
        $show_comments = in_array('comments', $show_components);

        if ($show_comments) :
            get_template_part('parts/comments/comments-category', null, array('heading' => 'Hỏi đáp - Nhận xét'));
        endif;
    }
}
