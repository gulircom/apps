<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_newsletter' ) ) {
	function gulir_register_options_newsletter() {

		return [
			'id'     => 'gulir_theme_ops_section_subscribe',
			'title'  => esc_html__( 'Popup Newsletter', 'gulir' ),
			'desc'   => esc_html__( 'Customize the popup newsletter.', 'gulir' ),
			'icon'   => 'el el-envelope',
			'fields' => [
				[
					'id'       => 'newsletter_popup',
					'type'     => 'select',
					'title'    => esc_html__( 'Popup Newsletter', 'gulir' ),
					'subtitle' => esc_html__( 'Choose whether to enable or disable the popup newsletter.', 'gulir' ),
					'options'  => [
						'0' => esc_html__( 'Disable', 'gulir' ),
						'1' => esc_html__( 'Center Popup', 'gulir' ),
						'2' => esc_html__( 'Fixed Right', 'gulir' ),
					],
					'default'  => '0',
				],
				[
					'id'       => 'newsletter_title',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Title', 'gulir' ),
					'subtitle' => esc_html__( 'Input title for the popup newsletter form', 'gulir' ),
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => esc_html__( 'Join Us!', 'gulir' ),
				],
				[
					'id'       => 'newsletter_description',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Description', 'gulir' ),
					'subtitle' => esc_html__( 'Input description for the popup newsletter form', 'gulir' ),
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => esc_html__( 'Subscribe to our newsletter and never miss our latest news, podcasts etc.', 'gulir' ),
				],
				[
					'id'       => 'newsletter_shortcode',
					'type'     => 'text',
					'title'    => esc_html__( 'Newsletter Shortcode', 'gulir' ),
					'subtitle' => esc_html__( 'Input a newsletter shortcode.', 'gulir' ),
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => '[mc4wp_form]',
				],
				[
					'id'       => 'newsletter_footer',
					'type'     => 'text',
					'title'    => esc_html__( 'Footer Text', 'gulir' ),
					'subtitle' => esc_html__( 'Input a footer text for the box.', 'gulir' ),
					'default'  => esc_html__( 'Zero spam, Unsubscribe at any time.', 'gulir' ),
					'required' => [ 'newsletter_popup', '!=', 0 ],
				],
				[
					'id'       => 'newsletter_footer_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Footer URL', 'gulir' ),
					'subtitle' => esc_html__( 'Add a link for the footer text (optional).', 'gulir' ),
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => '',
				],
				[
					'id'          => 'newsletter_cover',
					'title'       => esc_html__( 'Cover Image', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a cover image for the box.', 'gulir' ),
					'description' => esc_html__( 'It is recommended to use a dark image to ensure sufficient text contrast when selecting the FIXED RIGHT position.', 'gulir' ),
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'required'    => [ 'newsletter_popup', '!=', 0 ],
				],
				[
					'id'          => 'newsletter_popup_expired',
					'type'        => 'select',
					'title'       => esc_html__( 'Popup Expiration', 'gulir' ),
					'subtitle'    => esc_html__( 'Set how long to wait before showing the popup again after a visitor closes it.', 'gulir' ),
					'description' => esc_html__( 'The "Immediately (for Preview)" option should be used only for previewing the settings.', 'gulir' ),
					'options'     => [
						'1'  => esc_html__( '1 Day', 'gulir' ),
						'2'  => esc_html__( '2 Days', 'gulir' ),
						'3'  => esc_html__( '3 Days', 'gulir' ),
						'7'  => esc_html__( '1 Week', 'gulir' ),
						'14' => esc_html__( '2 Weeks', 'gulir' ),
						'21' => esc_html__( '3 Weeks', 'gulir' ),
						'30' => esc_html__( '1 Month', 'gulir' ),
						'0'  => esc_html__( 'Immediately (for Preview)', 'gulir' ),
					],
					'required'    => [ 'newsletter_popup', '!=', 0 ],
					'default'     => '1',
				],
				[
					'id'       => 'newsletter_popup_display',
					'type'     => 'select',
					'title'    => esc_html__( 'Display Mode', 'gulir' ),
					'subtitle' => esc_html__( 'Select a mode to display the newsletter popup.', 'gulir' ),
					'options'  => [
						'scroll' => esc_html__( 'Scroll Distance', 'gulir' ),
						'time'   => esc_html__( 'Time Delay', 'gulir' ),
					],
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => 'scroll',
				],
				[
					'id'       => 'newsletter_popup_offset',
					'type'     => 'text',
					'title'    => esc_html__( 'Distance of Scroll', 'gulir' ),
					'subtitle' => esc_html__( 'This option use for "Scroll Distance" mode. Input a distance value (in pixels) when visitor scrolling down to show the popup.', 'gulir' ),
					'class'    => 'small',
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => '2000',
				],
				[
					'id'       => 'newsletter_popup_delay',
					'type'     => 'text',
					'title'    => esc_html__( 'Delay Time', 'gulir' ),
					'subtitle' => esc_html__( 'This option use for "Time Delay" mode. Input a delay time (ms) value to show the popup after the site loaded.', 'gulir' ),
					'class'    => 'small',
					'required' => [ 'newsletter_popup', '!=', 0 ],
					'default'  => '',
				],
			],
		];
	}
}