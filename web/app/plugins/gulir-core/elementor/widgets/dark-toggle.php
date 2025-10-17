<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use function gulir_dark_mode_switcher;

/**
 * Class Dark_Mode_Toggle
 *
 * @package gulirElementor\Widgets
 */
class Dark_Mode_Toggle extends Widget_Base {

	public function get_name() {

		return 'gulir-dark-mode-toggle';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Dark Mode Toggle', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-adjust';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'dark', 'template', 'builder', 'light', 'switcher' ];
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
			'icon_size',
			[
				'label'       => esc_html__( 'Switcher Size Scale', 'gulir-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Change dark mode switcher size.', 'gulir-core' ),
				'size_units'  => [ '%' ],
				'range'       => [
					'%' => [
						'min' => 50,
						'max' => 150,
					],
				],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'   => [
					'{{WRAPPER}}' => '--dm-size: calc(24px * {{SIZE}}/100);',
				],
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
				'selectors' => [ '{{WRAPPER}} .dark-mode-toggle' => 'justify-content: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'light-mode-section', [
				'label' => esc_html__( 'Switcher - Light Mode (Sun Icon)', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'light_color',
			[
				'label'       => esc_html__( 'Icon - Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the sun icon.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--dm-light-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'light_background',
			[
				'label'       => esc_html__( 'Icon - Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the sun icon.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--dm-light-bg: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'light_divider',
			[
				'label'       => esc_html__( 'Slide Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the slider in light mode.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--dm-slide: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'dark-mode-section', [
				'label' => esc_html__( 'Switcher - Dark Mode (Moon Icon)', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dark_text_color',
			[
				'label'       => esc_html__( 'Icon - Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the moon icon.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--dm-dark-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_color',
			[
				'label'       => esc_html__( 'Icon - Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the moon icon.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--dm-dark-bg: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_divider',
			[
				'label'       => esc_html__( 'Slide Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background for the slider in dark mode.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--dm-slide: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_dark_mode_switcher' ) ) {
			gulir_dark_mode_switcher();
		}
	}
}