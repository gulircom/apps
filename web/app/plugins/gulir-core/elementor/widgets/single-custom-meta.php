<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_elementor_custom_field_meta;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Custom_Meta extends Widget_Base {

	public function get_name() {

		return 'gulir-single-custom-meta';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Custom Field Meta', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-meta-data';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'meta' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section', [
				'label' => esc_html__( 'Custom Field Meta', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'meta_id',
			[
				'label'       => esc_html__( 'Custom Field ID/name', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
				'description' => esc_html__( 'Input your own custom field ID that created by any party plugin to display.', 'gulir-core' ),
				'placeholder' => esc_html__( 'filed_id', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'meta_label',
			[
				'label'       => esc_html__( 'Meta Tagline', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
				'description' => esc_html__( 'Input a tagline for this meta', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'meta_icon',
			[
				'label'            => esc_html__( 'Meta Icon', 'gulir-core' ),
				'type'             => Controls_Manager::ICONS,
				'description'      => esc_html__( 'Select an icon for this meta', 'gulir-core' ),
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);
		$this->add_control(
			'icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'begin' => esc_html__( 'Begin', 'gulir-core' ),
					'end'   => esc_html__( 'End', 'gulir-core' ),
				],
				'default' => 'begin',
			]
		);
		$this->add_control(
			'label_position',
			[
				'label'   => esc_html__( 'Tagline Position', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'begin' => esc_html__( 'Begin', 'gulir-core' ),
					'end'   => esc_html__( 'End', 'gulir-core' ),
				],
				'default' => 'end',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'meta_style_section', [
				'label' => esc_html__( 'for Meta', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Meta Font', 'gulir-core' ),
				'name'     => 'meta_font',
				'selector' => '{{WRAPPER}}',
			]
		);
		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--meta-fcolor: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_meta_color',
			[
				'label'     => esc_html__( 'Dark Mode - Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--meta-fcolor: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'meta_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--meta-spacing: {{VALUE}}px;' ],
				'default'   => '',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'meta_label_section', [
				'label' => esc_html__( 'for Tagline', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Tagline Font', 'gulir-core' ),
				'name'     => 'meta_label_font',
				'selector' => '{{WRAPPER}} .meta-tagline',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'icon_style_section', [
				'label' => esc_html__( 'for Icon', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Font Size', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--meta-icon-size: {{VALUE}}px;' ],
				'default'   => '',
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--meta-icon-color: {{VALUE}};' ],
				'default'   => '',
			]
		);
		$this->add_control(
			'dark_icon_color',
			[
				'label'     => esc_html__( 'Dark Mode - Icon Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--meta-icon-color: {{VALUE}};' ],
				'default'   => '',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings = $this->get_settings();
		gulir_elementor_custom_field_meta( $settings );
	}
}