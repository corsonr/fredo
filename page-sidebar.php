<?php
/**
 *
 * Template Name: Page Sidebar
 *
 * The template for displaying all single page with a sidebar.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package WordPress
 * @subpackage Fredo
 */

get_header();
?>

<div class="row">
	<div class="column column-66">
		<?php the_title( '<h1 class="">', '</h1>' ); ?>

		<?php
		// Start the Loop.
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content/content', 'single' );

		endwhile;
		// End of the loop.
		?>
	</div>
	<div class="column column-34 sidebar">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

			<?php dynamic_sidebar( 'sidebar-1' ); ?>

		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
