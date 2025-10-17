<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

define( 'GULIR_THEME_VERSION', '0.0.1' );
define( 'GULIR_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'GULIR_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );
define( 'GULIR_CHILD_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'GULIR_CHILD_THEME_URI', trailingslashit( esc_url( get_stylesheet_directory_uri() ) ) );
defined( 'GULIR_TOS_ID' ) || define( 'GULIR_TOS_ID', 'gulir_theme_options' );

define( 'GULIR_THEME_DIST_DIR', GULIR_THEME_DIR . 'dist/' );
define( 'GULIR_THEME_DIST_URI', GULIR_THEME_URI . '/dist/' );
define( 'GULIR_THEME_INC', GULIR_THEME_DIR . 'src/' );
define( 'GULIR_THEME_BLOCK_DIR', GULIR_THEME_DIR . 'blocks/' );
define( 'GULIR_THEME_BLOCK_DIST_DIR', GULIR_THEME_DIR . 'dist/blocks/' );


$is_local_env = in_array( wp_get_environment_type(), [ 'local', 'development' ], true );
$is_local_url = strpos( home_url(), '.test' ) || strpos( home_url(), '.local' );
$is_local     = $is_local_env || $is_local_url;

if ( $is_local && file_exists( __DIR__ . '/dist/fast-refresh.php' ) ) {
	require_once __DIR__ . '/dist/fast-refresh.php';

	if ( function_exists( 'TenUpToolkit\set_dist_url_path' ) ) {
		TenUpToolkit\set_dist_url_path( basename( __DIR__ ), GULIR_THEME_DIST_URI, GULIR_THEME_DIST_DIR );
	}
}

// Require Composer autoloader if it exists.
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	throw new Exception( 'Please run `composer install` in your theme directory.' );
}

require_once __DIR__ . '/vendor/autoload.php';

// $theme_core = new \Gulir\ThemeCore();
// $theme_core->setup();

include_once GULIR_THEME_DIR . 'includes/core-functions.php';
include_once GULIR_THEME_DIR . 'includes/file.php';

add_action( 'after_setup_theme', 'gulir_theme_setup', 10 );
add_action( 'wp_enqueue_scripts', 'gulir_register_script_frontend', 990 );

/** setup */
if ( ! function_exists( 'gulir_theme_setup' ) ) {
	function gulir_theme_setup() {

		// load_theme_textdomain
		$locale          = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
		$loco_path       = WP_LANG_DIR . '/loco/themes/gulir-' . $locale . '.mo';
		$theme_lang_path = WP_LANG_DIR . '/themes/gulir-' . $locale . '.mo';
		if ( is_readable( $loco_path ) ) {
			load_textdomain( 'gulir', $loco_path );
		} elseif ( file_exists( $theme_lang_path ) ) {
			load_textdomain( 'gulir', $theme_lang_path );
		} else {
			load_theme_textdomain( 'gulir', get_theme_file_path( 'languages' ) );
		}

		if ( ! isset( $GLOBALS['content_width'] ) ) {
			$GLOBALS['content_width'] = 1170;
		}

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		] );
		add_theme_support( 'post-formats', [ 'gallery', 'video', 'audio' ] );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'woocommerce', [
			'gallery_thumbnail_image_width' => 110,
			'thumbnail_image_width'         => 300,
			'single_image_width'            => 760,
		] );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		if ( ! gulir_get_option( 'widget_block_editor' ) ) {
			remove_theme_support( 'widgets-block-editor' );
		}
		register_nav_menus( [
			'gulir_main'         => esc_html__( 'Main Menu', 'gulir' ),
			'gulir_mobile'       => esc_html__( 'Mobile Menu', 'gulir' ),
			'gulir_mobile_quick' => esc_html__( 'Mobile Quick Access', 'gulir' ),
		] );

		$sizes = gulir_calc_crop_sizes();
		foreach ( $sizes as $crop_id => $size ) {
			add_image_size( $crop_id, $size[0], $size[1], $size[2] );
		}
	}
}

/* register scripts */
if ( ! function_exists( 'gulir_register_script_frontend' ) ) {
	function gulir_register_script_frontend() {

		$style_deps  = [];
		$script_deps = [
			'jquery',
			'jquery-waypoints',
			'rbswiper',
			'jquery-magnific-popup',
		];

		$main_filename        = 'main';
		$woocommerce_filename = 'woocommerce';
		$podcast_filename     = 'podcast';

		if ( is_rtl() ) {
			$main_filename        = 'rtl';
			$woocommerce_filename = 'woocommerce-rtl';
			$podcast_filename     = 'podcast-rtl';
		}

		$gfont_url = Gulir_Font::get_font_url();

		if ( ! empty( $gfont_url ) ) {
			wp_register_style( 'gulir-font', esc_url_raw( $gfont_url ), [], GULIR_THEME_VERSION, 'all' );
			$style_deps[] = 'gulir-font';
		}

		if ( gulir_get_option( 'font_awesome' ) ) {
			wp_deregister_style( 'font-awesome' );
			wp_register_style( 'font-awesome', gulir_get_file_uri( 'assets/css/font-awesome.css' ), [], '6.1.1', 'all' );
			$style_deps[] = 'font-awesome';
		}

		wp_register_style( 'gulir-main', gulir_get_file_uri( 'assets/css/' . $main_filename . '.css' ), [], GULIR_THEME_VERSION, 'all' );
		wp_add_inline_style( 'gulir-main', gulir_get_dynamic_css() );
		$style_deps[] = 'gulir-main';

		if ( gulir_get_option( 'podcast_supported' ) ) {
			wp_register_style( 'gulir-podcast', gulir_get_file_uri( 'assets/css/' . $podcast_filename . '.css' ), [], GULIR_THEME_VERSION, 'all' );
			$style_deps[] = 'gulir-podcast';
		}

		if ( ! gulir_is_amp() ) {

			wp_register_style( 'gulir-print', gulir_get_file_uri( 'assets/css/print.css' ), [], GULIR_THEME_VERSION, 'all' );
			$style_deps[] = 'gulir-print';

			if ( class_exists( 'WooCommerce' ) ) {
				wp_deregister_style( 'yith-wcwl-font-awesome' );
				wp_register_style( 'gulir-woocommerce', gulir_get_file_uri( 'assets/css/' . $woocommerce_filename . '.css' ), [], GULIR_THEME_VERSION, 'all' );
				$style_deps[] = 'gulir-woocommerce';
			}
		}

		wp_register_style( 'gulir-style', get_stylesheet_uri(), $style_deps, GULIR_THEME_VERSION, 'all' );
		wp_enqueue_style( 'gulir-style' );

		if ( ! gulir_is_amp() ) {

			wp_register_script( 'html5', gulir_get_file_uri( 'assets/js/html5shiv.min.js' ), [], '3.7.3' );
			wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			wp_register_script( 'jquery-waypoints', gulir_get_file_uri( 'assets/js/jquery.waypoints.min.js' ), [ 'jquery' ], '3.1.1', true );
			wp_register_script( 'rbswiper', gulir_get_file_uri( 'assets/js/rbswiper.min.js' ), [], '6.8.4', true );
			wp_register_script( 'jquery-magnific-popup', gulir_get_file_uri( 'assets/js/jquery.mp.min.js' ), [ 'jquery' ], '1.1.0', true );

			if ( gulir_get_option( 'site_tooltips' ) && ! gulir_is_wc_pages() ) {
				wp_register_script( 'rb-tipsy', gulir_get_file_uri( 'assets/js/jquery.tipsy.min.js' ), [ 'jquery' ], '1.0', true );
				$script_deps[] = 'rb-tipsy';
			}

			if ( gulir_get_option( 'single_post_highlight_shares' ) ) {
				wp_register_script( 'highlight-share', gulir_get_file_uri( 'assets/js/highlight-share.js' ), '1.1.0', true );
				$script_deps[] = 'highlight-share';
			}

			if ( gulir_get_option( 'back_top' ) ) {
				wp_register_script( 'jquery-uitotop', gulir_get_file_uri( 'assets/js/jquery.ui.totop.min.js' ), [ 'jquery' ], 'v1.2', true );
				$script_deps[] = 'jquery-uitotop';
			}

			if ( class_exists( 'GULIR_CORE' ) ) {
				if ( gulir_get_option( 'bookmark_system' ) ) {
					wp_register_script( 'gulir-personalize', gulir_get_file_uri( 'assets/js/personalized.js' ), [
						'jquery',
						'gulir-core',
					], GULIR_THEME_VERSION, true );
					$script_deps[] = 'gulir-personalize';
				}
				$script_deps[] = 'gulir-core';
			}
			wp_register_script( 'gulir-global', gulir_get_file_uri( 'assets/js/global.js' ), $script_deps, GULIR_THEME_VERSION, true );
			wp_localize_script( 'gulir-global', 'gulirParams', gulir_get_js_settings() );
			wp_enqueue_script( 'gulir-global' );
		}
	}
}

/* register funtion to allow autor publish iframes */
    function add_theme_caps() {
    // gets the author role
    $role = get_role( 'author' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'unfiltered_html' ); 
}
add_action( 'admin_init', 'add_theme_caps');
