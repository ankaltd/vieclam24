
<?php

class WEP_Product_View {

    /* Hiển thị danh sách thuộc tính sản phẩm */
    static function wep_display_product_attributes($product_id = null) {

        $pid = get_the_ID();
        if (!is_null($product_id)) :
            $pid = $product_id;
        endif;

        // lấy đối tượng sản phẩm woocommerce
        $product = wc_get_product($pid);

        $product_attributes = array();

        // Display weight and dimensions before attribute list.
        $display_dimensions = apply_filters('wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions());

        if ($display_dimensions && $product->has_weight()) {
            $product_attributes['weight'] = array(
                'label' => __('Weight', 'woocommerce'),
                'value' => wc_format_weight($product->get_weight()),
            );
        }

        if ($display_dimensions && $product->has_dimensions()) {
            $product_attributes['dimensions'] = array(
                'label' => __('Dimensions', 'woocommerce'),
                'value' => wc_format_dimensions($product->get_dimensions(false)),
            );
        }

        // Add product attributes to list.
        $attributes = array_filter($product->get_attributes(), 'wc_attributes_array_filter_visible');

        foreach ($attributes as $attribute) {
            $values = array();

            if ($attribute->is_taxonomy()) {
                $attribute_taxonomy = $attribute->get_taxonomy_object();
                $attribute_values   = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

                foreach ($attribute_values as $attribute_value) {
                    $value_name = esc_html($attribute_value->name);

                    if ($attribute_taxonomy->attribute_public) {
                        $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                    } else {
                        $values[] = $value_name;
                    }
                }
            } else {
                $values = $attribute->get_options();

                foreach ($values as &$value) {
                    $value = make_clickable(esc_html($value));
                }
            }

            $product_attributes['attribute_' . sanitize_title_with_dashes($attribute->get_name())] = array(
                'label' => wc_attribute_label($attribute->get_name()),
                'value' => apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values),
            );
        }

        /**
         * Hook: woocommerce_display_product_attributes.
         *
         * @since 3.6.0.
         * @param array $product_attributes Array of attributes to display; label, value.
         * @param WC_Product $product Showing attributes for this product.
         */
        $product_attributes = apply_filters('woocommerce_display_product_attributes', $product_attributes, $product);


        // Lấy Template Bảng thuộc tính 
        get_template_part(
            'parts/single-product/product', 'attributes', 
            array(
                'id' => $product_id,
                'product_attributes' => $product_attributes,
                // Legacy params.
                'product'            => $product,
                'attributes'         => $attributes,
                'display_dimensions' => $display_dimensions,
            )
        );   
    }

    // Description Tab Content
    static function render_wep_product_description_tab() {
        get_template_part('parts/single-product/tabs/description');
    }

    // Information Tab Content
    static function wep_product_more_information_tab() {
        get_template_part('parts/single-product/tabs/more-information');
    }

    // Warranty Policy Content
    static function render_wep_product_warranty_policy_tab() {
        get_template_part('parts/single-product/tabs/warranty-policy');
    }

    // Pricing Table Content
    static function render_wep_product_pricing_table_tab() {
        get_template_part('parts/single-product/tabs/pricing-table');
    }

    // Specifications Content
    static function render_wep_product_specifications_tab() {
        get_template_part('parts/single-product/tabs/specifications');
    }
}
