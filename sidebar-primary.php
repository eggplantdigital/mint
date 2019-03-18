<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0
 */

do_action('mint_sidebar_above'); ?>

	<div id="primary-sidebar" <?php mint_primary_sidebar_class(); ?> role="sidebar">
	
		<?php do_action('mint_sidebar_inside_above'); ?>
		    
			<?php dynamic_sidebar('primary-widget-area'); ?>
	    
		<?php do_action('mint_sidebar_inside_below'); ?>
	
	</div>

<?php do_action('mint_sidebar_below'); ?>