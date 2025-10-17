<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_is_edit_mode;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Tagline extends Widget_Base {

	public function get_name() {

		return 'gulir-single-tagline';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Post Tagline', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-text';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'title', 'subtitle', 'tagline' ];
	}

	public function get_categories() {

		return [ 'gulir_single' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'style_section', [
				'label' => esc_html__( 'Style', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Tagline Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--tagline-fcolor: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_dark_color',
			[
				'label'     => esc_html__( 'Dark Mode - Tagline Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--tagline-fcolor: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_align',
			[
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'gulir-core' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [ '{{WRAPPER}}' => 'text-align: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Tagline Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .s-tagline',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( gulir_is_edit_mode() ) {
			echo '<h3 class="s-tagline">' . esc_html__( 'Dynamic post tagline will replaced width the real tagline after your assigned this template', 'gulir-core' ) . '</h3>';
		} else {
			if ( function_exists( 'gulir_single_tagline' ) ) {
				gulir_single_tagline();
			}
		}
	}

}