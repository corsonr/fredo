<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage Fredo
 * @since 1.0
 * @version 1.0
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<?php wp_head(); ?>
</head>
	<body <?php body_class(); ?>>
		<main class="wrapper">

			<nav class="navigation">
				<div class="nav_container">
					<div class="row">
						<?php
							$logo_column_width = apply_filters( 'fredo_nav_logo_column_width', 25 );
						?>
						<div class="column column-<?php echo esc_attr( $logo_column_width ); ?> logo">
							<h2 class="title section-title">
								<a href="<?php echo esc_url( site_url() ); ?>" >
									<?php echo apply_filters( 'fredo_site_logo', '<span class="r">R</span><span class="e">E</span>MI<span class="title-bg"></span><span class="lastname">CORSON</span>' ); ?>
								</a>
							</h2>
						</div>
						<div class="column">
							<?php wp_nav_menu( array('menu' => 'main') ); ?>
						</div>
						</div>
					</div>
				</div>
			</nav>

			<div class="container">
