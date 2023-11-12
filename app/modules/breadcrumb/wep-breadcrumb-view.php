
<?php

class WEP_Breadcrumb_View {

    static function render_breadcrumb() {
        echo '<section class="wep_breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">';

        // Trang chủ
        echo '<li class="breadcrumb-item"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="icon text-dtv text-base mr-[10px]" data-v-2026a140="" style="" width="1em" height="1em" viewBox="0 0 24 24" data-v-dc707951="">
        <path fill="#e41d30" d="M10 20H6q-.425 0-.713-.288T5 19v-7H3.3q-.35 0-.475-.325t.15-.55l8.35-7.525q.275-.275.675-.275t.675.275L16 6.6V4.5q0-.2.15-.35T16.5 4h2q.2 0 .35.15t.15.35v4.8l2.025 1.825q.275.225.15.55T20.7 12H19v7q0 .425-.288.713T18 20h-4v-5q0-.425-.288-.713T13 14h-2q-.425 0-.713.288T10 15v5Zm0-9.975h4q0-.8-.6-1.313T12 8.2q-.8 0-1.4.513t-.6 1.312Z"></path>
    </svg><a href="' . home_url() . '">Trang chủ</a></li>';

        // Kiểm tra xem trang hiện tại là trang sản phẩm WooCommerce
        if (is_product()) {
            global $product;
            if (is_object($product)) {
                $product_id = $product->get_id();
                $product_cats = wp_get_post_terms($product_id, 'product_cat');

                if (!empty($product_cats)) {
                    foreach ($product_cats as $cat) {
                        $cat_link = get_term_link($cat);
                        echo '<li class="breadcrumb-item"><a href="' . esc_url($cat_link) . '">' . esc_html($cat->name) . '</a></li>';
                    }
                }

                echo '<li class="breadcrumb-item"><span class="current">' . esc_html($product->get_name()) . '</span></li>';
            } else {
                echo '<li class="breadcrumb-item">';
                echo get_the_title();
                echo '</li>';
            }
        }


        // Kiểm tra xem trang hiện tại là trang danh mục sản phẩm WooCommerce
        elseif (is_product_category()) {
            $term = get_queried_object();
            $parent_term_id = $term->parent;

            if ($parent_term_id) {
                $parent_term = get_term($parent_term_id, 'product_cat');
                echo '<li class="breadcrumb-item"><a href="' . get_term_link($parent_term) . '">' . esc_html($parent_term->name) . '</a></li>';
            }

            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html($term->name) . '</li>';
        }

        // Kiểm tra xem trang hiện tại là trang bài viết
        elseif (is_single()) {
            echo '<li class="breadcrumb-item">';
            the_category(' / '); // Hiển thị danh mục bài viết
            echo '</li>';
            echo '<li class="breadcrumb-item">';
            the_title(); // Hiển thị tiêu đề bài viết
            echo '</li>';
        }

        // Kiểm tra xem trang hiện tại là trang danh mục bài viết
        elseif (is_category()) {
            echo '<li class="breadcrumb-item">';
            single_cat_title(); // Hiển thị tiêu đề danh mục
            echo '</li>';
        }

        // Kiểm tra xem trang hiện tại là trang loại bài viết tùy chỉnh
        elseif (is_post_type_archive()) {
            echo '<li class="breadcrumb-item">';
            echo post_type_archive_title(); // Hiển thị tiêu đề loại bài viết tùy chỉnh
            echo '</li>';
        }

        // Kiểm tra xem trang hiện tại là trang taxonomy tùy chỉnh
        elseif (is_tax()) {
            $term = get_queried_object();
            $taxonomy = get_taxonomy($term->taxonomy);

            echo '<li class="breadcrumb-item">';
            echo esc_html($taxonomy->labels->singular_name) . ': ' . esc_html($term->name); // Hiển thị tên taxonomy và tên term
            echo '</li>';
        }

        // Kiểm tra xem trang hiện tại là trang tùy chỉnh khác
        elseif (is_singular()) {
            echo '<li class="breadcrumb-item">';
            the_title(); // Hiển thị tiêu đề trang tùy chỉnh
            echo '</li>';
        }
        // Kiểm tra xem trang hiện tại là trang tùy chỉnh khác
        elseif (is_404()) {
            echo '<li class="breadcrumb-item">404</li>';
        }

        // Trường hợp mặc định
        else {
            echo '<li class="breadcrumb-item">';
            the_title(); // Hiển thị tiêu đề trang mặc định
            echo '</li>';
        }

        echo '</ol></nav>';
        echo '</section>';
    }
}
