<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_is_edit_mode;
use function gulir_render_register_link;
use function gulir_render_register_link_edit_mode;

class Header_Register_Link extends Widget_Base {

	public function get_name() {

		return 'gulir-register-link';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Register Link Button', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-h-align-right';
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
				'raw'             => esc_html__( 'NOTE: This block requests configuration for register URL and the creation of a register page. Please navigate to "Theme Options > Login".', 'gulir-core' ),
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
				'raw'             => esc_html__( 'Tips: Navigate to "Settings > General > Membership" to enable registration for your website. The block will disable the logged-in user.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'label_text',
			[
				'label'       => esc_html__( 'Register Label', 'gulir-core' ),
				'description' => esc_html__( 'To configure the destination of this block, navigate to "Theme Options > Login > Custom Register Page URL".', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'default'     => 'Sign Up',
				'rows'        => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'text-button-section', [
				'label' => esc_html__( 'Style', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( 'button_style_tabs' );
		$this->start_controls_tab( 'normal_tab',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);
		$this->add_control(
			'text_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text register button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--btn-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_bg',
			[
				'label'       => esc_html__( 'Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--btn-primary: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_text_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the text register button.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--btn-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_button_bg',
			[
				'label'       => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color for the register button in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--btn-primary: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'hover_tab',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);
		$this->add_control(
			'text_hover_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text register button when hovering.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--btn-accent-h: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'button_hover_bg',
			[
				'label'       => esc_html__( 'Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the button when hovering.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--btn-primary-h: {{VALUE}}; --btn-primary-h-90: {{VALUE}}e6;' ],
			]
		);

		$this->add_control(
			'dark_text_hover_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the text register button when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--btn-accent-h: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'dark_button_hover_bg',
			[
				'label'       => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color for the register button in dark mode when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--btn-primary-h: {{VALUE}}; --btn-primary-h-90: {{VALUE}}e6;' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'button-border-section', [
				'label' => esc_html__( 'Border', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_border',
			[
				'label'       => esc_html__( 'Button Border', 'gulir-core' ),
				'description' => esc_html__( 'Enable or disable the border for the register link button.', 'gulir-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'selectors'   => [ '{{WRAPPER}} .reg-link.is-btn' => 'border: 1px solid var(--usr-btn-border, currentColor)' ],
			]
		);
		$this->start_controls_tabs( 'border_style_tabs' );
		$this->start_controls_tab( 'border_normal_tab',
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
				'default'     => '',
			]
		);
		$this->add_control(
			'border_color_dark',
			[
				'label'       => esc_html__( 'Dark Mode - Border Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the button border in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--usr-btn-border: {{VALUE}};' ],
				'default'     => '',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'border_hover_tab',
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
				'selectors'   => [ '{{WRAPPER}} .reg-link:hover' => '--usr-btn-border: {{VALUE}};' ],
				'default'     => '',
			]
		);

		$this->add_control(
			'border_hover_color_dark',
			[
				'label'       => esc_html__( 'Dark Mode - Border Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the button border in dark mode when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .reg-link:hover' => '--usr-btn-border: {{VALUE}};' ],
				'default'     => '',
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
				'selector'    => '{{WRAPPER}} .reg-link span',
			]
		);
		$this->add_control(
			'icon_height',
			[
				'label'       => esc_html__( 'Height', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the register icon/button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .reg-link' => 'line-height: {{VALUE}}px; height: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'padding',
			[
				'label'       => esc_html__( 'Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom left right padding for the register icon/button.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .reg-link' => '--login-btn-padding: {{VALUE}}px;' ],
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
	}

	protected function render() {

		$settings = $this->get_settings();

		if ( gulir_is_edit_mode() ) {
			gulir_render_register_link_edit_mode( $settings );
		} else {
			gulir_render_register_link( $settings );
		}
	}
}