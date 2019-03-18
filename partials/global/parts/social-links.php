<div class="social-links <?php echo get_theme_mod('mint_social_position'); ?>">
	<?php
	// Define the $args variable
	$args=array();
		
	if ( $t=get_theme_mod('mint_social_type') )
		$args['type'] = $t;

	if ( $s=get_theme_mod('mint_social_shape') )
		$args['shape'] = $s;

	if ( $z=get_theme_mod('mint_social_size') )
		$args['size'] = $z;
	
	mint_social_icons( $args ); ?>
</div>