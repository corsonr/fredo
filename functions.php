<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Fredo
 * @since 1.0
 */

/**
 * Assign the theme version to a var
 */
$theme         = wp_get_theme( 'fredo' );
$fredo_version = $theme['Version'];

require 'inc/customizer.php';

/**
 * Sets actions.
 */
add_action( 'after_setup_theme', 'fredo_setup' );
add_action( 'wp_enqueue_scripts', 'fredo_scripts' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function fredo_setup() {

	// Make theme ready for translation.
	load_theme_textdomain( 'fredo' );

	// Add theme supports.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_action( 'init', 'disable_emojis' );

	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	add_filter( 'excerpt_more', 'new_excerpt_more' );

	add_action( 'widgets_init', 'widgets_init' );

	remove_filter( 'init', 'get_avatar' );

	// Content specific to remicorson.com
	// Use remove_action() to disable those sections.
	add_action( 'fredo_after_home_content', 'fredo_promote_theme_box' );
	add_action( 'fredo_before_home_content', 'fredo_home_intro' );
	add_action( 'walker_nav_menu_start_el', 'fredo_apply_button_class_to_last_menu_item', 10, 4 );

}

/**
 * Enqueue scripts and styles.
 */
function fredo_scripts() {

	global $fredo_version;

	// Theme stylesheets.
	wp_enqueue_style( 'fredo-main', get_theme_file_uri( '/assets/css/main.css' ), array(), $fredo_version );

	// Fonts.
	$google_fonts = apply_filters(
		'fredo_google_font_families', array(
			'lato' => 'Lato:300,300italic,700,700italic',
		)
	);
	$query_args   = array(
		'family' => implode( '|', $google_fonts ),
		'subset' => rawurlencode( 'latin,latin-ext' ),
	);
	$fonts_url    = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	wp_enqueue_style( 'fredo-fonts', $fonts_url, array(), null );

}

/**
 * Shorten the excerpt.
 *
 * @param integer $length     The excerpt default length.
 */
function custom_excerpt_length( $length ) {
	return apply_filters( 'fredo_excerpt_length', 20 );
}

/**
 * Replace [...]  by ... in the excerpt.
 *
 * @param string $more     The "more"" default value.
 */
function new_excerpt_more( $more ) {
	return apply_filters( 'fredo_excerpt_length_more', '...' );
}

/**
 * Apply custom button class to the last menu item.
 *
 * Learn more: https://developer.wordpress.org/reference/hooks/walker_nav_menu_start_el/
 *
 * @param string   $item_output  The menu item's starting HTML output.
 * @param object   $item     Menu item data object.
 * @param integer  $depth     Depth of menu item. Used for padding.
 * @param stdClass $args     An object of wp_nav_menu() arguments.
 */
function fredo_apply_button_class_to_last_menu_item( $item_output, $item, $depth, $args ) {
	if ( apply_filters( 'fredo_last_menu_item_name', 'buy-a-coffee' ) === $item->post_name ) {
		$item_output = preg_replace( '/<a.*?>(.*)<\/a>/', '<a href="' . $item->url . '" class="button button-black" target="_blank">$1</a>', $item_output );
	}
	return $item_output;
}

/**
 * Register widget area.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function widgets_init() {

	$sidebar_args['sidebar'] = array(
		'name'        => __( 'Sidebar', 'fredo' ),
		'id'          => 'sidebar-1',
		'description' => '',
	);

	$sidebar_args = apply_filters( 'fredo_sidebar_args', $sidebar_args );

	foreach ( $sidebar_args as $sidebar => $args ) {
		$widget_tags = array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',
		);
	}

	$filter_hook = sprintf( 'fredo_%s_widget_tags', $sidebar );

	$widget_tags = apply_filters( $filter_hook, $widget_tags );
	if ( is_array( $widget_tags ) ) {
		register_sidebar( $args + $widget_tags );
	}
}

/**
 * Custom function to display comments.
 *
 * Learn more: https://codex.wordpress.org/Function_Reference/wp_list_comments
 *
 * @param string  $comment  The comment.
 * @param object  $args     The args.
 * @param integer $depth    Depth of menu item. Used for padding.
 */
function list_comments( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	} ?>
	<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
	<?php
	if ( 'div' !== $args['style'] ) {
	?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
<?php } ?>
	<div class="comment-author vcard">
		<?php
		if ( 0 !== $args['avatar_size'] ) {
			echo get_avatar( $comment, $args['avatar_size'] );
		}
		printf( __( '<cite class="fn">%s</cite>:' ), get_comment_author_link() );
		?>
	</div>
	<?php
	if ( 0 === $comment->comment_approved ) {
	?>
		<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'fredo' ); ?></em><br/>
		<?php
	}
	?>
	<div class="comment-meta commentmetadata">
		<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf(
					__('%1$s at %2$s'),
					get_comment_date(),
					get_comment_time()
				);
				?>
			</a>
			<?php
			edit_comment_link( __( '<span class="button button-small float-right button-outline">' . __( 'Edit', 'fredo' ) . '</span>' ), '  ', '' );
			?>
		</div>

		<?php comment_text(); ?>

		<div class="reply">
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below'  => $add_below,
						'depth'      => $depth,
						'max_depth'  => $args['max_depth'],
						'reply_text' => '<span class="button button-small">' . __( 'Reply', 'fredo' ) . '</span>',
					)
				)
			);
			?>
		</div>
		<?php
		if ( 'div' !== $args['style'] ) :
		?>
		</div>
		<?php
		endif;
}

/**
 * Disable emojis, please.
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

/**
 * Apply button style to last menu item.
 *
 * @param array $items     The menu item.
 */
function fredo_add_menu_class_to_last_item( $items ) {
	$items[ count( $items ) ]->classes[] = 'button button-black';
	return $items;
}

/**
 * Display home introduction text.
 */
function fredo_home_intro() {
	?>
	<div class="row content">
		<div class="column">
			<h1><?php esc_attr_e( 'Looking for some WordPress and WooCommerce related stuff? I got you covered! I\'m Remi, nice to meet you.', 'fredo' ); ?></h1>
			<p>
				<?php esc_attr_e( 'Here is my blog, where I write from to time to time, where I give free snippets, where I share my skills. I work at Automattic, and guess what? We\'re hiring!', 'fredo' ); ?>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Promote theme.
 * add remove_action( 'fredo_after_home_content', 'fredo_promote_theme_box' ); to remove this.
 */
function fredo_promote_theme_box() {
	?>
	<div class="row section-title">
		<div class="column">
			<h2><span><?php esc_attr_e( ' Like this theme?', 'fredo' ); ?></span></h2>
		</div>
	</div>

	<div class="row theme">
		<div class="column">
			<span class="title"><?php esc_attr_e( 'It\'s free an open source!', 'fredo' ); ?></span>
			<span class="description"><?php esc_attr_e( 'This theme is clean, fast and doesn\'t rely on any heavy technology. I wanted it to be simple to use, clearly readable and focusing on content. No need for useless featured images, visual effects, preloaders or any other fancy trendy stuff. Nobody cares about this anymore.', 'fredo' ); ?></span>
		</div>
	</div>
	<div class="row">
		<div class="column">
			<span><a class="button button-outline" href="https://github.com/corsonr/fredo/archive/master.zip" target="_blank"><?php esc_attr_e( 'Download', 'fredo' ); ?></a></span>
		</div>
		<div class="column">
			<span><a class="button button-outline" href="https://github.com/corsonr/fredo/issues" target="_blank"><?php esc_attr_e( 'Report a bug', 'fredo' ); ?></a></span>
		</div>
		<div class="column">
			<span><a class="button button-outline" href="https://github.com/corsonr/fredo/blob/master/CONTRIBUTING.md" target="_blank"><?php esc_attr_e( 'Contribute', 'fredo' ); ?></a></span>
		</div>
		<div class="column">
			<span class="support"><a class="button button-outline" href="<?php echo esc_url( fredo_buy_me_a_coffee_url() ); ?>" target="_blank"><?php esc_attr_e( 'Buy me a coffee', 'fredo' ); ?></a></span>
		</div>
	</div>
	<?php
}

/**
 * Buy me a coffee URL.
 */
function fredo_buy_me_a_coffee_url() {
	return apply_filters( 'fredo_buy_me_a_coffee_url', 'https://www.buymeacoffee.com/u8Mr47vGJ' );
}
