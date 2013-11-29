<?php
// if you need this query to be custom, use pre_get_posts before
// this file is included to manipulate wp_query

// $mdg_global_query should be a query set in your template file before ariving here
// see the news template for example
// if that query doesn't exist, we'll use the global $wp_query
global $mdg_global_query;
global $wp_query;
global $more;

$query = isset( $mdg_global_query ) ? $mdg_global_query : $wp_query;

$posts = $query->get_posts();
?>

<ul>
	<?php foreach( $posts as $post ){

	setup_postdata($post);
	$more = 0;
	
	?>
		<li>
			<h2 class="title title1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php the_content('Read More <span class="glyphicon glyphicon-play"></span>'); ?>
		</li>
	
	<?php } wp_reset_postdata(); ?>
</ul>