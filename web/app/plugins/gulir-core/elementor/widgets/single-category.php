<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_elementor_single_category;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Category extends Widget_Base {

	public function get_name() {

		return 'gulir-single-category';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Entry Category', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-post-info';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'meta' ];
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
			'entry_category',
			[
				'label'       => esc_html__( 'Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::entry_category_description(),
				'options'     => Options::extended_entry_category_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'entry_tax',
			[
				'label'       => esc_html__( 'Replace Category by Taxonomy', 'gulir-core' ),
				'description' => Options::post_type_tax_info_description(),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::taxonomy_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'category_align',
			[
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => '',
				'selectors' => [ '{{WRAPPER}} .p-categories' => 'justify-content: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Custom Entry Category Font', 'gulir-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .p-categories',
			]
		);
		$this->add_control(
			'hide_category',
			[
				'label'       => esc_html__( 'Hide Entry Category', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_category_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			]
		);
		$this->add_control(
			'primary_category',
			[
				'label'       => esc_html__( 'Primary Category', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Show primary category only', 'gulir-core' ),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color_section', [
				'label' => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_scheme',
			[
				'label'       => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::color_scheme_description(),
				'options'     => [
					'0' => esc_html__( 'Default (Dark Text)', 'gulir-core' ),
					'1' => esc_html__( 'Light Text', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings = $this->get_settings();
		gulir_elementor_single_category( $settings );
	}

}