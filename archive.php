<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Fredo
 */
 get_header(); ?>

 <div class="row">
 	<div class="column">
		<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	</div>
</div>

 	<?php if ( have_posts() ) :
		get_template_part( 'loop' );
	else :
		get_template_part( 'content', 'none' );
	endif;
	?>

<?php get_footer(); ?>
