<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_is_edit_mode;
use function gulir_single_content;
use function is_singular;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Content extends Widget_Base {

	public function get_name() {

		return 'gulir-single-content';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Post Content', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-post-content';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'content', 'data' ];
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
			'single_content_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Please navigate to "Theme Options > Single Post > Content Area" for further settings.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Tag/Source/Via Label Font', 'gulir-core' ),
				'name'     => 'tag_link_font',
				'selector' => '{{WRAPPER}} .blabel',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Tag/Source/Via Links Font', 'gulir-core' ),
				'name'     => 'tag_label_font',
				'selector' => '{{WRAPPER}} .efoot .h5',
			]
		);
		$this->add_control(
			'full_wide_support',
			[
				'label'        => esc_html__( 'Align Wide Image & Gallery Support', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'description'  => esc_html__( 'This setting helps the theme detect the sidebar\'s presence, allowing full-wide images to be displayed.', 'gulir-core' ),
				'options'      => [
					'wide-f' => esc_html__( 'Full-Wide (No Sidebar)', 'gulir-core' ),
					'wide-w' => esc_html__( 'Right Sidebar', 'gulir-core' ),
					'wide-n' => esc_html__( 'None', 'gulir-core' ),
				],
				'prefix_class' => 'yes-',
				'default'      => 'wide-f',
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
				'label'        => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'description'  => Options::color_scheme_description(),
				'options'      => [
					'default-scheme' => esc_html__( 'Default (Dark Text)', 'gulir-core' ),
					'light-scheme'   => esc_html__( 'Light Text', 'gulir-core' ),
				],
				'prefix_class' => 'elementor-widget-theme-post-content ',
				'default'      => 'default-scheme',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( gulir_is_edit_mode() || is_singular( 'rb-etemplate' ) ) {
			echo '<div class="s-content-placeholder">' . esc_html__( 'Dynamic post content', 'gulir-core' ) . '</div>';
		} else {
			if ( function_exists( 'gulir_single_content' ) ) {
				gulir_single_content();
			}
		}
	}

}