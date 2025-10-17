<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_logo' ) ) {
	function gulir_register_options_logo() {

		return [
			'id'    => 'gulir_config_section_site_logo',
			'title' => esc_html__( 'Logo', 'gulir' ),
			'icon'  => 'el el-barcode',
		];
	}
}

if ( ! function_exists( 'gulir_register_options_logo_global' ) ) {
	function gulir_register_options_logo_global() {

		return [
			'id'         => 'gulir_config_section_global_logo',
			'title'      => esc_html__( 'Default Logos', 'gulir' ),
			'desc'       => esc_html__( 'Upload logos for you website.', 'gulir' ),
			'icon'       => 'el el-laptop',
			'subsection' => true,
			'fields'     => [
				[
					'id'    => 'info_add_favicon',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Go to "Settings > General Settings > Site Icon" to easily add your site icon (favicon).', 'gulir' ),
				],
				[
					'id'    => 'info_add_logo_dark',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Ensure that dark mode logos are configured when enabling dark mode for your site.', 'gulir' ),
				],
				[
					'id'    => 'template_logo_info',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'The logo settings may not apply to the Header Template. Edit the header with Elementor to configure the logo block if your website uses a header template.', 'gulir' ),
				],
				[
					'id'          => 'logo',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Main Logo', 'gulir' ),
					'subtitle'    => esc_html__( 'Select or upload the main logo for your site.', 'gulir' ),
					'description' => esc_html__( 'For optimal display, use a retina-ready logo with a recommended height of 120px, which is twice the height of its wrapper.', 'gulir' ),
				],
				[
					'id'          => 'dark_logo',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Dark Mode - Main Logo', 'gulir' ),
					'subtitle'    => esc_html__( 'Select or upload the logo for your site’s dark mode.', 'gulir' ),
					'description' => esc_html__( 'This logo should match the main logo but with colors adjusted to contrast well with a dark mode header background.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_logo_mobile' ) ) {
	function gulir_register_options_logo_mobile() {

		return [
			'id'         => 'gulir_config_section_mobile_logo',
			'title'      => esc_html__( 'Mobile Logos', 'gulir' ),
			'desc'       => esc_html__( 'Customize the mobile logos.', 'gulir' ),
			'icon'       => 'el el-iphone-home',
			'subsection' => true,
			'fields'     => [
				[
					'id'          => 'mobile_logo',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Mobile Logo', 'gulir' ),
					'subtitle'    => esc_html__( 'Upload a retina logo for displaying on mobile devices.', 'gulir' ),
					'description' => esc_html__( 'For optimal display, use a retina-ready logo with a recommended height of 84px, which is twice the height of its wrapper.', 'gulir' ),
				],
				[
					'id'       => 'dark_mobile_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'Dark Mode - Mobile Logo', 'gulir' ),
					'subtitle' => esc_html__( 'Upload a retina logo for displaying on mobile devices in dark mode.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_logo_transparent' ) ) {
	function gulir_register_options_logo_transparent() {

		return [
			'id'         => 'gulir_config_section_transparent_logo',
			'title'      => esc_html__( 'Transparent Logos', 'gulir' ),
			'desc'       => esc_html__( 'Upload and manage logos for transparent headers.', 'gulir' ),
			'icon'       => 'el el-photo',
			'subsection' => true,
			'fields'     => [
				[
					'id'          => 'transparent_logo',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Transparent Logo', 'gulir' ),
					'subtitle'    => esc_html__( 'Upload a light logo for transparent headers, if necessary, for pages using a transparent header.', 'gulir' ),
					'description' => esc_html__( 'For optimal display, use a retina-ready logo with a recommended height of 120px, which is twice the height of its wrapper.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_logo_organization' ) ) {
	function gulir_register_options_logo_organization() {

		return [
			'id'         => 'gulir_config_section_organization_logo',
			'title'      => esc_html__( 'Organization Logo', 'gulir' ),
			'desc'       => esc_html__( 'This logo is for schema markup. If your main logo uses light colors, a dark logo is recommended for this setting.', 'gulir' ),
			'icon'       => 'el el-photo',
			'subsection' => true,
			'fields'     => [
				[
					'id'    => 'logo_seo_info',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'IMPORTANT: The "Main Logo" or  Organization Logo (1st Priority) setting is crucial for schema data markup. Please ensure this setting is properly configured.', 'gulir' ),
				],
				[
					'id'          => 'logo_organization',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Organization Logo', 'gulir' ),
					'subtitle'    => esc_html__( 'This logo will appear on social media when sharing the front page and in search results.', 'gulir' ),
					'description' => esc_html__( 'Leave this field blank to use the main logo as the organization logo.', 'gulir' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_logo_favicon' ) ) {
	function gulir_register_options_logo_favicon() {

		return [
			'id'         => 'gulir_config_section_logo_favicon',
			'title'      => esc_html__( 'Bookmarklet', 'gulir' ),
			'desc'       => esc_html__( 'Select or upload bookmarklet icons for iOS and Android devices.', 'gulir' ),
			'icon'       => 'el el-bookmark',
			'subsection' => true,
			'fields'     => [
				[
					'id'          => 'icon_touch_apple',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'iOS Bookmarklet Icon', 'gulir' ),
					'subtitle'    => esc_html__( 'Upload an icon for the Apple touch.', 'gulir' ),
					'description' => esc_html__( 'The recommended image size is 72 x 72px', 'gulir' ),
				],
				[
					'id'          => 'icon_touch_metro',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Metro UI Bookmarklet Icon', 'gulir' ),
					'description' => esc_html__( 'The recommended image size is 144 x 144px', 'gulir' ),
					'subtitle'    => esc_html__( 'Upload icon for the Metro interface.', 'gulir' ),
				],
			],
		];
	}
}
