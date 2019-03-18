<?php
/**
 * The default template for displaying content
 *
 * Used for both single/index/archive/search.
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0
 */

do_action('mint_article_above'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php do_action('mint_article_inside_above'); ?>

	<?php mint_post_thumbnail(); ?>
	
	<header class="entry-header">
		
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			
	</header>
	
	<div class="entry-content">
	
		<?php 
		if ( is_single() ) :	
			the_content();
		else :
			the_excerpt(); ?>
		<?php endif; ?>
		
		<?php
		if ( is_single() )
			mint_author_meta(); ?>

	</div>
	
	<footer class="entry-footer">

		<?php
		$args = array(
			'show_post_date' => true,
			'show_post_author' => true,
			'show_post_category' => true,
	 		'show_edit_link' => true,
	 		'echo' => true
		);
	
		mint_post_meta( $args ); ?>
	
	</footer>

	<?php do_action('mint_article_inside_below'); ?>
	
	<div class="clearfix"></div>

</article>

<?php do_action('mint_article_below'); ?>