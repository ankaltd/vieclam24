<?php

/**
 * WEP Shortcode Class, with functions and filters related to the site shortcode.
 * 
 */

class WEP_Shortcode {

    public function __construct() {

        // Khởi tạo và đăng ký shortcode trong thư mục theme/shortcodes constructor của class
        add_action('init', array($this, 'register_shortcodes'));

        // Thêm shortcode vào trình soạn thảo
        add_action('admin_init', array($this, 'add_shortcode_button'));

        // Thêm shortcode đơn lẻ
        add_shortcode('detail_attributes', array($this, 'render_shortcode_detail_attributes'));

        // Thêm shortcode password Netflix
        add_shortcode('noi_dung_mat_khau', array($this, 'create_shortcode_noi_dung_mat_khau'));

        // Thêm shortcode nổi bật
        add_shortcode('nd_noi_bat', array($this, 'create_shortcode_nd_noi_bat'));


        // Thêm danh sách thành phần ở đây kích hoạt shortcode ở đây
        $this->create_wib_shortcodes();
    }

    // Shortcode nội dung nổi bật
    function create_shortcode_nd_noi_bat($args, $content) {
        ob_start(); ?>
        <div class="mb-3 bg-light p-3 rounded-lg shadow border wep_hightlight"><?= $content ?></div>
<?php $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }

    // Shortcode password
    function create_shortcode_noi_dung_mat_khau($args, $content) {
        ob_start();
        if (!empty($args['mobile'])) {
            $class = ' d-lg-none';
        } elseif (!empty($args['desktop'])) {
            $class = ' d-none d-lg-block';
        } else {
            $class = '';
        }

        $args = array(
            'class' => $class,
            'title' => $args['title'],
            'content' => $content,
            'time' => $args['time'],
        );

        get_template_part('app/lonely-templates/noi-dung-mat-khau', null, $args);

        $list_product = ob_get_contents();
        ob_end_clean();
        return $list_product;
    }

    // Tạo một loạt các shortcode wib
    public function create_wib_shortcodes() {
        // Đường dẫn đến thư mục chứa các tệp class shortcode
        $wib_shortcode_dir = THEME_CONTROLLER . '/';

        // Lấy danh sách tệp trong thư mục
        $files = scandir($wib_shortcode_dir);

        // Mảng để lưu trữ các đối tượng shortcode
        $shortcode_objects = array();

        foreach ($files as $file) {
            // Kiểm tra xem tệp có bắt đầu bằng "wib-" không
            if (strpos($file, 'wib-') === 0 && pathinfo($file, PATHINFO_EXTENSION) == 'php') {

                // Lấy tên thành phần từ tên tệp
                $component_name = str_replace('.php', '', $file);

                // Chuẩn hóa tên thành phần
                $component_name = str_replace('-', '_', $component_name);
                $component_name = ucwords($component_name, '_');
                $component_name = str_replace(['Wib_', 'wib_'], 'WIB_', $component_name);

                // Định tên class dựa trên tên thành phần
                $class_name = $component_name;

                // Kiểm tra xem lớp đã tồn tại chưa
                if (class_exists($class_name)) {

                    // Tạo một đối tượng mới và lưu vào mảng - không tự nạp WIB_Base
                    if ($class_name != 'WIB_Base') {
                        $shortcode_objects[] = new $class_name();
                    }
                }
            }
        }

        // Bây giờ bạn có mảng $shortcode_objects chứa các đối tượng shortcode

    }


    // Display Shortcode
    static function render($content, $args = array(), $echo =  true) {

        $shortcode_content = $content;

        // Nếu có tham số cung cấp array
        if (count($args) > 0) {

            // Tách tên shortcode ra khỏi $content
            // Sử dụng biểu thức chính quy để tìm và trích xuất tên shortcode

            $pattern = '/\[(\w+)\s*\]/';

            preg_match($pattern, $content, $matches);

            $shortcode_name = '';
            if (count($matches) >= 2) {
                // $matches[1] chứa tên shortcode
                $shortcode_name = $matches[1];
            }

            // Khởi tạo một chuỗi rỗng để lưu trữ chuỗi key=value
            $keyValueString = '';

            foreach ($args as $key => $value) {
                // Kiểm tra nếu giá trị là mảng

                if (!is_string($value)) {
                    // Chuyển giá trị của $value thành một chuỗi nếu nó không phải là một chuỗi
                    $value_attr = var_export($value, true);
                } else {
                    $value_attr = sprintf('"%s"', $value);
                }

                // Xây dựng chuỗi key=value
                $keyValueString .= sprintf(' %s=%s', $key, $value_attr);
            }


            // Ghép hoàn chỉnh
            $shortcode_content = sprintf('[%s %s]', $shortcode_name, $keyValueString);
        }

        if ($echo) {
            if (is_array($shortcode_content)) {
                echo do_shortcode('[' . $shortcode_content[0] . ']');
            } else {
                echo do_shortcode($shortcode_content);
            }
        } else {
            do_shortcode($shortcode_content);
        }
    }

    // Đăng ký shortcode
    public function register_shortcodes() {
        // Định nghĩa mảng shortcode
        $shortcode_definitions = WEP_Shortcode_Model::get_list_shortcode();

        // Đăng ký các shortcode và truyền biến $shortcode_view_file vào hàm callback
        foreach ($shortcode_definitions as $shortcode_name => $shortcode_view_file) {
            add_shortcode($shortcode_name, function ($atts) use ($shortcode_name, $shortcode_view_file) {
                return $this->render_shortcode($atts, $shortcode_view_file, $shortcode_name);
            });
        }
    }

    // Render shortcode
    public function render_shortcode($atts, $shortcode_view_file, $shortcode_name) {

        // Dữ liệu
        $data = array();

        if (is_array($atts)) {
            $data = $atts;
        }

        // Kiểm tra xem tệp dữ liệu có tồn tại
        $data_file = $shortcode_view_file . '-data.php';
        $data_file_b = $shortcode_view_file . '_data.php';

        if (file_exists($data_file)) {
            // Nếu tệp tồn tại, thực hiện include để xử lý dữ liệu
            include $data_file;
        } elseif (file_exists($data_file_b)) {
            // Nếu tệp tồn tại, thực hiện include để xử lý dữ liệu phương án B
            include $data_file_b;
        }

        // Đọc nội dung từ file view
        $view_file = $shortcode_view_file . '.php';

        ob_start();
        if (file_exists($view_file)) {
            include $view_file;
        }
        return ob_get_clean();
    }

    // Khởi tạo nút "Insert Shortcode" và đăng ký script JavaScript
    public function add_shortcode_button() {
        if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
            add_filter('mce_buttons', array($this, 'register_shortcode_button'));
            add_filter('mce_external_plugins', array($this, 'add_shortcode_button_script'));
        }
    }

    // Đăng ký nút "Insert Shortcode" trong trình soạn thảo
    public function register_shortcode_button($buttons) {
        array_push($buttons, 'shortcode_button');
        return $buttons;
    }

    // Đăng ký script JavaScript cho nút "Insert Shortcode"
    public function add_shortcode_button_script($plugin_array) {
        $plugin_array['shortcode_button'] = get_template_directory_uri() . '/app/assets/js/shortcode-button.js';
        return $plugin_array;
    }


    // Render shortcode wep_shortcode
    public function render_shortcode_detail_attributes($atts) {

        // Xử lý logic shortcode ở đây, gọi các phương thức từ Model nếu cần
        $model = new WEP_Shortcode_Model();
        $data = $model->get_data();

        // Xử lý các tham số được truyền vào shortcode
        $atts = shortcode_atts(array(
            'param1' => 'default_value1',
            'param2' => 'default_value2',
        ), $atts);

        $shortcode_view_file = THEME_SHORTCODE . '/wep_detail_attributes.php';

        // Kiểm tra xem tệp dữ liệu có tồn tại
        $data_file = THEME_SHORTCODE . '/' . $shortcode_view_file . '-data' . '.php';
        if (file_exists($data_file)) {
            // Nếu tệp tồn tại, thực hiện include để xử lý dữ liệu
            include $data_file;
        }

        // Render giao diện View
        ob_start();
        if (file_exists($shortcode_view_file)) {
            include(THEME_SHORTCODE . '/wep_detail_attributes.php');
        }
        return ob_get_clean();
    }
}
