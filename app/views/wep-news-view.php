<?php
class WEP_News_View {


    /* PageNavi */
    static function render_news_pagenavi($news_query = null) {
        global $wp_query;

        if ($news_query) $main_query = $news_query;
        else $main_query = $wp_query;

        $big = 999999999;
        $total = isset($main_query->max_num_pages) ? $main_query->max_num_pages : '';
        if ($total > 1) echo '<section class="wep_pagenav"><ul class="pagination">';

        $pagination = paginate_links(
            array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $total,
                'mid_size' => 3,
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'type' => 'list',
            )
        );

        // Tùy chỉnh mẫu HTML cho danh sách phân trang
        $pagination = str_replace('<ul class=\'page-numbers\'>', '<ul class="pagination">', $pagination);
        $pagination = str_replace('<li>', '<li class="page-item">', $pagination);
        $pagination = str_replace('page-numbers', 'page-item', $pagination);
        $pagination = str_replace('current', 'page-item active', $pagination);
        $pagination = str_replace('<span class="page-numbers dots">', '<li class="page-item disabled"><span class="page-link">...</span></li>', $pagination);
        $pagination = str_replace('<a class="page-numbers"', '<a class="page-link"', $pagination);
        $pagination = str_replace('<a class="page-item"', '<a class="page-link"', $pagination);
        $pagination = str_replace('</a>', '</a></li>', $pagination);


        echo $pagination;

        if ($total > 1) echo '</ul></section>';
    }

    /**
     * Hiển thị danh sách bài viết.
     *
     * @param array $posts Mảng các bài viết.
     */
    public function display_posts($posts) {
        if (!empty($posts)) {
            foreach ($posts as $post) {
                setup_postdata($post);
                echo '<div class="post">';
                echo '<h2 class="post-title">' . get_the_title() . '</h2>';
                echo '<div class="post-content">' . get_the_content() . '</div>';
                echo '</div>';
            }
            wp_reset_postdata();
        } else {
            echo '<p>No more posts</p>';
        }
    }

    /**
     * Hiển thị phân trang.
     *
     * @param int $current_page Trang hiện tại.
     * @param int $total_pages Tổng số trang.
     */
    public function display_pagination($current_page, $total_pages) {
        echo '<div class="pagination">';

        if ($current_page > 1) {
            echo '<a href="#" class="prev-page" data-page="' . ($current_page - 1) . '">&lt;</a>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="#" class="page-link' . ($current_page == $i ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
        }

        if ($current_page < $total_pages) {
            echo '<a href="#" class="next-page" data-page="' . ($current_page + 1) . '">&gt;</a>';
        }

        echo '</div>';
    }
}
