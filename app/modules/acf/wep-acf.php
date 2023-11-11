<?php

/** 
 * Class integration ACF into System for Metabox Page Options, Custom Post Types, Custom Taxonomies
 */
class WEP_ACF {
    private $home_page_id = 223;
    private $home_page_json = 'home.json';
    private $general_option_json = 'general.json';


    public function __construct() {
        add_filter('acf/settings/save_json', [$this, 'wep_acf_json_save_point']);
        add_filter('acf/settings/load_json', [$this, 'wep_acf_json_load_point']);
        add_action('init', [$this, 'load_blocks'], 5);
        add_filter('acf/settings/load_json', [$this, 'load_acf_field_group']);
        add_filter('block_categories_all', [$this, 'block_categories']);

        // Field Menu for ACF        
        add_action('acf/include_field_types', array($this, 'acnmf_register_field_for_nav_menu'));

        // Field Pages for ACF        
        add_action('acf/include_field_types', array($this, 'acnmf_register_field_for_page_list'));

        // Field Attributes for ACF        
        add_action('acf/include_field_types', array($this, 'acnmf_register_field_for_atts_list'));

        // Thêm hành động lưu post vào ACF để export JSON data
        add_action('acf/save_post', array($this, 'general_acf_save_post'), 20);

        // Thêm hành động lưu post trang chủ Home Page theo ID 
        add_action('save_post', array($this, 'home_acf_save_post'), 20, 1);
    }

    // Register New ACF Fields Menu Nav
    public function acnmf_register_field_for_nav_menu() {
        new WEP_ACF_Field_Menu();
    }

    // Register New ACF Fields Page List
    public function acnmf_register_field_for_page_list() {
        new WEP_ACF_Field_Page();
    }

    // Register New ACF Fields Attribute List
    public function acnmf_register_field_for_atts_list() {
        new WEP_ACF_Field_Attributes();
    }

    // Save content option ACF general to JSON
    public function general_acf_save_post($post_id) {

        // Lấy options
        $wep_general = WEP_Option_Model::get_general_options();
        $field_values = WEP_Option_Model::get_acf_field_values($wep_general, true);

        // Lưu giá trị của các option vào file json
        $this->save_json($field_values, $this->general_option_json);
    }

    // Save content option ACF in Home page to JSON
    public function home_acf_save_post($post_id) {

        if ($post_id == $this->home_page_id) :

            // Lấy options
            $wep_home = WEP_Option_Model::get_home_options();
            $field_values = WEP_Option_Model::get_acf_field_values($wep_home, false, $post_id);

            /* 3 - Select Device - Stored on General Options */

            /* 4 - Prequery data services by devices sections */
            $total_sections = 3;
            $sub_cat_list = array();
            $keyword_list = array();
            $product_slider = array();
            for ($sec_index = 0; $sec_index < $total_sections; $sec_index++) :
                $service_device_data = $field_values['wep_section_service_by_device__wep_section_service_device_list'][$sec_index];

                extract($service_device_data); // important

                // Get Data from $service_device_data each section
                $product_category_object = get_term($wep_section_service_device_slider_category);
                $section_heading = $wep_section_service_device ? $wep_section_service_device : $product_category_object->name;
                $show_all_link = get_term_link($product_category_object);
                $product_slider_type = $wep_section_service_device_slider_type;
                $product_slider_ids = $wep_section_service_device_slider;
                $product_slider_number = $wep_section_service_device_slider_number;
                $product_keyword_input = $wep_section_service_device_highlight_custom_input;
                $product_keyword_input_list = $wep_section_service_device_highlight_custom;

                // 4-1. subcat
                $sub_cat_list[$sec_index] = array();
                if ($wep_section_service_device_subcat) :
                    $sub_cat_list[$sec_index] = WEP_Option_Model::get_child_terms_info($wep_section_service_device_slider_category, 'product_cat');
                endif;

                // 4-2. keywords
                if ($product_keyword_input) {
                    $stt = 0;
                    $result = array();
                    foreach ($product_keyword_input_list as $item) {
                        $stt++;
                        $temp = array();
                        $temp['id'] = $stt;
                        $temp['url'] = $item['wep_section_service_device_highlight_item_link'];
                        $temp['short'] = $item['wep_section_service_device_highlight_item_text'];
                        $temp['text'] = $item['wep_section_service_device_highlight_item_text'];
                        $result[$stt] = $temp;
                    }

                    $keyword_list[$sec_index] = $result;
                } else {
                    $keyword_list[$sec_index] = WEP_Option_Model::get_keyword_list($wep_section_service_device_highlight);
                }

                // 4-3. product list for slider
                $product_ids['category'] = $wep_section_service_device_slider_category;
                $product_ids['selection'] = $product_slider_ids;

                $product_slider[$sec_index] = WEP_Woocommerce_Model::get_wep_service_device_slider_products($product_slider_type, $product_slider_number, $product_ids);

                // All data of section
                $section_data = array();
                $section_data['subcat'] = $sub_cat_list[$sec_index];
                $section_data['keywords'] = $keyword_list[$sec_index];
                $section_data['products'] = $product_slider[$sec_index];

                // => Add to end array
                $field_values['wep_section_service_by_device_data_' . $sec_index] = $section_data;

            endfor;

            /* 5 - Prequery data accessories sections */
            $number_product = $field_values['wep_section_accessories__wep_home_accessories_number'];
            $accessories_ids = $field_values['wep_section_accessories__wep_home_accessories_selection'];
            $list_type = $field_values['wep_section_accessories__wep_home_accessories_list_type'];

            $wep_section_accessories_slider_data = WEP_Woocommerce_Model::get_wep_service_device_slider_products($accessories_ids, $number_product, $accessories_ids);

            // => Add to end array
            $field_values['wep_section_accessories_slider_data'] = $wep_section_accessories_slider_data;

            /* 6 - Prequery data for sections news featured */
            $news_featured_type = $field_values['wep_section_featured_news']['wep_home_featured_news_type'];
            $news_featured_ids = $field_values['wep_section_featured_news']['wep_home_featured_news_selection'];
            $news_featured_cat_id = $field_values['wep_section_featured_news']['wep_home_featured_news_category'];
            $news_featured_number = $field_values['wep_section_featured_news']['wep_home_featured_news_number'];
            $wep_section_featured_news_data = WEP_News_Model::get_featured_news($news_featured_type, $news_featured_ids, $news_featured_cat_id, $news_featured_number);

            // => Add to end array
            $field_values['wep_section_featured_news_data'] = $wep_section_featured_news_data;

            /* 7 - Prequery data news guide */

            $number_news = 3;
            $guide_cat_id = $field_values['wep_section_featured_news']['wep_home_other_news_left_category'];
            $guide_cat_by_cat = $field_values['wep_section_featured_news']['wep_home_other_news_left_from_cat'];
            $guide_cat_ids = $field_values['wep_section_featured_news']['wep_home_featured_news_left_selection'];
            if ($guide_cat_by_cat) {
                $get_news_type = 'category';
                $wep_home_other_news_guide_data = WEP_News_Model::get_featured_news($get_news_type, array(), $guide_cat_id, $number_news);
            } else {
                $get_news_type = 'selection';
                $wep_home_other_news_guide_data = WEP_News_Model::get_featured_news($get_news_type, $guide_cat_ids, $guide_cat_id, $number_news);
            }

            $service_cat_id = $field_values['wep_section_featured_news']['wep_home_other_news_right_category'];
            $service_cat_by_cat = $field_values['wep_section_featured_news']['wep_home_other_news_right_from_cat'];
            $service_cat_ids = $field_values['wep_section_featured_news']['wep_home_featured_news_right_selection'];

            if ($service_cat_by_cat) {
                $get_news_type = 'category';
                $wep_home_other_news_service_data = WEP_News_Model::get_featured_news($get_news_type, array(), $service_cat_id, $number_news);
            } else {
                $get_news_type = 'selection';
                $wep_home_other_news_service_data = WEP_News_Model::get_featured_news($get_news_type, $service_cat_ids, $service_cat_id, $number_news);
            }

            // => Add to end array 
            $field_values['wep_home_other_news_guide_data'] = $wep_home_other_news_guide_data;
            $field_values['wep_home_other_news_service_data'] = $wep_home_other_news_service_data;

            // Lưu giá trị của các option vào file json
            $this->save_json($field_values, $this->home_page_json);
        endif;
    }

    // Phương thức lưu giá trị của các option vào file json
    public function save_json($options, $file_name) {

        // Chuyển mảng thành chuỗi JSON
        $json = json_encode($options);

        // Lưu chuỗi JSON vào file
        file_put_contents(THEME_CONFIG . '/option-json/' . $file_name, $json);
    }

    /**
     * Block categories
     * 
     * @since 1.0.0
     */
    public function block_categories($categories) {
        // Check to see if we already have a CultivateWP category
        $include = true;
        foreach ($categories as $category) {
            if ('wep' === $category['slug']) {
                $include = false;
            }
        }
        if ($include) {
            $categories = array_merge(
                $categories,
                [
                    [
                        'slug'  => 'wep',
                        'title' => __('Blocks WEP ', 'wep'),
                    ],
                    [
                        'slug'  => 'wep-home',
                        'title' => __('Trang chủ', 'wep'),
                    ],
                    [
                        'slug'  => 'wep-about',
                        'title' => __('Giới thiệu', 'wep'),
                    ],
                    [
                        'slug'  => 'wep-hiring',
                        'title' => __('Tuyển dụng', 'wep'),
                    ],
                    [
                        'slug'  => 'wep-contact',
                        'title' => __('Liên hệ', 'wep'),
                    ],
                    [
                        'slug'  => 'wep-dich-vu',
                        'title' => __('Dịch vụ', 'wep'),
                    ],
                    [
                        'slug'  => 'wep-tin-tuc',
                        'title' => __('Tin tức', 'wep'),
                    ],
                ]
            );
        }
        return $categories;
    }
    /**
     * Get Blocks
     */
    public function get_blocks() {
        $theme   = wp_get_theme();
        $blocks  = get_option('wep_blocks');
        $version = get_option('wep_blocks_version');
        if (empty($blocks) || version_compare($theme->get('Version'), $version) || (function_exists('wp_get_environment_type') && 'production' !== wp_get_environment_type())) {
            $blocks = scandir(get_template_directory() . '/blocks/');
            $blocks = array_values(array_diff($blocks, array('..', '.', '.DS_Store', '_base-block')));
            update_option('wep_blocks', $blocks);
            update_option('wep_blocks_version', $theme->get('Version'));
        }
        return $blocks;
    }
    /**
     * Load ACF field groups for blocks
     */
    public function load_acf_field_group($paths) {
        $blocks = $this->get_blocks();
        foreach ($blocks as $block) {
            $paths[] = get_template_directory() . '/blocks/' . $block;
        }
        return $paths;
    }
    // check file
    function check_file_exists($filename) {
        $theme_path = get_template_directory() . '/' . $filename;
        return file_exists($theme_path);
    }
    /**
     * Load Blocks
     */
    public function load_blocks() {
        $theme  = wp_get_theme();
        $blocks = $this->get_blocks();
        $blocks_dir = [];
        foreach ($blocks as $dirname) {
            if (substr($dirname, -4) != '.php') {
                $blocks_dir[] = $dirname;
            }
        }
        $blocks = $blocks_dir;
        foreach ($blocks as $block) {
            if (file_exists(get_template_directory() . '/blocks/' . $block . '/block.json')) {
                register_block_type(get_template_directory() . '/blocks/' . $block . '/block.json');
                // load style.css
                if (file_exists(get_template_directory() . '/blocks/' . $block . '/style.css')) {
                    wp_register_style('block-' . $block, get_template_directory_uri() . '/blocks/' . $block . '/style.css', null, $theme->get('Version'));
                }
                // load script.js
                if (file_exists(get_template_directory() . '/blocks/' . $block . '/script.js')) {
                    wp_register_script('block-' . $block, get_template_directory_uri() . '/blocks/' . $block . '/script.js', null, $theme->get('Version'));
                }
                // init.php
                if (file_exists(get_template_directory() . '/blocks/' . $block . '/init.php')) {
                    include_once get_template_directory() . '/blocks/' . $block . '/init.php';
                }
            }
        }
    }
    // save local json
    public function wep_acf_json_save_point($path) {
        // update path
        $path = get_stylesheet_directory() . '/app/acf-json';
        // return
        return $path;
    }
    // load local json
    public function wep_acf_json_load_point($paths) {
        // remove original path (optional)
        unset($paths[0]);
        // append path
        $paths[] = get_stylesheet_directory() . '/app/acf-json';
        // return
        return $paths;
    }
}
