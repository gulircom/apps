<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_dark_mode' ) ) {
	function gulir_register_options_dark_mode() {

		return [
			'id'     => 'gulir_config_section_dark_mode',
			'title'  => esc_html__( 'Dark Mode', 'gulir' ),
			'desc'   => esc_html__( 'Customize dark mode for your website.', 'gulir' ),
			'icon'   => 'el el-adjust',
			'fields' => [
				[
					'id'    => 'dark_mode_notice',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'You can set custom dark mode background in "Global Colors > Dark Mode Background".', 'gulir' ),
				],
				[
					'id'    => 'dark_mode_logo_notice',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'Consider providing dark logos, colors, and background settings if you use dark mode.', 'gulir' ),
				],
				[
					'id'     => 'section_start_dark_mode',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Global', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'dark_mode',
					'title'       => esc_html__( 'Dark Mode', 'gulir' ),
					'subtitle'    => esc_html__( 'Select settings for the dark mode.', 'gulir' ),
					'description' => esc_html__( 'In browser mode, switching modes not be allowed. However, you need to set up colors and data for both light and dark modes.', 'gulir' ),
					'type'        => 'select',
					'options'     => [
						'0'       => esc_html__( 'Disable Dark Mode', 'gulir' ),
						'1'       => esc_html__( 'Light/Dark Switchable', 'gulir' ),
						'dark'    => esc_html__( 'Dark Mode Only', 'gulir' ),
						'browser' => esc_html__( 'Based on Browser', 'gulir' ),
					],
					'default'     => '0',
				],
				[
					'id'     => 'section_end_dark_mode',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_dark_mode_switchable',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'for Light/Dark Switchable', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'dark_mode_cookie',
					'title'       => esc_html__( 'Preventing Dark Mode Flickering', 'gulir' ),
					'subtitle'    => esc_html__( 'Use cookies or JS function after Body tag to prevent background flickering during page load.', 'gulir' ),
					'description' => esc_html__( 'The theme uses localStorage as the default for dark mode to reduce server usage.', 'gulir' ),
					'type'        => 'select',
					'options'     => [
						'0' => esc_html__( 'Default (Footer Script)', 'gulir' ),
						'2' => esc_html__( 'Move JS Function after Body Tag', 'gulir' ),
						'1' => esc_html__( 'Use Cookies Method', 'gulir' ),
					],
					'default'     => '2',
				],
				[
					'id'          => 'first_visit_mode',
					'title'       => esc_html__( 'Mode First Time Visit', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color scheme for your website when users visit your site at the first time.', 'gulir' ),
					'description' => esc_html__( 'Based on browser will set the website\'s color scheme to either light or dark mode based on the user\'s browser settings on their first visit.', 'gulir' ),
					'type'        => 'select',
					'options'     => [
						'default' => esc_html__( 'Light', 'gulir' ),
						'dark'    => esc_html__( 'Dark', 'gulir' ),
						'browser' => esc_html__( 'Based on Browser', 'gulir' ),
					],
					'default'     => 'default',
				],
				[
					'id'     => 'section_end_dark_mode_switchable',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_dark_mode_image',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Featured Image', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'dark_mode_image_opacity',
					'title'    => esc_html__( 'Image Opacity', 'gulir' ),
					'subtitle' => esc_html__( 'Reduce the featured image opacity when enabled dark mode.', 'gulir' ),
					'type'     => 'switch',
					'default'  => false,
				],
				[
					'id'     => 'section_end_dark_mode_image',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'       => 'section_start_dark_mode_switcher',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Mode Switcher', 'gulir' ),
					'notice' => [
						esc_html__( 'Go to "Colors > Mode Switcher" to customize the colors of the dark mode icons.', 'gulir' ),
						esc_html__( 'Enable the option in "Theme Design > SVG Upload > SVG Supported" if you cannot upload .SVG files.', 'gulir' ),
					],
					'indent'   => true,
				],
				[
					'id'       => 'dark_mode_style',
					'title'    => esc_html__( 'Switcher Style', 'gulir' ),
					'subtitle' => esc_html__( 'Select a style for the dark mode toggle button that best suits your design preferences.', 'gulir' ),
					'type'     => 'select',
					'options'  => [
						'1' => esc_html__( '- Default -', 'gulir' ),
						'2' => esc_html__( 'Minimalistic', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'          => 'dark_mode_size',
					'title'       => esc_html__( 'Switcher Size', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a custom size for the dark mode switcher (in pixels).', 'gulir' ),
					'description' => esc_html__( 'The default value is 24px.', 'gulir' ),
					'type'        => 'text',
					'class'       => 'small',
					'placeholder' => '24',
					'validate'    => 'numeric',
				],
				[
					'id'          => 'dark_mode_light_icon',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Custom Light (Sun) Icon', 'gulir' ),
					'subtitle'    => esc_html__( 'Replace the default sun icon with a custom SVG icon.', 'gulir' ),
					'description' => esc_html__( 'Tip: Edit the SVG path, fill color to "currentColor" to allow color settings to be applied.', 'gulir' ),
				],
				[
					'id'       => 'dark_mode_dark_icon',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Custom Dark (Moon) Icon', 'gulir' ),
					'subtitle' => esc_html__( 'Replace the default moon icon with a custom SVG icon.', 'gulir' ),
				],
				[
					'id'     => 'section_end_dark_mode_switcher',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}