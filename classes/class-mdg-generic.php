<?php
/**
 * This generic class is really just designed to hold random functions/methods.
 * By putting them in this generic class, we will avoid collisions and
 * make these functions easier to find.  Since you will be forced to instantiate
 * this class before you can use these functions, that instantiation will
 * tell you (and others) that the function lives here.
 *
 * @author Matchbox Design Group <info@matchboxdesigngroup.com>
 */
class MDG_Generic {
	/**
	 * Class Constructor
	 *
	 * @return Void
	 */
	public function __construct() {
	} // __construct()


	/**
	 * Checks if the current host is localhost.
	 *
	 * @return boolean If the current host is localhost.
	 */
	public function is_localhost() {
		$localhost = array( 'localhost', '127.0.0.1' );
		$host      = $_SERVER['HTTP_HOST'];

		if ( in_array( $host, $localhost ) ) {
			return true;
		} // if()

		return false;
	} // is_localhost()



	/**
	 * Checks if the current host is a staging site.
	 *
	 * @return boolean If the current host is a staging site.
	 */
	public function is_staging() {
		$staging = array( 'staging.', 'dev.' );
		$host    = $_SERVER['HTTP_HOST'];

		foreach ( $staging as $site ) {
			if ( strpos( $host, $site ) !== false ) {
				return true;
			} // if()
		} // foreach()

		return false;
	} // is_staging()



	/**
	 * Retrieves a page/post/custom post type ID when provided a slug.
	 *
	 * @param string  $slug The slug of the page/post/custom post type you want an ID for.
	 *
	 * @return integer      The ID of the page/post/custom post type
	 */
	public function get_ID_by_slug( $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page )
			return $page->ID;

		return null;
	} // get_ID_by_slug()



	/**
	 * Adds testing post content to the supplied post type.
	 *
	 * Sample use: $mdg_generic->make_dummy_content( 'project', 'Sample Project' 20 );
	 *
	 * @param string  $post_type Required. Name of the post type to create content for.
	 * @param string  $title     Required. The title base you want to use without a trailing space, the post count will be appended to the end.
	 * @param integer $count     Required. The amount of posts you want to be added.
	 * @param string[] $options{} Optional.
	 *
	 * @return [type]            [description]
	 */
	public function make_dummy_content( $post_type, $title, $count, $options = array() ) {
		global $user_ID;

		for ( $i = 1; $i <= $count; $i++ ) {

			$text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

			// add an extra paragraph here and there
			$text = $i % 3 ? $text . '<br/><br/>' . $text : $text;

			// By adding one to the time the publish date increments
			$current_time = time() + $i;

			$new_post = array(
				'post_title'    => "{$title} {$i}",
				'post_content'  => $text,
				'post_status'   => 'publish',
				'post_date'     => date( 'Y-m-d H:i:s', $current_time ),
				'post_author'   => $user_ID,
				'post_type'     => $post_type,
				'post_category' => array( 0 )
			);

			$post_id = wp_insert_post( $new_post );
		} // for()
	} // make_dummy_content()



	/**
	 * Truncates a string with the supplied information
	 *
	 * Example:
	 * global $mdg_generic;
	 * $mdg_generic->truncate( $string, 30, " " )
	 *
	 * @param string  $string The string to be truncated
	 * @param integer $limit  The length of the truncated string
	 * @param string  $break  The break point
	 * @param string  $pad    The string padding to use
	 *
	 * @return string          The truncated string if $string <= $limit or the input $string
	 */
	public function truncate_string( $string, $limit, $break = ".", $pad = "..." ) {
		// return with no change if string is shorter than $limit
		if ( strlen( $string ) <= $limit )
			return $string;

		// our first test
		$test1 = strpos( $string, $break, $limit );

		// second test to make sure we didn't land on a break (won't truncate)
		$test2 = strpos( $string, $break, $limit -1 );

		// is $break present between $limit and the end of the string?
		if ( false !== ( $breakpoint = $test1 ) || false !== ( $breakpoint = $test2 ) ) {
			if ( $breakpoint < strlen( $string ) - 1 ) {
				$string = substr( $string, 0, $breakpoint ) . $pad;
			} // if()
		} // if()

		return $string;
	} // truncate_string()



	/**
	 * Creates and optionally outputs pagination
	 *
	 * @param string  $max_num_pages Optional. The amount of pages to be paginated through, defaults to the global $wp_query->max_num_pages.
	 * @param integer $range         Optional. The minimum amount of items to show
	 * @param boolean $output        Optional. Output the content
	 *
	 * @return string                    The pagination HTML
	 */
	public function pagination( $max_num_pages = null, $range = 2, $output = true ) {
		$showitems = ( $range * 2 ) + 1;
		$pagination = '';

		global $paged;
		if ( empty( $paged ) )
			$paged = 1;

		if ( is_null( $max_num_pages ) ) {
			global $wp_query;
			$max_num_pages = $wp_query->max_num_pages;
			if ( ! $max_num_pages )
				$max_num_pages = 1;
		} // if()

		if ( 1 != $max_num_pages ) {
			$pagination .= "<div class='pagination'>";
			if ( $paged > 2 && $paged > $range+1 && $showitems < $max_num_pages )
				$pagination .= "<a href='".get_pagenum_link( 1 )."'>&laquo;</a>";
			if ( $paged > 1 && $showitems < $max_num_pages )
				$pagination .= "<a href='".get_pagenum_link( $paged - 1 )."'>&lsaquo;</a>";

			for ( $i = 1; $i <= $max_num_pages; $i++ ) {
				if ( 1 != $max_num_pages &&( !( $i >= $paged + $range + 1 || $i <= $paged-$range-1 ) || $max_num_pages <= $showitems ) ) {
					$pagination .= ( $paged == $i )? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link( $i )."' class='inactive' >".$i."</a>";
				} // if()
			} // for()

			if ( $paged < $max_num_pages && $showitems < $max_num_pages )
				$pagination .= "<a href='".get_pagenum_link( $paged + 1 )."'>&rsaquo;</a>";
			if ( $paged < $max_num_pages - 1 &&  $paged + $range - 1 < $max_num_pages && $showitems < $max_num_pages )
				$pagination .= "<a href='".get_pagenum_link( $max_num_pages )."'>&raquo;</a>";
			$pagination .= "</div>\n";
		} // if()

		if ( $output )
			echo $pagination;

		return $pagination;
	} // pagination()



	/**
	 * Retrieve the post excerpt.
	 *
	 * @param integer $id Post ID to retrieve the excerpt for
	 *
	 * @return string       The post excerpt
	 */
	public function get_the_excerpt( $id = false, $allowable_tags = array(), $excerpt_length = 55, $excerpt_more = '...' ) {
		$post    = get_post( $id );
		$excerpt = trim( $post->post_excerpt );
		if ( ! $excerpt ) {
			$excerpt        = $post->post_content;
			$excerpt        = strip_shortcodes( $excerpt );
			$excerpt        = apply_filters( 'the_content', $excerpt );
			$excerpt        = str_replace( ']]>', ']]&gt;', $excerpt );
			$excerpt        = strip_tags( $excerpt, $allowable_tags );
			$excerpt_length = ( $excerpt_length == 55 ) ? apply_filters( 'excerpt_length', $excerpt_length ) : $excerpt_length;
			// $excerpt_more = '<a href="'. get_permalink($post->ID) . '" class="more-link lato-bold-italic">Read More</a>';

			$words = preg_split( "/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
			if ( count( $words ) > $excerpt_length ) {
				array_pop( $words );
				$excerpt = implode( ' ', $words );
				$excerpt = $excerpt . $excerpt_more;
			} else {
				$excerpt = implode( ' ', $words );
			}
		}

		return $excerpt;
	} // get_the_excerpt()



	/**
	 * Display the post content.
	 *
	 * @param STDObject $post           Optional. The post object
	 * @param string  $more_link_text Optional. Content for when there is more text.
	 * @param bool    $strip_teaser   Optional. Strip teaser content before the more text. Default is false.
	 */
	function the_content( $post = null, $more_link_text = null, $strip_teaser = false ) {
		$content = get_the_content( $post, $more_link_text, $strip_teaser );
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;
	} // the_content()



	/**
	 * Retrieve the post content.
	 *
	 * @param STDObject $post           Optional. The post object
	 * @param string  $more_link_text Optional. Content for when there is more text.
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 * @return string
	 */
	function get_the_content( $post = null, $more_link_text = null, $strip_teaser = false ) {
		global $page, $more, $preview, $pages, $multipage;

		if ( is_null( $post ) )
			$post = get_post();

		if ( null === $more_link_text )
			$more_link_text = __( '(more&hellip;)' );

		$output = '';
		$has_teaser = false;

		// If post password required and it doesn't match the cookie.
		if ( post_password_required( $post ) )
			return get_the_password_form( $post );

		if ( $page > count( $pages ) ) // if the requested page doesn't exist
			$page = count( $pages ); // give them the highest numbered page that DOES exist

		$content = $pages[$page - 1];
		if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
			$content = explode( $matches[0], $content, 2 );
			if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
				$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );

			$has_teaser = true;
		} else {
			$content = array( $content );
		}

		if ( false !== strpos( $post->post_content, '<!--noteaser-->' ) && ( ! $multipage || $page == 1 ) )
			$strip_teaser = true;

		$teaser = $content[0];

		if ( $more && $strip_teaser && $has_teaser )
			$teaser = '';

		$output .= $teaser;

		if ( count( $content ) > 1 ) {
			if ( $more ) {
				$output .= '<span id="more-' . $post->ID . '"></span>' . $content[1];
			} else {
				if ( ! empty( $more_link_text ) )
					$output .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-{$post->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
				$output = force_balance_tags( $output );
			}
		}

		if ( $preview ) // preview fix for javascript bug with foreign languages
			$output = preg_replace_callback( '/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output );

		return $output;
	} // get_the_content(



	/**
	 * Outputs previous and next navigation when supplied a post object
	 *
	 * @param STDObject $post WP post object
	 *
	 * @return Void
	 */
	public function output_prev_next_nav( $post ) {

		$post_type = get_post_type( $post );

		// have to get the url for the next post to use in our faux link

		// first let's be sure that everything is getting reset properly
		$nepo              = '';
		$prepo             = '';
		$nepoid            = '';
		$prepoid           = '';
		$next_post_url     = '';
		$previous_post_url = '';
		$prev_and_next     = '';

		if ( $post_type == 'post' ) {

			// we can use some built in stuff for regular posts

			if ( get_next_post() ) {

				$nepo          = get_next_post();
				$nepoid        = $nepo->ID;
				$next_post_url = get_permalink( $nepoid );

			}

			if ( get_previous_post() ) {

				$prepo          = get_previous_post();
				$prepoid        = $nepo->ID;
				$previous_post_url = get_permalink( $nepoid );

			}

		} else {

			// looks like we have to use some more grown up stuff for
			// custom post types
			// so get the previous and next post ids from this method

			$prev_and_next = $this->next_post( $post );

			$next_post_url = !empty( $prev_and_next['next'] ) ? get_permalink( $prev_and_next['next'] ) : '';
			$prev_post_url = !empty( $prev_and_next['prev'] ) ? get_permalink( $prev_and_next['prev'] ) : '';

		}

		echo '<section class="span6 trans-block content-block underline direction-nav">';

		echo '<div class="inner-pad-all">';

		if ( $post_type == 'post' ) {

			if ( get_previous_post() ) {
				previous_post_link(
					'%link',
					'<span class="title1">&lt; Previous article</span>' );

			}

			if ( get_next_post() ) {
				next_post_link(
					'%link',
					'<span class="title1 fr">Next article &gt;</span>' );
			}

		} else {
			// again, need to account for custom post types here
			if ( $prev_post_url ) {
				echo '<a href="'.$prev_post_url.'"><span class="title1">&lt; Previous '.$post_type.' </span></a>';
			}

			if ( $next_post_url ) {
				echo '<a href="'.$next_post_url.'"><span class="title1 fr">Next '.$post_type.' &gt;</span></a>';
			}

		}
		echo '<div class="cl"></div>';
		echo '</div>';

		echo '</section>';
	} // output_prev_next_nav()



	/**
	 * Retrieves the next and previous post with the same sort of functionality for the built in post types
	 *
	 * appearently there are some issues with next_post_link() and custom post types
	 * so i guess we're gonna make our own :)
	 *
	 * @param STDObject $post WP post object
	 *
	 * @return string[] $return {
	 *  @type integer $prev The ID of the previous post
	 *  'next' => $prev
	 * }
	 */
	public function next_post( $post ) {
		$query_args = array(
			'post_type'      => $post->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1        // TODO: leaving this unbounded is bad news bears
		);

		// adjust order for service post type
		if ( get_post_type( get_the_id() ) == 'service' ) {
			$query_args['orderby'] = 'title';
			$query_args['order']   = 'ASC';
		}
		$query = new WP_Query( $query_args );
		$posts = $query->get_posts();
		$ids   = array();

		foreach ( $posts as $item )
			array_push( $ids, $item->ID );

		$current = $post->ID;
		$prev_key = array_search( $current, $ids, true ) + 1;
		$next_key = array_search( $current, $ids, true ) - 1;

		if ( $prev_key == count( $sorting ) )
			$prev_key = 0; // reached end of array, reset

		if ( $next_key == 1 )
			$next_key = 0; // beginning of array, reset

		$prev = $ids[$prev_key];
		$next = $ids[$next_key];

		return array(
			'prev' => $prev,
			'next' => $next
		);
	} // next_post()



	/**
	 * Retrieves attachments for the supplied parent post ID
	 *
	 * @param integer $post_id The parent post ID
	 * @param string[] $args    {
	 *  @type integer $numberposts Optional. The amount of attachments to return, defaults to -1
	 * }
	 *
	 * @return array             The retrieved attachments
	 */
	public function get_attachments( $post_id, $args = array() ) {
		// try to get the global post in case it wasn't passed
		if ( empty( $post ) )
			global $post;

		extract( $args );

		$numberposts = ( isset( $numberposts ) ) ? $numberposts : -1;

		$args = array(
			'post_type'   => 'attachment',
			'numberposts' => $numberposts,
			'post_status' => null,
			'order'       => 'ASC',
			'orderby'     => 'menu_order',
			'post_parent' => $post_id
		);

		$attachments = get_posts( $args );

		return $attachments;
	} // get_attachments()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function print_attachments( $args = array() ) {

		$limit        = isset( $args['limit'] )        ? $args['limit']        : '';
		$post         = isset( $args['post'] )         ? $args['post']         : '';
		$gallery_type = isset( $args['gallery_type'] ) ? $args['gallery_type'] : 'gallery';

		// get the attachments if they weren't passed
		$attachments = isset( $args['attachments'] ) ? $args['attachments'] : '';

		if ( empty( $attachments ) ) {
			$attachments = $this->get_attachments( $post, array( 'limit' => $limit ) );
		}

		// attachments have to be greater than 1 to
		// be sure that we're not grabbing only
		// the featured image
		if ( count( $attachments ) > 1 ) {

			echo '<div class="slider '.$gallery_type.'">';
			echo '<ul class="slides">';

			$i = 0;
			$end_i = 2;
			foreach ( $attachments as $attachment ) {

				$li_class = $i < 1 ? 'current-slide' : '';

				// for the thumb
				$attachment_url      = wp_get_attachment_image_src( $attachment->ID, '60x60' );

				// for the large gallery image
				$attachment_full_url = wp_get_attachment_image_src( $attachment->ID, 'x475' );

				// for the large fancybox (lightbox) image
				$attachment_large_url= wp_get_attachment_image_src( $attachment->ID, 'large' );

				if ( ! $attachment_url )
					continue;

				// replace quotes so excerpts pass properly
				$excerpt = !empty( $attachment->post_content ) ? str_replace( '"', '&quot;', $attachment->post_content ) : str_replace( '"', '&quot;', $attachment->post_excerpt );

				$excerpt = empty( $excerpt ) ? $attachment->post_title : $excerpt;


				// let's try to keep the gallery-trigger class as just a js trigger...
				// try not to attach styles to it

				echo '<li
						class="span1_5 gallery-trigger '.$li_class.'"
						data-image-url="'.$attachment_full_url[0].'"
						data-thumb="'.$attachment_url[0].'"
						data-full-image-url="'.$attachment_full_url[0].'"
						data-image-caption="'.$attachment->post_excerpt.'">';

				echo '<img src="'.$attachment_full_url[0].'">';
				echo '</li>';

				$i++;
			}

			echo '</ul>';
			echo '</div>';

		} // end if $attachments
	} // print_attachments()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function roll_template( $posts = array() ) {
		// pass me an array of posts, and i'll return
		// the html of the layout (list)
		$html = '';

		foreach ( $posts as $post ) {
			if ( get_post_type( $post->ID ) == 'toolbox_talk' ) {
				// link to pdf instead of post for toolbox talks
				// so first, get the pdf attachements (although we'll only use the first

				$args = array(
					'post_mime_type' => 'application/pdf',
					'post_type'      => 'attachment',
					'numberposts'    => 1,
					'post_status'    => null,
					'post_parent'    => $post->ID
				);

				$attachments = get_posts( $args );
				$target      = '_self';

				if ( $attachments ) {
					$link_to_post = $attachments[0]->guid;
					$target       = '_blank';
				} else {
					$link_to_post = '';
				}

			} else {
				// link to the post for everything else
				$link_to_post = get_permalink( $post->ID );
			}
			$html .= '<li class="clickable-mobile" data-faux-link="'.$link_to_post.'">';

			if ( has_post_thumbnail( $post->ID ) ) {

				$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '210x165', false, '' );

			} else {

				$src = array( '/assets/img/site/place-holder.png' );

			}
			$html .= '<div class="lazy-image small-featured fl" data-image-url="'.$src[0].'">';
			$html .= '<a href="'.$link_to_post.'" target="'.$target.'">';
			$html .= '<noscript><img src="'.$src[0].'" alt="'.$link_to_post.'" /></noscript>';
			$html .= '</a>';
			$html .= '</div>';

			$html .= '<div class="copy">';
			$html .= '<h2 class="title2">';
			$html .= '<a href="'.$link_to_post.'" target="'.$target.'">';
			$html .= $post->post_title;
			$html .= '</a>';
			$html .= '</h2>';
			$html .= $this->determine_teaser_format( $post );
			$html .= '</div>';
			$html .= '<a href="'.$link_to_post.'" class="more-link fr" target="'.$target.'">more &gt;</a>';
			$html .= '</li>';
		}

		return $html;
	} // roll_template()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function determine_teaser_format( $post = array() ) {
		// pass a post object and this guy will return the html for the teaser
		// based on things like title length etc...
		$title_length = strlen( $post->post_title );

		// only show excert if titles are shorter than this
		$excerpt_threshold = 50;
		$excerpt = $this->get_the_excerpt( $post );

		$html  = '';

		// disabling this since we made the font size smaller
		// if( $title_length > $excerpt_threshold ){
		// return;
		// } else {
		$html .= !empty( $excerpt ) ? '<p>'.$excerpt.'</p>' : '';

		// }

		return $html;
	} // determine_teaser_format()



	/**
	 * Retrieves the YouTube video ID from the supplied embed code
	 *
	 * @param string  $embed YouTube embed code
	 *
	 * @return [type]        [description]
	 */
	public function get_youtube_id( $embed ) {

		// pass me a link or an embed code and I'll return the youtube id for the video
		preg_match( '#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $embed, $matches );
		if ( isset( $matches[2] ) && $matches[2] != '' ) {
			$youtube_id = $matches[2];
		}

		return $youtube_id;
	} // get_youtube_id()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function get_video( $post = array() ) {
		// pass me a post array, and i'll return the html
		// for the video (if one exists
		$embed = get_post_meta( $post->ID, 'videoEmbed', true );
		$html = '';

		if ( !empty( $embed ) ) {
			$youtube_id = $this->get_youtube_id( $embed );

			$html .= '<section class="span6 trans-block content-block">';
			$html .= '<div class="inner-pad-all">';

			$html .= '<iframe width="100%" height="315" src="http://www.youtube.com/embed/'.$youtube_id.'?rel=0" frameborder="0" allowfullscreen></iframe>';

			$html .= '</div>';
			$html .= '</section>';
		}

		return $html;
	} // get_video()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function clean_multi_input( $multi_input = '' ) {
		// this converts the multi_input from it's saved state (fake sorta json object thingy)
		// to a php array

		// make it a valid json object
		$multi_input = str_replace( '|', '"', $multi_input );

		// decode to get make it php friendly array
		$multi_input = json_decode( $multi_input );

		return $multi_input;
	} // clean_multi_input()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function group_multi_input( $multi_input = '' ) {

		// this method will get the multi_input, clean them via this->clean_multi_input, and return them in a grouped array

		// clean/format multi_input
		$multi_input = $this->clean_multi_input( $multi_input );

		$i      = 1;
		$multi_input_fields_count= 3; // this is the number of fields for each group of rewards
		$tracker    = 1;
		$grouped_array  = array();

		foreach ( $multi_input as $award ) {

			// iterate through multi_input, building an award (item) with each field
			if ( $tracker == 1 ) {
				//first in group
				$item = array();
			}

			array_push( $item, $award );

			if ( $tracker == $multi_input_fields_count ) {
				// last in group

				array_push( $grouped_array, $item );

				$tracker = 1; // reset tracker

			} else {
				$tracker++;
			}

			$i++;
		}

		return $grouped_array;
	} // group_multi_input()



	/**
	 *
	 *
	 * @todo Audit and document this method
	 */
	public function get_img_urls( $attachment_id = '' ) {
		// pass id of attachment
		// return array of image urls for different sizes

		// for the thumb
		$attachment_url      = wp_get_attachment_image_src( $attachment_id, '60x60' );

		// for the large gallery image
		$attachment_full_url = wp_get_attachment_image_src( $attachment_id, 'x475' );

		// for the large fancybox (lightbox) image
		$attachment_large_url= wp_get_attachment_image_src( $attachment_id, 'large' );

		if ( ! $attachment_url )
			return false;

		return array(
			'small'   => $attachment_url[0],
			'medium'  => $attachment_full_url[0],
			'large'   => $attachment_large_url[0],
		);

	} // get_img_urls()



	/**
	 * Get attachment ID from src url
	 *
	 * @param string  $attachment_url Absolute URI to an attachment
	 *
	 * @return integer Post ID
	 */
	public function get_attachment_id_from_src( $attachment_url ) {
		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_url'";
		$id    = $wpdb->get_var( $query );
		return $id;
	} // get_attachment_id_from_src()
} // END Class MDG_Generic()

global $mdg_generic;
$mdg_generic = new MDG_Generic();
