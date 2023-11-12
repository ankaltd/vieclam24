<?php  
    extract($args);
?>
<div id="navbar" class="collapse navbar-collapse">
    <?php
    // Loading WordPress Custom Menu (theme_location).
    wp_nav_menu(
        array(
            'menu_class'     => 'navbar-nav me-auto',
            'container'      => '',
            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'theme_location' => 'main-menu',
        )
    );

    if ('1' === $search_enabled) :
    ?>
        <form class="search-form my-2 my-lg-0" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="input-group">
                <input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Search', 'vieclam24'); ?>" title="<?php esc_attr_e('Search', 'vieclam24'); ?>" />
                <button type="submit" name="submit" class="btn btn-outline-secondary"><?php esc_html_e('Search', 'vieclam24'); ?></button>
            </div>
        </form>
    <?php
    endif;
    ?>
</div><!-- /.navbar-collapse -->

