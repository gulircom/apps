<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_privacy' ) ) {
	function gulir_register_options_privacy() {

		return [
			'id'     => 'gulir_theme_ops_section_privacy',
			'title'  => esc_html__( 'Privacy Notice', 'gulir' ),
			'desc'   => esc_html__( 'Customize the privacy notice popup bar.', 'gulir' ),
			'icon'   => 'el el-exclamation-sign',
			'fields' => [
				[
					'id'       => 'privacy_bar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Privacy Bar', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the privacy bar.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'privacy_text',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Content', 'gulir' ),
					'subtitle' => esc_html__( 'Input your privacy or cookie content for your site, allow raw HTML.', 'gulir' ),
					'default'  => html_entity_decode( esc_html__( 'By using this site, you agree to the <a href="#">Privacy Policy</a> and <a href="#">Terms of Use</a>.', 'gulir' ) ),
					'required' => [ 'privacy_bar', '=', true ],
				],
				[
					'id'       => 'privacy_position',
					'type'     => 'select',
					'title'    => esc_html__( 'Position', 'gulir' ),
					'subtitle' => esc_html__( 'Select a position to display the privacy bar.', 'gulir' ),
					'options'  => [
						'left'   => esc_html__( 'Fixed Left', 'gulir' ),
						'0'      => esc_html__( 'Top Site', 'gulir' ),
						'bottom' => esc_html__( 'Fixed Bottom', 'gulir' ),
					],
					'required' => [ 'privacy_bar', '=', true ],
					'default'  => 'left',
				],
				[
					'id'       => 'privacy_width',
					'type'     => 'select',
					'title'    => esc_html__( 'Max Width', 'gulir' ),
					'subtitle' => esc_html__( 'Select a max width for the top position.', 'gulir' ),
					'options'  => [
						'wrap' => esc_html__( 'Wrapper', 'gulir' ),
						'wide' => esc_html__( 'Full Wide', 'gulir' ),
					],
					'required' => [ 'privacy_bar', '=', true ],
					'default'  => 'wrap',
				],
				[
					'id'          => 'privacy_bg_color',
					'type'        => 'color',
					'title'       => esc_html__( 'Background Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for this box background.', 'gulir' ),
					'transparent' => false,
					'required'    => [ 'privacy_bar', '=', true ],
				],
				[
					'id'          => 'privacy_text_color',
					'type'        => 'color',
					'title'       => esc_html__( 'Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for the text.', 'gulir' ),
					'transparent' => false,
					'required'    => [ 'privacy_bar', '=', true ],
				],
				[
					'id'          => 'dark_privacy_bg_color',
					'type'        => 'color',
					'title'       => esc_html__( 'Dark Mode - Background Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for this box background in dark mode.', 'gulir' ),
					'transparent' => false,
					'required'    => [ 'privacy_bar', '=', true ],
				],
				[
					'id'          => 'dark_privacy_text_color',
					'type'        => 'color',
					'title'       => esc_html__( 'Dark Mode - Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for the text in dark mode.', 'gulir' ),
					'transparent' => false,
					'required'    => [ 'privacy_bar', '=', true ],
				],
			],
		];
	}
}
