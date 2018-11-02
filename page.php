<?php
/**
 * The template for displaying all single page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package WordPress
 * @subpackage Fredo
 */

get_header();
?>

<div class="row">
	<div class="column content">
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
</div>

<?php
get_footer();
