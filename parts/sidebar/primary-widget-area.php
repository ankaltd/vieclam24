<?php
if (is_active_sidebar('primary_widget_area')) :
?>
    <div id="widget-area" class="widget-area" role="complementary">
        <?php
        dynamic_sidebar('primary_widget_area');

        if (current_user_can('manage_options')) :
        ?>
            <span class="edit-link"><a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="badge bg-secondary"><?php esc_html_e('Edit', 'vieclam24'); ?></a></span><!-- Show Edit Widget link -->
        <?php
        endif;
        ?>
    </div><!-- /.widget-area -->
<?php
endif;
