<?php

/* Class Web Interface Block Viewer */
class WIB_Base_View {

    private $template_file;

    public function __construct($shorcode = '') {
        $this->set_template_name($shorcode);
    }

    public function set_template_name($shorcode) {
        $shortcode_template_file = str_replace('_', '-', $shorcode) . '-tpl.php';
        $this->template_file = THEME_WIB_TEMPLATE . '/' . $shortcode_template_file;
    }    
    
    public function output_content($data) {

        // Include nội dung từ tệp template
        ob_start();
        if (file_exists($this->template_file)) {
            include($this->template_file);
        }
        $template_content = ob_get_clean();

        return $template_content;
    }

    // Render to Template
    public function render($data) {

        // Kiểm tra xem có ID hình ảnh hay không
        if ($data['id']) {
            return $this->output_content($data);
        } else {
            $output = 'No logo image found'; // Thông báo nếu không có ID hình ảnh
        }

        return $output;
    }
}
