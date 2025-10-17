<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_elementor_single_featured;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Single_Featured extends Widget_Base {

	public function get_name() {

		return 'gulir-single-featured';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Post Featured Image', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-featured-image';
	}

	public function get_keywords() {

		return [ 'single', 'template', 'builder', 'image' ];
	}

	public function get_categories() {

		return [ 'gulir_single' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'image_section', [
				'label' => esc_html__( 'for Standard Format', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'crop_size',
			[
				'label'       => esc_html__( 'Featured Image Size', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::crop_size(),
				'options'     => Options::crop_size_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'image_ratio', [
				'label'       => esc_html__( 'Image Ratio', 'gulir-core' ),
				'description' => esc_html__( 'The image size will be based on your dimensions. Input a custom ratio if you want to specify the exact height.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--image-ratio: {{VALUE}}%;' ],
			]
		);
		$this->add_control(
			'feat_align',
			[
				'label'       => esc_html__( 'Featured Align', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Align the featured image for a single post. This setting will apply when you set a custom ratio.', 'gulir-core' ),
				'options'     => [
					''       => esc_html__( '- Default -', 'gulir-core' ),
					'top'    => esc_html__( 'Top', 'gulir-core' ),
					'bottom' => esc_html__( 'Bottom', 'gulir-core' ),
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}}' => '--feat-position: center {{VALUE}};',
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
		$this->end_controls_section();
		$this->start_controls_section(
			'gallery_section', [
				'label' => esc_html__( 'for Gallery Format', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'gallery_layout',
			[
				'label'       => esc_html__( 'Gallery Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a layout for the featured gallery.', 'gulir-core' ),
				'options'     => [
					'gallery_1' => esc_html__( 'Layout 1 (Slider)', 'gulir-core' ),
					'gallery_2' => esc_html__( 'Layout 2 (Carousel)', 'gulir-core' ),
					'gallery_3' => esc_html__( 'Layout 3 (Coverflow)', 'gulir-core' ),
				],
				'default'     => 'gallery_1',
			]
		);
		$this->add_control(
			'gallery_crop_size',
			[
				'label'       => esc_html__( 'Gallery Image Size', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::crop_size(),
				'options'     => Options::crop_size_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'gallery_ratio', [
				'label'       => esc_html__( 'Gallery Images Ratio', 'gulir-core' ),
				'description' => esc_html__( 'Input a custom ratio if you want to specify the image height for the gallery. The value will be percent of the device height (vh) if you select carousel layout 2.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--sg-ratio: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'video_section', [
				'label' => esc_html__( 'for Video Format', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'video_ratio', [
				'label'       => esc_html__( 'Video Iframe Ratio', 'gulir-core' ),
				'description' => esc_html__( 'Input custom ratio for iframe if the post format is video.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--video-ratio: {{VALUE}}%;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'audio_section', [
				'label' => esc_html__( 'for Audio Format', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'audio_ratio', [
				'label'       => esc_html__( 'Audio Iframe Ratio', 'gulir-core' ),
				'description' => esc_html__( 'Input custom ratio for iframe if the post format is audio.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--audio-ratio: {{VALUE}}%;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'caption_section', [
				'label' => esc_html__( 'Caption Text', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [ '{{WRAPPER}}' => '--meta-b-fcolor: {{VALUE}}; --ecat-highlight: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'caption_dark_color',
			[
				'label'     => esc_html__( 'Dark Mode - Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--meta-b-fcolor: {{VALUE}}; --ecat-highlight: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'caption_align',
			[
				'label'        => esc_html__( 'Alignment', 'gulir-core' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'prefix_class' => 'yes-cap-',
				'default'      => '',
			]
		);
		$this->add_control(
			'caption_line',
			[
				'label'   => esc_html__( 'Solid Line', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::switch_dropdown( false ),
				'default' => '1',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Caption Font', 'gulir-core' ),
				'name'     => 'caption_font',
				'selector' => '{{WRAPPER}} .caption-text',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'border_section', [
				'label' => esc_html__( 'Border Radius', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'box_border',
			[
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'description' => esc_html__( 'Input custom border radius for featured image.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--round-5: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		gulir_elementor_single_featured( $this->get_settings() );
	}

}