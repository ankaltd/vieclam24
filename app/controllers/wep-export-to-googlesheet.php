<?php

class WEP_Export_To_GoogleSheet {

    // Constructor và các thuộc tính khác của class
    public function __construct() {
        $this->init_submenu();
    }

    // Hàm callback cho trang admin của WooCommerce Export Google Sheet
    public function woocommerce_export_products_googlesheet_menu_callback() {
        // Code xử lý hiển thị trang admin ở đây (nếu cần thiết)
    }

    // Hàm thêm submenu page
    public function add_export_googlesheet_submenu() {
        add_submenu_page(
            'woocommerce',
            'Export Google Sheet',
            'Export Google Sheet',
            'manage_woocommerce',
            'woocommerce_export_products_googlesheet_menu',
            array($this, 'woocommerce_export_products_googlesheet_menu_callback')
        );
    }

    // Hàm gọi trong constructor hoặc ở bất kỳ đâu bạn muốn
    public function init_submenu() {
        add_action('admin_menu', array($this, 'add_export_googlesheet_submenu'));
    }
}
