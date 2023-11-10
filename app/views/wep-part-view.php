<?php

/** 
 * Class for View template part
 */

class WEP_Part_View extends WEP_View {

    // Render cơ bản view
    public function render($template, $data) {
        get_template_part($template);
    }

    // Hiện view
    public function get_view($template, $data) {
        parent::make_view($template, '', $data);
    }

    // Hiện sidebar
    static function show_sidebar($sidebar_id) {
        if (is_active_sidebar($sidebar_id)) {
            dynamic_sidebar($sidebar_id);
        }
    }    
}
