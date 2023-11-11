
<?php
/* WEP Product Model Class */

class WEP_Product_Model {


    /* Lấy danh sách những loại thuộc tính sử dụng cho sản phẩm */
    // static function wep_used_atributes_of_product($product_id = null) {
    //     $result = array();

    //     if ($product_id == null) {
    //         $pid = $product_id;
    //     } else {
    //         $pid = get_the_ID(); // Thay 123 bằng ID của sản phẩm bạn muốn lấy thuộc tính
    //     }

    //     $product = wc_get_product($pid);
    //     $attributes = $product->get_attributes();

    //     if (!empty($attributes)) {
    //         foreach ($attributes as $attribute) {
    //             $result[] = $attribute['name'] . "\n";
    //         }
    //     }

    //     return $result;
    // }

    /* Lấy FAQs theo bộ  */
    static function wep_get_list_faqs_by_set($set_id = null, $number = -1) {
        $args = array(
            'post_type' => 'faq',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_group',
                    'field' => 'term_id',
                    'terms' => $set_id,
                ),
            ),
        );

        $faq_posts = get_posts($args);

        $results = array();

        foreach ($faq_posts as $post) {
            $post_id = $post->ID;
            $post_title = $post->post_title;
            $post_content = $post->post_content;
            $post_slug = $post->post_name;
            $results[] = array(
                'id' => $post_id,
                'title' => $post_title,
                'content' => $post_content,
                'slug' => $post_slug,
            );
        }

        return $results;
    }

    /* Lấy FAQs theo danh sách ids */
    static function wep_get_list_faqs_by_ids($ids = array(), $number = -1) {

        $args = array(
            'post_type' => 'faq',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'post__in' => $ids,
        );

        $faq_query = new WP_Query($args);

        $results = array();

        if ($faq_query->have_posts()) {
            while ($faq_query->have_posts()) {
                $faq_query->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_content = get_the_content();
                $post_slug = get_post_field('post_name', $post_id);
                $results[] = array(
                    'id' => $post_id,
                    'title' => $post_title,
                    'content' => $post_content,
                    'slug' => $post_slug,
                );
            }
        }
        wp_reset_postdata();

        return $results;
    }

    /**
     * Output the related products.
     *
     * @param array $args Provided arguments.
     */
    static function wep_woocommerce_related_products($pid = null) {

        $product_id = $pid;
        $related_products_custom = WEP_Option_Model::get_group_field('wep_single_service_related', 'wep_single_service_related_custom', $product_id);
        $related_products_ids = WEP_Option_Model::get_group_field('wep_single_service_related', 'wep_single_service_related_select_custom', $product_id);


        $args = array();
        $defaults = array(
            'posts_per_page' => 4,
            'columns'        => 4,
            'orderby'        => 'rand', // @codingStandardsIgnoreLine.
            'order'          => 'desc',
        );

        $args = wp_parse_args($args, $defaults);

        // Nếu không tự chọn => tự động
        if (!$related_products_custom) {
            // Get visible related products then sort them at random.
            $args['related_products'] = wc_get_related_products($product_id, $args['posts_per_page']);            
        } else {
            $args['related_products'] = $related_products_ids;
        }

        


        return $args;
    }

    /* Save product to cookie */
    public static function wep_save_product($product_id, $cookie_name = 'wep_product_cookie') {
        $product_data = self::wep_get_product($cookie_name);

        if (!$product_data) {
            $product = wc_get_product($product_id);
            $product_data = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' => $product->get_price(),
                // Thêm thông tin sản phẩm khác cần lưu trữ vào đây
            );
            WEP_Helper::save_to_cookie($cookie_name, $product_data);
        }
    }

    // Get product data from cookie
    public static function wep_get_product($cookie_name = 'wep_product_cookie') {
        return WEP_Helper::get_from_cookie($cookie_name);
    }

    /* Get product category infor */
    static function get_product_categories($current_product_id = null) {

        $result = array();

        if (is_null($current_product_id)) :
            $product_id = get_the_ID();
        else :
            $product_id = $current_product_id;
        endif;

        $product_categories = wp_get_post_terms($product_id, 'product_cat');
        if (!empty($product_categories) && !is_wp_error($product_categories)) {
            foreach ($product_categories as $product_category) {
                $result[$product_category->term_id] = array(
                    'id' => $product_category->term_id,
                    'name' => $product_category->name,
                    'slug' => $product_category->slug,
                    'permalink' => get_term_link($product_category->term_id, 'product_cat')
                );
            }
        }

        return $result;
    }

    /* Get product_cat_type of product_category */
    static function get_product_cat_type($current_product_id = null) {

        if (is_null($current_product_id)) {
            $product_id = get_the_ID();
        } else {
            $product_id = $current_product_id;
        }

        $product_categories = wp_get_post_terms($product_id, 'product_cat');
        if ($product_categories) :
            $product_cat_id = $product_categories[0]->term_id;
            $product_cat_type = WEP_Option_Model::get_field_in_taxonomy('wep_product_cat_type', 'product_cat', '', $product_cat_id);
        else :
            $product_cat_type = 'service';
        endif;

        if ($product_cat_type) :
            return $product_cat_type;
        else :
            return 'service';
        endif;
    }

    /* Get name of term in attribute */
    static function get_term_name_by_slug_and_taxonomy($term_slug, $taxonomy_name) {
        // Lấy thông tin của term dựa trên slug và taxonomy
        $term = get_term_by('slug', $term_slug, $taxonomy_name);

        if ($term) {
            // Lấy tên của term
            return $term->name;
        } else {
            return null; // Trả về null nếu không tìm thấy term
        }
    }


    /* Generate filtering permalink */
    static function generate_filtering_permalinks() {

        // lấy current url without params $current_url as string
        $current_product_cat = WEP_Product_Model::get_current_product_category_permalink();

        // lấy current params without url $current_params as array
        $current_params = WEP_Product_Model::get_current_query_params();

        // 1 - Link remove all filter
        $result_link = array();

        $result_link['remove-all'] = array(
            'title' => 'Bỏ chọn tất cả',
            'link' => $current_product_cat
        );

        // 2 - Other link - lặp qua tất cả các mục params
        foreach ($current_params as $attr_name => $attr_value) {
            $result_link['remove-' . $attr_name] = array(
                'title' => $attr_value,
                'link' => self::remove_selected_attribute_link($attr_name, $attr_value)
            );
        }


        return $result_link;
    }

    /* Remove attribute and value from current url */
    static function remove_selected_attribute_link($attr_name = '', $attr_value) {

        // lấy current url without params $current_url as string
        $current_product_cat = WEP_Product_Model::get_current_product_category_permalink();

        // lấy current params without url $current_params as array
        $current_params = WEP_Product_Model::get_current_query_params();

        $result_link = $current_product_cat;

        // Nếu mảng params có key là thuộc tính thì tìm tiếp
        if (array_key_exists($attr_name, $current_params)) :

            // Lấy giá trị của key 
            $attr_value_str = $current_params[$attr_name];

            // Chuyển giá trị qua array để kiểm tra tiếp
            $attr_value_arr = explode(",", $attr_value_str);

            // Nếu có sẽ loại bỏ
            if (in_array($attr_value, $attr_value_arr)) :

                // Tìm chỉ số của giá trị trong mảng
                $key = array_search($attr_value, $attr_value_arr);

                // Loại bỏ
                unset($attr_value_arr[$key]);

                // Chuyển ngược lại thành chuỗi giá trị
                $new_attr_value_str = implode(",", $attr_value_arr);

                // chuyển ngược lại giá trị 
                $current_params[$attr_name] = $new_attr_value_str;


            endif;

            // Nếu không còn giá trị nào thì bỏ luông key đó
            if (empty($attr_value_arr)) :
                unset($current_params[$attr_name]);
            endif;

            //  Chuyển $current_params thành chuỗi 
            $filter_params = WEP_Helper::array_to_params($current_params);

            if (empty($filter_params)) :
                $result_link = $current_product_cat;
            else :
                $result_link = $current_product_cat . '?' . urldecode($filter_params);
            endif;

        endif;

        return $result_link;
    }

    /* Tạo link filter */
    static function get_product_category_filter_permalink($attr_name = '', $attr_value) {

        // lấy current url without params $current_url as string
        $current_product_cat = WEP_Product_Model::get_current_product_category_permalink();

        // lấy current params without url $current_params as array
        $current_params = WEP_Product_Model::get_current_query_params();

        // Kiểm tra nếu $current_params ko tham số
        if (!$current_params) :
            $current_params = array();
            $current_params[$attr_name] = $attr_value;

        // Kiểm tra xem không tồn tại thuộc tính trong tham số hiện tại tồn tại key = $attr_name
        elseif (!array_key_exists($attr_name, $current_params)) :
            $current_params[$attr_name] = $attr_value;

        else :

            // Kiểm tra nếu $current_params tồn tại key = $attr_name rồi
            // lấy giá trị hiện tại của thuộc tính $attr_name dạng chuỗi
            $attr_value_str = $current_params[$attr_name];

            /// Chuyển sang dạng array
            $attr_value_arr = explode(",", $attr_value_str);

            // kiểm tra $value_arr nếu chưa có $attr_value thì thêm vào giá trị mới
            if (!in_array($attr_value, $attr_value_arr)) :
                $attr_value_arr[] = $attr_value;
            endif;

            // chuyển ngược lại thành str 
            $new_attr_value_str = implode(",", $attr_value_arr);

            // chuyển ngược lại giá trị 
            $current_params[$attr_name] = $new_attr_value_str;

        endif;

        //  Chuyển $current_params thành chuỗi 
        $filter_params = WEP_Helper::array_to_params($current_params);

        // Ghép lại 
        if ($filter_params) :
            $result = $current_product_cat . '?' . urldecode($filter_params);
        else :
            $result = false;
        endif;

        return $result;
    }

    /* Lấy current permalink  */
    static function get_current_product_category_permalink() {
        if (is_product_category()) {
            $current_category_id = get_queried_object_id();

            // Lấy permalink của danh mục sản phẩm hiện tại
            $category_permalink = get_term_link($current_category_id, 'product_cat');

            return $category_permalink;
        }

        // Trả về null nếu không phải trang danh mục sản phẩm
        return null;
    }

    /* Get current query string */
    static function get_current_query_params($return_str = false) {

        // Lấy các tham số sau dấu "?"
        $query_parameters = $_SERVER['QUERY_STRING'];

        // Chuyển sang array
        parse_str($query_parameters, $query_arr);

        if ($return_str) {
            return urldecode($query_parameters);
        } else {
            return $query_arr;
        }
    }

    /* Lấy permalink của product category hiện tại */
    static function append_query_parameters_to_permalink() {
        if (is_product_category()) {

            $current_category_id = get_queried_object_id();

            // Lấy permalink của danh mục sản phẩm hiện tại
            $category_permalink = get_term_link($current_category_id, 'product_cat');

            // Lấy các tham số sau dấu "?"
            $query_parameters = $_SERVER['QUERY_STRING'];

            // Kiểm tra xem có tham số nào hay không
            if (!empty($query_parameters)) {
                // Ghép các tham số vào permalink
                $category_permalink .= '?' . esc_html($query_parameters);
            }

            return $category_permalink;
        }

        // Trả về null nếu không phải trang danh mục sản phẩm
        return null;
    }


    /* Kiểm tra thuộc tính có giá trị biến thể không trong mảng */
    static function check_variant_list($data) {
        foreach ($data['attribute_items'] as $item) {
            if (isset($item['variant_list'][$data['attribute_name']]) && !empty($item['variant_list'][$data['attribute_name']])) {
                return true;
            }
        }
        return false;
    }

    /* Lấy danh sách biến thể của thuộc tính theo tên thuộc tính */
    static function get_product_variations_with_attribute_name($product_id, $attribute_name) {
        $product = wc_get_product($product_id);
        $product_type = $product->get_type();
        $result = array();

        if ($product_type == 'variable') :
            $variations = $product->get_available_variations();

            // Duyệt qua mảng các biến thể để lấy tên của từng biến thể    
            foreach ($variations as $variation) {
                $variation_id = $variation['variation_id'];
                $variation_product = wc_get_product($variation_id);


                // Lấy thuộc tính của biến thể
                $attributes_list = $variation['attributes'];

                // WEP_Helper::print_struct($attributes_list);

                // Lấy danh sách thuộc tính của biến thể
                $attributes = $variation_product->get_variation_attributes();

                // Kiểm tra xem biến thể có thuộc tính cần tìm không
                foreach ($attributes as $attr_name => $attr_value) {

                    if (strpos($attr_name, $attribute_name) !== false) {

                        $regular_price = $variation_product->get_regular_price();
                        $sale_price = $variation_product->get_sale_price() ? $variation_product->get_sale_price() : $regular_price;
                        $full_name = $variation_product->get_name();

                        // Lấy tên của biến thể
                        $term = get_term_by('slug', $attr_value, $attr_name);

                        $attr_taxonomy = 'pa_' . $attribute_name;
                        $term_slug = $attr_value; // Thay 'yellow' bằng slug của giá trị thuộc tính bạn muốn lấy tên

                        $term = get_term_by('slug', $term_slug, $attr_taxonomy);
                        if ($term) {
                            $variant_name = $term->name;
                        } else {
                            $variant_name = $attr_value;
                        }

                        $result[] = array(
                            'id' => $variation_id,
                            'image_url' => $variation['image']['url'],
                            'regular_price' => $regular_price,
                            'sale_price' => $sale_price,
                            'attr' => $attr_name,
                            'variant' => $attr_value,
                            'variant_name' => $variant_name,
                            'variant_list' => $attributes_list,

                        );
                        break;
                    }
                }
            }
        endif;

        return $result;
    }

    /* Lấy danh sách toàn bộ các thuộc tính sản phẩm */
    static function get_woocommerce_attributes() {
        global $wpdb;
        $attribute_taxonomies = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies");
        $attributes = array();

        if ($attribute_taxonomies) {
            foreach ($attribute_taxonomies as $tax) {
                $attributes[$tax->attribute_name] = $tax->attribute_label;
            }
        }

        return $attributes;
    }


    /* Lấy danh sách biến thể của một sản phẩm */
    static function get_variations_by_attribute_name($product_id, $attribute_id) {

        $product = wc_get_product($product_id);
        $variations = $product->get_available_variations();
        $result = array();

        foreach ($variations as $variation) {
            $variation_id = $variation['variation_id'];
            $variation_product = wc_get_product($variation_id);

            // Lấy danh sách thuộc tính của biến thể
            $attributes = $variation_product->get_variation_attributes();

            // Kiểm tra xem biến thể có thuộc tính cần tìm không
            if (isset($attributes['attribute_' . $attribute_id])) {
                $result[] = array(
                    'id' => $variation_id,
                    'image_url' => $variation['image']['url'],
                    'regular_price' => $variation_product->get_regular_price(),
                    'sale_price' => $variation_product->get_sale_price(),
                    'name' => $variation_product->get_name(),
                );
            }
        }

        return $result;
    }


    /* Lấy danh sách sản phẩm cùng nhóm với id hiện tại */
    public static function get_related_group_products($product_id, $group_field_name = 'wep_group_type_product', $field_type_name = 'wep_same_group_product_ids') {

        // Lấy group_type của sản phẩm hiện tại
        $group_product_ids = WEP_Option_Model::get_group_field($group_field_name, $field_type_name, $product_id);

        // Mảng để lưu thông tin các sản phẩm
        $products = array();

        if ($group_product_ids) :
            foreach ($group_product_ids as $id) {

                // Tạo đối tượng sản phẩm
                $product = wc_get_product($id);

                // Lấy thông tin cần thiết
                $title = get_the_title($id);
                $permalink = get_permalink($id);
                $thumbnail = get_the_post_thumbnail_url($id);
                $price = $product->get_price();

                // Lấy thuộc tính ACF group_type_display
                $group_type_display = WEP_Option_Model::get_group_field($group_field_name, 'wep_group_type_display', $id);

                // Thêm vào mảng sản phẩm
                $products[] = array(
                    'id' => $id,
                    'permalink' => $permalink,
                    'thumbnail' => $thumbnail,
                    'price' => $price,
                    'group_type_display' => $group_type_display ? $group_type_display : $title, // thêm thuộc tính này vào mảng
                );
            }
        endif;

        return $products;
    }

    // Get attribute list of woocomerce
    static function get_attribute_terms($attribute) {

        $args = array(
            'taxonomy' => 'pa_' . $attribute,
            'hide_empty' => true,
        );

        $attribute_terms = get_terms($args);
        $terms_array = array();
        if (!empty($attribute_terms) && !is_wp_error($attribute_terms)) {
            foreach ($attribute_terms as $term) {
                $term_link = get_term_link($term);
                if (is_wp_error($term_link)) {
                    continue;
                }
                $terms_array[] = array(
                    'id' => $term->term_id,
                    'slug' => $term->slug,
                    'name' => $term->name,
                    'permalink' => $term_link,
                    'filter_link' => self::get_product_category_filter_permalink($attribute, $term->slug)
                );
            }
        }

        return $terms_array;
    }


    // Get attribute list of woocomerce => hide empty product
    static function get_attribute_terms_hide_empty($attribute) {

        // Lấy slug của danh mục hiện tại
        $category_slug = get_queried_object()->slug;

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category_slug,
                    'operator' => 'IN',
                )
            ),
        );

        $the_query = new WP_Query($args);
        $terms_array = array();
        $terms_slug = array();

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $product_id = get_the_ID();
                $terms = get_the_terms($product_id, 'pa_' . $attribute);

                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $term_link = get_term_link($term);
                        if (is_wp_error($term_link)) {
                            continue;
                        }
                        $terms_array[] = array(
                            'id' => $term->term_id,
                            'slug' => $term->slug,
                            'name' => $term->name,
                            'permalink' => $term_link,
                            'filter_link' => self::get_product_category_filter_permalink($attribute, $term->slug)
                        );

                        // Lấy slug để lọc duy nhất
                        $terms_slug[] = $term->slug;
                    }
                }
            }
            /* Restore original Post Data */
            wp_reset_postdata();
        }


        // Lọc duy nhất
        $unique_slugs = array_unique($terms_slug);

        // Update lại array
        // Mảng kết quả
        $result_terms = [];

        foreach ($unique_slugs as $slug) {
            $found = false;
            foreach ($terms_array as $term) {
                if ($term['slug'] === $slug) {
                    $result_terms[] = [
                        'id' => $term['id'],
                        'slug' => $slug,
                        'name' => $term['name'],
                        'permalink' => $term['permalink'],
                        'filter_link' => $term['filter_link']
                    ];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                // Xử lý trường hợp không tìm thấy slug trong $terms_array
                // Ví dụ: có thể tạo một mảng với các giá trị mặc định hoặc thực hiện hành động khác tùy thuộc vào yêu cầu của bạn.
            }
        }
        return $result_terms;
    }

    // Định nghĩa hàm lấy danh sách danh mục con của danh mục hiện tại
    static function get_child_categories_info_of_current_category() {
        if (is_product_category()) {
            $current_category_id = get_queried_object_id();

            // Lấy danh sách các danh mục con của danh mục hiện tại
            $child_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'child_of' => $current_category_id,
            ));

            // Kiểm tra nếu có danh mục con
            if (!empty($child_categories)) {
                $categories_info = array();

                // Lặp qua danh sách và lấy thông tin của từng danh mục con
                foreach ($child_categories as $child_category) {
                    $category_info = array(
                        'id' => $child_category->term_id,
                        'name' => $child_category->name,
                        'slug' => $child_category->slug,
                        'permalink' => get_term_link($child_category),
                    );
                    $categories_info[] = $category_info;
                }

                return $categories_info;
            }
        }

        // Trả về null nếu không phải trang archive danh mục sản phẩm
        return null;
    }


    // Lấy danh sách chuyên mục cùng cấp danh mục sản phẩm hiện tại
    static function get_child_categories_of_parent($product_id, $limit = 10) {

        // Lấy danh mục của sản phẩm hiện tại (sản phẩm đang xem)
        $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));

        if (!empty($product_categories)) {

            // Lấy các danh mục cha của danh mục đầu tiên trong danh sách
            $parent_category_id = wp_get_term_taxonomy_parent_id($product_categories[0], 'product_cat');

            $parent_category_ids = array();
            foreach ($product_categories as $product_cat) {
                $parent_category_ids[] = wp_get_term_taxonomy_parent_id($product_cat, 'product_cat');
            }

            // Sử dụng vòng lặp để lọc bỏ tất cả các phần tử có giá trị 0
            $arr_without_zeros = array_filter($parent_category_ids, function ($value) {
                return $value != 0;
            });
            $parent_category_ids = $arr_without_zeros;

            $result = array();
            if ($parent_category_ids) :

                foreach ($parent_category_ids as $parent_id) {
                    # code... lấy con
                    $child_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'child_of' => $parent_id,
                        'number' => $limit, // Số lượng danh mục con tối đa (sử dụng tham số)
                    ));

                    foreach ($child_categories as $category) {
                        $category_info = array(
                            'id' => $category->term_id,
                            'permalink' => get_term_link($category),
                            'name' => $category->name,
                        );
                        $result[] = $category_info;
                    }
                }
            endif;

            return $result;
        }

        return array(); // Trả về mảng trống nếu không tìm thấy danh mục nào.
    }

    // Lấy danh sách hình ảnh của sản phẩm
    static public function get_product_images($product_id) {
        $product_images = array();

        // Lấy danh sách hình ảnh đính kèm của sản phẩm
        $product_gallery = get_post_meta($product_id, '_product_image_gallery', true);

        // Chuyển đổi chuỗi danh sách thành mảng
        if (!empty($product_gallery)) {
            $product_image_ids = explode(',', $product_gallery);

            // Lặp qua danh sách ID hình ảnh và lấy URL của hình ảnh
            foreach ($product_image_ids as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full'); // Đối số 'full' là kích thước hình ảnh cần lấy
                if ($image_url) {
                    $product_images[] = $image_url;
                }
            }
        }

        return $product_images;
    }

    // Lấy số lượng sản phẩm đã bán của sản phẩm
    static function shop_product_sold_count() {
        $units_sold = get_post_meta(get_the_ID(), 'total_sales', true);
        return $units_sold;
    }
}
