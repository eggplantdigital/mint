<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<span class="screen-reader-text"><?php _e( 'Search for:', 'mint' ); ?></span>
	<input type="search" class="search-field" placeholder="<?php echo _e( 'Search &hellip;', 'mint' ); ?>" value="<?php get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><span class="fa fa-search"></span></button>
</form>