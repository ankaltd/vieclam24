<?php

/**
 * The template for displaying image attachments.
 *
 */

new WEP_Page_Header();
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post();

					new WEP_Page_Content('image');

					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) :
						comments_template();
					endif;

					get_template_part('parts/loop/pagination-parent');

				endwhile;
			endif;

			wp_reset_postdata(); // End of the loop.
			?>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.container -->
<?php
new WEP_Page_Footer();
