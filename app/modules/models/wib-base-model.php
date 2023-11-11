<?php

/**
 * Class Web Interface Block Model Data
 */


class WIB_Base_Model {
    private $att_defaults;
    private $field_defaults;
    private $key_mapping;

    public function __construct($att_defaults = [], $field_defaults = [], $key_mapping = []) {
        $this->att_defaults = $att_defaults;
        $this->field_defaults = $field_defaults;
        $this->key_mapping = $key_mapping;
    }

    /**
     * Nếu $acf_used xác định => sẽ sử dụng tham số ACF      
     * Nếu $acf_used không dùng => sẽ dùng thuộc tính shortcode
     * - Nếu trong $atts đầu vào có acf=true sẽ lại chuyển qua dùng
     * - Nếu không có thì lại dùng shortcode
     * 
     * Ý nghĩa tham số
     * $atts => mảng giá trị thuộc tính shortcode thực tế truyền vào
     * $acf_option => đọc fields trong options
     * $acf_used => đọc fields tại các group thường
     */
    public function get_shortcode_data($atts, $acf_option = false, $acf_used = false) {

        // Mặc định sử dụng ACF theo tham số vào
        $use_acf = $acf_used;

        // Xác định xem có sử dụng ACF hay không 
        if ($atts === '') {
            $use_acf = false;
        } else {
            if (array_key_exists('acf', $atts)) {
                $use_acf = $atts['acf'];
            }
        }

        // THUỘC TÍNH TỪ ACF MẶC ĐỊNH
        // Xử lý thuộc tính truyền vào shortcode và áp dụng giá trị mặc định từ $att_defaults hoặc $field_defaults tùy thuộc vào sử dụng ACF
        $defaults = $use_acf ? $this->field_defaults : $this->att_defaults;

        // THUỘC TÍNH TỪ SHORTCODE
        $atts = shortcode_atts($defaults, $atts);

        if ($use_acf) {

            // Sử dụng ACF để lấy giá trị
            $acf_values = WEP_Option_Model::get_field_values($this->field_defaults, $acf_option);

            // Sao chép giá trị từ $field_defaults vào $att_defaults dựa trên key_mapping
            foreach ($this->key_mapping as $att_key => $field_key) {
                if (isset($acf_values[$field_key])) {
                    $atts[$att_key] = $acf_values[$field_key];
                }
            }
        }

        return $atts;
    }
}
