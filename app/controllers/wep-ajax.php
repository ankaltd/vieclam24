<?php
class WEP_Ajax {

    public function __construct() {       

        // Đăng ký và enqueue script AJAX
        add_action('wp_enqueue_scripts', array($this, 'client_enqueue_scripts'));

        // Tab Product Content
        add_action('wp_ajax_get_tab_content', array('WEP_Ajax_Model', 'get_tab_content'));
        add_action('wp_ajax_nopriv_get_tab_content', array('WEP_Ajax_Model', 'get_tab_content'));

        // Loading Related Product
        add_action('wp_ajax_get_related_content', array('WEP_Ajax_Model', 'get_related_content'));
        add_action('wp_ajax_nopriv_get_related_content', array('WEP_Ajax_Model', 'get_related_content'));

        // Gọi các hàm xử lý khác AJAX ở đây     

    }

    // Đăng ký các script và style cần thiết cho AJAX
    public function client_enqueue_scripts() {
        wp_enqueue_script('wep-ajax', get_template_directory_uri() . '/assets/js/wep-ajax.js', array('jquery'), '1.0', true);

        // Tạo nonce và truyền vào script
        $ajax_nonce = wp_create_nonce('wep-ajax-nonce');
        wp_localize_script('wep-ajax', 'wepAjax', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'ajaxNonce' => $ajax_nonce // Truyền nonce vào JavaScript
        ));
    }
   
}
