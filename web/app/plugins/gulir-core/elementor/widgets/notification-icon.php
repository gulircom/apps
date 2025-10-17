<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use function gulir_header_notification;

/**
 * Class Header_Notification
 *
 * @package gulirElementor\Widgets
 */
class Header_Notification extends Widget_Base {

	public function get_name() {

		return 'gulir-notification-icon';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Notification Icon', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-info-circle-o';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'template', 'builder', 'notification', 'push' ];
	}

	public function get_categories() {

		return [ 'gulir_header' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general-section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'header_notification_url',
			[
				'label'       => esc_html__( 'Destination Link', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a destination URL for the notification panel.', 'gulir-core' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style-section', [
				'label' => esc_html__( 'Style', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label'       => esc_html__( 'Icon Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the notification icon.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} i.wnav-icon, {{WRAPPER}} .notification-icon-svg' => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} span.wnav-svg'                                   => 'width: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'icon_height',
			[
				'label'       => esc_html__( 'Icon Height', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the notification icon.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .notification-icon-inner' => 'min-height: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'align', [
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-align-start-h',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-align-center-h',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-align-end-h',
					],
				],
				'selectors' => [ '{{WRAPPER}} .notification-icon' => 'justify-content: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color-section', [
				'label' => esc_html__( 'Colors', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color',
			[
				'label'       => esc_html__( 'Icon Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the notification icon.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} i.wnav-icon, {{WRAPPER}} .notification-icon-svg' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_color',
			[
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the notification icon in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} i.wnav-icon, [data-theme="dark"] {{WRAPPER}} .notification-icon-svg' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'notification_color',
			[
				'label'       => esc_html__( 'Notification Dot', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the notification dot icon.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} .notification-info' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dropdown-section', [
				'label' => esc_html__( 'Dropdown', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'form_position',
			[
				'label'       => esc_html__( 'Dropdown Right Position', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '-200',
				'description' => esc_html__( 'Input the right relative position (in px) for the notification dropdown, e.g., -200.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ],
			]
		);
		$this->add_responsive_control(
			'dropdown_width',
			[
				'label'       => esc_html__( 'Dropdown Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input the width values for the dropdown section.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--dropdown-w: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'popup_text_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text in the popup form.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}}' => '--subnav-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'bg_from',
			[
				'label'       => esc_html__( 'Background Gradient (From)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'bg_to',
			[
				'label'       => esc_html__( 'Background Gradient (To)', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-bg-to: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'popup_dark_text_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the text in the popup form.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [
					'[data-theme="dark"] {{WRAPPER}}' => '--subnav-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'dark_bg_from',
			[
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the dropdown section in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_bg_to',
			[
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the dropdown section in dark mode.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg-to: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'header_notification_scheme',
			[
				'label'       => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select color scheme for the search form to fit with your background.', 'gulir-core' ),
				'options'     => [
					'0' => esc_html__( 'Default (Dark Text)', 'gulir-core' ),
					'1' => esc_html__( 'Light Text', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'gulir_header_notification' ) ) {
			gulir_header_notification( $this->get_settings() );
		}
	}
}