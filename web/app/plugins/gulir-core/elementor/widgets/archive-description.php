<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_elementor_archive_description;
use function gulir_is_edit_mode;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Archive_Description extends Widget_Base {

	public function get_name() {

		return 'gulir-archive-description';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Archive Description', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-text';
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'archive', 'category', 'tag', 'description', 'taxonomy' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'style_section', [
				'label' => esc_html__( 'Style', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'template_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block is only used to build category, tag, search, taxonomy and archive templates. It displays the description based on the current page.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Description Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_dark_color',
			[
				'label'     => esc_html__( 'Dark Mode - Description Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => 'color: {{VALUE}};',
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
				'label'    => esc_html__( 'Description Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}}',
			]
		);
		$this->add_responsive_control(
			'excerpt_columns',
			[
				'label'       => esc_html__( 'Description Columns', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select the number of columns for displaying the description text. This is helpful when you have a lengthy description.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--excerpt-columns: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'excerpt_gap',
			[
				'label'     => esc_html__( 'Column Gap', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--excerpt-gap: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( gulir_is_edit_mode() ) {
			echo '<p class="taxonomy-description">' . esc_html__( 'Dynamic archive description will replaced width the real description after your assigned this template', 'gulir-core' ) . '</p>';
		} else {
			$settings = $this->get_settings();
			if ( function_exists( 'gulir_elementor_archive_description' ) ) {
				echo gulir_elementor_archive_description( $settings );
			}
		}
	}
}