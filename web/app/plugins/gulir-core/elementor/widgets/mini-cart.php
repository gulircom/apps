<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_elementor_mini_cart;

/**
 * Class Mini_Cart
 *
 * @package gulirElementor\Widgets
 */
class Mini_Cart extends Widget_Base {

	public function get_name() {

		return 'gulir-mini-cart';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Mini Cart', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-bag-light';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'template', 'builder', 'shop', 'popup', 'product', 'woocommerce' ];
	}

	public function get_categories() {

		return [ 'gulir_header' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'style-section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'mini_cart_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block requests the Woocommerce plugin to work.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label'       => esc_html__( 'Icon Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom font size for the mini cart icon.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} i.wnav-icon, {{WRAPPER}} .cart-icon-svg' => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} span.wnav-svg'                           => 'width: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'icon_height',
			[
				'label'       => esc_html__( 'Icon Height', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a custom height value for the mini cart icon.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .cart-link' => 'height: {{VALUE}}px;' ],
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
				'selectors' => [ '{{WRAPPER}} .cart-link' => 'justify-content: {{VALUE}};' ],
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
			'icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the mini cart icon.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} i.wnav-icon, {{WRAPPER}} .cart-icon-svg' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'count_color',
			[
				'label'       => esc_html__( 'Dot Color', 'gulir-core' ),
				'description' => esc_html__( 'Choose the color for the dot that indicates the cart counter.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} .cart-counter' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_icon_color',
			[
				'label'       => esc_html__( 'Dark Mode - Icon Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'description' => esc_html__( 'Select a color for the mini cart icon in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} i.wnav-icon, [data-theme="dark"] {{WRAPPER}} .cart-icon-svg' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_count_color',
			[
				'label'       => esc_html__( 'Dark Mode - Dot Color', 'gulir-core' ),
				'description' => esc_html__( 'Choose the color for the dot that indicates the cart counter in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .cart-counter' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'dropdown-section', [
				'label' => esc_html__( 'Dropdown Section', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'form_position',
			[
				'label'       => esc_html__( 'Dropdown Right Position', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '-200',
				'description' => esc_html__( 'Input a right relative position for the mini cart dropdown, e.g. -200', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .header-dropdown' => 'right: {{VALUE}}px; left: auto;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .woocommerce-mini-cart-item a:not(.remove)',
			]
		);
		$this->add_control(
			'dropdown_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the mini cart dropdown.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-color: {{VALUE}};' ],
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
			'dark_dropdown_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the mini cart dropdown in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-color: {{VALUE}};' ],
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
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_elementor_mini_cart' ) ) {
			gulir_elementor_mini_cart( $this->get_settings() );
		}
	}
}