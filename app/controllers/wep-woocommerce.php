<?php

/**
 * Class integration ACF into System
 * Include methods return values
 */
class WEP_Woocommerce {

    private $acf_import_options = array(
        'wep_single_service_warranty_content' => 'Bảo hành',
        'wep_single_service_repair_content' => 'Thời gian sửa',
        'wep_single_service_description' => 'Mô tả (shortcode)',
    );

    public function __construct() {

        // Thêm lớp CSS Bootstrap cho sản phẩm trên trang danh sách sản phẩm
        add_filter('post_class', array($this, 'add_bootstrap_classes_to_product'), 10, 3);

        // Thay đổi HTML của nút Mua Hàng
        add_filter('woocommerce_loop_add_to_cart_link', array($this, 'custom_add_to_cart_button'), 10, 2);

        // Thêm lớp CSS Bootstrap cho trang giỏ hàng
        add_action('woocommerce_before_cart', array($this, 'add_bootstrap_classes_to_cart'));

        // Chuyển hướng tới archive product
        add_filter('template_include', array($this, 'wep_product_cat_template'));

        // add_action('after_setup_theme', array($this, 'wep_add_woocommerce_support'));
        // Must at Woocommerce Templates END

        // Woocommerce Lightbox
        add_action('after_setup_theme', array($this, 'wep_wc_lightbox'));

        // WooCommerce Breadcrumb
        if (!function_exists('bs_woocommerce_breadcrumbs')) :
            add_filter('woocommerce_breadcrumb_defaults', array($this, 'wep_woocommerce_breadcrumwep'));
        endif;

        /* ACF and WooCommerce */
        // Add Related after WEP_Tabs
        add_action('wep_single_product_related_products', 'woocommerce_output_related_products', 10);

        // Save custom product data
        add_action('woocommerce_process_product_meta', array($this, 'save_custom_product_data'));


        // Hook into WooCommerce actions and filters
        add_action('init', array($this, 'wep_customize_catalog_ordering'));

        // Change badge
        add_filter('woocommerce_sale_flash', array($this, 'wep_change_onsale_badge_html'), 10, 3);

        // Out of stock status
        add_filter('woocommerce_get_availability_text', array($this, 'wep_change_out_of_stock_status'), 10, 2);

        // PageNavi
        add_filter('woocommerce_pagination_args', array($this, 'wep_woocommerce_pagination'));

        // Product Image        
        add_filter('woocommerce_single_product_image_html', array($this, 'wep_woocommerce_product_image_class'), 10, 3);
        add_filter('woocommerce_single_product_image_thumbnail_html', array($this, 'wep_woocommerce_product_image_class'), 10, 3);

        // Change title loop product
        add_action('woocommerce_shop_loop_item_title', array($this, 'change_product_title_tag'), 1);

        // Change title related
        add_filter('woocommerce_product_related_products_heading', array($this, 'wep_change_related_products_heading'));

        // Show Total Sales on Product Page
        add_action('wep_woocommerce_single_product_summary', array($this, 'wep_product_sold_count'), 11);

        // Bổ sung shortcode review product
        add_shortcode('product_reviews', array($this, 'wep_product_reviews_shortcode'));

        // Thêm review rate cho sản phẩm
        add_action('wep_rating_show', 'woocommerce_template_single_rating', 10);

        // Thêm flash sale
        add_action('wep_before_single_product_meta', 'woocommerce_show_product_sale_flash', 10);
        // add_action('wep_before_single_product_meta', 'woocommerce_template_single_rating', 20);

        // Remove Default Button Buy Now
        global $devvn_quickbuy;
        remove_action('woocommerce_single_product_summary', array($devvn_quickbuy, 'add_button_quick_buy'), 35);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

        // Add new fields into fields mapping of woo 
        add_filter('woocommerce_csv_product_import_mapping_options', array($this, 'wep_add_my_option'), 10, 2);

        // Đăng ký một hàm với hàm do_action
        add_action('woocommerce_product_import_before_import', array($this, 'wep_updated_import_data_acf'), 10, 1);
    }



    // Hiển thị nội dung dữ liệu đang Import bởi Woo
    function wep_updated_import_data_acf($parsed_data) {

        if ($parsed_data) :
            $product_id = $parsed_data['id'];
            $product_warranty = $parsed_data['wep_single_service_warranty_content'];
            $product_repair = $parsed_data['wep_single_service_repair_content'];
            $product_description = $parsed_data['wep_single_service_description'];

            $update_data['wep_single_service_warranty_content'] = $product_warranty;
            $update_data['wep_single_service_repair_content'] = $product_repair;
            $update_data['wep_single_service_description'] = $product_description;

            // Add option into product với id 
            $this->wep_update_options_into_product($product_id, $update_data);
        endif;
    }

    // Save content to description
    function add_content_to_product_description($additional_content, $product_id) {

        // Lấy sản phẩm
        $product = wc_get_product($product_id);
        if (!$product) {
            return 'Không tìm thấy sản phẩm.';
        }

        // Lấy mô tả hiện tại
        $current_description = $product->get_description();

        // Loại bỏ shortcode nếu đã có
        // Replace 'noi_dung_mat_khau' with your shortcode name
        $pattern = '/\[noi_dung_mat_khau(.*?)\[\/noi_dung_mat_khau\]/';
        $current_description = preg_replace($pattern, '', $current_description);

        // Thêm nội dung vào cuối mô tả
        $new_description = $current_description . $additional_content;

        // Cập nhật mô tả
        $product->set_description($new_description);
        $product->save();

        return 'Đã cập nhật mô tả sản phẩm.';
    }


    // Update option ACF
    function wep_update_options_into_product($pid = null, $update_data = array()) {
        // Lấy ID của sản phẩm.
        if ($pid === null) {
            $product_id = get_the_ID();
        } else {
            $product_id = $pid;
        }

        if ($update_data) :
            // Tạo một mảng với các giá trị mới - bảo hành và thời gian sửa.        
            $warranty_data = array(
                'wep_single_service_warranty_content' => $update_data['wep_single_service_warranty_content'],
                'wep_single_service_warranty_custom' => 1
            );

            $repair_data = array(
                'wep_single_service_repair_content' => $update_data['wep_single_service_repair_content'],
                'wep_single_service_repair_custom' => 1
            );

            $netflix_data = $update_data['wep_single_service_description'];


            // Cập nhật shortcode into end of description
            $this->add_content_to_product_description($netflix_data, $product_id);

            // Cập nhật trường.
            update_field('wep_single_service_warranty', $warranty_data, $product_id);
            update_field('wep_single_service_repair', $repair_data, $product_id);
        endif;
    }


    // Add new fields into fields mapping of woo
    function wep_add_my_option($options, $item) {
        $options = $this->acf_import_options + $options;
        return $options;
    }

    // Kiểm tra sản phẩm có cho phép đánh giá hay không
    static function wep_check_product_reviews_allowed($product_id) {
        $product = wc_get_product($product_id);
        if ($product) {
            return $product->get_reviews_allowed();
        }
        return false;
    }

    /* Shortcode đếm số lượng review product */
    static function wep_product_reviews_counter($product_id = '') {
        if (!empty($product_id) && function_exists('wc_get_product')) {
            $product = wc_get_product((int)$product_id);
            return $product->get_review_count();
        }
    }

    /* Shortcode Product Reviews */
    function wep_product_reviews_shortcode($atts) {
        if (empty($atts)) return '';
        if (!isset($atts['id'])) return '';
        $comments = get_comments('post_id=' . $atts['id']);
        if (!$comments) return '';
        $html .= '<div class=\"woocommerce-tabs\"><div id=\"reviews\"><ol class=\"commentlist\">';
        foreach ($comments as $comment) {
            $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
            $html .= '<li class=\"review\">';
            $html .= get_avatar($comment, '60');
            $html .= '<div class=\"comment-text\">';
            if ($rating) $html .= wc_get_rating_html($rating);
            $html .= '<p class=\"meta\"><strong class=\"woocommerce-review__author\">';
            $html .= get_comment_author($comment);
            $html .= '</strong></p>';
            $html .= '<div class=\"description\">';
            $html .= $comment->comment_content;
            $html .= '</div></div>';
            $html .= '</li>';
        }
        $html .= '</ol></div></div>';
        return $html;
    }


    // Total sold
    function wep_product_sold_count() {
        global $product;
        $total_sold = $product->get_total_sales();
        if ($total_sold) {
            echo '<p>' . sprintf(__('Total Sold: %s', 'woocommerce'), $total_sold) . '</p>';
        }
    }

    // Change heading related content
    function wep_change_related_products_heading() {
        return 'DỊCH VỤ - SẢN PHẨM TƯƠNG TỰ';
    }

    // Change title class tag
    function change_product_title_tag() {
        remove_action('woocommerce_shop_loop_item_title', array($this, 'woocommerce_template_loop_product_title'), 10);
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        add_action('woocommerce_shop_loop_item_title', array($this, 'new_woocommerce_template_loop_product_title'), 10);
    }

    function new_woocommerce_template_loop_product_title() {
        echo '<h4 class="wep_service_by_device__title">' . get_the_title() . '</h4>';
    }

    // Change image
    function wep_woocommerce_product_image_class($html, $post_id, $post_image_id) {
        // Tìm các thẻ img trong sản phẩm
        $html = preg_replace('/<img(.*?)class=[\'"](.*?)[\'"](.*?)>/', '<img$1class="$2 img-fluid"', $html);

        // Tìm các thẻ a với lớp .woocommerce-loop-product__link và thêm lớp .wep_service_by_device__image
        $html = preg_replace('/<a(.*?)class=[\'"](.*?woocommerce-loop-product__link)(.*?)[\'"](.*?)>/', '<a$1class="$2 wep_service_by_device__image$3"', $html);

        return $html;
    }

    // PageNavi
    public function wep_woocommerce_pagination($args) {
        $args['type'] = 'list';
        $args['prev_text'] = '«';
        $args['next_text'] = '»';

        $links = paginate_links($args);

        if (is_array($links)) {
            echo '<section class="wep_pagenav"><ul class="pagination">';
            foreach ($links as $link) {
                if (strpos($link, 'current') !== false) {
                    echo '<li class="page-item active">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
                } else {
                    echo '<li class="page-item">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
                }
            }
            echo '</ul></section>';
        }
    }
    // Change Out of stock
    function wep_change_out_of_stock_status($html, $product) {
        // Kiểm tra trạng thái sản phẩm
        if (!$product->is_in_stock()) {

            // Thay đổi class và nội dung của thẻ p khi hết hàng
            $html = '<p class="badge rounded-pill bg-danger">Hết hàng</p>';

            // Kiểm tra trạng thái đặt hàng trước
        } elseif ($product->is_purchasable()) {

            // Thay đổi class và nội dung của thẻ p khi có thể đặt hàng trước
            $html = '<p class="badge rounded-pill bg-info text-dark">Đặt hàng</p>';
        } else {
            // Thay đổi class và nội dung của thẻ p khi còn hàng
            $html = '<p class="badge rounded-pill bg-success">Còn hàng</p>';
        }

        return $html;
    }

    // Change Badge OnSale
    function wep_change_onsale_badge_html($html, $post, $product) {
        // Thay đổi class và nội dung của thẻ span
        $html = '<span class="wep_onsale badge rounded-pill bg-warning text-dark mb-2">Giảm giá!</span>';
        return $html;
    }


    // Ordering
    public function wep_customize_catalog_ordering() {

        // For default woo template
        // remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        add_action('woocommerce_before_shop_loop', array(__CLASS__, 'wep_custom_catalog_ordering'), 30);
        add_filter('woocommerce_get_catalog_ordering_args', array(__CLASS__, 'wep_custom_catalog_ordering_next'));
    }

    static function wep_custom_catalog_ordering_next($args) {
        $orderby_value = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));

        $tax_query = array();
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'filter_') !== false) {
                $taxonomy = str_replace('filter_', '', $key);
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => explode(',', $value)
                );
            }
        }

        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }

        switch ($orderby_value) {
            case 'popularity':
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'desc';
                $args['meta_key'] = 'total_sales';
                break;
            case 'price':
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'asc';
                $args['meta_key'] = '_price';
                break;
            case 'price-desc':
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'desc';
                $args['meta_key'] = '_price';
                break;
            default:
                break;
        }

        return $args;
    }


    static function wep_custom_catalog_ordering() {
        WEP_Shortcode::render('[wep_offcanvas_open_filter]');
        echo '<section class="wep_category_service_grid__sorting">';
        echo '<div class="wep_category_service_grid__label">Sắp xếp :</div>';
        $orderby_options = apply_filters(
            'woocommerce_catalog_orderby',
            array(
                // 'menu_order' => 'Mặc định',
                // 'rating'     => 'Đánh giá',
                // 'date'       => 'Mới nhất',
                'popularity' => 'Bán chạy',
                'price'      => 'Giá thấp',
                'price-desc' => 'Giá cao',
            )
        );

        foreach ($orderby_options as $key => $value) :
            $checked = checked($key, isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'popularity', false);

?>
            <div class="wep-control wep-radio wep-control-inline">
                <input type="radio" id="<?php echo esc_attr($key); ?>" name="orderby" value="<?php echo esc_attr($key); ?>" class="wep-control-input" <?php checked($key, isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'menu_order'); ?>>
                <label class="wep-control-label" for="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></label>
            </div>
<?php
        endforeach;
        echo '</section>';
    }




    // Thêm một tab tùy chỉnh vào trang quản lý sản phẩm WooCommerce
    public function add_custom_tab_to_product_page($tabs) {
        $tabs['custom_tab'] = array(
            'label'     => __('ACF Tab', 'bvdt'), // Đổi tên tab tùy ý
            'target'    => 'wep_tab_content', // Đặt ID của div chứa nội dung tab
            'class'     => array('show_if_simple', 'show_if_variable'),
        );
        return $tabs;
    }

    // Lưu dữ liệu trường tùy chỉnh ACF khi sản phẩm được lưu
    public function save_custom_product_data($post_id) {
        // Lưu dữ liệu ACF ở đây (nếu cần)
        if (function_exists('acf_save_post')) {
            acf_save_post($post_id);
        }
    }


    // Hiển thị Field Group ACF bên trong tab general options woo
    public function display_custom_product_data_fields() {
        global $post;

        echo '<div class="options_group">';
        echo '<h2>Tùy chọn chi tiết</h2>'; // Đổi tên tab tùy ý

        // Lấy và hiển thị Field Group ACF
        if (function_exists('acf_form')) {
            acf_form([
                'post_id' => $post->ID,
                'field_groups' => [176],
                'form' => false,
                'submit_value' => 'Lưu', // Đổi tên nút "Lưu"
                'updated_message' => 'Dữ liệu đã được cập nhật.', // Thông báo sau khi lưu
            ]);
        }

        echo '</div>';
    }

    // Breadcrumb
    public function wep_woocommerce_breadcrumbs() {
        return array(
            'delimiter'   => '',
            'wrap_before' => "<nav aria-label='breadcrumb' class='wc-breadcrumb breadcrumb-scroller mb-4 mt-2 py-2 px-3 bg-body-tertiary rounded'>
        <ol class='breadcrumb mb-0'>",
            'wrap_after'  => '</ol>
        </nav>',
            'before'      => '<li class="breadcrumb-item">',
            'after'       => '</li>',
            // Remove "Home" and add Fontawesome house icon (_wc_breadcrumb.scss)
            //'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
            'home'        => ' ',
        );
    }
    // WooCommerce Breadcrumb End

    function wep_wc_lightbox() {
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
    // Woocommerce Lightbox End

    // Woocommerce Templates
    // function wep_add_woocommerce_support() {
    //     add_theme_support('woocommerce');
    // }

    function wep_product_cat_template($template) {
        if (is_tax('product_cat')) {
            $new_template = locate_template(array('archive-product.php'));
            if (!empty($new_template)) {
                return $new_template;
            }
        }
        return $template;
    }


    function add_bootstrap_classes_to_add_to_cart_button() {
        echo '<div class="mt-3">'; // Thêm lớp mt-3 Bootstrap cho khoảng cách top
        woocommerce_template_single_add_to_cart();
        echo '</div>';
    }


    function add_bootstrap_classes_to_product_price() {
        echo '<p class="lead">'; // Thêm lớp lead Bootstrap cho phần giá
        woocommerce_template_single_price();
        echo '</p>';
    }


    function add_bootstrap_classes_to_product_title() {
        echo '<h1 class="display-7">'; // Thêm lớp display-4 Bootstrap cho tiêu đề lớn
        the_title();
        echo '</h1>';
    }

    function add_bootstrap_classes_to_product($classes, $class, $post_id) {
        if (is_archive() && in_array('product', $class)) {
            $classes[] = 'col-md-4'; // Thêm lớp col-md-4 để sử dụng Bootstrap grid
        }
        return $classes;
    }

    function custom_add_to_cart_button($button_html, $product) {
        $button_html = str_replace('single_add_to_cart_button', 'btn btn-primary', $button_html);
        return $button_html;
    }

    function add_bootstrap_classes_to_cart() {
        if (is_cart()) {
            echo '<div class="container">';
        }
    }
}
