<?php
/**
 * Plugin Name:    Gulir Core
 * Plugin URI:     https://gulir.luncur.com/
 * Description:    Features for Gulir, this is required plugin (important) for this theme.
 * Version:        2.6.9
 * Requires at least: 6.0
 * Requires PHP:   7.4
 * Text Domain:    gulir-core
 * Domain Path:    /languages/
 * Author:         Luncur
 *
 * @package        gulir-core
 */
defined( 'ABSPATH' ) || exit;

define( 'GULIR_CORE_VERSION', '2.6.9' );
define( 'GULIR_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'GULIR_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'GULIR_REL_PATH', dirname( plugin_basename( __FILE__ ) ) );
defined( 'GULIR_TOS_ID' ) || define( 'GULIR_TOS_ID', 'gulir_theme_options' );
defined( 'RB_META_ID' ) || define( 'RB_META_ID', 'rb_global_meta' );

/** LOAD FILES */
include_once GULIR_CORE_PATH . 'includes/file.php';

if ( ! class_exists( 'GULIR_CORE', false ) ) {
	class GULIR_CORE {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;
			register_activation_hook( __FILE__, [ $this, 'activation' ] );
			add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ], 100 );
			add_action( 'wp_enqueue_scripts', [ $this, 'core_enqueue' ], 1 );
			add_action( 'widgets_init', [ $this, 'register_widgets' ] );
		}

		/**
		 * Loads the plugin textdomain for localization.
		 *
		 * This method determines the current locale and attempts to load
		 * the corresponding .mo file from the plugin's languages directory.
		 * If the .mo file exists and is readable, it unloads any previously
		 * loaded textdomain and loads the new one for 'gulir-core'.
		 *
		 * @return void
		 */
		public function load_plugin_textdomain() {

			$locale = apply_filters( 'plugin_locale', function_exists( 'determine_locale' ) ? determine_locale() : get_locale(), 'gulir-core' );

			$loco_path          = WP_LANG_DIR . '/loco/plugins/gulir-core-' . $locale . '.mo';
			$plugin_lang_path   = WP_LANG_DIR . '/plugins/gulir-core-' . $locale . '.mo';
			$original_lang_path = WP_PLUGIN_DIR . '/gulir-core/languages/gulir-core-' . $locale . '.mo';

			if ( is_readable( $loco_path ) ) {
				unload_textdomain( 'gulir-core' );
				load_textdomain( 'gulir-core', $loco_path );
			} elseif ( is_readable( $plugin_lang_path ) ) {
				unload_textdomain( 'gulir-core' );
				load_textdomain( 'gulir-core', $plugin_lang_path );
			} elseif ( is_readable( $original_lang_path ) ) {
				unload_textdomain( 'gulir-core' );
				load_textdomain( 'gulir-core', $original_lang_path );
			}
		}

		public function core_enqueue() {

			if ( gulir_is_amp() ) {
				return;
			}

			$deps = [ 'jquery' ];
			wp_register_style( 'gulir-core', GULIR_CORE_URL . 'assets/core.js', $deps, GULIR_CORE_VERSION, true );

			$fonts = get_option( 'rb_adobe_fonts', [] );
			if ( ! empty( $fonts['project_id'] ) ) {
				wp_enqueue_style( 'adobe-fonts', esc_url_raw( 'https://use.typekit.net/' . esc_html( $fonts['project_id'] ) . '.css' ), [], false, 'all' );
			}
			wp_register_style( 'gulir-admin-bar', GULIR_CORE_URL . 'assets/admin-bar.css', [], GULIR_CORE_VERSION );
			wp_register_script( 'gulir-core', GULIR_CORE_URL . 'assets/core.js', $deps, GULIR_CORE_VERSION, true );

			$js_params     = [
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'darkModeID'      => $this->get_dark_mode_id(),
				'yesPersonalized' => gulir_get_option( 'bookmark_system' ),
				'cookieDomain'    => defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '',
				'cookiePath'      => defined( 'COOKIEPATH' ) ? COOKIEPATH : '/',
			];
			$multi_site_id = $this->get_multisite_subfolder();
			if ( $multi_site_id ) {
				$js_params['mSiteID'] = $multi_site_id;
			}
			wp_localize_script( 'gulir-core', 'gulirCoreParams', $js_params );
			wp_enqueue_script( 'gulir-core' );

			if ( is_admin_bar_showing() ) {
				wp_enqueue_style( 'gulir-admin-bar' );
			}
		}

		public function get_dark_mode_id() {

			if ( is_multisite() ) {
				return 'D_' . trim( str_replace( '/', '_', preg_replace( '/https?:\/\/(www\.)?/', '', get_site_url() ) ) );
			}

			return 'RubyDarkMode';
		}

		public function get_multisite_subfolder() {

			if ( is_multisite() ) {
				$site_info = get_blog_details( get_current_blog_id() );
				$path      = $site_info->path;

				if ( ! empty( $path ) && '/' !== $path ) {
					return trim( str_replace( '/', '', $path ) );
				} else {
					return false;
				}
			}

			return false;
		}

		/**
		 * @return false
		 */
		public function register_widgets() {

			$widgets = [
				'Gulir_W_Post',
				'Gulir_W_Follower',
				'Gulir_W_Weather',
				'Gulir_Fw_Instagram',
				'Gulir_W_Social_Icon',
				'Gulir_W_Youtube_Subscribe',
				'Gulir_W_Flickr',
				'Gulir_W_Address',
				'Gulir_W_Instagram',
				'Gulir_Fw_Mc',
				'Gulir_Ad_Image',
				'Gulir_FW_Banner',
				'Gulir_W_Facebook',
				'Gulir_Ad_Script',
				'Gulir_W_Ruby_Template',
			];

			foreach ( $widgets as $widget ) {
				if ( class_exists( $widget ) ) {
					register_widget( $widget );
				}
			}

			return false;
		}

		/**
		 * @param $network
		 */
		public function activation( $network ) {
			if ( is_multisite() && $network ) {
				global $wpdb;
				$blogs_ids = $wpdb->get_col( 'SELECT blog_id FROM ' . $wpdb->blogs );
				foreach ( $blogs_ids as $blog_id ) {
					switch_to_blog( (int) $blog_id );
					$this->create_db();
					restore_current_blog();
				}
			} else {
				$this->create_db();
			}
		}

		public function create_db() {
			new Gulir_Personalize_Db();
		}

	}
}

/** LOAD */
GULIR_CORE::get_instance();