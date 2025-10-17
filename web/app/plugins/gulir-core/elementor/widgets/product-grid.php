<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_product_grid;

class Product_Grid extends Widget_Base {

	public function get_name() {

		return 'gulir-product-grid';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Grid Products', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-products';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'shop', 'list', 'shortcode', 'product', 'woocommerce' ];
	}

	public function get_categories() {

		return [ 'gulir-flex' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'query_filters', [
				'label' => esc_html__( 'Query Settings', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'shortcode_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => html_entity_decode( esc_html__( 'You can refer shortcodes: <a target="_blank" rel="nofollow" href="https://woocommerce.com/document/woocommerce-shortcodes/">Click here</a>', 'gulir-core' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'columns_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Gulir allows you to manage the responsive grid columns via Layout > Columns. Don\'t need to add columns params.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'shortcode', [
				'label'       => esc_html__( 'WooCommerce Shortcodes', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'placeholder' => '[products limit="4" orderby="popularity" on_sale="true" offset="0"]',
				'description' => esc_html__( 'To ensure the flexibility, Gulir allows you to use the WooCommerce Shortcodes to filter any products to show.', 'gulir-core' ),
				'default'     => '[products limit="4"]',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'box_section', [
				'label' => esc_html__( 'Boxed', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'box_style',
			[
				'label'       => esc_html__( 'Box Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a box style for the product listing.', 'gulir-core' ),
				'options'     => [
					'0'        => esc_html__( 'Default (Add to cart Invisible)', 'gulir-core' ),
					'standard' => esc_html__( 'Standard', 'gulir-core' ),
					'bg'       => esc_html__( 'Background', 'gulir-core' ),
					'border'   => esc_html__( 'Border', 'gulir-core' ),
					'shadow'   => esc_html__( 'Shadow', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_control(
			'box_border',
			[
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::border_description(),
				'selectors'   => [
					'{{WRAPPER}}' => '--wrap-border: {{VALUE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'box_padding', [
				'label'       => esc_html__( 'Box Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_spacing_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--box-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'box_color',
			[
				'label'       => esc_html__( 'Box Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::box_color_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--box-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_box_color',
			[
				'label'       => esc_html__( 'Dark Mode - Box Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::box_dark_color_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--dark-box-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_category_section', [
				'label' => esc_html__( 'Entry Category', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'category_meta',
			[
				'label'        => esc_html__( 'Entry Category', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'description'  => esc_html__( 'Show or hide the product categories meta.', 'gulir-core' ),
				'options'      => [
					'0'     => esc_html__( 'Show', 'gulir-core' ),
					'hide'  => esc_html__( 'Hide', 'gulir-core' ),
					'mhide' => esc_html__( 'Hide on Mobile', 'gulir-core' ),
				],
				'prefix_class' => 'pcat-',
				'default'      => '0',
			]
		);
		$this->add_control(
			'category_color', [
				'label'       => esc_html__( 'Entry Category Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the entry category.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--product-cat-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_category_color', [
				'label'       => esc_html__( 'Dark Mode - Entry Category Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the entry category in dark mode.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--product-cat-color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Custom Entry Category Font', 'gulir-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .p-categories',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'featured_section', [
				'label' => esc_html__( 'Featured Image', 'gulir-core' ),
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
			'display_ratio', [
				'label'       => esc_html__( 'Custom Featured Ratio', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::display_ratio_description(),
				'selectors'   => [
					'{{WRAPPER}}' => '--feat-ratio: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'sale_section', [
				'label' => esc_html__( 'Sale Label', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'sale_color', [
				'label'       => esc_html__( 'Sale Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the sale label.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--wc-sale-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'sale_bg', [
				'label'       => esc_html__( 'Sale Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the sale label.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--wc-sale-bg: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Sale Font', 'gulir-core' ),
				'name'     => 'sale_font',
				'selector' => '{{WRAPPER}} .onsale',
			]
		);
		$this->add_responsive_control(
			'sale_padding',
			[
				'label'       => esc_html__( 'Inner Padding', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Input a custom inner padding value for the sale label.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .onsale' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_title_section', [
				'label' => esc_html__( 'Product Title', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .woocommerce-loop-product__title',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'product_meta_section', [
				'label' => esc_html__( 'Product Price', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'price_color', [
				'label'       => esc_html__( 'Price Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the price values.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--wc-price-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_price_color', [
				'label'       => esc_html__( 'Dark Mode - Price Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for the price values in dark mode.', 'gulir-core' ),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--wc-price-color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Price Font', 'gulir-core' ),
				'name'     => 'price_font',
				'selector' => '{{WRAPPER}} .price',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'add_cart_section', [
				'label' => esc_html__( 'Add to Cart', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'cart_button_width',
			[
				'label'        => esc_html__( 'Style', 'gulir-core' ),
				'description'  => esc_html__( 'Select a style for the add to cart button.', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'inline'   => esc_html__( '- Default -', 'gulir-core' ),
					'fw'       => esc_html__( 'Fullwidth', 'gulir-core' ),
					'b-inline' => esc_html__( 'Inline with Border', 'gulir-core' ),
					'b-fw'     => esc_html__( 'Fullwidth with Border', 'gulir-core' ),
				],
				'prefix_class' => 'cart-style-',
				'default'      => 'inline',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Add to Cart Font', 'gulir-core' ),
				'name'     => 'add_cart_font',
				'selector' => '{{WRAPPER}} .button',
			]
		);
		$this->add_responsive_control(
			'add_cart_padding',
			[
				'label'       => esc_html__( 'Button Padding', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Input a custom inner padding value for the add to cart button.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .product-btn a' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->add_control(
			'add_cart_border', [
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}}' => '--wcac-border: {{VALUE}}px;',
				],
			]
		);
		$this->start_controls_tabs( 'add_cart_tabs' );
		$this->start_controls_tab( 'add_cart_normal',
			[
				'label' => esc_html__( 'Normal', 'gulir-core' ),
			]
		);
		$this->add_control(
			'add_cart_color', [
				'label'     => esc_html__( 'Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--wcac-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'add_cart_bg', [
				'label'     => esc_html__( 'Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--wcac-bg: {{VALUE}}; --wcac-bg-90: {{VALUE}}e6;' ],
			]
		);
		$this->add_control(
			'add_cart_bcolor', [
				'label'     => esc_html__( 'Border Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--wcac-bcolor: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_add_cart_color', [
				'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--wcac-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_add_cart_bg', [
				'label'     => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--wcac-bg: {{VALUE}}; --wcac-bg-90: {{VALUE}}e6;' ],
			]
		);
		$this->add_control(
			'dark_add_cart_bcolor', [
				'label'     => esc_html__( 'Dark Mode - Border Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--wcac-bcolor: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'add_cart_hover',
			[
				'label' => esc_html__( 'Hover', 'gulir-core' ),
			]
		);

		$this->add_control(
			'add_cart_hover_color', [
				'label'     => esc_html__( 'Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--wcac-h-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'add_cart_hover_bg', [
				'label'     => esc_html__( 'Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--wcac-h-bg: {{VALUE}}; --wcac-h-bg-90: {{VALUE}}e6;' ],
			]
		);
		$this->add_control(
			'add_cart_hover_bcolor', [
				'label'     => esc_html__( 'Border Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--wcac-h-bcolor: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_add_cart_hover_color', [
				'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme ' => '--wcac-h-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_add_cart_hover_bg', [
				'label'     => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--wcac-h-bg: {{VALUE}}; --wcac-h-bg-90: {{VALUE}}e6;' ],
			]
		);
		$this->add_control(
			'dark_add_cart_hover_bcolor', [
				'label'     => esc_html__( 'Dark Mode - Border Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}}.light-scheme' => '--wcac-h-bcolor: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
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
				'prefix_class' => ' ',
				'options'      => [
					'0' => esc_html__( 'Default (Dark Text)', 'gulir-core' ),
					'1' => esc_html__( 'Light Text', 'gulir-core' ),
				],
				'default'      => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'layout_section', [
				'label' => esc_html__( 'Layout', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'desktop_layout',
			[
				'label'       => esc_html__( 'Desktop Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a layout for the product listing on the desktop.', 'gulir-core' ),
				'options'     => Options::responsive_layout_dropdown( false ),
				'default'     => 'grid',
			]
		);
		$this->add_control(
			'tablet_layout',
			[
				'label'       => esc_html__( 'Tablet Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::tablet_layout_description(),
				'options'     => Options::responsive_layout_dropdown( false ),
				'default'     => 'grid',
			]
		);
		$this->add_control(
			'mobile_layout',
			[
				'label'       => esc_html__( 'Mobile Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::mobile_layout_description(),
				'options'     => Options::responsive_layout_dropdown( false ),
				'default'     => 'grid',
			]
		);
		$this->add_responsive_control(
			'featured_list_width', [
				'label'       => esc_html__( 'List - Image Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::mobile_featured_width_description(),
				'placeholder' => '150',
				'selectors'   => [ '{{WRAPPER}}' => '--feat-list-width: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'featured_list_position', [
				'label'       => esc_html__( 'List - Image Position', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::featured_position_description(),
				'options'     => Options::featured_position_dropdown( false ),
				'default'     => 'left',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'block_columns', [
				'label' => esc_html__( 'Columns', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns on Desktop', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_description(),
				'options'     => Options::columns_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'columns_tablet',
			[
				'label'       => esc_html__( 'Columns on Tablet', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_tablet_description(),
				'options'     => Options::columns_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'columns_mobile',
			[
				'label'       => esc_html__( 'Columns on Mobile', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_mobile_description(),
				'options'     => Options::columns_dropdown( [ 0, 1, 2 ] ),
				'default'     => '0',
			]
		);
		$this->add_control(
			'column_gap',
			[
				'label'       => esc_html__( 'Column Gap', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::column_gap_description(),
				'options'     => Options::column_gap_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'column_gap_custom', [
				'label'       => esc_html__( '1/2 Custom Gap Value', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::column_gap_custom_description(),
				'selectors'   => [
					'{{WRAPPER}} .is-gap-custom'                  => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px; --colgap: {{VALUE}}px;',
					'{{WRAPPER}} .is-gap-custom .block-inner > *' => 'padding-left: {{VALUE}}px; padding-right: {{VALUE}}px;',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'border_section', [
				'label' => esc_html__( 'Grid Borders', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'border_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::column_border_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'column_border',
			[
				'label'       => esc_html__( 'Column Border', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::column_border_description(),
				'options'     => Options::column_border_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'bottom_border',
			[
				'label'       => esc_html__( 'Bottom Border', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::bottom_border_description(),
				'options'     => Options::column_border_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'last_bottom_border',
			[
				'label'       => esc_html__( 'Last Bottom Border', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::last_bottom_border_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'spacing_section', [
				'label' => esc_html__( 'Spacing', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_responsive_control(
			'el_spacing', [
				'label'       => esc_html__( 'Custom Element Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_spacing_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--el-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'bottom_margin', [
				'label'       => esc_html__( 'Custom Bottom Margin', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_margin_description(),
				'selectors'   => [ '{{WRAPPER}} .block-wrap' => '--bottom-spacing: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'center_section', [
				'label' => esc_html__( 'Centering', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'center_mode',
			[
				'label'       => esc_html__( 'Centering Content', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Centering text and content for the product listing.', 'gulir-core' ),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mobile_scroll_section', [
				'label' => esc_html__( 'Tablet/Mobile Horizontal Scroll', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'horizontal_scroll',
			[
				'label'       => esc_html__( 'Horizontal Scroll', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::horizontal_scroll_description(),
				'options'     => Options::horizontal_scroll_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'scroll_width_tablet', [
				'label'       => esc_html__( 'Tablet - Post Module Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '300',
				'description' => Options::scroll_width_tablet_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--tablet-scroll-width: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'scroll_width_mobile', [
				'label'       => esc_html__( 'Mobile - Post Module Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '300',
				'description' => Options::scroll_width_mobile_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--mobile-scroll-width: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( class_exists( 'WooCommerce' ) && function_exists( 'gulir_get_product_grid' ) ) {

			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_product_grid( $settings );
		}
	}
}