<?php

/**
 * WEP Helper Class for call direct static function
 * Include methods return values
 */
class WEP_Helper {

    public function __construct() {
    }

    static function init() {
        // Gọi hàm để lưu dữ liệu JSON khi sản phẩm được cập nhật
        // add_action('save_post_product', [__CLASS__, 'save_product_data_as_json']);
    }

    // Save vào Cookie
    public static function save_to_cookie($cookie_name, $cookie_data) {
        ob_start(); // Bắt đầu bộ đệm đầu ra

        // Ghi dữ liệu vào bộ đệm
        setcookie($cookie_name, json_encode($cookie_data), time() + (86400 * 30), '/');

        ob_end_flush(); // Gửi tất cả dữ liệu từ bộ đệm đến trình duyệt
    }

    // Get từ Cookie
    public static function get_from_cookie($cookie_name) {
        if (isset($_COOKIE[$cookie_name])) {
            return json_decode($_COOKIE[$cookie_name], true);
        } else {
            return null;
        }
    }

    // Hàm truy vấn dữ liệu và lưu JSON vào trường meta
    function save_product_data_as_json($product_id, $meta_name = 'wep_product_data') {

        // Thực hiện truy vấn dữ liệu quan trọng từ sản phẩm Woocommerce
        $product_data = array(
            'name' => get_the_title($product_id),
            'price' => get_post_meta($product_id, '_price', true),
            'sold' => WEP_Product_Model::shop_product_sold_count()

            // Thêm các trường dữ liệu khác mà bạn muốn lưu vào JSON
        );

        // Chuyển dữ liệu thành chuỗi JSON
        $product_data_json = json_encode($product_data);

        // Lưu chuỗi JSON vào trường meta tương ứng với sản phẩm
        update_post_meta($product_id, $meta_name, $product_data_json);
    }

    // Hàm lấy dữ liệu JSON từ trường meta
    static function get_product_data_json($product_id, $meta_name = 'wep_product_data') {
        $product_data_json = get_post_meta($product_id, $meta_name, true);
        return $product_data_json;
    }

    /* Calculator Discount */
    static function calculateDiscount($sale_price, $origin_price, $percent = true) {
        $sale_price = str_replace(['.', ','], '', $sale_price);
        $origin_price = str_replace(['.', ','], '', $origin_price);
        $sale_price = preg_replace('/[^0-9.]/', '', $sale_price);
        $origin_price = preg_replace('/[^0-9.]/', '', $origin_price);

        if (!is_numeric($sale_price)) {
            $sale_price = floatval($sale_price);
        }
        if (!is_numeric($origin_price)) {
            $origin_price = floatval($origin_price);
        }

        if ($origin_price == 0) {
            // Xử lý trường hợp giá gốc bằng 0
            return $percent ? "0%" : 0;
        }

        // Tính phần trăm giảm giá
        $discount_value = $origin_price - $sale_price;

        if ($percent) {
            // Trả về theo phần trăm
            $discount_percent = round(($discount_value / $origin_price) * 100, 1); // Làm tròn số với một chữ số thập phân
            return $discount_percent . "%";
        } else {
            // Trả về giá trị số
            return round($discount_value, 1); // Làm tròn số với một chữ số thập phân
        }
    }


    /* Làm tròn số */
    static function format_decimal($number) {
        return number_format((float)$number, 1, '.', '');
    }

    /* Get last text */
    static function get_lastest_text($input_string, $dash_character) {
        $parts = explode($dash_character, $input_string);

        if (count($parts) > 1) {
            return $parts[1];
        } else {
            return "Không tìm thấy $dash_character trong chuỗi.";
        }
    }

    // Check exist value on param url
    static function has_query_parameter($parameter_name, $expected_values) {
        if (isset($_GET[$parameter_name])) {
            $parameter_values = explode(',', $_GET[$parameter_name]);
            $expected_values = explode(',', $expected_values);

            // Kiểm tra xem có bất kỳ giá trị nào của tham số nằm trong danh sách giá trị mong đợi
            foreach ($parameter_values as $value) {
                if (in_array($value, $expected_values)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Convert query params to array
    public static function params_to_array($url_params = '') {

        // Chuyển sang array
        parse_str($url_params, $query_arr);

        return $query_arr;
    }

    // Convert array to url query params
    public static function array_to_params($args = array()) {
        return http_build_query($args);
    }

    // Format Number Currency
    public static function format_currency_with_unit($amount, $currency_unit = '₫') {
        // Ép kiểu biến $amount thành số thực (float) nếu nó là chuỗi.
        $amount = floatval($amount);

        $formatted_amount = number_format($amount, 0, '.', '.');
        return $formatted_amount . '' . $currency_unit;
    }

    // Format Number Phone
    public static function formatPhoneNumber($phoneNumber) {
        // Định dạng lại chuỗi số
        $formattedPhoneNumber = preg_replace('/(\d{4})(\d{3})(\d{3,4})$/', '$1.$2.$3', $phoneNumber);

        return $formattedPhoneNumber;
    }


    /* Get page template by id */
    public static function get_template_file_by_page_id($page_id) {
        // Lấy thông tin trang dựa vào ID

        $page = get_post($page_id);

        if ($page) {
            // Lấy tên tệp template của trang
            $template = get_post_meta($page->ID, '_wp_page_template', true);

            // Kiểm tra xem tệp template có tồn tại không
            if (!empty($template)) {
                return $template;
            }
        } else {
            if ($page_id == 0) {
                $template = 'default.php';
            }
        }

        // default page template
        $default_page = 'page.php';

        if (!file_exists(THEME_DIR . '/' . $default_page)) {
            // Tệp page.php tồn tại trong theme hiện tại
            $default_page = 'index.php';
        }

        // Trả về một giá trị mặc định nếu không tìm thấy template
        return $default_page; // Thay 'default-template.php' bằng tên template mặc định của bạn.
    }


    /**
     * Đọc nội dung từ tệp JSON và trả về dưới dạng mảng.
     *
     * @param string $json_file_path Đường dẫn đến tệp JSON.
     * @return array|null Mảng chứa nội dung JSON hoặc null nếu có lỗi.
     */
    public static function getJsonAsArray($json_file_path) {
        // Kiểm tra xem tệp JSON tồn tại
        if (file_exists($json_file_path)) {
            // Đọc nội dung từ tệp JSON
            $json_data = file_get_contents($json_file_path);

            // Chuyển đổi nội dung JSON thành mảng
            $array_data = json_decode($json_data, true);

            // Kiểm tra xem chuyển đổi thành công
            if ($array_data !== null) {
                return $array_data;
            } else {
                // Chuyển đổi thất bại, trả về null
                return null;
            }
        } else {
            // Tệp JSON không tồn tại, trả về null
            return null;
        }
    }

    // Print nested array or object
    static function print_struct($array) {
        echo '<pre>' . print_r($array, true) . '</pre>';
    }

    /* Random String */
    static function genRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /** Get date with format vietnam */
    static function format_date($date) {
        // Chuyển đổi định dạng ngày tháng
        $formatted_date = date_i18n('j \T\há\n\g n, Y', strtotime($date));
        return $formatted_date; // Kết quả: 13 Tháng 3, 2023
    }
    /**
     * Returns the size for avatars used in the theme.
     *
     * @since WEP 1.0
     *
     * @return int
     */
    static function wep_get_avatar_size() {
        return 60;
    }
    /* Convert Typography array to string css*/
    static function wep_get_typography_css($array) {
        $css_properties = array();
        foreach ($array as $key => $value) {
            if (!empty($value)) {
                $css_properties[] = sprintf('%s:%s', str_replace('_', '-', $key), $value);
            }
        }
        $css_string = implode(';', $css_properties);
        return $css_string;
    }
    /** 
     * Convert to Slug
     */
    static function wep_get_slug_string($normal_str = '') {
        /**
         * Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
         * @access    public
         * @param string
         * @return    string
         */
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $normal_str);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    /**
     * Creates continue reading text.
     *
     * @since WEP 1.0
     */
    static function wep_continue_reading_text() {
        $continue_reading = sprintf(
            /* translators: %s: Post title. Only visible to screen readers. */
            esc_html__('Continue reading %s', LANG_DOMAIN),
            the_title('<span class="screen-reader-text">', '</span>', false)
        );
        return $continue_reading;
    }

    /* Get attachment url image by id */
    static function wep_get_thumbnail_url_by_attachment_id($attachment_id) {
        $thumbnail_url = wp_get_attachment_url($attachment_id);

        if ($thumbnail_url) {
            return esc_url($thumbnail_url);
        } else {
            return false;
        }
    }


    /**
     * Gets the SVG code for a given icon.
     *
     * @since WEP 1.0
     *
     * @param string $group The icon group.
     * @param string $icon  The icon.
     * @param int    $size  The icon size in pixels.
     * @return string
     */
    static function wep_get_icon_svg($group, $icon, $size = 24) {
        return WEP_One_SVG_Icons::get_svg($group, $icon, $size);
    }
    /**
     * Get custom CSS.
     *
     * Return CSS for non-latin language, if available, or null
     *
     * @since WEP 1.0
     *
     * @param string $type Whether to return CSS for the "front-end", "block-editor", or "classic-editor".
     * @return string
     */
    static function wep_get_non_latin_css($type = 'front-end') {
        // Fetch site locale.
        $locale = get_bloginfo('language');
        /**
         * Filters the fallback fonts for non-latin languages.
         *
         * @since WEP 1.0
         *
         * @param array $font_family An array of locales and font families.
         */
        $font_family = apply_filters(
            'wep_get_localized_font_family_types',
            array(
                // Arabic.
                'ar'    => array('Tahoma', 'Arial', 'sans-serif'),
                'ary'   => array('Tahoma', 'Arial', 'sans-serif'),
                'azb'   => array('Tahoma', 'Arial', 'sans-serif'),
                'ckb'   => array('Tahoma', 'Arial', 'sans-serif'),
                'fa-IR' => array('Tahoma', 'Arial', 'sans-serif'),
                'haz'   => array('Tahoma', 'Arial', 'sans-serif'),
                'ps'    => array('Tahoma', 'Arial', 'sans-serif'),
                // Chinese Simplified (China) - Noto Sans SC.
                'zh-CN' => array('\'PingFang SC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif'),
                // Chinese Traditional (Taiwan) - Noto Sans TC.
                'zh-TW' => array('\'PingFang TC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif'),
                // Chinese (Hong Kong) - Noto Sans HK.
                'zh-HK' => array('\'PingFang HK\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif'),
                // Cyrillic.
                'bel'   => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'bg-BG' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'kk'    => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'mk-MK' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'mn'    => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'ru-RU' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'sah'   => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'sr-RS' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'tt-RU' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'uk'    => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                // Devanagari.
                'bn-BD' => array('Arial', 'sans-serif'),
                'hi-IN' => array('Arial', 'sans-serif'),
                'mr'    => array('Arial', 'sans-serif'),
                'ne-NP' => array('Arial', 'sans-serif'),
                // Greek.
                'el'    => array('\'Helvetica Neue\', Helvetica, Arial, sans-serif'),
                // Gujarati.
                'gu'    => array('Arial', 'sans-serif'),
                // Hebrew.
                'he-IL' => array('\'Arial Hebrew\'', 'Arial', 'sans-serif'),
                // Japanese.
                'ja'    => array('sans-serif'),
                // Korean.
                'ko-KR' => array('\'Apple SD Gothic Neo\'', '\'Malgun Gothic\'', '\'Nanum Gothic\'', 'Dotum', 'sans-serif'),
                // Thai.
                'th'    => array('\'Sukhumvit Set\'', '\'Helvetica Neue\'', 'Helvetica', 'Arial', 'sans-serif'),
                // Vietnamese.
                'vi'    => array('\'Libre Franklin\'', 'sans-serif'),
            )
        );
        // Return if the selected language has no fallback fonts.
        if (empty($font_family[$locale])) {
            return '';
        }
        /**
         * Filters the elements to apply fallback fonts to.
         *
         * @since WEP 1.0
         *
         * @param array $elements An array of elements for "front-end", "block-editor", or "classic-editor".
         */
        $elements = apply_filters(
            'wep_get_localized_font_family_elements',
            array(
                'front-end'      => array('body', 'input', 'textarea', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', '.has-drop-cap:not(:focus)::first-letter', '.entry-content .wp-block-archives', '.entry-content .wp-block-categories', '.entry-content .wp-block-cover-image', '.entry-content .wp-block-latest-comments', '.entry-content .wp-block-latest-posts', '.entry-content .wp-block-pullquote', '.entry-content .wp-block-quote.is-large', '.entry-content .wp-block-quote.is-style-large', '.entry-content .wp-block-archives *', '.entry-content .wp-block-categories *', '.entry-content .wp-block-latest-posts *', '.entry-content .wp-block-latest-comments *', '.entry-content p', '.entry-content ol', '.entry-content ul', '.entry-content dl', '.entry-content dt', '.entry-content cite', '.entry-content figcaption', '.entry-content .wp-caption-text', '.comment-content p', '.comment-content ol', '.comment-content ul', '.comment-content dl', '.comment-content dt', '.comment-content cite', '.comment-content figcaption', '.comment-content .wp-caption-text', '.widget_text p', '.widget_text ol', '.widget_text ul', '.widget_text dl', '.widget_text dt', '.widget-content .rssSummary', '.widget-content cite', '.widget-content figcaption', '.widget-content .wp-caption-text'),
                'block-editor'   => array('.editor-styles-wrapper > *', '.editor-styles-wrapper p', '.editor-styles-wrapper ol', '.editor-styles-wrapper ul', '.editor-styles-wrapper dl', '.editor-styles-wrapper dt', '.editor-post-title__block .editor-post-title__input', '.editor-styles-wrapper .wp-block h1', '.editor-styles-wrapper .wp-block h2', '.editor-styles-wrapper .wp-block h3', '.editor-styles-wrapper .wp-block h4', '.editor-styles-wrapper .wp-block h5', '.editor-styles-wrapper .wp-block h6', '.editor-styles-wrapper .has-drop-cap:not(:focus)::first-letter', '.editor-styles-wrapper cite', '.editor-styles-wrapper figcaption', '.editor-styles-wrapper .wp-caption-text'),
                'classic-editor' => array('body#tinymce.wp-editor', 'body#tinymce.wp-editor p', 'body#tinymce.wp-editor ol', 'body#tinymce.wp-editor ul', 'body#tinymce.wp-editor dl', 'body#tinymce.wp-editor dt', 'body#tinymce.wp-editor figcaption', 'body#tinymce.wp-editor .wp-caption-text', 'body#tinymce.wp-editor .wp-caption-dd', 'body#tinymce.wp-editor cite', 'body#tinymce.wp-editor table'),
            )
        );
        // Return if the specified type doesn't exist.
        if (empty($elements[$type])) {
            return '';
        }
        // Include file if function doesn't exist.
        if (!function_exists('wep_generate_css')) {
            require_once get_theme_file_path('inc/custom-css.php'); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
        }
        // Return the specified styles.
        return wep_generate_css( // @phpstan-ignore-line.
            implode(',', $elements[$type]),
            'font-family',
            implode(',', $font_family[$locale]),
            null,
            null,
            false
        );
    }
    /**
     * Print the first instance of a block in the content, and then break away.
     *
     * @since WEP 1.0
     *
     * @param string      $block_name The full block type name, or a partial match.
     *                                Example: `core/image`, `core-embed/*`.
     * @param string|null $content    The content to search in. Use null for get_the_content().
     * @param int         $instances  How many instances of the block will be printed (max). Default  1.
     * @return bool Returns true if a block was located & printed, otherwise false.
     */
    static function wep_print_first_instance_of_block($block_name, $content = null, $instances = 1) {
        $instances_count = 0;
        $blocks_content  = '';
        if (!$content) {
            $content = get_the_content();
        }
        // Parse blocks in the content.
        $blocks = parse_blocks($content);
        // Loop blocks.
        foreach ($blocks as $block) {
            // Sanity check.
            if (!isset($block['blockName'])) {
                continue;
            }
            // Check if this the block matches the $block_name.
            $is_matching_block = false;
            // If the block ends with *, try to match the first portion.
            if ('*' === $block_name[-1]) {
                $is_matching_block = 0 === strpos($block['blockName'], rtrim($block_name, '*'));
            } else {
                $is_matching_block = $block_name === $block['blockName'];
            }
            if ($is_matching_block) {
                // Increment count.
                $instances_count++;
                // Add the block HTML.
                $blocks_content .= render_block($block);
                // Break the loop if the $instances count was reached.
                if ($instances_count >= $instances) {
                    break;
                }
            }
        }
        if ($blocks_content) {
            /** This filter is documented in wp-includes/post-template.php */
            echo apply_filters('the_content', $blocks_content); // phpcs:ignore WordPress.Security.EscapeOutput
            return true;
        }
        return false;
    }
    /**
     * Custom CSS
     *
     * @package WordPress
     * @subpackage Twenty_Twenty_One
     * @since WEP 1.0
     */
    /**
     * Generate CSS.
     *
     * @since WEP 1.0
     *
     * @param string $selector The CSS selector.
     * @param string $style    The CSS style.
     * @param string $value    The CSS value.
     * @param string $prefix   The CSS prefix.
     * @param string $suffix   The CSS suffix.
     * @param bool   $display  Print the styles.
     * @return string
     */
    static function wep_generate_css($selector, $style, $value, $prefix = '', $suffix = '', $display = true) {
        // Bail early if there is no $selector elements or properties and $value.
        if (!$value || !$selector) {
            return '';
        }
        $css = sprintf('%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix);
        if ($display) {
            /*
		 * Note to reviewers: $css contains auto-generated CSS.
		 * It is included inside <style> tags and can only be interpreted as CSS on the browser.
		 * Using wp_strip_all_tags() here is sufficient escaping to avoid
		 * malicious attempts to close </style> and open a <script>.
		 */
            echo wp_strip_all_tags($css); // phpcs:ignore WordPress.Security.EscapeOutput
        }
        return $css;
    }

    // Tạo cookie và lưu dữ liệu vào transient
    public static function create_transient($transient_name, $value, $expiration = 12) {
        $cookie_value = 'user_' . time();
        setcookie('user_key', $cookie_value, time() + (86400 * 30), "/");
        $transient_key = self::generate_transient_key($cookie_value, $transient_name);
        set_transient($transient_key, $value, $expiration * HOUR_IN_SECONDS);
    }

    // Cập nhật dữ liệu trong transient
    public static function update_transient($transient_name, $new_value, $expiration = 12) {
        if (isset($_COOKIE['user_key'])) {
            $transient_key = self::generate_transient_key($_COOKIE['user_key'], $transient_name);
            set_transient($transient_key, $new_value, $expiration * HOUR_IN_SECONDS);
        }
    }

    // Đọc dữ liệu từ transient
    public static function read_transient($transient_name) {
        if (isset($_COOKIE['user_key'])) {
            $transient_key = self::generate_transient_key($_COOKIE['user_key'], $transient_name);
            return get_transient($transient_key);
        }
        return null;
    }

    // Xóa dữ liệu từ transient
    public static function delete_transient($transient_name) {
        if (isset($_COOKIE['user_key'])) {
            $transient_key = self::generate_transient_key($_COOKIE['user_key'], $transient_name);
            delete_transient($transient_key);
        }
    }

    // Hàm hỗ trợ tạo key transient
    private static function generate_transient_key($cookie_value, $transient_name) {
        return 'transient_' . $cookie_value . '_' . $transient_name;
    }
}
