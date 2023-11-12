<?php

/**
 * The Template for displaying Search Results pages.
 */

new WEP_Page_Header();

if (have_posts()) :

	get_template_part('parts/page/page-header-search');
	get_template_part('parts/archive', 'loop');

else :

	new WEP_Page_Content('nothing-found');

endif;

wp_reset_postdata();

new WEP_Page_Footer();
