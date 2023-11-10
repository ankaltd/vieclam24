
<?php

class WEP_Woocommerce_Model {


    // Get list product for home
    static function get_wep_service_device_slider_products($slider_type, $slider_number, $slider_ids) {
        $args_category = array(
            'post_type' => 'product',
            'posts_per_page' => intval($slider_number),
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat', // Taxonomy là 'product_cat' (danh mục sản phẩm)
                    'field' => 'id', // Sử dụng ID chuyên mục để tìm kiếm
                    'include_children' => true, // Bao gồm sản phẩm con trong chuyên mục
                ),
            ),
        );

        $args_selection = array(
            'post_type' => 'product',
            'posts_per_page' => intval($slider_number),
            'orderby' => 'date',
            'order' => 'DESC'
        );

        // Nếu là dạng category - Lấy product thuộc id
        if ($slider_type === 'category') {
            $category_id = intval($slider_ids['category']);
            $args_category['tax_query'][0]['terms'] = $category_id;
        } elseif ($slider_type === 'selection' && is_array($slider_ids['selection']) && !empty($slider_ids['selection'])) {
            $args_selection['post__in'] = array_map('intval', $slider_ids['selection']);
        }

        if ($slider_type === 'category') {
            $products = new WP_Query($args_category);
        } else {
            $products = new WP_Query($args_selection);
        }

        // Lấy danh sách product
        $product_list = array();

        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                $product_id = get_the_ID();
                $product = wc_get_product($product_id);

                $saving = 0;
                if (is_numeric($product->get_regular_price()) && is_numeric($product->get_sale_price())) {
                    $saving = $product->get_regular_price() - $product->get_sale_price();
                }

                $warranty = WEP_Option_Model::get_group_field('wep_single_service_warranty', 'wep_single_service_warranty_content');
                $repair_time = WEP_Option_Model::get_group_field('wep_single_service_repair', 'wep_single_service_repair_content');

                $average      = $product->get_average_rating();

                $product_list[] = array(
                    'id' => $product_id,
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'thumbnail' => get_the_post_thumbnail_url($product_id, 'thumbnail'),
                    'regular_price' => $product->get_regular_price(),
                    'sale_price' => $product->get_sale_price(),
                    'warranty_content' => $warranty,
                    'repair_content' => $repair_time,                    
                    'savings' => $saving,
                    'star' => $average, // Đánh giá 5 sao (hoặc bạn có thể lấy đánh giá thực tế từ WooCommerce)
                );
                
        
            }
            wp_reset_postdata();
        }

        return $product_list;
    }
}
