<?php

/**
 * WEP Option Class, with functions and filters related to the site options.
 * 
 */

class WEP_Admin_Option {

    private $general_option_pages = array(
        'Trang chủ' => 'https://bvdt.webp.vn/wp-admin/post.php?post=223&action=edit',
        '01 - Cài đặt chung' => 'field_64c13df3892e1',
        '02 - Header' => 'field_64690a4475f2a',
        '03 - Chi tiết dịch vụ' => 'field_64c143acf1761',
        '04 - Danh mục dịch vụ' => 'field_64db2133400c8',
        '05 - Chi tiết tin' => 'field_64c13f08892e4',
        '06 - Chuyên mục tin' => 'field_64c13e2f892e2',
        '07 - Trang Liên hệ' => 'field_64690d6f9ad09',
        '08 - Trang tìm kiếm' => 'field_64c0b9758618b',
        '09 - Footer' => 'field_64db207d400c3',
        '10 - Custom Code' => 'field_64f20c293acc1',
    );

    // Init
    public function __construct() {

        $this->model = new WEP_Option_Model;

        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(
                array(
                    'page_title' => 'Cài đặt chung - Web BVĐT',
                    'menu_title' => 'Cài đặt BVĐT',
                    'position' => '2',
                )
            );
        }
        add_filter('enter_title_here', [$this, 'change_default_title'], 10, 2);

        // ACF Pro đã được kích hoạt
        if (class_exists('acf')) {
            // Thực hiện các hành động bạn muốn khi ACF Pro đã kích hoạt

            // Gắn hàm callback vào hook 'admin_bar_menu'
            add_action('admin_bar_menu', [$this, 'add_custom_admin_bar_link'], 999);

            // Gắn hàm callback vào hook 'admin_bar_menu'
            add_action('admin_bar_menu', [$this, 'customize_admin_bar_link'], 999);


            // Bổ sung menu con cho Admin Bar Menu
            add_action('admin_bar_menu', array($this, 'wep_general_option_pages_admin_bar'));


            // Bổ sung menu con cho từng mục
            add_action('admin_menu', array($this, 'wep_general_option_pages_admin_menu'));
        }
    }

    // Thêm các mục menu con cho Admin Bar Menu Options
    function wep_general_option_pages_admin_bar() {

        global $wp_admin_bar;
        if (!is_super_admin() || !is_admin_bar_showing())
            return;

        foreach ($this->general_option_pages as $title => $tab) {

            // Sub Menus Admin Bar
            if ($title === 'Trang chủ') :
                $url = $tab;
            else :
                $url = admin_url('admin.php?page=acf-options-cai-dat-bvdt&tab=' . $tab);
            endif;

            $wp_admin_bar->add_menu(array(
                'parent' => 'custom_admin_bar_link',
                'id' => 'wep_menu_' . $tab,
                'title' => __($title),
                'href' => $url,
            ));
        }
    }

    // Thêm các mục menu con cho Admin Menu Options
    function wep_general_option_pages_admin_menu() {
        foreach ($this->general_option_pages as $title => $tab) {

            // Sub Menus Admin
            if ($title === 'Trang chủ') :
                $url = $tab;
            else :
                $url = admin_url('admin.php?page=acf-options-cai-dat-bvdt&tab=' . $tab);
            endif;

            add_submenu_page(
                'acf-options-cai-dat-bvdt', // Trang cha của submenu, có thể là slug của trang chính hoặc slug của menu cha
                __($title), // Tiêu đề trang
                __($title), // Tên trên menu
                'manage_options', // Quyền truy cập
                $url, // Slug của submenu
                function () use ($url) { // Sử dụng biến $url trong hàm callback
                    echo '<script>window.location="' . $url . '"</script>';
                }
            );
        }
    }

    // Hàm callback để thêm liên kết vào thanh admin bar, nhưng ẩn "Tùy biến"
    function customize_admin_bar_link($wp_admin_bar) {
        // Kiểm tra xem liên kết nào đang được thêm vào, nếu là "customize.php" thì loại bỏ nó
        foreach ($wp_admin_bar->get_nodes() as $node) {
            if (strpos($node->href, 'customize.php') !== false) {
                $wp_admin_bar->remove_node($node->id);
            }
        }
    }

    // Hàm callback để thêm liên kết vào thanh admin bar
    function add_custom_admin_bar_link() {
        global $wp_admin_bar;

        // Đặt URL của trang cấu hình website ở đây
        $url = home_url() . '/wp-admin/admin.php?page=acf-options-cai-dat-bvdt';

        // Thêm liên kết vào thanh admin bar
        $args = array(
            'id'    => 'custom_admin_bar_link',
            'title' => 'Cài đặt BVĐT', // Tiêu đề hiển thị trên thanh admin bar
            'href'  => $url,
            'meta'  => array('class' => 'custom-admin-bar-link')
        );
        $wp_admin_bar->add_node($args);
    }


    // Change Title of form ACF to FE
    function change_default_title($title, $post_type) {
        if ($post_type == 'subscriber') { // Thay 'your_custom_post_type' bằng tên custom post type của bạn
            $title = 'Họ và tên'; // Thay 'Mới Tiêu đề' bằng tiêu đề mới mà bạn muốn sử dụng
        }
        return $title;
    }

    // Get option of page - ACF get fields for current page
    public function get_page_option($page_template) {

        $result = array();

        if (($page_template != '') || ($page_template)) {
        }

        return $result;
    }

    // Get list option of layout in current page 
    public function get_layout_option($layout_name) {
        $result = array();

        if (($layout_name != '') || ($layout_name)) {
        }

        return $result;
    }
}
