<?php

/**
 * WP SEO Class for call direct static function
 * Include methods return values
 */
class WEP_SEO {

    public function __construct() {
    }

    /* Description Meta */
    static function site_description() {
        if (is_single()) {
            single_post_title('', true);
        } else {
            bloginfo('name');
            echo " - ";
            bloginfo('description');
        }
    }

    /* Social Graph Render */
    static function social_graph_meta() {

        // Thẻ meta cho Facebook Open Graph 
        if (is_front_page()) {

            $thumbnail_url = THEME_IMG . '/wep-preview.jpg';
            $title = get_bloginfo('name');
            $description = get_bloginfo('description');
            $url = home_url();

            printf(
                '<meta property="og:image" content="%s">
                <meta property="og:title" content="%s">
                <meta property="og:description" content="%">
                <meta property="og:url" content="%s">
                <meta property="og:type" content="article">',
                esc_url($thumbnail_url),
                esc_attr($title),
                esc_attr($description),
                esc_url($url)
            );
        }

        if (is_single()) {

            $thumbnail_url = get_the_post_thumbnail_url();
            $title = get_the_title();
            $description = get_the_excerpt();
            $url = get_permalink();

            printf(
                '<meta property="og:image" content="%s">
                <meta property="og:title" content="%s">
                <meta property="og:description" content="%s">
                <meta property="og:url" content="%s">
                <meta property="og:type" content="article">',
                esc_url($thumbnail_url),
                esc_attr($title),
                esc_attr($description),
                esc_url($url)
            );
        }

        // Thẻ meta cho Twitter Cards 
        if (is_single()) {

            $thumbnail_url = get_the_post_thumbnail_url();
            $title = get_the_title();
            $description = get_the_excerpt();
            $url = get_permalink();

            printf(
                '<meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:title" content="%s">
                <meta name="twitter:description" content="%s">
                <meta name="twitter:image" content="%s">
                <meta name="twitter:url" content="%s">',
                esc_attr($title),
                esc_attr($description),
                esc_url($thumbnail_url),
                esc_url($url)
            );
        }
    }
}
