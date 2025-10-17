<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_ad_image;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Ad_Image extends Widget_Base {

	public function get_name() {

		return 'gulir-ad-image';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Ad Image', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-image-rollover';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'advert', 'image', 'promotion' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a description for this adverting box.', 'gulir-core' ),
				'default'     => esc_html__( '- Advertisement -', 'gulir-core' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label'       => esc_html__( 'Ad Image', 'gulir-core' ),
				'description' => esc_html__( 'Upload your ad image.', 'gulir-core' ),
				'type'        => Controls_Manager::MEDIA,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'dark_image',
			[
				'label'       => esc_html__( 'Dark Mode - Ad Image', 'gulir-core' ),
				'description' => esc_html__( 'Upload your ad image in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::MEDIA,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'destination',
			[
				'label'       => esc_html__( 'Ad Destination', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
				'description' => esc_html__( 'Input your ad destination URL.', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'image_width_section', [
				'label' => esc_html__( 'Image', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'image_width',
			[
				'label'       => esc_html__( 'Image Max Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a max width value (in px) for your ad image, leave blank set full size.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--am-width: {{VALUE}}px',
				],
			]
		);
		$this->add_control(
			'feat_lazyload',
			[
				'label'       => esc_html__( 'Lazy Load', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::feat_lazyload_description(),
				'options'     => Options::feat_lazyload_simple_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'box_border',
			[
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}}' => '--round-5: {{VALUE}}px',
				],
			]
		);
		$this->add_responsive_control(
			'description_size',
			[
				'label'     => esc_html__( 'Description Size', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}}' => '--meta-fsize: {{VALUE}}px',
				],
			]
		);
		$this->add_control(
			'color',
			[
				'label'     => esc_html__( 'Description Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--meta-fcolor: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_color',
			[
				'label'     => esc_html__( 'Dark Mode - Description Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--meta-fcolor: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_get_ad_image' ) ) {
			$settings               = $this->get_settings();
			$settings['uuid']       = 'uid_' . $this->get_id();
			$settings['no_spacing'] = true;

			if ( ! empty( $settings['image']['id'] ) ) {
				$medata = wp_get_attachment_metadata( $settings['image']['id'] );
				if ( ! empty( $medata['width'] ) && ! empty( $medata['height'] ) ) {
					$settings['image']['width']  = $medata['width'];
					$settings['image']['height'] = $medata['height'];
				}
			}
			echo gulir_get_ad_image( $settings );
		}
	}
}