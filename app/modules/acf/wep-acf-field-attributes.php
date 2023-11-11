<?php

class WEP_ACF_Field_Attributes extends acf_field {
	function __construct() {
		$this->name = 'wep_attributes';
		$this->label = __('WEP Attributes', 'acf');
		$this->category = 'choice';
		parent::__construct();
	}

	function render_field($field) {
		$attributes = WEP_Product_Model::get_woocommerce_attributes();
		if (!empty($attributes)) {
			foreach ($attributes as $name => $label) {
				$checked = '';
				if (is_array($field['value']) && in_array($name, $field['value'])) {
					$checked = ' checked="checked"';
				}
				echo '<input type="checkbox" name="' . esc_attr($field['name']) . '[]" value="' . esc_attr($name) . '"' . $checked . '> ' . esc_html($label) . '<br>';
			}
		}
	}
}
