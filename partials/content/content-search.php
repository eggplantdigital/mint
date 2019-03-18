<?php
/**
 * The template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0
 */

do_action('mint_article_above'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php do_action('mint_article_inside_above'); ?>

	<?php mint_post_thumbnail(); ?>

	<?php if ( apply_filters( 'mint_show_page_title', true ) ) : ?>

	<header class="entry-header">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>	
	</header>

	<?php endif; ?>

	<div class="entry-content">
	
		<?php 
		if ( is_single() ) :	
			the_content();
		else :
			the_excerpt(); ?>
		<?php endif; ?>

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