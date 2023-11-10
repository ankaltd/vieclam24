<?php

/**
 * WEP Template Hooks Class, with functions that hooks action / filter
 * 
 */

class WEP_Hooks {

    public function __construct() {
        add_filter('wp_get_attachment_image_attributes', [$this, 'wep_get_attachment_image_attributes'], 10, 3);
        add_filter('body_class', [$this, 'wep_body_classes']);
        add_filter('post_class', [$this, 'wep_post_classes'], 10, 3);
        add_action('wp_head', [$this, 'wep_pingback_header']);
        add_action('wp_footer', [$this, 'wep_supports_js']);
        add_filter('comment_form_defaults', [$this, 'wep_comment_form_defaults']);
        add_filter('excerpt_more', [$this, 'wep_continue_reading_link_excerpt']); // Filter the excerpt more link.
        add_filter('the_content_more_link', [$this, 'wep_continue_reading_link']); // Filter the content more link.
        add_filter('the_title', [$this, 'wep_post_title']);
        add_filter('get_calendar', [$this, 'wep_change_calendar_nav_arrows']);
        add_filter('the_password_form', [$this, 'wep_password_form'], 10, 2);
        add_action('wp_head', [$this, 'custom_single_post_meta_description']);
        add_filter('excerpt_more', [$this, 'wep_excerpt_more']);

    }

    

    // Remove Continue Reading...
    function wep_excerpt_more($more) {
        return '';
    }

    // Meta description
    public function custom_single_post_meta_description() {
        global $post;

        // Kiểm tra xem bài viết có nội dung không
        if (!empty($post->post_content)) {
            // Xóa các thẻ HTML và các ký tự đặc biệt từ nội dung bài viết
            $cleaned_content = wp_strip_all_tags($post->post_content);

            // Cắt nội dung thành 160 ký tự
            $meta_description = mb_substr($cleaned_content, 0, 160);

            // Kiểm tra xem có nên thêm dấu chấm 3 chấm (...) nếu nội dung bài viết quá dài
            if (mb_strlen($cleaned_content) > 160) {
                $meta_description .= '...';
            }

            // Xóa khoảng trắng ở đầu và cuối chuỗi meta description (nếu có)
            $meta_description = trim($meta_description);

            // In ra thẻ Meta description
            echo '<meta name="description" content="' . esc_attr($meta_description) . '" />';
        }
    }

    /**
     * Functions which enhance the theme by hooking into WordPress
     *
     * @package WordPress
     * @subpackage Twenty_Twenty_One
     * @since WEP 1.0
     */

    /**
     * Adds custom classes to the array of body classes.
     *
     * @since WEP 1.0
     *
     * @param array $classes Classes for the body element.
     * @return array
     */
    function wep_body_classes($classes) {

        // Helps detect if JS is enabled or not.
        $classes[] = 'no-js';

        // Adds `singular` to singular pages, and `hfeed` to all other pages.
        $classes[] = is_singular() ? 'singular' : 'hfeed';

        // Add a body class if main navigation is active.
        if (has_nav_menu('primary')) {
            $classes[] = 'has-main-navigation';
        }

        // Add a body class if there are no footer widgets.
        if (!is_active_sidebar('sidebar-1')) {
            $classes[] = 'no-widgets';
        }

        // Add .init-nav-white vào body nếu đang không phải trang chủ
        if (!is_front_page() && (WEP_Router::wep_page_template() != 'templates/home.php')) {
            $classes[] = 'init-nav-white';
        }

        return $classes;
    }

    /**
     * Adds custom class to the array of posts classes.
     *
     * @since WEP 1.0
     *
     * @param array $classes An array of CSS classes.
     * @return array
     */
    function wep_post_classes($classes) {
        $classes[] = 'entry';

        return $classes;
    }

    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    function wep_pingback_header() {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }

    /**
     * Remove the `no-js` class from body if JS is supported.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    function wep_supports_js() {
        echo '<script>document.body.classList.remove("no-js");</script>';
    }

    /**
     * Changes comment form default fields.
     *
     * @since WEP 1.0
     *
     * @param array $defaults The form defaults.
     * @return array
     */
    function wep_comment_form_defaults($defaults) {

        // Adjust height of comment form.
        $defaults['comment_field'] = preg_replace('/rows="\d+"/', 'rows="5"', $defaults['comment_field']);

        return $defaults;
    }

    /**
     * Determines if post thumbnail can be displayed.
     *
     * @since WEP 1.0
     *
     * @return bool
     */
    function wep_can_show_post_thumbnail() {
        /**
         * Filters whether post thumbnail can be displayed.
         *
         * @since WEP 1.0
         *
         * @param bool $show_post_thumbnail Whether to show post thumbnail.
         */
        return apply_filters(
            'wep_can_show_post_thumbnail',
            !post_password_required() && !is_attachment() && has_post_thumbnail()
        );
    }

    /**
     * Creates the continue reading link for excerpt.
     *
     * @since WEP 1.0
     */
    function wep_continue_reading_link_excerpt() {
        if (!is_admin()) {
            return '&hellip; <a class="more-link" href="' . esc_url(get_permalink()) . '">' . WEP_Helper::wep_continue_reading_text() . '</a>';
        }
    }

    /**
     * Creates the continue reading link.
     *
     * @since WEP 1.0
     */
    function wep_continue_reading_link() {
        if (!is_admin()) {
            return '<div class="more-link-container"><a class="more-link" href="' . esc_url(get_permalink()) . '#more-' . esc_attr(get_the_ID()) . '">' . WEP_Helper::wep_continue_reading_text() . '</a></div>';
        }
    }

    /**
     * Adds a title to posts and pages that are missing titles.
     *
     * @since WEP 1.0
     *
     * @param string $title The title.
     * @return string
     */
    function wep_post_title($title) {
        return '' === $title ? esc_html_x('Untitled', 'Added to posts and pages that are missing titles', LANG_DOMAIN) : $title;
    }

    /**
     * Changes the default navigation arrows to svg icons
     *
     * @since WEP 1.0
     *
     * @param string $calendar_output The generated HTML of the calendar.
     * @return string
     */
    function wep_change_calendar_nav_arrows($calendar_output) {
        $calendar_output = str_replace('&laquo; ', is_rtl() ? wep_get_icon_svg('ui', 'arrow_right') : wep_get_icon_svg('ui', 'arrow_left'), $calendar_output);
        $calendar_output = str_replace(' &raquo;', is_rtl() ? wep_get_icon_svg('ui', 'arrow_left') : wep_get_icon_svg('ui', 'arrow_right'), $calendar_output);
        return $calendar_output;
    }

    /**
     * Retrieve protected post password form content.
     *
     * @since WEP 1.0
     * @since WEP 1.4 Corrected parameter name for `$output`,
     *                              added the `$post` parameter.
     *
     * @param string      $output The password form HTML output.
     * @param int|WP_Post $post   Optional. Post ID or WP_Post object. Default is global $post.
     * @return string HTML content for password form for password protected post.
     */
    function wep_password_form($output, $post = 0) {
        $post   = get_post($post);
        $label  = 'pwbox-' . (empty($post->ID) ? wp_rand() : $post->ID);
        $output = '<p class="post-password-message">' . esc_html__('This content is password protected. Please enter a password to view.', LANG_DOMAIN) . '</p>
	<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post">
	<label class="post-password-form__label" for="' . esc_attr($label) . '">' . esc_html_x('Password', 'Post password form', LANG_DOMAIN) . '</label><input class="post-password-form__input" name="post_password" id="' . esc_attr($label) . '" type="password" spellcheck="false" size="20" /><input type="submit" class="post-password-form__submit" name="' . esc_attr_x('Submit', 'Post password form', LANG_DOMAIN) . '" value="' . esc_attr_x('Enter', 'Post password form', LANG_DOMAIN) . '" /></form>
	';
        return $output;
    }

    /**
     * Filters the list of attachment image attributes.
     *
     * @since WEP 1.0
     *
     * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
     *                                 See wp_get_attachment_image().
     * @param WP_Post      $attachment Image attachment post.
     * @param string|int[] $size       Requested image size. Can be any registered image size name, or
     *                                 an array of width and height values in pixels (in that order).
     * @return string[] The filtered attributes for the image markup.
     */
    function wep_get_attachment_image_attributes($attr, $attachment, $size) {

        if (is_admin()) {
            return $attr;
        }

        if (isset($attr['class']) && false !== strpos($attr['class'], 'custom-logo')) {
            return $attr;
        }

        $width  = false;
        $height = false;

        if (is_array($size)) {
            $width  = (int) $size[0];
            $height = (int) $size[1];
        } elseif ($attachment && is_object($attachment) && $attachment->ID) {
            $meta = wp_get_attachment_metadata($attachment->ID);
            if (isset($meta['width']) && isset($meta['height'])) {
                $width  = (int) $meta['width'];
                $height = (int) $meta['height'];
            }
        }

        if ($width && $height) {

            // Add style.
            $attr['style'] = isset($attr['style']) ? $attr['style'] : '';
            $attr['style'] = 'width:100%;height:' . round(100 * $height / $width, 2) . '%;max-width:' . $width . 'px;' . $attr['style'];
        }

        return $attr;
    }
}
