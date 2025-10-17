<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_membership' ) ) {
	function gulir_register_options_membership() {

		if ( ! class_exists( 'SimpleWpMembership' ) ) {
			return [
				'id'     => 'gulir_config_section_membership',
				'title'  => esc_html__( 'Membership', 'gulir-core' ),
				'desc'   => esc_html__( 'Customize styles and layout for the Simple WordPress Membership plugin.', 'gulir-core' ),
				'icon'   => 'el el-group',
				'fields' => [
					[
						'id'    => 'membership_install_warning',
						'type'  => 'info',
						'style' => 'warning',
						'desc'  => html_entity_decode( esc_html__( 'The Simple WordPress Membership Plugin is missing! Please install and activate the <a href="https://wordpress.org/plugins/simple-membership">Simple WordPress Membership</a> plugin to enable the settings.', 'gulir-core' ) ),
					],
				],
			];
		}

		return [
			'id'     => 'gulir_config_section_membership',
			'title'  => esc_html__( 'Membership', 'gulir-core' ),
			'desc'   => esc_html__( 'Customize styles and layout for the Simple WordPress Membership plugin.', 'gulir-core' ),
			'icon'   => 'el el-group',
			'fields' => [
				[
					'id'     => 'section_start_restrict_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Content Restrict for New Users', 'gulir-core' ),
					'indent' => true,
				],
				[
					'id'       => 'restrict_title',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Restrict Content Title', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your restrict content title, allow raw HTML.', 'gulir-core' ),
					'default'  => '<strong>Unlimited digital access</strong> to all our <span>Premium</span> contents',
				],
				[
					'id'       => 'restrict_desc',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Restrict Content Description', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your restrict content description, allow raw HTML.', 'gulir-core' ),
					'default'  => 'Plans starting at less than $9/month. <strong>Cancel anytime.</strong>',
				],
				[
					'id'       => 'join_us_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Join US Button Label', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input a join us button label.', 'gulir-core' ),
					'default'  => esc_html__( 'Get Digital All Access', 'gulir-core' ),
				],
				[
					'id'       => 'login_desc',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Login Description', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your login description.', 'gulir-core' ),
					'default'  => esc_html__( 'Already a subscriber?', 'gulir-core' ),
				],
				[
					'id'       => 'login_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Login Button Label', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input the login button label.', 'gulir-core' ),
					'default'  => esc_html__( 'Sign In', 'gulir-core' ),
				],
				[
					'id'     => 'section_end_restrict_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_restrict_level_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Content Restrict for Logged Users', 'gulir-core' ),
					'indent' => true,
				],
				[
					'id'       => 'restrict_level_title',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Upgrade Membership Title', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your upgrade membership level title, allow raw HTML.', 'gulir-core' ),
					'default'  => '<strong>Upgrade Your Plan</strong> for even <span>Greater</span> benefits.',
				],
				[
					'id'       => 'restrict_level_desc',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Upgrade Membership Description', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your upgrade membership level description, allow raw HTML.', 'gulir-core' ),
					'default'  => 'This content is not permitted for your membership level.',
				],
				[
					'id'     => 'section_end_restrict_level_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_restrict_renewal_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Content Restrict for Expired Users', 'gulir-core' ),
					'indent' => true,
				],
				[
					'id'       => 'restrict_renewal_title',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Renewal Membership Title', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your renewal membership title, allow raw HTML.', 'gulir-core' ),
					'default'  => '<strong>Renew account</strong> to access <span>Premium</span> contents',
				],
				[
					'id'       => 'restrict_renewal_desc',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Renewal Membership Description', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input your renewal membership description, allow raw HTML.', 'gulir-core' ),
					'default'  => 'Your membership plan has expired.',
				],
				[
					'id'       => 'renewal_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Renewal Button Label', 'gulir-core' ),
					'subtitle' => esc_html__( 'Input a renewal button label.', 'gulir-core' ),
					'default'  => esc_html__( 'Renewal Your MemberShip', 'gulir-core' ),
				],
				[
					'id'     => 'section_end_restrict_renewal_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],

				[
					'id'     => 'section_start_protected_title',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Exclusive Label', 'gulir-core' ),
					'indent' => true,
				],
				[
					'id'          => 'exclusive_label',
					'type'        => 'text',
					'title'       => esc_html__( 'Member Only Label', 'gulir-core' ),
					'subtitle'    => esc_html__( 'Input a Label for displaying before the post title listing.', 'gulir-core' ),
					'description' => esc_html__( 'Leave blank to disable the label.', 'gulir-core' ),
					'default'     => 'EXCLUSIVE',
				],
				[
					'id'       => 'exclusive_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Label Style', 'gulir-core' ),
					'subtitle' => esc_html__( 'Select a style for the member only label.', 'gulir-core' ),
					'options'  => [
						'0'      => esc_html__( 'Background Color', 'gulir-core' ),
						'border' => esc_html__( 'Border', 'gulir-core' ),
						'text'   => esc_html__( 'Text with Color', 'gulir-core' ),
					],
					'default'  => '0',
				],
				[
					'id'     => 'section_end_restrict_protected_title',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}
