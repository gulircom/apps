<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_wprm_supported' ) ) {
	function gulir_register_options_wprm_supported() {

		if ( ! class_exists( 'WP_Recipe_Maker' ) ) {
			return [
				'id'     => 'gulir_config_section_wprm_supported',
				'title'  => esc_html__( 'WP Recipe Maker', 'gulir-core' ),
				'desc'   => esc_html__( 'Enable styling support for the WP Recipe Maker plugin, compatible with dark mode.', 'gulir-core' ),
				'icon'   => 'el el-tasks',
				'fields' => [
					[
						'id'    => 'wprm_install_warning',
						'type'  => 'info',
						'style' => 'warning',
						'desc'  => html_entity_decode( esc_html__( 'The WP Recipe Maker Plugin is missing! Please install and activate the <a href="https://wordpress.org/plugins/wp-recipe-maker/">WP Recipe Maker</a> plugin to enable the settings.', 'gulir-core' ) ),
					],
				],
			];
		}

		return [
			'id'     => 'gulir_config_section_wprm_supported',
			'title'  => esc_html__( 'WP Recipe Maker', 'gulir-core' ),
			'desc'   => esc_html__( 'Enable styling support for the WP Recipe Maker plugin, compatible with dark mode.', 'gulir-core' ),
			'icon'   => 'el el-tasks',
			'fields' => [
				[
					'id'       => 'wprm_supported',
					'type'     => 'switch',
					'title'    => esc_html__( 'Load Styles', 'gulir-core' ),
					'subtitle' => esc_html__( 'Customize WP Recipe Maker styling to match the theme aesthetics.', 'gulir-core' ),
					'default'  => 1,
				],
				[
					'id'          => 'wprm_pinterest',
					'type'        => 'select',
					'title'       => esc_html__( 'Pinterest Script', 'gulir-core' ),
					'subtitle'    => esc_html__( 'Force to disable the Pinterest library script of this plugin.', 'gulir-core' ),
					'description' => esc_html__( 'Disabling the script of the plugin will fix the layout of the "Share on Pinterest" button.', 'gulir-core' ),
					'options'     => [
						'1'  => esc_html__( 'Enable', 'gulir-core' ),
						'-1' => esc_html__( 'Disable', 'gulir-core' ),
					],
					'default'     => '-1',
				],
				[
					'id'       => 'wprm_toc',
					'type'     => 'select',
					'title'    => esc_html__( 'Table of Contents Included', 'gulir-core' ),
					'subtitle' => esc_html__( 'Include the heading of the WP Recipe Maker to table of contents.', 'gulir-core' ),
					'options'  => [
						'1'  => esc_html__( 'Enable', 'gulir-core' ),
						'-1' => esc_html__( 'Disable', 'gulir-core' ),
					],
					'default'  => '1',
				],
			],
		];
	}
}
