<?php

/* Comment Category Admin */

class WEP_Cmt_Cat_Admin {
    public function __construct() {

        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_pages'));

            // Kiểm tra và tạo bảng nếu cần
            $this->check_and_create_table();
        }
    }

    public function add_pages() {
        add_menu_page(
            __('Bình luận Cate', 'bvdt'),
            __('Bình luận Cate', 'bvdt'),
            'delete_others_posts',
            'cmt_cat',
            array($this, 'render_page'),
            'dashicons-format-chat',
            5
        );
    }

    public function check_and_create_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'comments_ws24h';

        // Kiểm tra xem bảng đã tồn tại chưa
        if ($wpdb->get_var("SHOW TABLES LIKE ' " . $table_name . "'") != $table_name) {
            // Bảng chưa tồn tại, tạo nó
            $this->create_comment_category_table();
        }
    }

    public function create_comment_category_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'comments_bvdt';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint NOT NULL,
            cat_id bigint DEFAULT NULL,
            content text $charset_collate,
            date datetime DEFAULT NULL,
            ten tinytext $charset_collate,
            phone varchar(255) $charset_collate DEFAULT NULL,
            email varchar(255) $charset_collate DEFAULT NULL,
            type varchar(20) $charset_collate DEFAULT NULL,
            parent bigint DEFAULT NULL,
            approved varchar(20) $charset_collate DEFAULT NULL,
            user_id bigint DEFAULT NULL
        ) ENGINE=InnoDB $charset_collate;";


        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function render_page() {
        if (!empty($_GET['edit_cmt_cat'])) {
            //require_once 'edit-comment-category.php';
        } else {
            global $wpdb;
            $table_name = $wpdb->prefix . 'comments_bvdt';

            if (!empty($_GET['delete_id'])) {
                $xoa = $wpdb->delete($table_name, array('id' => $_GET['delete_id']), array('%d'));
            }

            $where = $search = '';
            if (!empty($_GET['stt_cmt_cat'])) {
                $update = $wpdb->update(
                    $table_name,
                    array(
                        'approved' => $_GET['approved'],
                    ),
                    array('id' => $_GET['stt_cmt_cat']),
                    '%s',
                    '%s'
                );
            }

            if (!empty($_REQUEST['xoa_cmt_cat'])) {
                $xoa = $wpdb->query('DELETE FROM ' . $table_name . ' WHERE id IN(' . implode(',', $_REQUEST['xoa_cmt_cat']) . ')');
            }

            $count = $wpdb->get_var('SELECT COUNT(id) AS dem FROM ' . $table_name . $where);
            $ppage = 100;

            if ($count > $ppage) {
                $maxpage = ceil($count / $ppage);
                if (isset($_REQUEST['paged'])) {
                    $trang = $_REQUEST['paged'];
                    if ($trang > $maxpage) $trang = $maxpage;
                } else {
                    $trang = 1;
                }
                $dau = ($trang - 1) * $ppage;
                $results = $wpdb->get_results('SELECT * FROM ' . $table_name . $where . ' ORDER BY id DESC LIMIT ' . $dau . ', ' . $ppage);
            } else {
                $results = $wpdb->get_results('SELECT * FROM ' . $table_name . $where . ' ORDER BY id DESC');
            }
?>
            <div class="wrap">
                <form method="GET" class="form-horizontal" role="form" action="">
                    <input type="hidden" name="page" value="cmt_cat">
                    <h1 class="wp-heading-inline">Bình luận chuyên mục</h1>
                    <?php if (!empty($xoa)) : ?>
                        <div class="updated notice is-dismissible">
                            <p><strong>Đã xoá thành công.</strong></p>
                        </div>
                    <?php endif ?>
                    <?php if (!empty($update)) : ?>
                        <div class="updated notice is-dismissible">
                            <p><strong>Đã cập nhật thành công.</strong></p>
                        </div>
                    <?php endif ?>
                    <h2>Có tất cả <?php echo $count; ?> bình luận <?php echo (!empty($_REQUEST['search'])) ? 'khớp với từ khóa "' . $_REQUEST['search'] . '"' : ''; ?></h2>
                    <p><input type="submit" name="xoa" value="Xoá bình luận đã chọn" class="button button-primary"></p>
                    <?php if ($count > $ppage) : ?>
                        <div class="tablenav">
                            <div class="tablenav-pages"><span class="displaying-num"><?php echo $count; ?> Bình luận</span>
                                <span class="pagination-links">
                                    <?php if ($trang == 1) : ?>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
                                    <?php else : ?>
                                        <a class="first-page" href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat' . $search; ?>"><span class="screen-reader-text">Trang Tĩnh Đầu Tiên</span><span aria-hidden="true">«</span></a>
                                        <a class="prev-page" href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat&paged=' . ($trang - 1) . $search; ?>"><span class="screen-reader-text">Trang trước</span><span aria-hidden="true">‹</span></a>
                                    <?php endif ?>
                                    <span class="paging-input"><input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $trang; ?>" size="4" aria-describedby="table-paging"><span class="tablenav-paging-text"> trên <span class="total-pages"><?php echo $maxpage; ?></span></span></span>
                                    <?php if ($trang == $maxpage) : ?>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">›</span>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
                                    <?php else : ?>
                                        <a class="next-page" href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat&paged=' . ($trang + 1) . $search; ?>"><span class="screen-reader-text">Trang sau</span><span aria-hidden="true">›</span></a>
                                        <a class="last-page" href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat&paged=' . ($maxpage) . $search; ?>"><span class="screen-reader-text">Trang cuối</span><span aria-hidden="true">»</span></a>
                                    <?php endif ?>
                                </span>
                            </div>
                            <br class="clear">
                        </div>
                    <?php endif ?>
                    <?php if ($count > 0) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 20px"><input type="checkbox" name="xoa_all" value="ok"></th>
                                        <th>Tác giả</th>
                                        <th>Nội dung</th>
                                        <th>Trả lời</th>
                                        <th>Thời gian</th>
                                        <th>Trạng thái</th>
                                        <th style="width: 140px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $result) {
                                        if (!empty($result->user_id)) {
                                            $user = get_user_by('ID', $result->user_id);
                                            $ten = $user->display_name;
                                        } else {
                                            $ten = $result->ten . '-' . $result->phone;
                                        }
                                        $term = get_term_by('term_taxonomy_id', $result->cat_id); ?>
                                        <tr>
                                            <td>
                                                <input class="input_xoa_cmt_cat" type="checkbox" name="xoa_cmt_cat[]" value="<?php echo $result->id ?>">
                                            </td>
                                            <td><?php echo $ten; ?></td>
                                            <td><?php echo $result->content ?></td>
                                            <td><a target="_blank" href="<?php echo get_term_link($term) ?>#commentform"><?php echo $term->name ?></a></td>
                                            <td><?php echo $result->date ?></td>
                                            <td><?php echo $result->approved == 1 ? 'Đã hiển thị' : 'Chờ duyệt' ?></td>
                                            <td>
                                                <?php if ($result->approved == 1) : ?>
                                                    <a href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat&approved=0&stt_cmt_cat=' . $result->id; ?>" class="button button-primary">Chờ duyệt</a>
                                                <?php else : ?>
                                                    <a href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat&approved=1&stt_cmt_cat=' . $result->id; ?>" class="button button-primary">Chấp nhận</a>
                                                <?php endif ?>
                                                <a href="<?php echo get_admin_url() . 'admin.php?page=cmt_cat&delete_id=' . $result->id; ?>" class="button button-secondary" onclick="return confirm('Bạn có chắc chắn muốn xoá bình luận này không?');">Xoá</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <script type="text/javascript">
                            jQuery(document).ready(function() {
                                jQuery('input[name="xoa_all"]').change(function() {
                                    if (jQuery(this).prop('checked') == true) {
                                        jQuery('.input_xoa_cmt_cat').prop('checked', true);
                                    } else {
                                        jQuery('.input_xoa_cmt_cat').prop('checked', false);
                                    }
                                });
                            });
                        </script>
                    <?php else : ?>
                        <h3>Không tìm thấy bình luận nào.</h3>
                    <?php endif ?>
                </form>
            </div>
<?php }
    }
}
