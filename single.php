<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Fredo
 */

get_header();
?>

<div class="row">
	<div class="column content">
		<?php the_title( '<h1>', '</h1>' ); ?>
		<div class="row post-info">
				<div class="column">
					<span class="tags">
						<?php
						$post_tags = get_the_tags();
						if ( $post_tags ) {
							foreach ( $post_tags as $tag ) {
								echo '<a class="button button-small button-outline ' . esc_attr( $tag->slug ) . '" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">#' . esc_attr( $tag->name ) . '</a> ';
							}
						}
						?>
					</span>
				</div>
				<div class="column column-25 post-date">
					<span class="date"><?php esc_attr_e( 'Posted on', 'remicorson' ); ?> <time datetime="<?php echo get_the_date('Y-m-d\TH:i:sP'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time></span>
					<?php
					if ( strtotime( get_the_date() ) < strtotime( '-1 year' ) ) {
					?>
						<span class="outdated"><?php esc_attr_e( 'This might be outdated!', 'fredo' ); ?></span>
					<?php } ?>
				</div>
		</div>
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

<div class="row section-title">
	<div class="column">
		<h2><span><?php esc_attr_e( 'About the author', 'fredo' ); ?></span></h2>
	</div>
</div>

<div class="row author">
	<div class="column">
		<span class="title"><?php the_author(); ?></span>
		<span class="bio"><?php echo nl2br( get_the_author_meta( 'description' ) ); ?></span>
		<span class="social"><a class="button button-outline" href="https://twitter.com/intent/user?screen_name=remicorson" target="_blank"><?php esc_attr_e( 'Follow', 'fredo' ); ?></a><br /><?php esc_attr_e( 'Followed by ±3K people', 'fredo' ); ?></span>
		<span class="support"><a class="button button-outline" href="<?php echo esc_url( fredo_buy_me_a_coffee_url() ); ?>" target="_blank"><?php esc_attr_e( 'Buy a coffee', 'fredo' ); ?></a><br /><?php esc_attr_e( 'Show your support', 'fredo' ); ?></span>
	</div>
</div>

<div class="row section-title">
	<div class="column">
		<h2><span><?php esc_attr_e( 'Related Posts', 'fredo' ); ?></span></h2>
	</div>
</div>

<div class="row related-posts">
	<?php

	// Get the post data.
	$orig_post = $post;
	global $post;
	$tags = wp_get_post_tags( $post->ID );

	// Query arguments.
	$posts_per_page = 4;
	$post_type      = 'post';
	$orderby        = 'rand';

		// Check if post has tags.
	if ( $tags ) {

		$tag_ids = array();

		foreach ( $tags as $individual_tag ) $tag_ids[] = $individual_tag->term_id;

			// Build our tag related custom query arguments.
			$custom_query_args = array(
				'tag__in'        => $tag_ids,
				'posts_per_page' => $posts_per_page,
				'post__not_in'   => array( $post->ID ),
				'orderby'        => 'rand',
			);
	} else {
		// If the post does not have tags, run the standard related posts query.
		$custom_query_args = array(
			'posts_per_page' => $posts_per_page,
			'post__not_in'   => array( $post->ID ),
			'orderby'        => 'rand',
		);
	}

	// Create the Query.
	$query = new WP_Query( $custom_query_args );

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
				<span class="excerpt"><?php echo wp_strip_all_tags( get_the_excerpt(), true ); ?></span>
			</div>
			<?php
		endwhile;

		endif;

		// Reset query to prevent conflicts.
		wp_reset_postdata();
	?>
</div>

<?php
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
	comments_template();
}
?>

<?php
get_footer();
