<?php

/** 
 * Class Option Model
 */

class WEP_Option_Model {

    /* 
    * Thuộc tính private lưu trữ giá trị mặc định của các option
    * Đọc trong group thì giá trị là array liệt kê tên field thuộc group (array)
    * Để tự động đọc hết các giá trị thì để dạng (true)
    */

    private static $wep_general = array(
        'wep_single_page_template'  => '',
        'wep_category_page_template'  => '',
        'wep_single_service_page_template'  => '',
        'wep_category_service_page_template'  => '',
        'wep_contact_page_template'  => '',
        'wep_search_page_template'  => '',
        'wep_404_page_template'  => '',
        'wep_general_options' => array(
            'wep_logo' => '',
            'wep_dark_version_logo' => '',
        ),
        'wep_mobile_options' => array(
            'wep_mobile_logo_using_desktop_logo' => true,
            'wep_mobile_logo' => '',
            'wep_show_chat_buttons_on_mobile' => true,
        ),
        'wep_header_options' => array(
            'wep_header_logo_get_main_logo' => true,
            'wep_header_logo' => '',
            'wep_header_hotline' => '',
            'wep_header_hotline_text' => '',
            'wep_header_booking_link' => '',
            'wep_header_contact_text' => '',
            'wep_header_contact_link' => '',
            'wep_header_breadcrumb_show_on' => '',
            'wep_header_service_categories_show_on' => '',
            'wep_header_service_categories_selection' => '',
        ),
        'wep_mobile_header_sticky_options' => array(
            'wep_header_sticky_search' => true,
            'wep_header_sticky_breadcrumb' => true,
            'wep_header_sticky_service_categories' => true,
            'wep_header_sticky_service_page' => true,
        ),
        'wep_mobile_footer_sticky_options' => array(
            'wep_mobile_footer_sticky_buttons' => true,
        ),
        'wep_header_scripts' => array(
            'wep_header_meta_gsc' => '',
            'wep_header_gtag_script' => '',
            'wep_header_gtm_head_script' => '',
            'wep_header_gtm_body_script' => '',
            'wep_header_facebook_app_id' => '',
            'wep_header_facebook_admin_id' => '',
            'wep_header_scripts' => '',
            'wep_header_body_scripts' => '',
        ),
        'wep_footer_benefits' => true,
        'wep_footer_columns_list' => true,
        'wep_footer_options' => array(
            'wep_payment_getways_icons' => array(),
            'wep_social_link_icons' => array(),
            'wep_footer_copyright' => '',
        ),
        'wep_footer_scripts' => array(
            'wep_footer_facebook_app_scripts' => '',
            'wep_footer_live_chat_scripts' => '',
            'wep_footer_body_scripts' => '',
        ),
        'wep_css_mobile' => array(
            'wep_custom_css_for_mobile' => ''
        ),
        'wep_css_tablet' => array(
            'wep_custom_css_for_tablet' => ''
        ),
        'wep_css_desktop' => array(
            'wep_custom_css_for_desktop' => ''
        ),
        'wep_general_pricing_promotion_time_options' => array(
            'wep_price_promotion_label' => '',
            'wep_price_promotion_label_short_used' => true,
            'wep_price_promotion_label_short' => '',
            'wep_price_notice' => '',
            'wep_price_free_label' => '',
            'wep_warranty_label' => '',
            'wep_warranty_label_short_used' => true,
            'wep_warranty_label_short' => '',
            'wep_repair_time_label_short' => '',
            'wep_repair_time_label_short' => true,
            'wep_repair_time_label_short' => '',
        ),
        'wep_general_commitment_address' => array(
            'wep_commitment_title' => '',
            'wep_commitment_list' => array(),
            'wep_commitment_show_on' => '',
            'wep_shop_address_title' => '',
            'wep_shop_address_list' => array(),
            'wep_shop_address_show_on' => '',
        ),
        'wep_general_contact_suggestion_services' => array(
            'wep_service_booking_button_text' => '',
            'wep_service_consultant_zalo' => '',
            'wep_service_consultant_facebook' => '',
            'wep_service_hotline_phone' => '',
        ),
        'wep_general_category_service_options' => array(
            'wep_general_category_service_components' => '',
            'wep_general_product_cat_banner_default' => '',
            'wep_general_product_cat_faqs_default' => '',
        ),
        'wep_general_detail_service_options' => array(
            'wep_show_banner_on' => '',
            'wep_banner_default' => '',
            'wep_show_offters_on' => '',
            'wep_offers_label' => '',
            'wep_offers_label_short_used' => '',
            'wep_offers_label_short' => '',
            'wep_offers_default' => '',
            'wep_show_detail_table_on' => '',
            'wep_detail_table_default' => '',
            'wep_show_description_on' => '',
            'wep_description_default' => '',
            'wep_show_more_information_on' => '',
            'wep_pricing_table_default' => '',
            'wep_show_warranty_policy_on' => '',
            'wep_warranty_policy_default' => '',
        ),
        'wep_other_detail_service_options' => array(
            'wep_show_real_photo_gallery_on' => '',
            'wep_real_photo_heading' => '',
            'wep_show_cross_sale_on' => '',
            'wep_cross_sale_heading' => '',
            'wep_show_cross_related_on' => '',
            'wep_cross_related_heading' => '',
            'wep_show_faqs_on' => '',
            'wep_show_comments_on' => '',
            'wep_show_review_on' => '',
            'wep_faqs_heading' => '',
            'wep_review_heading' => '',
        ),
        'wep_general_category_service_filter' => array(
            'wep_general_category_product_filtering_bar' => '',
            'wep_general_category_product_filter_condition' => '',
            'wep_general_category_service_filter_boxes' => '',
            'wep_general_category_product_filter_boxes' => '',
        ),
        'wep_general_detail_news_options' => array(
            'wep_detail_news_section_show' => '',
            'wep_banner_default' => '',
            'wep_related_news_heading' => '',
            'wep_related_news_type' => '',
            'wep_lastest_news_heading' => '',
            'wep_lastest_news_type' => '',
            'wep_lastest_news_featured' => '',
        ),
        'wep_other_detail_news_options' => array(
            'wep_detail_news_service_show' => '',
            'wep_show_cross_related_on' => '',
            'wep_cross_related_heading' => '',
            'wep_show_faqs_on' => '',
            'wep_faqs_heading' => '',
        ),
        'wep_general_category_news_options' => array(
            'wep_detail_news_section_show' => '',
            'wep_banner_default' => '',
        ),
        'wep_general_contact_options' => array(
            'wep_contact_section_show' => '',
            'wep_banner_default' => '',
        ),
        'wep_general_contact_information' => array(
            'wep_contact_form_heading' => '',
            'wep_contact_form' => '',
            'wep_contact_form_content' => '',
        ),


    );

    // Home
    private static $wep_home = array(
        'wep_section_banner_hero'  => array(
            'wep_home_banner_slider' => '',
            'wep_home_banner_captions' => array(),
            'wep_home_banner_hero' => '',
            'wep_home_support_items' => array(),
        ),
        'wep_section_banner_ads'  => array(
            'wep_banner_ads' => '',
        ),
        'wep_section_select_device'  => true,
        'wep_section_service_by_device'  => array(
            'wep_section_service_device_list' => true,
        ),
        'wep_section_accessories'  => array(
            'wep_home_accessories_heading' => '',
            'wep_home_accessories_list_type' => '',
            'wep_home_accessories_number' => '',
            'wep_home_accessories_category_product' => '',
            'wep_home_accessories_selection' => '',
        ),
        'wep_section_featured_news'  => true,
    );

    // Check option from current cate and general
    static function get_product_cat_option($general_field_option_name, $using_global_cat_field_name, $product_cat_field_name) {
        global $general_options;

        $current_category = get_queried_object(); // Lấy đối tượng chuyên mục hiện tại
        $category_id = $current_category->term_id; // Lấy ID của chuyên mục


        // General Option filter boxes
        $filter_boxes_show = $general_options[$general_field_option_name];

        // using global field
        $using_global = self::get_field_in_taxonomy($using_global_cat_field_name, 'product_cat', 'wep_product_cat_filter', $category_id);

        // product cat option filter boxed
        $filter_boxes_cat_show = self::get_field_in_taxonomy($product_cat_field_name, 'product_cat', 'wep_product_cat_filter', $category_id);

        if ($using_global) {
            $result = $filter_boxes_show;
        } else {
            $result = $filter_boxes_cat_show;
        }

        // WEP_Helper::print_struct($result);

        $result = $filter_boxes_show;

        return $result;
    }

    // Get option from array
    static function get_options_by_id($data, $key, $value) {
        $result = null;

        foreach ($data as $item) {
            if (isset($item[$key]) && $item[$key] === $value) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

    // get option with language
    static function get_field_lang($field_name, $option = true) {

        // ngôn ngữ khác ngôn ngữ chính vi thì sẽ là tiếng anh
        if (function_exists('pll_current_language')) {
            $lang_slug = pll_current_language() == 'vi' ? '' : '_en';
        } else {
            $lang_slug = '';
        }

        // lấy tên của biến option theo ngôn ngữ option_name_[lang]
        $lang_field_name = $field_name . $lang_slug;

        // lấy giá trị theo trường option (global), nếu không là invidual page
        $result = $option ? get_field($field_name, 'option') : get_field($field_name);

        // lấy giá trị theo option và theo ngôn ngữ
        $result_lang = $option ? get_field($lang_field_name, 'option') : get_field($lang_field_name);

        // nếu cung cấp trường ngôn ngữ sẽ lấy theo ngôn ngữ, nếu không bất cứ ngôn ngữ nào cũng lấy option gốc ngôn ngữ mặc định 
        $result = $result_lang ? $result_lang : $result;

        return $result;
    }

    // get fields ver 2 from array multi level with group
    static function get_acf_field_values($fields, $in_option = false, $post_id = 0) {
        $result = array();
        $fiels_false_arr = array('wep_image_list');

        // Lặp qua từng phần trong mảng fields
        foreach ($fields as $key => $default) {

            // get type of field
            // $field_maybe = acf_maybe_get_field($key, false, false);
            // $field_type = $field_maybe['type'];

            // Nếu giá trị luôn không phải là một array thì xử lý bình thường
            if (!is_array($default)) :

                // check get global options of invidual page options
                if ($in_option) :
                    $value = get_field($key, 'option');
                else :
                    if ($post_id === 0) :
                        $value = get_field($key);
                    else :
                        $value = get_field($key, $post_id);
                    endif;
                endif;

                if (is_null($value) || (in_array($key, $fiels_false_arr) && $value === false)) :
                    $result[$key] = $default;
                else :
                    $result[$key] = $value;
                endif;

            // Nếu là một array thì cần phải đọc giá trị sub_field bên trong group | repeat này
            else :

                // check get global options 
                if ($in_option) :

                    // if ($field_type == 'group') :
                    // get all value inside group
                    $group_field_value = get_field($key, 'option');

                    // Lấy giá trị của các subfields
                    foreach ($default as $sub_key => $sub_default) {

                        $sub_value = $group_field_value[$sub_key];

                        // generate sub_key
                        $sub_key_name = $key . '__' . $sub_key;
                        if (is_null($sub_value) || (in_array($sub_key, $fiels_false_arr) && $sub_value === false)) :
                            $result[$sub_key_name] = $sub_default;
                        else :
                            $result[$sub_key_name] = $sub_value;
                        endif;
                    }
                // elseif ($field_type == 'repeater') :
                //     // Check rows existexists. - kiểm tra xem có group hay repeat không
                //     if (have_rows($key, 'option')) :

                //         // Loop through rows.
                //         while (have_rows($key, 'option')) : the_row();

                //             $result_row = [];

                //             // Lấy giá trị của các subfields
                //             foreach ($default as $sub_key => $sub_default) {

                //                 $sub_value = get_sub_field($sub_key);

                //                 // generate sub_key
                //                 $sub_key_name = $key . '__' . $sub_key;
                //                 if (is_null($sub_value) || (in_array($sub_key, $fiels_false_arr) && $sub_value === false)) :
                //                     $result_row[$sub_key_name] = $sub_default;
                //                 else :
                //                     $result_row[$sub_key_name] = $sub_value;
                //                 endif;
                //             }

                //             // Đưa giá trị vào mảng
                //             $result[$key][] = $result_row;

                //         // End loop.
                //         endwhile;
                //     endif;
                // endif;

                // if not in option
                else :

                    // Check rows existexists. - kiểm tra xem có group hay repeat không
                    if (have_rows($key)) :

                        // Loop through rows.
                        while (have_rows($key)) : the_row();

                            // Lấy giá trị của các subfields
                            foreach ($default as $sub_key => $sub_default) {

                                if ($post_id === 0) :
                                    $sub_value = get_sub_field($sub_key);
                                else :
                                    $sub_value = get_sub_field($sub_key, $post_id);
                                endif;

                                // generate sub_key
                                $sub_key_name = $key . '__' . $sub_key;
                                if (is_null($sub_value) || (in_array($sub_key, $fiels_false_arr) && $sub_value === false)) :
                                    $result[$sub_key_name] = $sub_default;
                                else :
                                    $result[$sub_key_name] = $sub_value;
                                endif;
                            }


                        // End loop.
                        endwhile;
                    endif;

                endif;


            endif;
        }

        // Trả ra kết quả
        return $result;
    }

    // Lấy giá trị option từ file JSON
    public static function get_options_json($file_json) {
        // Đọc nội dung file
        $json = file_get_contents(THEME_CONFIG . '/option-json/' . $file_json);

        // Chuyển đổi chuỗi JSON thành mảng
        $results = json_decode($json, true);

        // Trả về mảng chứa dữ liệu
        return $results;
    }

    // get general option
    static function get_general_options() {
        return self::$wep_general;
    }

    // get home option
    static function get_home_options() {
        return self::$wep_home;
    }

    // get news option
    static function get_news_options() {
        return self::$news_options;
    }

    // get content option
    static function get_content_options() {
        return self::$content_options;
    }

    // get section option
    static function get_section_options() {
        return self::$section_options;
    }

    // get heading option
    static function get_heading_options() {
        return self::$heading_options;
    }

    // get description option
    static function get_description_options() {
        return self::$description_options;
    }

    // get background option
    static function get_background_options() {
        return self::$background_options;
    }

    // get image option
    static function get_image_options() {
        return self::$image_options;
    }

    // get video option
    static function get_video_options() {
        return self::$video_options;
    }

    // List section by template
    private $section_by_template = array(
        'slider/head-carousel' => 'header_photo',
        'slider/head-banner' => 'header_photo',
    );

    // Get section by template
    public function get_section_by_template($section_template) {

        if (array_key_exists($section_template, $this->section_by_template)) {
            return $this->section_by_template[$section_template];
        } else {
            return 'header_photo';
        }
    }

    // get list child term by id and taxonomy
    static function get_child_terms_info($parent_term_id, $taxonomy) {
        $child_terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'child_of' => $parent_term_id,
        ));

        $term_info = array();

        if (!empty($child_terms) && !is_wp_error($child_terms)) {
            foreach ($child_terms as $child_term) {
                $term_id = $child_term->term_id;
                $term_link = get_term_link($child_term);
                $term_title = $child_term->name;
                $acf_short_value = get_field('wep_product_cat_short_name', $taxonomy . '_' . $term_id); // Thay 'short' bằng tên trường ACF của bạn.

                $term_info[] = array(
                    'term_id' => $term_id,
                    'term_link' => $term_link,
                    'term_title' => $term_title,
                    'acf_short_value' => $acf_short_value,
                );
            }
        }

        return $term_info;
    }

    // Get keywordlist 2
    public static function get_keyword_list_slider($term_ids) {

        $final_list = array();

        if ($term_ids) :
            foreach ($term_ids as $item) {
                extract($item);
                $arr_temp['id'] = $term_id;
                $arr_temp['text'] = $name;
                $arr_temp['url'] = get_term_link($term_id);
                $arr_temp['short'] = self::get_field_by_term('wep_product_cat_short_name', 'product_cat', $term_id);

                if (is_null($arr_temp['short']) || empty($arr_temp['short'])) {
                    $arr_temp['short'] = $arr_temp['text'];
                }

                $final_list[$term_id] = $arr_temp;
            }
        endif;

        return $final_list;
    }

    // Get keword list
    public static function get_keyword_list($term_ids) {
        $keyword_list = array();

        if ($term_ids) :
            foreach ($term_ids as $term_id) {
                $sub_term = get_term($term_id);
                $arr_temp['id'] = $term_id;
                $arr_temp['text'] = $sub_term->name;
                $arr_temp['url'] = get_term_link($term_id);
                $arr_temp['short'] = self::get_field_by_term('wep_product_cat_short_name', 'product_cat', $term_id);

                if (is_null($arr_temp['short']) || empty($arr_temp['short'])) {
                    $arr_temp['short'] = $arr_temp['text'];
                }

                $keyword_list[$term_id] = $arr_temp;
            }
        endif;

        return $keyword_list;
    }

    // Lấy giá trị field bên trong group 
    public static function get_group_field(string $group, string $field, $post_id = 0) {
        $group_data = get_field($group, $post_id);
        if (is_array($group_data) && array_key_exists($field, $group_data)) {
            return $group_data[$field];
        }
        return null;
    }

    // Lấy giá trị field bên trong group thuộc taxonomy
    public static function get_field_in_taxonomy($field_name, $taxonomy = 'category', $group_name = '', $term_id = 0) {

        // Nếu $term_id là 0, lấy term_id của trang hiện tại
        if ($term_id == 0) {
            $queried_object = get_queried_object();
            if ($queried_object) {
                $term_id = $queried_object->term_id;
            }
        }


        // Lấy term object
        $term = get_term($term_id, $taxonomy);
        $result = null;

        if ($term) {

            // has group
            if ($group_name != '') {
                // Lấy giá trị của trường nhóm
                $group_field = get_field($group_name, $term);

                if ($group_field) {
                    // Lấy giá trị của trường trong nhóm
                    $field_value = $group_field[$field_name];
                    $result = $field_value;
                } else {
                    $result = null;
                }
            } else { // no group

                $field_value = self::get_field_by_term($field_name, $taxonomy, $term_id);
                $result = $field_value;
            }
        }

        return $result;
    }


    // Get field value of taxonomy by term id
    static function get_field_by_term($field, $tax_name, $term_id) {
        return get_field($field, $tax_name . '_' . $term_id);
    }

    /*  
    * Using from render.php blocks
        $fields = array(
            'key1' => 'default1',
            'key2' => 'default2',
            // ...
        );

        $option = WEP_Option_Model::get_field_values($fields);

        echo $option['key1']; // In ra giá trị của key1
        echo $option['key2']; // In ra giá trị của key2
    */

    // Get acf block field values from array with default value
    static function get_field_values($fields, $in_option = false) {
        $result = array();
        $fiels_false_arr = array('wep_image_list');

        foreach ($fields as $key => $default) {

            // check get global options of invidual page options
            if ($in_option) {
                $value = get_field($key, 'option');
            } else {
                $value = get_field($key);
            }

            if (is_null($value) || (in_array($key, $fiels_false_arr) && $value === false)) {
                $result[$key] = $default;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    // Get feature url size from url image
    static function get_thumbnail_url($image_url, $image_size_name = 'thumbnail') {

        $thumbnail_url = $image_url;

        // Lấy kích thước từ danh sách image size
        $image_sizes = wp_get_registered_image_subsizes();
        $thumbnail_size = $image_sizes[$image_size_name];

        // Kiểm tra xem attachment có tồn tại không
        if ($thumbnail_size) {
            // Lấy thông tin kích thước thumbnail
            $file_with_size = '-' . $thumbnail_size['width'] . 'x' . $thumbnail_size['height'] . '.';

            $thumbnail_url = str_replace('.', $file_with_size, $image_url);

            // Tìm vị trí cuối cùng của dấu "."
            $dot_position = strrpos($image_url, '.');

            if ($dot_position !== false) {
                // Ghép chuỗi "-widthxheight." vào trước dấu "."
                $thumbnail_url = substr_replace($image_url, $file_with_size, $dot_position, 1);
            }
        }

        return $thumbnail_url;
    }

    /** 
     * Get option by section_name and layout_name 
     * 
     */

    // Get option of current for template - ACF get fields
    public function get_section_option($section_template) {

        $section_option = array();
        $section_option_child_1 = array();

        if (($section_template != '') || ($section_template)) {
            // Get section name
            $section_name = $this->option_model->get_section_by_template($section_template);

            // Get option in section name
            if (have_rows($section_name)) {

                $section_index = 1;
                while (have_rows($section_name)) : the_row();

                    // Case: photo_carousel layout.
                    if (get_row_layout() == 'photo_carousel') :
                        $section_option_child_1['section_type'] = 'photo_carousel';
                        $section_option_child_2 = array();

                        $slider_index = 1;
                        while (have_rows('header_slider_photos')) : the_row();
                            $section_option_child_2['slider_photo_image'] = get_sub_field('slider_photo_image');
                            $section_option_child_2['slider_photo_text'] = get_sub_field('slider_photo_text');
                            $section_option_child_2['slider_photo_image'] = get_sub_field('slider_photo_image');
                            $section_option_child_3 = array();

                            $button_index = 1;
                            while (have_rows('slider_photo_button_add')) : the_row();
                                $section_option_child_3['slider_photo_button_type'] = get_sub_field('slider_photo_button_type');
                                $section_option_child_3['slider_photo_button_text'] = get_sub_field('slider_photo_button_text');
                                $section_option_child_3['slider_photo_button_link'] = get_sub_field('slider_photo_button_link');
                                $section_option_child_3['slider_photo_button_title'] = get_sub_field('slider_photo_button_title');
                                $section_option_child_3['slider_photo_button_arrow'] = get_sub_field('slider_photo_button_arrow');

                                // Level 3 is child of $section_option_level2
                                $section_option_child_2['button_' . $button_index++] = $section_option_child_3;
                            endwhile;

                            // Level 2 is child of $section_option_level1
                            $section_option_child_1['slider_' . $slider_index++] = $section_option_child_2;

                        endwhile;

                    // Case: photo_banner layout.
                    elseif (get_row_layout() == 'photo_banner') :
                        $section_option_child_1['section_type'] = 'photo_banner';

                        while (have_rows('header_slider_photos')) : the_row();
                            $section_option_child_2['section_item'] = the_sub_field('banner_photo_image');
                            $section_option_child_2['section_item'] = the_sub_field('banner_photo_text');
                            $section_option_child_2['section_item'] = the_sub_field('banner_photo_description');
                        endwhile;

                    // // Case: header_background layout.
                    elseif (get_row_layout() == 'header_background') :
                        $section_option_child_1['section_type'] = 'header_background';

                        while (have_rows('header_slider_photos')) : the_row();
                            $section_option_child_1['section_item'] = the_sub_field('header_background_image');
                        endwhile;

                    endif;

                    // Level 1 is child of $section_option
                    $section_option['section_' . $section_index++] = $section_option_child_1;

                endwhile;
            }
        }

        return $section_option;
    }
}
