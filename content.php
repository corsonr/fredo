<?php
/**
 * Template used to display post content.
 *
 * @package WordPress
 * @subpackage Fredo
 */

?>

<div class="column column-50" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
	<?php fredo_post_thumbnail( 'medium' ); ?>
	<span class="excerpt"><?php the_excerpt(); ?></span>
	<span class="button button-black button-small"><a href="<?php the_permalink(); ?>"><?php esc_attr_e( 'Read Now', 'fredo' ); ?></a></span>
	<?php
	do_action( 'fredo_loop_post' );
	?>

</div>
