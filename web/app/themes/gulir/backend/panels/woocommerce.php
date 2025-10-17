<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_wc_plugin_status_info' ) ) {
	function gulir_wc_plugin_status_info( $id = 'wc_status_info' ) {

		return [
			[
				'id'    => $id,
				'type'  => 'info',
				'style' => 'warning',
				'desc'  => html_entity_decode( esc_html__( 'Woocommerce Plugin is missing! Please install and activate <a href="https://wordpress.org/plugins/woocommerce">Woocommerce</a> plugin to enable the settings.', 'gulir' ) ),
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_woocommerce' ) ) {
	function gulir_register_options_woocommerce() {

		return [
			'id'    => 'gulir_config_section_woocommerce',
			'title' => esc_html__( 'WooCommerce', 'gulir' ),
			'desc'  => esc_html__( 'Select options for the shop.', 'gulir' ),
			'icon'  => 'el el-shopping-cart',
		];
	}
}

/**
 * @return array
 * single product
 */
if ( ! function_exists( 'gulir_register_options_wc_page' ) ) {
	function gulir_register_options_wc_page() {

		return [
			'id'         => 'gulir_config_section_wc_page',
			'title'      => esc_html__( 'Shop & Archives', 'gulir' ),
			'desc'       => esc_html__( 'Select options for the shop and archive and single product pages.', 'gulir' ),
			'icon'       => 'el el-folder-open',
			'subsection' => true,
			'fields'     => ! class_exists( 'WooCommerce' ) ? gulir_wc_plugin_status_info() :
				[
					[
						'id'     => 'section_start_wc_shop',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Shop Page', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_shop_template',
						'type'        => 'textarea',
						'title'       => esc_html__( 'Header Template Shortcode', 'gulir' ),
						'subtitle'    => esc_html__( 'Input your template shortcode you would like to use Elementor builder to create a featured section at the top of shop page.', 'gulir' ),
						'placeholder' => '[Ruby_E_Template id="1"]',
						'class'       => 'ruby-template-input',
						'rows'        => 1,
					],
					[
						'id'       => 'wc_shop_posts_per_page',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Products per Page', 'gulir' ),
						'subtitle' => esc_html__( 'Select number of products per page for the shop page.', 'gulir' ),
						'default'  => false,
					],
					[
						'id'       => 'wc_shop_sidebar_position',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Shop Sidebar Position', 'gulir' ),
						'subtitle' => esc_html__( 'Select sidebar position for the shop page if you enabled the sidebar.', 'gulir' ),
						'options'  => gulir_config_sidebar_position( false ),
						'default'  => 'none',
					],
					[
						'id'       => 'wc_shop_sidebar_name',
						'type'     => 'select',
						'title'    => esc_html__( 'Shop Sidebar Name', 'gulir' ),
						'subtitle' => esc_html__( 'Select a sidebar for the shop page if you enabled the sidebar.', 'gulir' ),
						'options'  => gulir_config_sidebar_name(),
						'default'  => 'gulir_sidebar_default',
					],
					[
						'id'     => 'section_end_wc_shop',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_archive',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Category & Archives', 'gulir' ),
						'indent' => true,
					],
					[
						'id'       => 'wc_archive_posts_per_page',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Products per Page', 'gulir' ),
						'subtitle' => esc_html__( 'Select number of products per page for the category pages.', 'gulir' ),
						'default'  => false,
					],
					[
						'id'       => 'wc_archive_sidebar_position',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Archive Sidebar Position', 'gulir' ),
						'subtitle' => esc_html__( 'Select a sidebar position for product category and archive pages if you enabled the sidebar.', 'gulir' ),
						'options'  => gulir_config_sidebar_position( false ),
						'default'  => 'none',
					],
					[
						'id'       => 'wc_archive_sidebar_name',
						'type'     => 'select',
						'title'    => esc_html__( 'Archive Sidebar Name', 'gulir' ),
						'subtitle' => esc_html__( 'Select a sidebar for product category and archive pages if you enabled the sidebar.', 'gulir' ),
						'options'  => gulir_config_sidebar_name(),
						'default'  => 'gulir_sidebar_default',
					],
					[
						'id'     => 'section_end_wc_archive',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_sidebar',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Sidebar', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_shop_sidebar_width',
						'title'       => esc_html__( 'Shop Sidebar Width', 'gulir' ),
						'subtitle'    => esc_html__( 'Input a custom % width (1 to 100) for the shop, product category, and archive sidebars.', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'placeholder' => '30',
					],
					[
						'id'     => 'section_end_wc_sidebar',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_spacing',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Product Listing Gap', 'gulir' ),
						'notice' => [
							esc_html__( 'These settings apply to the main product listings on the shop, product category, and archive pages.', 'gulir' ),
							esc_html__( 'For blocks created with "Gulir - Grid Product," you can adjust all spacing in the Layout tab of the block settings.', 'gulir' ),
						],
						'indent' => true,
					],
					[
						'id'          => 'wc_product_gap_desktop',
						'title'       => esc_html__( 'Desktop - 1/2 Column Gap', 'gulir' ),
						'subtitle'    => esc_html__( 'Set the column spacing (in pixels) between product listings for desktop.', 'gulir' ),
						'description' => esc_html__( 'The actual gap will be twice the value you input.', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'placeholder' => '20',
					],
					[
						'id'          => 'wc_product_gap_tablet',
						'title'       => esc_html__( 'Tablet - 1/2 Column Gap', 'gulir' ),
						'subtitle'    => esc_html__( 'Set the column spacing (in pixels) between product listings for tablet.', 'gulir' ),
						'description' => esc_html__( 'The actual gap will be twice the value you input.', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'placeholder' => '15',
					],
					[
						'id'     => 'section_end_wc_spacing',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_bottom_margin',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Product Listing Bottom Margin', 'gulir' ),
						'notice' => [
							esc_html__( 'These settings apply to the main product listings on the shop, product category, and archive pages.', 'gulir' ),
							esc_html__( 'For blocks created with "Gulir - Grid Product," you can adjust all spacing in the Layout tab of the block settings.', 'gulir' ),
						],
						'indent' => true,
					],
					[
						'id'          => 'wc_product_margin_desktop',
						'title'       => esc_html__( 'Desktop - Bottom Margin', 'gulir' ),
						'subtitle'    => esc_html__( 'Input custom bottom margin values (in pixels) between products in the listing for desktop.', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'placeholder' => '35',
					],
					[
						'id'          => 'wc_product_margin_tablet',
						'title'       => esc_html__( 'Tablet - Bottom Margin', 'gulir' ),
						'subtitle'    => esc_html__( 'Input custom bottom margin values (in pixels) between products in the listing for tablet.', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'placeholder' => '35',
					],
					[
						'id'          => 'wc_product_margin_mobile',
						'title'       => esc_html__( 'Mobile - Bottom Margin', 'gulir' ),
						'subtitle'    => esc_html__( 'Input custom bottom margin values (in pixels) between products in the listing for mobile.', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'placeholder' => '35',
					],
					[
						'id'     => 'section_end_wc_bottom_margin',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
				],
		];
	}
}

/**
 * @return array
 * styling
 */
if ( ! function_exists( 'gulir_register_options_wc_style' ) ) {
	function gulir_register_options_wc_style() {

		return [
			'id'         => 'gulir_config_section_wc_style',
			'title'      => esc_html__( 'General', 'gulir' ),
			'desc'       => esc_html__( 'Select styles and layout for the product listing.', 'gulir' ),
			'icon'       => 'el el-adjust-alt',
			'subsection' => true,
			'fields'     => ! class_exists( 'WooCommerce' ) ? gulir_wc_plugin_status_info( 'wc_style_info' ) :
				[
					[
						'id'    => 'info_product_block',
						'type'  => 'info',
						'style' => 'info',
						'desc'  => esc_html__( 'You can use "Gulir - Grid Products" to display products on the homepage and other pages. This block also supports individual responsive settings.', 'gulir' ),
					],
					[
						'id'     => 'section_start_wc_color',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Color', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_global_color',
						'title'       => esc_html__( 'Highlight Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a global color for WooCommerce pages. This setting will override the global color.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'     => 'section_end_wc_color',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_boxed',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Boxed', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_box_style',
						'title'       => esc_html__( 'Box Style', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a box style for the product listing.', 'gulir' ),
						'description' => esc_html__( 'Add to cart Invisible style will only apply to desktop.', 'gulir' ),
						'type'        => 'select',
						'options'     => [
							'0'        => esc_html__( 'Default (Add to cart Invisible)', 'gulir' ),
							'standard' => esc_html__( 'Standard', 'gulir' ),
							'bg'       => esc_html__( 'Background', 'gulir' ),
							'border'   => esc_html__( 'Border', 'gulir' ),
							'shadow'   => esc_html__( 'Shadow', 'gulir' ),
						],
						'default'     => '0',
					],
					[
						'id'          => 'wc_box_color',
						'title'       => esc_html__( 'Box Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a color for the background or border style.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
					],
					[
						'id'          => 'wc_dark_box_color',
						'title'       => esc_html__( 'Dark Mode - Box Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a color for the background or border style in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
					],
					[
						'id'     => 'section_end_wc_boxed',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'       => 'section_start_wc_responsive',
						'type'     => 'section',
						'class'    => 'ruby-section-start',
						'title'    => esc_html__( 'Responsive List/Grid & Centering', 'gulir' ),
						'subtitle' => esc_html__( 'This setting will apply only to main product loop of the standard WooCommerce pages such as shop, category and archives.', 'gulir' ),
						'indent'   => true,
					],
					[
						'id'       => 'wc_responsive_list',
						'type'     => 'switch',
						'title'    => esc_html__( 'Mobile List Layout', 'gulir' ),
						'subtitle' => esc_html__( 'Display product list in the gird layout on mobile devices.', 'gulir' ),
						'default'  => true,
					],
					[
						'id'       => 'wc_centered',
						'type'     => 'switch',
						'title'    => esc_html__( 'Centering Products', 'gulir' ),
						'subtitle' => esc_html__( 'Center the product title and meta in the listing.', 'gulir' ),
						'default'  => false,
					],
					[
						'id'     => 'section_end_wc_responsive',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_sale_style',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Sale Label', 'gulir' ),
						'indent' => true,
					],
					[
						'id'       => 'wc_sale_percent',
						'type'     => 'switch',
						'title'    => esc_html__( 'Percentage Saved', 'gulir' ),
						'subtitle' => esc_html__( 'Display Percentage saved on WooCommerce sale products', 'gulir' ),
						'default'  => true,
					],
					[
						'id'          => 'wc_sale_text',
						'title'       => esc_html__( 'Text Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a text color value for the sale icon.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_sale_color',
						'title'       => esc_html__( 'Background', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a background color value for the sale icon.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'     => 'section_end_wc_sale_style',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_price',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Price', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_price_color',
						'title'       => esc_html__( 'Price Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a color value for the product price.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_price_color',
						'title'       => esc_html__( 'Dark Mode - Price Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a color value for the product price in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'     => 'section_end_wc_price',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_review',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Review', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_star_color',
						'title'       => esc_html__( 'Review Start Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a color value for the stars review.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_star_color',
						'title'       => esc_html__( 'Dark Mode - Review Start Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a color value for the stars review in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'     => 'section_end_wc_review',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_add_to_cart',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Add to Cart Style', 'gulir' ),
						'indent' => true,
					],
					[
						'id'       => 'wc_add_cart_style',
						'title'    => esc_html__( 'Button Style', 'gulir' ),
						'subtitle' => esc_html__( 'Select a style for the add to cart button.', 'gulir' ),
						'type'     => 'select',
						'options'  => [
							'inline'   => esc_html__( '- Default -', 'gulir' ),
							'fw'       => esc_html__( 'Fullwidth', 'gulir' ),
							'b-inline' => esc_html__( 'Inline with Border', 'gulir' ),
							'b-fw'     => esc_html__( 'Fullwidth with Border', 'gulir' ),
						],
						'default'  => 'inline',
					],
					[
						'id'       => 'wc_add_cart_border',
						'title'    => esc_html__( 'Border Radius', 'gulir' ),
						'subtitle' => esc_html__( 'Input a custom border radius value for "Add to Cart" button.', 'gulir' ),
						'class'    => 'small',
						'type'     => 'text',
						'validate' => 'numeric',
					],
					[
						'id'     => 'section_end_wc_add_to_cart',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_add_to_cart_normal',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Add to Cart - Normal', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_add_cart_text',
						'title'       => esc_html__( 'Text Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a text color for the "Add to Cart" button.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_add_cart_color',
						'title'       => esc_html__( 'Background', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a background color for the "Add to Cart" button.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_add_cart_bcolor',
						'title'       => esc_html__( 'Border', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a border color for the "Add to Cart" button.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_add_cart_text',
						'title'       => esc_html__( 'Dark Mode - Text Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a text color for the "Add to Cart" button in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
						'default'     => '#ffffff',
					],
					[
						'id'          => 'wc_dark_add_cart_color',
						'title'       => esc_html__( 'Dark Mode - Background', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a background color for the "Add to Cart" button in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_add_cart_bcolor',
						'title'       => esc_html__( 'Dark Mode - Border', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a border color for the "Add to Cart" button in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'     => 'section_end_wc_add_to_cart_normal',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_add_to_cart_hover',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Add to Cart - Hover', 'gulir' ),
						'indent' => true,
					],
					[
						'id'          => 'wc_add_cart_hover_text',
						'title'       => esc_html__( 'Text Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a text color when hovering.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_add_cart_hover_color',
						'title'       => esc_html__( 'Background', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a background color when hovering.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_add_cart_hover_bcolor',
						'title'       => esc_html__( 'Border', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a border color when hovering.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_add_cart_hover_text',
						'title'       => esc_html__( 'Dark Mode - Text Color', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a border color when hovering in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_add_cart_hover_color',
						'title'       => esc_html__( 'Dark Mode - Background', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a background color when hovering in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'          => 'wc_dark_add_cart_hover_bcolor',
						'title'       => esc_html__( 'Dark Mode - Border', 'gulir' ),
						'subtitle'    => esc_html__( 'Select a border color when hovering in dark mode.', 'gulir' ),
						'type'        => 'color',
						'transparent' => false,
						'validate'    => 'color',
					],
					[
						'id'     => 'section_end_wc_add_to_cart_hover',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_add_popup',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Add to Cart Notification', 'gulir' ),
						'indent' => true,
					],
					[
						'id'       => 'wc_add_cart_popup',
						'title'    => esc_html__( 'Popup Notification', 'gulir' ),
						'subtitle' => esc_html__( 'Show a popup notification at the bottom when a product is added to the cart.', 'gulir' ),
						'type'     => 'switch',
						'default'  => true,
					],
					[
						'id'     => 'section_end_wc_add_popup',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
				],
		];
	}
}

/**
 * @return array
 * styling
 */
if ( ! function_exists( 'gulir_register_options_wc_single' ) ) {
	function gulir_register_options_wc_single() {

		return [
			'id'         => 'gulir_config_section_wc_single',
			'title'      => esc_html__( 'Single Product', 'gulir' ),
			'desc'       => esc_html__( 'Select settings for the single product page.', 'gulir' ),
			'icon'       => 'el el-shopping-cart',
			'subsection' => true,
			'fields'     => ! class_exists( 'WooCommerce' ) ? gulir_wc_plugin_status_info( 'wc_single_info' ) :
				[
					[
						'id'     => 'section_start_wc_single_style',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Group Product Type', 'gulir' ),
						'indent' => true,
					],
					[
						'id'       => 'wc_group_thumbnail',
						'type'     => 'switch',
						'title'    => esc_html__( 'Group Product Images', 'gulir' ),
						'subtitle' => esc_html__( 'Enable or disable the group product featured images.', 'gulir' ),
						'default'  => true,
					],
					[
						'id'          => 'wc_gallery_nav_columns',
						'title'       => esc_html__( 'Gallery Nav Columns', 'gulir' ),
						'subtitle'    => esc_html__( 'Enter the number of columns for the gallery navigation on the single product page.', 'gulir' ),
						'description' => esc_html__( 'This section is located under the featured image on the single product page.', 'gulir' ),
						'type'        => 'text',
						'validate'    => 'numeric',
						'class'       => 'small',
						'placeholder' => '4',
					],
					[
						'id'          => 'wc_gallery_nav_ratio',
						'title'       => esc_html__( 'Gallery Nav Ratio', 'gulir' ),
						'subtitle'    => esc_html__( 'Input custom ratio percent (height*100/width) for featured image you would like. e.g. 50', 'gulir' ),
						'type'        => 'text',
						'class'       => 'small',
						'validate'    => 'numeric',
						'placeholder' => '100',
					],
					[
						'id'     => 'section_end_wc_single_style',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_start_wc_single_section',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Footer Sections', 'gulir' ),
						'indent' => true,
					],
					[
						'id'       => 'wc_box_review',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Review Box', 'gulir' ),
						'subtitle' => esc_html__( 'enable or disable the review box in the single product page.', 'gulir' ),
						'default'  => true,
					],
					[
						'id'       => 'wc_related_posts_per_page',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Total Related Products', 'gulir' ),
						'subtitle' => esc_html__( 'Select total related product to show at once. leave blank if you want to set as default.', 'gulir' ),
						'default'  => 4,
					],
					[
						'id'     => 'section_end_wc_single_section',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
				],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_typo_wc' ) ) {
	function gulir_register_options_typo_wc() {

		return [
			'id'         => 'gulir_config_section_wc_typography',
			'title'      => esc_html__( 'WooCommerce', 'gulir' ),
			'desc'       => esc_html__( 'Select font values for your shop.', 'gulir' ),
			'icon'       => 'el el-font',
			'subsection' => true,
			'fields'     => ! class_exists( 'WooCommerce' ) ? gulir_wc_plugin_status_info( 'wc_typo_info' ) :
				[
					[
						'id'     => 'section_start_wc_product_font',
						'type'   => 'section',
						'class'  => 'ruby-section-start',
						'title'  => esc_html__( 'Product Title', 'gulir' ),
						'indent' => true,
					],
					[
						'id'             => 'font_product',
						'type'           => 'typography',
						'title'          => esc_html__( 'Product Title Font', 'gulir' ),
						'subtitle'       => esc_html__( 'Select a custom font for the product listing title.', 'gulir' ),
						'google'         => true,
						'font-backup'    => true,
						'text-align'     => false,
						'color'          => true,
						'text-transform' => true,
						'letter-spacing' => true,
						'line-height'    => false,
						'font-size'      => true,
						'units'          => 'px',
						'default'        => [],
					],
					[
						'id'       => 'font_product_size_tablet',
						'type'     => 'text',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for product listing title on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
					],
					[
						'id'       => 'font_product_size_mobile',
						'type'     => 'text',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for the product listing title on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
					],
					[
						'id'     => 'section_end_wc_product_font',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'     => 'section_end_wc_product_font',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'       => 'section_start_wc_single_font',
						'type'     => 'section',
						'class'    => 'ruby-section-start',
						'title'    => esc_html__( 'Single Title', 'gulir' ),
						'subtitle' => esc_html__( 'These settings below will apply to the single product.', 'gulir' ),
						'indent'   => true,
					],
					[
						'id'       => 'font_sproduct_size',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for the single product title.', 'gulir' ),
					],
					[
						'id'       => 'font_sproduct_size_tablet',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for the single product title on tablet devices (max screen width: 1024px), Leave this option blank to set the default value.', 'gulir' ),
					],
					[
						'id'       => 'font_sproduct_size_mobile',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for the single product title on mobile devices (max screen width: 767px), Leave this option blank to set the default value.', 'gulir' ),
					],
					[
						'id'     => 'section_end_wc_single_font',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
					[
						'id'       => 'section_start_wc_price_font',
						'type'     => 'section',
						'class'    => 'ruby-section-start',
						'title'    => esc_html__( 'Price Font', 'gulir' ),
						'subtitle' => esc_html__( 'The font size values will apply only to the loop listing.', 'gulir' ),
						'indent'   => true,
					],
					[
						'id'             => 'font_price',
						'type'           => 'typography',
						'title'          => esc_html__( 'Price Font', 'gulir' ),
						'subtitle'       => esc_html__( 'Select a custom font for the product price.', 'gulir' ),
						'google'         => true,
						'font-backup'    => true,
						'text-align'     => false,
						'color'          => false,
						'text-transform' => true,
						'letter-spacing' => true,
						'line-height'    => false,
						'font-size'      => true,
						'units'          => 'px',
						'default'        => [],
					],
					[
						'id'       => 'font_price_size_tablet',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Tablet Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for the price title on tablet devices.', 'gulir' ),
					],
					[
						'id'       => 'font_price_size_mobile',
						'type'     => 'text',
						'class'    => 'small',
						'validate' => 'numeric',
						'title'    => esc_html__( 'Mobile Font Size', 'gulir' ),
						'subtitle' => esc_html__( 'Select a font size (in pixels) for the price on mobile devices.', 'gulir' ),
					],
					[
						'id'     => 'section_end_wc_price_font',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
				],
		];
	}
}