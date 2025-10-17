<?php

namespace gulirElementorControl;

use function esc_attr;
use function esc_html__;
use function gulir_count_posts_category;
use function gulir_query_order_selection;
use function get_categories;
use function get_post_types;
use function get_taxonomies;
use function get_users;
use function is_admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Options
 *
 * @package gulirElementorControl
 * options
 */
class Options {

	static function switch_dropdown( $default = true ) {

		if ( $default ) {
			return [
				'0'  => esc_html__( '- Default -', 'gulir-core' ),
				'1'  => esc_html__( 'Enable', 'gulir-core' ),
				'-1' => esc_html__( 'Disable', 'gulir-core' ),
			];
		} else {
			return [
				'1'  => esc_html__( 'Enable', 'gulir-core' ),
				'-1' => esc_html__( 'Disable', 'gulir-core' ),
			];
		}
	}

	static function cat_dropdown( $dynamic = false, $taxonomy = 'category' ) {

		$cache_key = 'gulir_cat_dropdown_' . ( $dynamic ? 'dynamic' : 'static' ) . '_' . $taxonomy;

		if ( isset( $GLOBALS[ $cache_key ] ) ) {
			return $GLOBALS[ $cache_key ];
		}

		$data = [
			'0' => esc_html__( '- All -', 'gulir-core' ),
		];

		if ( $dynamic ) {
			$data['dynamic'] = esc_html__( 'Dynamic Query', 'gulir-core' );
		}

		if ( is_admin() ) {
			$categories = get_categories( [
				'hide_empty' => 0,
				'taxonomy'   => $taxonomy,
				'parent'     => 0,
			] );

			$pos = 1;

			foreach ( $categories as $index => $item ) {
				$children = get_categories( [
					'hide_empty' => 0,
					'taxonomy'   => $taxonomy,
					'child_of'   => $item->term_id,
				] );
				if ( ! empty( $children ) ) {
					array_splice( $categories, $pos + $index, 0, $children );
					$pos += count( $children );
				}
			}

			foreach ( $categories as $item ) {
				$deep = '';
				if ( ! empty( $item->parent ) ) {
					$deep = '-- ';
				}

				$data[ $item->term_id ] = $deep . esc_attr( $item->name ) . ' - [ID: ' . esc_attr( $item->term_id ) . ' / Posts: ' . gulir_count_posts_category( $item ) . ']';
			}
		} else {

			// Frontend Mode: lightweight load Elementor
			$categories = get_categories( [
				'hide_empty' => 0,
				'taxonomy'   => $taxonomy,
			] );
			foreach ( $categories as $item ) {
				$data[ $item->term_id ] = $item->name;
			}
		}

		$GLOBALS[ $cache_key ] = $data;

		return $data;
	}

	static function cat_slug_dropdown() {

		if ( isset( $GLOBALS['gulir_cat_slug_dropdown'] ) ) {
			return $GLOBALS['gulir_cat_slug_dropdown'];
		}

		$data = [
			'0' => esc_html__( '- Select a category -', 'gulir-core' ),
		];

		if ( is_admin() ) {
			$categories = get_categories( [
				'hide_empty' => 0,
				'parent'     => 0,
			] );

			$pos = 1;

			foreach ( $categories as $index => $item ) {
				$children = get_categories( [
					'hide_empty' => 0,
					'child_of'   => $item->term_id,
				] );
				if ( ! empty( $children ) ) {
					array_splice( $categories, $pos + $index, 0, $children );
					$pos += count( $children );
				}
			}

			foreach ( $categories as $item ) {
				$deep = '';
				if ( ! empty( $item->parent ) ) {
					$deep = '--';
				}
				$data[ $item->slug ] = $deep . ' ' . $item->name . ' [Posts: ' . gulir_count_posts_category( $item ) . ']';
			}
		} else {
			// Frontend Mode: lightweight load Elementor
			$categories = get_categories( [
				'hide_empty' => 0,
			] );

			foreach ( $categories as $item ) {
				$data[ $item->slug ] = $item->name;
			}
		}


		$GLOBALS['gulir_cat_slug_dropdown'] = $data;

		return $data;
	}

	static function menu_dropdown() {

		if ( isset( $GLOBALS['gulir_menu_dropdown'] ) ) {
			return $GLOBALS['gulir_menu_dropdown'];
		}

		$menus = wp_get_nav_menus();
		$data  = [];

		if ( ! empty( $menus ) && is_array( $menus ) ) {
			foreach ( $menus as $menu ) {
				$data[ $menu->slug ] = $menu->name;
			}
		}
		$GLOBALS['gulir_menu_dropdown'] = $data;
		return $data;
	}


	static function post_type_dropdown() {

		if ( isset( $GLOBALS['gulir_post_type_dropdown'] ) ) {
			return $GLOBALS['gulir_post_type_dropdown'];
		}

		$post_types = get_post_types( [ 'public' => true ], 'objects' );

		/** unset post types */
		unset( $post_types['post'], $post_types['rb-etemplate'], $post_types['e-landing-page'], $post_types['elementor_library'] );

		$data = [
			'0' => esc_html__( '- Default -', 'gulir-core' ),
		];

		foreach ( $post_types as $post_type ) {
			$core_label = in_array(
				$post_type->name,
				[
					'post',
					'page',
					'attachment',
				],
				true
			) ? esc_html__( '(WP Core)', 'gulir-core' ) : '';

			$data[ $post_type->name ] = $post_type->label . ' ' . $core_label;
		}

		$GLOBALS['gulir_post_type_dropdown'] = $data;

		return $data;
	}


	static function taxonomy_dropdown() {

		if ( isset( $GLOBALS['gulir_taxonomy_dropdown'] ) ) {
			return $GLOBALS['gulir_taxonomy_dropdown'];
		}

		$taxes = get_taxonomies( [ 'public' => true ], 'objects' );
		unset( $taxes['nav_menu'], $taxes['post_format'] );
		$data = [
			'0' => esc_html__( '- Default -', 'gulir-core' ),
		];

		foreach ( $taxes as $tax ) {
			$data[ $tax->name ] = $tax->label;
		}

		$GLOBALS['gulir_taxonomy_dropdown'] = $data;

		return $data;
	}

	static function followed_dropdown() {

		return [
			'1'   => esc_html__( 'Categories', 'gulir-core' ),
			'2'   => esc_html__( 'Tags', 'gulir-core' ),
			'all' => esc_html__( 'All Taxonomies', 'gulir-core' ),
			'-1'  => esc_html__( 'Disable', 'gulir-core' ),
		];
	}


	static function order_dropdown( $settings = [] ) {

		return gulir_query_order_selection( $settings );
	}

	static function format_dropdown() {

		return [
			'0'       => esc_html__( '- All -', 'gulir-core' ),
			'default' => esc_html__( 'Post Only', 'gulir-core' ),
			'gallery' => esc_html__( 'Gallery', 'gulir-core' ),
			'video'   => esc_html__( 'Video', 'gulir-core' ),
			'audio'   => esc_html__( 'Audio', 'gulir-core' ),
		];
	}


	static function author_dropdown( $dynamic = false, $all = true ) {


		$cache_key = 'gulir_author_dropdown_' . ( $dynamic ? 'dynamic' : 'static' ) . '_' . ( $all ? 'all' : 'single' );

		if ( isset( $GLOBALS[ $cache_key ] ) ) {
			return $GLOBALS[ $cache_key ];
		}

		if ( ! isset( $GLOBALS['gulir_author_dropdown'] ) ) {
			$GLOBALS['gulir_author_dropdown'] = [];
		}

		$data = [];

		if ( $all ) {
			$data = [
				'0' => esc_html__( '- All -', 'gulir-core' ),
			];
		}

		if ( $dynamic ) {
			$data['dynamic_author'] = esc_html__( 'Dynamic Query', 'gulir-core' );
		}

		$blogusers = get_users( [
			'role__not_in' => [ 'subscriber' ],
			'fields'       => [ 'ID', 'display_name' ],
		] );

		if ( is_array( $blogusers ) ) {
			foreach ( $blogusers as $user ) {
				$data[ $user->ID ] = $user->display_name;
			}
		}

		$GLOBALS[ $cache_key ] = $data;

		return $data;
	}

	/**
	 * @param bool $default
	 *
	 * @return array|string[]
	 */
	static function heading_html_dropdown( $default = true ) {

		$settings = [
			'0'    => esc_html__( '- Default -', 'gulir-core' ),
			'h1'   => esc_html__( 'H1', 'gulir-core' ),
			'h2'   => esc_html__( 'H2', 'gulir-core' ),
			'h3'   => esc_html__( 'H3', 'gulir-core' ),
			'h4'   => esc_html__( 'H4', 'gulir-core' ),
			'h5'   => esc_html__( 'H5', 'gulir-core' ),
			'h6'   => esc_html__( 'H6', 'gulir-core' ),
			'p'    => esc_html__( 'p', 'gulir-core' ),
			'span' => esc_html__( 'span', 'gulir-core' ),
			'div'  => esc_html__( 'div', 'gulir-core' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	static function excerpt_dropdown() {

		return [
			'0' => esc_html__( '- Default -', 'gulir-core' ),
			'1' => esc_html__( 'Custom Settings Below', 'gulir-core' ),
		];
	}

	static function excerpt_source_dropdown() {

		return [
			'0'       => esc_html__( 'Use Post Excerpt', 'gulir-core' ),
			'tagline' => esc_html__( 'Use Title Tagline', 'gulir-core' ),
		];
	}

	/** featured dropdown */
	static function feat_hover_dropdown() {

		return [
			'0'         => esc_html__( '- Disable -', 'gulir-core' ),
			'scale'     => esc_html__( 'Scale', 'gulir-core' ),
			'fade'      => esc_html__( 'Fade Out', 'gulir-core' ),
			'bw'        => esc_html__( 'Black & White', 'gulir-core' ),
			'bw-invert' => esc_html__( 'Black & White Invert', 'gulir-core' ),
		];
	}

	/**
	 * @return array
	 */
	static function feat_lazyload_dropdown() {

		return [
			'0'    => esc_html__( '- Default -', 'gulir-core' ),
			'none' => esc_html__( 'Disable', 'gulir-core' ),
			'1'    => esc_html__( 'Enable', 'gulir-core' ),
			'e-1'  => esc_html__( 'Enable except 1st image', 'gulir-core' ),
			'e-2'  => esc_html__( 'Enable except 2 first images', 'gulir-core' ),
			'e-3'  => esc_html__( 'Enable except 3 first images', 'gulir-core' ),
			'e-4'  => esc_html__( 'Enable except 4 first images', 'gulir-core' ),
			'e-5'  => esc_html__( 'Enable except 5 first images', 'gulir-core' ),
			'e-6'  => esc_html__( 'Enable except 6 first images', 'gulir-core' ),
		];
	}

	/**
	 * @return array
	 */
	static function feat_lazyload_simple_dropdown() {

		return [
			'0'    => esc_html__( '- Default -', 'gulir-core' ),
			'none' => esc_html__( 'Disable', 'gulir-core' ),
			'1'    => esc_html__( 'Enable', 'gulir-core' ),
		];
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function extended_entry_category_dropdown( $default = true ) {

		$settings = [
			'0'              => esc_html__( 'Default from Theme Option', 'gulir-core' ),
			'bg-1'           => esc_html__( 'Background 1', 'gulir-core' ),
			'bg-1,big'       => esc_html__( 'Background 1 (Big)', 'gulir-core' ),
			'bg-2'           => esc_html__( 'Background 2', 'gulir-core' ),
			'bg-2,big'       => esc_html__( 'Background 2 (Big)', 'gulir-core' ),
			'bg-3'           => esc_html__( 'Background 3', 'gulir-core' ),
			'bg-3,big'       => esc_html__( 'Background 3 (Big)', 'gulir-core' ),
			'bg-4'           => esc_html__( 'Background 4', 'gulir-core' ),
			'bg-4,big'       => esc_html__( 'Background 4 (Big)', 'gulir-core' ),
			'text'           => esc_html__( 'Only Text', 'gulir-core' ),
			'text,big'       => esc_html__( 'Only Text (Big)', 'gulir-core' ),
			'border'         => esc_html__( 'Border', 'gulir-core' ),
			'border,big'     => esc_html__( 'Border (Big)', 'gulir-core' ),
			'b-border'       => esc_html__( 'Bottom Line', 'gulir-core' ),
			'b-border,big'   => esc_html__( 'Bottom Line (Big)', 'gulir-core' ),
			'b-dotted'       => esc_html__( 'Bottom Dotted', 'gulir-core' ),
			'b-dotted,big'   => esc_html__( 'Bottom Dotted (Big)', 'gulir-core' ),
			'b-border-2'     => esc_html__( 'Bottom Border', 'gulir-core' ),
			'b-border-2,big' => esc_html__( 'Bottom Border (Big)', 'gulir-core' ),
			'l-dot'          => esc_html__( 'Left Dot', 'gulir-core' ),
			'-1'             => esc_html__( 'Disable', 'gulir-core' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	static function entry_meta_dropdown() {

		return [
			'0'      => esc_html__( 'Default from Theme Option', 'gulir-core' ),
			'custom' => esc_html__( 'Custom Below', 'gulir-core' ),
			'-1'     => esc_html__( 'Disable', 'gulir-core' ),
		];
	}

	static function sponsor_dropdown( $default = true ) {

		if ( $default ) {
			return [
				'0'  => esc_html__( '- Default -', 'gulir-core' ),
				'1'  => esc_html__( 'Enable', 'gulir-core' ),
				'2'  => esc_html__( 'Enable without Label', 'gulir-core' ),
				'-1' => esc_html__( 'Disable', 'gulir-core' ),
			];
		} else {
			return [
				'1'  => esc_html__( 'Enable', 'gulir-core' ),
				'2'  => esc_html__( 'Enable without Label', 'gulir-core' ),
				'-1' => esc_html__( 'Disable', 'gulir-core' ),
			];
		}
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function entry_format_dropdown( $default = true ) {

		$settings = [
			'0'              => esc_html__( 'Default from Theme Option', 'gulir-core' ),
			'bottom'         => esc_html__( 'Bottom Right', 'gulir-core' ),
			'bottom,big'     => esc_html__( 'Bottom Right (Big Icon) ', 'gulir-core' ),
			'top'            => esc_html__( 'Top', 'gulir-core' ),
			'top,big'        => esc_html__( 'Top (Big Icon)', 'gulir-core' ),
			'center'         => esc_html__( 'Center', 'gulir-core' ),
			'center,big'     => esc_html__( 'Center (Big Icon)', 'gulir-core' ),
			'after-category' => esc_html__( 'After Entry Category', 'gulir-core' ),
			'-1'             => esc_html__( 'Disable', 'gulir-core' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function review_dropdown( $default = true ) {

		$settings = [
			'0'       => esc_html__( 'Default from Theme Option', 'gulir-core' ),
			'1'       => esc_html__( 'Enable', 'gulir-core' ),
			'replace' => esc_html__( 'Replace for Entry Meta', 'gulir-core' ),
			'-1'      => esc_html__( 'Disable', 'gulir-core' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	/**
	 * @return array
	 */
	static function flex_review_dropdown() {

		return [
			'0'       => esc_html__( '- Default -', 'gulir-core' ),
			'replace' => esc_html__( 'Replace for Entry Meta', 'gulir-core' ),

		];
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function review_meta_dropdown( $default = true ) {

		$settings = [
			'0'  => esc_html__( '- Default -', 'gulir-core' ),
			'1'  => esc_html__( 'No Wrap', 'gulir-core' ),
			'2'  => esc_html__( 'Desktop No Wrap - Mobile Line Wrap', 'gulir-core' ),
			'3'  => esc_html__( 'Line Wrap', 'gulir-core' ),
			'4'  => esc_html__( 'No Wrap (Show Score Only)', 'gulir-core' ),
			'5'  => esc_html__( 'Line Wrap (Show Score Only)', 'gulir-core' ),
			'-1' => esc_html__( 'Disable', 'gulir-core' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}

	/**
	 * @param array $configs
	 *
	 * @return array
	 * columns_dropdown
	 */
	static function columns_dropdown( $configs = [] ) {

		$settings = [];

		$default = [
			'0' => esc_html__( '- Default -', 'gulir-core' ),
			'1' => esc_html__( '1 Column', 'gulir-core' ),
			'2' => esc_html__( '2 Columns', 'gulir-core' ),
			'3' => esc_html__( '3 Columns', 'gulir-core' ),
			'4' => esc_html__( '4 Columns', 'gulir-core' ),
			'5' => esc_html__( '5 Columns', 'gulir-core' ),
			'6' => esc_html__( '6 Columns', 'gulir-core' ),
			'7' => esc_html__( '7 Columns', 'gulir-core' ),
		];

		if ( ! is_array( $configs ) || ! count( $configs ) ) {
			return $default;
		}
		foreach ( $configs as $item ) {
			$settings[ $item ] = $default[ $item ];
		}

		return $settings;
	}

	/**
	 * @return array
	 * column_gap_dropdown
	 */
	static function column_gap_dropdown() {

		return [
			'0'      => esc_html__( '- Default -', 'gulir-core' ),
			'none'   => esc_html__( 'No Gap', 'gulir-core' ),
			'5'      => esc_html__( '10px', 'gulir-core' ),
			'7'      => esc_html__( '14px', 'gulir-core' ),
			'10'     => esc_html__( '20px', 'gulir-core' ),
			'15'     => esc_html__( '30px', 'gulir-core' ),
			'20'     => esc_html__( '40px', 'gulir-core' ),
			'25'     => esc_html__( '50px', 'gulir-core' ),
			'30'     => esc_html__( '60px', 'gulir-core' ),
			'35'     => esc_html__( '70px', 'gulir-core' ),
			'custom' => esc_html__( 'Custom Value', 'gulir-core' ),
		];
	}

	/**
	 * @param array $disabled
	 *
	 * @return array
	 * pagination dropdown
	 */
	static function pagination_dropdown( $disabled = [] ) {

		$settings = [
			'0'               => esc_html__( '- Disable -', 'gulir-core' ),
			'next_prev'       => esc_html__( 'Next Prev', 'gulir-core' ),
			'load_more'       => esc_html__( 'Show More', 'gulir-core' ),
			'infinite_scroll' => esc_html__( 'Infinite Scroll', 'gulir-core' ),
		];

		if ( count( $disabled ) ) {
			foreach ( $disabled as $key ) {
				unset( $settings[ $key ] );
			}
		}

		return $settings;
	}

	/**
	 * @return array
	 */
	static function template_builder_pagination_dropdown() {

		return [
			'0'               => esc_html__( '- Disable -', 'gulir-core' ),
			'number'          => esc_html__( 'Numeric', 'gulir-core' ),
			'simple'          => esc_html__( 'Simple', 'gulir-core' ),
			'load_more'       => esc_html__( 'Show More (ajax)', 'gulir-core' ),
			'infinite_scroll' => esc_html__( 'Infinite Scroll (ajax)', 'gulir-core' ),
		];
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function crop_size_dropdown( $default = true ) {

		if ( isset( $GLOBALS['gulir_crop_size_dropdown'] ) ) {
			return $GLOBALS['gulir_crop_size_dropdown'];
		}

		global $_wp_additional_image_sizes;

		$data = [];

		if ( $default ) {
			$data['0'] = esc_html__( '- Default -', 'gulir-core' );
		}

		if ( ! empty( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $size => $info ) {
				$data[ $size ] = $info['width'] . 'x' . $info['height'] . ' (' . $size . ')';
			}
		}

		$data['thumbnail']    = esc_html__( 'Thumbnail (Core WP)', 'gulir-core' );
		$data['medium']       = esc_html__( 'Medium (Core WP)', 'gulir-core' );
		$data['medium_large'] = esc_html__( 'Medium Large (Core WP)', 'gulir-core' );
		$data['large']        = esc_html__( 'Large (Core WP)', 'gulir-core' );

		$GLOBALS['gulir_crop_size_dropdown'] = $data;

		return $data;
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function featured_position_dropdown( $default = true ) {

		if ( $default ) {
			return [
				'0'     => esc_html__( '- Default -', 'gulir-core' ),
				'left'  => esc_html__( 'Left', 'gulir-core' ),
				'right' => esc_html__( 'Right', 'gulir-core' ),
			];
		} else {
			return [
				'left'  => esc_html__( 'Left', 'gulir-core' ),
				'right' => esc_html__( 'Right', 'gulir-core' ),
			];
		}
	}

	/**
	 * @param bool $default
	 *
	 * @return array
	 */
	static function hide_dropdown( $default = true ) {

		if ( $default ) {
			return [
				'0'      => esc_html__( '- Default -', 'gulir-core' ),
				'mobile' => esc_html__( 'On Mobile', 'gulir-core' ),
				'tablet' => esc_html__( 'On Tablet', 'gulir-core' ),
				'all'    => esc_html__( 'On Tablet & Mobile', 'gulir-core' ),
				'-1'     => esc_html__( 'Disable', 'gulir-core' ),
			];
		} else {
			return [
				'0'      => esc_html__( '- Disable -', 'gulir-core' ),
				'mobile' => esc_html__( 'On Mobile', 'gulir-core' ),
				'tablet' => esc_html__( 'On Tablet', 'gulir-core' ),
				'all'    => esc_html__( 'Tablet & Mobile', 'gulir-core' ),
			];
		}
	}

	static function box_style_dropdown() {

		return [
			'0'      => esc_html__( '- Default -', 'gulir-core' ),
			'bg'     => esc_html__( 'Background', 'gulir-core' ),
			'border' => esc_html__( 'Border', 'gulir-core' ),
			'shadow' => esc_html__( 'Shadow', 'gulir-core' ),
		];
	}

	static function column_border_dropdown() {

		return [
			'0'         => esc_html__( '- Disable -', 'gulir-core' ),
			'gray'      => esc_html__( 'Gray Solid', 'gulir-core' ),
			'dark'      => esc_html__( 'Dark Solid', 'gulir-core' ),
			'dark-bold' => esc_html__( 'Bold Dark Solid', 'gulir-core' ),
			'gray-dot'  => esc_html__( 'Gray Dotted', 'gulir-core' ),
			'dark-dot'  => esc_html__( 'Dark Dotted', 'gulir-core' ),
			'gray-dash' => esc_html__( 'Gray Dashed', 'gulir-core' ),
			'dark-dash' => esc_html__( 'Dark Dashed', 'gulir-core' ),
		];
	}

	static function pagination_style_dropdown() {
		return [
			'0'       => esc_html__( '- Default -', 'gulir-core' ),
			'fw'      => esc_html__( 'Fullwidth Background', 'gulir-core' ),
			'border'  => esc_html__( 'Border', 'gulir-core' ),
			'fborder' => esc_html__( 'Fullwidth Border', 'gulir-core' ),
			'text'    => esc_html__( 'Text Only', 'gulir-core' ),
		];
	}

	/**
	 * @return array
	 */
	static function ad_size_dropdown() {

		return [
			'1'  => esc_html__( 'Leaderboard (728x90)', 'gulir-core' ),
			'2'  => esc_html__( 'Banner (468x60)', 'gulir-core' ),
			'3'  => esc_html__( 'Half banner (234x60)', 'gulir-core' ),
			'4'  => esc_html__( 'Button (125x125)', 'gulir-core' ),
			'5'  => esc_html__( 'Skyscraper (120x600)', 'gulir-core' ),
			'6'  => esc_html__( 'Wide Skyscraper (160x600)', 'gulir-core' ),
			'7'  => esc_html__( 'Small Rectangle (180x150)', 'gulir-core' ),
			'8'  => esc_html__( 'Vertical Banner (120 x 240)', 'gulir-core' ),
			'9'  => esc_html__( 'Small Square (200x200)', 'gulir-core' ),
			'10' => esc_html__( 'Square (250x250)', 'gulir-core' ),
			'11' => esc_html__( 'Medium Rectangle (300x250)', 'gulir-core' ),
			'12' => esc_html__( 'Large Rectangle (336x280)', 'gulir-core' ),
			'13' => esc_html__( 'Half Page (300x600)', 'gulir-core' ),
			'14' => esc_html__( 'Portrait (300x1050)', 'gulir-core' ),
			'15' => esc_html__( 'Mobile Banner (320x50)', 'gulir-core' ),
			'16' => esc_html__( 'Large Leaderboard (970x90)', 'gulir-core' ),
			'17' => esc_html__( 'Billboard (970x250)', 'gulir-core' ),
			'18' => esc_html__( 'Mobile Banner (320x100)', 'gulir-core' ),
			'19' => esc_html__( 'Mobile Friendly (300x100)', 'gulir-core' ),
			'-1' => esc_html__( 'Hide on Desktop', 'gulir-core' ),
		];
	}

	static function vertical_align_dropdown( $default = true ) {

		if ( $default ) {
			return [
				'0'  => esc_html__( '- Default -', 'gulir-core' ),
				'1'  => esc_html__( 'Middle', 'gulir-core' ),
				'-1' => esc_html__( 'Bottom', 'gulir-core' ),
				'2'  => esc_html__( 'Top', 'gulir-core' ),
			];
		} else {
			return [
				'1'  => esc_html__( 'Middle', 'gulir-core' ),
				'-1' => esc_html__( 'Bottom', 'gulir-core' ),
				'2'  => esc_html__( 'Top', 'gulir-core' ),
			];
		}
	}

	static function responsive_layout_dropdown( $default = true ) {

		if ( $default ) {
			return [
				'0'    => esc_html__( '- Default -', 'gulir-core' ),
				'grid' => esc_html__( 'Grid', 'gulir-core' ),
				'list' => esc_html__( 'List', 'gulir-core' ),
			];
		} else {
			return [
				'grid' => esc_html__( 'Grid', 'gulir-core' ),
				'list' => esc_html__( 'List', 'gulir-core' ),
			];
		}
	}

	/**
	 * @return array
	 */
	static function divider_style_dropdown() {

		return [
			'solid'   => esc_html__( 'Solid', 'gulir-core' ),
			'bold'    => esc_html__( 'Bold Solid', 'gulir-core' ),
			'dashed'  => esc_html__( 'Dashed', 'gulir-core' ),
			'bdashed' => esc_html__( 'Bold Dashed', 'gulir-core' ),
			'zigzag'  => esc_html__( 'Zigzag', 'gulir-core' ),
		];
	}

	static function horizontal_scroll_dropdown() {

		return [
			'0'      => esc_html__( '- Disable -', 'gulir-core' ),
			'1'      => esc_html__( 'Tablet & Mobile', 'gulir-core' ),
			'tablet' => esc_html__( 'Tablet Only', 'gulir-core' ),
			'mobile' => esc_html__( 'Mobile Only', 'gulir-core' ),
		];
	}

	static function meta_divider_dropdown() {

		return [
			'0'           => esc_html__( '- Default -', 'gulir-core' ),
			'default'     => esc_html__( 'Vertical Line', 'gulir-core' ),
			'line'        => esc_html__( 'Solid Line', 'gulir-core' ),
			'gray-line'   => esc_html__( 'Gray Solid Line', 'gulir-core' ),
			'dot'         => esc_html__( 'Dot', 'gulir-core' ),
			'gray-dot'    => esc_html__( 'Gray Dot', 'gulir-core' ),
			'none'        => esc_html__( 'White Spacing', 'gulir-core' ),
			'wrap'        => esc_html__( 'Line Wrap', 'gulir-core' ),
			'gray-dslash' => esc_html__( 'Gray Double Slash', 'gulir-core' ),
			'dslash'      => esc_html__( 'Double Slash', 'gulir-core' ),
		];
	}

	static function count_posts_dropdown( $default = true ) {

		return [
			'1'  => esc_html__( '- Enable -', 'gulir-core' ),
			'2'  => esc_html__( 'Include Children Taxonomies', 'gulir-core' ),
			'-1' => esc_html__( 'Disable', 'gulir-core' ),
		];
	}

	static function menu_divider_dropdown() {

		return [
			'0'      => esc_html__( 'None', 'gulir-core' ),
			'slash'  => esc_html__( 'Slash (/)', 'gulir-core' ),
			'pipe'   => esc_html__( 'Pipe (|)', 'gulir-core' ),
			'pipe-2' => esc_html__( 'Pipe 2 (|)', 'gulir-core' ),
			'hyphen' => esc_html__( 'Hyphen (-)', 'gulir-core' ),
			'dot'    => esc_html__( 'Dot (.)', 'gulir-core' ),
			'dot-2'  => esc_html__( 'Dot 2(.)', 'gulir-core' ),
		];
	}

	static function counter_dropdown() {

		return [
			'0'          => esc_html__( 'None', 'gulir-core' ),
			'1'          => esc_html__( 'Right Opacity', 'gulir-core' ),
			'inline'     => esc_html__( 'Inline before Title', 'gulir-core' ),
			'circle'     => esc_html__( 'Circle Inline Before Title', 'gulir-core' ),
			'circle-sq'  => esc_html__( 'Square Inline Before Title', 'gulir-core' ),
			'inline-b'   => esc_html__( 'Block before Title', 'gulir-core' ),
			'circle-b'   => esc_html__( 'Block Circle Before Title', 'gulir-core' ),
			'circle-sqb' => esc_html__( 'Block Square Before Title', 'gulir-core' ),
		];
	}

	static function counter_zero_dropdown() {
		return [
			'decimal-leading-zero' => esc_html__( 'With Leading Zero', 'gulir-core' ),
			'decimal'              => esc_html__( 'Without Leading Zero', 'gulir-core' ),
		];
	}

	static function category_description() {

		return esc_html__( 'Filter posts by category.', 'gulir-core' );
	}

	static function categories_description() {

		return esc_html__( 'Filter posts by multiple category IDs, separated by commas (e.g. 1, 2, 3).', 'gulir-core' );
	}

	static function category_not_in_description() {

		return esc_html__( 'Exclude category IDs. This setting is only available when selecting all categories, separated by commas (e.g. 1, 2, 3).', 'gulir-core' );
	}

	static function tags_description() {

		return esc_html__( 'Filter posts by tag slugs, separated by commas (e.g. tagslug1, tagslug2, tagslug3).', 'gulir-core' );
	}

	static function tag_not_in_description() {

		return esc_html__( 'Exclude tag slugs, separated by commas (e.g. tagslug1, tagslug2, tagslug3).', 'gulir-core' );
	}

	static function format_description() {

		return esc_html__( 'Filter posts by post format.', 'gulir-core' );
	}

	static function author_description() {

		return esc_html__( 'Filter posts by post author.', 'gulir-core' );
	}

	static function post_not_in_description() {

		return esc_html__( 'Exclude posts by Post IDs, separated by commas (e.g. 1,2,3).', 'gulir-core' );
	}

	static function post_in_description() {

		return esc_html__( 'Filter posts by post IDs. separated by commas (e.g. 1,2,3).', 'gulir-core' );
	}

	static function order_description() {

		return esc_html__( 'Please select a type to order the query results.', 'gulir-core' );
	}

	static function posts_per_page_description() {

		return esc_html__( 'Select the number of posts to display at once.', 'gulir-core' );
	}

	static function offset_description() {

		return esc_html__( 'Specify the number of posts to skip. Leaving it blank starts from the beginning. Use with caution: enabling this setting may result in missing posts if Unique posts is activated', 'gulir-core' );
	}

	static function heading_html_description() {

		return esc_html__( 'Select a title HTML tag for the main title.', 'gulir-core' );
	}

	static function sub_heading_html_description() {

		return esc_html__( 'Select a title HTML tag for the secondary titles.', 'gulir-core' );
	}

	static function crop_size() {

		return esc_html__( 'Select a featured image size to optimize with the columns setting.', 'gulir-core' );
	}

	static function featured_width_description() {

		return esc_html__( 'Input custom width values (in pixels) for the featured image.', 'gulir-core' );
	}

	static function featured_position_description() {

		return esc_html__( 'Select a position of the featured image for this layout.', 'gulir-core' );
	}

	static function display_ratio_description() {

		return esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. e.g. 50', 'gulir-core' );
	}

	static function feat_hover_description() {

		return esc_html__( 'Select a hover effect for this block featured images.', 'gulir-core' );
	}

	static function feat_align_description() {

		return esc_html__( 'Align the featured images for this block.', 'gulir-core' );
	}

	static function feat_lazyload_description() {

		return esc_html__( 'Disable lazy load image if this block is above the fold. The default is base on Theme Options > Performance > Featured Image - Lazy Load', 'gulir-core' );
	}

	static function entry_category_description() {

		return esc_html__( 'Select category icons style in this block. Access "Theme Options > Theme Design > Entry Category" for global settings, including colors, the total limit to display, and more.', 'gulir-core' );
	}

	static function entry_category_size_description() {

		return esc_html__( 'Quickly edit the entry category font size. Leave it blank if you want to control additional font values via font settings.', 'gulir-core' );
	}

	static function entry_meta_description() {

		return esc_html__( 'Enable or disable the post entry meta.', 'gulir-core' );
	}

	static function entry_meta_tags_description() {

		return esc_html__( 'Input custom entry meta tags to show, separate by comma. e.g. avatar,author,update. Keys include: [avatar, author, date, category, tag, view, comment, update, read, like, bookmark, custom].', 'gulir-core' );
	}

	static function entry_meta_tags_placeholder() {

		return 'avatar, author, date, category, tag, view, comment, update, read, like, bookmark, custom, taxonomy-slug';
	}

	static function podcast_entry_meta_tags_description() {

		return esc_html__( 'Input custom entry meta tags to show, separate by comma. e.g. avatar,author,update. Keys include: [avatar, author, date, category, tag, view, comment, update, read, duration, play].', 'gulir-core' );
	}

	static function podcast_entry_meta_tags_placeholder() {

		return 'avatar, author, date, category, tag, view, comment, update, read, duration, index, play, taxonomy-slug';
	}

	static function meta_prefix_description() {

		return esc_html__( 'Prefix & Suffix: You can add a prefix or suffix to a meta using the following format: prefix {meta_key} suffix. For example: author, Categories: {category}, view. You can also allow inline HTML tags such as <i>, <span>, etc.', 'gulir-core' );
	}

	static function meta_flex_description() {

		return esc_html__( 'Taxonomy & Custom Field: Input the "Taxonomy Key" or the "custom field ID" (meta boxes) to display the custom taxonomy or custom field value', 'gulir-core' );
	}

	static function flex_1_structure_placeholder() {

		return 'title, thumbnail, meta, review, excerpt, readmore';
	}

	static function flex_2_structure_placeholder() {

		return 'category, title, thumbnail, meta, review, excerpt, readmore';
	}

	static function entry_meta_size_description() {

		return esc_html__( 'Input custom font size value for the entry meta of this layout. Leave blank if you would like to set it as the default.', 'gulir-core' );
	}

	static function avatar_size_description() {

		return esc_html__( 'Input custom avatar size for this layout. Leave blank if you would like to set it as the default (22px).', 'gulir-core' );
	}

	static function review_description() {

		return esc_html__( 'Disable or select setting for the post review meta.', 'gulir-core' );
	}

	static function entry_format_description() {

		return esc_html__( 'Enable or disable the post format icon.', 'gulir-core' );
	}

	static function entry_format_size_description() {

		return esc_html__( 'Input custom font size value for the post format icon of this layout. Leave blank if you would like to set it as the default.', 'gulir-core' );
	}

	static function excerpt_size_description() {

		return esc_html__( 'Input font size values for the excerpt.', 'gulir-core' );
	}

	static function excerpt_columns_description() {

		return esc_html__( 'Select columns for the excerpt, This setting will apply to the desktop and tablet devices.', 'gulir-core' );
	}

	static function review_meta_description() {

		return esc_html__( 'Select a layout or disable the meta description at the end of the review bar.', 'gulir-core' );
	}

	static function review_size_description() {

		return esc_html__( 'Enter the icon size value (in pixels) for the review star and score section.', 'gulir-core' );
	}

	static function bookmark_description() {

		return esc_html__( 'Please ensure at least one entry meta is enabled and that the "Personalized System" setting in Theme Options > Personalized System > Global is also enabled.', 'gulir-core' );
	}

	static function excerpt_description() {

		return esc_html__( 'Customize the post excerpt.', 'gulir-core' );
	}

	static function max_excerpt_description() {

		return esc_html__( 'Leave this option blank or set it to 0 to disable the custom excerpt length. Choose "Custom Settings Below" in the above "Excerpt" option to activate this setting.', 'gulir-core' );
	}

	static function excerpt_source_description() {

		return esc_html__( 'Select a source of content to display for the post excerpt. To activate this setting, choose "Custom Settings Below" in the "Excerpt" option above.', 'gulir-core' );
	}

	static function readmore_description() {

		return esc_html__( 'Enable or disable the read more button.', 'gulir-core' );
	}

	static function readmore_size_description() {

		return esc_html__( 'Input custom font sizes for the read more button.', 'gulir-core' );
	}

	static function columns_description() {

		return esc_html__( 'Select the total number of columns to show per row on desktop devices.', 'gulir-core' );
	}

	static function columns_tablet_description() {

		return esc_html__( 'Select the total number of columns to show per row on tablet devices.', 'gulir-core' );
	}

	static function columns_mobile_description() {

		return esc_html__( 'Select the total number of columns to show per row on mobile devices.', 'gulir-core' );
	}

	static function column_gap_description() {

		return esc_html__( 'Choose a column spacing. Select "Custom" to enter specific values manually.', 'gulir-core' );
	}

	static function column_gap_custom_description() {

		return esc_html__( 'Input custom gap between columns (in pixels) for desktop, tablet, and mobile devices. The spacing will be 2x your input values.', 'gulir-core' );
	}

	static function column_border_description() {

		return esc_html__( 'Show vertical borders between columns.', 'gulir-core' );
	}

	static function pagination_description() {

		return esc_html__( 'Select an AJAX pagination type. This setting does not apply when using "Global Query". Use the WP Global Query Pagination setting instead.', 'gulir-core' );
	}

	static function unique_info() {

		return esc_html__( 'OFFSET Notice: If you enable the Unique Post, it\'s recommended to leave the "Post Offset" field in Query settings blank. Enabling the offset may cause the beginning posts to be bypassed.', 'gulir-core' );
	}

	static function unique_description() {

		return esc_html__( 'Avoid duplicate posts that have been queried before this block.', 'gulir-core' );
	}

	static function dynamic_query_info() {

		return esc_html__( 'If you assign this template to a category, author, tag, or taxonomy page, the dynamic query helps you create featured or additional sections. It filters posts based on the current page where it is displayed.', 'gulir-core' );
	}

	static function dynamic_tag_info() {

		return esc_html__( 'You can input "{dynamic}" into the "Tags Slug Filter" or "Define Taxonomy" if you want to filter tags or taxonomy dynamically based on the current page.', 'gulir-core' );
	}

	static function dynamic_render_info() {

		return esc_html__( 'Dynamic query cannot execute in this live editor. The latest posts will be displayed. Your change will be effect when you assign this template to a category page.', 'gulir-core' );
	}

	static function scroll_description() {

		return esc_html__( 'Enable the scroll bar.', 'gulir-core' );
	}

	static function scroll_height_description() {

		return esc_html__( 'Input the max block height (in px) when you would like to enable scrollbar. Leave this option blank to disable the scroll bar.', 'gulir-core' );
	}

	static function color_scheme_description() {

		return esc_html__( 'Select a text color scheme (light or dark) to suit with the background of the block it will be displayed on.', 'gulir-core' );
	}

	static function overlay_bg_info() {

		return esc_html__( 'Ensure the background makes the text easy to read. You can set the background to #0000 (100% transparent) to remove the gradient or use the same gradient colors for a solid background.', 'gulir-core' );
	}

	static function box_style_description() {

		return esc_html__( 'Select a box style for the post listing .', 'gulir-core' );
	}

	static function box_color_description() {

		return esc_html__( 'Select a color for the background or border style.', 'gulir-core' );
	}

	static function box_dark_color_description() {

		return esc_html__( 'Select a color in dark mode or light scheme mode for the background or border style.', 'gulir-core' );
	}

	static function custom_font_info_description() {

		return esc_html__( 'The settings below will override on theme option settings and the above font size settings.', 'gulir-core' );
	}

	static function counter_index_info() {

		return esc_html__( 'The counter index helps display an indicator for popular posts or reorder posts to attract visitor attention. This feature is not compatible with slider mode.', 'gulir-core' );
	}

	static function counter_description() {

		return esc_html__( 'Choose where the counter will be displayed, including its visual style.', 'gulir-core' );
	}

	static function counter_zero_description() {

		return esc_html__( 'Choose where the counter will be displayed, including its visual style.', 'gulir-core' );
	}

	static function counter_set_description() {

		return esc_html__( 'Set a start value (index -1) for the counter.', 'gulir-core' );
	}

	static function counter_size_description() {

		return esc_html__( 'Choose the font for the index counter.', 'gulir-core' );
	}

	static function divider_style_description() {

		return esc_html__( 'Input custom font sizes for the counter. Please blank to set it as the default.', 'gulir-core' );
	}

	static function divider_width_description() {

		return esc_html__( 'Input a custom width (in pixels) for the divider.', 'gulir-core' );
	}

	static function divider_color_description() {

		return esc_html__( 'Select a color for the divider.', 'gulir-core' );
	}

	static function divider_dark_color_description() {

		return esc_html__( 'Select a color for the divider in dark mode.', 'gulir-core' );
	}

	static function hide_divider_description() {

		return esc_html__( 'Hide the divider on tablet and mobile devices.', 'gulir-core' );
	}

	static function title_size_description() {

		return esc_html__( 'Quickly edit title size. Leave it blank if you want to control additional font values via font settings.', 'gulir-core' );
	}

	static function title_color_description() {

		return esc_html__( 'Select a color for the post title. The title is set to white in the dark mode.', 'gulir-core' );
	}

	static function sub_title_size_description() {

		return esc_html__( 'Input custom font size values (in pixels) for the secondary post title for displaying in this block.', 'gulir-core' );
	}

	static function meta_divider_description() {

		return esc_html__( 'Select a divider style between entry metas.', 'gulir-core' );
	}

	static function sponsor_meta_description() {

		return esc_html__( 'Enable or disable the "sponsored by" meta for this post listing.', 'gulir-core' );
	}

	static function hide_category_description() {

		return esc_html__( 'Hide the entry category on tablet and mobile devices.', 'gulir-core' );
	}

	static function hide_excerpt_description() {

		return esc_html__( 'Hide the post excerpt on tablet and mobile devices.', 'gulir-core' );
	}

	static function hide_excerpt_by_title_description() {

		return esc_html__( 'Disable the post excerpt based on the maximum post title length. Input the maximum number of title words to display the excerpt.', 'gulir-core' );
	}

	static function tablet_hide_meta_description() {

		return esc_html__( 'Input the entry meta tags that you want to hide on tablet devices, separated by a comma. e.g. avatar, author. Keys include: [avatar, author, date, category, tag, view, comment, update, read, like, bookmark, custom]. If you want to re-enable all metas input "-1"', 'gulir-core' );
	}

	static function mobile_hide_meta_description() {

		return esc_html__( 'Input the entry meta tags that you want to hide on mobile devices, separate by comma. e.g. avatar, author Keys include: [avatar, author, date, category, tag, view, comment, update, read, like, bookmark, custom]. If you want to re-enable all metas input "-1"', 'gulir-core' );
	}

	static function slider_mode_description() {

		return esc_html__( 'Display this block in the slider layout if it has more than one post.', 'gulir-core' );
	}

	static function carousel_info_description() {

		return esc_html__( 'The AJAX pagination will be not available if you activate the carousel mode.', 'gulir-core' );
	}

	static function carousel_mode_description() {

		return esc_html__( 'Display this block in the carousel layout.', 'gulir-core' );
	}

	static function carousel_columns_description() {

		return esc_html__( 'Input the total number of slides to show for this carousel. You can also use decimal values such as 2.3, 2.4, etc.', 'gulir-core' );
	}

	static function wide_carousel_columns_description() {

		return esc_html__( 'Input the total number of slides to display for the carousel on wide screen devices (wider than 1500px).', 'gulir-core' );
	}

	static function carousel_gap_description() {

		return esc_html__( 'Input custom spacing values between carousel items. The spacing will be the same as your input value. Set "-1" to disable the gap.', 'gulir-core' );
	}

	static function carousel_dot_description() {

		return esc_html__( 'Enable or disable the pagination dot for this carousel.', 'gulir-core' );
	}

	static function carousel_nav_description() {

		return esc_html__( 'Enable or disable the next/prev navigation dots for this carousel.', 'gulir-core' );
	}

	static function carousel_nav_spacing_description() {

		return esc_html__( 'Input custom spacing values (in pixels) for the carousel navigation bar.', 'gulir-core' );
	}

	static function carousel_autoplay_description() {

		return esc_html__( 'Enable or disable automatic sliding for this slider.', 'gulir-core' );
	}

	static function carousel_speed_description() {

		return esc_html__( 'Input a custom time (in milliseconds) for the slide transition. Leave blank to use the default setting specified in the Theme Options.', 'gulir-core' );
	}

	static function carousel_freemode_description() {

		return esc_html__( 'Enable or disable the free mode scrolling for this carousel.', 'gulir-core' );
	}

	static function carousel_centered_description() {

		return esc_html__( 'Enable centered mode for this carousel in case you set decimal sliders.', 'gulir-core' );
	}

	static function carousel_nav_color_description() {

		return esc_html__( 'Select a color for the slider navigation at the footer of this carousel.', 'gulir-core' );
	}

	static function el_spacing_description() {

		return esc_html__( 'Please input custom spacing values (in pixels) between the elements to be displayed.', 'gulir-core' );
	}

	static function featured_spacing_description() {

		return esc_html__( 'Input custom spacing values (in pixels) between the featured image and other elements.', 'gulir-core' );
	}

	static function el_margin_description() {

		return esc_html__( 'Input custom bottom margin values (in pixels) between posts in the listing.', 'gulir-core' );
	}

	static function bottom_border_description() {

		return esc_html__( 'Show borders at the bottom of the post listings. The bottom spacing will be doubled if you enable this option.', 'gulir-core' );
	}

	static function last_bottom_border_description() {

		return esc_html__( 'Disable border for the last posts in this listing.', 'gulir-core' );
	}

	static function center_mode_description() {

		return esc_html__( 'Center title and content in the post listing.', 'gulir-core' );
	}

	static function inner_width_description() {
		return esc_html__( 'Set custom maximum width (in pixels) for the overlay content.', 'gulir-core' );
	}

	static function overlay_margin_description() {
		return esc_html__( 'Set custom margin values (in pixels) for the overlay content when using the boxed background style. You can use negative values (-px) for the margins to move the box outside the featured image.', 'gulir-core' );
	}

	static function middle_mode_description() {

		return esc_html__( 'Vertically align elements in the post listing to the middle. This setting will only apply to desktop and tablet devices.', 'gulir-core' );
	}

	static function border_description() {

		return esc_html__( 'Input a custom border radius (in px) for the featured image or boxed layout. Set 0 to disable it.', 'gulir-core' );
	}

	static function list_gap_description() {

		return esc_html__( 'Input 1/2 value of the custom gap between the featured image and list post content (in px) for desktop, tablet devices. The spacing will be 2x your input value.', 'gulir-core' );
	}

	static function template_builder_info() {

		return esc_html__( 'Settings below allow you to apply the global query loop to this block and show it as a the main listing for the index blog, category, archive, single related, reading list etc...', 'gulir-core' );
	}

	static function template_builder_unique_info() {

		return esc_html__( 'Don\'t apply the WP global query mode for more than one block in a template to avoid duplicated query loop.', 'gulir-core' );
	}

	static function template_builder_available_info() {

		return esc_html__( 'The "Query Settings" will be not available in the "WP global query" mode.', 'gulir-core' );
	}

	static function template_builder_pagination_info() {

		return esc_html__( 'Use "WP Global Query Pagination" because the "Ajax Pagination" settings will be not available when you enable "WP global query" mode.', 'gulir-core' );
	}

	static function template_builder_admin_info() {

		return esc_html__( 'The "WP global query mode" layout cannot execute in this live editor. Please check the frontend to see your changes.', 'gulir-core' );
	}

	static function template_builder_posts_info() {

		return esc_html__( '"Number of posts" in the frontend will be set in the Theme Options panel (Theme Options > Category, Tags & Archive > Posts per Page). Base on the page has been assigned this template shortcode.', 'gulir-core' );
	}

	static function template_builder_total_posts_info() {

		return esc_html__( 'Tips: You can change the "Number of Posts" setting in "Query Settings" the same as the frontend (in Theme Options panel). It will help you to easy to edit but that value will not apply in the frontend.', 'gulir-core' );
	}

	static function column_border_info() {

		return esc_html__( 'The settings below require all responsive column values to be set.', 'gulir-core' );
	}

	static function template_pagination_description() {

		return esc_html__( 'Ajax pagination types may not be available in some cases (archive and taxonomy pages). depending on where you assigned this template. The theme will automatically return an appropriate setting.', 'gulir-core' );
	}

	static function query_mode_description() {

		return esc_html__( 'Choose to use the global query or use the "Query settings" panel. Please read the above notices for further information.', 'gulir-core' );
	}

	static function mobile_layout_description() {

		return esc_html__( 'Convert this layout to a grid or a list for mobile devices.', 'gulir-core' );
	}

	static function tablet_layout_description() {

		return esc_html__( 'Convert this layout to a grid or a list for tablet devices.', 'gulir-core' );
	}

	static function tablet_featured_width_description() {

		return esc_html__( 'Input custom width values (in pixels) for the featured image in the tablet list mode. Navigate to "Style > Featured Image" to set other values.', 'gulir-core' );
	}

	static function mobile_featured_width_description() {

		return esc_html__( 'Input custom width values (in pixels) for the featured image in the mobile list mode. Navigate to "Style > Featured Image" to set other values.', 'gulir-core' );
	}

	static function pagination_style_description() {

		return esc_html__( 'Select a style for the AJAX pagination.', 'gulir-core' );
	}

	static function pagination_size_description() {

		return esc_html__( 'Input custom font size values for the AJAX pagination.', 'gulir-core' );
	}

	static function pagination_color_description() {

		return esc_html__( 'Select a text label color for AJAX pagination.', 'gulir-core' );
	}

	static function pagination_accent_color_description() {

		return esc_html__( 'Select a background and border color for AJAX pagination.', 'gulir-core' );
	}

	static function pagination_dark_color_description() {

		return esc_html__( 'Select a text label color for AJAX pagination in dark mode.', 'gulir-core' );
	}

	static function pagination_dark_accent_color_description() {

		return esc_html__( 'Select a background color for AJAX pagination in dark mode.', 'gulir-core' );
	}

	static function horizontal_scroll_info() {

		return esc_html__( 'IMPORTANT: This feature is not compatible with AJAX pagination and carousel mode. Please disable it if you are using those features.', 'gulir-core' );
	}

	static function horizontal_scroll_description() {

		return esc_html__( 'Enable or disable the horizontal scrolling for this block on tablet and mobile devices.', 'gulir-core' );
	}

	static function scroll_width_tablet_description() {

		return esc_html__( 'Input a width value (in pixels) for the modules on tablet devices.', 'gulir-core' );
	}

	static function scroll_width_mobile_description() {

		return esc_html__( 'Input a width value (in pixels) for the modules on mobile devices.', 'gulir-core' );
	}

	static function extend_query_info_description() {

		return esc_html__( 'The settings below allow you to query any taxonomies and post types created by code or third-party plugins.', 'gulir-core' );
	}

	static function post_type_tax_info_description() {

		return esc_html__( 'Select a taxonomy to display as the entry category in the post listing. Please choose the correct taxonomy for your post type.', 'gulir-core' );
	}

	static function post_type_query_info_description() {

		return esc_html__( 'The Category or categories filters will not be available if you choose to query a custom post type. Please use the taxonomy settings below to set up your query.', 'gulir-core' );
	}

	static function podcast_tax_query_info_description() {

		return esc_html__( 'The Show or multiple shows filters will not be available if you choose to query a custom tax.', 'gulir-core' );
	}

	static function taxonomy_query_description() {

		return esc_html__( 'Input the taxonomy slug/name/key you created via code or a 3rd party plugin. It is the string after "...wp-admin/edit-tags.php?taxonomy=" when you are on the edit page of the taxonomy. Use {dynamic} to display posts from the currently viewed term page when creating a term template with additional featured blocks.', 'gulir-core' );
	}

	static function post_type_description() {

		return esc_html__( 'Select a custom post type. Default is POST.', 'gulir-core' );
	}

	static function term_slugs_description() {

		return esc_html__( 'Filter posts by multiple term slugs, separated by commas (e.g., termslug1, termslug2, termslug3). Please ensure the input term slugs belong to the "DEFINE TAXONOMY" above. Leave blank to disable the term slugs filter.', 'gulir-core' );
	}

	static function display_mode_info() {

		return esc_html__( 'Ajax mode is compatible with cache plugins, while direct mode can improve user experience. However, if you enable direct mode, you will need to exclude this page contain the block from the cache.', 'gulir-core' );
	}

	static function tax_name_description() {

		return esc_html__( 'The taxonomy slug/name/key is the string after "...wp-admin/edit-tags.php?taxonomy=" when you are on the edit page of the taxonomy.', 'gulir-core' );
	}

	static function tax_featured_info() {

		return esc_html__( 'To set featured images for each category, tag or taxonomy, navigate to "Posts > Categories, Tags, or Your Taxonomies > Edit > Featured Images".', 'gulir-core' );
	}

	static function display_mode_description() {

		return esc_html__( 'Select a display mode.', 'gulir-core' );
	}

	static function taxonomies_followed_description() {

		return esc_html__( 'Show followed categories, post tags or custom taxonomies based on the visitor.', 'gulir-core' );
	}

	static function tax_slug_followed_description() {

		return esc_html__( 'Input the taxonomy slugs/names/keys separated by commas (e.g., category, post_tag, genre). This setting will take precedence over the above setting; Leave it blank to use the above setting.', 'gulir-core' );
	}

	static function categories_display_mode_description() {

		return esc_html__( 'Select a display mode. This setting will apply when you enable user followed categories.', 'gulir-core' );
	}

	static function content_source_description() {

		return esc_html__( 'Select the source content for display.', 'gulir-core' );
	}

	static function source_post_type_description() {

		return esc_html__( 'Select a post type. The default is POST if "Recommended Based on User Followed" is selected, and ANY if for "User Saved" and "User Read History".', 'gulir-core' );
	}

	static function reading_history_info() {

		return esc_html__( 'To utilize the user read history query, Make sure to enable the Read History option under "Theme Options > Personalized > Read History"', 'gulir-core' );
	}

	static function count_posts_description() {

		return esc_html__( 'Toggle the display of total post count. If "Include child terms" is selected, the value is cached for 1 hour to improve performance.', 'gulir-core' );
	}
}