<?php

/* WEP_Admin_Menu Class */

class WEP_Admin_Menu {
    public function __construct() {
        add_action('admin_bar_menu', array($this, 'wep_admin_bar_menu'), 100);
        add_action('admin_menu', array($this, 'wep_userguide_page'));
    }

    // Thêm trang admin
    public function wep_userguide_page() {

        // Main Menu Admin
        add_menu_page(
            'Hướng dẫn',
            'Hướng dẫn',
            'manage_options',
            'wep-userguide',
            array($this, 'wep_userguide_page_content'),
            'dashicons-editor-help',
            2
        );

        // Lấy danh sách bài hướng dẫn
        $args = array(
            'post_type' => 'wep_guide',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $posts = get_posts($args);

        foreach ($posts as $post) {
            $slug = $post->post_name;
            $title = $post->post_title;

            // Sub Menus Admin
            $url = admin_url('admin.php?page=wep-userguide&tab=' . $slug);
            add_submenu_page(
                'wep-userguide', // Trang cha của submenu, có thể là slug của trang chính hoặc slug của menu cha
                __($title), // Tiêu đề trang
                __($title), // Tên trên menu
                'manage_options', // Quyền truy cập
                'wep-userguide&tab=' . $slug, // Slug của submenu
                function() use ($url) { // Sử dụng biến $url trong hàm callback
                    echo '<script>window.location="'.$url.'"</script>';
                }          
            );
        }
    }
    public function wep_admin_bar_menu() {
        global $wp_admin_bar;
        if (!is_super_admin() || !is_admin_bar_showing())
            return;
        $wp_admin_bar->add_menu(array(
            'id' => 'wep_menu',
            'title' => __('Hướng dẫn'),
            'href' => admin_url('admin.php?page=wep-userguide'),
        ));

        $args = array(
            'post_type' => 'wep_guide',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $posts = get_posts($args);

        foreach ($posts as $post) {
            $slug = $post->post_name;
            $title = $post->post_title;
            $wp_admin_bar->add_menu(array(
                'parent' => 'wep_menu',
                'id' => 'wep_menu_' . $slug,
                'title' => __($title),
                'href' => admin_url('admin.php?page=wep-userguide&tab=' . $slug),
            ));
        }
    }

    // Nội dung trang admin
    // Nội dung trang admin
    public function wep_userguide_page_content() {
?>
        <div class="wrap">
            <h1>Wep User Guide</h1>
            <div class="tabs">
                <h2 class="nav-tab-wrapper">
                    <?php
                    $args = array(
                        'post_type' => 'wep_guide',
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'posts_per_page' => -1,
                    );

                    $posts = get_posts($args);
                    foreach ($posts as $post) {
                        $slug = $post->post_name;
                        $title = $post->post_title;
                        echo '<a href="?page=wep-userguide&tab=' . $slug . '" class="nav-tab ' . ((isset($_GET['tab']) && $_GET['tab'] == $slug) ? 'nav-tab-active' : '') . '">' . $title . '</a>';
                    }
                    ?>
                </h2>
                <?php
                if (isset($_GET['tab'])) {
                    $slug = sanitize_text_field($_GET['tab']);
                    $args = array(
                        'name'        => $slug,
                        'post_type'   => 'wep_guide',
                        'post_status' => 'publish',
                        'orderby'     => 'title',
                        'order'       => 'DESC',
                        'numberposts' => 1
                    );
                    $posts = get_posts($args);
                    if ($posts) {
                        $post = $posts[0];
                        $id = $post->ID;
                        $content = $post->post_content;
                        $title = $post->post_title;
                        $content = wp_kses_post($content);
                        $edit_link = "https://bvdt.webp.vn/wp-admin/post.php?post=$id&action=edit";

                        echo "<h2>Hướng dẫn sử dụng - $title ";
                        echo "<a href='$edit_link'>[sửa]</a></h2>";
                        echo "<div class='wep_content_html'>$content</div>";
                    }
                }
                ?>
            </div>
        </div>
<?php
    }
}
