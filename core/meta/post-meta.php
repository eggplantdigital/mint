<?php
/**
 * Add Post Meta Box UI
 *
 * Adds meta box UI onto the edit / add new post UI. This is used for posts that display in the slider.
 *
 * @package		WordPress
 * @subpack		Mint
 * @since		Mint 1.5.0
 */
	
if ( ! function_exists( 'mint_post_metabox' ) ) :
function mint_post_metabox() {	

	$post_metabox = new Mint_Background_Meta_Box( 'post' );	
	$post_metabox->settings->title = __('Post Slider Image', 'mint');
}
endif;
add_action( 'admin_init', 'mint_post_metabox' );