<?php
/**
 * Mint functions and definitions
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0.0
 */

/**
 * Define some global variables to use within core functions
 *
 * @since 1.5.0
 */
define( 'MINT_TEMPLATE_URI' , get_template_directory_uri() );
define( 'MINT_TEMPLATE_DIR' , get_template_directory() );
define( 'MINT_VERSION' , '1.6.7' );

/**
 * If it is not set already, we should set the content width.
 *
 * @link http://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

/*
 * Load Customizer Support
 *
 *		Typography @since Mint 1.2.0
 */
require_once get_template_directory() . '/core/customizer/init.php';
require_once get_template_directory() . '/core/customizer/typography.php';

/*
 * Load Front-end helpers
 *
 * 		Layout @since Mint 1.6.0
 */
require_once get_template_directory() . '/core/helpers/post.php';
require_once get_template_directory() . '/core/helpers/layout.php';

/*
 * Load Post Types & Post Meta Support
 *
 * @since Mint 1.5.0
 */
require_once get_template_directory() . '/core/meta/init.php';
require_once get_template_directory() . '/core/meta/post-meta.php';

/*
 * Load Welcome Screen
 *
 * @since Mint 1.5.0
 */
require_once get_template_directory() . '/core/admin/welcome.php';

/*
 * Load Includes
 *
 * @since Mint 1.6.5
 * 		Add Woocommerce support @since 1.6.7
 */
require_once get_template_directory() . '/inc/hooks.php';
require_once get_template_directory() . '/inc/template-hooks.php';
require_once get_template_directory() . '/inc/template-parts.php';
require_once get_template_directory() . '/inc/woocommerce.php';

if (!function_exists('mint_theme_setup')) :
/**
 * Adding theme features via 'after_setup_theme'
 *
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support
 * @since 1.0.3
 */
 function mint_theme_setup(){

	/**
	 * Adds theme support for a few useful things.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support
	 * @since 1.0.0
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Custom header is an image that is chosen as the representative image 
	 * in the theme top header section.
	 *
	 * @link https://codex.wordpress.org/Custom_Headers
	 * @since 1.1.0
	 */	
	add_theme_support( 'custom-header', array(
		'width' => 1300, 'height' => 240, 'header-text' => true, 'flex-height' => true, 'flex-width' => true
	) );
		
	/**
	 * This theme uses wp_nav_menu() for the main menu.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
	 */
	register_nav_menus( array(
		'primary-menu' => __('Primary Menu', 'mint')
	) );
	
	/**
	 * A slider sized image for the slide.
	 * Cropping behavior for the homepage blog post images.
	 * Hard Crop Top Left.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_image_size/
	 */
	add_image_size( 'slide-image', 1200, 450, false );
	add_image_size ( 'home-posts', 700, 580, array( 'left', 'top' ) );	

	/*
	 * Add Woocommerce Support
	 *
	 * @link https://docs.woocommerce.com/document/woocommerce-theme-developer-handbook/
	 * @since 1.6.7
	 */	
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 150,
		'single_image_width'    => 300,
        'product_grid' => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
	));
}
endif;
add_action( 'after_setup_theme', 'mint_theme_setup');

if (!function_exists('mint_register_styles')) :
/**
 * What's a WordPress theme without stylesheets.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 */
function mint_register_styles() {

	wp_enqueue_style( 'bootstrap' 	, get_template_directory_uri() . '/css/bootstrap.min.css', false, '3.3.7');
	wp_enqueue_style( 'fontawesome'	, get_template_directory_uri() . '/css/font-awesome.min.css', false, '4.2.1');
	wp_enqueue_style( 'main'	 	, get_template_directory_uri() . '/css/main.css', array( 'bootstrap' ), '1.1.0');
	wp_enqueue_style( 'social'	 	, get_template_directory_uri() . '/css/social.css', array( 'main' ), '1.0.3');
	
	if ( is_front_page() && get_theme_mod( 'mint_show_slider' ) == '1' ) {
		wp_enqueue_style( 'bxslider' , get_template_directory_uri() . '/css/bxslider.min.css', false, '4.2.12');
	}
	
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'mint-woocommerce', get_template_directory_uri() . '/css/woo.css', array( 'main' ), '1.0.0');		
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'mint_register_styles' );

if (!function_exists('mint_register_scripts')) :
/**
 * Most sites these days have some jQuery including this theme.
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 */
function mint_register_scripts() {
	
	wp_enqueue_script( 'mint_respond', get_template_directory_uri() . '/js/respond.min.js', array('jquery'), '1.4.2', true );
	wp_enqueue_script( 'mint_global', get_template_directory_uri() . '/js/global.js', array('jquery'), '1.0.1', true );
	
	if ( ( is_front_page() || is_home() ) && get_theme_mod( 'mint_show_slider' ) == '1' ) {
		wp_enqueue_script( 'bxslider' , get_template_directory_uri() . '/js/bxslider.min.js', false, '1.4.2');
	}

	if ( is_singular() ) 
		wp_enqueue_script( 'comment-reply' );		

	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_script( 'mint_woo', get_template_directory_uri() . '/js/woo.js', array('jquery'), '1.0.0', true );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'mint_register_scripts' );

if (!function_exists('mint_register_sidebars')) :
/**
 * Register primary and secondary sidebars on the site
 * 
 * @since Mint 1.0.0
 */
function mint_register_sidebars() {

	register_sidebar( array (
		'name' => 'Primary Sidebar',
		'id' => 'primary-widget-area',
		'description' => __( 'The primary sidebar', 'mint' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => 'Secondary Sidebar',
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary sidebar', 'mint' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	$total = get_theme_mod('mint_footer_sidebars');	
	
	if ($total && $total != '0') {

		$i=0; while ($i < $total) {
			
			$i++;
			register_sidebar( array (
				'name' => 'Footer '.$i,
				'id' => 'footer-'.$i, 
				'description' => __( 'Footer Widget Area', 'mint' ), 
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			));
		}
	}		

	/**
	 * A special sidebar for Woocommerce stores
	 *
	 * @since Mint 1.6.7
	 */
	if ( class_exists( 'woocommerce' ) ) {
		register_sidebar( array (
			'name' => 'Store Sidebar',
			'id' => 'store-widget-area',
			'description' => __( 'The store sidebar', 'mint' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
}
endif;
add_action( 'widgets_init', 'mint_register_sidebars' );

/**
 * These are the social networks available to add links to.
 *
 * @since Mint 1.1.0
 */
global $_mint_registered_social;
$_mint_registered_social = array(
	'twitter'		=> __('Follow us on Twitter', 'mint'),
	'facebook'		=> __('Connect on Facebook', 'mint'),
	'instagram'		=> __('Follow us on Instagram', 'mint'),
	'youtube'		=> __('Watch on Youtube', 'mint'),
	
	'google-plus'	=> __('Follow us on Google+', 'mint'),
	'reddit'		=> __('Follow us on Reddit', 'mint'),
	'vimeo'			=> __('Watch on Vimeo', 'mint'),
		
	'pinterest'		=> __('Follow us on Pinterest', 'mint'),
	'linkedin'		=> __('Connect on Linkedin', 'mint'),

	'weixin'		=> __('Connect on Wechat', 'mint'),
	'weibo'			=> __('Connect on Weibo', 'mint'),

	'rss'			=> __('Blog RSS Feed', 'mint'),
	'envelope'		=> __('Get in touch via email', 'mint')
);

if (!function_exists('mint_css_template')) :
/**
 * Output the CSS template in the header.
 *
 * This adds a header background image within the header.
 * Recommend header image size is '1300 x 240'.
 *
 * @since Mint 1.1.0
 */
function mint_css_template() {
	
	// Get the header image uploaded & header text color by the user in the customizer.
	$header_image = get_custom_header();
	$header_text_color = get_theme_mod( 'header_textcolor' );
	
	// Setup the css variable
	$css = '';
	
	// If a header image has been uploaded, set the CSS to be output in the website header.
	if ( isset( $header_image->url ) && $header_image->url != '' ) {
		$css = <<<CSS
	
#header {
  background: url( {$header_image->url} ) top center no-repeat; 
  background-size: cover; 
}
#header .inner-wrapper { 
  height: {$header_image->height}px;
}
CSS;
	}
	
	// If the color of the header text has been selected, set the CSS to output the hex code.
	if ( $header_text_color ) {
		$css .= <<<CSS
		
#header h1,
#header p {
  color: #{$header_text_color};
}
CSS;
	}
	
	if ( $css != '' )
		echo '<style type="text/css" media="screen" id="mint-css-tmpl">'.$css.'</style>';

}
add_action( 'wp_head', 'mint_css_template' );
endif;

if (!function_exists('mint_get_color_schemes')) :
/**
 * Color schemes.
 *
 * Array to hold the color schemes. There 6 colors schemes apart from the default. 
 * Add more by filtering the mint_color_schemes filter.
 *
 * @since Mint 1.4.0
 */
function mint_get_color_schemes() {
	return apply_filters( 'mint_color_schemes', array (
		'light' => array(
			'label'  => __( 'Light', 'mint' ),
			'colors' => array(
				'darkest'	=> '',
				'dark'		=> '',
				'medium'	=> '',
				'light'		=> '',
				'lightest'	=> ''
			)
		),
		'blue' => array(
			'label'  => __( 'Blue', 'mint' ),
			'colors' => array(
				'darkest'	=> '#135282',
				'dark'		=> '#196dad',
				'medium'	=> '#2188d6',
				'light'		=> '#9ed5ff',
				'lightest'	=> '#c5d6e4'
			)
		),
		'green' => array(
			'label'  => __( 'Green', 'mint' ),
			'colors' => array(
				'darkest'	=> '#235d39',
				'dark'		=> '#00953b',
				'medium'	=> '#00b552',
				'light'		=> '#7fdaa8',
				'lightest'	=> '#bde4cc'
			)
		),
		'yellow' => array(
			'label'  => __( 'Yellow', 'mint' ),
			'colors' => array(
				'darkest'	=> '#ffa400',
				'dark'		=> '#ffc72c',
				'medium'	=> '#fdde40',
				'light'		=> '#ffe395',
				'lightest'	=> '#fff1c8'
			)
		),
		'red' => array(
			'label'  => __( 'Red', 'mint' ),
			'colors' => array(
				'darkest'	=> '#ce112d',
				'dark'		=> '#f6343f',
				'medium'	=> '#ff5b5b',
				'light'		=> '#ff9d9d',
				'lightest'	=> '#fdcacd'
			)
		),
		'pink' => array(
			'label'  => __( 'Pink', 'mint' ),
			'colors' => array(
				'darkest'	=> '#a9123e',
				'dark'		=> '#d50058',
				'medium'	=> '#e74883',
				'light'		=> '#ee7fa8',
				'lightest'	=> '#f4bdd4'
			)
		),
		'orange' => array(
			'label'  => __( 'Orange', 'mint' ),
			'colors' => array(
				'darkest'	=> '#e14602',
				'dark'		=> '#ff6c38',
				'medium'	=> '#ff8e6c',
				'light'		=> '#ffb098',
				'lightest'	=> '#ffd9cb'
			)
		)
	));
}
endif;

if (!function_exists('mint_get_color_scheme')) :
/**
 * Get Color Scheme.
 *
 * Function to get a single color scheme option. 
 *
 * @since Mint 1.4.0
 */
function mint_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'mint_color_scheme', 'light' );
	$color_schemes       = mint_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['light']['colors'];
}
endif;

if (!function_exists('mint_color_scheme_css_output')) :
/**
 * Output Color Scheme
 *
 * Output the color scheme based on the user choice from within the customize
 *
 * @since Mint 1.4.0
 */
function mint_color_scheme_css_output() {
	
	// If there is no color scheme selected then exit
	if ( ! get_theme_mod( 'mint_color_scheme' ) )
		return false;
	
	// Preset Colour Schemes
	$color_presets = mint_get_color_schemes();
	
	$scheme = ( $c = get_theme_mod( 'mint_color_scheme' ) ) ? $color_presets[ $c ]['colors'] : $color_presets['light']['colors'];
	
	// Cycle through the preset scheme that has been chosen.
	foreach ( $scheme as $name => $code ) {
		
		// Check if any of the colors have been overridden by the user.
		if ( $new = get_theme_mod( 'mint_color_scheme_'.$name ) ) {
			
			// Set the color code to the overridden one.
			$scheme[ $name ] = $new;
		}
	}
	
	 if ( $c == 'blue' || $c == 'green' || $c == 'red' || $c == 'pink' || $c == 'orange' ) {
		 $menu = '#ffffff';
	 } else {
		 $menu = '#333333';
	 }

	$css = <<<CSS

/* Lightest Background Color */
body {
	background:{$scheme['lightest']};
}

#wrapper.wide {
	background:{$scheme['lightest']};
}		

/* Main Menu Background Color */
.boxed .nav-wrapper {
	background: {$scheme['darkest']};
    border-top-color: {$scheme['darkest']};
    border-bottom-color: {$scheme['darkest']};
}

/* Dropdown Menu Border Color */
.boxed .nav-wrapper .menu li:hover .children,
.boxed .nav-wrapper .menu li:hover .sub-menu {
	border-color: {$scheme['lightest']};
}

/* Main Text Color */
.page-header h1,
.page-header h2,
.page-header h3,
.nav-wrapper .menu li ul.children li a:hover,
.nav-wrapper .menu li ul.sub-menu li a:hover, 
.nav-wrapper .menu li ul.children li.current_page_item > a,
.nav-wrapper .menu li ul.sub-menu li.current_page_item > a,
.woocommerce-message::before,
.woocommerce div.product p.price, 
.woocommerce div.product span.price,
.woocommerce ul.products li.product .price {
	color: {$scheme['dark']};
}

/* Wide Menu Selected Background */
.wide .nav-wrapper .menu > li:hover:not(.menu-item-has-children) > a, 
.wide .nav-wrapper .menu > li.current-menu-item > a,
.nav-wrapper .menu li > ul.children, 
.nav-wrapper .menu li > ul.sub-menu,
.wide  .nav-wrapper .menu > li.current-page-ancestor > a, 
.wide  .nav-wrapper .menu > li.current_page_parent > a {
	border-color: {$scheme['dark']};
	color: {$scheme['dark']};
}
	
/* Border Highlight Color */
#footer-widgets,
#footer-subscribe-wrapper,
.woocommerce-message {
	border-color: {$scheme['medium']};
}

/* Light Background Color */
.top-bar,
.boxed .entry-footer {
	background-color: {$scheme['lightest']};
}

.wide .entry-footer,
.woocommerce span.onsale {
	background-color: {$scheme['light']};
}

/* Button Color */
.button, button, 
input[type="button"], 
input[type="reset"], 
input[type="submit"],
.bx-wrapper .bx-pager .bx-pager-item a:hover, 
.bx-wrapper .bx-pager .bx-pager-item a.active,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {
	background-color:{$scheme['darkest']};
}

button:hover, .button:hover, button:focus, .button:focus,
input[type="button"]:hover, 
input[type="reset"]:hover, 
input[type="submit"]:hover,  
input[type="button"]:focus, 
input[type="reset"]:focus, 
input[type="submit"]:focus,
.boxed .page-title-bar,
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt,
.woocommerce #respond input#submit.alt:hover, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover {
	background-color:{$scheme['dark']};
}

/* Link Color */
@media screen and (min-width : 768px){
	.boxed .nav-wrapper .menu li a {
		color:{$menu};
	}
}

/* Pagination */
.pagination .current, 
.pagination a:hover {
	background: {$scheme['dark']};
	border-color: {$scheme['light']};
	color:{$menu};
}

.pagination a:link, 
.pagination a:visited, 
.pagination a:active {
	border-color: {$scheme['light']};
}

CSS;
	?>
<style type="text/css" media="screen" id="mint-color-tmpl"><?php echo $css; ?></style>
	<?php
}
add_action( 'wp_head', 'mint_color_scheme_css_output' );
endif;