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
		<?php get_template_part('parts/header/header-start') ?>

		<?php get_template_part('parts/header/header-navbar-start', null, array('navbar_scheme' => $navbar_scheme, 'navbar_position' => $navbar_position)) ?>

		<?php get_template_part('parts/global/container-start') ?>
		<?php get_template_part('parts/header/header-logo') ?>
		<?php get_template_part('parts/header/header-navbar-toggler') ?>
		<?php get_template_part('parts/header/header-navbar', null, array('search_enabled' => $search_enabled)) ?>
		<?php get_template_part('parts/global/container-end') ?>
		<?php get_template_part('parts/header/header-navbar-end');		?>
		
		<?php get_template_part('parts/header/header-end') ?>

		<?php
		get_template_part('parts/global/wrapper-start', null, array('navbar_position' => $navbar_position))
		?>