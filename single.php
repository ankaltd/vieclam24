<?php

/**
 * The Template for displaying all single posts.
 */

new WEP_Page_Header();

if (have_posts()) :
	while (have_posts()) :
		the_post();

		get_template_part('parts/content', 'single');

		// If comments are open or we have at least one comment, load up the comment template.
		if (comments_open() || get_comments_number()) :
			comments_template();
		endif;
	endwhile;
endif;

wp_reset_postdata();

get_template_part('parts/loop/navigation-post');

new WEP_Page_Footer();
