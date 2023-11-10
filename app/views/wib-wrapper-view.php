<?php

/* Class Web Interface Block Viewer */
class WIB_Wrapper_View extends WIB_Base_View {

    public function __construct($shorcode = '') {
        parent::__construct($shorcode);
    }

    public function render($data) {
        // CUSTOM HERE FOR RENDER

        // Kiểm tra xem có ID hình ảnh hay không
        if ($data['id']) {
            return $this->output_content($data);
        } else {
            $output = 'No data found'; // Thông báo nếu không có ID hình ảnh
        }        

        // call parent
        $output = parent::render($data);

        return $output;
    }
}
