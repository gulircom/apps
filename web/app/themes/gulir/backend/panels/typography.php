<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

/** typo config */
if ( ! function_exists( 'gulir_register_options_typo' ) ) {
	function gulir_register_options_typo() {

		return [
			'id'    => 'gulir_config_section_typo',
			'title' => esc_html__( 'Typography', 'gulir' ),
			'icon'  => 'el el-font',
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_body' ) ) {
	function gulir_register_options_typo_body() {

		return [
			'id'         => 'gulir_config_section_typo_body',
			'title'      => esc_html__( 'Website Body', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for your site. The settings below apply to almost content elements on the website.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'info_body_color_dark_mode',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'The body font (text) color for dark mode will be white (#fff).', 'gulir' ),
				],
				[
					'id'             => 'font_body',
					'type'           => 'typography',
					'title'          => esc_html__( 'Body Font', 'gulir' ),
					'subtitle'       => esc_html__( 'The settings below apply to almost post and page content on your site.', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set; the minimum value will be 1.4 of the font size. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_body_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the body on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_body_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the body on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_excerpt' ) ) {
	function gulir_register_options_typo_excerpt() {

		return [
			'id'         => 'gulir_config_section_typo_excerpt',
			'title'      => esc_html__( 'Entry Excerpt', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font sizes and colors for the excerpt in the post listing.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_excerpt',
					'type'           => 'typography',
					'title'          => esc_html__( 'Excerpt Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Custom font for excerpt and entry summary.', 'gulir' ),
					'desc'           => esc_html__( 'Leaving the font family blank or matching it with the body font will optimize for your site speed.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_excerpt_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the excerpt on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_excerpt_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the excerpt on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'          => 'excerpt_color',
					'title'       => esc_html__( 'Excerpt Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for post excerpt text.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'dark_excerpt_color',
					'title'       => esc_html__( 'Dark Mode - Excerpt Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for post excerpt text.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply to dark mode and overlay layouts.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_h1' ) ) {
	function gulir_register_options_typo_h1() {

		return [
			'id'         => 'gulir_config_section_typo_h1',
			'title'      => esc_html__( 'H1 Tag', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the H1 tag. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_h1',
					'type'           => 'typography',
					'title'          => esc_html__( 'H1 Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the H1 tag and [ CSS classname: .h1]', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_h1_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_h1_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_h2' ) ) {
	function gulir_register_options_typo_h2() {

		return [
			'id'         => 'gulir_config_section_typo_h2',
			'title'      => esc_html__( 'H2 Tag', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the H2 tag. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_h2',
					'type'           => 'typography',
					'title'          => esc_html__( 'H2 Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the H2 tag and [ CSS classname: .h2]', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_h2_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_h2_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_h3' ) ) {
	function gulir_register_options_typo_h3() {

		return [
			'id'         => 'gulir_config_section_typo_h3',
			'title'      => esc_html__( 'H3 Tag', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the H3 tag. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_h3',
					'type'           => 'typography',
					'title'          => esc_html__( 'H3 Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the H3 tag and [ CSS classname: .h3]', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_h3_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_h3_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_h4' ) ) {
	function gulir_register_options_typo_h4() {

		return [
			'id'         => 'gulir_config_section_typo_h4',
			'title'      => esc_html__( 'H4 Tag', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the H4 tag. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_h4',
					'type'           => 'typography',
					'title'          => esc_html__( 'H4 Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the H4 tag and [ CSS classname: .h4]', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_h4_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_h4_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_h5' ) ) {
	function gulir_register_options_typo_h5() {

		return [
			'id'         => 'gulir_config_section_typo_h5',
			'title'      => esc_html__( 'H5 Tag', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the H5 tag. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_h5',
					'type'           => 'typography',
					'title'          => esc_html__( 'H5 Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the H5 tag and [ CSS classname: .h5]', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_h5_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_h5_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_h6' ) ) {
	function gulir_register_options_typo_h6() {

		return [
			'id'         => 'gulir_config_section_typo_h6',
			'title'      => esc_html__( 'H6 Tag', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the H6 tag. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_h6',
					'type'           => 'typography',
					'title'          => esc_html__( 'H6 Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the H6 tag and [ CSS classname: .h6]', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_h6_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_h6_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for this heading tag on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_category' ) ) {
	function gulir_register_options_typo_category() {

		return [
			'id'         => 'gulir_config_section_typo_category',
			'title'      => esc_html__( 'Entry Category', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the entry category (category icon) in the post listing.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_ecat',
					'type'           => 'typography',
					'title'          => esc_html__( 'Entry Category Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for the entry category element.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_ecat_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the entry category element on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_ecat_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the entry category element on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_meta' ) ) {
	function gulir_register_options_typo_meta() {

		return [
			'id'         => 'gulir_config_section_typo_meta',
			'title'      => esc_html__( 'Entry Meta', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the post entry meta. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'     => 'section_start_font_emeta',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Entry Meta Font', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_emeta',
					'type'           => 'typography',
					'title'          => esc_html__( 'Entry Meta Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Customize font settings for entry meta elements such as date, views, comments, and more.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-size'      => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
				],
				[
					'id'       => 'font_emeta_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Set a font size (in pixels) for entry meta info on tablet devices (max width: 1024px).', 'gulir' ),
				],
				[
					'id'       => 'font_emeta_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Set a font size (in pixels) for entry meta info on mobile devices (max width: 767px).', 'gulir' ),
				],
				[
					'id'          => 'dark_emeta_color',
					'title'       => esc_html__( 'Dark Mode - Entry Meta Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for entry meta in dark mode.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply to dark mode and overlay layouts.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'     => 'section_end_font_emeta',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_font_emeta_bold',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Important Entry Meta Font', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_eauthor',
					'type'           => 'typography',
					'title'          => esc_html__( 'Important Meta Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Customize font settings for author names, categories, term, review descriptions, and sponsored brand labels.', 'gulir' ),
					'desc'           => esc_html__( 'Leaving the font family blank or matching it with the entry meta font will optimize for your site speed.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-size'      => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_eauthor_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Set the font size (in pixels) for important entry meta elements on tablets (screen width up to 1024px).', 'gulir' ),
				],
				[
					'id'       => 'font_eauthor_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Set the font size (in pixels) for important entry meta elements on mobile devices (screen width up to 767px).', 'gulir' ),
				],
				[
					'id'          => 'dark_eauthor_color',
					'title'       => esc_html__( 'Dark Mode - Important Meta Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for important entry meta such as author, term name in dark mode.', 'gulir' ),
					'description' => esc_html__( 'Recommended color is white color.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],

				[
					'id'     => 'section_end_font_emeta_bold',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_readmore' ) ) {
	function gulir_register_options_typo_readmore() {

		return [
			'id'         => 'gulir_config_section_typo_readmore',
			'title'      => esc_html__( 'Read More Button', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the read more button.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_readmore',
					'type'           => 'typography',
					'title'          => esc_html__( 'Read More Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the read more button', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-size'      => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
				],
				[
					'id'       => 'font_readmore_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the readmore button on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_readmore_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the readmore button on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_input' ) ) {
	function gulir_register_options_typo_input() {

		return [
			'id'         => 'gulir_config_section_typo_input',
			'title'      => esc_html__( 'Inputs & Button', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font for the input, textarea and button. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'     => 'section_start_font_input',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Input Font', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_input',
					'type'           => 'typography',
					'title'          => esc_html__( 'Input & Textarea Font', 'gulir' ),
					'subtitle'       => esc_html__( 'The settings below apply to the input and textarea form on your site.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_input_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for input and textarea on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_input_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for input and textarea on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'     => 'section_end_font_input',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_font_button',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Button Font', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_button',
					'type'           => 'typography',
					'title'          => esc_html__( 'Button Font', 'gulir' ),
					'subtitle'       => esc_html__( 'The settings below apply to all button on your site.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_button_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for buttons on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_button_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for buttons on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'     => 'section_end_font_button',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_single' ) ) {
	/**
	 * @return array
	 * single typography
	 */
	function gulir_register_options_typo_single() {

		return [
			'id'         => 'gulir_config_section_typo_single',
			'title'      => esc_html__( 'Single Post', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for Single Headline (Single Post Title) and Single Tagline (Single Sub Title).', 'gulir' ),
			'fields'     => [
				[
					'id'     => 'section_start_font_single_headline',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Single Headline Fonts (Post Title)', 'gulir' ),
					'indent' => true,
				],
				[
					'id'    => 'typo_single_info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'The single headline will use H1 font settings as the default. You can override the settings in this panel.', 'gulir' ),
				],
				[
					'id'             => 'font_headline',
					'type'           => 'typography',
					'title'          => esc_html__( 'Full Width Headline', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the single headline for displaying in the full width layouts.', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_headline_size_content',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Content Font Size (Small Headline)', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the single headline or displaying in 66.67% of the site width.', 'gulir' ),
				],
				[
					'id'       => 'font_headline_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the single headline on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_headline_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the single headline on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'     => 'section_end_font_single_headline',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'       => 'section_start_font_single_tagline',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Single Tagline Fonts (Sub Title)', 'gulir' ),
					'subtitle' => esc_html__( 'The single tagline will use the H2 tag font settings. You can override settings in this panel.', 'gulir' ),
					'indent'   => true,
				],
				[
					'id'             => 'font_tagline',
					'type'           => 'typography',
					'title'          => esc_html__( 'Full Width Tagline', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the single tagline for displaying in the full width layouts.', 'gulir' ),
					'description'    => esc_html__( 'The line height value requires that the font size be set. Leave it blank for the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => true,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_tagline_size_content',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Content Font Size (Small Tagline)', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the single tagline or displaying in 66.67% of the site width.', 'gulir' ),
				],
				[
					'id'       => 'font_tagline_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the single tagline on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_tagline_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the single tagline on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'          => 'dark_tagline_color',
					'title'       => esc_html__( 'Dark Mode - Tagline Color', 'gulir' ),
					'subtitle' => esc_html__( 'Select a color for the single post tagline in dark mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'     => 'section_end_font_tagline',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_font_single_quote',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Block Quote', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_quote',
					'type'           => 'typography',
					'title'          => esc_html__( 'Block Quote', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font values for the block quote.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'font-weight'    => true,
					'font-size'      => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'     => 'section_end_font_quote',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_font_post_pagi',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Next/Prev Post Pagination', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_epagi',
					'type'           => 'typography',
					'title'          => esc_html__( 'Next/Previous Post Pagination Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font settings for the post titles in the next/previous link navigation.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_epagi_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the next/previous link navigation on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_epagi_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the next/previous link navigation on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'     => 'section_end_font_post_pagi',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_breadcrumb' ) ) {
	function gulir_register_options_typo_breadcrumb() {

		return [
			'id'         => 'gulir_config_section_typo_breadcrumb',
			'title'      => esc_html__( 'Breadcrumb', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the breadcrumb bar. Selecting same font family settings for similar elements will optimize for your site speed.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_breadcrumb',
					'type'           => 'typography',
					'title'          => esc_html__( 'Breadcrumb Font', 'gulir' ),
					'subtitle'       => esc_html__( 'The settings below apply to the breadcrumb bar.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'          => 'breadcrumb_color',
					'title'       => esc_html__( 'Breadcrumb Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for the breadcrumb bar.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply to the default mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'dark_breadcrumb_color',
					'title'       => esc_html__( 'Dark Mode - Breadcrumb Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for the breadcrumb bar in dark mode.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply to dark mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'       => 'font_breadcrumb_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the breadcrumbs bar on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_breadcrumb_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the breadcrumbs bar on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_menus' ) ) {
	function gulir_register_options_typo_menus() {

		return [
			'id'         => 'gulir_config_section_typo_main_menu',
			'title'      => esc_html__( 'Header Menus', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for menus on the website header.', 'gulir' ),
			'fields'     => [
				[
					'id'     => 'section_start_section_font_main_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Main Menu', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_main_menu',
					'type'           => 'typography',
					'title'          => esc_html__( 'Menu Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for top menu items for displaying in the main menu.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'             => 'font_main_sub_menu',
					'type'           => 'typography',
					'title'          => esc_html__( 'Sub-Level Menu Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for sub-level menu items for displaying in the main menu.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'     => 'section_end_section_font_main_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_section_font_mobile_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Mobile Menu', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_mobile_menu',
					'type'           => 'typography',
					'title'          => esc_html__( 'Mobile Menu Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for top menu items for displaying in the mobile menu.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'             => 'font_mobile_sub_menu',
					'type'           => 'typography',
					'title'          => esc_html__( 'Sub-Level Mobile Menu Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for sub-level menu items for displaying in the mobile menu.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'     => 'section_end_section_font_mobile_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_section_font_quick_access_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Mobile Quick Access', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_quick_access_menu',
					'type'           => 'typography',
					'title'          => esc_html__( 'Mobile Quick Access Menu Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for mobile quick access menu items for displaying on mobile devices.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'     => 'section_end_section_font_quick_access_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_heading' ) ) {
	function gulir_register_options_typo_heading() {

		return [
			'id'         => 'gulir_config_section_typo_block_heading',
			'title'      => esc_html__( 'Block Heading', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the block heading.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_heading',
					'type'           => 'typography',
					'title'          => esc_html__( 'Heading Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Heading tag will use default H tag font settings. Select font values if you would like to choose a custom font.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_heading_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the heading block on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_heading_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the heading block on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'             => 'font_sub_heading',
					'type'           => 'typography',
					'title'          => esc_html__( 'Tagline Font', 'gulir' ),
					'subtitle'       => esc_html__( 'Tagline tag will use default H6 tag font settings. Select font values if you would like to choose a custom font.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => true,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_widget_menu' ) ) {
	function gulir_register_options_typo_widget_menu() {

		return [
			'id'         => 'gulir_config_section_typo_widget_menu',
			'title'      => esc_html__( 'Archive & Menu Widgets', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the default widgets, apply to the archive, category widgets...', 'gulir' ),
			'fields'     => [
				[
					'id'     => 'section_start_section_font_widgets',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Sidebar Archive & Menu Widgets', 'gulir' ),
					'indent' => true,
				],
				[
					'id'             => 'font_widget',
					'type'           => 'typography',
					'title'          => esc_html__( 'Default Widgets', 'gulir' ),
					'subtitle'       => esc_html__( 'Select font for the default archives, categories and menu fonts.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'font-weight'    => true,
					'line-height'    => false,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_widget_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for buttons on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_widget_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for buttons on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
				[
					'id'     => 'section_end_section_font_widgets',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_toc' ) ) {
	function gulir_register_options_typo_toc() {

		return [
			'id'         => 'gulir_config_section_typo_toc',
			'title'      => esc_html__( 'Table of Contents', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'desc'       => esc_html__( 'Select font values for the table of contents.', 'gulir' ),
			'fields'     => [
				[
					'id'             => 'font_toc',
					'type'           => 'typography',
					'title'          => esc_html__( 'Table of Contents Font', 'gulir' ),
					'subtitle'       => esc_html__( 'The Table of Contents uses the default H5 tag font settings. Select custom font values below if you wish to override the default.', 'gulir' ),
					'google'         => true,
					'font-backup'    => true,
					'text-align'     => false,
					'color'          => false,
					'text-transform' => true,
					'letter-spacing' => true,
					'line-height'    => false,
					'font-weight'    => true,
					'font-size'      => true,
					'units'          => 'px',
					'default'        => [],
				],
				[
					'id'       => 'font_toc_size_tablet',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the Table of Contents on tablet devices (max screen width: 1024px). Leave this option blank to use the default value.', 'gulir' ),
				],
				[
					'id'       => 'font_toc_size_mobile',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a font size (in pixels) for the Table of Contents on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
				],
			],
		];
	}
}
