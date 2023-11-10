<?php

/* Page Base Class */

class WEP_Page_Base {

    private $action_function_prefix = "render_";
    private $action_position_before_prefix = "before_";
    private $action_position_after_prefix = "after_";

    /* 
    * Array define postion 
    * 'none' => just main position
    * 'all' => all postion main, before and after
    *  array => main position and all postions in array is prefix: array('befor', 'after', 'start', 'end',...)
    */
    private $action_positions = array();

    // Render content home
    public function render_wep_home_content() {

        get_template_part('parts/home/select', 'device', array('heading' => 'Lựa chọn thiết bị cần sửa chữa'));
        get_template_part('parts/home/service', 'device', array('heading' => 'Sửa iPhone'));
        get_template_part('parts/home/service', 'device', array('heading' => 'Sửa Apple Watch'));
        get_template_part('parts/home/service', 'device', array('heading' => 'Sửa điện thoại Samsung'));
        get_template_part('parts/home/product', 'accessory', array('heading' => '9. Phụ kiện'));
        get_template_part('parts/home/news', 'featured', array('heading' => '10. Tin tức công nghệ'));

        WEP_Tag::render_bs_tag('container p-0');
        WEP_Tag::render_bs_tag('row');

        get_template_part('parts/home/news', 'haft', array('category' => 'guide'));

        get_template_part('parts/home/news', 'haft', array('category' => 'service'));
        WEP_Tag::render_bs_close_tag();
        WEP_Tag::render_bs_close_tag();
    }

    // Before Content
    public function render_wep_before_home_content() {

        // #WEP Main
        WEP_Tag::render_bs_tag(['id' => 'wep_main', 'class' => 'shadow',]);

        // Begin Container
        WEP_Tag::render_bs_tag(['class' => 'container']);
    }

    // After Content
    public function render_wep_after_home_content() {

        // End of container
        WEP_Tag::render_bs_close_tag();

        // End #WEP Main
        WEP_Tag::render_bs_close_tag();
    }


    /* ========= All get methods output to page template ============== */

    // Get Content
    static public function get_content() {

        /**
         * Hook: wep_before_home_content.
         *
         * @hooked render_wep_before_home_content
         */
        do_action('wep_before_home_content');

        /**
         * Hook: wep_home_content.
         *
         * @hooked render_wep_home_content
         */
        do_action('wep_home_content');

        /**
         * Hook: wep_after_home_content.
         *
         * @hooked render_wep_after_home_content
         */
        do_action('wep_after_home_content');
    }

    /* Init */
    public function __construct($page_positions = []) {

        $this->action_positions = $page_positions;

        // Attach template with place holder - wep action
        foreach ($this->action_positions as $action_name => $other_pos) {

            $method_name = $this->action_function_prefix . $action_name;

            // Befor and After
            $before_action_name = str_replace('wep_', 'wep_' . $this->action_position_before_prefix, $action_name);
            $after_action_name = str_replace('wep_', 'wep_' . $this->action_position_after_prefix, $action_name);
            $before_method_name = $this->action_function_prefix . $before_action_name;
            $after_method_name = $this->action_function_prefix . $after_action_name;

            // Other prefix
            $other_action_name = str_replace('wep_', 'wep_' . $other_pos, $action_name);
            $other_method_name = $this->action_function_prefix . $other_action_name;

            // Main Action
            if (method_exists($this, $method_name)) {
                add_action($action_name, array($this, $method_name));
            } else {
                echo printf("<p class='wep_notice'>Phương thức <strong>%s</strong> chưa tồn tại trong class hiện tại.</p>", $method_name);
            }

            if (!is_array($other_pos)) :

                // Attach Position after and before
                if ($other_pos === 'all') :
                    // Before Position
                    if (method_exists($this, $before_method_name)) {
                        add_action($before_action_name, array($this, $before_method_name));
                    } else {
                        echo printf("<p class='wep_notice'>Phương thức <strong>%s</strong> chưa tồn tại trong class hiện tại.</p>", $before_method_name);
                    }

                    // After Position
                    if (method_exists($this, $after_method_name)) {
                        add_action($after_action_name, array($this, $after_method_name));
                    } else {
                        echo printf("<p class='wep_notice'>Phương thức <strong>%s</strong> chưa tồn tại trong class hiện tại.</p>", $after_method_name);
                    }
                else : // prefix

                    // Other Position
                    if (method_exists($this, $other_method_name)) {
                        add_action($other_action_name, array($this, $other_method_name));
                    } else {
                        echo printf("<p class='wep_notice'>Phương thức <strong>%s</strong> chưa tồn tại trong class hiện tại.</p>", $other_method_name);
                    }
                endif;

            else : // if array create main and all postion prefix                

                // Prefix
                $all_prefix = $other_pos;
                foreach ($all_prefix as $prefix) {

                    $prefix_action_name = str_replace('wep_', 'wep_' . $prefix, $action_name);
                    $prefix_method_name = $this->action_function_prefix . $prefix_action_name;

                    if (method_exists($this, $prefix_method_name)) {
                        add_action($prefix_action_name, array($this, $prefix_method_name));
                    } else {
                        echo printf("<p class='wep_notice'>Phương thức <strong>%s</strong> chưa tồn tại trong class hiện tại.</p>", $prefix_method_name);
                    }
                }

            endif;
        }
    }
}
