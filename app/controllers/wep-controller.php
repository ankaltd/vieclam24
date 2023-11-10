<?php


class WEP_Controller {
    public function fetch_latest_posts($offset, $posts_per_page) {
        // Gọi phương thức trong model để truy vấn dữ liệu bài viết mới nhất
        $model = new WEP_Model();
        $posts = $model->get_latest_posts($offset, $posts_per_page);

        // Gọi phương thức trong view để hiển thị dữ liệu
        $view = new WEP_News_View();
        $view->display_posts($posts);

        wp_die();
    }

    public function fetch_posts_pagination($page) {
        // Gọi phương thức trong model để truy vấn dữ liệu bài viết theo trang
        $model = new WEP_Model();
        $posts_per_page = 10;
        $offset = ($page - 1) * $posts_per_page;
        $posts = $model->get_latest_posts($offset, $posts_per_page);

        // Gọi phương thức trong view để hiển thị dữ liệu
        $view = new WEP_News_View();
        $view->display_posts($posts);

        wp_die();
    }
}
