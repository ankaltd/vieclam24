<main class="bg-se-titan-white">
	<div class="min-h-screen bg-white lg:pb-4">
		<section id="employers-banner-version2">
			<?php
			/**
			 * The template for displaying content in the index.php template.
			 */

			get_template_part('parts/01-home/1-home-banner-slider');
			?>

			<div class="wp-container search-container">
				<?php
				get_template_part('parts/01-home/2-home-search-form');
				get_template_part('parts/01-home/3-home-hightlight-branch');
				?>
			</div>
			<div class="wp-container">
				<?php
				get_template_part('parts/01-home/4-home-top-company');
				?>
			</div>
		</section>

		<?php
		get_template_part('parts/01-home/5-home-urgent-jobs-grid-slider');
		?>
		<section class="wp-container-fluid relative bg-se-titan-white lg:bg-transparent lg:pt-6 pb-4 mb-3">
			<?php
			get_template_part('parts/01-home/parts/01-home/6-home-banner-ads');
			get_template_part('parts/01-home/7-home-suggestion-jobs-grid');
			?>
		</section>
		<?php
		get_template_part('parts/01-home/8-home-career-handbook-grid');
		get_template_part('parts/01-home/9-home-jobs-by-columns');

		?>
	</div>
</main>