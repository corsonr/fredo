<?php
/**
 * The home template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package WordPress
 * @subpackage Fredo
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php do_action( 'fredo_before_home_content' ); ?>

<div class="row section-title">
	<div class="column">
		<h2><span><?php esc_attr_e( 'My latest posts', 'fredo' ); ?></span></h2>
	</div>
</div>

<div class="row home-posts">
	<?php

		// Create the Query.
		$posts_per_page = 8;
		$post_type      = 'post';
		$orderby        = 'date';
		$order          = 'DESC';
		$paged          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => $posts_per_page,
				'orderby'        => $orderby,
				'order'          => $order,
				'paged'          => $paged,
			)
		);

		// Get post type count.
		$post_count = $query->post_count;

		// Displays info.
		if ( $post_count > 0 ) :

			// Loop.
			while ( $query->have_posts() ) :
				$query->the_post();
			?>
			<div class="column column-50 ">
				<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
				<span class="excerpt"><?php the_excerpt(); ?></span>
				<span class="button button-black button-small"><a href="<?php the_permalink(); ?>"><?php esc_attr_e( 'Read Now', 'fredo' ); ?></a></span>
			</div>
			<?php
			endwhile;

		endif;

		// Reset query to prevent conflicts.
		wp_reset_postdata();
	?>
</div>

<?php do_action( 'fredo_after_home_content' ); ?>

<?php	get_footer(); ?>
