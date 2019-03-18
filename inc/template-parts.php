<?php
/**
 * Template parts functions
 *
 * @package Mint
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.6.5
 */

if (!function_exists('mint_get_header_template_part')) :
/**
 * Switch between different headers based on the choice in the customizer.
 *
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support
 * @since 1.6.5
 */
function mint_get_header_template_part() {
	
	$template = get_theme_mod('mint_layout_type');
	
	switch ($template) {
		
		case 'wide':
			get_template_part('partials/header/wide');
			break;
		
		case 'boxed':
			get_template_part('partials/header/boxed');
			break;
		
		default:
			get_template_part('partials/header/wide');
	}
}
endif;