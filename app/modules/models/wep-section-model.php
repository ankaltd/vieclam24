<?php

/** 
 * Class for one Section Model
 */

class WEP_Section_Model {
    private $section_template;
    private $section_data;

    public function __construct() {
        // code here
    }


    // Get list post related by category current
    static function get_related_posts_by_category($post_id, $number_of_posts = 5) {
        $post_categories = wp_get_post_categories($post_id);

        if (empty($post_categories)) {
            return array(); // Trả về mảng rỗng nếu bài viết không có chuyên mục nào.
        }

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'post__not_in' => array($post_id),
            'category__in' => $post_categories,
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $number_of_posts,
        );

        $related_posts = get_posts($args);

        $result = array();

        foreach ($related_posts as $post) {
            setup_postdata($post);

            $thumbnail_url = get_the_post_thumbnail_url($post, 'wep_thumb_news');

            $post_data = array(
                'title' => get_the_title($post),
                'id' => $post->ID,
                'thumbnail_url' => $thumbnail_url,
                'excerpt' => get_the_excerpt($post),
                'permalink' => get_permalink($post),
                'date' => get_the_date('d.m.Y', $post), // Định dạng ngày: ngày.tháng.năm
            );

            $result[] = $post_data;
        }

        wp_reset_postdata();

        return $result;
    }

    // Get lastest News
    static function get_latest_posts($post_count = -1, $category_ids, $thumbnail_size = 'wep_thumb_news') {
        $result = array();

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $post_count,
            'category__in' => $category_ids,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_thumbnail = get_the_post_thumbnail_url($post_id, $thumbnail_size);
                $post_slug = get_post_field('post_name', $post_id);
                $post_permalink = get_permalink($post_id);
                $post_excerpt = get_the_excerpt();
                $post_categories = get_the_category();
                $post_category_names = array();
                $post_category_links = array();

                foreach ($post_categories as $category) {
                    $post_category_names[] = $category->name;
                    $post_category_links[] = get_category_link($category->term_id);
                }

                if (pll_current_language() == 'vi') {
                    $post_date = get_the_date();
                } else {
                    $post_date = date('F d, Y', strtotime(get_the_date()));
                }



                $post_info = array(
                    'id' => $post_id,
                    'title' => $post_title,
                    'thumbnail' => $post_thumbnail,
                    'slug' => $post_slug,
                    'permalink' => $post_permalink,
                    'excerpt' => $post_excerpt,
                    'categories' => $post_category_names,
                    'category_links' => $post_category_links,
                    'date' => $post_date
                );

                $result[] = $post_info;
            }
        }

        wp_reset_postdata();

        return $result;
    }

    // Get list news from selected options
    static function get_list_posts($posts, $thumbnail_size = 'wep_thumb_news') {
        $result = array();

        foreach ($posts as $post) {
            $post_id = $post->ID;
            $post_title = $post->post_title;
            $post_thumbnail = get_the_post_thumbnail_url($post_id, $thumbnail_size);
            $post_slug = $post->post_name;
            $post_permalink = get_permalink($post_id);
            $post_excerpt = get_the_excerpt($post_id);
            $post_categories = get_the_category($post_id);
            $post_category_names = array();
            $post_category_links = array();

            foreach ($post_categories as $category) {
                $post_category_names[] = $category->name;
                $post_category_links[] = get_category_link($category->term_id);
            }


            if (pll_current_language() == 'vi') {
                $post_date = $post->post_date;
            } else {
                $post_date = date('F d, Y', strtotime($post->post_date));
            }

            $post_info = array(
                'id' => $post_id,
                'title' => $post_title,
                'thumbnail' => $post_thumbnail,
                'slug' => $post_slug,
                'permalink' => $post_permalink,
                'excerpt' => $post_excerpt,
                'categories' => $post_category_names,
                'category_links' => $post_category_links,
                'date' => $post_date
            );

            $result[] = $post_info;
        }

        return $result;
    }

    // Get list custom taxonomy
    static function get_list_terms($taxname = 'industry') {
        $args = array(
            'taxonomy'   => $taxname,
            'hide_empty' => false,
            'orderby'    => 'menu_order',
            'order'      => 'ASC'
        );

        $terms = get_terms($args);

        $result = array();

        foreach ($terms as $term) {
            $result[] = array(
                'id'          => $term->term_id,
                'title'       => $term->name,
                'slug'        => $term->slug,
                'permalink'   => get_term_link($term),
                'description' => $term->description
            );
        }

        return $result;
    }

    // Get list client
    static function get_list_client_by_industry($number_item = -1, $industry_id = 0, $sort_order = 'asc', $thumbnail = 'wep_thumb_solution') {

        $args = array(
            'post_type'      => 'client', // Thay 'client' bằng tên post type của bạn
            'posts_per_page' => $number_item,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'industry',
                    'field'    => 'term_id',
                    'terms'    => $industry_id
                )
            )
        );

        $posts_array = array();
        $posts = get_posts($args);

        if ($posts) {
            foreach ($posts as $post) {
                setup_postdata($post);

                $post_id = $post->ID;
                $post_title = $post->post_title;
                $post_thumbnail = get_the_post_thumbnail_url($post_id, $thumbnail);
                $post_permalink = get_permalink($post_id);
                $post_except = get_the_excerpt($post_id);
                $post_client_link = get_field('client_goto_link', $post_id);
                $post_client_image = get_field('client_content_image', $post_id);
                $post_client_detail = get_field('client_service_detail', $post_id);
                $post_client_solutions = get_field('client_solutions', $post_id);
                $post_client_services = get_field('client_services', $post_id);

                $post_data = array(
                    'id' => $post->ID,
                    'title' => $post_title,
                    'thumbnail' => $post_thumbnail,
                    'permalink' => $post_permalink,
                    'excerpt' => $post_except,
                    'link' => $post_client_link,
                    'photo' => $post_client_image,
                    'detail' => $post_client_detail,
                    'solutions' => $post_client_solutions,
                    'services' => $post_client_services,
                );

                $posts_array[] = $post_data;
            }

            wp_reset_postdata();
        }

        // Trả về mảng tiêu đề và ID
        return $posts_array;
    }

    // Get list hr
    static function get_list_hiring($number_item = -1, $sort_order = 'asc', $thumbnail = 'thumbnail') {

        $args = array(
            'post_type'         => 'hiring',
            'post_status'       => 'publish',
            'orderby'           => 'date',
            'order'             => $sort_order,
            'posts_per_page'    => $number_item,
        );

        $posts_array = array();
        $posts = get_posts($args);

        if ($posts) {
            foreach ($posts as $post) {
                setup_postdata($post);

                // Lấy thông tin tiêu đề và nội dung
                $post_id = $post->ID;
                $post_title = $post->post_title;
                $post_thumbnail = get_the_post_thumbnail_url($post_id, $thumbnail);
                $post_permalink = get_permalink($post_id);
                $post_except = get_the_excerpt($post_id);

                // Lấy thông tin các taxonomy (hiring_position và location)
                $hiring_position = get_the_terms($post_id, 'hiring_position');
                $hirring_location = get_the_terms($post_id, 'location');

                // Lấy thông tin các giá trị trường ACF
                $hiring_salary = get_field('hiring_salary', $post_id);
                $hiring_deadline = get_field('hiring_deadline', $post_id);
                $hiring_workform = get_field('hiring_workform', $post_id);
                $hiring_workform_description = get_field('hiring_workform_description', $post_id);
                $hiring_workform_requirment = get_field('hiring_workform_requirment', $post_id);
                $hiring_workform_benefit = get_field('hiring_workform_benefit', $post_id);

                // Kết hợp
                $post_data = array(
                    'id' => $post->ID,
                    'title' => $post_title,
                    'thumbnail' => $post_thumbnail,
                    'permalink' => $post_permalink,
                    'excerpt' => $post_except,
                    'hiring_position' => $hiring_position[0]->name,
                    'hirring_location' => $hirring_location[0]->name,
                    'hiring_salary' => $hiring_salary,
                    'hiring_deadline' => $hiring_deadline,
                    'hiring_workform' => $hiring_workform,
                    'hiring_workform_description' => $hiring_workform_description,
                    'hiring_workform_requirment' => $hiring_workform_requirment,
                    'hiring_workform_benefit' => $hiring_workform_benefit,
                );

                $posts_array[] = $post_data;
            }

            wp_reset_postdata();
        }

        // Trả về mảng tiêu đề và ID
        return $posts_array;
    }


    // Get list service
    static function get_list_service($number_item = -1, $sort_order = 'asc', $thumbnail = 'wep_thumb_service') {

        $args = array(
            'post_type'         => 'service',
            'post_status'       => 'publish',
            'orderby'           => 'menu_order',
            'order'             => $sort_order,
            'posts_per_page'    => $number_item,
        );

        $posts_array = array();
        $posts = get_posts($args);

        if ($posts) {
            foreach ($posts as $post) {
                setup_postdata($post);

                $post_id = $post->ID;
                $post_title = $post->post_title;
                $post_thumbnail = get_the_post_thumbnail_url($post_id, $thumbnail);
                $post_permalink = get_permalink($post_id);
                $post_except = get_the_excerpt($post_id);

                $post_data = array(
                    'id' => $post->ID,
                    'title' => $post_title,
                    'thumbnail' => $post_thumbnail,
                    'permalink' => $post_permalink,
                    'excerpt' => $post_except,
                );

                $posts_array[] = $post_data;
            }

            wp_reset_postdata();
        }

        // Trả về mảng tiêu đề và ID
        return $posts_array;
    }

    // Get list solution
    static function get_list_solution($number_item = -1, $sort_order = 'asc', $thumbnail = 'wep_thumb_solution') {

        $args = array(
            'post_type'         => 'solution',
            'post_status'       => 'publish',
            'orderby'           => 'menu_order',
            'order'             => $sort_order,
            'posts_per_page'    => $number_item,
        );

        $posts_array = array();
        $posts = get_posts($args);

        if ($posts) {
            foreach ($posts as $post) {
                setup_postdata($post);

                $post_id = $post->ID;
                $post_title = $post->post_title;
                $post_thumbnail = get_the_post_thumbnail_url($post_id, $thumbnail);
                $post_permalink = get_permalink($post_id);
                $post_except = get_the_excerpt($post_id);

                $post_data = array(
                    'id' => $post->ID,
                    'title' => $post_title,
                    'thumbnail' => $post_thumbnail,
                    'permalink' => $post_permalink,
                    'excerpt' => $post_except,
                );

                $posts_array[] = $post_data;
            }

            wp_reset_postdata();
        }

        // Trả về mảng tiêu đề và ID
        return $posts_array;
    }


    // Get list posts by type
    static function get_list_post($post_type = 'post') {

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $posts_array = array();

        $posts = get_posts($args);

        if ($posts) {
            foreach ($posts as $post) {
                $post_id = $post->ID;
                $post_title = $post->post_title;
                $posts_array[] = array(
                    'ID' => $post_id,
                    'title' => $post_title,
                );
            }
        }

        // Trả về mảng tiêu đề và ID
        return $posts_array;
    }

    // Get term by ID
    public function get_tax_name($tax_slug, $tax_id) {

        // ID của taxonomy cần lấy tên
        $taxonomy_id = $tax_id;

        // Lấy term object dựa trên ID
        $term = get_term_by('term_id', $taxonomy_id, $tax_slug); // Thay 'your_taxonomy_slug' bằng slug của taxonomy bạn đang làm việc

        // Kiểm tra và hiển thị tên của term
        if ($term) {
            $term_name = $term->name;
            return $term_name;
        } else {
            return false;
        }
    }

    // Checked have children
    public function tax_have_chidren($tax_slug = 'feature', $tax_id) {

        // ID của taxonomy cần kiểm tra
        $taxonomy_id = $tax_id;

        // Kiểm tra xem có term con hay không
        $child_terms = get_term_children($taxonomy_id, $tax_slug); // Thay 'your_taxonomy_slug' bằng slug của taxonomy bạn đang làm việc

        if (!empty($child_terms)) {
            // Có term con
            return true;
        } else {
            // Không có term con
            return false;
        }
    }

    // Get full list taxonomy children by id
    public function get_children_tax($tax_slug = 'feature', $tax_id) {

        $result = [];

        // Tham số để lấy danh sách taxonomy con     
        $termchildren = get_term_children($tax_id, $tax_slug);

        foreach ($termchildren as $child) {
            $term = get_term_by('id', $child, $tax_slug);
            $result[] = $term->name;
        }

        // Lấy danh sách các taxonomy con
        return $result;
    }

    // Search posts by key s
    static function searchPosts($post_per_page = 6) {
        $keyword = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        $postsPerPage = $post_per_page;
        $currentPage = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $queryArgs = array(
            's' => $keyword,
            'post_type' => 'post', // Chỉ lấy các bài viết (không bao gồm trang)
            'posts_per_page' => $postsPerPage,
            'paged' => $currentPage,
            'order' => 'DESC',
            'orderby' => 'date'
        );

        $query = new WP_Query($queryArgs);

        $results = array(
            'totalResults' => $query->found_posts,
            'keyword' => $keyword,
            'posts' => array()
        );

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wep_thumb_news');
                $thumbnailUrl = $thumbnail ? $thumbnail[0] : ''; // Lấy URL của thumbnail với kích thước wep_thumb_news                
                $date = get_the_date('d/m/Y');

                // Loại bỏ phần "Continue Reading" trong phần tóm tắt
                $excerpt = get_the_excerpt();
                $excerpt = preg_replace('/<a\s+class="more-link"[^>]*>.*?<\/a>/i', '', $excerpt);

                $results['posts'][] = array(
                    'title' => get_the_title(),
                    'thumbnailUrl' => $thumbnailUrl,
                    'permalink' => get_permalink(),
                    'date' => $date,
                    'excerpt' => $excerpt
                );
            }

            wp_reset_postdata();
        }

        // Bổ sung phần thanh điều hướng (pagination)
        $pagination = paginate_links(array(
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => max(1, $currentPage),
            'total' => $query->max_num_pages,
            'prev_text' => '&laquo; Trước',
            'next_text' => 'Tiếp &raquo;',
            'type' => 'array',
        ));


        // Bổ sung đường dẫn tương ứng vào các thẻ a chuyển trang
        $results['pagination'] = '';

        if (!is_null($pagination)) {
            $results['pagination'] = '<nav aria-label="Page navigation"><ul class="pagination wep_page_nav">';
            $stt_page = 0;
            foreach ($pagination as $link) {
                $stt_page++;
                $currentPageClass = ($currentPage === $stt_page) ? 'current_page' : '';
                $results['pagination'] .= '<li class="page-item ' . $currentPageClass . '">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            }
            $results['pagination'] .= '</ul></nav>';
        }

        return $results;
    }

    // Category posts by category
    static function categoryPosts($post_per_page = 6, $cat_id = false) {

        if ($cat_id) {
            $category_id = $cat_id; // Lấy ID đầu vào   
        } else {
            $category_id = get_queried_object_id(); // Lấy ID của chuyên mục hiện tại
        }

        $currentPage = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $queryArgs = array(
            'post_type' => 'post', // Chỉ lấy các bài viết (không bao gồm trang)
            'posts_per_page' => $post_per_page,
            'paged' => $currentPage,
            'order' => 'DESC',
            'orderby' => 'date',
            'cat' => $category_id, // Chỉ lấy bài viết trong chuyên mục hiện tại
        );

        $query = new WP_Query($queryArgs);

        $results = array(
            'totalResults' => $query->found_posts,
            'posts' => array(),
        );

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wep_thumb_news');
                $thumbnailUrl = $thumbnail ? $thumbnail[0] : ''; // Lấy URL của thumbnail với kích thước wep_thumb_news
                $date = get_the_date('d/m/Y'); // Định dạng ngày: day/month/year

                // Loại bỏ phần "Continue Reading" trong phần tóm tắt
                $excerpt = get_the_excerpt();
                $excerpt = preg_replace('/<a\s+class="more-link"[^>]*>.*?<\/a>/i', '', $excerpt);

                $results['posts'][] = array(
                    'title' => get_the_title(),
                    'url' => get_permalink(),
                    'thumbnailUrl' => $thumbnailUrl,
                    'permalink' => get_permalink(),
                    'date' => $date,
                    'excerpt' => $excerpt
                );
            }

            wp_reset_postdata();
        }

        $category_name = get_cat_name($category_id); // Lấy tên chuyên mục từ ID của chuyên mục
        $results['category_name'] = $category_name;

        // Bổ sung phần thanh điều hướng (pagination)
        $pagination = paginate_links(array(
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => max(1, $currentPage),
            'total' => $query->max_num_pages,
            'prev_text' => '&laquo; Trước',
            'next_text' => 'Tiếp &raquo;',
            'type' => 'array',
        ));

        // Bổ sung đường dẫn tương ứng vào các thẻ a chuyển trang
        $results['pagination'] = '';

        if (!is_null($pagination)) {
            $results['pagination'] = '<nav aria-label="Page navigation"><ul class="pagination wep_page_nav">';
            $stt_page = 0;
            foreach ($pagination as $link) {
                $stt_page++;
                $currentPageClass = ($currentPage === $stt_page) ? 'current_page' : '';
                $results['pagination'] .= '<li class="page-item ' . $currentPageClass . '">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            }
            $results['pagination'] .= '</ul></nav>';
        }

        return $results;
    }

    // Gán template cho section
    public function set_template($template_name) {
        $this->section_template = $template_name;
    }

    // Gán data cho section
    public function set_data($input_data) {
        $this->section_data = $input_data;
    }

    // Lấy template của section
    public function get_template() {
        return $this->section_template;
    }

    // Lấy giá trị của section
    public function get_data() {
        return $this->section_data;
    }
}
