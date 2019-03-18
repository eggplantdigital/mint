<div class="logo">
	<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('description') ?>">
		<?php if ( $site_logo = get_option('mint_custom_logo') ) { ?>
				<img src="<?php echo $site_logo; ?>" alt="<?php bloginfo('name') ?>" />
		<?php } else { ?>
				<h1><?php bloginfo('name') ?></h1>
				<p class="tagline"><?php echo get_bloginfo ( 'description' ); ?></p>
		<?php } ?>
	</a>
</div>