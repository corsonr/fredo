<?php
/**
 *
 * Template Name: Blog
 *
 * The main template for displaying all posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Fredo
 */

get_header(); ?>

<div class="row">
	<div class="column">
		<h1><?php esc_attr_e( 'All my posts', 'fredo' ); ?></h1>
	</div>
</div>

<div class="row home-posts">
	<?php

		// Create the Query.
		$posts_per_page = 8;
		$post_type      = 'post';
		$orderby        = 'date';
		$order          = 'DESC';

		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => $posts_per_page,
				'orderby'        => $orderby,
				'order'          => $order,
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
					<?php fredo_post_thumbnail( 'medium' ); ?>
					<span class="excerpt"><?php the_excerpt(); ?></span>
					<span class="button button-black button-small"><a href="<?php the_permalink(); ?>"><?php esc_attr_e( 'Read Now', 'fredo' ); ?></a></span>
				</div>
				<?php
			endwhile;

		endif;
		?>

		<div class="row pagination">

		<?php
		$total = $query->max_num_pages;
		// only bother with the rest if we have more than 1 page!
		if ( $total > 1 ) {

			// get the current page.
			if ( get_query_var( 'paged' ) !== $current_page ) {
				$current_page = 1;
			}

			// structure of "format" depends on whether we're using pretty permalinks.
			if ( empty( get_option( 'permalink_structure' ) ) ) {
				$format = '&paged=%#%';
			} else {
				$format = 'page/%#%/';
			}

			// Echo pagination.
			echo paginate_links(
				array(
					'base'     => get_pagenum_link( 1 ) . '%_%',
					'format'   => $format,
					'current'  => $current_page,
					'total'    => $total,
					'mid_size' => 4,
					'type'     => 'list',
				)
			);
		}
		?>

		</div>

		<?php
		// Reset query to prevent conflicts.
		wp_post_data();
	?>
</div>

<?php get_footer(); ?>
