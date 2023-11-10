<?php

/**
 * ACF WEP Page Field
 *
 * @package ACF WEP Page Field
 */

/* Exit if accessed directly */
if (!defined('ABSPATH')) {
	exit;
}

/**
 * WEP_ACF_Field_Page Class
 *
 * This class contains all the custom workings for the WEP Page Field for ACF
 */
class WEP_ACF_Field_Page extends acf_field {

	/**
	 * Sets up some default values and delegats work to the parent constructor.
	 * This function shows page menu field into the acf field type.
	 */
	public function __construct() {
		$this->name     = 'page_list';
		$this->label    = esc_html__('WEP Page', 'acf-page-list');
		$this->category = 'choice';
		$this->defaults = array(
			'save_format' => 'menu',
			'allow_null'  => 0,
			'container'   => 'div',
		);
		parent::__construct();

		/* Enqueue CSS */
		add_action('admin_enqueue_scripts', array($this, 'acnmf_enqueue_style'));
	}

	// CSS
	public function acnmf_enqueue_style() {
		wp_enqueue_style('acnmf-backend', THEME_APP . '/assets/css/acnmf-backend.css');
	}

	/**
	 * Renders the ACF WEP Page Field options seen when editing a WEP Page Field.
	 *
	 * @param array $field The array representation of the current WEP Page Field.
	 */
	public function render_field_settings($field) {
		// Register the Return Value format setting
		acf_render_field_setting($field, array(
			'label'        => esc_html__('Return Value', 'acf-page-list'),
			'instructions' => esc_html__('Specify the returned value on front end', 'acf-page-list'),
			'type'         => 'radio',
			'name'         => 'save_format',
			'layout'       => 'horizontal',
			'choices'      => array(
				'template'   => esc_html__('Template File', 'acf-page-list'),
				'content'   => esc_html__('Page Content', 'acf-page-list'),
				'name'   => esc_html__('Page Name', 'acf-page-list'),
				'slug' => esc_html__('Page Slug', 'acf-page-list'),
				'id'     => esc_html__('Page ID', 'acf-page-list'),
			),
		));

		// Register the Page Container setting
		acf_render_field_setting($field, array(
			'label'        => esc_html__('Page Container', 'acf-page-list'),
			'instructions' => esc_html__("What to wrap the Menu's ul with (when returning Content only)", 'acf-page-list'),
			'type'         => 'select',
			'name'         => 'container',
			'choices'      => $this->get_allowed_page_container_tags(),
		));

		// Register the Allow Null setting
		acf_render_field_setting($field, array(
			'label'        => esc_html__('Allow Null?', 'acf-page-list'),
			'type'         => 'radio',
			'name'         => 'allow_null',
			'layout'       => 'horizontal',
			'choices'      => array(
				1 => esc_html__('Yes', 'acf-page-list'),
				0 => esc_html__('No', 'acf-page-list'),
			),
		));
	}

	/**
	 * Get the allowed wrapper tags for use with wp_page_list().
	 *
	 * @return array An array of allowed wrapper tags.
	 */
	private function get_allowed_page_container_tags() {
		$tags           = apply_filters('wp_page_list_container_allowedtags', array('div', 'page'));
		$formatted_tags = array(
			'0' => 'None',
		);
		foreach ($tags as $tag) {
			$formatted_tags[$tag] = ucfirst($tag);
		}
		return $formatted_tags;
	}

	/**
	 * Renders the ACF WEP Page Field.
	 *
	 * @param array $field The array representation of the current WEP Page Field.
	 */
	public function render_field($field) {
		$allow_null = $field['allow_null'];
		$page_lists  = $this->get_page_lists($allow_null);
		if (empty($page_lists)) {
			return;
		}
?>
		<div class="custom-acf-page-list">
			<select id="<?php esc_attr($field['id']); ?>" class="<?php echo esc_attr($field['class']); ?>" name="<?php echo esc_attr($field['name']); ?>">
				<option value="0">- Mặc định -</option>
				<?php foreach ($page_lists as $page_list_id => $page_list_name) : ?>
					<option value="<?php echo esc_attr($page_list_id); ?>" <?php selected($field['value'], $page_list_id); ?>>
						<?php echo esc_html($page_list_name) . " (ID: $page_list_id)"; ?>
					</option>
				<?php endforeach; ?>

			</select>
		</div>
<?php
	}
	/**
	 * Gets a list of ACF WEP Pages indexed by their WEP Page IDs.
	 *
	 * @param bool $allow_null If true, prepends the null option.
	 *
	 * @return array An array of WEP Pages indexed by their WEP Page IDs.
	 */
	private function get_page_lists($allow_null = false) {
		$pages = get_pages();
		$page_lists = array();
		if ($allow_null) {
			$page_lists[''] = esc_html__('- Select -', 'acf-page-list');
		}
		foreach ($pages as $page) {
			$page_lists[$page->ID] = $page->post_title;
		}
		return $page_lists;
	}

	/**
	 * Renders the ACF WEP Page Field.
	 *
	 * @param int   $value   The WEP Page ID selected for this WEP Page Field.
	 * @param int   $post_id The Post ID this $value is associated with.
	 * @param array $field   The array representation of the current WEP Page Field.
	 *
	 * @return mixed The WEP Page ID, or the WEP Page HTML, or the WEP Page Object, or false.
	 */
	public function format_value($value, $post_id, $field) {
		// bail early if no value
		if (empty($value)) {
			return false;
		}

		$wp_page_object = get_post($value);
		if (empty($wp_page_object)) {
			return false;
		}
		$page_object = new stdClass;
		$page_object->ID    = $wp_page_object->ID;
		$page_object->name  = $wp_page_object->post_title;
		$page_object->slug  = $wp_page_object->post_name;
		$page_object->content  = $wp_page_object->post_content;
		$page_object->template  = WEP_Helper::get_template_file_by_page_id($wp_page_object->ID);

		// check format
		if ('object' == $field['save_format']) {
			return $page_object;
		} elseif ('content' == $field['save_format']) {
			ob_start();
			echo $page_object->content;
			return ob_get_clean();
		} elseif ('slug' == $field['save_format']) {
			return $page_object->slug;
		} elseif ('name' == $field['save_format']) {
			return $page_object->name;
		} elseif ('template' == $field['save_format']) {
			return $page_object->template;
		}
		// Just return the WEP Page ID
		return $value;
	}
	function load_value($value, $post_id, $field) {
		return $value;
	}
}
