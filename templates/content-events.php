<?php
global $mdg_events;
global $mdg_generic;

// Post Editor Content
while ( have_posts() ) {
	the_post();
	the_content();
} // while()

$non_archived_events = $mdg_events->get_non_archived_events();
extract( $non_archived_events ); // $events, $closest_event
?>

	<div class="col-md-6 featured-event">
		<?php if ( $closest_event ) { ?>
		<?php echo get_the_post_thumbnail( $closest_event->ID, 'featured_event_image', array( 'class' => 'featured-event-image' ) ); ?>
		<div class="featured-event-content">
			<?php echo $mdg_generic->get_the_excerpt( $closest_event->ID, array(), 35, '' ); ?>
		</div>
		<a href="<?php echo get_post_permalink( $closest_event->ID ); ?>" class="feature-event-link btn btn-large" title="<?php echo esc_html( $closest_event->post_title ); ?>">GO TO EVENT PAGE</a>
		<?php } // if() ?>
	</div> <!-- /.col-md-6 -->


	<div class="col-md-6 future-events">
	<?php foreach ( $events as $event ) { ?>
		<div class="col-md-12">
			<h3 class="event-title"><?php echo esc_html( $event->post_title ); ?></h3>
			<div class="event-excerpt">
				<?php
				$excerpt_more   = ' <a href="'.get_permalink( $post->ID ).'"class="more-link">Read More</a>';
				$excerpt_length = 20;
				$excerpt        = $mdg_generic->get_the_excerpt( $event->ID, array(), $excerpt_length, $excerpt_more );
				echo $excerpt;
				?>
			</div>
		</div>
	<?php } // foreach() ?>

	<a class="view-event-archives inverse">VIEW EVENT ARCHIVES</a>
	</div> <!-- /.col-md-6 -->

<?php
// $is_archived_event = $mdg_events->is_archived_event();
// pp($is_archived_event);