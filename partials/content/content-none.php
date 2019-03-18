<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0
 */

do_action('mint_article_above'); ?>

<article class="type-page status-publish hentry">

	<?php do_action('mint_article_inside_above'); ?>
	
	<?php if ( apply_filters( 'mint_show_page_title', true ) ) : ?>

	<header class="page-header">
		<h1><?php _e( 'Nothing Found', 'mint' ); ?></h1>
	</header>

	<?php endif; ?>

	<div class="page-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mint' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mint' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mint' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div>
		
	<?php do_action('mint_article_inside_below'); ?>

</article>

<?php do_action('mint_article_below'); ?>