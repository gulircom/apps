<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_is_edit_mode;
use function gulir_single_footer;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Related extends Widget_Base {

	public function get_name() {

		return 'gulir-single-related';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Post Related', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-archive-posts';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'related', 'list' ];
	}

	public function get_categories() {

		return [ 'gulir_single' ];
	}

	protected function register_controls() {

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

	/**
	 * render layout
	 */
	protected function render() {

		if ( gulir_is_edit_mode() ) {
			echo '<div class="s-related-placeholder">' . esc_html__( 'Dynamic post related section', 'gulir-core' ) . '</div>';
		} else {
			if ( function_exists( 'gulir_single_footer' ) ) {
				gulir_single_footer( true );
			}
		}
	}

}