<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
    <?php
    $header_logo = get_theme_mod('header_logo'); // Get custom meta-value.

    if (!empty($header_logo)) :
    ?>
        <img src="<?php echo esc_url($header_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
    <?php
    else :
        echo esc_attr(get_bloginfo('name', 'display'));
    endif;
    ?>
</a>

