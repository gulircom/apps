<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_elementor_sidebar_menu;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Sidebar_Menu extends Widget_Base {

	public function get_name() {

		return 'gulir-sidebar-menu';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Sidebar Menu', 'gulir-core' );
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'template', 'builder', 'navigation', 'sidebar', 'vertical' ];
	}

	public function get_icon() {

		return 'eicon-nav-menu';
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$menus = Options::menu_dropdown();

		$this->start_controls_section(
			'general_section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'menu', [
				'label'        => esc_html__( 'Assign Menu', 'gulir-core' ),
				'description'  => esc_html__( 'Select a menu for this block.', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'multiple'     => false,
				'options'      => $menus,
				'default'      => ! empty( array_keys( $menus )[0] ) ? array_keys( $menus )[0] : '',
				'save_default' => true,
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading', 'gulir-core' ),
				'description' => esc_html__( 'Input a heading, Support the i tag (raw HTML) for displaying icon. e.g: <i class="rbi rbi-trending"></i> Your Heading', 'gulir-core' ),
				'placeholder' => esc_html__( 'About US', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'heading_section', [
				'label' => esc_html__( 'Heading', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label'       => esc_html__( 'Heading HTML Tag', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::heading_html_description(),
				'options'     => Options::heading_html_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Heading Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .menu-heading',
			]
		);
		$this->add_responsive_control(
			'title_spacing', [
				'label'       => esc_html__( 'Bottom Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set the spacing between the menu heading and the content.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--h-menu-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__( 'Heading Color', 'gulir-core' ),
				'description' => esc_html__( 'Choose a color for the menu heading.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--h-menu-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_title_color',
			[
				'label'       => esc_html__( 'Dark Mode - Heading Color', 'gulir-core' ),
				'description' => esc_html__( 'Choose a color for the menu heading in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--h-menu-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style-section', [
				'label' => esc_html__( 'Layout', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'menu_layout', [
				'label'       => esc_html__( 'Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a menu layout. Horizontal layout will not support menu depths.', 'gulir-core' ),
				'options'     => [
					'0' => esc_html__( 'Vertical', 'gulir-core' ),
					'1' => esc_html__( 'Horizontal', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'menu_item_spacing', [
				'label'       => esc_html__( 'Item Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing between menu item.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--sidebar-menu-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'icon_item_spacing', [
				'label'       => esc_html__( 'Icon Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter custom spacing between menu text and icon, if applicable.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--m-icon-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'align', [
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-align-start-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-align-center-h',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-align-end-h',
					],
				],
				'selectors' => [ '{{WRAPPER}}' => '--menu-align : {{VALUE}};' ],
			]
		);

		$this->start_controls_tabs( 'main_item_tabs' );
		$this->start_controls_tab( 'main_item_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);
		$this->add_control(
			'menu_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--sb-menu-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'menu_dark_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--sb-menu-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'main_item_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);
		$this->add_control(
			'menu_hover_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .sidebar-menu a:hover > span, {{WRAPPER}} .current-menu-item a > span' => 'color: {{VALUE}}; opacity: 1;' ],
			]
		);
		$this->add_control(
			'menu_dark_hover_color',
			[
				'label'       => esc_html__( 'Dark Mode -  Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color when hovering in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .sidebar-menu a:hover > span, [data-theme="dark"] {{WRAPPER}} .current-menu-item a > span' => 'color: {{VALUE}}; opacity: 1;' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'font_section', [
				'label' => esc_html__( 'Font & Font Size', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Menu Font', 'gulir-core' ),
				'name'     => 'menu_font',
				'selector' => '{{WRAPPER}} .sidebar-menu a',
			]
		);
		$this->add_responsive_control(
			'sub_font_size', [
				'label'       => esc_html__( 'Sub Menu Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size value for the sub menu item.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .sidebar-menu ul.sub-menu a' => 'font-size: {{VALUE}}px !important;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'vertical_divider_section', [
				'label' => esc_html__( 'for Vertical', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'bottom_border',
			[
				'label'        => esc_html__( 'Bottom Border', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'description'  => Options::bottom_border_description(),
				'options'      => Options::column_border_dropdown(),
				'prefix_class' => 'mborder-',
				'default'      => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'hoz_divider_section', [
				'label' => esc_html__( 'for Horizontal', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'hoz_divider_style',
			[
				'label'        => esc_html__( 'Horizontal Divider Style', 'gulir-core' ),
				'description'  => esc_html__( 'Select a divider style to display between menu items in the horizontal layout.', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => Options::menu_divider_dropdown(),
				'default'      => '0',
				'prefix_class' => 'is-divider-',
			]
		);
		$this->add_control(
			'divider_color',
			[
				'label'       => esc_html__( 'Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for divider.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--divider-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_divider_color',
			[
				'label'       => esc_html__( 'Dark Mode - Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for divider in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--divider-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings = $this->get_settings();
		gulir_elementor_sidebar_menu( $settings );
	}

}