<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function rb_sidebar_banner;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Banner extends Widget_Base {

	public function get_name() {

		return 'gulir-banner';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Sidebar Banner', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-button';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'advert', 'intro', 'promotion' ];
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Input a title for this banner.', 'gulir-core' ),
				'default'     => 'Your banner title...',
			]
		);
		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Input a description for this banner.', 'gulir-core' ),
				'default'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			]
		);
		$this->add_control(
			'url',
			[
				'label'   => esc_html__( 'Button Destination URL', 'gulir-core' ),
				'type'    => Controls_Manager::TEXT,
				'ai'      => [ 'active' => false ],
				'default' => '#',
			]
		);
		$this->add_control(
			'submit',
			[
				'label'   => esc_html__( 'Button Label', 'gulir-core' ),
				'type'    => Controls_Manager::TEXT,
				'ai'      => [ 'active' => false ],
				'default' => 'Learn More',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_section', [
				'label' => esc_html__( 'Content', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'padding',
			[
				'label'       => esc_html__( 'Inner Padding', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Input a custom inner padding value this block.', 'gulir-core' ),
				'size_units'  => [ 'px', 'em', '%' ],
				'selectors'   => [
					'{{WRAPPER}} .w-banner'         => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .w-banner-content' => 'min-height: auto',
				],
			]
		);
		$this->add_responsive_control(
			'banner_align',
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
				'selectors' => [
					'{{WRAPPER}}' => '--banner-align: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'title_size',
			[
				'label'       => esc_html__( 'Title Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the title.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .w-banner-title' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_responsive_control(
			'desc_size',
			[
				'label'       => esc_html__( 'Description Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the description.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .w-banner-desc.element-desc' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .w-banner-title',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Description Font', 'gulir-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .w-banner-desc.element-desc',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'button_section', [
				'label' => esc_html__( 'Button', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_width',
			[
				'label'        => esc_html__( 'Button Width', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'inline' => esc_html__( '- Default -', 'gulir-core' ),
					'fw'     => esc_html__( 'Full Width', 'gulir-core' ),
				],
				'prefix_class' => 'btn-',
				'default'      => 'inline',
			]
		);
		$this->add_control(
			'button_border',
			[
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--btn-round: {{VALUE}}px;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Button Font', 'gulir-core' ),
				'name'     => 'button_font',
				'selector' => '{{WRAPPER}} .banner-btn',
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label'     => esc_html__( 'Top Margin', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--btn-top-spacing: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--btn-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_bg',
			[
				'label'     => esc_html__( 'Background Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--btn-bg: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_button_color',
			[
				'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'separator' => 'before',
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--btn-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_button_bg',
			[
				'label'     => esc_html__( 'Dark Mode - Background Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--btn-bg: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'background_section', [
				'label' => esc_html__( 'Cover Background', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'e_image',
			[
				'label'       => esc_html__( 'Background Image URL', 'gulir-core' ),
				'description' => esc_html__( 'Upload a cover background for this block.', 'gulir-core' ),
				'type'        => Controls_Manager::MEDIA,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'e_dark_image',
			[
				'label'       => esc_html__( 'Dark Mode - Background Image URL', 'gulir-core' ),
				'description' => esc_html__( 'Upload a cover background for this block in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::MEDIA,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'e_image_border',
			[
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--round-5: {{VALUE}}px;',
				],
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
				'default'     => '1',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'rb_sidebar_banner' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			rb_sidebar_banner( $settings );
		}
	}
}