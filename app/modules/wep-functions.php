<?php


class WEP_Functions {

    function __construct() {

        /**
         * Include Theme Customizer.
         *
         * @since v1.0
         */
        $theme_customizer = __DIR__ . '/inc/customizer.php';
        if (is_readable($theme_customizer)) {
            require_once $theme_customizer;
        }

        if (!function_exists('vieclam24_add_user_fields')) {
        }

        add_action('after_setup_theme', array($this, 'vieclam24_setup_theme'));

        // Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
        remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
        remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');

        $this->wp_body_open();

        add_filter('user_contactmethods', array($this, 'vieclam24_add_user_fields'));
        add_filter('comments_open', array($this, 'vieclam24_filter_media_comment_status'), 10, 2);
        add_filter('edit_post_link', array($this, 'vieclam24_custom_edit_post_link'));
        add_filter('edit_comment_link', array($this, 'vieclam24_custom_edit_comment_link'));
        add_filter('embed_oembed_html', array($this, 'vieclam24_oembed_filter'), 10);

        add_filter('next_posts_link_attributes', array($this, 'posts_link_attributes'));
        add_filter('previous_posts_link_attributes', array($this, 'posts_link_attributes'));
        add_action('widgets_init', array($this, 'vieclam24_widgets_init'));
        add_filter('the_password_form', array($this, 'vieclam24_password_form'));
        add_filter('comment_reply_link', array($this, 'vieclam24_replace_reply_link_class'));
        add_filter('comment_form_defaults', array($this, 'vieclam24_custom_commentform'));
        add_action('wp_enqueue_scripts', array($this, 'vieclam24_scripts_loader'));

        /**
         * Nav menus.
         *
         * @since v1.0
         *
         * @return void
         */
        register_nav_menus(
            array(
                'main-menu'   => 'Main Navigation Menu',
                'footer-menu' => 'Footer Menu',
            )
        );


        // Custom Nav Walker: wp_bootstrap_navwalker().
        $custom_walker = __DIR__ . '/inc/wp-bootstrap-navwalker.php';
        if (is_readable($custom_walker)) {
            require_once $custom_walker;
        }

        $custom_walker_footer = __DIR__ . '/inc/wp-bootstrap-navwalker-footer.php';
        if (is_readable($custom_walker_footer)) {
            require_once $custom_walker_footer;
        }

        // Thêm cột chọn nhanh Page Template
        add_filter('manage_pages_columns', array($this, 'custom_page_template_column'));
        add_action('manage_pages_custom_column', array($this, 'custom_page_template_column_content'), 10, 2);

        // Add CSS & JS to Admin
        add_action('admin_enqueue_scripts', [$this, 'attach_css_files_admin']);
        add_action('admin_enqueue_scripts', [$this, 'attach_js_files_admin']);

        // Ajax apply template for page
        add_action('admin_enqueue_scripts', array($this, 'wep_admin_enqueue_scripts'));
        add_action('wp_ajax_apply_page_template', array($this, 'apply_page_template'));
    }

    // Định nghĩa biến ajaxurl trong JavaScript
    function wep_admin_enqueue_scripts() {
?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        </script>
        <?php
    }

    // Xử lý AJAX request để áp dụng template cho trang
    function apply_page_template() {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $page_template = isset($_POST['page_template']) ? sanitize_text_field($_POST['page_template']) : '';

        // Lưu template cho trang
        update_post_meta($post_id, '_wp_page_template', $page_template);

        wp_die(); // Kết thúc AJAX request
    }


    /**
     * Enqueue Stylesheets files Admin
     *
     * @return void
     */
    function attach_css_files_admin() {
        $cssFiles = require THEME_CONFIG . '/admin-cssfiles.config.php';
        if (!empty($cssFiles)) {
            foreach ($cssFiles as $cssFile) {
                if (!empty($cssFile['path'])) {
                    $fileId = (!empty($cssFile['handle'])) ? $cssFile['handle'] : 'cssfile-' . microtime();
                    wp_register_style(
                        $fileId,
                        $cssFile['path'],
                        (!empty($cssFile['dependencies'])) ? $cssFile['dependencies'] : [],
                        (!empty($cssFile['version'])) ? $cssFile['version'] : '',
                        (!empty($cssFile['media'])) ? $cssFile['media'] : 'all'
                    );
                    wp_enqueue_style($fileId);
                }
            }
        }
    }
    /**
     * Register block script Admin
     */
    function attach_js_files_admin() {
        $jsFiles = require THEME_CONFIG . '/admin-jsfiles.config.php';
        if (!empty($jsFiles)) {
            foreach ($jsFiles as $jsFile) {
                if (!empty($jsFile['path'])) {
                    // Enqueue script to WordPress
                    wp_enqueue_script(
                        (!empty($jsFile['handle'])) ? $jsFile['handle'] : 'jsfile-' . microtime(),
                        $jsFile['path'],
                        (!empty($jsFile['dependencies']) && is_array($jsFile['dependencies'])) ? $jsFile['dependencies'] : [],
                        (!empty($jsFile['version'])) ? $jsFile['version'] : '',
                        (!empty($jsFile['in_footer'])) ? $jsFile['in_footer'] : false
                    );
                }
            }
        }

        // Add JS Vars
        if (!empty($jsFiles[0])) {
            ob_start();
            require THEME_CONFIG . '/script-vars.config.php';
            $jsVars = ob_get_clean();
            wp_add_inline_script($jsFiles[0]['handle'], $jsVars, 'before');
        }
    }

    // Thêm cột "Giao diện" vào trang quản lý Page
    function custom_page_template_column($columns) {
        $columns['page_template'] = 'Giao diện';
        return $columns;
    }

    // Hiển thị nội dung cho cột "Giao diện"
    function custom_page_template_column_content($column_name, $post_id) {
        if ($column_name === 'page_template') {
            // Lấy giao diện của trang
            $page_template = get_post_meta($post_id, '_wp_page_template', true);

            // Hiển thị tên giao diện
            // echo esc_html($page_template);

            // Hiển thị dropdown select với tất cả các template
            echo '<select class="page-template-select" data-post-id="' . esc_attr($post_id) . '" style="width:100%">';
            echo '<option value="">Mặc định</option>';
            $all_templates = get_page_templates();

            foreach ($all_templates as $template_file => $template_name) {
                echo '<option value="' . esc_attr($template_name) . '"';

                // Kiểm tra nếu không có giao diện nào được chọn hoặc giao diện mặc định
                if (empty($page_template) || ($page_template === $template_name)) {
                    echo ' selected="selected"';
                }

                echo '>' . esc_html($template_file) . '</option>';
            }
            echo '</select>';
        }
    }




    /**
     * Loading All CSS Stylesheets and Javascript Files.
     *
     * @since v1.0
     *
     * @return void
     */
    function vieclam24_scripts_loader() {
        $theme_version = wp_get_theme()->get('Version');

        // 1. Styles.
        wp_enqueue_style('style', get_theme_file_uri('style.css'), array(), $theme_version, 'all');
        // wp_enqueue_style('main', get_theme_file_uri('build/main.css'), array(), $theme_version, 'all'); // main.scss: Compiled Framework source + custom styles.

        if (is_rtl()) {
            wp_enqueue_style('rtl', get_theme_file_uri('build/rtl.css'), array(), $theme_version, 'all');
        }

        // 2. Scripts.
        wp_enqueue_script('mainjs', get_theme_file_uri('build/main.js'), array(), $theme_version, true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Template for comments and pingbacks:
     * add function to comments.php ... wp_list_comments( array( 'callback' => 'vieclam24_comment' ) );
     *
     * @since v1.0
     *
     * @param object $comment Comment object.
     * @param array  $args    Comment args.
     * @param int    $depth   Comment depth.
     */
    static function vieclam24_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type):
            case 'pingback':
            case 'trackback':
        ?>
                <li class="post pingback">
                    <p>
                        <?php
                        esc_html_e('Pingback:', 'vieclam24');
                        comment_author_link();
                        edit_comment_link(esc_html__('Edit', 'vieclam24'), '<span class="edit-link">', '</span>');
                        ?>
                    </p>
                <?php
                break;
            default:
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment">
                        <footer class="comment-meta">
                            <div class="comment-author vcard">
                                <?php
                                $avatar_size = ('0' !== $comment->comment_parent ? 68 : 136);
                                echo get_avatar($comment, $avatar_size);

                                /* Translators: 1: Comment author, 2: Date and time */
                                printf(
                                    wp_kses_post(__('%1$s, %2$s', 'vieclam24')),
                                    sprintf('<span class="fn">%s</span>', get_comment_author_link()),
                                    sprintf(
                                        '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                                        esc_url(get_comment_link($comment->comment_ID)),
                                        get_comment_time('c'),
                                        /* Translators: 1: Date, 2: Time */
                                        sprintf(esc_html__('%1$s ago', 'vieclam24'), human_time_diff((int) get_comment_time('U'), current_time('timestamp')))
                                    )
                                );

                                edit_comment_link(esc_html__('Edit', 'vieclam24'), '<span class="edit-link">', '</span>');
                                ?>
                            </div><!-- .comment-author .vcard -->

                            <?php if ('0' === $comment->comment_approved) { ?>
                                <em class="comment-awaiting-moderation">
                                    <?php esc_html_e('Your comment is awaiting moderation.', 'vieclam24'); ?>
                                </em>
                                <br />
                            <?php } ?>
                        </footer>

                        <div class="comment-content"><?php comment_text(); ?></div>

                        <div class="reply">
                            <?php
                            comment_reply_link(
                                array_merge(
                                    $args,
                                    array(
                                        'reply_text' => esc_html__('Reply', 'vieclam24') . ' <span>&darr;</span>',
                                        'depth'      => $depth,
                                        'max_depth'  => $args['max_depth'],
                                    )
                                )
                            );
                            ?>
                        </div><!-- /.reply -->
                    </article><!-- /#comment-## -->
                <?php
                break;
        endswitch;
    }

    /**
     * Custom Comment form.
     *
     * @since v1.0
     * @since v1.1: Added 'submit_button' and 'submit_field'
     * @since v2.0.2: Added '$consent' and 'cookies'
     *
     * @param array $args    Form args.
     * @param int   $post_id Post ID.
     *
     * @return array
     */
    function vieclam24_custom_commentform($args = array(), $post_id = null) {
        if (null === $post_id) {
            $post_id = get_the_ID();
        }

        $commenter     = wp_get_current_commenter();
        $user          = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';

        $args = wp_parse_args($args);

        $req      = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true' required" : '');
        $consent  = (empty($commenter['comment_author_email']) ? '' : ' checked="checked"');
        $fields   = array(
            'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_html__('Name', 'vieclam24') . ($req ? '*' : '') . '"' . $aria_req . ' />
							<label for="author">' . esc_html__('Name', 'vieclam24') . ($req ? '*' : '') . '</label>
						</div>',
            'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_html__('Email', 'vieclam24') . ($req ? '*' : '') . '"' . $aria_req . ' />
							<label for="email">' . esc_html__('Email', 'vieclam24') . ($req ? '*' : '') . '</label>
						</div>',
            'url'     => '',
            'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__('Save my name, email, and website in this browser for the next time I comment.', 'vieclam24') . '</label>
						</p>',
        );

        $defaults = array(
            'fields'               => apply_filters('comment_form_default_fields', $fields),
            'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__('Comment', 'vieclam24') . ($req ? '*' : '') . '"></textarea>
											<label for="comment">' . esc_html__('Comment', 'vieclam24') . '</label>
										</div>',
            /** This filter is documented in wp-includes/link-template.php */
            'must_log_in'          => '<p class="must-log-in">' . sprintf(wp_kses_post(__('You must be <a href="%s">logged in</a> to post a comment.', 'vieclam24')), wp_login_url(esc_url(get_the_permalink(get_the_ID())))) . '</p>',
            /** This filter is documented in wp-includes/link-template.php */
            'logged_in_as'         => '<p class="logged-in-as">' . sprintf(wp_kses_post(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'vieclam24')), get_edit_user_link(), $user->display_name, wp_logout_url(apply_filters('the_permalink', esc_url(get_the_permalink(get_the_ID()))))) . '</p>',
            'comment_notes_before' => '<p class="small comment-notes">' . esc_html__('Your Email address will not be published.', 'vieclam24') . '</p>',
            'comment_notes_after'  => '',
            'id_form'              => 'commentform',
            'id_submit'            => 'submit',
            'class_submit'         => 'btn btn-primary',
            'name_submit'          => 'submit',
            'title_reply'          => '',
            'title_reply_to'       => esc_html__('Leave a Reply to %s', 'vieclam24'),
            'cancel_reply_link'    => esc_html__('Cancel reply', 'vieclam24'),
            'label_submit'         => esc_html__('Post Comment', 'vieclam24'),
            'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
            'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
            'format'               => 'html5',
        );

        return $defaults;
    }
    /**
     * Style Reply link.
     *
     * @since v1.0
     *
     * @param string $class Link class.
     *
     * @return string
     */
    function vieclam24_replace_reply_link_class($class) {
        return str_replace("class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class);
    }


    /**
     * Template for Password protected post form.
     *
     * @since v1.0
     *
     * @return string
     */
    function vieclam24_password_form() {
        global $post;
        $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);

        $output                  = '<div class="row">';
        $output             .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">';
        $output             .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__('This content is password protected. To view it please enter your password below.', 'vieclam24') . '</h4>';
        $output         .= '<div class="col-md-6">';
        $output     .= '<div class="input-group">';
        $output .= '<input type="password" name="post_password" id="' . esc_attr($label) . '" placeholder="' . esc_attr__('Password', 'vieclam24') . '" class="form-control" />';
        $output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__('Submit', 'vieclam24') . '" /></div>';
        $output     .= '</div><!-- /.input-group -->';
        $output         .= '</div><!-- /.col -->';
        $output             .= '</form>';
        $output                 .= '</div><!-- /.row -->';

        return $output;
    }
    /**
     * "Theme posted on" pattern.
     *
     * @since v1.0
     */
    static function vieclam24_article_posted_on() {
        printf(
            wp_kses_post(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'vieclam24')),
            esc_url(get_the_permalink()),
            esc_attr(get_the_date() . ' - ' . get_the_time()),
            esc_attr(get_the_date('c')),
            esc_html(get_the_date() . ' - ' . get_the_time()),
            esc_url(get_author_posts_url((int) get_the_author_meta('ID'))),
            sprintf(esc_attr__('View all posts by %s', 'vieclam24'), get_the_author()),
            get_the_author()
        );
    }

    /**
     * Init Widget areas in Sidebar.
     *
     * @since v1.0
     *
     * @return void
     */
    function vieclam24_widgets_init() {
        // Area 1.
        register_sidebar(
            array(
                'name'          => 'Primary Widget Area (Sidebar)',
                'id'            => 'primary_widget_area',
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );

        // Area 2.
        register_sidebar(
            array(
                'name'          => 'Secondary Widget Area (Header Navigation)',
                'id'            => 'secondary_widget_area',
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );

        // Area 3.
        register_sidebar(
            array(
                'name'          => 'Third Widget Area (Footer)',
                'id'            => 'third_widget_area',
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );
    }
    /**
     * Display a navigation to next/previous pages when applicable.
     *
     * @since v1.0
     *
     * @param string $nav_id Navigation ID.
     */
    static function vieclam24_content_nav($nav_id) {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) {
                ?>
                <div id="<?php echo esc_attr($nav_id); ?>" class="d-flex mb-4 justify-content-between">
                    <div><?php next_posts_link('<span aria-hidden="true">&larr;</span> ' . esc_html__('Older posts', 'vieclam24')); ?></div>
                    <div><?php previous_posts_link(esc_html__('Newer posts', 'vieclam24') . ' <span aria-hidden="true">&rarr;</span>'); ?></div>
                </div><!-- /.d-flex -->
    <?php
        } else {
            echo '<div class="clearfix"></div>';
        }
    }

    /**
     * Add Class.
     *
     * @since v1.0
     *
     * @return string
     */
    function posts_link_attributes() {
        return 'class="btn btn-secondary btn-lg"';
    }
    /**
     * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
     *
     * @since v1.0
     *
     * @param string $html Inner HTML.
     *
     * @return string
     */
    function vieclam24_oembed_filter($html) {
        return '<div class="ratio ratio-16x9">' . $html . '</div>';
    }

    /**
     * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
     *
     * @since v1.0
     *
     * @param string $link Comment Edit Link.
     */
    function vieclam24_custom_edit_comment_link($link) {
        return str_replace('class="comment-edit-link"', 'class="comment-edit-link badge bg-secondary"', $link);
    }

    /**
     * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
     *
     * @since v1.0
     *
     * @param string $link Post Edit Link.
     *
     * @return string
     */
    function vieclam24_custom_edit_post_link($link) {
        return str_replace('class="post-edit-link"', 'class="post-edit-link badge bg-secondary"', $link);
    }

    /**
     * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
     *
     * @since v1.0
     *
     * @param bool $open    Comments open/closed.
     * @param int  $post_id Post ID.
     *
     * @return bool
     */
    function vieclam24_filter_media_comment_status($open, $post_id = null) {
        $media_post = get_post($post_id);

        if ('attachment' === $media_post->post_type) {
            return false;
        }

        return $open;
    }

    /**
     * Test if a page is a blog page.
     * if ( is_blog() ) { ... }
     *
     * @since v1.0
     *
     * @return bool
     */
    function is_blog() {
        global $post;
        $posttype = get_post_type($post);

        return ((is_archive() || is_author() || is_category() || is_home() || is_single() || (is_tag() && ('post' === $posttype))) ? true : false);
    }

    /**
     * Add new User fields to Userprofile:
     * get_user_meta( $user->ID, 'facebook_profile', true );
     *
     * @since v1.0
     *
     * @param array $fields User fields.
     *
     * @return array
     */
    function vieclam24_add_user_fields($fields) {
        // Add new fields.
        $fields['facebook_profile'] = 'Facebook URL';
        $fields['twitter_profile']  = 'Twitter URL';
        $fields['linkedin_profile'] = 'LinkedIn URL';
        $fields['xing_profile']     = 'Xing URL';
        $fields['github_profile']   = 'GitHub URL';

        return $fields;
    }

    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     * @since v2.2
     *
     * @return void
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }

    /**
     * General Theme Settings.
     *
     * @since v1.0
     *
     * @return void
     */
    function vieclam24_setup_theme() {
        // Make theme available for translation: Translations can be filed in the /languages/ directory.
        load_theme_textdomain('vieclam24', __DIR__ . '/languages');

        /**
         * Set the content width based on the theme's design and stylesheet.
         *
         * @since v1.0
         */
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 800;
        }

        // Theme Support.
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
                'navigation-widgets',
            )
        );

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');
        // Add support for full and wide alignment.
        add_theme_support('align-wide');
        // Add support for Editor Styles.
        add_theme_support('editor-styles');
        // Enqueue Editor Styles.
        add_editor_style('style-editor.css');

        // Default attachment display settings.
        update_option('image_default_align', 'none');
        update_option('image_default_link_type', 'none');
        update_option('image_default_size', 'large');

        // Custom CSS styles of WorPress gallery.
        add_filter('use_default_gallery_style', '__return_false');
    }
}
