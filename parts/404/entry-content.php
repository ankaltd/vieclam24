<?php
extract($args);
?>
<div class="entry-content">
    <p><?php esc_html_e('It looks like nothing was found at this location.', 'vieclam24'); ?></p>
    <div>
        <?php
        if ('1' === $search_enabled) :
            get_search_form();
        endif;
        ?>
    </div>
</div><!-- /.entry-content -->