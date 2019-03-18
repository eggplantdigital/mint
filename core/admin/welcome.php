<?php
/**
 * Welcome Screen
 *
 * Creates a simple welcome screen when the theme is activated or updated.
 * Welcome screen explains the latest updates, and will be changed for each version release.
 * 
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.5.0
 */
 
/**
* Welcome Screen Activate
*
* Set a transient t.
*
* @since 1.5.0
*/ 
function mint_welcome_screen_activate() {

	// Bail if no activation redirect
	if ( get_transient( '_mint_welcome_screen_activation_redirect' ) ) {
		return;
	}
	
	// Delete the redirect transient
	set_transient( '_mint_welcome_screen_activation_redirect', true, 30 );
	
	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}
	
	// Redirect to welcome page
	wp_safe_redirect( add_query_arg( array( 'page' => 'mint-welcome-screen' ), admin_url( 'themes.php' ) ) );

}
add_action( 'after_switch_theme', 'mint_welcome_screen_activate' );

if ( !function_exists('mint_welcome_screen_pages')) :
/**
* Add Welcome Screen
*
* Adds the welcome screen to the dashboard menu section.
*
* @since 1.5.0
*/
function mint_welcome_screen_pages() {
	
	global $theme;
	
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( __( 'Welcome To %s', 'mint' ), $theme->get( 'Name' )),
		sprintf( __( 'Welcome To %s', 'mint' ), $theme->get( 'Name' )),
		'read',
		'mint-welcome-screen',
		'mint_welcome_screen_content'
	);
}
add_action('admin_menu', 'mint_welcome_screen_pages');
endif;

if ( !function_exists('mint_welcome_screen_content')) :
/**
* Welcome Screen Content
*
* The text and pictures to introduce the latest Mint Theme version.
*
* @since 1.5.0
*/
function mint_welcome_screen_content() {
	
	global $theme;
?>
	<div class="wrap about-wrap">
		<h1><?php printf( __( '%s Theme v%s', 'mint' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ); ?><span class="ct_logo"><a href="https://www.charitythemes.org" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/core/assets/img/logo_ct_2x_pink.png" alt="" style="margin-top: 10px;
    margin-left: 10px;" /></a></span></h1>

		<div class="about-text"><?php printf( __( 'Thank you for using %s Theme!', 'mint' ), $theme->get( 'Name' )); ?></div>

		<h2 class="nav-tab-wrapper">
			<a href="?page=welcome-screen-about" class="nav-tab nav-tab-active"><?php _e( 'Welcome', 'mint' ); ?></a>
		</h2>

		<div class="headline-feature feature-section one-col" style="text-align: center;">
			<div class="media-container" style="margin-top: 20px;">
				<img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" />
			</div>
		</div>

		<hr />

		<div class="feature-section two-col">
			<div class="col">
				<div class="media-container">
					<img src="<?php echo get_template_directory_uri(); ?>/core/assets/img/post-slider-background-options.png" alt="Post%20Slider%20Background%20Options" width="777" height="402" />
				</div>
			</div>
			<div class="col">
				<h3><?php _e( 'Post Slider Images', 'mint' ); ?></h3>
				<p><?php _e( 'When you add or edit a blog post, you will see a new control panel (shown on left). This is used to add either a slider image or color to this posts slide. Giving you full control to make each slide look unique!', 'mint' ); ?></p>
			</div>
		</div>

		<hr />

		<div class="feature-section two-col">
			<div class="col">
				<div class="media-container" style="text-align: center;">
					<img src="<?php echo get_template_directory_uri(); ?>/core/assets/img/slider-customizer.png" alt="slider-customizer" width="283" height="322" />
				</div>
			</div>
			<div class="col">
				<h3><?php _e( 'Customize your slider', 'mint' ); ?></h3>
				<p><?php _e( 'From the WordPress customizer, you can change a few of the slider settings, such as the animation speed, whether to show the controls or not and the direction your images slider.', 'mint' ); ?></p>
			</div>
		</div>

		<hr />

		<div class="feature-section two-col">
			<div class="col">
				<div class="media-container" style="text-align: center;">
					<img src="<?php echo get_template_directory_uri(); ?>/core/assets/img/layout-customizer.png" alt="" />
				</div>
			</div>
			<div class="col">
				<h3><?php _e( '2 different layouts', 'mint' ); ?></h3>
				<p><?php _e( 'Swapping between the Wide and Boxed layouts for your blog, also changes the arrangement of the slider.', 'mint' ); ?></p>
			</div>
		</div>

		<hr />

		<div class="changelog">
			<h3><?php _e( 'We Need Your Help!', 'mint' ); ?></h3>

			<div class="feature-section under-the-hood three-col">
				<div class="col">
					<h4><?php _e( 'Suggest a feature!', 'mint' ); ?></h4>
					<p><?php echo sprintf( __( 'Do you have an idea for a great feature on our next version of this theme? Or perhaps there is something you don\'t like and want us to improve, <a href="%s" target="_blank">please let us know</a>, we\'d love to hear from you!', 'mint'), 'https://www.facebook.com/charitythemes.org/'); ?></p>
				</div>
				<div class="col">
					<h4><?php _e( 'Like Our Work? Give us 5 stars!', 'mint' ); ?></h4>
					<p><?php echo sprintf(__( 'We have over a 1000 active users of our Themes, which is pretty great! If you can spare a moment, please rate us on <a href="%s" target="_blank">wordpress.org</a>.', 'mint' ), 'https://wordpress.org/themes/mint/'); ?></p>
				</div>
				<div class="col">
					<h4><?php _e( 'Like us on Facebook', 'mint' ); ?></h4>
					<p><?php echo sprintf(__( 'Get our latest updates by <a href="%s" target="_blank">following us on Facebook!</a>', 'mint' ), 'https://www.facebook.com/charitythemes.org/'); ?></p>
				</div>
			</div>

			<div class="return-to-dashboard">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? _e( 'Return to Updates', 'mint' ) : _e( 'Return to Dashboard &rarr; Updates', 'mint' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home', 'mint' ) : _e( 'Go to Dashboard', 'mint' ); ?></a>
			</div>

		</div>
	</div>
  <?php
}

endif;

if ( !function_exists('mint_welcome_screen_remove_menus')) :
/**
* Remove From Menus
*
* Remove the menu item from the dashboard menu.
*
* @since 1.5.0
*/
function mint_welcome_screen_remove_menus() {
	remove_submenu_page( 'themes.php', 'mint-welcome-screen' );
}
add_action( 'admin_head', 'mint_welcome_screen_remove_menus' );
endif;
?>