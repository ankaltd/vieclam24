<?php

/** 
 * Class Shortcode Model
 */

class WEP_Shortcode_Model {

    private $shortcode_welcome = 'Welcome WEP Shortcode';

    // Các phương thức để tương tác với dữ liệu
    public function __construct() {
        return true;
    }

    /** 
     * Get list shortcode with Shortcode Name: name-shortcode
     * return array('file-name' => 'shortcode-name',...)
     * Note: file-name is without extension .php
     */
    static public function get_list_shortcode() {

        $shortcode_data = array(); // Mảng để lưu tên file và giá trị shortcode

        // subfolder for group shortcodes
        $shortcodes_group = array(
            '/shortcodes/components',
            '/shortcodes/elements',
            '/shortcodes/footer',
            '/shortcodes/header',
            '/shortcodes/panels',
            '/shortcodes/popups',
            '/shortcodes/sections',
            '/shortcodes/widgets',
            '/shortcodes',
        );

        foreach ($shortcodes_group as $dir) {

            // Đường dẫn tới thư mục chứa các file .php
            $shortcodes_dir = THEME_DIR . $dir;            

            // Kiểm tra nếu thư mục tồn tại
            if (is_dir($shortcodes_dir)) {
                // Lấy danh sách tất cả các file .php trong thư mục
                $files = glob($shortcodes_dir . '/*.php');

                // Lặp qua từng file
                foreach ($files as $file) {
                    // Đọc nội dung của file
                    $file_content = file_get_contents($file);

                    // Sử dụng biểu thức chính quy để tìm comment với tên Shortcode
                    if (preg_match('/Shortcode Name:(.*)/i', $file_content, $matches)) {
                        // Lấy tên file (loại bỏ đường dẫn và phần mở rộng)
                        $file_name = basename($file, '.php');

                        // Lưu tên file và giá trị shortcode vào mảng
                        $shortcode_name = trim($matches[1]);
                        $shortcode_data[$shortcode_name] = $shortcodes_dir . '/'. $file_name;
                    }
                }
            }
        }
        

        // Hiển thị kết quả
        return $shortcode_data;
    }

    // Get data
    public function get_data() {
        return $this->shortcode_welcome;
    }

    // Get attrs shortcodes from array with default value
    static function get_atts_values($atts) {
        $result = array();

        foreach ($atts as $param => $default) {

            // check get global options of invidual page options
            $value = $atts[$param];

            if (is_null($value) || !in_array($param, $atts) || (in_array($param, $atts) && $value === false)) {
                $result[$param] = $default;
            } else {
                $result[$param] = $value;
            }
        }

        return $result;
    }
}
