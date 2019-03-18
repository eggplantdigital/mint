<?php
/**
 * Cusotmizer Theme Actions
 *
 * These options appear in the WordPress customizer
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * 
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0.0
 */

if ( !function_exists( 'mint_enqueue_live_preview' ) ) :
/**
* This hooks into 'customize_preview_init' and enqueues scripts to be used
* within the Theme Customize screen.
* 
* @since Mint 1.1.0
*/
function mint_enqueue_live_preview() {
	wp_enqueue_script( 'mint-customizer', get_template_directory_uri() . '/core/assets/js/theme-customizer.js', array(  'jquery', 'customize-preview' ), '1.1.0');
}
add_action( 'customize_preview_init' , 'mint_enqueue_live_preview' );
endif;

if ( !function_exists( 'mint_customize_control_js' ) ) :
/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 * 
 * @since Mint 1.4.0
 */
function mint_customize_control_js() {
	wp_enqueue_script( 'mint-extend-controls', get_template_directory_uri() . '/core/assets/js/customizer-extend.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '1.1.0', true );
	
	if ( function_exists( 'mint_get_color_schemes' )) {
		wp_localize_script( 'mint-extend-controls', 'colorScheme', mint_get_color_schemes() );
	}
}
add_action( 'customize_controls_enqueue_scripts', 'mint_customize_control_js', 20 );
endif;

/**
* This hooks into 'customize_register' (available as of WP 3.4) and allows
* you to add new sections and controls to the Theme Customize screen.
* 
* @see add_action('customize_register',$func)
* @param \WP_Customize_Manager $wp_customize
* @since Mint 1.0.0
*/
function mint_customize_register( $wp_customize ) {
	
	$image_folder_url =  get_template_directory_uri() . '/includes/images/';
	
	// Get the color scheme options
	// Function can be found in functions.php
	if ( function_exists( 'mint_get_color_scheme' ) ) {
		$color_scheme = mint_get_color_scheme();
	}
	
	/**
	 * Branding
	 *
	 * Upload a logo and a favicon to make the site your own
	 * 
	 * @since Mint 1.0.0
	 */
    $wp_customize->add_setting('mint_custom_logo', array(
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'option',
		'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'mint_custom_logo', array(
        'label'    		=> __('Upload Logo', 'mint'),
        'section'  		=> 'title_tagline',
        'settings' 		=> 'mint_custom_logo',
        'priority'		=> 15,
    )));
    
    $wp_customize->add_setting('mint_custom_favicon', array(
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'option',
		'transport' 		=> 'postMessage',
		'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'mint_custom_favicon', array(
        'label'    		=> __('Upload Favicon', 'mint'),
        'section'  		=> 'title_tagline',
        'settings' 		=> 'mint_custom_favicon',
        'priority'		=> 20,
    )));

	/**
	 * General
	 *
	 * Change the site to full width or box it in to a set width 
	 * 
	 * @since Mint 1.0.0
	 */
    $wp_customize->add_section('general', array(
        'title'    		=> __('General', 'mint'),
        'priority' 		=> 30,
        'description' 	=> __('Customize the general look & feel of your website', 'mint'),
    ));

	$wp_customize->add_setting('mint_layout_type', array(
    	'default'       	=> 'wide',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
		'sanitize_callback' => 'sanitize_html_class'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_layout_type', array(
        'label'    		=> __('Layout', 'mint'),
        'section'  		=> 'general',
        'settings' 		=> 'mint_layout_type',
        'type'          => 'select',
        'choices'       => array (
	        'wide'   => __('Wide', 'mint'),
        	'boxed'  => __('Boxed', 'mint'),
		)
    )));

	/**
	 * Disable latest posts on the homepage 
	 * @since Mint 1.6.2
	 */
	$wp_customize->add_setting('mint_disable_posts', array(
    	'default'       	=> '',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_disable_posts', array(
        'label'    		=> __('Disable latest posts on the homepage', 'mint'),
        'description'   => sprintf( __('Note: The latest posts will only appear when using a <a href="%s" target="_blank">static front page</a>', 'mint' ), 'https://codex.wordpress.org/Creating_a_Static_Front_Page' ),
        'section'  		=> 'general',
        'settings' 		=> 'mint_disable_posts',
        'type'          => 'checkbox'
    )));

	/**
	 * Use a tag to filter the posts
	 * @since Mint 1.6.4
	 */
	 $wp_customize->add_setting('mint_filter_homepage_posts', array(
    	'default'       	=> '',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_filter_homepage_posts', array(
        'label'    		=> __('Filter the posts that appear on the homepage using a tag', 'mint'),
        'description'   => __('', 'mint' ),
        'section'  		=> 'general',
        'settings' 		=> 'mint_filter_homepage_posts',
        'type'          => 'checkbox'
    )));

	// Tag(s) to be select the posts in the slider
	$wp_customize->add_setting('mint_tag_homepage_posts', array(
    	'default'			=> '',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_tag_homepage_posts', array(
    	'label'       	=> '',
    	'description'	=> __('Use the tag(s) slug below separated by a comma.', 'mint'),
        'section'  		=> 'general',
        'settings' 		=> 'mint_tag_homepage_posts',
        'type'          => 'text'
    )));	

	/**
	 * Blog
	 *
	 * Blog options 
	 * 
	 * @since Mint 1.3.0
	 */
	$wp_customize->add_section('blog', array(
        'title'    		=> __('Blog', 'mint'),
        'priority' 		=> 35,
        'description' 	=> __('Customize your blog', 'mint'),
    ));
	
	// Select a layout for the blog pages
    $wp_customize->add_setting('mint_blog_layout', array(
	    'default'           => 'two-col-left',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_blog_layout', array(
        'label'    => __( 'Layout', 'mint' ),
        'section'  => 'blog',
        'description' => __('This option affects your category, tag, author and search pages.', 'mint'),
        'settings' => 'mint_blog_layout',
        'type'	   => 'select',
        'choices'  => array (
			'one-col' 		   => __('No Sidebars', 'mint'),
			'two-col-left'     => __('Righthand Sidebar', 'mint'),
			'two-col-right'    => __('Lefthand Sidebar', 'mint'),
			'three-col-middle' => __('Both', 'mint')
		)
	)));

	/**
	 * Allow users to alter the single post layout 
	 * @since Mint 1.6.3
	 */
    $wp_customize->add_setting('mint_post_layout', array(
	    'default'           => 'two-col-left',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
	));

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_post_layout', array(
        'label'    => __( 'Post Layout', 'mint' ),
        'section'  => 'blog',
        'description' => __('This option affects single blog posts.', 'mint'),
        'settings' => 'mint_post_layout',
        'type'	   => 'select',
        'choices'  => array (
			'one-col' 		   => __('No Sidebars', 'mint'),
			'two-col-left'     => __('Righthand Sidebar', 'mint'),
			'two-col-right'    => __('Lefthand Sidebar', 'mint'),
			'three-col-middle' => __('Both', 'mint')
		)
	)));
		
	// Turn on / off the about author section.
	$wp_customize->add_setting('mint_blog_about_author', array(
	    'default'           => '',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_blog_about_author', array(
        'label'    => __( 'Hide About Author', 'mint' ),
        'description' 	=> __('Hide the "About The Author" section on the blog single post.', 'mint'),
        'section'  => 'blog',
        'settings' => 'mint_blog_about_author',
        'type'     => 'checkbox',
	)));

	/**
	 * Slider
	 *
	 * Customize the slider on the homepage. 
	 * 
	 * @since Mint 1.5.0
	 */
    // Options for the homepage slider area.
    $wp_customize->add_section( 'slider', array(
		'title' 		=> __('Posts Slider', 'mint'),
		'description' 	=> __('Settings for the slider on your homepage.', 'mint'),
		'priority' 		=> '40',
    ));

	// Show the slider
	$wp_customize->add_setting('mint_show_slider', array(
    	'default'       	=> '',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_show_slider', array(
        'label'    		=> __('Show Slider', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_show_slider',
        'type'          => 'checkbox'
    )));
		
	// Show the direction nav on the slider.
	$wp_customize->add_setting('mint_slider_direction_nav', array(
    	'default'       	=> '1',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_slider_direction_nav', array(
        'label'    		=> __('Show Direction Nav', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_direction_nav',
        'type'          => 'checkbox'
    )));

	// Show the control nav on the slider.
	$wp_customize->add_setting('mint_slider_control_nav', array(
    	'default'       	=> '1',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_slider_control_nav', array(
        'label'    		=> __('Show Control Nav', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_control_nav',
        'type'          => 'checkbox'
    )));    

	// Auto scroll.
	$wp_customize->add_setting('mint_slider_auto_scroll', array(
    	'default'       	=> '1',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_slider_auto_scroll', array(
        'label'    		=> __('Auto Change', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_auto_scroll',
        'type'          => 'checkbox'
    )));    

    // Select fade or slide for the slider animation
    $wp_customize->add_setting( 'mint_slider_animation', array(
	    'default'           => 'horizontal',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_slider_animation', array(
        'label'    => __( 'Animation', 'mint' ),
        'section'  => 'slider',
        'settings' => 'mint_slider_animation',
        'type'	   => 'select',
        'choices'  => array (
			'horizontal' => __('Horizontal Slide', 'mint'),
			'fade'  	 => __('Fade', 'mint'),
			'vertical'   => __('Vertical Slide', 'mint'),
		)
	)));

    // Speed
	$wp_customize->add_setting('mint_slider_speed', array(
    	'default'			=> '500',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_slider_speed', array(
    	'label'       	=> __('Speed', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_speed',
        'type'          => 'text'
    )));

	// Max Number of posts to show
	$wp_customize->add_setting('mint_slider_num_of_posts', array(
    	'default'			=> '5',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_slider_num_of_posts', array(
    	'label'       	=> __('Max Number of Posts', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_num_of_posts',
        'type'          => 'text'
    )));
		
	// Show latest posts or sticky posts or posts with a tag
    $wp_customize->add_setting( 'mint_slider_display_type', array(
	    'default'           => 'latest',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_slider_display_type', array(
        'label'    => __( 'Posts to Display', 'mint' ),
 	    'description' => '',
        'section'  => 'slider',
        'settings' => 'mint_slider_display_type',
        'type'	   => 'select',
        'choices'  => array (
			'latest'	 => __('Latest Posts', 'mint'),
			'sticky'  	 => __('Sticky Posts', 'mint'),
			'tag'		 => __('Posts with a tag...', 'mint'),
		)
	)));		
	
	// Tag(s) to be select the posts in the slider
	$wp_customize->add_setting('mint_slider_posts_tag', array(
    	'default'			=> '',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_slider_posts_tag', array(
    	'label'       	=> '',
    	'description'	=> __('Use the tag(s) slug below separated by a comma.', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_posts_tag',
        'type'          => 'text'
    )));	
	
	// Show slider posts in the main loop
	$wp_customize->add_setting('mint_slider_posts_in_loop', array(
    	'default'       	=> '',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'mint_sanitize_checkbox'
    ));
	
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_slider_posts_in_loop', array(
        'label'    		=> __('Repeat slider posts in the main blog', 'mint'),
        'section'  		=> 'slider',
        'settings' 		=> 'mint_slider_posts_in_loop',
        'type'          => 'checkbox'
    )));    	
	
	/**
	 * Color Scheme
	 *
	 * Edit the colour scheme of the website to presets, or  
	 * select your own colors.
	 * 
	 * @since Mint 1.4.0
	 */

	$wp_customize->add_panel( 'color', array(
        'title'    		=> __('Color Scheme', 'mint'),
        'priority' 		=> 45,
        'description' 	=> __('Customize your website colors', 'mint'),
    ));
    
    // Options for color presets.
    $wp_customize->add_section( 'color_presets', array(
		'title' 		=> __('Color Presets', 'mint'),
		'description' 	=> __('Select a preset color scheme for your site.', 'mint'),
		'priority' 		=> '10',
		'panel' 		=> 'color'
    ));
	 
	// Select a color scheme.
    $wp_customize->add_setting('mint_color_scheme', array(
	    'default'           => 'light',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
	));
	
	// 6 awesome color schemes to choose from
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_color_scheme', array(
        'section'  => 'color_presets',
        'settings' => 'mint_color_scheme',
        'type'	   => 'radio',
        'choices'  => array (
			'light'  => __('Light', 'mint'),
			'blue' 	 => __('Blue', 'mint'),
			'green'  => __('Green', 'mint'),
			'yellow' => __('Yellow', 'mint'),
			'red'	 => __('Red', 'mint'),
			'pink'	 => __('Pink', 'mint'),
			'orange' => __('Orange', 'mint'),
		)
	)));

    // 
    $wp_customize->add_section( 'color_select', array(
		'title' 		=> __('Override Presets', 'mint'),
		'description' 	=> __('Change the color tones below to override the preset color scheme.', 'mint'),
		'priority' 		=> '10',
		'panel' 		=> 'color'
    ));
	
	// Color keys for the available tones in this theme.
	$color_keys = array( 
		'darkest'   => __('Darkest Tone', 'mint'),
		'dark'		=> __('Dark Tone', 'mint'),
		'medium'	=> __('Medium Tone', 'mint'),
		'light'		=> __('Light Tone', 'mint'),
		'lightest'	=> __('Lightest Tone', 'mint')		
	);
	
	// Cycle through the available color tones and set a control in the customizer for each one.
	foreach ( $color_keys as $key => $label ) {

		$wp_customize->add_setting('mint_color_scheme_'.$key, array(
			'default'			=> $color_scheme[ $key ],
		    'capability'        => 'edit_theme_options',
		    'type'           	=> 'theme_mod',
		    'sanitize_callback' => 'sanitize_hex_color',
		));
		
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'mint_color_scheme_'.$key, array(
		    'label'    => $label,
		    'section'  => 'color_select',
		    'settings' => 'mint_color_scheme_'.$key,
		)));			
	}
	
	/**
	 * Social
	 *
	 * Social media options 
	 * 
	 * @since Mint 1.1.0
	 */
	$wp_customize->add_panel( 'social', array(
        'title'    		=> __('Social', 'mint'),
        'priority' 		=> 50,
        'description' 	=> __('Add social media icons to your website or blog.', 'mint'),
    ));
    
    // Options for the look & feel.
    $wp_customize->add_section( 'look', array(
		'title' 		=> __('Look & Feel', 'mint'),
		'description' 	=> __('Position the social media icons on your blog.', 'mint'),
		'priority' 		=> '5',
		'panel' 		=> 'social'
    ));

    // Social Icons Position
    $wp_customize->add_setting('mint_social_position', array(
    	'default'       	=> 'right',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_social_position', array(
        'label'    		=> __('Position', 'mint'),
        'section'  		=> 'look',
        'settings' 		=> 'mint_social_position',
        'type'          => 'select',
        'choices'       => array (
        	'' 	  		   => __('Hide', 'mint'),
        	'header' 	   => __('At the top', 'mint'),
			'menu-right'   => __('On the right of the menu', 'mint'),
			'stick-right'  => __('Stick to the right', 'mint'),
			'stick-left'   => __('Stick to the left', 'mint'),
			'footer'   	   => __('At the bottom', 'mint'),
		)
    )));
    
	// Options for the look and feel of the social icons.
    $wp_customize->add_setting('mint_social_shape', array(
    	'default'       	=> '',
        'capability'   	 	=> 'edit_theme_options',
        'type'         	 	=> 'theme_mod',
        'transport' 		=> 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_social_shape', array(
        'label'    		=> __('Shape', 'mint'),
        'section'  		=> 'look',
        'settings' 		=> 'mint_social_shape',
        'type'          => 'select',
        'choices'       => array (
        	'circle'   => __('Circular', 'mint'),
			'square'   => __('Square', 'mint'),
			'no-shape' => __('No Background', 'mint')
		)
    )));
    
    $wp_customize->get_setting( 'mint_social_shape' )->transport = 'postMessage';
    
    // Social Icons Type
    $wp_customize->add_setting('mint_social_type', array(
    	'default'       	=> 'black',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'transport' 		=> 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_social_type', array(
        'label'    		=> __('Type', 'mint'),
        'section'  		=> 'look',
        'settings' 		=> 'mint_social_type',
        'type'          => 'select',
        'choices'       => array (
        	'black' => __('Black', 'mint'),
			'white' => __('White', 'mint'),
			'color' => __('Color', 'mint')
		)
    )));
    
    $wp_customize->get_setting( 'mint_social_type' )->transport = 'postMessage'; 

    // Social Icons Size
    $wp_customize->add_setting('mint_social_size', array(
    	'default'       	=> 'small',
        'capability'   		=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
        'transport' 		=> 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_social_size', array(
        'label'    		=> __('Size', 'mint'),
        'section'  		=> 'look',
        'settings' 		=> 'mint_social_size',
        'type'          => 'select',
        'choices'       => array (
        	'small'  => __('Small', 'mint'),
			'medium' => __('Medium', 'mint'),
			'large'  => __('Large', 'mint')
		)
    )));
    
    $wp_customize->get_setting( 'mint_social_size' )->transport = 'postMessage'; 
        
    // Options the different URL's for each social media option.
    $wp_customize->add_section( 'links', array(
		'title' 		=> __('Social Links', 'mint'),
		'description' 	=> __('Add links to your social pages. You know Facebook, Instagram and all that.', 'mint'),
		'priority' 		=> '5',
		'panel' 		=> 'social'
    ));

	global $_mint_registered_social;
	$accounts = $_mint_registered_social;
    
	if ($accounts) foreach ($accounts as $account => $name) {
		
		$setting_id = 'mint_social_'.$account;
		
		$wp_customize->add_setting( $setting_id, array(
	    	'default'       	=> '',
	        'capability'    	=> 'edit_theme_options',
	        'type'          	=> 'theme_mod',
	        'sanitize_callback' => 'sanitize_text_field'
		) ); 
		
		$control_id = 'mint_social_'.$account;
		
		$wp_customize->add_control( $control_id, array( 
		    'label'    		=> $name,
		    'section'  		=> 'links',
		    'settings' 		=> $control_id,
		    'type'          => 'text',
		) ); 
	} 
	
    /**
	 * Footer
	 *
	 * Footer turn on / off the various credits and change the footer widget layout 
	 * 
	 * @since Mint 1.0.0
	 */
    $wp_customize->add_section('footer', array(
        'title'    		=> __('Footer', 'mint'),
        'priority' 		=> 110,
        'description' 	=> __('Customize the website footer.', 'mint'),
    ));

	$wp_customize->add_setting('mint_footer_credit', array(
	    'default'           => '',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'option',
        'sanitize_callback' => 'mint_sanitize_checkbox'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_footer_credit', array(
        'label'    => __( 'Hide website credits.', 'mint' ),
        'section'  => 'footer',
        'settings' => 'mint_footer_credit',
        'type'     => 'checkbox'
	)));

    // Footer Copyright Text
    $wp_customize->add_setting('mint_footer_text', array(
    	'default'       	=> 'ABC Ltd, All Rights Reserved.',
        'capability'    	=> 'edit_theme_options',
        'type'          	=> 'theme_mod',
		'sanitize_callback' => 'mint_sanitize_html_text'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'mint_footer_text', array(
        'label'    		=> __('Copyright Text', 'mint'),
        'section'  		=> 'footer',
        'settings' 		=> 'mint_footer_text',
        'type'          => 'textarea',
    )));

	// Select a footer widget layout
    $wp_customize->add_setting('mint_footer_sidebars', array(
	    'default'           => '0',
	    'capability'        => 'edit_theme_options',
	    'type'           	=> 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mint_footer_sidebars', array(
        'label'    => __( 'Footer Widgets Areas', 'mint' ),
        'section'  => 'footer',
        'settings' => 'mint_footer_sidebars',
        'type'	   => 'select',	        
        'choices'  => array (
			'0' => '0',
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4'
		)
	)));			
}
add_action( 'customize_register' , 'mint_customize_register' );

if ( ! function_exists( 'mint_sanitize_html_text' ) ) :
/**
 * Mint Sanitize HTML text
 *
 * Used to clean up the textarea saved through the WP customizer.
 * Allows the limited HTML tags.
 *
 * @ref https://codex.wordpress.org/Function_Reference/wp_kses_post
 * @ref https://codex.wordpress.org/Function_Reference/force_balance_tags
 * @since Mint 1.5.11
 **/
function mint_sanitize_html_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}
endif;

if ( ! function_exists( 'mint_sanitize_checkbox' ) ) :
/**
 * Santize a checkbox
 *
 * If the input is a 1 (indicating a checked box) then the function returns a one. 
 * If the input is anything else at all, the function returns a blank string.
 *
 * @since Mint 1.5.2
 **/
function mint_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
endif;