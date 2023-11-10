<?php

/**
 * Class of Web Interface Block => Logo
 * 1 - Create an class WIB_Name in dir app/controllers/wib-name.php
 * 2 - Change name of shortcode for WIB_Name at $shortcode = 'wib_logo'
 * 3 - Create an class WIB_Model in dir app/models/wib-name-model.php
 * 4 - Create an class WIB_View in dir app/views/wib-name-view.php
 * 5 - Create an template in dir app/wib-templates/wib-name-tpl.php
 */

class WIB_Base {
    private $model;
    private $view;
    private $shortcode;
    private $args;

    public function __construct($shortcode, $model, $view, $args) {
        $this->model = $model;
        $this->view = $view;
        $this->shortcode = $shortcode;
        $this->args = $args;

        // Đăng ký shortcode trong constructor
        add_shortcode($shortcode, array($this, 'render_shortcode'));
    }

    // Render Shortcode with [shortcode param=val]
    public function render_shortcode($atts) {
        // Xử lý thuộc tính truyền vào shortcode và lấy dữ liệu từ model
        $shortcode_data = $this->model->get_shortcode_data($atts);

        // Sử dụng view để hiển thị logo
        return $this->view->render($shortcode_data);
    }

    // Render Element with method Class_Name::render($args);
    public function render($atts) {
        // Xử lý thuộc tính truyền vào shortcode và lấy dữ liệu từ model
        $shortcode_data = $this->model->get_shortcode_data($atts);

        // Sử dụng view để hiển thị logo
        return $this->view->render($shortcode_data);
    }

}
