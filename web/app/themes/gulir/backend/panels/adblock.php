<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_adblock' ) ) {
	function gulir_register_options_adblock() {

		return [
			'id'     => 'gulir_config_section_adblock',
			'title'  => esc_html__( 'AdBlock Detector', 'gulir' ),
			'desc'   => esc_html__( 'Detecting most of the AdBlock extensions and show a popup to disable the extension.', 'gulir' ),
			'icon'   => 'el el-minus-sign',
			'fields' => [
				[
					'id'          => 'adblock_detector',
					'title'       => esc_html__( 'AdBlock Detector', 'gulir' ),
					'subtitle'    => esc_html__( 'Enable or disable the AdBlock detector.', 'gulir' ),
					'description' => esc_html__( 'The basic method may not work with advanced or smarter AdBlock extensions.', 'gulir' ),
					'type'        => 'select',
					'options'     => [
						'0' => esc_html__( '- Disable -', 'gulir' ),
						'1' => esc_html__( 'Basic Method', 'gulir' ),
						'2' => esc_html__( 'Advanced Method', 'gulir' ),
					],
					'default'     => '0',
				],
				[
					'id'       => 'adblock_title',
					'title'    => esc_html__( 'Title', 'gulir' ),
					'subtitle' => esc_html__( 'Input a title for the adblock popup.', 'gulir' ),
					'type'     => 'text',
					'required' => [ 'adblock_detector', '!=', 0 ],
					'default'  => esc_html__( 'AdBlock Detected', 'gulir' ),
				],
				[
					'id'       => 'adblock_description',
					'title'    => esc_html__( 'Description', 'gulir' ),
					'subtitle' => esc_html__( 'Input a description for the adblock popup.', 'gulir' ),
					'type'     => 'textarea',
					'rows'     => 2,
					'required' => [ 'adblock_detector', '!=', 0 ],
					'default'  => esc_html__( 'Our site is an advertising supported site. Please whitelist to support our site.', 'gulir' ),
				],
			],
		];
	}
}
