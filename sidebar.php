<?php

/**
 * Sidebar Template.
 */

if (is_active_sidebar('primary_widget_area') || is_archive() || is_single()) :
?>
	<div id="sidebar" class="col-md-4 order-md-first col-sm-12 order-sm-last">
		<?php
		get_template_part('parts/sidebar/primary-widget-area');
		get_template_part('parts/sidebar/primary-two');


		?>
	</div><!-- /#sidebar -->
<?php
endif;
?>