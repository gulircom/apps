<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_page' ) ) {
	function gulir_register_options_page() {

		$prefix = 'page_';

		return [
			'id'     => 'gulir_config_section_page',
			'title'  => esc_html__( 'Single Page', 'gulir' ),
			'icon'   => 'el el-list-alt',
			'desc'   => esc_html__( 'Customize the layout and style of the single page.', 'gulir' ),
			'fields' => [
				[
					'id'     => 'section_start_page_header',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'General', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => $prefix . 'page_header_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Page Header Layout', 'gulir' ),
					'subtitle' => esc_html__( 'Select a header layout for the single page.', 'gulir' ),
					'options'  => gulir_config_page_header_dropdown( false ),
					'default'  => '1',
				],
				[
					'id'          => $prefix . 'breadcrumb_pos',
					'type'        => 'select',
					'title'       => esc_html__( 'Breadcrumb Position', 'gulir' ),
					'subtitle'    => esc_html__( 'Choose the position for all page breadcrumb if enabled.', 'gulir' ),
					'description' => esc_html__( 'This setting applies globally and will be used for page headers with the title aligned to the left.', 'gulir' ),
					'options'     => [
						'0'     => esc_html__( 'Left', 'gulir' ),
						'right' => esc_html__( 'Right', 'gulir' ),
					],
					'default'     => '0',
				],
				[
					'id'          => 'page_content_width',
					'title'       => esc_html__( 'Default Max Width (Optimize Line Length)', 'gulir' ),
					'subtitle'    => esc_html__( 'Enter the maximum width (in px) for the single page.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply if you choose "Optimize Line Length". Leave blank to use the default (840).', 'gulir' ),
					'placeholder' => '840',
					'type'        => 'text',
					'class'       => 'small',
				],
				[
					'id'       => $prefix . 'header_width',
					'type'     => 'select',
					'title'    => esc_html__( 'Limit Page Header Width', 'gulir' ),
					'subtitle' => esc_html__( 'Limit the max-width for the page header content, which includes the page title and featured image.', 'gulir' ),
					'options'  => [
						'small' => esc_html__( 'Optimize Line Length', 'gulir' ),
						'0'     => esc_html__( 'Full Width', 'gulir' ),
					],
					'default'  => '0',
				],
				[
					'id'          => $prefix . 'width_wo_sb',
					'type'        => 'select',
					'title'       => esc_html__( 'Limit Page Content Width', 'gulir' ),
					'subtitle'    => esc_html__( 'Enhance readability by optimizing the line length through the limitation of the content width in the page.', 'gulir' ),
					'description' => esc_html__( 'This setting will only apply to pages without a sidebar.', 'gulir' ),
					'options'     => [
						'small' => esc_html__( 'Optimize Line Length', 'gulir' ),
						'0'     => esc_html__( 'Full Width', 'gulir' ),
					],
					'default'     => 'small',
				],
				[
					'id'     => 'section_end_page_header',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_page_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Sidebar Area', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => $prefix . 'sidebar_position',
					'type'     => 'image_select',
					'title'    => esc_html__( 'Sidebar Position', 'gulir' ),
					'subtitle' => esc_html__( 'Select a sidebar position or disable it for the single page.', 'gulir' ),
					'options'  => gulir_config_sidebar_position(),
					'default'  => 'none',
				],
				[
					'id'       => $prefix . 'sidebar_name',
					'type'     => 'select',
					'title'    => esc_html__( 'Assign a Sidebar', 'gulir' ),
					'subtitle' => esc_html__( 'Assign a widget section for the sidebar for the single page if it is enabled.', 'gulir' ),
					'options'  => gulir_config_sidebar_name( false ),
					'default'  => 'gulir_sidebar_default',
				],
				[
					'id'       => $prefix . 'sticky_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Sticky Sidebar', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable sticky sidebar feature for the single page.', 'gulir' ),
					'options'  => gulir_config_sticky_dropdown(),
					'default'  => '0',
				],
				[
					'id'     => 'section_end_page_sidebar',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}