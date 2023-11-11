<?php
/**
 * Class base of View
 *
 * This class provides methods for loading and displaying view templates with options and data.
 * It also includes functionality for initializing the template directory and handling buttons.
 *
 * @since 1.0.0
 */
if (!defined('ABSPATH')) return;

class WEP_View {

    static $_template_dir;

    /**
     * Initializes the template directory.
     *
     * @return void
     */
    static function init() {
        self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/parts');
    }

    /**
     * Gets the current template directory.
     *
     * @return string The current template directory.
     */
    static function get_template_dir() {
        return self::$_template_dir;
    }

    /**
     * Returns the CSS classes for a button based on its type.
     *
     * @param string $button_type The type of the button ('gradient', 'outline', 'white', 'link').
     * @return string The CSS classes for the button.
     */
    static function get_button_classes($button_type) {
        if ($button_type == 'gradient') {
            return 'wep_button wep_button--readmore';
        }

        if ($button_type == 'outline') {
            return 'wep_button wep_button--readmore wep_button--outline';
        }

        if ($button_type == 'white') {
            return 'wep_button wep_button--readmore wep_button--white';
        }

        if ($button_type == 'link') {
            return 'wep_link wep_link--readmore';
        }
    }

    /**
     * Returns the CSS class for button color based on its type.
     *
     * @param string $button_type The type of the button ('gradient', 'outline', 'white', 'link').
     * @return string The CSS class for the button color.
     */
    static function get_button_color_classes($button_type) {
        if ($button_type == 'gradient') {
            return 'white';
        }

        // else gradient
        return 'gradient';
    }

    /**
 * Gets the SVG code for a given icon.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param string $group The icon group.
 * @param string $icon  The icon.
 * @param int    $size  The icon size in pixels.
 * @return string
 */
function wep_get_icon_svg( $group, $icon, $size = 24 ) {
	return WEP_SVG_Icons::get_svg( $group, $icon, $size );
}

    /**
     * Load and optionally return the content of a view template.
     *
     * @param string $view_name    The name of the view template file.
     * @param string|bool $slug    An optional slug to differentiate between view templates with the same name.
     * @param array $data          An array of data to pass to the view template.
     * @param bool $echo           Whether to echo the template content (default is TRUE).
     * @param string|bool $template_dir An optional template directory to use instead of the default.
     * @param string $type         The file extension for the template (default is '.php').
     * @return string|void The rendered template content if $echo is FALSE, otherwise, it is echoed directly.
     * 
     * Example usage:
     * ```
     * $viewData = array('data1' => 'value1', 'data2' => 'value2');
     * WEP_View::make_view('template-name', 'slug', $viewData, TRUE, 'custom-templates', '.html');
     * ```
     */
    static function make_view($view_name, $slug = false, $data = array(), $echo = TRUE, $template_dir = false, $type = '.php') {

        if (!empty($template_dir)) self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/' . $template_dir);
        else self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/parts');
        $template_path = get_template_directory();
        $stylesheet_path = get_stylesheet_directory();

        if ($slug) {
            $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . '-' . $slug . $type;
            if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
            else $template =  get_template_directory() . self::$_template_dir . '/' . $view_name . '-' . $slug . $type;
            if (!is_file($template)) {
                $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . $type;
                if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
                else $template = get_template_directory() . self::$_template_dir . '/' . $view_name . $type;
            }
        } else {
            $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . $type;
            if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
            else $template = get_template_directory() . self::$_template_dir . '/' . $view_name . $type;
        }

        // Allow View be filter
        $template = apply_filters('wep_load_view', $template, $view_name, $slug);

        if ($data) extract($data);

        if (file_exists($template)) {

            if (!$echo) {

                ob_start();
                include $template;
                return @ob_get_clean();
            } else

                include $template;
        }
    }

    /**
     * Display a view template with provided options and data.
     *
     * @param string $view_name    The name of the view template file.
     * @param string|bool $slug    An optional slug to differentiate between view templates with the same name.
     * @param array $data          An array of data to pass to the view template.
     * @param bool $echo           Whether to echo the template content (default is TRUE).
     * @param string|bool $template_dir An optional template directory to use instead of the default.
     * @param string $type         The file extension for the template (default is '.php').
     * @return void
     * 
     * Example usage:
     * ```
     * $viewOptions = array('option1' => 'value1', 'option2' => 'value2');
     * $viewData = array('data1' => 'value1', 'data2' => 'value2');
     * WEP_View::show_view('template-name', 'slug', $viewData, TRUE, 'custom-templates', '.html');
     * ```
     */
    static function show_view($view_name, $slug = false, $data = array(), $echo = TRUE, $template_dir = false, $type = '.php') {

        if (!empty($template_dir)) self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/' . $template_dir);
        else self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/parts');
        $template_path = get_template_directory();
        $stylesheet_path = get_stylesheet_directory();

        if ($slug) {
            $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . '-' . $slug . $type;
            if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
            else $template =  get_template_directory() . self::$_template_dir . '/' . $view_name . '-' . $slug . $type;
            if (!is_file($template)) {
                $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . $type;
                if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
                else $template = get_template_directory() . self::$_template_dir . '/' . $view_name . $type;
            }
        } else {
            $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . $type;
            if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
            else $template = get_template_directory() . self::$_template_dir . '/' . $view_name . $type;
        }

        // Allow View be filter
        $template = apply_filters('wep_load_view', $template, $view_name, $slug);

        if ($data) extract($data);

        if (file_exists($template)) {

            if (!$echo) {

                ob_start();
                include $template;
                return @ob_get_clean();
            } else

                include $template;
        }
    }

    /**
     * Display a view template with provided options and data.
     *
     * @param string $view_name    The name of the view template file.
     * @param array $option        An array of options for customizing the view.
     * @param array $data          An array of data to pass to the view template.
     * @param string|bool $slug    An optional slug to differentiate between view templates with the same name.
     * @param bool $echo           Whether to echo the template content (default is TRUE).
     * @param string|bool $template_dir An optional template directory to use instead of the default.
     * @param string $type         The file extension for the template (default is '.php').
     * @return void
     * 
     * Example usage:
     * ```
     * $viewOptions = array('option1' => 'value1', 'option2' => 'value2');
     * $viewData = array('data1' => 'value1', 'data2' => 'value2');
     * WEP_View::display_view('template-name', $viewOptions, $viewData, 'slug', TRUE, 'custom-templates', '.html');
     * ```
     */
    static function display_view($view_name, $option = array(), $data = array(), $slug = false, $echo = TRUE, $template_dir = false, $type = '.php') {
        // Display content view - CONTINUE CODE HERE
        if (!empty($template_dir)) self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/' . $template_dir);
        else self::$_template_dir = apply_filters('WEP_Part_View_Part_Dir', '/parts');
        $template_path = get_template_directory();
        $stylesheet_path = get_stylesheet_directory();

        if ($slug) {
            $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . '-' . $slug . $type;
            if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
            else $template =  get_template_directory() . self::$_template_dir . '/' . $view_name . '-' . $slug . $type;
            if (!is_file($template)) {
                $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . $type;
                if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
                else $template = get_template_directory() . self::$_template_dir . '/' . $view_name . $type;
            }
        } else {
            $path = $stylesheet_path . self::$_template_dir . '/' . $view_name . $type;
            if ($template_path != $stylesheet_path && is_file($path)) $template = $path;
            else $template = get_template_directory() . self::$_template_dir . '/' . $view_name . $type;
        }

        // Allow View be filter
        $template = apply_filters('wep_load_view', $template, $view_name, $slug);

        if ($data) extract($data);
        if ($option) extract($option);

        if (file_exists($template)) {

            if (!$echo) {

                ob_start();
                include $template;
                return @ob_get_clean();
            } else

                include $template;
        }
    }
}
