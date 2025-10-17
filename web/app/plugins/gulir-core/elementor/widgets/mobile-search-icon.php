<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use function gulir_mobile_search_icon;

/**
 * Class Header_Mobile_Search
 *
 * @package gulirElementor\Widgets
 */
class Header_Mobile_Search extends Widget_Base {

	public function get_name() {

		return 'gulir-header-msearch';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Mobile Search Icon', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-menu-toggle';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'mobile', 'search', 'icon' ];
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
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'gulir_mobile_search_icon' ) ) {
			gulir_mobile_search_icon();
		}
	}
}