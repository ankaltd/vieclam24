<?php

/**
 * WEP Template Tag Class, with direct using include echo inside
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since WEP 1.0
 */

class WEP_Tag {

    public  function __construct() {
    }
    static function init() {
    }

    /** 
     * Render Container Tag 
     * @var $tag = 'close' => closing tag
     * @var $full = true => container-fluid
     * @var $args = array attributes for tag (tag_id, tag_classes, tag_style, tag_atts)
     */
    public static function container($tag = 'open', $full = false, $args = array()) {

        $tag_args = array('width' => $full ? '-fluid' : '');
        $tag_args += $args;

        if ($tag == 'open') :
            get_template_part('parts/global/container-start', null, $tag_args);
        else :
            get_template_part('parts/global/container-end');
        endif;
    }

    /** 
     * Render Row Tag 
     * @var $tag = 'end' => closing tag
     * @var $args = array attributes for tag (tag_id, tag_classes, tag_style, tag_atts)
     */
    public static function row($tag = 'open', $args = array()) {

        if ($tag == 'open') :
            get_template_part('parts/global/row-start', null, $args);
        else :
            get_template_part('parts/global/row-end');
        endif;
    }

    /** 
     * Render Column Tag 
     * @var $tag = 'end' => closing tag
     * @var $cols = '12' => number of column
     * @var $args = array attributes for tag (tag_id, tag_classes, tag_style, tag_atts)
     */
    public static function col($tag = 'open', $cols = '12', $args = array()) {

        $tag_args = array(
            'classes' =>  'col-' . $cols
        );

        $tag_args += $args;

        if ($tag == 'open') :
            get_template_part('parts/global/col-start', null, $tag_args);
        else :
            get_template_part('parts/global/col-end');
        endif;
    }

    /** 
     * Render Section Tag 
     * @var $tag = 'end' => closing tag
     * @var $full = true => container-fluid
     * @var $args = array attributes for tag (tag_id, tag_classes, tag_style, tag_atts)
     */
    public static function section($tag = 'open', $args = array()) {

        if ($tag == 'open') :
            get_template_part('parts/global/section-start', null, $args);
        else :
            get_template_part('parts/global/section-end');
        endif;
    }

    /** 
     * Render Image Tag 
     * @var $src = '' => default image
     * @var $responsive = true => img-fluid
     * @var $args = array attributes for tag (tag_id, tag_classes, tag_style, tag_atts, tag_width, tag_height, tag_alt)
     */
    public static function image($src = 'default.png', $responsive = true, $width = 'auto', $height = 'auto', $args = array()) {

        $tag_args = array(
            'src' => $src,
            'responsive' => $responsive,
            'width' => $width,
            'height' => $height,
        );
        $tag_args += $args;

        get_template_part('parts/global/image', null, $tag_args);
    }

    // Render Bootstrap Tag
    public static function render_bs_tag($args = '') {

        $tag_name = 'div';
        $tag_id = '';
        $classes = '';
        $inline_css = '';
        $prop_list = '';
        $before_content = '';

        if (is_array($args)) {
            // chuyển mỗi thành phần mảng thành biến
            extract($args);
            if (isset($tag)) {
                $tag_name = $tag;
            }
            if (isset($id)) {
                $tag_id = $id;
            }
            if (isset($class)) {
                $classes = $class;
            }
            if (isset($style)) {
                $inline_css = $style;
            }
            if (isset($prop)) {
                $prop_list = $prop;
            }
            if (isset($content)) {
                $before_content = $content;
            }
        } elseif ($args !== '') { // nếu là string
            // nếu string khác '' thì là class
            $classes = $args;
        }

        if ($classes !== '') {
            $class_list = sprintf('class="%s"', $classes);
        } else {
            $class_list = '';
        }

        if ($tag_id !== '') {
            $id_name = sprintf('id="%s"', $tag_id);
        } else {
            $id_name = '';
        }

        if ($prop_list !== '') {
            $prop_list = sprintf('%s', $prop_list);
        } else {
            $prop_list = '';
        }

        if ($inline_css !== '') {
            $inline_css = sprintf('style="%s"', $inline_css);
        } else {
            $inline_css = '';
        }

        $html = sprintf('<%s %s %s %s>%s', $tag_name, $id_name, $class_list, $prop_list, $before_content);

        echo apply_filters('wep_html_tag', $html);
    }

    // Render Bootstrap Close Tag
    static function render_bs_close_tag($tag_name = 'div', $after_content = '') {

        $html = sprintf('%s</%s>', $after_content, $tag_name);
        echo apply_filters('wep_html_close_tag', $html);
    }

    /**
     * Calculate classes for the main <html> element.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    static function wep_the_html_classes() {
        /**
         * Filters the classes for the main <html> element.
         *
         * @since Twenty Twenty-One 1.0
         *
         * @param string The list of classes. Default empty string.
         */
        $classes = apply_filters('wep_html_classes', '');
        if (!$classes) {
            return;
        }
        echo 'class="' . esc_attr($classes) . '"';
    }

    /**
     * Prints HTML with meta information for the current post-date/time.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    static function wep_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date())
        );
        echo '<span class="posted-on">';
        printf(
            /* translators: %s: Publish date. */
            esc_html__('Published %s', LANG_DOMAIN),
            $time_string // phpcs:ignore WordPress.Security.EscapeOutput
        );
        echo '</span>';
    }

    /**
     * Prints HTML with meta information about theme author.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    static function wep_posted_by() {
        if (!get_the_author_meta('description') && post_type_supports(get_post_type(), 'author')) {
            echo '<span class="byline">';
            printf(
                /* translators: %s: Author name. */
                esc_html__('By %s', LANG_DOMAIN),
                '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author">' . esc_html(get_the_author()) . '</a>'
            );
            echo '</span>';
        }
    }

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     * Footer entry meta is displayed differently in archives and single posts.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    static function wep_entry_meta_footer() {

        // Early exit if not a post.
        if ('post' !== get_post_type()) {
            return;
        }

        // Hide meta information on pages.
        if (!is_single()) {

            if (is_sticky()) {
                echo '<p>' . esc_html_x('Featured post', 'Label for sticky posts', LANG_DOMAIN) . '</p>';
            }

            $post_format = get_post_format();
            if ('aside' === $post_format || 'status' === $post_format) {
                echo '<p><a href="' . esc_url(get_permalink()) . '">' . wep_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
            }

            // Posted on.
            self::wep_posted_on();

            // Edit post link.
            edit_post_link(
                sprintf(
                    /* translators: %s: Post title. Only visible to screen readers. */
                    esc_html__('Edit %s', LANG_DOMAIN),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                ),
                '<span class="edit-link">',
                '</span><br>'
            );

            if (has_category() || has_tag()) {

                echo '<div class="post-taxonomies">';

                $categories_list = get_the_category_list(wp_get_list_item_separator());
                if ($categories_list) {
                    printf(
                        /* translators: %s: List of categories. */
                        '<span class="cat-links">' . esc_html__('Categorized as %s', LANG_DOMAIN) . ' </span>',
                        $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }

                $tags_list = get_the_tag_list('', wp_get_list_item_separator());
                if ($tags_list) {
                    printf(
                        /* translators: %s: List of tags. */
                        '<span class="tags-links">' . esc_html__('Tagged %s', LANG_DOMAIN) . '</span>',
                        $tags_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }
                echo '</div>';
            }
        } else {

            echo '<div class="posted-by">';
            // Posted on.
            self::wep_posted_on();
            // Posted by.
            self::wep_posted_by();
            // Edit post link.
            edit_post_link(
                sprintf(
                    /* translators: %s: Post title. Only visible to screen readers. */
                    esc_html__('Edit %s', LANG_DOMAIN),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                ),
                '<span class="edit-link">',
                '</span>'
            );
            echo '</div>';

            if (has_category() || has_tag()) {

                echo '<div class="post-taxonomies">';

                $categories_list = get_the_category_list(wp_get_list_item_separator());
                if ($categories_list) {
                    printf(
                        /* translators: %s: List of categories. */
                        '<span class="cat-links">' . esc_html__('Categorized as %s', LANG_DOMAIN) . ' </span>',
                        $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }

                $tags_list = get_the_tag_list('', wp_get_list_item_separator());
                if ($tags_list) {
                    printf(
                        /* translators: %s: List of tags. */
                        '<span class="tags-links">' . esc_html__('Tagged %s', LANG_DOMAIN) . '</span>',
                        $tags_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }
                echo '</div>';
            }
        }
    }

    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    static function wep_post_thumbnail() {
        if (!self::wep_can_show_post_thumbnail()) {
            return;
        }
?>

        <?php if (is_singular()) : ?>

            <figure class="post-thumbnail">
                <?php
                // Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
                the_post_thumbnail('post-thumbnail', array('loading' => false));
                ?>
                <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                    <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                <?php endif; ?>
            </figure><!-- .post-thumbnail -->

        <?php else : ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail('post-thumbnail'); ?>
                </a>
                <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                    <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                <?php endif; ?>
            </figure><!-- .post-thumbnail -->

        <?php endif; ?>
<?php
    }

    /**
     * Print the next and previous posts navigation.
     *
     * @since WEP 1.0
     *
     * @return void
     */
    static function wep_the_posts_navigation() {
        the_posts_pagination(
            array(
                'before_page_number' => esc_html__('Page', LANG_DOMAIN) . ' ',
                'mid_size'           => 0,
                'prev_text'          => sprintf(
                    '%s <span class="nav-prev-text">%s</span>',
                    is_rtl() ? wep_get_icon_svg('ui', 'arrow_right') : wep_get_icon_svg('ui', 'arrow_left'),
                    wp_kses(
                        __('Newer <span class="nav-short">posts</span>', LANG_DOMAIN),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    )
                ),
                'next_text'          => sprintf(
                    '<span class="nav-next-text">%s</span> %s',
                    wp_kses(
                        __('Older <span class="nav-short">posts</span>', LANG_DOMAIN),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    is_rtl() ? wep_get_icon_svg('ui', 'arrow_left') : wep_get_icon_svg('ui', 'arrow_right')
                ),
            )
        );
    }
}
