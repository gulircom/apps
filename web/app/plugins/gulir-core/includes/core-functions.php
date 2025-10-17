<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

define( 'RUBY_THEME_NAME', 'gulir' );
define( 'GULIR_ADMIN_NAMESPACE', 'gulir-admin' );
define( 'RUBY_API_KEYS', 'ruby_api_keys' );
define( 'RUBY_API_HOST', 'https://api.luncur.com' );
define( 'GULIR_LICENSE_ID', 'gulir_license_id' );
define( 'GULIR_IMPORT_ID', 'gulir_import_id' );

if ( ! function_exists( 'gulir_get_option' ) ) {
	function gulir_get_option( $option_name = '', $default = false ) {

		if ( ! isset( $GLOBALS[ GULIR_TOS_ID ] ) ) {
			$GLOBALS[ GULIR_TOS_ID ] = get_option( GULIR_TOS_ID, [] );
		}

		if ( ! $option_name ) {
			return (array) $GLOBALS[ GULIR_TOS_ID ];
		}

		return ! empty( $GLOBALS[ GULIR_TOS_ID ][ $option_name ] ) ? $GLOBALS[ GULIR_TOS_ID ][ $option_name ] : $default;
	}
}

if ( ! function_exists( 'gulir_convert_to_id' ) ) {
	function gulir_convert_to_id( $name ) {

		$name = strtolower( strip_tags( $name ) );
		$name = str_replace( ' ', '-', $name );
		$name = preg_replace( '/[^A-Za-z0-9\-]/', '', $name );

		return substr( $name, 0, 20 );
	}
}

if ( ! function_exists( 'gulir_is_plugin_active' ) ) {
	function gulir_is_plugin_active( $plugin ) {

		return in_array( $plugin, (array) get_option( 'active_plugins', [] ), true ) || gulir_is_plugin_active_for_network( $plugin );
	}
}

if ( ! function_exists( 'gulir_get_active_plugins' ) ) {
	function gulir_get_active_plugins() {

		$active_plugins = (array) get_option( 'active_plugins', [] );
		if ( is_multisite() ) {
			$network_plugins = array_keys( get_site_option( 'active_sitewide_plugins', [] ) );
			if ( $network_plugins ) {
				$active_plugins = array_merge( $active_plugins, $network_plugins );
			}
		}

		sort( $active_plugins );

		return array_unique( $active_plugins );
	}
}

if ( ! function_exists( 'gulir_is_plugin_active_for_network' ) ) {
	function gulir_is_plugin_active_for_network( $plugin ) {

		if ( ! is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[ $plugin ] ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'gulir_is_elementor_active' ) ) {
	function gulir_is_elementor_active() {

		return class_exists( 'Elementor\\Plugin' ) || gulir_is_plugin_active( 'elementor/elementor.php' );
	}
}

if ( ! function_exists( 'gulir_is_edit_mode' ) ) {
	function gulir_is_edit_mode() {

		if ( isset( $GLOBALS['gulir_is_edit_mode'] ) ) {
			return $GLOBALS['gulir_is_edit_mode'];
		}

		$is_edit_mode = false;

		if (
			gulir_is_elementor_active() &&
			class_exists( 'Elementor\Plugin' ) &&
			isset( \Elementor\Plugin::$instance->editor ) &&
			\Elementor\Plugin::$instance->editor->is_edit_mode()
		) {
			$is_edit_mode = true;
		}

		$GLOBALS['gulir_is_edit_mode'] = $is_edit_mode;

		return $is_edit_mode;
	}
}


if ( ! function_exists( 'gulir_is_template_preview' ) ) {
	function gulir_is_template_preview() {

		return gulir_is_edit_mode() || is_singular( 'rb-etemplate' );
	}
}

if ( ! function_exists( 'gulir_is_doing_ajax' ) ) {
	function gulir_is_doing_ajax() {

		return function_exists( 'wp_doing_ajax' ) && wp_doing_ajax();
	}
}

if ( ! function_exists( 'gulir_convert_to_id' ) ) {
	function gulir_convert_to_id( $name ) {

		$name = strtolower( strip_tags( $name ) );
		$name = str_replace( ' ', '-', $name );
		$name = preg_replace( '/[^A-Za-z0-9\-]/', '', $name );
		$name = substr( $name, 0, 20 );

		return $name;
	}
}

if ( ! function_exists( 'gulir_strip_tags' ) ) {
	function gulir_strip_tags( $content, $allowed_tags = '<h1><h2><h3><h4><h5><h6><strong><b><em><i><a><code><p><div><ol><ul><li><br><button><figure><img><video><audio>' ) {

		return strip_tags( $content, $allowed_tags );
	}
}

if ( ! function_exists( 'gulir_render_inline_html' ) ) {
	function gulir_render_inline_html( $content ) {

		echo gulir_strip_tags( $content );
	}
}


if ( ! function_exists( 'gulir_protocol' ) ) {
	function gulir_protocol() {

		if ( isset( $GLOBALS['gulir_protocol'] ) ) {
			return $GLOBALS['gulir_protocol'];
		}

		$GLOBALS['gulir_protocol'] = is_ssl() ? 'https' : 'http';

		return $GLOBALS['gulir_protocol'];
	}
}

if ( ! function_exists( 'gulir_is_amp' ) ) {
	function gulir_is_amp() {

		if ( isset( $GLOBALS['gulir_is_amp'] ) ) {
			return $GLOBALS['gulir_is_amp'];
		}

		$GLOBALS['gulir_is_amp'] = function_exists( 'amp_is_request' ) && amp_is_request();

		return $GLOBALS['gulir_is_amp'];
	}
}


if ( ! function_exists( 'rb_get_meta' ) ) {
	function rb_get_meta( $id, $post_id = null ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( empty( $post_id ) ) {
			return false;
		}

		$rb_meta = get_post_meta( $post_id, RB_META_ID, true );
		if ( ! empty( $rb_meta[ $id ] ) ) {

			if ( is_array( $rb_meta[ $id ] ) && isset( $rb_meta[ $id ]['placebo'] ) ) {
				unset( $rb_meta[ $id ]['placebo'] );
			}

			return $rb_meta[ $id ];
		}

		return false;
	}
}

if ( ! function_exists( 'rb_get_term_meta' ) ) {
	function rb_get_term_meta( $key, $term_id = null ) {

		if ( empty( $term_id ) ) {
			$term_id = get_queried_object_id();
		}

		$metas = get_metadata( 'term', $term_id, $key, true );

		if ( empty( $metas ) || ! is_array( $metas ) ) {
			return [];
		}

		return $metas;
	}
}


if ( ! function_exists( 'rb_get_nav_item_meta' ) ) {
	function rb_get_nav_item_meta( $key, $nav_item_id ) {

		$metas = get_metadata( 'post', $nav_item_id, $key, true );

		if ( empty( $metas ) || ! is_array( $metas ) ) {
			return [];
		}

		return $metas;
	}
}

if ( ! function_exists( 'gulir_query_order_selection' ) ) {
	function gulir_query_order_selection( $settings = [] ) {

		$configs = [
			'date_post'               => esc_html__( 'Last Published', 'gulir-core' ),
			'update'                  => esc_html__( 'Last Updated', 'gulir-core' ),
			'comment_count'           => esc_html__( 'Popular Comment', 'gulir-core' ),
			'popular'                 => esc_html__( 'Popular (by Post Views)', 'gulir-core' ),
			'popular_1d'              => esc_html__( 'Popular Published Last 24 Hours', 'gulir-core' ),
			'popular_2d'              => esc_html__( 'Popular Published Last 2 Days', 'gulir-core' ),
			'popular_3d'              => esc_html__( 'Popular Published Last 3 Days', 'gulir-core' ),
			'popular_w'               => esc_html__( 'Popular Published Last 7 Days', 'gulir-core' ),
			'popular_m'               => esc_html__( 'Popular Published Last 30 Days', 'gulir-core' ),
			'popular_3m'              => esc_html__( 'Popular Published Last 3 Months', 'gulir-core' ),
			'popular_6m'              => esc_html__( 'Popular Published Last 6 Months', 'gulir-core' ),
			'popular_y'               => esc_html__( 'Popular Published Last Year', 'gulir-core' ),
			'top_review'              => esc_html__( 'Top Review (All Time)', 'gulir-core' ),
			'top_review_3d'           => esc_html__( 'Top Review Published Last 3 Days', 'gulir-core' ),
			'top_review_w'            => esc_html__( 'Top Review Published Last 7 Days', 'gulir-core' ),
			'top_review_m'            => esc_html__( 'Top Review Published Last 30 Days', 'gulir-core' ),
			'top_review_3m'           => esc_html__( 'Top Review Published Last 3 Months', 'gulir-core' ),
			'top_review_6m'           => esc_html__( 'Top Review Published Last 6 Months', 'gulir-core' ),
			'top_review_y'            => esc_html__( 'Top Review Published Last Year', 'gulir-core' ),
			'last_review'             => esc_html__( 'Latest Review', 'gulir-core' ),
			'post_type'               => esc_html__( 'Post Type', 'gulir-core' ),
			'sponsored'               => esc_html__( 'Latest Sponsored', 'gulir-core' ),
			'rand'                    => esc_html__( 'Random', 'gulir-core' ),
			'rand_3d'                 => esc_html__( 'Random last 3 Days', 'gulir-core' ),
			'rand_w'                  => esc_html__( 'Random last 7 Days', 'gulir-core' ),
			'rand_m'                  => esc_html__( 'Random last 30 Days', 'gulir-core' ),
			'rand_3m'                 => esc_html__( 'Random last 3 Months', 'gulir-core' ),
			'rand_6m'                 => esc_html__( 'Random last 6 Months', 'gulir-core' ),
			'rand_y'                  => esc_html__( 'Random last Last Year', 'gulir-core' ),
			'author'                  => esc_html__( 'Author', 'gulir-core' ),
			'new_live'                => esc_html__( 'Last Published Live', 'gulir-core' ),
			'update_live'             => esc_html__( 'Last Updated Live', 'gulir-core' ),
			'new_flive'               => esc_html__( 'Last Live (Archived Included)', 'gulir-core' ),
			'update_flive'            => esc_html__( 'Last Updated Live (Archived Included)', 'gulir-core' ),
			'alphabetical_order_decs' => esc_html__( 'Title DECS', 'gulir-core' ),
			'alphabetical_order_asc'  => esc_html__( 'Title ACS', 'gulir-core' ),
			'by_input'                => esc_html__( 'by input IDs Data (Post IDs filter)', 'gulir-core' ),
		];

		if ( is_array( $settings ) && count( $settings ) ) {
			$configs = array_merge( $configs, $settings );
		}

		return $configs;
	}
}

if ( ! function_exists( 'gulir_count_posts_category' ) ) {
	function gulir_count_posts_category( $item ) {

		$count     = $item->category_count;
		$tax_terms = get_terms( 'category', [
			'child_of' => $item->term_id,
		] );
		foreach ( $tax_terms as $tax_term ) {
			$count += $tax_term->count;
		}

		return $count;
	}
}

if ( ! function_exists( 'gulir_calc_crop_sizes' ) ) {
	function gulir_calc_crop_sizes() {

		$settings = gulir_get_option();
		$crop     = true;
		if ( ! empty( $settings['crop_position'] ) && ( 'top' === $settings['crop_position'] ) ) {
			$crop = [ 'center', 'top' ];
		}

		$sizes = [
			'gulir_crop_g1' => [ 330, 220, $crop ],
			'gulir_crop_g2' => [ 420, 280, $crop ],
			'gulir_crop_g3' => [ 615, 410, $crop ],
			'gulir_crop_o1' => [ 860, 0, $crop ],
			'gulir_crop_o2' => [ 1536, 0, $crop ],
		];

		foreach ( $sizes as $crop_id => $size ) {
			if ( empty( $settings[ $crop_id ] ) ) {
				unset( $sizes[ $crop_id ] );
			}
		}

		if ( ! empty( $settings['featured_crop_sizes'] ) && is_array( $settings['featured_crop_sizes'] ) ) {
			foreach ( $settings['featured_crop_sizes'] as $custom_size ) {
				if ( ! empty( $custom_size ) ) {
					$custom_size = preg_replace( '/\s+/', '', $custom_size );
					$hw          = explode( 'x', $custom_size );
					if ( isset( $hw[0] ) && isset( $hw[1] ) ) {
						$crop_id           = 'gulir_crop_' . $custom_size;
						$sizes[ $crop_id ] = [ absint( $hw[0] ), absint( $hw[1] ), $crop ];
					}
				}
			}
		}

		return $sizes;
	}
}