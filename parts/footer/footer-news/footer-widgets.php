<?php
if (is_active_sidebar('third_widget_area')) :
?>
    <div class="col-md-12">
        <?php
        dynamic_sidebar('third_widget_area');

        if (current_user_can('manage_options')) :
        ?>
            <span class="edit-link"><a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="badge bg-secondary"><?php esc_html_e('Edit', 'vieclam24'); ?></a></span><!-- Show Edit Widget link -->
        <?php
        endif;
        ?>
    </div>
<?php
endif;
?>