<?php

/**
 * Class WEP_Ajax_Model
 */
class WEP_Ajax_Model {

    /**
     * Get Related Product by key
     *
     * @return void
     */
    public static function get_related_content(){
        // Get the key from the AJAX request
        $product_id = sanitize_text_field($_POST['pid']);

        // Get related product
        $data = WEP_Product_Model::wep_woocommerce_related_products($product_id);   
        
        // Return content
        get_template_part('parts/single-product/product', 'related', $data);

        // Terminate the script
        wp_die();
    }

    /**
     * Get Tab Product Content by key
     *
     * @return void
     */
    public static function get_tab_content() {
        // Get the key from the AJAX request
        $key = sanitize_text_field($_POST['key']);
        $product_id = sanitize_text_field($_POST['pid']);
        $default_policy_id = sanitize_text_field($_POST['dpid']);

        // Define tab data
        $tab_data = array(
            'thong-tin-bo-sung' => 'parts/single-product/tabs/more-information',
            'mo-ta' => 'parts/single-product/tabs/description',
            'chinh-sach-bao-hanh' => 'parts/single-product/tabs/warranty-policy',
        );

        // Check if the key exists in the tab data
        if (array_key_exists($key, $tab_data)) {
            get_template_part($tab_data[$key], '', ['id' => $product_id, 'dpid' => $default_policy_id]);
        } else {
            echo '...';
        }

        // Terminate the script
        wp_die();
    }

    /**
     * Get Post Title by ID
     *
     * This method retrieves the post title by its ID.
     *
     * @param int $post_id The ID of the post.
     * @return string The post title.
     */
    public function get_post_title_by_id($post_id) {

        $post_title = '';

        // Perform a query to retrieve the post title of the specified ID
        $post = get_post($post_id);
        if ($post) {
            $post_title = $post->post_title;
        }


        return apply_filters('wep_post_title', $post_title);
    }

    /**
     * Get More News Posts
     *
     * This method retrieves more news posts based on pagination and category IDs.
     *
     * @param int $paged The current page number.
     * @param array $category_ids The category IDs to filter news posts.
     * @return array An array containing max pages and HTML content of news items.
     */
    public function get_more_news($paged, $category_ids) {
        $ajaxposts = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 4,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged + 2,
            'category__in' => $category_ids,
        ]);

        $response = '';
        $max_pages = $ajaxposts->max_num_pages;

        if ($ajaxposts->have_posts()) {
            ob_start(); // Start output buffering

            while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
                // Include the template part for the news item
                get_template_part('blocks/news-grid/list', 'item');
            endwhile;

            $output = ob_get_clean(); // Get the buffered output and clean the buffer
        } else {
            $response = '';
        }

        // Prepare the result array
        $result = [
            'max' => $max_pages,
            'html' => $output, // Return the HTML content
        ];

        // Return the result as JSON
        echo json_encode($result);

        // Terminate the script
        die();
    }
}
