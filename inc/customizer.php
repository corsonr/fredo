<?php
/**
 * Fredo Customizer Class
 *
 * @package WordPress
 * @subpackage Fredo
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Storefront_Customizer' ) ) :

	/**
	 * The Fredo Customizer class
	 */
	class Fredo_Customizer {
		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
		}

		/**
		 * Add customizer options.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_register( $wp_customize ) {

			/**
			 * Add the Fredo section.
			 */
			$wp_customize->add_section(
				'fredo_section', array(
					'title'			=> __( 'Fredo', 'fredo' ),
					'priority'	=> 45,
				)
			);

			/**
			 * Tracking code.
			 */
			$wp_customize->add_setting(
				'fredo_tracking_code', array(
					'default' => 'UA-XXXXXXXX-X'
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize, 'fredo_tracking_code', array(
						'label'                 => __( 'Tracking code', 'fredo' ),
						'section'               => 'fredo_section',
						'settings'              => 'fredo_tracking_code',
						'priority'              => 30,
					)
				)
			);

		}

	}

endif;

return new Fredo_Customizer();
