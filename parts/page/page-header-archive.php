<header class="page-header">
	<h1 class="page-title">
		<?php
			if ( is_day() ) :
				printf( esc_html__( 'Daily Archives: %s', 'vieclam24' ), get_the_date() );
			elseif ( is_month() ) :
				printf( esc_html__( 'Monthly Archives: %s', 'vieclam24' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'vieclam24' ) ) );
			elseif ( is_year() ) :
				printf( esc_html__( 'Yearly Archives: %s', 'vieclam24' ), get_the_date( _x( 'Y', 'yearly archives date format', 'vieclam24' ) ) );
			else :
				esc_html_e( 'Blog Archives', 'vieclam24' );
			endif;
		?>
	</h1>
</header>