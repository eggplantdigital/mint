<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0
 */

do_action('mint_article_above'); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php do_action('mint_article_inside_above'); ?>

	<?php if ( apply_filters( 'mint_show_page_title', true ) ) : ?>

	<header class="page-header">
		<?php the_title( '<h1>', '</h1>' ); ?>		
	</header>

	<?php endif; ?>
	
	<div class="page-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'mint' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'mint' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>		
	</div>
	
	<?php if ( ! is_front_page() ) : ?>
	<footer class="page-footer">
		<?php edit_post_link( __( 'Edit Page', 'mint' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<?php endif; ?>
	
	<?php do_action('mint_article_inside_below'); ?>

</article>

<?php do_action('mint_article_below'); ?>