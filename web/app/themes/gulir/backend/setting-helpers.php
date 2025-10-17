<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_asset_image' ) ) {
	function gulir_get_asset_image( $file ) {

		return gulir_get_file_uri( 'backend/assets/' . $file );
	}
}

if ( ! function_exists( 'gulir_config_sidebar_name' ) ) {
	function gulir_config_sidebar_name( $default = true ) {

		$sidebar_data = [];
		$settings     = gulir_get_option();

		if ( $default ) {
			$sidebar_data['default'] = esc_html__( '- Default -', 'gulir' );
		}
		$sidebar_data['gulir_sidebar_default'] = esc_html__( 'Standard Sidebar', 'gulir' );
		if ( ! empty( $settings['multi_sidebars'] ) && is_array( $settings['multi_sidebars'] ) ) {
			foreach ( $settings['multi_sidebars'] as $sidebar ) {
				$id                  = 'gulir_ms_' . gulir_convert_to_id( trim( $sidebar ) );
				$sidebar_data[ $id ] = $sidebar;
			}
		}

		return $sidebar_data;
	}
}

if ( ! function_exists( 'gulir_config_header_style' ) ) {
	function gulir_config_header_style( $default = false, $transparent = false, $template = false, $no_header = false ) {

		$settings = [
			'0' => esc_html__( '- Default -', 'gulir' ),
			'1' => esc_html__( 'Layout 1 (Left Menu)', 'gulir' ),
			'2' => esc_html__( 'Layout 2 (Right Menu)', 'gulir' ),
			'3' => esc_html__( 'Layout 3 (Center Menu)', 'gulir' ),
			'4' => esc_html__( 'Layout 4 (Border)', 'gulir' ),
			'5' => esc_html__( 'Layout 5 (Center Logo)', 'gulir' ),
		];

		if ( $transparent ) {
			$settings['t1'] = esc_html__( 'Transparent - Layout 1', 'gulir' );
			$settings['t2'] = esc_html__( 'Transparent - Layout 2', 'gulir' );
			$settings['t3'] = esc_html__( 'Transparent - Layout 3', 'gulir' );
		}

		if ( $no_header ) {
			$settings['none']        = esc_html__( 'No Header on Desktop, Mobile Header Only', 'gulir' );
			$settings['none_mobile'] = esc_html__( 'No Header on Any Device', 'gulir' );
		}

		if ( $template ) {
			$settings['rb_template'] = esc_html__( 'Use Ruby Template', 'gulir' );
		}

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_heading_layout' ) ) {
	function gulir_config_heading_layout( $default = false ) {

		$settings = [
			'0'   => esc_html__( '- Default -', 'gulir' ),
			'1'   => esc_html__( '01 - Two Slashes', 'gulir' ),
			'2'   => esc_html__( '02 - Left Dot', 'gulir' ),
			'3'   => esc_html__( '03 - Bold Underline', 'gulir' ),
			'4'   => esc_html__( '04 - Multiple Underline', 'gulir' ),
			'5'   => esc_html__( '05 - Top Line', 'gulir' ),
			'6'   => esc_html__( '06 - Parallelogram Background', 'gulir' ),
			'7'   => esc_html__( '07 - Left Border', 'gulir' ),
			'8'   => esc_html__( '08 - Half Elegant Background', 'gulir' ),
			'9'   => esc_html__( '09 - Small Corners', 'gulir' ),
			'10'  => esc_html__( '10 - Only Text', 'gulir' ),
			'11'  => esc_html__( '11 - Big Tagline Overlay', 'gulir' ),
			'12'  => esc_html__( '12 - Mixed Underline', 'gulir' ),
			'13'  => esc_html__( '13 - Rectangle Background', 'gulir' ),
			'14'  => esc_html__( '14 - Top Solid', 'gulir' ),
			'15'  => esc_html__( '15 - Top & Bottom Solid', 'gulir' ),
			'16'  => esc_html__( '16 - Mixed Background', 'gulir' ),
			'17'  => esc_html__( '17 - Centered Solid', 'gulir' ),
			'18'  => esc_html__( '18 - Centered Dotted', 'gulir' ),
			'19'  => esc_html__( '19 - Line Break for Tagline', 'gulir' ),
			'20'  => esc_html__( '20 - Mixed Box Light Border', 'gulir' ),
			'21'  => esc_html__( '21 - Mixed Box Solid Border', 'gulir' ),
			'22'  => esc_html__( '22 - Mixed Box Shadow Border', 'gulir' ),
			'23'  => esc_html__( '23 - Right Slashes', 'gulir' ),
			'c1'  => esc_html__( 'Center 01 - Two Slashes', 'gulir' ),
			'c2'  => esc_html__( 'Center 02 - Two Dots', 'gulir' ),
			'c3'  => esc_html__( 'Center 03 - Underline', 'gulir' ),
			'c4'  => esc_html__( 'Center 04 - Bold Underline', 'gulir' ),
			'c5'  => esc_html__( 'Center 05 - Top Line', 'gulir' ),
			'c6'  => esc_html__( 'Center 06 - Parallelogram Background', 'gulir' ),
			'c7'  => esc_html__( 'Center 07 - Two Square Dots', 'gulir' ),
			'c8'  => esc_html__( 'Center 08 - Elegant Lines', 'gulir' ),
			'c9'  => esc_html__( 'Center 09 - Small Corners', 'gulir' ),
			'c10' => esc_html__( 'Center 10 - Only Text', 'gulir' ),
			'c11' => esc_html__( 'Center 11 - Big Tagline Overlay', 'gulir' ),
			'c12' => esc_html__( 'Center 12 - Mixed Underline', 'gulir' ),
			'c13' => esc_html__( 'Center 13 - Rectangle Background', 'gulir' ),
			'c14' => esc_html__( 'Center 14 - Top Solid', 'gulir' ),
			'c15' => esc_html__( 'Center 15 - Top & Bottom Solid', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_sidebar_position' ) ) {
	function gulir_config_sidebar_position( $default = true, $none = true ) {

		if ( ! is_admin() ) {
			return false;
		}

		$sidebars = [];
		if ( true === $default ) {
			$sidebars['default'] = [
				'alt'   => '- Default -',
				'img'   => gulir_get_asset_image( 'sidebar-default.png' ),
				'title' => esc_html__( 'Default', 'gulir' ),
			];
		};
		if ( true === $none ) {
			$sidebars['none'] = [
				'alt'   => 'none',
				'img'   => gulir_get_asset_image( 'sidebar-none.png' ),
				'title' => esc_html__( 'No Sidebar', 'gulir' ),
			];
		};

		$sidebars['left'] = [
			'alt'   => 'left sidebar',
			'img'   => gulir_get_asset_image( 'sidebar-left.png' ),
			'title' => esc_html__( 'Left', 'gulir' ),
		];

		$sidebars['right'] = [
			'alt'   => 'right sidebar',
			'img'   => gulir_get_asset_image( 'sidebar-right.png' ),
			'title' => esc_html__( 'Right', 'gulir' ),
		];

		return $sidebars;
	}
}

if ( ! function_exists( 'gulir_config_sticky_dropdown' ) ) {
	function gulir_config_sticky_dropdown() {

		return [
			'0'  => esc_html__( '- Default -', 'gulir' ),
			'1'  => esc_html__( 'Sticky Sidebar', 'gulir' ),
			'2'  => esc_html__( 'Sticky Last Widget', 'gulir' ),
			'-1' => esc_html__( 'Disable', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_switch_dropdown' ) ) {
	function gulir_config_switch_dropdown() {

		return [
			'0'  => esc_html__( '- Default -', 'gulir' ),
			'1'  => esc_html__( 'Enable', 'gulir' ),
			'-1' => esc_html__( 'Disable', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_excerpt_dropdown' ) ) {
	function gulir_config_excerpt_dropdown() {

		return [
			'0' => esc_html__( '- Default -', 'gulir' ),
			'1' => esc_html__( 'Custom Settings Below', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_excerpt_source' ) ) {
	function gulir_config_excerpt_source() {

		return [
			'0'       => esc_html__( 'Use Post Excerpt', 'gulir' ),
			'tagline' => esc_html__( 'Use Title Tagline', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_heading_tag' ) ) {
	function gulir_config_heading_tag() {

		return [
			'0'    => esc_html__( '- Default -', 'gulir' ),
			'h1'   => esc_html__( 'H1', 'gulir' ),
			'h2'   => esc_html__( 'H2', 'gulir' ),
			'h3'   => esc_html__( 'H3', 'gulir' ),
			'h4'   => esc_html__( 'H4', 'gulir' ),
			'h5'   => esc_html__( 'H5', 'gulir' ),
			'h6'   => esc_html__( 'H6', 'gulir' ),
			'p'    => esc_html__( 'p', 'gulir' ),
			'span' => esc_html__( 'span', 'gulir' ),
			'div'  => esc_html__( 'div', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_hide_dropdown' ) ) {
	function gulir_config_hide_dropdown() {

		return [
			'0'      => esc_html__( '- Disable -', 'gulir' ),
			'mobile' => esc_html__( 'On Mobile', 'gulir' ),
			'tablet' => esc_html__( 'On Tablet', 'gulir' ),
			'all'    => esc_html__( 'On Tablet & Mobile', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_archive_hide_dropdown' ) ) {
	function gulir_config_archive_hide_dropdown() {

		return [
			'0'      => esc_html__( '- Default -', 'gulir' ),
			'mobile' => esc_html__( 'On Mobile', 'gulir' ),
			'tablet' => esc_html__( 'On Tablet', 'gulir' ),
			'all'    => esc_html__( 'On Tablet & Mobile', 'gulir' ),
			'-1'     => esc_html__( 'Disable', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_menu_slug' ) ) {
	function gulir_config_menu_slug() {

		$settings = [];
		$menus    = wp_get_nav_menus();
		if ( ! empty ( $menus ) ) {
			foreach ( $menus as $item ) {
				$settings[ $item->slug ] = $item->name;
			}
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_standard_entry_category' ) ) {
	function gulir_config_standard_entry_category( $default = false ) {

		$settings = [
			'0'        => esc_html__( '- Default -', 'gulir' ),
			'bg-1'     => esc_html__( 'Background 1', 'gulir' ),
			'bg-1,big' => esc_html__( 'Background 1 (Big)', 'gulir' ),
			'bg-2'     => esc_html__( 'Background 2', 'gulir' ),
			'bg-2,big' => esc_html__( 'Background 2 (Big)', 'gulir' ),
			'bg-3'     => esc_html__( 'Background 3', 'gulir' ),
			'bg-3,big' => esc_html__( 'Background 3 (Big)', 'gulir' ),
			'bg-4'     => esc_html__( 'Background 4', 'gulir' ),
			'bg-4,big' => esc_html__( 'Background 4 (Big)', 'gulir' ),
			'-1'       => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings[0] );
			unset( $settings['-1'] );
			$settings['0'] = esc_html__( 'Disable', 'gulir' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_extended_entry_category' ) ) {
	function gulir_config_extended_entry_category( $default = false ) {

		$settings = [
			'0'              => esc_html__( '- Default -', 'gulir' ),
			'bg-1'           => esc_html__( 'Background 1', 'gulir' ),
			'bg-1,big'       => esc_html__( 'Background 1 (Big)', 'gulir' ),
			'bg-2'           => esc_html__( 'Background 2', 'gulir' ),
			'bg-2,big'       => esc_html__( 'Background 2 (Big)', 'gulir' ),
			'bg-3'           => esc_html__( 'Background 3', 'gulir' ),
			'bg-3,big'       => esc_html__( 'Background 3 (Big)', 'gulir' ),
			'bg-4'           => esc_html__( 'Background 4', 'gulir' ),
			'bg-4,big'       => esc_html__( 'Background 4 (Big)', 'gulir' ),
			'text'           => esc_html__( 'Only Text', 'gulir' ),
			'text,big'       => esc_html__( 'Only Text (Big)', 'gulir' ),
			'border'         => esc_html__( 'Border', 'gulir' ),
			'border,big'     => esc_html__( 'Border (Big)', 'gulir' ),
			'b-border'       => esc_html__( 'Bottom Line', 'gulir' ),
			'b-border,big'   => esc_html__( 'Bottom Line (Big)', 'gulir' ),
			'b-dotted'       => esc_html__( 'Bottom Dotted', 'gulir' ),
			'b-dotted,big'   => esc_html__( 'Bottom Dotted (Big)', 'gulir' ),
			'b-border-2'     => esc_html__( 'Bottom Border', 'gulir' ),
			'b-border-2,big' => esc_html__( 'Bottom Border (Big)', 'gulir' ),
			'l-dot'          => esc_html__( 'Left Dot', 'gulir' ),
			'-1'             => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings[0] );
			unset( $settings['-1'] );
			$settings['0'] = esc_html__( 'Disable', 'gulir' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_entry_meta_bar' ) ) {
	function gulir_config_entry_meta_bar() {

		return [
			'0'      => esc_html__( '- Default -', 'gulir' ),
			'-1'     => esc_html__( 'Disable', 'gulir' ),
			'custom' => esc_html__( 'Use Custom', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_entry_format' ) ) {
	function gulir_config_entry_format( $default = false ) {

		$settings = [
			'0'              => esc_html__( '- Default -', 'gulir' ),
			'bottom'         => esc_html__( 'Bottom Right', 'gulir' ),
			'bottom,big'     => esc_html__( 'Bottom Right (Big Icon)', 'gulir' ),
			'top'            => esc_html__( 'Top', 'gulir' ),
			'top,big'        => esc_html__( 'Top (Big Icon)', 'gulir' ),
			'after-category' => esc_html__( 'After Entry Category', 'gulir' ),
			'center'         => esc_html__( 'Center', 'gulir' ),
			'center,big'     => esc_html__( 'Center (Big Icon)', 'gulir' ),
			'-1'             => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
			unset( $settings['-1'] );
			$settings['0'] = esc_html__( 'Disable', 'gulir' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_entry_meta_tags' ) ) {
	function gulir_config_entry_meta_tags() {

		return [
			'avatar'    => esc_html__( 'avatar (Avatar)', 'gulir' ),
			'author'    => esc_html__( 'author (Author)', 'gulir' ),
			'date'      => esc_html__( 'date (Publish Date)', 'gulir' ),
			'category'  => esc_html__( 'category (Categories)', 'gulir' ),
			'tag'       => esc_html__( 'tag (Tags)', 'gulir' ),
			'view'      => esc_html__( 'view (Post Views)', 'gulir' ),
			'comment'   => esc_html__( 'comment (Comments)', 'gulir' ),
			'update'    => esc_html__( 'update  (Last Updated)', 'gulir' ),
			'read'      => esc_html__( 'read (Reading Time)', 'gulir' ),
			'bookmark'  => esc_html__( 'bookmark (Bookmark)', 'gulir' ),
			'like'      => esc_html__( 'like (Like/Dislike)', 'gulir' ),
			'custom'    => esc_html__( 'custom (Custom)', 'gulir' ),
			'_disabled' => esc_html__( 'Disabled', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_entry_review' ) ) {
	function gulir_config_entry_review( $default = false ) {

		$settings = [
			'0'       => esc_html__( '- Default -', 'gulir' ),
			'1'       => esc_html__( 'Enable', 'gulir' ),
			'replace' => esc_html__( 'Replace for Entry Meta', 'gulir' ),
			'-1'      => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
			unset( $settings['-1'] );
			$settings['0'] = esc_html__( 'Disable', 'gulir' );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_blog_layout' ) ) {
	function gulir_config_blog_layout() {

		return [
			'classic_1'    => [
				'img'   => gulir_get_asset_image( 'classic-1.jpg' ),
				'title' => esc_html__( 'Classic', 'gulir' ),
			],
			'grid_1'       => [
				'img'   => gulir_get_asset_image( 'grid-1.jpg' ),
				'title' => esc_html__( 'Grid 1', 'gulir' ),
			],
			'grid_2'       => [
				'img'   => gulir_get_asset_image( 'grid-1.jpg' ),
				'title' => esc_html__( 'Grid 2', 'gulir' ),
			],
			'grid_box_1'   => [
				'img'   => gulir_get_asset_image( 'grid-box-1.jpg' ),
				'title' => esc_html__( 'Boxed Grid 1', 'gulir' ),
			],
			'grid_box_2'   => [
				'img'   => gulir_get_asset_image( 'grid-box-2.jpg' ),
				'title' => esc_html__( 'Boxed Grid 2', 'gulir' ),
			],
			'grid_small_1' => [
				'img'   => gulir_get_asset_image( 'grid-small-1.jpg' ),
				'title' => esc_html__( 'Small Grid', 'gulir' ),
			],
			'list_1'       => [
				'img'   => gulir_get_asset_image( 'list-1.jpg' ),
				'title' => esc_html__( 'List 1', 'gulir' ),
			],
			'list_2'       => [
				'img'   => gulir_get_asset_image( 'list-2.jpg' ),
				'title' => esc_html__( 'List 2', 'gulir' ),
			],
			'list_box_1'   => [
				'img'   => gulir_get_asset_image( 'list-box-1.jpg' ),
				'title' => esc_html__( 'Boxed List 1', 'gulir' ),
			],
			'list_box_2'   => [
				'img'   => gulir_get_asset_image( 'list-box-2.jpg' ),
				'title' => esc_html__( 'Boxed List 2', 'gulir' ),
			],
		];
	}
}

if ( ! function_exists( 'gulir_config_blog_columns' ) ) {
	function gulir_config_blog_columns( $configs = [] ) {

		$settings = [];
		$default  = [
			'0' => esc_html__( '- Default -', 'gulir' ),
			'1' => esc_html__( '1 Column', 'gulir' ),
			'2' => esc_html__( '2 Columns', 'gulir' ),
			'3' => esc_html__( '3 Columns', 'gulir' ),
			'4' => esc_html__( '4 Columns', 'gulir' ),
			'5' => esc_html__( '5 Columns', 'gulir' ),
			'6' => esc_html__( '6 Columns', 'gulir' ),
			'7' => esc_html__( '7 Columns', 'gulir' ),
		];

		if ( ! is_array( $configs ) || ! count( $configs ) ) {
			return $default;
		}
		foreach ( $configs as $item ) {
			$settings[ $item ] = $default[ $item ];
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_blog_column_gap' ) ) {
	function gulir_config_blog_column_gap() {

		return [
			'0'    => esc_html__( '- Default -', 'gulir' ),
			'none' => esc_html__( 'No Gap', 'gulir' ),
			'5'    => esc_html__( '10px', 'gulir' ),
			'7'    => esc_html__( '14px', 'gulir' ),
			'10'   => esc_html__( '20px', 'gulir' ),
			'15'   => esc_html__( '30px', 'gulir' ),
			'20'   => esc_html__( '40px', 'gulir' ),
			'25'   => esc_html__( '50px', 'gulir' ),
			'30'   => esc_html__( '60px', 'gulir' ),
			'35'   => esc_html__( '70px', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_category_sidebar_position' ) ) {
	function gulir_config_category_sidebar_position() {

		return [
			'0'     => esc_html__( '- Default -', 'gulir' ),
			'none'  => esc_html__( 'No Sidebar', 'gulir' ),
			'left'  => esc_html__( 'Left', 'gulir' ),
			'right' => esc_html__( 'Right', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_blog_pagination' ) ) {
	function gulir_config_blog_pagination( $default = false ) {

		$settings = [
			'0'               => esc_html__( '- Default -', 'gulir' ),
			'number'          => esc_html__( 'Numeric', 'gulir' ),
			'simple'          => esc_html__( 'Simple', 'gulir' ),
			'load_more'       => esc_html__( 'Load More (Ajax)', 'gulir' ),
			'infinite_scroll' => esc_html__( 'Infinite Scroll (Ajax)', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_category_header' ) ) {
	function gulir_config_category_header( $default = false ) {

		$settings = [
			'0'    => esc_html__( '- Default -', 'gulir' ),
			'1'    => esc_html__( 'Layout 1 (Right Featured Image)', 'gulir' ),
			'2'    => esc_html__( 'Layout 2 (Background Image)', 'gulir' ),
			'3'    => esc_html__( 'Layout 3 (Minimalist)', 'gulir' ),
			'4'    => esc_html__( 'Layout 4 (Minimalist Center)', 'gulir' ),
			'none' => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_archive_header' ) ) {
	function gulir_config_archive_header( $default = false ) {

		$settings = [
			'0'    => esc_html__( '- Default -', 'gulir' ),
			'1'    => esc_html__( 'Left', 'gulir' ),
			'2'    => esc_html__( 'Center', 'gulir' ),
			'none' => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_archive_header_bg' ) ) {
	function gulir_config_archive_header_bg( $default = false ) {

		$settings = [
			'0'         => esc_html__( '- Default -', 'gulir' ),
			'dot'       => esc_html__( 'Pattern Dotted', 'gulir' ),
			'dot2'      => esc_html__( 'Pattern Dotted 2', 'gulir' ),
			'diagonal'  => esc_html__( 'Pattern Diagonal', 'gulir' ),
			'diagonal2' => esc_html__( 'Pattern Diagonal 2', 'gulir' ),
			'-1'        => esc_html__( 'Solid Light Gray', 'gulir' ),
		];
		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_single_standard_layouts' ) ) {
	function gulir_config_single_standard_layouts( $default = true ) {

		$settings = [
			'default'     => [
				'img'   => gulir_get_asset_image( 'default.png' ),
				'title' => esc_html__( '- Default -', 'gulir' ),
			],
			'standard_1'  => [
				'img'   => gulir_get_asset_image( 'single-1.png' ),
				'title' => esc_html__( 'Layout 1', 'gulir' ),
			],
			'standard_1a' => [
				'img'   => gulir_get_asset_image( 'single-1a.png' ),
				'title' => esc_html__( 'Layout 1(a)', 'gulir' ),
			],
			'standard_2'  => [
				'img'   => gulir_get_asset_image( 'single-2.png' ),
				'title' => esc_html__( 'Layout 2', 'gulir' ),
			],
			'standard_3'  => [
				'img'   => gulir_get_asset_image( 'single-3.png' ),
				'title' => esc_html__( 'Layout 3', 'gulir' ),
			],
			'standard_4'  => [
				'img'   => gulir_get_asset_image( 'single-4.png' ),
				'title' => esc_html__( 'Layout 4', 'gulir' ),
			],
			'standard_5'  => [
				'img'   => gulir_get_asset_image( 'single-5.png' ),
				'title' => esc_html__( 'Layout 5', 'gulir' ),
			],
			'standard_6'  => [
				'img'   => gulir_get_asset_image( 'single-6.png' ),
				'title' => esc_html__( 'Layout 6', 'gulir' ),
			],
			'standard_7'  => [
				'img'   => gulir_get_asset_image( 'single-7.png' ),
				'title' => esc_html__( 'Layout 7', 'gulir' ),
			],
			'standard_8'  => [
				'img'   => gulir_get_asset_image( 'single-8.png' ),
				'title' => esc_html__( 'Layout 8', 'gulir' ),
			],
			'standard_9'  => [
				'img'   => gulir_get_asset_image( 'single-9.png' ),
				'title' => esc_html__( 'Layout 9 (No Featured)', 'gulir' ),
			],
			'standard_10' => [
				'img'   => gulir_get_asset_image( 'single-10.png' ),
				'title' => esc_html__( 'Layout 10', 'gulir' ),
			],
			'standard_11' => [
				'img'   => gulir_get_asset_image( 'single-11.png' ),
				'title' => esc_html__( 'Layout 11', 'gulir' ),
			],
		];

		if ( ! $default ) {
			unset( $settings['default'] );
		}

		return $settings;
	}
}


/**
 * Get the available single post layout configurations for taxonomy pages.
 *
 * This function returns an associative array of predefined single post layouts
 * that can be selected for taxonomy (category, tag, etc.) pages.
 *
 * @return array Associative array of layout options with keys as layout identifiers
 *               and values as translated layout names.
 */
if ( ! function_exists( 'gulir_config_tax_single_layouts' ) ) {
	function gulir_config_tax_single_layouts() {

		return [
			'0'           => esc_html__( '- Default -', 'gulir' ),
			'standard_1'  => esc_html__( 'Layout 1', 'gulir' ),
			'standard_1a' => esc_html__( 'Layout 1(a)', 'gulir' ),
			'standard_2'  => esc_html__( 'Layout 2', 'gulir' ),
			'standard_3'  => esc_html__( 'Layout 3', 'gulir' ),
			'standard_4'  => esc_html__( 'Layout 4', 'gulir' ),
			'standard_5'  => esc_html__( 'Layout 5', 'gulir' ),
			'standard_6'  => esc_html__( 'Layout 6', 'gulir' ),
			'standard_7'  => esc_html__( 'Layout 7', 'gulir' ),
			'standard_8'  => esc_html__( 'Layout 8', 'gulir' ),
			'standard_9'  => esc_html__( 'Layout 9 (No Featured)', 'gulir' ),
			'standard_10' => esc_html__( 'Layout 10', 'gulir' ),
			'standard_11' => esc_html__( 'Layout 11', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_single_video_layouts' ) ) {
	function gulir_config_single_video_layouts( $default = true ) {

		$settings = [
			'default'  => [
				'img'   => gulir_get_asset_image( 'default.png' ),
				'title' => esc_html__( '- Default -', 'gulir' ),
			],
			'video_1'  => [
				'img'   => gulir_get_asset_image( 'single-video-1.png' ),
				'title' => esc_html__( 'Layout 1', 'gulir' ),
			],
			'video_1a' => [
				'img'   => gulir_get_asset_image( 'single-1a.png' ),
				'title' => esc_html__( 'Layout 1(a)', 'gulir' ),
			],
			'video_2'  => [
				'img'   => gulir_get_asset_image( 'single-video-2.png' ),
				'title' => esc_html__( 'Layout 2', 'gulir' ),
			],
			'video_3'  => [
				'img'   => gulir_get_asset_image( 'single-video-3.png' ),
				'title' => esc_html__( 'Layout 3', 'gulir' ),
			],
			'video_4'  => [
				'img'   => gulir_get_asset_image( 'single-video-4.png' ),
				'title' => esc_html__( 'Layout 4', 'gulir' ),
			],
		];

		if ( ! $default ) {
			unset( $settings['default'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_single_audio_layouts' ) ) {
	function gulir_config_single_audio_layouts( $default = true ) {

		$settings = [
			'default'  => [
				'img'   => gulir_get_asset_image( 'default.png' ),
				'title' => esc_html__( '- Default -', 'gulir' ),
			],
			'audio_1'  => [
				'img'   => gulir_get_asset_image( 'single-audio-1.png' ),
				'title' => esc_html__( 'Layout 1', 'gulir' ),
			],
			'audio_1a' => [
				'img'   => gulir_get_asset_image( 'single-audio-1a.png' ),
				'title' => esc_html__( 'Layout 1(a)', 'gulir' ),
			],
			'audio_2'  => [
				'img'   => gulir_get_asset_image( 'single-audio-2.png' ),
				'title' => esc_html__( 'Layout 2', 'gulir' ),
			],
			'audio_3'  => [
				'img'   => gulir_get_asset_image( 'single-audio-3.png' ),
				'title' => esc_html__( 'Layout 3', 'gulir' ),
			],
			'audio_4'  => [
				'img'   => gulir_get_asset_image( 'single-audio-4.png' ),
				'title' => esc_html__( 'Layout 4', 'gulir' ),
			],
		];

		if ( ! $default ) {
			unset( $settings['default'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_single_gallery_layouts' ) ) {
	function gulir_config_single_gallery_layouts( $default = true ) {

		$settings = [
			'default'   => [
				'img'   => gulir_get_asset_image( 'default.png' ),
				'title' => esc_html__( '- Default -', 'gulir' ),
			],
			'gallery_1' => [
				'img'   => gulir_get_asset_image( 'single-gallery-1.png' ),
				'title' => esc_html__( 'Layout 1', 'gulir' ),
			],
			'gallery_2' => [
				'img'   => gulir_get_asset_image( 'single-gallery-2.png' ),
				'title' => esc_html__( 'Layout 2', 'gulir' ),
			],
			'gallery_3' => [
				'img'   => gulir_get_asset_image( 'single-gallery-3.png' ),
				'title' => esc_html__( 'Layout 3', 'gulir' ),
			],
		];
		if ( ! $default ) {
			unset( $settings['default'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_crop_size' ) ) {
	function gulir_config_crop_size() {

		$sizes    = gulir_calc_crop_sizes();
		$settings = [ '0' => esc_html__( '- Default -', 'gulir' ) ];

		foreach ( $sizes as $size => $data ) {
			if ( isset( $data[0] ) && isset( $data[1] ) ) {
				$settings[ $size ] = $data[0] . 'x' . $data[1];
			}
		}

		$settings['thumbnail']    = esc_html__( 'Thumbnail (Core WP)', 'gulir' );
		$settings['medium']       = esc_html__( 'Medium (Core WP)', 'gulir' );
		$settings['medium_large'] = esc_html__( 'Medium Large (Core WP)', 'gulir' );
		$settings['large']        = esc_html__( 'Large (Core WP)', 'gulir' );
		$settings['1536x1536']    = esc_html__( '1536x1536 (Core WP)', 'gulir' );
		$settings['2048x2048']    = esc_html__( '2048x2048 (Core WP)', 'gulir' );

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_featured_position' ) ) {
	function gulir_config_featured_position( $default = false ) {

		$settings = [
			'0'     => esc_html__( '- Default -', 'gulir' ),
			'left'  => esc_html__( 'Left', 'gulir' ),
			'right' => esc_html__( 'Right', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings['0'] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_ad_size_dropdown' ) ) {
	function gulir_ad_size_dropdown() {

		return [
			'1'  => esc_html__( 'Leaderboard (728x90)', 'gulir' ),
			'2'  => esc_html__( 'Banner (468x60)', 'gulir' ),
			'3'  => esc_html__( 'Half banner (234x60)', 'gulir' ),
			'4'  => esc_html__( 'Button (125x125)', 'gulir' ),
			'5'  => esc_html__( 'Skyscraper (120x600)', 'gulir' ),
			'6'  => esc_html__( 'Wide Skyscraper (160x600)', 'gulir' ),
			'7'  => esc_html__( 'Small Rectangle (180x150)', 'gulir' ),
			'8'  => esc_html__( 'Vertical Banner (120 x 240)', 'gulir' ),
			'9'  => esc_html__( 'Small Square (200x200)', 'gulir' ),
			'10' => esc_html__( 'Square (250x250)', 'gulir' ),
			'11' => esc_html__( 'Medium Rectangle (300x250)', 'gulir' ),
			'12' => esc_html__( 'Large Rectangle (336x280)', 'gulir' ),
			'13' => esc_html__( 'Half Page (300x600)', 'gulir' ),
			'14' => esc_html__( 'Portrait (300x1050)', 'gulir' ),
			'15' => esc_html__( 'Mobile Banner (320x50)', 'gulir' ),
			'16' => esc_html__( 'Large Leaderboard (970x90)', 'gulir' ),
			'17' => esc_html__( 'Billboard (970x250)', 'gulir' ),
			'18' => esc_html__( 'Mobile Banner (320x100)', 'gulir' ),
			'19' => esc_html__( 'Mobile Friendly (300x100)', 'gulir' ),
			'-1' => esc_html__( 'Hide on Desktop', 'gulir' ),
		];
	}
}

if ( ! function_exists( 'gulir_config_box_style' ) ) {
	function gulir_config_box_style( $default = false ) {

		$settings = [
			'0'      => esc_html__( '- None -', 'gulir' ),
			'bg'     => esc_html__( 'Background', 'gulir' ),
			'border' => esc_html__( 'Border', 'gulir' ),
			'shadow' => esc_html__( 'Shadow', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_review_desc_dropdown' ) ) {
	function gulir_config_review_desc_dropdown( $default = true ) {

		$settings = [
			'0'  => esc_html__( '- Default -', 'gulir' ),
			'1'  => esc_html__( 'No Wrap', 'gulir' ),
			'2'  => esc_html__( 'Desktop No Wrap - Mobile Line Wrap', 'gulir' ),
			'3'  => esc_html__( 'Line Wrap', 'gulir' ),
			'4'  => esc_html__( 'No Wrap (Show Score Only)', 'gulir' ),
			'5'  => esc_html__( 'Line Wrap (Show Score Only)', 'gulir' ),
			'-1' => esc_html__( 'Disable', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_config_page_header_dropdown' ) ) {
	function gulir_config_page_header_dropdown( $default = true ) {

		$settings = [
			'0'  => esc_html__( '- Default -', 'gulir' ),
			'1'  => esc_html__( 'Left Heading', 'gulir' ),
			'2'  => esc_html__( 'Overlay Heading (Featured image required)', 'gulir' ),
			'3'  => esc_html__( 'Overlay Center Heading (Featured image required)', 'gulir' ),
			'4'  => esc_html__( 'Wrapper Overlay Heading (Require featured image)', 'gulir' ),
			'-1' => esc_html__( 'No Header', 'gulir' ),
		];

		if ( ! $default ) {
			unset( $settings[0] );
		}

		return $settings;
	}
}

if ( ! function_exists( 'gulir_get_post_types_list' ) ) {
	function gulir_get_post_types_list() {

		$args       = [ 'public' => true ];
		$post_types = get_post_types( $args, 'objects' );

		unset(
			$post_types['post'],
			$post_types['page'],
			$post_types['attachment'],
			$post_types['podcast'],
			$post_types['rb-etemplate'],
			$post_types['product'],
			$post_types['forum'],
			$post_types['topic'],
			$post_types['reply'],
			$post_types['e-landing-page'],
			$post_types['e-floating-buttons'],
			$post_types['elementor_library'],
			$post_types['index_dir_ltg']
		);

		foreach ( $post_types as $post_type => $data ) {
			if ( strpos( $post_type, 'acf-' ) === 0 ) {
				unset( $post_types[ $post_type ] );
			}
		}

		return apply_filters( 'ruby_settings_post_types_list', $post_types );
	}
}