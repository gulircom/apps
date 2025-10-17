<?php
/**
 * Plugin Name:    Ruby bbPress Supported
 * Plugin URI:     https://themeforest.net/user/theme-ruby/
 * Description:    bbPress custom styles and functions.
 * Version:        1.2
 * Text Domain:    ruby-bbp
 * Domain Path:    /languages
 * Author:         Luncur
 * Author URI:     https://themeforest.net/user/theme-ruby/
 *
 * @package        bbp
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RB_BBP_SUPPORTED', '1.2' );
define( 'RB_BBP_URL', plugin_dir_url( __FILE__ ) );
define( 'RB_BBP_PATH', plugin_dir_path( __FILE__ ) );

include_once RB_BBP_PATH . 'includes/settings.php';

if ( ! class_exists( 'Ruby_BBP_Supported' ) ) {
	class Ruby_BBP_Supported {

		protected static $instance = null;

		static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		function __construct() {

			self::$instance = $this;

			if ( ! class_exists( 'bbpress' ) ) {
				return;
			}

			include_once RB_BBP_PATH . 'includes/helper.php';
			include_once RB_BBP_PATH . 'includes/actions.php';
			include_once RB_BBP_PATH . 'templates/parts.php';

			if ( is_admin() && current_user_can( 'manage_options' ) ) {
				Ruby_BBP_Settings::get_instance();
			}

			add_post_type_support( 'forum', [ 'thumbnail' ] );
			add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ], 101 );
			add_filter( 'bbp_default_styles', [ $this, 'remove_bbp_style' ], 10, 1 );
			add_action( 'bbp_enqueue_scripts', [ $this, 'enqueue' ], 99 );
			add_filter( 'template_include', [ $this, 'bbpress_redirect' ], 99 );
			add_filter( 'bbp_template_stack', [ $this, 'location' ], 9 );
			add_filter( 'bbp_kses_allowed_tags', [ $this, 'remove_tags' ], 10, 1 );
			add_filter( 'bbp_show_lead_topic', [ $this, 'show_lead_topic' ], 10, 1 );
		}

		function show_lead_topic( $show_lead ) {

			if ( get_option( 'ruby_bbp_lead_topic' ) ) {
				$show_lead[] = true;
			}

			return $show_lead;
		}

		function remove_tags( $tags ) {

			if ( ! current_user_can( 'moderate' ) ) {
				/** fix break layout if without ol */
				if ( isset( $tags['li'] ) ) {
					unset( $tags['li'] );
				}
				if ( isset( $tags['ul'] ) ) {
					unset( $tags['ul'] );
				}
				if ( isset( $tags['ol'] ) ) {
					unset( $tags['ol'] );
				}
			}

			return $tags;
		}

		function enqueue() {

			if ( ! is_bbpress() ) {
				return false;
			}

			$file_name = 'style';
			if ( is_rtl() ) {
				$file_name = 'rtl';
			}

			wp_register_style( 'ruby-bbp-icon', RB_BBP_URL . 'assets/icons.css', [], RB_BBP_SUPPORTED );
			wp_register_style( 'ruby-bbp', RB_BBP_URL . 'assets/' . $file_name . '.css', [ 'ruby-bbp-icon' ], RB_BBP_SUPPORTED );
			wp_register_script( 'ruby-bbp', RB_BBP_URL . 'assets/scripts.js', [ 'jquery' ], RB_BBP_SUPPORTED, true );

			/** load */
			wp_enqueue_style( 'ruby-bbp' );
			wp_enqueue_script( 'ruby-bbp' );
		}

		function remove_bbp_style( $defaults ) {

			return [];
		}

		function location() {

			return RB_BBP_PATH . 'templates';
		}

		public function bbpress_redirect( $template ) {

			if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {

				/** allow set elementor template */
				if ( class_exists( 'Elementor\Plugin' ) && is_page() ) {
					$template_slug = get_page_template_slug();
					if ( substr( $template_slug, 0, 9 ) === 'elementor' ) {
						return $template;
					}
				}

				$template = RB_BBP_PATH . 'templates/single-bbp.php';
			}

			return $template;
		}


		public function load_plugin_textdomain() {

			$locale = apply_filters( 'plugin_locale', function_exists( 'determine_locale' ) ? determine_locale() : get_locale(), 'ruby-bbp' );

			$loco_path   = WP_LANG_DIR . '/loco/plugins/ruby-bbp-' . $locale . '.mo';
			$plugin_lang_path   = WP_LANG_DIR . '/plugins/ruby-bbp-' . $locale . '.mo';
			$original_lang_path = RB_BBP_PATH . 'languages/ruby-bbp-' . $locale . '.mo';

			if ( is_readable( $loco_path ) ) {
				unload_textdomain( 'ruby-bbp' );
				load_textdomain( 'ruby-bbp', $loco_path );
			} elseif ( is_readable( $plugin_lang_path ) ) {
				unload_textdomain( 'ruby-bbp' );
				load_textdomain( 'ruby-bbp', $plugin_lang_path );
			} elseif ( is_readable( $original_lang_path ) ) {
				unload_textdomain( 'ruby-bbp' );
				load_textdomain( 'ruby-bbp', $original_lang_path );
			}
		}

	}
}

/** LOAD */
add_action( 'plugins_loaded', [ 'Ruby_BBP_Supported', 'get_instance' ], 10 );
