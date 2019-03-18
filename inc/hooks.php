<?php
/**
 * General Theme Actions
 *
 * Actions are called with the function do_action().
 * 
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference
 * 
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.3.0
 */

if (!function_exists('mint_page_featured_image')) :
/**
 * Adds a featured image on pages.
 *
 * @since 1.3.0
 */
function mint_page_featured_image() {
	global $post;
	
	// If this post has a thumbnail and we are looking at a page.
	if ( has_post_thumbnail() && is_page() ) {
		
		// Get the thumbnail data.
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID ); 
		$post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		$post_thumbnail_data = get_post( $post_thumbnail_id );
		?>
		<div class="banner-cover-wrapper cover-image" <?php echo 'style="background-image: url('.$post_thumbnail[0].'); height: '.$post_thumbnail[2].'px;"'; ?>>
			
			<?php 
			// Additional action for adding content over the featured image.
			do_action( 'mint_featured_image_content' ); ?>
			
			<?php 
			// If this image has a title or an excerpt we can display that over the image.	
			if ( $post_thumbnail_data->post_title || $post_thumbnail_data->post_excerpt ) { ?>
			<div class="darken">
				<div class="copy-container">
				<?php 
				// Show the title if it exists.
				if ( $post_thumbnail_data->post_title ) {
					echo '<h1>'.$post_thumbnail_data->post_title.'</h1>';
				}	
				// Show the excerpt if it exists.
				if ( $post_thumbnail_data->post_excerpt ) {
					echo '<p class="excerpt">'.$post_thumbnail_data->post_excerpt.'</p>';
				}	
				?>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php
	}
}
add_action( 'mint_container_above', 'mint_page_featured_image' ); 
endif;

if (!function_exists('mint_front_page_slider')) :
/**
* Add slider onto the front page or index page
*
* Includes the slider using a template part. Override this in a Child theme.
* The slider only show on the index page (blog or page) & when the slider is activated
*
* @since 1.5.0
*/ 
function mint_front_page_slider() {

	if ( is_front_page() && get_theme_mod( 'mint_show_slider' ) ) {
		
		get_template_part( 'partials/slider/default');
	
	}
}
endif;
add_action( 'mint_container_above', 'mint_front_page_slider' );

if (!function_exists('mint_slider_query')) :
/**
 * Posts Slider Query
 * 
 * This query grabs the posts depending on the options selected in the Customizer.
 *
 * @since 1.5.0
 */
function mint_slider_query( $query ) {
	
	// Only run if we are on the main loop.
	if ( !$query->is_main_query() )
		return;
	
	// Only run the query if the slider is turned on and it's the blog page.
	if ( ! is_home() || ! get_theme_mod( 'mint_show_slider' ) )
		return;
		
	// Use a global variable to hold the query results.
	global $slider_query;
	
	// Limit the number of slides we show by 5, but can be overridden in the Customizer.
	$limit = ( get_option( 'mint_slider_num_of_posts' ) ) ? get_option( 'mint_slider_num_of_posts' ) : 5;

	// Basic arguments
	$args = array( 
		'post_type' 		  => 'post',
		'posts_per_page' 	  => $limit, 
		'paged' 		 	  => 1,
 		'ignore_sticky_posts' => 1
	);

	// If set in Customizer use sticky posts only
	if ( get_theme_mod( 'mint_slider_display_type' ) == 'sticky' ) {
		$sticky = get_option( 'sticky_posts' );
		$args['post__in'] = $sticky;
	
	// If set in Customizer use posts with a certain tag.
	} elseif ( get_theme_mod( 'mint_slider_display_type' ) == 'tag' ) {
		$tags = get_option( 'mint_slider_posts_tag' );
		if ( $tags != '' ) {
			$args['tag'] = $tags;
		}
	}
	
	// Store the query results in a global variable.
	$slider_query = new WP_Query( $args );
}
add_action( 'pre_get_posts', 'mint_slider_query' ); 
endif;

if (!function_exists('mint_exclude_slider_posts')) :
/**
 * Exclude Slider Query
 *
 * If in the customizer the user chooses to exclude slider posts from the main blog. 
 * This action removes those posts from the main post query.
 * 
 * @since 1.5.0
 */
function mint_exclude_slider_posts( $query ) {
	
	// Only run if we are on the main loop.
	if ( ! $query->is_main_query() )
		return;

	// Only run the query if the slider is turned on and it's the blog page.
	if ( ! is_home() || ! get_theme_mod( 'mint_show_slider' ) )
		return;

	// Only proceed if the user is not asking to repeat posts in the main loop.
	if ( get_theme_mod( 'mint_slider_posts_in_loop' ) )
		return;

	// Get our query through a global variable.
	global $slider_query;
		
	// Pluck the ID's out of the main slider query.
	$post_ids = wp_list_pluck( $slider_query->posts, 'ID' ); 
	
	// Exclude posts ID's from the main loop.
	$query->set( 'post__not_in', $post_ids );
}
add_action( 'pre_get_posts', 'mint_exclude_slider_posts' );
endif;

if (!function_exists('mint_hide_page_title')) :
/**
 * Hide Page Title
 *
 * Hide the page title on the front page.
 * 
 * @since 1.6.0
 */
function mint_hide_page_title() {
	
	if ( is_front_page() )
		return false;
		
	return true;
}
add_filter( 'mint_show_page_title', 'mint_hide_page_title', 5 );
endif;

if ( ! function_exists('mint_front_page_blog')) :
/**
 * Show 3 blog posts to the homepage
 *
 * @since 1.6.0
 */
function mint_front_page_blog() {
	if ( is_front_page() && get_option( 'show_on_front')!='posts' && ! get_theme_mod( 'mint_disable_posts' ) ) {
		get_template_part( 'partials/blog/posts', 'grid' );
	}	
}
add_action( 'mint_section_inside_below', 'mint_front_page_blog', 15 );
endif;