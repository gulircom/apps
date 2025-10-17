<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_breadcrumb' ) ) {
	function gulir_register_options_breadcrumb() {

		return [
			'title'  => esc_html__( 'Breadcrumb Bar', 'gulir' ),
			'id'     => 'gulir_config_section_breadcrumb',
			'desc'   => esc_html__( 'The theme supports Navxt plugin Yoast SEO and Rank Math SEO breadcrumbs.', 'gulir' ),
			'icon'   => 'el el-random',
			'fields' => [
				[
					'id'    => 'info_breadcrumb',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'The settings below request the Navxt plugin, Yoast SEO or Rank Math SEO breadcrumbs to run.', 'gulir' ),
				],
				[
					'id'     => 'section_start_breadcrumb_global',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Global', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'breadcrumb',
					'type'     => 'switch',
					'title'    => esc_html__( 'Breadcrumb Bar', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb bar for your site.', 'gulir' ),
					'description' => esc_html__( 'This setting will turn off the breadcrumb bar for your whole site.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'       => 'breadcrumb_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Wrapping Text', 'gulir' ),
					'subtitle' => esc_html__( 'Allow long words to be able to break and wrap onto the next line.', 'gulir' ),
					'options'  => [
						'0'    => esc_html__( 'No Wrap', 'gulir' ),
						'wrap' => esc_html__( 'Line Wrap', 'gulir' ),
					],
					'required' => [ 'breadcrumb', '=', true ],
					'default'  => '0',
				],
				[
					'id'     => 'section_end_breadcrumb_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_page_breadcrumb',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Page Breadcrumbs', 'gulir' ),
					'required' => [ 'breadcrumb', '=', true ],
					'indent' => true,
				],
				[
					'id'       => 'single_post_breadcrumb',
					'title'    => esc_html__( 'Single Post Breadcrumb', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb bar in the single post.', 'gulir' ),
					'type'     => 'select',
					'options'  => [
						'1' => esc_html__( 'Use Global Setting', 'gulir' ),
						'0' => esc_html__( 'Disable', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'single_page_breadcrumb',
					'title'    => esc_html__( 'Single Page Breadcrumb', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb bar in the single page.', 'gulir' ),
					'type'     => 'select',
					'options'  => [
						'1' => esc_html__( 'Use Global Setting', 'gulir' ),
						'0' => esc_html__( 'Disable', 'gulir' ),
					],
					'default'  => '0',
				],
				[
					'id'       => 'category_breadcrumb',
					'title'    => esc_html__( 'Category Breadcrumb', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb in the category pages.', 'gulir' ),
					'type'     => 'select',
					'options'  => [
						'1' => esc_html__( 'Use Global Setting', 'gulir' ),
						'0' => esc_html__( 'Disable', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'author_breadcrumb',
					'title'    => esc_html__( 'Author Breadcrumb', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb in the author pages.', 'gulir' ),
					'type'     => 'select',
					'options'  => [
						'1' => esc_html__( 'Use Global Setting', 'gulir' ),
						'0' => esc_html__( 'Disable', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'archive_breadcrumb',
					'title'    => esc_html__( 'Archive Breadcrumb', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the breadcrumb in the archive pages.', 'gulir' ),
					'type'     => 'select',
					'options'  => [
						'1' => esc_html__( 'Use Global Setting', 'gulir' ),
						'0' => esc_html__( 'Disable', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'     => 'section_end_page_breadcrumb',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}