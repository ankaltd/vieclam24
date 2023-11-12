<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.
$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'vieclam24'); ?></a>

	<div id="wrapper">
		<?php

		/* Before Header */
		get_template_part('parts/header/header-start');
		get_template_part('parts/header/navbar-start');
		get_template_part('parts/global/container-start');

		/* Header Content */
		get_template_part('parts/header/header-logo');
		get_template_part('parts/header/header-navbar-toggler');
		get_template_part('parts/header/header-navbar'); 
		/* Header Content End */

		get_template_part('parts/global/container-end');
		get_template_part('parts/header/navbar-end');
		get_template_part('parts/header/header-end');
		/* After Header */

		/* Main Content */
		get_template_part('parts/global/wrapper-start');

		?>