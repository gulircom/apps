<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_is_edit_mode;
use function gulir_single_comment;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Comment extends Widget_Base {

	public function get_name() {

		return 'gulir-single-comment';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Post Comments', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-comments';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'comment' ];
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
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Heading Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .comment-box-header > .h3',
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
				'prefix_class' => '',
				'default'      => 'default-scheme',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( gulir_is_edit_mode() ) {
			echo '<div class="s-comment-placeholder">' . esc_html__( 'Dynamic comments', 'gulir-core' ) . '</div>';
		} else {
			if ( function_exists( 'gulir_single_comment' ) ) {
				gulir_single_comment( true );
			}
		}
	}
}