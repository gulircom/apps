<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_header_user;

class Header_Login_Icon extends Widget_Base {

	public function get_name() {

		return 'gulir-login-icon';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Login Link Trigger Button', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-exit';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'template', 'builder', 'user', 'popup', 'login', 'register' ];
	}

	public function get_categories() {

		return [ 'gulir_header' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'layout_section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'login_settings_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'NOTE: This block requires additional configuration for popup login form and the creation of a login page. Please navigate to "Theme Options > Login".', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'frontend_login_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'To build the frontend login and register pages, you can use the "Gulir - Login Form" and "Gulir - Register Form" blocks.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'login_logged_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'The block will show a welcome message for the logged-in user.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'header_login_layout',
			[
				'label'       => esc_html__( 'Sign In Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose how the sign-in button should appear. Options include:', 'gulir-core' ),
				'options'     => [
					'0' => esc_html__( 'Icon Only', 'gulir-core' ),
					'1' => esc_html__( 'Text Button', 'gulir-core' ),
					'2' => esc_html__( 'Text with Icon', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_control(
			'label_text',
			[
				'label'       => esc_html__( 'Login Label', 'gulir-core' ),
				'description' => esc_html__( 'Enter the text label for the button when "Text Button" or "Text with Icon" is selected. Leave blank for the default label.', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'default'     => '',
				'rows'        => 1,
			]
		);
		$this->add_control(
			'login_icon',
			[
				'label'       => esc_html__( 'Custom Login Icon (SVG Attachment)', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Override default login icon with a SVG icon, Input the file URL of your svg icon.', 'gulir-core' ),
				'placeholder' => esc_html__( 'https://yourdomain.com/wp-content/uploads/....filename.svg', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .login-icon-svg' => 'mask-image: url({{VALUE}}); -webkit-mask-image: url({{VALUE}}); background-image: none;',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style-section', [
				'label' => esc_html__( 'Icon', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the login icon.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} .login-toggle i, {{WRAPPER}} .login-toggle .login-icon-svg' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_icon_color',
			[
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the login icon in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .login-toggle i, [data-theme="dark"] {{WRAPPER}} .login-toggle .login-icon-svg' => 'color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'text-button-section', [
				'label' => esc_html__( 'Text Button', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button-style-info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'The settings below will apply to the "Text Button" and "Text with Icon" sign-in layouts.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->start_controls_tabs( 'btn_style_tabs' );
		$this->start_controls_tab( 'btn_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);
		$this->add_control(
			'text_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text on the login button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .login-toggle' => '--btn-accent : {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_bg',
			[
				'label'       => esc_html__( 'Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .login-toggle' => '--btn-primary: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_text_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'description' => esc_html__( 'Select a color for the text login button.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .login-toggle' => '--btn-accent : {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_button_bg',
			[
				'label'       => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the login button in dark mode.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .login-toggle' => '--btn-primary: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'btn_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);
		$this->add_control(
			'text_hover_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text on the login button when hovering.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .login-toggle' => '--btn-accent-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_hover_bg',
			[
				'label'       => esc_html__( 'Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the button when hovering.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .login-toggle' => '--btn-primary-h: {{VALUE}}; --btn-primary-h-90: {{VALUE}}e6;' ],
			]
		);
		$this->add_control(
			'dark_hover_text_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text login button when hovering.', 'gulir-core' ),
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .login-toggle' => '--btn-accent-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_button_hover_bg',
			[
				'label'       => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the login button in dark mode when hovering.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .login-toggle' => '--btn-primary-h: {{VALUE}}; --btn-primary-h-90: {{VALUE}}e6;' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_border',
			[
				'label'       => esc_html__( 'Button Border', 'gulir-core' ),
				'description' => esc_html__( 'Enable or disable the border for the login button.', 'gulir-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'separator'   => 'before',
				'selectors'   => [ '{{WRAPPER}} .login-toggle.is-btn' => 'border: 1px solid var(--usr-btn-border, currentColor)' ],
			]
		);

		$this->start_controls_tabs( 'btn_border_tabs' );
		$this->start_controls_tab( 'btn_border_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);
		$this->add_control(
			'border_color',
			[
				'label'       => esc_html__( 'Border Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the button border.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--usr-btn-border: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'border_color_dark',
			[
				'label'       => esc_html__( 'Dark Mode - Border Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the button border in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--usr-btn-border: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'btn_border_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);
		$this->add_control(
			'border_hover_color',
			[
				'label'       => esc_html__( 'Border Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the button border when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .login-toggle:hover' => '--usr-btn-border: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'border_hover_color_dark',
			[
				'label'       => esc_html__( 'Dark Mode - Border Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the button border in dark mode when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .login-toggle:hover' => '--usr-btn-border: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'dimension-section', [
				'label' => esc_html__( 'Font & Dimensions', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'       => esc_html__( 'Text Label Font', 'gulir-core' ),
				'description' => esc_html__( 'Choose the font style and size for the button text label.', 'gulir-core' ),
				'name'        => 'button_font',
				'selector'    => '{{WRAPPER}} .login-toggle.header-element span',
			]
		);
		$this->add_control(
			'size',
			[
				'label'       => esc_html__( 'Icon Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify the size of the login icon in pixels. This will adjust both the width and height of the icon as well as the font size of the text label and line height of the link.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .login-toggle.header-element svg'                                          => 'width: {{VALUE}}px; height: {{VALUE}}px;',
					'{{WRAPPER}} .login-toggle.header-element .login-icon-svg, {{WRAPPER}} .login-toggle i' => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} a.is-logged'                                                               => 'line-height: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'icon_height',
			[
				'label'       => esc_html__( 'Height', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the login icon/button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .login-toggle' => 'line-height: {{VALUE}}px; height: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'padding',
			[
				'label'       => esc_html__( 'Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom left right padding for the login icon/button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .login-toggle' => '--login-btn-padding: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'icon_spacing',
			[
				'label'       => esc_html__( 'Icon Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set the custom spacing between the icon and the text label.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--icon-gap: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--round-3: {{VALUE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'align', [
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-align-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-align-center-h',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-align-end-h',
					],
				],
				'selectors' => [ '{{WRAPPER}} .widget-h-login' => 'text-align: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dropdown-section', [
				'label' => esc_html__( 'When Logged', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'logged_menu_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'NOTE: To configure the user dropdown menu, please go to "Theme Options > Header > Sign In Buttons > User Dashboard Menu".', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'logged_gravatar',
			[
				'label'       => esc_html__( 'Gravatar Icon', 'gulir-core' ),
				'description' => esc_html__( 'Display the user Gravatar in the welcome label.', 'gulir-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
			]
		);
		$this->add_control(
			'gravatar_size',
			[
				'label'       => esc_html__( 'Gravatar Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Specify the size of the Gravatar icon in pixels.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--user-isize: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'logged_size',
			[
				'label'       => esc_html__( 'Welcome Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for welcome text.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .logged-welcome' => 'font-size: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'username_width',
			[
				'label'       => esc_html__( 'Max Username Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '120',
				'description' => esc_html__( 'Limit the username width (in px) to keep the block within a small width in the header.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--uname-width: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'logged_color',
			[
				'label'       => esc_html__( 'Welcome Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the welcome text. The white color will be applied for dark mode.', 'gulir-core' ),
				'selectors'   => [
					'body:not([data-theme="dark"]) {{WRAPPER}} .logged-welcome' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'form_position',
			[
				'label'       => esc_html__( 'Dropdown Right Position', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '-50',
				'description' => esc_html__( 'Input a right relative position for the logged dropdown, e.g. -50', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ],
			]
		);

		$this->start_controls_tabs( 'dropdown_style_tabs' );
		$this->start_controls_tab( 'dropdown_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);

		$this->add_control(
			'dropdown_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .user-dropdown a' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'bg_from',
			[
				'label'       => esc_html__( 'Background Gradient (From)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'bg_to',
			[
				'label'       => esc_html__( 'Background Gradient (To)', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_dropdown_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .user-dropdown a' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_bg_from',
			[
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_bg_to',
			[
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section in dark mode.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .header-dropdown' => '--subnav-bg-to: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'dropdown_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);
		$this->add_control(
			'hover_dropdown_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .user-dropdown a:hover' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_hover_dropdown_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the logged dropdown when hovering in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .user-dropdown a:hover' => 'color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		if ( function_exists( 'gulir_header_user' ) ) {
			gulir_header_user( $settings );
		}
	}
}