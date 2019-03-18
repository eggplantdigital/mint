<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Mint
 * @since Mint 1.0
 */

get_header(); ?>

	<?php do_action('mint_container_above'); ?>

	<div id="container" class="container" role="container">

		<?php do_action('mint_container_inside_above'); ?>
		
		<main id="main" class="row" role="main">
			
			<?php do_action('mint_section_above'); ?>
	
			<?php if ( have_posts() ) : ?>
	
			<section <?php mint_section_class(); ?>>
			
				<?php do_action('mint_section_inside_above'); ?>
	
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
					
					/*
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'partials/content', 'search' );
	
				// End the loop.
				endwhile;
				?>
				
				<?php mint_pagination(); ?>
				
				<?php do_action('mint_section_inside_below'); ?>
	
			</section>
			
			<?php
			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'partials/content', 'none' );
	
			endif;
			?>
		
			<?php do_action('mint_section_below'); ?>

		</main><!-- /#main -->
			
		<?php do_action('mint_container_inside_below'); ?>

	</div><!-- /#container -->
	
	<?php do_action('mint_container_below'); ?>

<?php get_footer(); ?>