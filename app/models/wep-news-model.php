<?php

/**
 * Lớp WEP_News_Model quản lý dữ liệu liên quan đến tin tức.
 */

class WEP_News_Model {

    /**
     * Constructor của lớp WEP_News_Model.
     * Khởi tạo các sự kiện lắng nghe khi tạo một đối tượng WEP_News_Model mới.
     */
    public function __construct() {
        add_filter('post_class', [$this, 'news_post_classes'], 10, 3);
        add_filter('the_content', [$this, 'add_anchor_id_to_headings']);
        add_action('wp_head', [$this, 'update_post_views_count']);
    }

    /* Lấy nội dung chuyên mục hiện tại */
    public static function get_news_by_current_category($page = 1, $per_page = 10) {
        if (is_category()) {
            $category = get_queried_object();
            $category_slug = $category->slug;

            $paged = ($page) ? $page : 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $per_page,
                'paged' => $paged,
                'category_name' => $category_slug
            );

            $query = new WP_Query($args);
            $news_list = array();

            while ($query->have_posts()) : $query->the_post();
                $news_item = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'thumbnail' => get_the_post_thumbnail_url(),
                    'permalink' => get_permalink(),
                    'date' => get_the_date('d/m/Y'),
                    'category_name' => get_the_category()[0]->cat_name,
                    'category_permalink' => get_category_link(get_the_category()[0]->term_id),
                    'summary' => get_the_excerpt()
                );

                array_push($news_list, $news_item);
            endwhile;

            wp_reset_postdata();

            return $news_list;
        }

        return null;
    }


    /* Lấy bài viết theo chuyên mục slug */
    public static function get_news_by_category($category_slug, $page = 1, $per_page = 10) {
        $paged = ($page) ? $page : 1;
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $per_page,
            'paged' => $paged,
            'category_name' => $category_slug
        );

        $query = new WP_Query($args);
        $news_list = array();

        while ($query->have_posts()) : $query->the_post();
            $news_item = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'thumbnail' => get_the_post_thumbnail_url(),
                'permalink' => get_permalink(),
                'date' => get_the_date('d/m/Y'),
                'category_name' => get_the_category()[0]->cat_name,
                'category_permalink' => get_category_link(get_the_category()[0]->term_id),
                'summary' => get_the_excerpt()
            );

            array_push($news_list, $news_item);
        endwhile;

        wp_reset_postdata();

        return $news_list;
    }


    /* Get featured news */
    static function get_featured_news($get_news_type, $selection_ids, $category_id, $number) {
        $featured_news = array();

        if ($get_news_type === 'selection') {
            // Lấy danh sách bài viết dựa trên ID của bài viết kiểu selection
            $selection_posts = get_posts(array(
                'post_type' => 'post', // Đổi thành loại post cụ thể của bạn nếu cần
                'post__in' => $selection_ids,
                'orderby' => 'post__in',
                'order' => 'ASC'
            ));

            foreach ($selection_posts as $post) {
                $post_data = array(
                    'thumbnail' => get_the_post_thumbnail_url($post),
                    'title' => get_the_title($post),
                    'permalink' => get_permalink($post),
                    'date' => get_the_date('F j, Y', $post),
                );

                // Lấy danh sách các category của bài viết
                $categories = get_the_category($post->ID);
                if (!empty($categories)) {
                    $category = $categories[0]; // Lấy category đầu tiên (có thể thay đổi nếu cần)
                    $post_data['category_name'] = $category->name;
                    $post_data['category_permalink'] = get_category_link($category->term_id);
                }

                $featured_news[] = $post_data;
            }
        } else {
            // Lấy danh sách bài viết mới nhất từ kiểu category
            $category_posts = get_posts(array(
                'post_type' => 'post', // Đổi thành loại post cụ thể của bạn nếu cần
                'category' => $category_id,
                'numberposts' => $number,
            ));

            foreach ($category_posts as $post) {
                $post_data = array(
                    'thumbnail' => get_the_post_thumbnail_url($post),
                    'title' => get_the_title($post),
                    'permalink' => get_permalink($post),
                    'date' => get_the_date('F j, Y', $post),
                );

                // Lấy danh sách các category của bài viết
                $categories = get_the_category($post->ID);
                if (!empty($categories)) {
                    $category = $categories[0]; // Lấy category đầu tiên (có thể thay đổi nếu cần)
                    $post_data['category_name'] = $category->name;
                    $post_data['category_permalink'] = get_category_link($category->term_id);
                }

                $featured_news[] = $post_data;
            }
        }

        return $featured_news;
    }

    /**
     * Cập nhật số lượt xem của bài viết.
     */
    function update_post_views_count() {
        if (is_single()) {
            $post_id = get_the_ID();
            $views_count = get_post_meta($post_id, 'post_views_count', true);
            $views_count = (empty($views_count)) ? 1 : (int) $views_count + 1;
            update_post_meta($post_id, 'post_views_count', $views_count);
        }
    }

    // Get most view post
    static function get_popular_posts($number_news = 5) {
        // Truy vấn danh sách bài viết được xem nhiều nhất
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_news,
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );

        $popular_query = new WP_Query($args);

        // Mảng lưu trữ thông tin bài viết được xem nhiều nhất
        $popular_posts = array();

        if ($popular_query->have_posts()) {
            while ($popular_query->have_posts()) {
                $popular_query->the_post();

                // Lấy thông tin bài viết được xem nhiều nhất
                $popular_item = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID()),
                    'date' => get_the_date(),
                    'permalink' => get_permalink(),
                );

                // Thêm bài viết vào mảng
                $popular_posts[] = $popular_item;
            }
        }

        // Đặt lại dữ liệu bài viết
        wp_reset_postdata();

        return $popular_posts;
    }

    /**
     * Thêm class CSS cho bài viết.
     */
    public function news_post_classes($classes) {
        $classes[] = 'dbiz-news-single-wrapper';

        return $classes;
    }

    /**
     * Tạo mục lục cho bài viết.
     */
    static function generate_toc($top_level_class = 'wep_news_single_entry__toc_list', $sec_level_class = 'wep_news_single_entry__toc_sub', $third_level_class = 'wep_news_single_entry__toc_sub_sub', $item_class = 'wep_news_single_entry__toc_item') {

        global $post;

        if (isset($post) && is_object($post)) :

            $content = $post->post_content;

            // Kiểm tra nếu nội dung không rỗng
            if (!empty($content)) {

                $headings = array();

                // Tìm tất cả các thẻ h2, h3, h4 trong nội dung
                preg_match_all('/<(h[2-4])[^>]*>(.*?)<\/\1>/', $content, $headings, PREG_SET_ORDER);

                // Sử dụng preg_match_all để tìm các thẻ h2 đến h6 trong nội dung
                // preg_match_all('/<h([2-6])[^>]*>.*?<\/h\\1>/i', $content, $matches, PREG_SET_ORDER);

                // $matches[0] chứa toàn bộ chuỗi thẻ h2-h6
                // $matches[1] chứa số thứ tự của thẻ (2-6)

                // var_dump($headings);


                // Kiểm tra nếu có các thẻ tiêu đề
                if (!empty($headings)) {

                    $toc_items = array(); // Mảng chứa thông tin mục lục

                    // Duyệt qua từng thẻ tiêu đề
                    foreach ($headings as $heading) {
                        $tag = $heading[1]; // Thẻ tiêu đề (h2, h3, h4)
                        $title = $heading[2]; // Tiêu đề

                        // Tạo id từ tiêu đề bằng cách loại bỏ ký tự không hợp lệ và thay thế khoảng trắng bằng dấu gạch ngang
                        $id = sanitize_title_with_dashes($title);

                        // Tạo mục lục cho thẻ tiêu đề
                        $toc_item = array(
                            'tag' => $tag,
                            'title' => $title,
                            'id' => $id,
                        );

                        // Thêm mục lục vào danh sách
                        $toc_items[] = $toc_item;
                    }

                    // Kiểm tra nếu có mục lục
                    if (!empty($toc_items)) {
                        echo '<ol class="' . $top_level_class . '">'; // Bắt đầu danh sách phân cấp

                        $current_heading_level = 2; // Mức độ của thẻ tiêu đề hiện tại

                        // Duyệt qua từng mục lục
                        foreach ($toc_items as $toc_item) {
                            $heading_level = intval(substr($toc_item['tag'], 1)); // Mức độ của thẻ tiêu đề

                            // Kiểm tra mức độ của thẻ tiêu đề để đóng/mở các thẻ danh sách phân cấp tương ứng
                            if ($heading_level > $current_heading_level) {
                                echo '<ol class="' . $sec_level_class . '">'; // Mở danh sách phân cấp mới
                            } elseif ($heading_level < $current_heading_level) {
                                echo str_repeat('</li></ol>', $current_heading_level - $heading_level); // Đóng danh sách phân cấp trước đó
                            } else {
                                echo '</li>'; // Đóng mục trước đó
                            }

                            // Hiển thị mục lục
                            echo '<li><a href="#' . $toc_item['id'] . '">' . $toc_item['title'] . '</a>';

                            $current_heading_level = $heading_level; // Cập nhật mức độ của thẻ tiêu đề hiện tại
                        }

                        echo str_repeat('</li></ol>', $current_heading_level - 2); // Đóng danh sách phân cấp cuối cùng
                        echo '</ol>'; // Đóng danh sách phân cấp chính
                    }
                }
            }

        endif;
    }


    /**
     * Thêm id vào các thẻ tiêu đề trong nội dung bài viết.
     */
    function add_anchor_id_to_headings($content) {

        // Kiểm tra nếu đang hiển thị bài viết và nội dung không rỗng
        if (is_single() && !empty($content)) {
            // Tìm tất cả các thẻ h2, h3, h4 trong nội dung
            preg_match_all('/<(h[2-4])[^>]*>(.*?)<\/\1>/', $content, $headings, PREG_SET_ORDER);

            // Duyệt qua từng thẻ tiêu đề
            foreach ($headings as $heading) {
                $tag = $heading[1]; // Thẻ tiêu đề (h2, h3, h4)
                $title = $heading[2]; // Tiêu đề

                // Tạo id từ tiêu đề bằng cách loại bỏ ký tự không hợp lệ và thay thế khoảng trắng bằng dấu gạch ngang
                $id = sanitize_title_with_dashes($title);

                // Thêm id vào thẻ tiêu đề
                $modified_heading = '<' . $tag . ' id="' . $id . '">' . $title . '</' . $tag . '>';

                // Thay thế thẻ tiêu đề gốc trong nội dung với thẻ đã được thêm id
                $content = str_replace($heading[0], $modified_heading, $content);
            }
        }

        return $content;
    }


    // Get current ID
    public function get_news_id() {
        return 'news-' . get_the_ID();
    }

    // Get summary 
    public function get_the_summary($post_id) {
        global $post;
        $save_post = $post;
        $post = get_post($post_id);
        $output = get_the_excerpt();
        $output = str_replace('Continue reading', '', $output);
        $post = $save_post;
        return $output;
    }

    // Get post current ID
    public function get_single_post_data() {

        // Lấy thông tin của post hiện tại
        $post_id = get_the_ID();
        $post_title = get_the_title($post_id);
        $post_content = get_the_content($post_id);
        $post_content = apply_filters('the_content', $post_content); // keep <p> </p> tag

        $post_thumbnail = get_the_post_thumbnail_url($post_id, 'large');;
        $post_summary = $this->get_the_summary($post_id);
        $post_date = get_the_date('Y-m-d', $post_id);

        // Tạo một mảng chứa thông tin post
        $post_data = array(
            'title' => $post_title,
            'content' => $post_content,
            'thumbnail' => $post_thumbnail,
            'summary' => $post_summary,
            'date' => $post_date,
        );

        return $post_data;
    }

    // Get news current category
    static function get_news_current_category() {

        // Lấy ID chuyên mục hiện tại
        $current_category_id = get_queried_object_id();

        // Truy vấn danh sách tin trong chuyên mục hiện tại
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 100,
            'category__in' => array($current_category_id),
        );

        $news_query = new WP_Query($args);

        // Mảng lưu trữ thông tin tin tức
        $list_news = array();

        if ($news_query->have_posts()) {
            while ($news_query->have_posts()) {
                $news_query->the_post();

                // Lấy thông tin tin tức
                $news_item = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID()),
                    'date' => get_the_date(),
                    'permalink' => get_permalink(),
                );

                // Thêm tin tức vào mảng
                $list_news[] = $news_item;
            }
        }

        // Đặt lại dữ liệu bài viết
        wp_reset_postdata();

        return $list_news;
    }

    /* Lấy chuyên mục cùng chuyên mục tin hiện tại */
    static function get_sibling_categories($limit = -1, $current_category_id = null) {
        $category_list = array();

        if ($current_category_id === null) {
            $current_category = get_queried_object();

            if (is_category() && $current_category) {
                $current_category_id = $current_category->term_id;
            } elseif (is_single()) {
                $categories = get_the_category();

                if (!empty($categories)) {
                    $current_category_id = $categories[0]->term_id;
                }
            }
        }

        if ($current_category_id && ($current_category_id != 0)) {
            $parent_category = get_term($current_category_id, 'category');
            $parent_category_id = $parent_category->parent;

            if ($parent_category_id) {

                // Lấy danh sách chuyên mục con của chuyên mục cha
                $child_categories = get_categories(array(
                    'child_of' => $parent_category_id,
                    'exclude' => $current_category_id,
                    'number' => $limit,
                ));

                foreach ($child_categories as $category) {
                    $category_list[] = array(
                        'name' => $category->name,
                        'permalink' => get_category_link($category->term_id),
                    );
                }
            } else {

                // Nếu không có chuyên mục cha, lấy danh sách chuyên mục gốc loại trừ chuyên mục hiện tại
                $args = array(
                    'exclude' => $current_category_id, // Loại trừ chuyên mục có ID là $current_category_id
                );

                $categories = get_categories($args);

                $stt = 0;
                foreach ($categories as $category) {
                    if ($limit > -1) :
                        if ($stt <= $limit) :
                            $category_list[$stt] = array(
                                'name' => $category->name,
                                'permalink' => get_category_link($category->term_id),
                            );
                        endif;
                        $stt++;

                    else : {
                            $category_list[] = array(
                                'name' => $category->name,
                                'permalink' => get_category_link($category->term_id),
                            );
                        }
                    endif;
                }
            }
        }

        return $category_list;
    }

    /* Get posts same category */
    static function get_same_category_posts($number = 10) {
        global $post;

        // Lấy chuyên mục của bài viết hiện tại
        $categories = get_the_category($post->ID);

        if (empty($categories)) {
            return array(); // Không có chuyên mục, trả về mảng rỗng.
        }

        $cat_id = $categories[0]->term_id;

        // Tạo truy vấn để lấy bài viết cùng chuyên mục
        $args = array(
            'category' => $cat_id,
            'post__not_in' => array($post->ID),
            'posts_per_page' => $number,
        );

        $related_posts_query = new WP_Query($args);

        $related_posts = array();

        if ($related_posts_query->have_posts()) {
            while ($related_posts_query->have_posts()) {
                $related_posts_query->the_post();

                $related_posts[] = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail_url' => get_the_post_thumbnail_url(),
                    'permalink' => get_permalink(),
                );
            }

            wp_reset_postdata(); // Đảm bảo là không ảnh hưởng đến truy vấn chính.
        }

        return $related_posts;
    }


    static function get_adjacent_posts_in_same_category($post_id) {
        $categories = get_the_category($post_id);
        if (!empty($categories)) {
            $category_ids = array_map(function ($category) {
                return $category->term_id;
            }, $categories);

            $previous_posts = get_posts([
                'category__in' => $category_ids,
                'date_query' => ['before' => get_post($post_id)->post_date],
                'posts_per_page' => 2,
                'order' => 'DESC'
            ]);

            $next_posts = get_posts([
                'category__in' => $category_ids,
                'date_query' => ['after' => get_post($post_id)->post_date],
                'posts_per_page' => 2,
                'order' => 'ASC'
            ]);

            $adjacent_posts = [];

            foreach ($previous_posts as $post) {
                setup_postdata($post);
                $adjacent_posts[] = [
                    'title' => get_the_title($post),
                    'excerpt' => get_the_excerpt($post),
                    'thumbnail_url' => get_the_post_thumbnail_url($post),
                    'permalink' => get_permalink($post)
                ];
            }

            foreach ($next_posts as $post) {
                setup_postdata($post);
                $adjacent_posts[] = [
                    'title' => get_the_title($post),
                    'excerpt' => get_the_excerpt($post),
                    'thumbnail_url' => get_the_post_thumbnail_url($post),
                    'permalink' => get_permalink($post)
                ];
            }

            return $adjacent_posts;
        }

        return null;
    }


    function format_post($post) {
        setup_postdata($post);

        return [
            'title' => get_the_title($post),
            'excerpt' => get_the_excerpt($post),
            'thumbnail_url' => get_the_post_thumbnail_url($post),
            'permalink' => get_permalink($post),
            'category_name' => get_the_category_list(', ', '', $post->ID),
            'category_permalink' => esc_url(get_category_link(get_the_category($post->ID)[0]->term_id))
        ];
    }


    /**
     * Phương thức để lấy thông tin bài viết và chuyên mục.
     *
     * @param int $post_id ID của bài viết (tùy chọn, mặc định là bài viết hiện tại).
     * @param int $before Số lượng bài viết trước cần lấy.
     * @param int $after Số lượng bài viết sau cần lấy.
     *
     * @return array Mảng chứa thông tin của bài viết và chuyên mục.
     */
    static function get_posts_before_and_after() {
        global $post;

        // Lấy ID của bài viết hiện tại
        $current_post_id = $post->ID;

        // Lấy chuyên mục của bài viết hiện tại
        $categories = get_the_category($current_post_id);
        if (empty($categories)) {
            return array();
        }
        $cat_id = $categories[0]->term_id;

        // Lấy 2 bài viết cùng chuyên mục có ID nhỏ hơn
        $args_before = array(
            'category' => $cat_id,
            'post__not_in' => array($current_post_id),
            'posts_per_page' => 2,
            'order' => 'ASC',
            'orderby' => 'ID',
        );
        $query_before = new WP_Query($args_before);

        // Lấy 2 bài viết cùng chuyên mục có ID lớn hơn
        $args_after = array(
            'category' => $cat_id,
            'post__not_in' => array($current_post_id),
            'posts_per_page' => 2,
            'order' => 'DESC',
            'orderby' => 'ID',
        );
        $query_after = new WP_Query($args_after);

        $related_posts = array();

        if ($query_before->have_posts()) {
            while ($query_before->have_posts()) {
                $query_before->the_post();
                $related_posts[] = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail_url' => get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : THEME_IMG . '/no-thumbnail.jpg',
                    'permalink' => get_permalink(),
                    'category_name' => $categories[0]->name,
                    'category_permalink' => get_category_link($cat_id),
                );
            }
        }

        if ($query_after->have_posts()) {
            while ($query_after->have_posts()) {
                $query_after->the_post();
                $related_posts[] = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail_url' => get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : THEME_IMG . '/no-thumbnail.jpg',
                    'permalink' => get_permalink(),
                    'category_name' => $categories[0]->name,
                    'category_permalink' => get_category_link($cat_id),
                );
            }
        }

        return $related_posts;
    }

    // Get related news lastest
    static function get_related_news($number_news = 5) {

        // Lấy ID bài viết hiện tại
        $current_post_id = get_the_ID();

        // Lấy danh sách tag của bài viết hiện tại
        $current_post_tags = wp_get_post_tags($current_post_id, array('fields' => 'ids'));

        // Truy vấn danh sách bài viết liên quan
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_news,
            'post__not_in' => array($current_post_id),
            'tag__in' => $current_post_tags,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $related_query = new WP_Query($args);

        // Mảng lưu trữ thông tin bài viết liên quan
        $related_news = array();

        if ($related_query->have_posts()) {
            while ($related_query->have_posts()) {
                $related_query->the_post();

                // Lấy thông tin bài viết liên quan
                $related_item = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                    'date' => get_the_date(),
                    'permalink' => get_permalink(),
                );

                // Thêm bài viết liên quan vào mảng
                $related_news[] = $related_item;
            }
        }

        // Đặt lại dữ liệu bài viết
        wp_reset_postdata();

        return $related_news;
    }

    // Get lastest of category
    static function get_lastest_news_by_category($category_id = array(), $number_news = 5) {

        // Lấy ID chuyên mục hiện tại
        $current_category_id = $category_id;

        // Truy vấn danh sách tin trong chuyên mục hiện tại
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_news,
            'category__in' => array($current_category_id),
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $news_query = new WP_Query($args);

        // Mảng lưu trữ thông tin tin tức
        $list_news = array();

        if ($news_query->have_posts()) {
            while ($news_query->have_posts()) {
                $news_query->the_post();

                // Lấy thông tin tin tức
                $news_item = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID()),
                    'date' => get_the_date(),
                    'permalink' => get_permalink(),
                );

                // Thêm tin tức vào mảng
                $list_news[] = $news_item;
            }
        }

        // Đặt lại dữ liệu bài viết
        wp_reset_postdata();

        return $list_news;
    }

    // Get lastest of news
    static function get_lastest_news($number_news = 5) {

        // Truy vấn danh sách tin trong chuyên mục hiện tại
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_news,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish'
        );

        $news_query = new WP_Query($args);

        // Mảng lưu trữ thông tin tin tức
        $list_news = array();

        if ($news_query->have_posts()) {
            while ($news_query->have_posts()) {
                $news_query->the_post();

                // Lấy thông tin tin tức
                $news_item = array(
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID()),
                    'date' => get_the_date('j F Y'),
                    'permalink' => get_permalink(),
                );

                // Thêm tin tức vào mảng
                $list_news[] = $news_item;
            }
        }

        // Đặt lại dữ liệu bài viết
        wp_reset_postdata();

        return $list_news;
    }
}
