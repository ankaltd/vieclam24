<?php

/* Class Web Interface Block Viewer */
class WIB_Logo_View extends WIB_Base_View {

    public function __construct($shorcode = '') {
        parent::__construct($shorcode);
    }

    public function render($data) {
        // CUSTOM HERE FOR RENDER

        echo 'Here';

        // Kiểm tra xem có ID hình ảnh hay không
        if ($data['id']) {
            return $this->output_content($data);
        } else {
            $data['url'] = THEME_URL . '/app/assets/images/default.jpg';
            return $this->output_content($data);
            //$output = 'No data found'; // Thông báo nếu không có ID hình ảnh
        }        

        // call parent
        // $output = parent::render($data);

        return $output;
    }
}
