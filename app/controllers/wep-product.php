<?php


/* Class Product */
class WEP_Product {

    public function __construct() {

        /* Action */
    }

    /* Create Tab Description */
    static function create_product_tab($action) {
        do_action($action);
    }

    /* Render Tab Description */
    static function render_product_tab($data_tab = array()) {
        foreach ($data_tab as $key => $values) {
            extract($values);
            add_action($action, array('WEP_Product_View', $callback), $priority);
        }
    }
}
