<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_mobile_toggle_btn;

/**
 * Class Header_Collapse_Toggle
 *
 * @package gulirElementor\Widgets
 */
class Header_Collapse_Toggle extends Widget_Base {

	public function get_name() {

		return 'gulir-collapse-toggle';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Mobile Collapse Toggle', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-menu-toggle';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'mobile', 'toggle', 'collapse', 'button' ];
	}

	public function get_categories() {

		return [ 'gulir_header' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'search-icon-section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'toggle_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'PLEASE NOTE: This block is intended exclusively for the mobile header template.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'toggle_color',
			[
				'label'     => esc_html__( 'Toggle Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--mbnav-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_toggle_color',
			[
				'label'     => esc_html__( 'Dark Mode - Toggle Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--mbnav-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'gulir_mobile_toggle_btn' ) ) {
			gulir_mobile_toggle_btn();
		}
	}
}