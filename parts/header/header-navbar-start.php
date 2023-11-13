<?php extract($args) ?>
<nav id="header" class="navbar navbar-expand-md <?php echo esc_attr($navbar_scheme);
												if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' fixed-top';
												elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' fixed-bottom';
												endif;
												if (is_home() || is_front_page()) : echo ' home';
												endif; ?>">