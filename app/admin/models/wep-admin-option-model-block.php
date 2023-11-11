<?php

/** 
 * Class Option Block Model
 */

class WEP_Option_Block_Model {

    // Content options
    private static $content_options = [
        'ssg_content_image_responsive'      => false,
        'ssg_content_list'                  => array(),
        'ssg_content_show_element'          => array(),
    ];

    // Icon options
    private static $icon_options = [
        'ssg_icon_list'         => array(),
    ];

    // Section default
    private static $section_options = [
        'ssg_section_id'                    => 'ssg_home_service',
        'ssg_section_classes'               => 'ssg_home_service',
        'ssg_section_custom_style'          => false,
        'ssg_section_top_space'             => 100,
        'ssg_section_bottom_space'          => 100,
        'ssg_section_custom_css'            => '',
        'ssg_section_is_anchor'             => false,
        'ssg_section_effect'                => 'none',
        'ssg_section_item_effect'           => false,
        'ssg_section_effect_stay'           => true,
        'ssg_section_effect_heading_desc'   => 'none',
        'ssg_section_effect_item'           => 'none',
        'ssg_section_effect_duration'       => 500,
        'ssg_section_effect_delay'          => 100,
        'ssg_section_effect_delay_interval' => 100,
    ];

    // Heading default
    private static $heading_options = [
        'ssg_heading_text'                  => 'Dịch vụ',
        'ssg_sub_heading_text'              => 'Tiêu đề phụ',
        'ssg_heading_color'                 => '#132239',
        'ssg_sub_heading_color'             => '#132239',
        'ssg_heading_tag'                   => 'h2',
        'ssg_heading_align'                 => 'justify-content-center',
        'ssg_heading_margin_bottom'         => 'default',
    ];

    // Description default
    private static $description_options = [
        'ssg_description_text'              => '',
        'ssg_description_color'             => '',
        'ssg_description_tag'               => 'p',
        'ssg_description_align'             => 'text-center',
        'ssg_description_margin_bottom'     => 'default',
        'ssg_description_font_size'         => 15,
        'ssg_description_line_height'       => 1.7,
    ];

    // Background default
    private static $background_options = [
        'ssg_background_src'                => '',
        'ssg_background_attachment'         => false,
        'ssg_background_color'              => 'inherit',
        'ssg_background_align_x'            => 'center',
        'ssg_background_align_y'            => 'center',
        'ssg_background_size'               => 'auto',
        'ssg_background_repeat'             => 'no-repeat',
        'ssg_background_dark'               => false,
    ];

    // Image Single default
    private static $image_options = [
        'ssg_image_src'               => 'https://demo.ssg.vn/wp-content/themes/ssg/assets/images/about/about-value-1.png',
        'ssg_image_link'              => '#',
        'ssg_image_target'            => false,
        'ssg_image_youtube_video'     => false,
        'ssg_image_youtube_link'      => 'https://www.youtube.com/watch?v=2-VJKjxb4pU',
    ];

    // Video Single default
    private static $video_options = [
        'ssg_video_src'               => '',
        'ssg_video_youtube_video'     => false,
        'ssg_video_youtube_link'      => 'https://www.youtube.com/watch?v=2-VJKjxb4pU',
        'ssg_video_responsive'        => false,
        'ssg_video_alignment'         => 'justify-content-center',
        'ssg_video_width'             => 800,
    ];

    // News default
    private static $news_options = [
        'ssg_news_lastest'                  => false,
        'ssg_news_featured_select'          => array(),
        'ssg_news_categories'               => 0,
        'ssg_news_categories_link'          => false,
        'ssg_news_show_element'             => array(),
        'ssg_news_total'                    => 6,
        'ssg_news_columns'                  => 3,
        'ssg_news_categories_filter'        => false,
        'ssg_news_industries_filter'        => false,
        'ssg_news_page_navigation'          => 'none',
    ];



    // get value in class bootstrap from value of block property
    /**
     * Using:
     * wep_text_align
     * echo WEP_Option_Model::block_val_to_bs_class('wep_text_align', $wep_text_align);
     */
    static function block_val_to_bs_class($block_prop, $block_value) {

        $result = '';

        // list value and class subfix
        $value_convert = array(
            'left' => 'start',
            'center' => 'center',
            'right' => 'end',
        );

        // list prop name and prefix
        $prefix_value = array(
            'wep_text_align' => 'text',
        );

        // result
        if (isset($value_convert[$block_value]) && ($prefix_value[$block_prop])) {
            $result = array_key_exists($block_prop, $prefix_value) ? sprintf("%s-%s", $prefix_value[$block_prop], $value_convert[$block_value]) : '';
        }

        return $result;
    }

    // get option of core blocks
    /** 
     * Using:
     * $prop = WEP_Option_Model::get_block_values($block);
     * extract($prop);
     **/
    static function get_block_values($block) {
        $result = array();


        $result['wep_id'] = isset($block['anchor']) ? $block['anchor'] : false;
        $result['wep_class'] = isset($block['className']) ? $block['className'] : false;
        $result['wep_block_align'] = isset($block['align']) ? $block['align'] : false;
        $result['wep_vertial_align'] = isset($block['alignContent']) ? $block['alignContent'] : false;
        $result['wep_full_height'] = isset($block['fullHeight']) ? $block['fullHeight'] : false;
        $result['wep_text_align'] = isset($block['alignText']) ? $block['alignText'] : false;
        $result['wep_text_color'] = isset($block['textColor']) ? $block['textColor'] : false;
        $result['wep_background_color'] = isset($block['backgroundColor']) ? $block['backgroundColor'] : false;
        $result['wep_font_size'] = isset($block['fontSize']) ? $block['fontSize'] : false;
        $result['wep_text_color'] = isset($block['textColor']) ? $block['textColor'] : false;
        $result['wep_text_color'] = isset($block['textColor']) ? $block['textColor'] : false;
        $result['wep_text_color'] = isset($block['textColor']) ? $block['textColor'] : false;

        $result_other = [
            'wep_link_color'                => self::get_style_link_color($block),
            'wep_hover_color'               => self::get_style_hover_color($block),
            'wep_style_text_color'          => self::get_block_style($block, 'style', 'text', 'color'),
            'wep_style_background_color'    => self::get_block_style($block, 'style', 'background', 'color'),
            'wep_line_height'       => self::get_line_height($block),
            'wep_min_height'        => self::get_min_height($block),
            'wep_padding_top'       => self::get_padding($block, 'top'),
            'wep_padding_right'     => self::get_padding($block, 'right'),
            'wep_padding_bottom'    => self::get_padding($block, 'bottom'),
            'wep_padding_left'      => self::get_padding($block, 'left'),
            'wep_margin_top'        => self::get_margin($block, 'top'),
            'wep_margin_right'      => self::get_margin($block, 'right'),
            'wep_margin_bottom'     => self::get_margin($block, 'bottom'),
            'wep_margin_left'       => self::get_margin($block, 'left'),
            'wep_space'             => self::get_space($block),
        ];

        $result += $result_other;

        return $result;
    }

    // get padding of core block
    static function get_space($block) {
        $result = false;
        $result = isset($block['style']["spacing"]["blockGap"]) ? $block['style']["spacing"]["blockGap"] : false;

        $spaceValue = explode('|', $result);
        $spaceValue = end($spaceValue);
        $result = $spaceValue;

        return $result;
    }

    // get padding of core block
    static function get_padding($block, $side = 'top') {
        $result = false;
        $result = isset($block['style']["spacing"]["padding"][$side]) ? $block['style']["spacing"]["padding"][$side] : false;

        $paddingValue = explode('|', $result);
        $paddingValue = end($paddingValue);
        $result = $paddingValue;

        return $result;
    }

    // get margin of core block
    static function get_margin($block, $side = 'top') {
        $result = false;
        $result = isset($block['style']["spacing"]["margin"][$side]) ? $block['style']["spacing"]["margin"][$side] : false;

        $marginValue = explode('|', $result);
        $marginValue = end($marginValue);
        $result = $marginValue;

        return $result;
    }

    // get style option of core block
    static function get_block_style($block, $key = 'style', $object = 'text', $key_prop = 'color') {
        $result = false;

        $result = isset($block[$key][$key_prop]) ? $block[$key][$key_prop][$object] : false;

        return $result;
    }

    // get line height
    static function get_line_height($block) {
        $result = false;
        $result = isset($block['style']["typography"]) ? $block['style']["typography"]["lineHeight"] : false;

        return $result;
    }

    // get min height
    static function get_min_height($block) {
        $result = false;
        $result = isset($block['style']["dimensions"]) ? $block['style']["dimensions"]["minHeight"] : false;
        $result = intval($result);

        return $result;
    }

    // get link option of core block
    static function get_style_link_color($block) {
        $result = false;

        $result = isset($block['style']["elements"]) ? $block['style']["elements"]["link"]["color"]["text"] : false;

        if (strpos($result, '#') === false) {
            $colorValue = explode('|', $result);
            $colorValue = end($colorValue);
            $result = $colorValue;
        }

        return $result;
    }

    // get style option of core block
    static function get_style_hover_color($block) {
        $result = false;
        $result = isset($block['style']["elements"]) ? $block['style']["elements"]["link"][":hover"]["color"]["text"] : false;

        if (strpos($result, '#') === false) {
            $colorValue = explode('|', $result);
            $colorValue = end($colorValue);
            $result = $colorValue;
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

    // get news option
    static function get_news_options() {
        return self::$news_options;
    }

    // get content option
    static function get_content_options() {
        return self::$content_options;
    }

    // get icon option
    static function get_icon_options() {
        return self::$icon_options;
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
        $fiels_false_arr = array('ssg_image_list');

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
