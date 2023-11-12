<?php

/**
 * The Template used to display Tag Archive pages.
 */

new WEP_Page_Header();

if (have_posts()) :

	get_template_part('parts/page/page-header-tag');

	get_template_part('parts/archive-loop');
else :
	// 404.
	get_template_part('parts/content-none');
endif;

wp_reset_postdata(); // End of the loop.

new WEP_Page_Footer();
