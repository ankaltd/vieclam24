<?php

/**
 * WEP Menu Class, with functions and filters related to the menus.
 * 
 * Makes the default WordPress navigation use an HTML structure similar
 * to the Navigation block.
 *
 * @link https://make.wordpress.org/themes/2020/07/06/printing-navigation-block-html-from-a-legacy-menu-in-themes/
 *
 * @package WordPress
 * @subpackage WEP
 * @since WEP 1.0
 */

/**
 * Add a button to top-level menu items that has sub-menus.
 * An icon is added using CSS depending on the value of aria-expanded.
 *
 * @since WEP 1.0
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 */


class WEP_Menu {

    public function __construct() {
        // add_filter('walker_nav_menu_start_el', [$this, 'wep_add_sub_menu_toggle'], 10, 4);
        // add_filter('walker_nav_menu_start_el', [$this, 'wep_nav_menu_social_icons'], 10, 4);
        // add_filter('nav_menu_item_args', [$this, 'wep_add_menu_description_args'], 10, 3);

        /* Lưu cấu trúc menu chính ra file JSON mỗi khi update menu */
        add_action('wp_update_nav_menu', array($this, 'save_menu_to_json'), 20);

        /** 
         * Lưu cấu trúc menu chính ra file JSON mỗi khi update thành phần liên quan Menu
         * Category
         * Post
         * Product         
         */
    }

    // Lưu nội dung Menu ra JSON
    public function save_menu_to_json() {

        // Lấy data
        $wep_menu_data = WEP_Menu_Model::get_menu_data(0);

        // Lưu giá trị của các option vào file json
        $this->save_json($wep_menu_data, 'menu.json');
    }

    // Phương thức lưu giá trị của các option vào file json
    public function save_json($options, $file_name) {

        // Chuyển mảng thành chuỗi JSON
        $json = json_encode($options);

        // Lưu chuỗi JSON vào file
        file_put_contents(THEME_CONFIG . '/option-json/' . $file_name, $json);
    }

    // Lấy nội dung đệ quy toàn bộ
    static function get_menu_items_recursive($menu_items, $parent_id = 0) {
        $menu = array();
        if ($menu_items) {
            foreach ($menu_items as $menu_item) {
                if ($menu_item->menu_item_parent == $parent_id) {
                    $menu_item_id = $menu_item->ID;
                    $menu_item_title = $menu_item->title;
                    $menu_item_url = $menu_item->url;
                    $menu_item_classes = $menu_item->classes;
                    $sub_menu = self::get_menu_items_recursive($menu_items, $menu_item_id);

                    $menu[] = array(
                        'id' => $menu_item_id,
                        'title' => $menu_item_title,
                        'url' => $menu_item_url,
                        'sub_menu' => $sub_menu,
                        'classes' => $menu_item_classes,
                        'mega' => get_field('mega_menu_show', $menu_item_id),
                        'mega_items' => get_field('mega_menu_tab', $menu_item_id),
                        'column' => get_field('mega_menu_column', $menu_item_id),
                        'column_number' => get_field('mega_menu_column_number', $menu_item_id),
                    );
                }
            }
        }
        return $menu;
    }


    // Lấy nội dung menu đơn giản
    static function get_menu_simple_items($menu_name) {
        $result_menu = array();

        // đối tượng menu
        $menu = wp_get_nav_menu_object($menu_name);

        // Kiểm tra nếu menu tồn tại
        if ($menu) {
            // Lấy danh sách các mục trong menu
            $menu_items = wp_get_nav_menu_items($menu->term_id);

            // In danh sách các mục trong menu        
            foreach ($menu_items as $item) {
                $result_menu[] = array(
                    'link' => $item->url,
                    'title' => $item->title
                );
            }
        }

        return $result_menu;
    }

    // Lấy nội dung menu đơn giản theo ID
    static function get_menu_items_by_id($menu_id) {
        $result_menu = array();

        // Lấy danh sách các mục trong menu
        $menu_items = wp_get_nav_menu_items($menu_id);

        // In danh sách các mục trong menu
        foreach ($menu_items as $item) {
            $result_menu[] = array(
                'link' => $item->url,
                'title' => $item->title
            );
        }

        return $result_menu;
    }


    // Add submenu toggle
    function wep_add_sub_menu_toggle($output, $item, $depth, $args) {
        if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {

            // Add toggle button.
            $output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="twentytwentyoneExpandSubMenu(this)">';
            $output .= '<span class="icon-plus">' . wep_get_icon_svg('ui', 'plus', 18) . '</span>';
            $output .= '<span class="icon-minus">' . wep_get_icon_svg('ui', 'minus', 18) . '</span>';
            /* translators: Hidden accessibility text. */
            $output .= '<span class="screen-reader-text">' . esc_html__('Open menu', 'dvdt') . '</span>';
            $output .= '</button>';
        }

        return apply_filters('wep_sub_menu_toggle',  $output);
    }

    /**
     * Detects the social network from a URL and returns the SVG code for its icon.
     *
     * @since WEP 1.0
     *
     * @param string $uri  Social link.
     * @param int    $size The icon size in pixels.
     * @return string
     */
    function wep_get_social_link_svg($uri, $size = 24) {
        return WEP_SVG_Icons::get_social_link_svg($uri, $size);
    }

    /**
     * Displays SVG icons in the footer navigation.
     *
     * @since WEP 1.0
     *
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $item        Menu item data object.
     * @param int      $depth       Depth of the menu. Used for padding.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     * @return string The menu item output with social icon.
     */
    function wep_nav_menu_social_icons($item_output, $item, $depth, $args) {
        // Change SVG icon inside social links menu if there is supported URL.
        if ('footer' === $args->theme_location) {
            $svg = wep_get_social_link_svg($item->url, 24);
            if (!empty($svg)) {
                $item_output = str_replace($args->link_before, $svg, $item_output);
            }
        }

        return $item_output;
    }


    /**
     * Filters the arguments for a single nav menu item.
     *
     * @since WEP 1.0
     *
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param WP_Post  $item  Menu item data object.
     * @param int      $depth Depth of menu item. Used for padding.
     * @return stdClass
     */
    function wep_add_menu_description_args($args, $item, $depth) {
        if ('</span>' !== $args->link_after) {
            $args->link_after = '';
        }

        if (0 === $depth && isset($item->description) && $item->description) {
            // The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
            $args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
        }

        return $args;
    }
}
