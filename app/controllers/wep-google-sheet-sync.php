<?php
if (!defined('ABSPATH')) {
    exit;
}

class WEP_Google_Sheet_Sync {
    public function __construct() {
        // Constructor nếu cần
    }

    /**
     * Initialization method.
     * This method initializes necessary actions and hooks for the plugin.
     */

    public function init() {
        if (is_admin()) {
            // Add menu for setting up Google Sheet configuration in the admin panel

            add_action('admin_menu', array($this, 'setting_google_sheet_menus'), 70);
            // Define action to handle AJAX request for initializing data sync from Google Sheet

            add_action('wp_ajax_google_sheet_bvdt', array($this, 'google_sheet_bvdt_init'));
            // Define action to handle AJAX request for updating data from Google Sheet to the store

            add_action('wp_ajax_google_sheet_bvdt_update', array($this, 'google_sheet_bvdt_update'));

            // allow access ajaxurl in admin
            add_action('admin_enqueue_scripts', array($this, 'client_enqueue_scripts'));
            
        }
    }

    /* Access Ajax URL */
    // Đăng ký các script và style cần thiết cho AJAX
    public function client_enqueue_scripts() {
        wp_enqueue_script('wep-ajax-admin', get_template_directory_uri() . '/app/assets/js/wep-ajax-admin.js', array('jquery'), '1.0', true);

        // Tạo nonce và truyền vào script
        $ajax_nonce = wp_create_nonce('google_sheet_bvdt');
        $ajax_nonce_update = wp_create_nonce('google_sheet_bvdt_update');
        wp_localize_script('wep-ajax-admin', 'wepAjaxAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'ajaxNonce' => $ajax_nonce, // Truyền nonce vào JavaScript
            'ajaxNonceUpdate' => $ajax_nonce_update // Truyền nonce vào JavaScript
        ));
    }   

    /**
     * Method to create the Google Sheet configuration page.
     * This method displays the Google Sheet configuration page with fields to configure Sheet ID, Sheet name, and Authorization Code.
     */
    public function setting_google_sheet_menus() {

        // Add your code for creating the Google Sheet configuration page here
        // Including HTML form for setting Sheet ID, Sheet name, and Authorization Code
        // You can add instructions and guidelines for users to configure the Google Sheet properly
        add_options_page(__('Cài đặt Google Sheet', 'bvdt'), __('Cài đặt Google Sheet', 'bvdt'), 'manage_options', 'setting-google-sheet', array($this, 'setting_google_sheet_Config'));
    }

    public function setting_google_sheet_Config() {
?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Cài đặt Google Sheet</h1>
            <?php
            if (isset($_POST['submit'])) :
                $access_token = get_option('access_token_google');
                $access_token = is_array($access_token) ? $access_token : array();
                $access_token['sheet_id'] = $_POST['sheet_id'];
                $access_token['ten_sheet'] = $_POST['ten_sheet'];
                update_option('access_token_google', $access_token);
            ?>
                <div class="updated notice is-dismissible">
                    <p><strong>Đã lưu thông số cấu hình Google Sheet.</strong></p>
                </div>
            <?php endif;

            $access_token = get_option('access_token_google');
            ?>
            <form method="POST">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label>Sheet id</label></th>
                        <td><input required="" name="sheet_id" type="text" value="<?php echo !empty($access_token['sheet_id']) ? $access_token['sheet_id'] : '' ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Tên sheet và số cột</label></th>
                        <td><input required="" name="ten_sheet" type="text" value="<?php echo !empty($access_token['ten_sheet']) ? $access_token['ten_sheet'] : '' ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Authorization Code</label></th>
                        <td><input name="code_sheet" type="text" class="regular-text" value="<?php echo !empty($_GET['code']) ? $_GET['code'] : '' ?>"></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" class="button button-primary" value="Lưu thay đổi">
                    <button type="button" class="button button-primary" id="dong-bo">Đồng bộ cửa hàng</button>
                </p>
            </form>
            <div id="ds-error" class="hidden">
                <h3>Danh sách lỗi đồng bộ</h3>
            </div>
            <div id="list-ajax"></div>
            
        </div>
<?php
    }

    /**
     * Method to initialize data sync from Google Sheet.
     * This method handles the request to sync data from Google Sheet to the WooCommerce store.
     */

    public function google_sheet_bvdt_init() {
        // Add your code for initializing data sync from Google Sheet here
        // Use the Google Sheets API to access data from the Sheet
        // Handle cases such as expired tokens and errors during the sync process
        // Return results in JSON format for client-side handling

        check_ajax_referer( 'google_sheet_bvdt', 'ajaxNonce' );


        require_once 'vendor/autoload.php';
        $client = new Google\Client();
        $client->setAuthConfig(THEME_CONFIG . '/google-sheet/client_secret.json');
        $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $access_token = get_option('access_token_google');
        try {
            if (!empty($access_token['access_token'])) {
                $client->setAccessToken($access_token['access_token']);
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                        $access_token['access_token'] = $client->getAccessToken();
                        update_option('access_token_google', $access_token);
                    } else {
                        $access_token['access_token'] = '';
                        update_option('access_token_google', $access_token);
                        $client->setRedirectUri(get_home_url() . '/wp-admin/options-general.php?page=setting-google-sheet');
                        echo json_encode(array('stt' => 1, 'data' => 'Mã code hết hạn. Click vào <a href="' . $client->createAuthUrl() . '">đây</a> lấy mã code để đồng bộ.'));
                        exit();
                    }
                }
                $service = new Google_Service_Sheets($client);
                $response = $service->spreadsheets_values->get($access_token['sheet_id'], $access_token['ten_sheet']);
                $data = $response->getValues();
                if (!empty($data)) {
                    $response = array();
                    foreach ($data as $key => $value) {
                        if ($value[4] == 'UPDATE') {
                            $response[] = $value;
                        }
                    }
                    echo json_encode(array('stt' => 2, 'data' => $response));
                } else {
                    $client->setRedirectUri(get_home_url() . '/wp-admin/options-general.php?page=setting-google-sheet');
                    echo json_encode(array('stt' => 1, 'data' => 'Không lấy được dữ liệu. Click vào <a href="' . $client->createAuthUrl() . '">đây</a> lấy mã code để đồng bộ.'));
                }
            } elseif (!empty($_POST['code'])) {
                $authenticate = $client->authenticate($_POST['code']);
                if (!empty($authenticate['error'])) {
                    $access_token['access_token'] = '';
                    update_option('access_token_google', $access_token);
                    $client->setRedirectUri(get_home_url() . '/wp-admin/options-general.php?page=setting-google-sheet');
                    echo json_encode(array('stt' => 1, 'data' => 'Mã code hết hạn. Click vào <a href="' . $client->createAuthUrl() . '">đây</a> lấy mã code để đồng bộ.<br>Lỗi ' . $authenticate['error'] . ' (' . $authenticate['error_description'] . ').'));
                } else {
                    $access_token['access_token'] = $client->getAccessToken();
                    if (!empty($access_token['access_token'])) {
                        update_option('access_token_google', $access_token);
                        $data = 'Đã lưu code. Vui lòng chạy lại đồng bộ.';
                    } else {
                        $client->setRedirectUri(get_home_url() . '/wp-admin/options-general.php?page=setting-google-sheet');
                        $data = 'Lỗi khi lưu token. Click vào <a href="' . $client->createAuthUrl() . '">đây</a> lấy mã code để đồng bộ.';
                    }
                    echo json_encode(array('stt' => 1, 'data' => $data));
                }
            } else {
                $client->setRedirectUri(get_home_url() . '/wp-admin/options-general.php?page=setting-google-sheet');
                echo json_encode(array('stt' => 1, 'data' => 'Chưa có mã code. Click vào <a href="' . $client->createAuthUrl() . '">đây</a> lấy mã code để đồng bộ.'));
            }
        } catch (Exception $e) {
            $access_token['access_token'] = '';
            update_option('access_token_google', $access_token);
            $client->setRedirectUri(get_home_url() . '/wp-admin/options-general.php?page=setting-google-sheet');
            echo json_encode(array('stt' => 1, 'data' => 'Click vào <a href="' . $client->createAuthUrl() . '">đây</a> lấy mã code để đồng bộ.<br>Lỗi |' . $e . '.| Vui lòng chạy lại đồng bộ.'));
        }
        exit();
    }

    /**
     * Method to update data from Google Sheet to the WooCommerce store.
     * This method handles the request to update data from Google Sheet to the WooCommerce store.
     */
    public function google_sheet_bvdt_update() {

        // Add your code for updating data from Google Sheet to the WooCommerce store here
        // Fetch data from the Google Sheet and update corresponding product information in the store
        // Handle error cases and return results in JSON format for client-side handling
        check_ajax_referer( 'google_sheet_bvdt_update', 'ajaxNonceUpdate' );

        $data = '';
        $stt = 1;
        if (!empty($_POST['salon'])) {
            $value = $_POST['salon'];
            if (!empty($value[1])) {
                $type = get_post_type($value[1]);
                if ($type == 'product' || $type == 'product_variation') {
                    $price = get_post_meta($value[1], '_regular_price', true);
                    $sale = get_post_meta($value[1], '_sale_price', true);
                    if (!empty($value[2]) && !empty($value[3])) {
                        $value[2] = $value[2] * 1000;
                        $value[3] = $value[3] * 1000;
                        if ($price != $value[2] || $sale != $value[3]) {
                            if ($value[3] < $value[2]) {
                                update_post_meta($value[1], '_sale_price', $value[3]);
                                update_post_meta($value[1], '_regular_price', $value[2]);
                                update_post_meta($value[1], '_price', $value[3]);
                                $data .= 'Đã cập nhật giá ' . $value[0];
                            } else {
                                $data .= 'Giá khuyến mại lớn hơn giá thường nên không cập nhật ' . $value[0];
                            }
                        } else {
                            $data .= 'Giá không đổi không cần cập nhật ' . $value[0];
                        }
                    } elseif (!empty($value[2]) || !empty($value[3])) {
                        $gia = !empty($value[2]) ? $value[2] * 1000 : $value[3] * 1000;
                        if ($price != $gia) {
                            if (!empty($sale)) {
                                update_post_meta($value[1], '_sale_price', 0);
                            }
                            update_post_meta($value[1], '_regular_price', $gia);
                            update_post_meta($value[1], '_price', $gia);
                            $data .= 'Đã cập nhật giá ' . $value[0];
                        } else {
                            $data .= 'Giá không đổi không cần cập nhật ' . $value[0];
                        }
                    } else {
                        $error = 'Không có giá, bỏ qua đồng bộ ' . $value[0];
                    }
                } else {
                    $error = 'Không phải ID sản phẩm, bỏ qua đồng bộ ' . $value[0];
                }
            } else {
                $error = 'Không có ID, bỏ qua đồng bộ ' . $value[0];
            }
            if (!empty($error)) {
                $data .= $error;
                $stt = 2;
            }
        } else {
            $data .= 'Không nhận được dữ liệu';
            $stt = 2;
        }
        echo json_encode(array('stt' => $stt, 'data' => $data));
        exit();
    }
}
