<?php

/**
 * Class of Web Interface Block => Wrapper
 * 1 - Create an class WIB_Name in dir app/controllers/wib-name.php
 * 2 - Change name of shortcode for WIB_Name at $shortcode = 'wib_wrapper'
 * 3 - Create an class WIB_Model in dir app/models/wib-name-model.php
 * 4 - Create an class WIB_View in dir app/views/wib-name-view.php
 * 5 - Create an template in dir app/wib-templates/wib-name-tpl.php
 */
class WIB_Wrapper extends WIB_Base {
    private $model;
    private $view;
    private $shortcode = 'wib_wrapper'; /* <= name shorcode here */

    public function __construct($args = []) {
        $this->model = new WIB_Wrapper_Model();
        $this->view = new WIB_Wrapper_View($this->shortcode);

        // call parent wib
        parent::__construct($this->shortcode, $this->model, $this->view, $args);
    }

    public function render_shortcode($atts) {
        // Xử lý thuộc tính truyền vào shortcode và lấy dữ liệu từ model
        $shortcode_data = $this->model->get_shortcode_data($atts);

        // Sử dụng view để hiển thị wrapper
        return $this->view->render($shortcode_data);
    }
}
