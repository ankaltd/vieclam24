<?php
class WEP_Model {
    public function get_latest_posts($offset, $posts_per_page) {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $query = new WP_Query($args);
        $posts = $query->get_posts();

        return $posts;
    }

    public function get_total_posts() {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
        );

        $query = new WP_Query($args);
        $total_posts = $query->found_posts;

        return $total_posts;
    }
}
