<?php

/**
 * The Template for displaying Author pages.
 */

new WEP_Page_Header();

if (have_posts()) :
	/**
	 * Queue the first post, that way we know
	 * what author we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	the_post();

	get_template_part('parts/page/page-header-author');

	get_template_part('parts/author-bio');

	/**
	 * Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	get_template_part('parts/archive', 'loop');
else :
	// 404.
	get_template_part('parts/content', 'none');
endif;

wp_reset_postdata(); // End of the loop.

new WEP_Page_Footer();
