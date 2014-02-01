<?php get_template_part( 'templates/page', 'header' ); ?>
	<div class="container">
		<?php if ( ! have_posts() ) { ?>
		<div class="alert">
			<?php _e( 'Sorry, no results were found.', 'roots' ); ?>
		</div>
		<?php get_search_form(); ?>
		<?php } // if() ?>
	</div> <!-- /.container -->
	<?php while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/content', get_post_format() );
	} // while() ?>

	<?php if ( $wp_query->max_num_pages > 1 ) { ?>
	<div class="container">
		<nav class="post-nav">
			<ul class="pager">
				<li class="previous"><?php next_posts_link( __( '&larr; Older posts', 'roots' ) ); ?></li>
				<li class="next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'roots' ) ); ?></li>
			</ul>
		</nav>
	</div> <!-- /.container -->
	<?php } // if() ?>