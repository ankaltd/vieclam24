<?php

/**
 * Template Name: Page (Default)
 * Description: Page template with Sidebar on the left side.
 *
 */

new WEP_Page_Header();

the_post();

get_template_part('parts/global/row-start');
?>

<div class="col-md-8 order-md-2 col-sm-12">

	<?php new WEP_Page_Content('page') ?>

	<?php
	// If comments are open or we have at least one comment, load up the comment template.
	if (comments_open() || get_comments_number()) {
		comments_template();
	}
	?>

</div><!-- /.col -->
<?php
new WEP_Page_Sidebar();
?>

<?php get_template_part('parts/global/row-end'); ?>

<?php

new WEP_Page_Footer();
