<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

add_action( 'plugins_loaded', [ 'Gulir_WPRM', 'get_instance' ], 1 );

if ( ! class_exists( 'Gulir_WPRM', false ) ) {
	class Gulir_WPRM {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			if ( ! class_exists( 'WP_Recipe_Maker' ) ) {
				return;
			}

			$pinterest_lib = gulir_get_option( 'wprm_pinterest' );

			if ( empty( $pinterest_lib ) || '-1' === (string) $pinterest_lib ) {
				add_filter( 'wprm_load_pinit', '__return_false', 9999 );
			}

			if ( gulir_get_option( 'wprm_supported' ) ) {
				add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ], 9999 );
				add_action( 'enqueue_block_assets', [ $this, 'enqueue' ], 92 );
				remove_action( 'wp_head', [ 'WPRM_Template_Manager', 'head_css' ] );
				remove_action( 'wp_footer', [ 'WPRM_Template_Manager', 'templates_css' ], 99 );
			}
		}

		/**
		 * Enqueue WPRM styles for the WordPress admin area.
		 *
		 * Loads the appropriate stylesheet (RTL or LTR) based on the site's text direction.
		 * Only runs in the admin dashboard.
		 *
		 * @return void
		 */
		function enqueue() {

			if ( ! is_admin() ) {
				return;
			}

			$path = is_rtl() ? 'assets/wprm-rtl.css' : 'assets/wprm.css';
			wp_enqueue_style( 'gulir-wprm', GULIR_CORE_URL . $path, [], GULIR_CORE_VERSION, 'all' );
		}
	}
}