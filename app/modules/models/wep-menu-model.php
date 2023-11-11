<?php
/* Menu Model Class */

class WEP_Menu_Model {
    /**
     * Lấy menu dựa trên ID và toàn bộ các mục con của nó.
     *
     * @param int $menu_id ID của menu cần lấy.
     * @return array Cấu trúc dữ liệu của menu và tất cả các mục con của nó.
     */
    public static function get_menu_by_id($menu_id) {
        $menu_items = wp_get_nav_menu_items($menu_id);
        $menu = array();
        foreach ($menu_items as $item) {
            $menu[$item->ID] = array(
                'ID' => $item->ID,
                'title' => $item->title,
                'link' => $item->url,
                'parent' => $item->menu_item_parent,
                'sub_menu' => array(),
                'icon_tye' => get_field('wep_menu_icon_style',$item->ID),
                'icon_img' => get_field('wep_menu_icon_image',$item->ID),
                'icon_svg' => get_field('wep_menu_icon_svg',$item->ID),
            );
        }

        return self::build_menu_tree($menu, 0);
    }

    /**
     * Xây dựng cây menu dựa trên cấu trúc dữ liệu đầu vào.
     *
     * @param array $items Dữ liệu menu đầu vào.
     * @param int $parent ID của menu cha.
     * @return array Cấu trúc cây menu.
     */
    public static function build_menu_tree(&$items, $parent) {
        $branch = array();
        foreach ($items as $item) {
            if ($item['parent'] == $parent) {
                $children = self::build_menu_tree($items, $item['ID']);
                if ($children) {
                    $item['sub_menu'] = $children;
                }
                $branch[$item['ID']] = $item;
                unset($items[$item['ID']]);
            }
        }
        return $branch;
    }

    /**
     * Lấy thông tin về tất cả các menu trong hệ thống WordPress.
     *
     * @return array Thông tin về tất cả các menu.
     */
    public static function get_all_menus() {
        $menus = get_terms('nav_menu', array('hide_empty' => true));
        $locations = get_nav_menu_locations();
        $all_menus = array();
        foreach ($menus as $menu) {
            $menu_location = array_search($menu->term_id, $locations);
            $all_menus[] = array(
                'id' => $menu->term_id,
                'name' => $menu->name,
                'slug' => $menu->slug,
                'location' => $menu_location ? $menu_location : 'Not assigned'
            );
        }
        return $all_menus;
    }

    /**
     * Lấy dữ liệu menu theo yêu cầu và định dạng trả về.
     *
     * @param int $menu_id ID của menu cần lấy.
     * @param bool $json True nếu muốn trả về dưới dạng JSON, False nếu muốn trả về dưới dạng mảng.
     * @return mixed Dữ liệu menu hoặc JSON tùy thuộc vào giá trị của $json.
     */
    static function get_menu_data($menu_id = 0, $json = false) {

        if ($menu_id == 0) {
            // Lấy toàn bộ menu và nội dung menu items cho từng menu.
            $all_menus = self::get_all_menus();
            $menu_data = array();

            foreach ($all_menus as $menu) {
                $menu_id = $menu['id'];
                $menu_items = self::get_menu_by_id($menu_id);
                $menu_data[$menu_id] = $menu_items;
            }
        } else {
            // Lấy nội dung menu items cho menu cụ thể.
            $menu_data = self::get_menu_by_id($menu_id);
        }

        if ($json) {
            // Trả về dưới dạng JSON.
            return json_encode($menu_data);
        } else {
            // Trả về dưới dạng mảng.
            return $menu_data;
        }
    }
}
