<?php

/** 
 * Class for one Section View
 *
 * This class provides methods for rendering sections with various options.
 */
class WEP_Section_View {

    /**
     * Render a section using a template, option, and data.
     *
     * @param string $template The name of the template file.
     * @param array $option An array of options for customizing the section.
     * @param array $data An array of data to be used within the template.
     * @return void
     */
    public function render($template, $option, $data) {
        // Check if template is provided and options and data are arrays
        if (($template) && is_array($option) && is_array($data)) {
            // Display the template section
            WEP_Part_View::display_view($template, $option, $data);
        }
    }

    /**
     * Render the closing tag of a section.
     *
     * @param string $tag_name The HTML tag name (default is 'section').
     * @return void
     */
    static function render_close_tag($tag_name = 'section') {
        printf('</%s>', $tag_name);
    }

    /**
     * Render the opening <section> tag with specified styles and classes.
     *
     * @param array $option An array of options for customizing the section.
     * @param string $input_classes Additional CSS classes to apply.
     * @return void
     */
    static function render_section_tag($option, $input_classes = '') {
        // Split array into variables
        extract($option);

        // Spacing
        $section_top_space = '';
        $section_bottom_space = '';
        if ($wep_section_custom_style) {
            $section_top_space = sprintf('padding-top: %dpx;', $wep_section_top_space);
            $section_bottom_space = sprintf('padding-bottom: %dpx;', $wep_section_bottom_space);
        }

        // CSS       
        $bg_section_dark = $wep_background_dark ? 'wep_bg_dark' : '';
        $background_color = ($wep_background_color != false) && ($wep_background_color != '')  ? 'background-color:' . $wep_background_color . ';' : '';
        $bg_section_fixed = $wep_background_attachment ? 'background-attachment:fixed;' : '';

        $bg_section_css = sprintf(
            '%s background-image: url(%s); %s background-position-x: %s; background-position-y: %s; background-repeat: %s; background-size: %s;',
            $background_color,
            $wep_background_src,
            $bg_section_fixed,
            $wep_background_align_x,
            $wep_background_align_y,
            $wep_background_repeat,
            $wep_background_size
        );

        // Effect
        $item_stay_attr = $wep_section_effect_stay ? 'data-aos-once="true"' : 'data-aos-once="false"';
        $section_effect = $wep_section_effect == 'wep_section_effect' ? '' : sprintf('%s data-aos="%s" data-aos-offset="200"', $item_stay_attr, $wep_section_effect);
        $section_track_this = $wep_section_is_anchor ? 'trackThis' : '';
        printf(
            '<section id="%s" class="%s %s %s %s" %s style="%s %s %s %s">',
            $wep_section_id,
            $wep_section_classes,
            $input_classes,
            $bg_section_dark,
            $section_track_this,
            $section_effect,
            $bg_section_css,
            $section_top_space,
            $section_bottom_space,
            $wep_section_custom_css
        );
    }

    /**
     * Render a button with specified options.
     *
     * @param array $option An array of options for customizing the button.
     * @return void
     */
    static function render_button($option) {
        // Split array into variables
        extract($option);

        $button_target = $wep_button_target ? 'target="_blank"' : '';
        $button_style = ($wep_button_style == 'default') ? '' : $wep_button_style;

        printf(
            '<a href="%s" class="wep_button %s" %s>%s</a>',
            $wep_button_link,
            $button_style,
            $button_target,
            $wep_button_name
        );
    }

    /**
     * Render a section's heading and description with specified options.
     *
     * @param array $option An array of options for customizing the heading and description.
     * @return void
     */
    static function render_section_heading_desc($option) {
        // Split array into variables
        extract($option);

        $heading_color = $wep_heading_color || ($wep_heading_color == '') ? '' : 'color:' . $wep_heading_color . ';';
        $heading_margin_bottom = ($wep_heading_margin_bottom == 'default') ? '' : $wep_heading_margin_bottom;
        $text_align = 'text-start';
        if ($wep_heading_align == 'justify-content-center') {
            $text_align = 'text-center';
        };
        if ($wep_heading_align == 'justify-content-end') {
            $text_align = 'text-end';
        };

        // Effects Heading
        $heading_effects = '';
        $item_stay_attr = $wep_section_effect_stay ? 'data-aos-once="true"' : 'data-aos-once="false"';
        if ($wep_section_item_effect) {
            $heading_effects = sprintf('%s data-aos="%s" data-aos-duration="%s" data-aos-delay="%s"', $item_stay_attr, $wep_section_effect_heading_desc, $wep_section_effect_duration, $wep_section_effect_delay);
        }

        printf(
            '<%s class="wep_heading %s %s %s" %s style="%s">%s</%s>',
            $wep_heading_tag,
            $wep_heading_align,
            $text_align,
            $heading_margin_bottom,
            $heading_effects,
            $heading_color,
            $wep_heading_text,
            $wep_heading_tag
        );

        // Effects Description
        $description_effects = '';
        $description_delay = $wep_section_effect_delay + $wep_section_effect_delay_interval;
        if ($wep_section_item_effect) {
            $description_effects = sprintf('%s data-aos="%s" data-aos-duration="%s" data-aos-delay="%s"', $item_stay_attr, $wep_section_effect_heading_desc, $wep_section_effect_duration, $description_delay);
        }

        if ($wep_description_text != '') {
            $description_color = $wep_description_color || ($wep_description_color == '')  ? '' : 'color:' . $wep_description_color . ';';
            $description_margin_bottom = ($wep_description_margin_bottom == 'default') ? '' : $wep_description_margin_bottom;
            printf(
                '<%s class="wep_description %s %s" %s style="%s line-height:%s; font-size:%spx">%s</%s>',
                $wep_description_tag,
                $wep_description_align,
                $description_margin_bottom,
                $description_effects,
                $description_color,
                $wep_description_line_height,
                $wep_description_font_size,
                $wep_description_text,
                $wep_description_tag
            );
        }
    }

    /**
     * Render AOS (Animate on Scroll) settings for each item.
     *
     * @param array $option An array of options for customizing the item's AOS settings.
     * @param int $show_order The order in which item groups are displayed.
     * @param int $run_order The actual order in which items within a group are run, typically their position in the group.
     * @return void
     */
    static function render_item_aos($option, $show_order, $run_order) {
        // Split array into variables
        extract($option);

        $item_effects = '';
        $item_stay_attr = $wep_section_effect_stay ? 'data-aos-once="true"' : 'data-aos-once="false"';
        $item_delay = $show_order * $wep_section_effect_delay_interval + $wep_section_effect_delay_interval * $run_order;
        if ($wep_section_item_effect) {
            $item_effects = sprintf('%s data-aos="%s" data-aos-duration="%s" data-aos-delay="%s"', $item_stay_attr, $wep_section_effect_item, $wep_section_effect_duration, $item_delay);
        }

        printf($item_effects);
    }

    /**
     * Display a hint indicating the template being used.
     *
     * @param string $template The name of the template file.
     * @return void
     */
    public function show_hint($template) {
        global $current_page;

        if (SHOW_HINT) {
            $text = '<div class="wep_template_hint"><span class="wep_template_hint__content">';
            $text .= $current_page;
            $text .= '@';
            $text .= WEP_Part_View::get_template_dir();
            $text .= '/' . $template;
            $text .= '.php</span></div>';
            echo $text;
        }
    }

    /* Render image with size */
    static function render_image_with_sizes($image_url, $alt = '', $atts = array('loading' => 'lazy', 'decoding' => 'async'), $class = 'img-fluid') {
        // Lấy thông tin chiều rộng và chiều cao từ URL hình ảnh
        list($width, $height) = getimagesize($image_url);
        $attachment_id = attachment_url_to_postid($image_url);
        $image_attributes = wp_get_attachment_image_src($attachment_id, 'full');
        $image_src = $image_attributes[0];
        $image_srcset = wp_get_attachment_image_srcset($attachment_id, 'full');
        $image_sizes = '(max-width: ' . $width . 'px) 100vw, ' . $width . 'px';

        // Gộp các thuộc tính cần bổ sung với mảng thuộc tính gốc
        $merged_atts = array_merge($atts, array(
            'class' => $class,
            'alt' => $alt,
            'srcset' => $image_srcset,
            'sizes' => $image_sizes,
        ));

        // Sử dụng wp_get_attachment_image với các thuộc tính đã gộp
        $img_html = wp_get_attachment_image($attachment_id, array($width, $height), false, $merged_atts);
        echo $img_html;
    }
}
