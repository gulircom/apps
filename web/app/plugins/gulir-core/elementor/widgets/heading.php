<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_heading;

/**
 * Class Gulir_Heading
 *
 * @package gulirElementor\Widgets
 */
class Block_Heading extends Widget_Base {

	public function get_name() {

		return 'gulir-heading';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Heading', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-heading';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'title', 'top', 'section' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title', [
				'label' => esc_html__( 'Content', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading', 'gulir-core' ),
				'description' => esc_html__( 'Input a heading, Support the i tag (raw HTML) for displaying icon. e.g: <i class="rbi rbi-trending"></i> Your Heading', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Latest News', 'gulir-core' ),
				'default'     => esc_html__( 'Latest News', 'gulir-core' ),
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
			]
		);
		$this->add_control(
			'tagline',
			[
				'label'       => esc_html__( 'Tagline', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Input a tagline text for this heading block.', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Custom Link', 'gulir-core' ),
				'type'  => Controls_Manager::URL,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'heading_style_section', [
				'label' => esc_html__( 'Heading', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'html_tag',
			[
				'label'   => esc_html__( 'Heading HTML Tag', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::heading_html_dropdown( false ),
				'default' => 'h2',
			]
		);
		$this->add_responsive_control(
			'heading_size',
			[
				'label'       => esc_html__( 'Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a custom font size value (in pixels) for this heading. Leave this option blank to set the default value.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .heading-title > *' => 'font-size: {{VALUE}}px;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Heading Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .heading-title > *',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tagline_section', [
				'label' => esc_html__( 'Tagline', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'tagline_html_tag',
			[
				'label'   => esc_html__( 'Tagline HTML Tag', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::heading_html_dropdown( false ),
				'default' => 'span',
			]
		);
		$this->add_control(
			'tagline_arrow',
			[
				'label'       => esc_html__( 'Tagline Icon', 'gulir-core' ),
				'description' => esc_html__( 'Show an arrow icon beside the tagline label.', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'0' => esc_html__( '- Disable -', 'gulir-core' ),
					'1' => esc_html__( 'Circle Arrow', 'gulir-core' ),
					'2' => esc_html__( 'Thin Arrow', 'gulir-core' ),
					'3' => esc_html__( 'Dots', 'gulir-core' ),
					'4' => esc_html__( 'Angle before Label' ),
					'5' => esc_html__( 'Plus before Label', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'tagline_size',
			[
				'label'       => esc_html__( 'Tagline - Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a custom font size value (in pixels) for this tagline. Leave this option blank to set the default value.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .heading-tagline > *' => 'font-size: {{VALUE}}px;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Custom Tagline Font', 'gulir-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .heading-tagline > *',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_color', [
				'label' => esc_html__( 'Colors', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'primary_color',
			[
				'label'       => esc_html__( 'Primary Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a primary color for this heading.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .heading-title' => '--heading-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'accent_color',
			[
				'label'       => esc_html__( 'Accent Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a accent color for this heading.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}}' => '--heading-sub-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tagline_color',
			[
				'label'       => esc_html__( 'Tagline Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a text color for the tagline.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} ' => '--heading-tagline-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_primary_color',
			[
				'label'       => esc_html__( 'Dark Mode - Primary Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'description' => esc_html__( 'Select a primary color for this heading in dark mode.', 'gulir-core' ),
				'selectors'   => [
					'[data-theme="dark"] {{WRAPPER}} .heading-title, {{WRAPPER}} .light-scheme .heading-title' => '--heading-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_accent_color',
			[
				'label'       => esc_html__( 'Dark Mode - Accent Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a accent color for this heading in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [
					'[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}} .light-scheme' => '--heading-sub-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_tagline_color',
			[
				'label'       => esc_html__( 'Dark Mode - Tagline Text Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a text color for the tagline in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [
					'[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}} .light-scheme' => '--heading-tagline-color: {{VALUE}};',
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
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'layout_section', [
				'label' => esc_html__( 'Layouts', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'layout',
			[
				'label'       => esc_html__( 'Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a layout for this heading block.', 'gulir-core' ),
				'options'     => [
					'0'   => esc_html__( '- Default -', 'gulir-core' ),
					'1'   => esc_html__( '01 - Two Slashes', 'gulir-core' ),
					'2'   => esc_html__( '02 - Left Dot', 'gulir-core' ),
					'3'   => esc_html__( '03 - Bold Underline', 'gulir-core' ),
					'4'   => esc_html__( '04 - Multiple Underline', 'gulir-core' ),
					'5'   => esc_html__( '05 - Top Line', 'gulir-core' ),
					'6'   => esc_html__( '06 - Parallelogram Background', 'gulir-core' ),
					'7'   => esc_html__( '07 - Left Border', 'gulir-core' ),
					'8'   => esc_html__( '08 - Half Elegant Background', 'gulir-core' ),
					'9'   => esc_html__( '09 - Small Corners', 'gulir-core' ),
					'10'  => esc_html__( '10 - Only Text', 'gulir-core' ),
					'11'  => esc_html__( '11 - Big Tagline Overlay', 'gulir-core' ),
					'12'  => esc_html__( '12 - Mixed Underline', 'gulir-core' ),
					'13'  => esc_html__( '13 - Rectangle Background', 'gulir-core' ),
					'14'  => esc_html__( '14 - Top Solid', 'gulir-core' ),
					'15'  => esc_html__( '15 - Top & Bottom Solid', 'gulir-core' ),
					'16'  => esc_html__( '16 - Mixed Background', 'gulir-core' ),
					'17'  => esc_html__( '17 - Centered Solid', 'gulir-core' ),
					'18'  => esc_html__( '18 - Centered Dotted', 'gulir-core' ),
					'19'  => esc_html__( '19 - Line Break for Tagline', 'gulir-core' ),
					'20'  => esc_html__( '20 - Mixed Box Light Border', 'gulir-core' ),
					'21'  => esc_html__( '21 - Mixed Box Solid Border', 'gulir-core' ),
					'22'  => esc_html__( '22 - Mixed Box Shadow Border', 'gulir-core' ),
					'23'  => esc_html__( '23 - Right Slashes', 'gulir-core' ),
					'24'  => esc_html__( '24 - Mixed Background 2', 'gulir-core' ),
					'c1'  => esc_html__( 'Center 01 - Two Slashes', 'gulir-core' ),
					'c2'  => esc_html__( 'Center 02 - Two Dots', 'gulir-core' ),
					'c3'  => esc_html__( 'Center 03 - Underline', 'gulir-core' ),
					'c4'  => esc_html__( 'Center 04 - Bold Underline', 'gulir-core' ),
					'c5'  => esc_html__( 'Center 05 - Top Line', 'gulir-core' ),
					'c6'  => esc_html__( 'Center 06 - Parallelogram Background', 'gulir-core' ),
					'c7'  => esc_html__( 'Center 07 - Two Square Dots', 'gulir-core' ),
					'c8'  => esc_html__( 'Center 08 - Elegant Lines', 'gulir-core' ),
					'c9'  => esc_html__( 'Center 09 - Small Corners', 'gulir-core' ),
					'c10' => esc_html__( 'Center 10 - Only Text', 'gulir-core' ),
					'c11' => esc_html__( 'Center 11 - Big Tagline Overlay', 'gulir-core' ),
					'c12' => esc_html__( 'Center 12 - Mixed Underline', 'gulir-core' ),
					'c13' => esc_html__( 'Center 13 - Rectangle Background', 'gulir-core' ),
					'c14' => esc_html__( 'Center 14 - Top Solid', 'gulir-core' ),
					'c15' => esc_html__( 'Center 15 - Top & Bottom Solid', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'       => esc_html__( 'Heading Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a custom spacing value (in pixels) value between the heading text and graphic elements (line, border...).', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--heading-spacing: {{VALUE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'heading_radius',
			[
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set a custom border radius for the heading box (background or border). This setting applies to specific layouts.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--round-3: {{VALUE}}px;',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'centered_section', [
				'label' => esc_html__( 'for Center Layouts', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_responsive_control(
			'tagline_margin',
			[
				'label'       => esc_html__( 'Tagline Top Margin', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a custom top margin value (in pixels) for the tagline. This setting applies only to center layouts.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--heading-tagline-margin: {{VALUE}}px;',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_get_heading' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			echo gulir_get_heading( $settings );
		}
	}
}