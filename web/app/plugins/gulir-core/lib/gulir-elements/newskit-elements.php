<?php
/**
 * Plugin Name:       Publisher Elements
 * Description:       Essential blocks and components for building modern news and magazine websites, specifically designed to support the Gulir theme.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           3.0
 * Author:            Luncur
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package           gulir-elements
 */

/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

defined( 'RB_ELEMENTS_VER' ) || define( 'RB_ELEMENTS_VER', '3.0' );
defined( 'RB_ELEMENTS_DIR_PATH' ) || define( 'RB_ELEMENTS_DIR_PATH', plugin_dir_path( __FILE__ ) );

if ( ! class_exists( 'Gulir_Post_Elements', false ) ) {
	class Gulir_Post_Elements {

		private static $instance;
		public $settings = [];

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;
			add_action( 'plugins_loaded', [ $this, 'load_files' ], 0 );
			add_action( 'init', [ $this, 'block_init' ] );
			add_action( 'enqueue_block_assets', [ $this, 'enqueue' ] );
			add_action( 'plugins_loaded', [ $this, 'register_mc4wp_integration' ], 91 );
		}

		function enqueue() {
			$stylesheet_path = is_rtl() ? 'public/style-rtl.css' : 'public/style.css';
			wp_enqueue_style( 'gulir-elements', plugin_dir_url( __FILE__ ) . $stylesheet_path, [], RB_ELEMENTS_VER, 'all' );
		}

		function block_init() {

			register_block_type_from_metadata( __DIR__ . '/build/note' );
			register_block_type_from_metadata( __DIR__ . '/build/list-style', [
				'render_callback' => 'gulir_render_list_style',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/affiliate-product' );
			register_block_type_from_metadata( __DIR__ . '/build/affiliate-list' );
			register_block_type_from_metadata( __DIR__ . '/build/affiliate-list-item' );
			register_block_type_from_metadata( __DIR__ . '/build/accordion' );
			register_block_type_from_metadata( __DIR__ . '/build/accordion-item', [
				'render_callback' => 'gulir_accordion_item',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/highlight' );
			register_block_type_from_metadata( __DIR__ . '/build/download', [
				'render_callback' => 'gulir_email_to_download',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/review', [
				'render_callback' => 'gulir_render_block_review',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/related', [
				'render_callback' => 'gulir_render_block_related',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/live', [
				'render_callback' => 'gulir_render_block_live',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/cta', [
				'render_callback' => 'gulir_render_block_cta',
			] );
			register_block_type_from_metadata( __DIR__ . '/build/image-slider', [
				'render_callback' => 'gulir_render_block_image_slider',
			] );

		}

		function register_mc4wp_integration() {

			if ( function_exists( 'mc4wp_register_integration' ) ) {
				include_once( plugin_dir_path( __FILE__ ) . 'includes/integration.php' );
				mc4wp_register_integration( 'gulir', 'Gulir_MC4WP_Integration', true );
			}
		}

		public function load_files() {
			require RB_ELEMENTS_DIR_PATH . 'includes/helper.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/download.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/accordion.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/review.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/list-style.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/related.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/live.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/cta.php';
			require RB_ELEMENTS_DIR_PATH . 'includes/image-slider.php';

		}

	}
}

Gulir_Post_Elements::get_instance();
