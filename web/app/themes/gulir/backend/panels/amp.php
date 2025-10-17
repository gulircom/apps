<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_amp_plugin_status_info' ) ) {
	function gulir_amp_plugin_status_info( $id = 'amp-plugin-info' ) {

		if ( ! function_exists( 'amp_init' ) ) {
			return [
				'id'    => $id,
				'type'  => 'info',
				'style' => 'warning',
				'desc'  => html_entity_decode( esc_html__( 'The AMP (Accelerated Mobile Pages) Plugin is missing! Please install and activate <a target="_blank" href="https://wordpress.org/plugins/amp">Automattic AMP</a> plugin to activate the settings.', 'gulir' ) ),
			];
		}

		return null;
	}
}

if ( ! function_exists( 'gulir_register_options_amp' ) ) {
	function gulir_register_options_amp() {

		return [
			'id'    => 'gulir_config_section_amp',
			'title' => esc_html__( 'AMP', 'gulir' ),
			'desc'  => esc_html__( 'Customize your website in AMP mode.', 'gulir' ),
			'icon'  => 'el el-ok',
		];
	}
}

if ( ! function_exists( 'gulir_register_options_amp_general' ) ) {
	function gulir_register_options_amp_general() {

		return [
			'id'         => 'gulir_config_section_amp_general',
			'title'      => esc_html__( 'General', 'gulir' ),
			'desc'       => esc_html__( 'Customize your website in AMP mode.', 'gulir' ),
			'icon'       => 'el el-cog',
			'subsection' => true,
			'fields'     => [
				gulir_amp_plugin_status_info( 'general-amp-plugin-info' ),
				[
					'id'    => 'amp-footer-info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Each AMP page has a 75,000 byte CSS limit. Gulir will support a compact footer to ensure your site will meet with this requirement.', 'gulir' ),
				],
				[
					'id'     => 'section_start_amp_general',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Debug Mode', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_debug',
					'type'     => 'switch',
					'title'    => esc_html__( 'AMP Debug', 'gulir' ),
					'subtitle' => esc_html__( 'Debug mode will provide more information about the each AMP page such as CSS usages, plugin scripts etc...', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'remove_amp_switcher',
					'type'     => 'switch',
					'title'    => esc_html__( 'Remove Footer Switcher', 'gulir' ),
					'subtitle' => esc_html__( 'Remove the "Exit Mobile Version" link at the footer.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'     => 'section_end_amp_general',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_amp_footer',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'AMP Footer', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_footer_logo',
					'type'     => 'media',
					'url'      => true,
					'preview'  => true,
					'title'    => esc_html__( 'AMP Footer Logo', 'gulir' ),
					'subtitle' => esc_html__( 'Upload AMP footer logo.', 'gulir' ),
				],
				[
					'id'       => 'amp_footer_logo_height',
					'title'    => esc_html__( 'Logo Height', 'gulir' ),
					'subtitle' => esc_html__( 'Input a height for value for the footer logo, Default is 50px.', 'gulir' ),
					'type'     => 'text',
					'class'       => 'small',
				],
				[
					'id'       => 'amp_footer_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Social Icons', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the social list in this section.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'amp_footer_bottom_center',
					'type'     => 'switch',
					'title'    => esc_html__( 'Centered Mode', 'gulir' ),
					'subtitle' => esc_html__( 'Centering this section.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'     => 'section_end_amp_footer',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_amp_footer_copyright',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Copyright Section', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'amp_copyright',
					'type'        => 'switch',
					'title'       => esc_html__( 'Copyright Section', 'gulir' ),
					'subtitle'    => esc_html__( 'Enable or disable the footer copyright section.', 'gulir' ),
					'description' => esc_html__( 'To setup the copyright area, Please navigate to Footer > Copyright Section.', 'gulir' ),
					'default'     => true,
				],
				[
					'id'     => 'section_end_amp_footer_copyright',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_amp_footer_back_top',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Back to Top', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_back_top',
					'type'     => 'switch',
					'title'    => esc_html__( 'Back to Top', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the back to top button.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'     => 'section_end_amp_back_top',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_amp_single' ) ) {
	function gulir_register_options_amp_single() {

		return [
			'id'         => 'gulir_config_section_amp_single',
			'title'      => esc_html__( 'Single Post', 'gulir' ),
			'desc'       => esc_html__( 'Select settings for the single post on your site in AMP mode.', 'gulir' ),
			'icon'       => 'el el-cog',
			'subsection' => true,
			'fields'     => [
				gulir_amp_plugin_status_info( 'single-amp-plugin-info' ),
				[
					'id'    => 'amp-single-info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Each AMP page has a 75,000 byte CSS limit, turn off unnecessary section will increase the AMP performance.', 'gulir' ),
				],
				[
					'id'       => 'amp_disable_left_share',
					'type'     => 'switch',
					'title'    => esc_html__( 'Fixed Left Share Bar', 'gulir' ),
					'off'      => esc_html__( 'Default from Single Settings', 'gulir' ),
					'on'       => esc_html__( 'Disable on AMP', 'gulir' ),
					'subtitle' => esc_html__( 'Disable the Author Card in AMP mode.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'       => 'amp_disable_author',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author Card', 'gulir' ),
					'off'      => esc_html__( 'Default from Single Settings', 'gulir' ),
					'on'       => esc_html__( 'Disable on AMP', 'gulir' ),
					'subtitle' => esc_html__( 'Disable the Author Card in AMP mode.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'amp_disable_single_pagination',
					'type'     => 'switch',
					'title'    => esc_html__( 'Next/Prev Articles', 'gulir' ),
					'off'      => esc_html__( 'Default from Single Settings', 'gulir' ),
					'on'       => esc_html__( 'Disable on AMP', 'gulir' ),
					'subtitle' => esc_html__( 'Disable the Next/Prev Articles section in AMP mode.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'amp_disable_comment',
					'type'     => 'switch',
					'title'    => esc_html__( 'Comment Box', 'gulir' ),
					'off'      => esc_html__( 'Default', 'gulir' ),
					'on'       => esc_html__( 'Disable on AMP', 'gulir' ),
					'subtitle' => esc_html__( 'Disable comment form in AMP mode.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'amp_disable_related',
					'type'     => 'switch',
					'title'    => esc_html__( 'Related & Popular Section', 'gulir' ),
					'off'      => esc_html__( 'Default from Single Settings', 'gulir' ),
					'on'       => esc_html__( 'Disable on AMP', 'gulir' ),
					'subtitle' => esc_html__( 'Disable the single footer section, including related and popular blocks in AMP mode.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'amp_disable_single_sidebar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sidebar Section', 'gulir' ),
					'off'      => esc_html__( 'Default from Single Settings', 'gulir' ),
					'on'       => esc_html__( 'Disable on AMP', 'gulir' ),
					'subtitle' => esc_html__( 'Disable the single post sidebar section in AMP mode.', 'gulir' ),
					'default'  => true,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_amp_auto_ads' ) ) {
	function gulir_register_options_amp_auto_ads() {

		return [
			'id'         => 'gulir_config_section_amp_auto_ads',
			'title'      => esc_html__( 'AMP Auto Ads', 'gulir' ),
			'desc'       => esc_html__( 'Select setting for auto ads in AMP mode.', 'gulir' ),
			'icon'       => 'el el-cog',
			'subsection' => true,
			'fields'     => [
				gulir_amp_plugin_status_info( 'auto-ads-amp-plugin-info' ),
				[
					'id'    => 'amp-auto-ads-info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Auto ads for AMP automatically place AdSense Auto ads on your AMP pages. Google will automatically show ads on your AMP pages at optimal times when they are likely to perform well and provide a good experience.', 'gulir' ),
				],
				[
					'id'          => 'amp_ad_auto_code',
					'title'       => esc_html__( 'AMP Auto Ads Code', 'gulir' ),
					'subtitle'    => esc_html__( 'Input your amp auto ads code.', 'gulir' ),
					'type'        => 'textarea',
					'rows'        => 2,
					'placeholder' => esc_html( '<amp-auto-ads type="adsense" data-ad-client....amp-auto-ads>' ),
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_amp_ads' ) ) {
	function gulir_register_options_amp_ads() {

		return [
			'id'         => 'gulir_config_section_amp_ads',
			'title'      => esc_html__( 'AMP Ads', 'gulir' ),
			'desc'       => esc_html__( 'Select setting for ads in AMP mode.', 'gulir' ),
			'icon'       => 'el el-cog',
			'subsection' => true,
			'fields'     => [
				gulir_amp_plugin_status_info( 'ads-amp-plugin-info' ),
				[
					'id'    => 'amp-ads-info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Leave blank AMP auto ads if you would like to use the ad units.', 'gulir' ),
				],

				[
					'id'     => 'section_start_amp_header_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Header Ad', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_header_ad_type',
					'type'     => 'select',
					'title'    => esc_html__( 'Header - Ad Type', 'gulir' ),
					'subtitle' => esc_html__( 'Select your ad type to display at the header.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Adsense --', 'gulir' ),
						'2' => esc_html__( 'AMP Custom Script Ad', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_header_adsense_client',
					'type'     => 'text',
					'required' => [ 'amp_header_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Header - Data Ad Client', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-client number ID (without ca-pub-).', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_header_adsense_slot',
					'type'     => 'text',
					'required' => [ 'amp_header_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Header - Data Ad Slot', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-slot number ID.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_header_adsense_size',
					'type'     => 'select',
					'required' => [ 'amp_header_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Header - Adsense Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a size for this ad.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Responsive --', 'gulir' ),
						'2' => esc_html__( 'Fixed Height (90px)', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_header_ad_code',
					'type'     => 'textarea',
					'rows'     => 2,
					'required' => [ 'amp_header_ad_type', '=', '2' ],
					'title'    => esc_html__( 'Header - AMP Custom Ad Script', 'gulir' ),
					'subtitle' => esc_html__( 'Input your AMP custom ad script.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'     => 'section_end_amp_header_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_amp_footer_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Footer Ad', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_footer_ad_type',
					'type'     => 'select',
					'title'    => esc_html__( 'Footer - Ad Type', 'gulir' ),
					'subtitle' => esc_html__( 'Select your ad type to display at the footer.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Adsense --', 'gulir' ),
						'2' => esc_html__( 'AMP Custom Script Ad', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_footer_adsense_client',
					'type'     => 'text',
					'required' => [ 'amp_footer_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Footer - Data Ad Client', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-client number ID (without ca-pub-).', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_footer_adsense_slot',
					'type'     => 'text',
					'required' => [ 'amp_footer_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Footer - Data Ad Slot', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-slot number ID.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_footer_adsense_size',
					'type'     => 'select',
					'required' => [ 'amp_footer_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Footer - Adsense Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a size for this ad.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Responsive --', 'gulir' ),
						'2' => esc_html__( 'Fixed Height (90px)', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_footer_ad_code',
					'type'     => 'textarea',
					'rows'     => 2,
					'required' => [ 'amp_footer_ad_type', '=', '2' ],
					'title'    => esc_html__( 'Footer - AMP Custom Ad Script', 'gulir' ),
					'subtitle' => esc_html__( 'Input your AMP custom ad script.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'     => 'section_end_amp_footer_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_amp_top_single_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Top Single Content Ad', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_top_single_ad_type',
					'type'     => 'select',
					'title'    => esc_html__( 'Top - Ad Type', 'gulir' ),
					'subtitle' => esc_html__( 'Select your ad type to display at the top single content.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Adsense --', 'gulir' ),
						'2' => esc_html__( 'AMP Custom Script Ad', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_top_single_adsense_client',
					'type'     => 'text',
					'required' => [ 'amp_top_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Top - Data Ad Client', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-client number ID (without ca-pub-).', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_top_single_adsense_slot',
					'type'     => 'text',
					'required' => [ 'amp_top_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Top - Data Ad Slot', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-slot number ID.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_top_single_adsense_size',
					'type'     => 'select',
					'required' => [ 'amp_top_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Top - Adsense Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a size for this ad.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Responsive --', 'gulir' ),
						'2' => esc_html__( 'Fixed Height (90px)', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_top_single_ad_code',
					'type'     => 'textarea',
					'rows'     => 2,
					'required' => [ 'amp_top_single_ad_type', '=', '2' ],
					'title'    => esc_html__( 'Top - AMP Custom Ad Script', 'gulir' ),
					'subtitle' => esc_html__( 'Input your AMP custom ad script.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'     => 'section_end_amp_top_single_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				/** bottom single */
				[
					'id'     => 'section_start_amp_bottom_single_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Bottom Single Content Ad', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_bottom_single_ad_type',
					'type'     => 'select',
					'title'    => esc_html__( 'Bottom - Ad Type', 'gulir' ),
					'subtitle' => esc_html__( 'Select your ad type to display at the bottom single content.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Adsense --', 'gulir' ),
						'2' => esc_html__( 'AMP Custom Script Ad', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_bottom_single_adsense_client',
					'type'     => 'text',
					'required' => [ 'amp_bottom_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Bottom - Data Ad Client', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-client number ID (without ca-pub-).', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_bottom_single_adsense_slot',
					'type'     => 'text',
					'required' => [ 'amp_bottom_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Bottom - Data Ad Slot', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-slot number ID.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_bottom_single_adsense_size',
					'type'     => 'select',
					'required' => [ 'amp_bottom_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Bottom - Adsense Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a size for this ad.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Responsive --', 'gulir' ),
						'2' => esc_html__( 'Fixed Height (90px)', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_bottom_single_ad_code',
					'type'     => 'textarea',
					'rows'     => 2,
					'required' => [ 'amp_bottom_single_ad_type', '=', '2' ],
					'title'    => esc_html__( 'Bottom - AMP Custom Ad Script', 'gulir' ),
					'subtitle' => esc_html__( 'Input your AMP custom ad script.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'     => 'section_end_amp_bottom_single_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_amp_inline_single_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Inline Single Content Ad', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'amp_inline_single_ad_type',
					'type'     => 'select',
					'title'    => esc_html__( 'Inline - Ad Type', 'gulir' ),
					'subtitle' => esc_html__( 'Select your ad type to display at the bottom single content.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Adsense --', 'gulir' ),
						'2' => esc_html__( 'AMP Custom Script Ad', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_inline_single_adsense_client',
					'type'     => 'text',
					'required' => [ 'amp_inline_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Inline - Data Ad Client', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-client number ID (without ca-pub-).', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_inline_single_adsense_slot',
					'type'     => 'text',
					'required' => [ 'amp_inline_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Inline - Data Ad Slot', 'gulir' ),
					'subtitle' => esc_html__( 'Input the data-ad-slot number ID.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'       => 'amp_inline_single_adsense_size',
					'type'     => 'select',
					'required' => [ 'amp_inline_single_ad_type', '=', '1' ],
					'title'    => esc_html__( 'Inline - Adsense Size', 'gulir' ),
					'subtitle' => esc_html__( 'Select a size for this ad.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( '-- Responsive --', 'gulir' ),
						'2' => esc_html__( 'Fixed Height (90px)', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'amp_inline_single_ad_code',
					'type'     => 'textarea',
					'rows'     => 2,
					'required' => [ 'amp_inline_single_ad_type', '=', '2' ],
					'title'    => esc_html__( 'Inline - AMP Custom Ad Script', 'gulir' ),
					'subtitle' => esc_html__( 'Input your AMP custom ad script.', 'gulir' ),
					'default'  => '',
				],
				[
					'id'          => 'amp_ad_single_positions',
					'type'        => 'text',
					'title'       => esc_html__( 'Display Positions', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a position (after x paragraphs) to display your ads.', 'gulir' ),
					'description' => esc_html__( 'Allow multiple positions, separated by commas. e.g. 4,9', 'gulir' ),
					'default'     => '4',
				],
				[
					'id'     => 'section_end_amp_inline_single_advert',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

