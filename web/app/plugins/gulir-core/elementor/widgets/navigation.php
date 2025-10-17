<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_elementor_main_menu;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Navigation extends Widget_Base {

	public function get_name() {

		return 'gulir-navigation';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Menu Navigation', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-navigation-horizontal';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'header', 'template', 'builder', 'menu', 'main', 'mega', 'horizontal' ];
	}

	public function get_categories() {

		return [ 'gulir_header' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general_section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$menus = Options::menu_dropdown();

		$this->add_control(
			'main_menu', [
				'label'        => esc_html__( 'Assign Menu', 'gulir-core' ),
				'description'  => esc_html__( 'Select a menu for your site.', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'multiple'     => false,
				'options'      => $menus,
				'default'      => ! empty( array_keys( $menus )[0] ) ? array_keys( $menus )[0] : '',
				'save_default' => true,
			]
		);
		$this->add_control(
			'is_main_menu',
			[
				'label'       => esc_html__( 'Set as Main Menu', 'gulir-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set this is the main site menu, This option help the site to understand where to add the single sticky headline.', 'gulir-core' ),
				'default'     => 'yes',
			]
		);
		$this->add_control(
			'menu_more',
			[
				'label'       => esc_html__( 'More Menu Button', 'gulir-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Enable or disable the more button at the end of the navigation.', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'root_level_section', [
				'label' => esc_html__( 'Top-Level Menu Items', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Main Menu Font', 'gulir-core' ),
				'name'     => 'menu_font',
				'selector' => '{{WRAPPER}} .main-menu > li > a',
			]
		);
		$this->add_control(
			'menu_height', [
				'label'       => esc_html__( 'Menu Height', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom height value (in pixels) for this menu. Default is 60.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--nav-height: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'menu_sticky_height', [
				'label'       => esc_html__( 'Sticky Menu Height', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom height value (in pixels) for this menu when sticking if it is enabled.', 'gulir-core' ),
				'selectors'   => [ '.sticky-on {{WRAPPER}}' => '--nav-height: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'menu_item_spacing', [
				'label'       => esc_html__( 'Item Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing between menu item. Default is 12.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--menu-item-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'icon_item_spacing', [
				'label'       => esc_html__( 'Icon Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter custom spacing between menu text and icon, if applicable.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--m-icon-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'menu_edge_spacing',
			[
				'label'        => esc_html__( 'No Edge Spacing', 'gulir-core' ),
				'description'  => esc_html__( 'Enable or disable the left spacing of the first menu item.', 'gulir-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'no-edge',
				'prefix_class' => '',
				'default'      => '',
			]
		);
		$this->add_control(
			'align', [
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-align-start-h',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-align-center-h',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-align-end-h',
					],
				],
				'selectors' => [ '{{WRAPPER}} .main-menu-wrap' => 'justify-content: {{VALUE}};' ],
			]
		);
		$this->start_controls_tabs( 'top_item_tabs' );
		$this->start_controls_tab( 'top_item_normal_tab',
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
				'selectors'   => [ '{{WRAPPER}}' => '--nav-color: {{VALUE}}; --nav-color-10: {{VALUE}}1a;' ],
			]
		);
		$this->add_control(
			'menu_dark_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for displaying in the navigation bar of this header in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--nav-color: {{VALUE}}; --nav-color-10: {{VALUE}}1a;' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'top_item_hover_tab',
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
				'selectors'   => [ '{{WRAPPER}}' => '--nav-color-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'menu_hover_color_accent',
			[
				'label'       => esc_html__( 'Accent Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a accent color when hovering.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--nav-color-h-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'menu_dark_hover_color',
			[
				'label'       => esc_html__( 'Dark Mode -Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color when hovering in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--nav-color-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'menu_dark_hover_color_accent',
			[
				'label'       => esc_html__( 'Dark Mode - Accent Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a accent color when hovering in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--nav-color-h-accent: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'sub_menu_section', [
				'label' => esc_html__( 'Submenu Items', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Submenu Font', 'gulir-core' ),
				'name'     => 'submenu_font',
				'selector' => '{{WRAPPER}} .main-menu .sub-menu > .menu-item a, {{WRAPPER}} .more-col .menu a, {{WRAPPER}} .collapse-footer-menu a',
			]
		);
		$this->add_control(
			'submenu_border', [
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom border radius for submenu.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--sm-border-radius: {{VALUE}}px;' ],
			]
		);
		$this->start_controls_tabs( 'sub_item_tabs' );
		$this->start_controls_tab( 'sub_item_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);
		$this->add_control(
			'submenu_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the sub menu dropdown section.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-color: {{VALUE}}; --subnav-color-10: {{VALUE}}1a;' ],
			]
		);
		$this->add_control(
			'submenu_bg_from',
			[
				'label'       => esc_html__( 'Background Gradient (From)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the sub menu dropdown section.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'submenu_bg_to',
			[
				'label'       => esc_html__( 'Background Gradient (To)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the sub menu dropdown section.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-bg-to: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_submenu_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for the sub menu dropdown section in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-color: {{VALUE}}; --subnav-color-10: {{VALUE}}1a;' ],
			]
		);
		$this->add_control(
			'dark_submenu_bg_from',
			[
				'label'       => esc_html__( 'Dark Mode - Background Gradient (From)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 0%) for the sub menu dropdown section in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg: {{VALUE}}; --subnav-bg-from: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_submenu_bg_to',
			[
				'label'       => esc_html__( 'Dark Mode - Background Gradient (To)', 'gulir-core' ),
				'description' => esc_html__( 'Select a background color (color stop: 100%) for the sub menu dropdown section in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg-to: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab( 'sub_item_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);
		$this->add_control(
			'submenu_hover_border',
			[
				'label'       => esc_html__( 'Left Border', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter the custom left border width for hover state. Set to 0 to disable.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-border: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'submenu_hover_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color for hover effects. Consider choosing a contrasting color, as this setting also applies to other menu items and header dropdowns.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--subnav-color-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'submenu_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'gulir-core' ),
				'subtitle'  => esc_html__( 'Select a background color when hovering.', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--subnav-bg-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_submenu_hover_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a text color when hovering in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-color-h: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_submenu_hover_bg',
			[
				'label'     => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'subtitle'  => esc_html__( 'Select a background color when hovering in dark mode.', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--subnav-bg-h: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'menu_divider_section', [
				'label' => esc_html__( 'Divider', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'divider_style', [
				'label'        => esc_html__( 'Divider Style', 'gulir-core' ),
				'description'  => esc_html__( 'Select a divider style to show between menu items.', 'gulir-core' ),
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
		$this->start_controls_section(
			'mega-menu-section', [
				'label' => esc_html__( 'Mega Menu - Color Scheme', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_scheme_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This is treated as a global setting. Each menu item in "Appearance > Menus" take priority over this setting.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'color_scheme',
			[
				'label'       => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'In case you would like to switch layout and text to light when set a dark background for sub menu in light mode.', 'gulir-core' ),
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
		gulir_elementor_main_menu( $settings );
	}
}