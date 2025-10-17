<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'gulir_register_options_header' ) ) {
	function gulir_register_options_header() {

		return [
			'id'    => 'gulir_config_section_header',
			'title' => esc_html__( 'Header', 'gulir' ),
			'icon'  => 'el el-th',
		];
	}
}
if ( ! function_exists( 'gulir_register_options_header_general' ) ) {
	function gulir_register_options_header_general() {

		return [
			'id'         => 'gulir_config_section_header_general',
			'title'      => esc_html__( 'Header Layout', 'gulir' ),
			'icon'       => 'el el-adjust-alt',
			'subsection' => true,
			'desc'       => esc_html__( 'Customize the layout and menu options for your site header.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'info_header_globally',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'The settings below will apply the layout to the entire website.', 'gulir' ),
				],
				[
					'id'    => 'info_header_individual',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Go to the "for Header x" panel to set up the layout and style to match the selected header layout.', 'gulir' ),
				],
				[
					'id'    => 'info_header_e_pro',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'If you want to use the Gulir Header and Footer in Elementor Pro, you need to delete both the HEADER and FOOTER templates in the "Theme Builder" panel if you have them.', 'gulir' ),
				],
				[
					'id'          => 'header_style',
					'type'        => 'select',
					'title'       => esc_html__( 'Header Layout', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a header layout for your site.', 'gulir' ),
					'options'     => gulir_config_header_style( false, false, true ),
					'description' => esc_html__( 'This is treated as a global setting. Other position settings take priority over this setting.', 'gulir' ),
					'default'     => '1',
				],
				[
					'id'          => 'header_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Template Shortcode', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode if you use a header template.', 'gulir' ),
					'required'    => [ 'header_style', '=', 'rb_template' ],
					'placeholder' => '[Ruby_E_Template id="1"]',
					'class'       => 'ruby-template-input',
					'rows'        => 1,
				],
			],
		];
	}
}
if ( ! function_exists( 'gulir_register_options_header_menu' ) ) {
	function gulir_register_options_header_menu() {

		return [
			'id'         => 'gulir_config_section_main_menu',
			'title'      => esc_html__( 'Main Menu', 'gulir' ),
			'icon'       => 'el el-compass',
			'subsection' => true,
			'desc'       => esc_html__( 'Customize the main menu and sub-level menu. These settings will apply to all predefined headers.', 'gulir' ),
			'fields'     => [
				[
					'id'     => 'section_start_main_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Navigation (Top Level)', 'gulir' ),
					'notice' => [
						esc_html__( 'The settings below will apply only to predefined headers.', 'gulir' ),
						esc_html__( 'Navigate to "Edit Template with Elementor > Your Header Section > Gulir - for Header Template > Sticky Header" to enable the sticky feature if you use a header template.', 'gulir' ),
					],
					'indent' => true,
				],
				[
					'id'       => 'menu_hover_effect',
					'type'     => 'select',
					'title'    => esc_html__( 'Menu Hover Effect', 'gulir' ),
					'subtitle' => esc_html__( 'This setting will apply to top level menu items.', 'gulir' ),
					'options'  => [
						'1' => esc_html__( 'Default (Color Border)', 'gulir' ),
						'2' => esc_html__( 'Style 2 (Opacity)', 'gulir' ),
						'3' => esc_html__( 'Style 3 (Background)', 'gulir' ),
						'4' => esc_html__( 'Style 4 (Underline)', 'gulir' ),
					],
					'default'  => '1',
				],
				[
					'id'       => 'sticky',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sticky Main Menu', 'gulir' ),
					'subtitle' => esc_html__( 'Keep the main menu bar visible while scrolling.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'smart_sticky',
					'type'     => 'switch',
					'title'    => esc_html__( 'Smart Sticky', 'gulir' ),
					'required' => [ 'sticky', '=', true ],
					'subtitle' => esc_html__( 'Enable to stick the menu bar only when scrolling upward.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'menu_glass_effect',
					'type'     => 'switch',
					'title'    => esc_html__( 'Glass Effect', 'gulir' ),
					'required' => [ 'sticky', '=', true ],
					'subtitle' => esc_html__( 'Enable a frosted glass effect for the header bar when it becomes sticky during scrolling.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'          => 'menu_template_glass_effect',
					'type'        => 'switch',
					'title'       => esc_html__( 'Glass Effect for Header Template', 'gulir' ),
					'required'    => [ 'menu_glass_effect', '=', true ],
					'subtitle'    => esc_html__( 'Also apply the glass effect to containers with sticky headers enabled in Ruby Templates.', 'gulir' ),
					'description' => esc_html__( 'To apply the glass effect manually, disable this setting, then add the "rb-glass-effect" selector under Advanced > CSS Classes in the section settings where you want the effect to appear.', 'gulir' ),
					'default'     => false,
				],
				[
					'id'          => 'menu_item_spacing',
					'title'       => esc_html__( 'Item Spacing', 'gulir' ),
					'subtitle'    => esc_html__( 'Set the left and right padding values for the main menu items.', 'gulir' ),
					'placeholder' => '12',
					'type'        => 'text',
					'class'       => 'small',
				],
				[
					'id'          => 'icon_item_spacing',
					'title'       => esc_html__( 'Menu Icon Spacing', 'gulir' ),
					'subtitle'    => esc_html__( 'Enter custom spacing (in pixel) between menu text and icon, if applicable.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply to all menus across the site.', 'gulir' ),
					'placeholder' => '5',
					'type'        => 'text',
					'class'       => 'small',
				],
				[
					'id'     => 'section_end_main_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_sub_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Sub-Level Menus', 'gulir' ),
					'notice' => [
						esc_html__( 'These settings apply to all sub-level menu dropdowns in the main menu across all predefined headers.', 'gulir' ),
						esc_html__( 'The background and text colors will also apply to the "More" section and other dropdown sections in the headers.', 'gulir' ),
						esc_html__( 'If these values are set, please make sure to configure the dark mode settings.', 'gulir' ),
					],
					'indent' => true,
				],
				[
					'id'          => 'hd1_sub_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color for the submenu and other dropdown sections of headers.', 'gulir' ),
					'description' => esc_html__( 'Please make sure the text color and "Mega Menu, Dropdown - Text Color Scheme" matches your background color.', 'gulir' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => [
						'from' => '',
						'to'   => '',
					],
				],
				[
					'id'          => 'hd1_sub_color',
					'title'       => esc_html__( 'Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color for displaying in sub menus and other dropdown sections of headers.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'hd1_sub_bg_hover',
					'title'       => esc_html__( 'Hover Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color when hovering.', 'gulir' ),
					'description' => esc_html__( 'Leave it blank to use the default (gray background).', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'hd1_sub_color_hover',
					'title'       => esc_html__( 'Hover Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color when hovering.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'submenu_radius',
					'type'        => 'text',
					'title'       => esc_html__( 'Border Radius', 'gulir' ),
					'subtitle'    => esc_html__( 'Enter a custom border radius for submenus and other dropdowns in the header.', 'gulir' ),
					'class'       => 'small',
					'placeholder' => '7',
				],
				[
					'id'          => 'submenu_shadow',
					'type'        => 'switch',
					'title'       => esc_html__( 'Wrapper Shadow/Border', 'gulir' ),
					'subtitle'    => esc_html__( 'Toggle the shadow or border effect around the submenu section.', 'gulir' ),
					'description' => esc_html__( 'Tip: Disable this option if you use a solid background for the submenu to improve visibility.', 'gulir' ),
					'default'     => true,
				],
				[
					'id'          => 'hd1_sub_scheme',
					'type'        => 'select',
					'title'       => esc_html__( 'Mega Menu, Dropdown - Text Color Scheme', 'gulir' ),
					'subtitle'    => esc_html__( 'Select color scheme for post listing for mega menus, live search, notifications, and the mini cart that match the sub-menu backgrounds.', 'gulir' ),
					'description' => esc_html__( 'Tips: Customize text and background for individual menu items in "Appearance > Menus".', 'gulir' ),
					'options'     => [
						'0' => esc_html__( 'Default (Dark Text)', 'gulir' ),
						'1' => esc_html__( 'Light Text', 'gulir' ),
					],
					'default'     => '0',
				],
				[
					'id'     => 'section_end_sub_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_dark_sub_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Dark Mode - Sub-Level Menus', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'dark_hd1_sub_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color for the submenu and other dropdown sections of headers in dark mode.', 'gulir' ),
					'description' => esc_html__( 'It is recommended to set DARK BACKGROUND to prevent issues with text color in the dropdown sections and mega menu.', 'gulir' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => [
						'from' => '',
						'to'   => '',
					],
				],
				[
					'id'          => 'dark_hd1_sub_color',
					'title'       => esc_html__( 'Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color for displaying in sub menus and other dropdown sections of headers in dark mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'dark_hd1_sub_bg_hover',
					'title'       => esc_html__( 'Hover Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color when hovering in dark mode.', 'gulir' ),
					'description' => esc_html__( 'Leave it blank to use the default (gray background).', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'dark_hd1_sub_color_hover',
					'title'       => esc_html__( 'Hover Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color when hovering in dark mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'     => 'section_end_dark_sub_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}
if ( ! function_exists( 'gulir_register_options_header_more' ) ) {
	function gulir_register_options_header_more() {

		return [
			'id'         => 'gulir_config_section_header_more',
			'title'      => esc_html__( 'More Menu Item', 'gulir' ),
			'icon'       => 'el el-braille',
			'subsection' => true,
			'desc'       => esc_html__( 'Customize the more dropdown section.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'info_more_icon',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'You can enable this menu item in the Header settings pane > More Menu Button.', 'gulir' ),
				],
				[
					'id'    => 'info_more_section',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Navigate to "Dashboard > Appearance > Widgets > More Menu Section" to add content for the dropdown section.', 'gulir' ),
				],
				[
					'id'          => 'more_column',
					'type'        => 'select',
					'title'       => esc_html__( 'Columns per Row', 'gulir' ),
					'subtitle'    => esc_html__( 'Select columns per row for the dropdown section.', 'gulir' ),
					'description' => esc_html__( 'Each widget is added in "Appearance >Widgets > More Menu Section" will be corresponding to a column.', 'gulir' ),
					'options'     => [
						'2' => esc_html__( '2 Columns', 'gulir' ),
						'3' => esc_html__( '3 Columns', 'gulir' ),
						'4' => esc_html__( '4 Columns', 'gulir' ),
						'5' => esc_html__( '5 Columns', 'gulir' ),
					],
					'default'     => '3',
				],
				[
					'id'          => 'more_width',
					'type'        => 'text',
					'class'       => 'small',
					'title'       => esc_html__( 'Dropdown Section Width', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a value (in px) for the width of the dropdown section.', 'gulir' ),
					'placeholder' => '450',
				],
				[
					'id'       => 'more_footer_menu',
					'type'     => 'select',
					'options'  => gulir_config_menu_slug(),
					'title'    => esc_html__( 'Footer Menu', 'gulir' ),
					'subtitle' => esc_html__( 'Select a footer menu to display at the bottom of this section.', 'gulir' ),
				],
				[
					'id'          => 'more_footer_copyright',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Footer Copyright', 'gulir' ),
					'subtitle'    => esc_html__( 'Enter the copyright text you want to display in the footer section. Raw HTML is allowed.', 'gulir' ),
					'description' => esc_html__( 'Use {year} in your text to automatically display the current year.', 'gulir' ),
					'placeholder' => esc_html__( 'e.g. © {year} YourSite. All rights reserved.', 'gulir' ),
					'rows'        => 1,
				],
				[
					'id'          => 'more_hover_color',
					'title'       => esc_html__( 'Link Hover Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a color for links in this section when hovering over them.', 'gulir' ),
					'description' => esc_html__( 'Leave this setting blank to use the global color settings.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
			],
		];
	}
}
if ( ! function_exists( 'gulir_register_options_header_search' ) ) {
	function gulir_register_options_header_search() {

		return [
			'id'         => 'gulir_config_section_header_search',
			'title'      => esc_html__( 'Header Search', 'gulir' ),
			'icon'       => 'el el-search',
			'subsection' => true,
			'desc'       => esc_html__( 'Select settings for search form to display in the website header.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'info_search_placeholder',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the placeholder text of the search form and icon style, navigate to "Theme Design > Search".', 'gulir' ),
				],
				[
					'id'    => 'info_search_mobile',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the search form on mobile devices, navigate to "Header > Mobile Header".', 'gulir' ),
				],
				[
					'id'          => 'header_search_heading',
					'type'        => 'text',
					'title'       => esc_html__( 'Search Heading', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a heading for displaying above the search form.', 'gulir' ),
					'description' => esc_html__( 'The heading will show in the "More" section and "Mobile Header Collapse" section.', 'gulir' ),
					'default'     => esc_html__( 'Search', 'gulir' ),
				],
				[
					'id'       => 'header_search_icon',
					'type'     => 'switch',
					'title'    => esc_html__( 'Header Search Icon', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the search icon in the header.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'          => 'header_search_mode',
					'type'        => 'select',
					'title'       => esc_html__( 'Search Form Appearance Mode', 'gulir' ),
					'subtitle'    => esc_html__( 'Choose how the search form appears when triggered by the search button.', 'gulir' ),
					'description' => esc_html__( 'Ensure the "More Menu Button" option is enabled in the Header settings if you select "Search Form Inside the More Menu Dropdown".', 'gulir' ),
					'options'     => [
						'search' => esc_html__( 'Standalone Search Form', 'gulir' ),
						'more'   => esc_html__( 'Search Form Inside the More Menu Dropdown', 'gulir' ),
					],
					'default'     => 'search',
				],
				[
					'id'          => 'ajax_search',
					'type'        => 'switch',
					'title'       => esc_html__( 'Live Search Result', 'gulir' ),
					'subtitle'    => esc_html__( 'Enable live search result when typing.', 'gulir' ),
					'description' => esc_html__( 'This setting will apply to predefined headers. To config the live search for header templates, check the "Header Search Icon" block.', 'gulir' ),
					'default'     => false,
				],
				[
					'id'       => 'ajax_search_limit',
					'title'    => esc_html__( 'Live Search Limit Posts', 'gulir' ),
					'subtitle' => esc_html__( 'Limit the number of posts displayed in live search results (maximum is 10).', 'gulir' ),
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
				],
				[
					'id'       => 'more_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'More Menu - Search Form', 'gulir' ),
					'subtitle' => esc_html__( 'Show search form at the top of the more section.', 'gulir' ),
					'default'  => true,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_header_notification' ) ) {
	function gulir_register_options_header_notification() {

		return [
			'id'         => 'gulir_config_section_header_notification',
			'title'      => esc_html__( 'Notification', 'gulir' ),
			'icon'       => 'el el-bell',
			'subsection' => true,
			'desc'       => esc_html__( 'Shows posts within 24 hours that allows users to receive real-time updates about new content that has been posted on your website.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'header_notification_info',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'The settings below will apply to the predefined headers. Please use "Header Notification Icon" for the header templates.', 'gulir' ),
				],
				[
					'id'       => 'header_notification',
					'type'     => 'switch',
					'title'    => esc_html__( 'Notification Section', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the notification section on the header.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'notification_duration',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Max Duration', 'gulir' ),
					'subtitle' => esc_html__( 'Enter the maximum duration value (hours ago) to retrieve new post data.', 'gulir' ),
					'default'  => 72,
				],
				[
					'id'       => 'notification_reload',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Reload Interval', 'gulir' ),
					'subtitle' => esc_html__( 'Enter the maximum duration value (in hours) to reload the data in the visitor\'s browser', 'gulir' ),
					'default'  => 12,
				],
				[
					'id'       => 'header_notification_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Destination', 'gulir' ),
					'subtitle' => esc_html__( 'Input a destination URL for the "Show More" text.', 'gulir' ),
					'default'  => '#',
				],
				[
					'id'          => 'notification_custom_icon',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Custom Notification SVG', 'gulir' ),
					'subtitle'    => esc_html__( 'Override the bell icon with a SVG icon.', 'gulir' ),
					'description' => esc_html__( 'Enable the option in "Theme Design > SVG Upload > SVG Supported" to upload SVG icons.', 'gulir' ),
				],
				[
					'id'          => 'notification_custom_icon_size',
					'title'       => esc_html__( 'Icon Size', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a custom size (in px) for the notification icon.', 'gulir' ),
					'placeholder' => '20',
					'type'        => 'text',
					'class'       => 'small',
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_header_mobile' ) ) {
	function gulir_register_options_header_mobile() {

		return [
			'id'         => 'gulir_config_section_header_mobile',
			'title'      => esc_html__( 'Mobile Header', 'gulir' ),
			'icon'       => 'el el-iphone-home',
			'subsection' => true,
			'desc'       => esc_html__( 'Customize the layout and style for your site header on mobile devices.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'info_mobile_navbar_typo',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To edit the typography, navigate to "Typography > Header Menus > Mobile Menu". Navigate to "Social Profiles" for the social list.', 'gulir' ),
				],
				[
					'id'    => 'info_mobile_header_color',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Color settings will apply to the tablet and mobile header. Leave blank to set as the desktop navigation colors.', 'gulir' ),
				],
				[
					'id'    => 'info_mobile_header_dark_color',
					'type'  => 'info',
					'style' => 'warning',
					'desc'  => esc_html__( 'Ensure "Dark Mode Colors" settings are set if you enable dark mode.', 'gulir' ),
				],
				[
					'id'       => 'section_start_mh_layout',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'General', 'gulir' ),
					'subtitle' => esc_html__( 'The center logo layout is best suited for small logos.', 'gulir' ),
					'indent'   => true,
				],
				[
					'id'       => 'mh_layout',
					'type'     => 'select',
					'title'    => esc_html__( 'Header Layout', 'gulir' ),
					'subtitle' => esc_html__( 'Select a layout for the mobile header.', 'gulir' ),
					'options'  => [
						'0' => esc_html__( 'Left Logo', 'gulir' ),
						'1' => esc_html__( 'Center Logo', 'gulir' ),
						'2' => esc_html__( 'Left Logo 2', 'gulir' ),
						'3' => esc_html__( 'Top Logo', 'gulir' ),
					],
					'default'  => '0',
				],
				[
					'id'          => 'mh_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'or Use Ruby Template for the Mobile Header', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode to display as a mobile header.', 'gulir' ),
					'description' => esc_html__( 'This setting will override the above setting. Leave it blank to use the predefined mobile header. In AMP mode, it will fallback to predefined header layout due to limitations of AMP.', 'gulir' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'class'       => 'ruby-template-input',
					'rows'        => 1,
				],
				[
					'id'       => 'mobile_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'Search Icon', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable search icon in the mobile header.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'       => 'mobile_amp_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'AMP Header - Search Icon', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable search icon the AMP header.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'          => 'mobile_height',
					'type'        => 'text',
					'class'       => 'small',
					'title'       => esc_html__( 'Mobile Navigation Height', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a custom value for the mobile navigation height.', 'gulir' ),
					'placeholder' => '42',
				],
				[
					'id'          => 'mlogo_height',
					'title'       => esc_html__( 'Mobile Logo Height', 'gulir' ),
					'subtitle'    => esc_html__( 'Enter a custom value for the mobile logo height.', 'gulir' ),
					'description' => esc_html__( 'This value should be equal to or less than the Mobile Navigation Height.', 'gulir' ),
					'type'        => 'text',
					'class'       => 'small',
					'placeholder' => '42',
				],
				[
					'id'          => 'quick_access_menu_height',
					'type'        => 'text',
					'class'       => 'small',
					'validate'    => 'numeric',
					'title'       => esc_html__( 'Quick View Menu Height', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a height value for the quick view menu bar.', 'gulir' ),
					'placeholder' => '42',
				],
				[
					'id'       => 'mh_divider',
					'type'     => 'select',
					'title'    => esc_html__( 'Divider Style', 'gulir' ),
					'subtitle' => esc_html__( 'Choose a style to visually separate the mobile header from the content beneath it.', 'gulir' ),
					'options'  => [
						'shadow' => esc_html__( 'Shadow', 'gulir' ),
						'gray'   => esc_html__( 'Gray Border', 'gulir' ),
						'dark'   => esc_html__( 'Dark Border', 'gulir' ),
						'none'   => esc_html__( 'None', 'gulir' ),
					],
					'default'  => 'shadow',
				],
				[
					'id'          => 'mh_top_divider',
					'type'        => 'select',
					'title'       => esc_html__( 'for Top Logo  - Divider', 'gulir' ),
					'subtitle'    => esc_html__( 'Choose a divider style specifically for the top logo mobile layout.', 'gulir' ),
					'description' => esc_html__( 'Only applies when using the "Top Logo" mobile header layout.', 'gulir' ),
					'options'     => [
						'shadow' => esc_html__( 'Shadow', 'gulir' ),
						'gray'   => esc_html__( 'Gray Border', 'gulir' ),
						'dark'   => esc_html__( 'Dark Border', 'gulir' ),
						'none'   => esc_html__( 'None', 'gulir' ),
					],
					'default'     => 'gray',
				],
				[
					'id'     => 'section_end_mh_layout',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'       => 'section_start_mobile_collapse',
					'type'     => 'section',
					'class'    => 'ruby-section-start',
					'title'    => esc_html__( 'Collapse Section', 'gulir' ),
					'subtitle' => esc_html__( 'To edit the login button, navigate to "Header > Sign in Buttons".', 'gulir' ),
					'indent'   => true,
				],
				[
					'id'       => 'mobile_sub_col',
					'type'     => 'select',
					'title'    => esc_html__( 'Sub-menu Columns', 'gulir' ),
					'subtitle' => esc_html__( 'Select the number of columns per row for the submenus.', 'gulir' ),
					'options'  => [
						'0' => esc_html__( '2 Columns', 'gulir' ),
						'1' => esc_html__( '1 Column', 'gulir' ),
					],
					'default'  => '0',
				],
				[
					'id'          => 'mobile_search_form',
					'type'        => 'switch',
					'title'       => esc_html__( 'Search Form', 'gulir' ),
					'subtitle'    => esc_html__( 'Enable or disable the search form.', 'gulir' ),
					'description' => esc_html__( 'Live search will be disabled in this form.', 'gulir' ),
					'default'     => true,
				],
				[
					'id'       => 'mobile_social',
					'type'     => 'switch',
					'title'    => esc_html__( 'Social Icons', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the social icons.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'       => 'mobile_footer_menu',
					'type'     => 'select',
					'options'  => gulir_config_menu_slug(),
					'title'    => esc_html__( 'Footer Menu', 'gulir' ),
					'subtitle' => esc_html__( 'Select a footer menu to display at the bottom of this section.', 'gulir' ),
				],
				[
					'id'          => 'mobile_copyright',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Footer Copyright', 'gulir' ),
					'subtitle'    => esc_html__( 'Enter the copyright text you want to display in the footer section. Raw HTML is allowed.', 'gulir' ),
					'description' => esc_html__( 'Use {year} in your text to automatically display the current year.', 'gulir' ),
					'placeholder' => esc_html__( 'e.g. © {year} YourSite. All rights reserved.', 'gulir' ),
					'rows'        => 1,
				],
				[
					'id'     => 'section_end_mobile_collapse',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_collapse_template',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Collapse Section Template', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'collapse_template',
					'type'        => 'textarea',
					'title'       => esc_html__( 'Collapse Template Shortcode', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a Ruby Template shortcode to display in the mobile collapsed section.', 'gulir' ),
					'placeholder' => '[Ruby_E_Template id="1"]',
					'class'       => 'ruby-template-input',
					'rows'        => 1,
				],
				[
					'id'          => 'collapse_template_display',
					'type'        => 'select',
					'title'       => esc_html__( 'Display Conditional', 'gulir' ),
					'subtitle'    => esc_html__( 'Choose the display for the Collapse Template', 'gulir' ),
					'description' => esc_html__( 'If you choose to replace the default layout, all default elements such as the menu and socials will be disabled. The Collapse section will only display the template.', 'gulir' ),
					'options'     => [
						'0'       => esc_html__( 'After Mobile Menu', 'gulir' ),
						'replace' => esc_html__( 'Replace Default Layout', 'gulir' ),
					],
					'required'    => [ 'collapse_template', 'not_empty', '' ],
					'default'     => '0',
				],
				[
					'id'     => 'section_end_collapse_template',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_mh_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Colors', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'mobile_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Header Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color for the mobile navigation bar and quick view mobile menu.', 'gulir' ),
					'description' => esc_html__( 'Use the "To" option to set a gradient background.', 'gulir' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => [
						'from' => '',
						'to'   => '',
					],
				],
				[
					'id'          => 'mobile_color',
					'title'       => esc_html__( 'Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color for toggle button, search, quick view menu for displaying on the mobile header.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'mobile_sub_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Collapse Section Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color for the collapsed section.', 'gulir' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => [
						'from' => '',
						'to'   => '',
					],
				],
				[
					'id'          => 'mobile_sub_color',
					'title'       => esc_html__( 'Collapse Section - Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color for menu item, sub menu item and other elements for displaying in the collapsed section.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'     => 'section_end_mh_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_mh_dark_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Dark Mode Colors', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'dark_mobile_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Header Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color for the mobile navigation bar and quick view mobile menu in dark mode.', 'gulir' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => [
						'from' => '',
						'to'   => '',
					],
				],
				[
					'id'          => 'dark_mobile_color',
					'title'       => esc_html__( 'Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color for toggle button, search, quick view menu for displaying on the mobile header in dark mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'          => 'dark_mobile_sub_background',
					'type'        => 'color_gradient',
					'title'       => esc_html__( 'Collapse Section Background', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a background color for the collapsed section in dark mode.', 'gulir' ),
					'validate'    => 'color',
					'transparent' => false,
					'default'     => [
						'from' => '',
						'to'   => '',
					],
				],
				[
					'id'          => 'dark_mobile_sub_color',
					'title'       => esc_html__( 'Collapse Section - Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select a text color for menu item, sub menu item and other elements for displaying in the collapsed section in dark mode.', 'gulir' ),
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
				],
				[
					'id'     => 'section_end_mh_dark_colors',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_header_login' ) ) {
	function gulir_register_options_header_login() {

		return [
			'id'         => 'gulir_config_section_header_login',
			'title'      => esc_html__( 'Sign In Buttons', 'gulir' ),
			'icon'       => 'el el-circle-arrow-right',
			'desc'       => esc_html__( 'Customize the logo buttons in the header.', 'gulir' ),
			'subsection' => true,
			'fields'     => [
				[
					'id'    => 'login_popup_info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To config the popup login form. Please navigate to "Theme Options > Login > Popup Sign In".', 'gulir' ),
				],
				[
					'id'     => 'section_start_login_button',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'for Desktop', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'header_login_icon',
					'type'     => 'switch',
					'title'    => esc_html__( 'Sign In Button', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the sign in button on the header.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'header_login_layout',
					'type'     => 'select',
					'title'    => esc_html__( 'Button Layout', 'gulir' ),
					'subtitle' => esc_html__( 'Select a layout for the sign in trigger button.', 'gulir' ),
					'options'  => [
						'0' => esc_html__( 'Icon', 'gulir' ),
						'1' => esc_html__( 'Text Button', 'gulir' ),
						'2' => esc_html__( 'Text with Icon Button', 'gulir' ),
					],
					'default'  => '0',
				],
				[
					'id'       => 'logged_gravatar',
					'type'     => 'switch',
					'title'    => esc_html__( 'Logged Gravatar', 'gulir' ),
					'subtitle' => esc_html__( 'Display the user Gravatar in the welcome label.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'     => 'section_end_login_button',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_mobile_login_button',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'for Mobile', 'gulir' ),
					'indent' => true,
				],
				[
					'id'       => 'mobile_login',
					'type'     => 'switch',
					'title'    => esc_html__( 'Mobile Header - Sign In', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the sign in button in the mobile collapsible section.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'          => 'mobile_login_label',
					'type'        => 'text',
					'title'       => esc_html__( 'Sign In Label', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a custom sign in label.', 'gulir' ),
					'placeholder' => esc_html__( 'Have an existing account?', 'gulir' ),
				],
				[
					'id'     => 'section_end_mobile_login_button',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_logged_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Logged User Menu', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'header_login_menu',
					'type'        => 'select',
					'title'       => esc_html__( 'User Dashboard Menu', 'gulir' ),
					'subtitle'    => esc_html__( 'Assign a menu for displaying when hovering on the login icon if user logged.', 'gulir' ),
					'options'     => gulir_config_menu_slug(),
					'placeholder' => esc_html__( '- Assign a Menu -', 'gulir' ),
				],
				[
					'id'       => 'header_login_menu_mobile',
					'type'     => 'switch',
					'title'    => esc_html__( 'User Dashboard Menu for Mobile', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the "User Dashboard Menu" in the collapsed section when the user is logged in.', 'gulir' ),
					'default'  => true,
				],
				[
					'id'     => 'section_end_logged_menu',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_login_icon',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Icon', 'gulir' ),
					'indent' => true,
				],
				[
					'id'          => 'login_custom_icon',
					'type'        => 'media',
					'url'         => true,
					'preview'     => true,
					'title'       => esc_html__( 'Custom Login SVG', 'gulir' ),
					'subtitle'    => esc_html__( 'Override the user icon with a SVG icon.', 'gulir' ),
					'description' => esc_html__( 'Enable the option in "Theme Design > SVG Upload > SVG Supported" if you cannot upload .SVG files.', 'gulir' ),
				],
				[
					'id'          => 'login_custom_icon_size',
					'title'       => esc_html__( 'Icon Size', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a custom size (in px) for the login icon.', 'gulir' ),
					'placeholder' => '20',
					'type'        => 'text',
					'class'       => 'small',
				],
				[
					'id'     => 'section_end_login_icon',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_header_alert' ) ) {
	function gulir_register_options_header_alert() {

		return [
			'id'         => 'gulir_config_section_header_alert',
			'title'      => esc_html__( 'Alert Bar', 'gulir' ),
			'icon'       => 'el el-bell',
			'subsection' => true,
			'desc'       => esc_html__( 'Show an alert or event information at the bottom of the navigation.', 'gulir' ),
			'fields'     => [
				[
					'id'       => 'info_alert_builder',
					'type'     => 'info',
					'style'    => 'info',
					'subtitle' => esc_html__( 'Template Builder: You can add text and button features to create an alert bar for the Elementor header templates.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'       => 'alert_bar_info',
					'type'     => 'info',
					'style'    => 'warning',
					'subtitle' => esc_html__( 'The alert bar will not be available when using a header template.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'          => 'alert_bar',
					'type'        => 'switch',
					'title'       => esc_html__( 'Alert Bar', 'gulir' ),
					'subtitle'    => esc_html__( 'Enable or disable the alert bar below the header.', 'gulir' ),
					'description' => esc_html__( 'This is treated as a global setting. Other individual post and page settings take priority over this setting.', 'gulir' ),
					'default'     => false,
				],
				[
					'id'       => 'alert_home',
					'type'     => 'switch',
					'title'    => esc_html__( 'Homepage Only', 'gulir' ),
					'subtitle' => esc_html__( 'Only show the bar in the homepage.', 'gulir' ),
					'required' => [ 'alert_bar', '=', true ],
					'default'  => true,
				],
				[
					'id'       => 'alert_content',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Alert Content', 'gulir' ),
					'subtitle' => esc_html__( 'Input your alert content to show.', 'gulir' ),
					'rows'     => 2,
					'required' => [ 'alert_bar', '=', true ],
				],
				[
					'id'       => 'alert_url',
					'type'     => 'text',
					'title'    => esc_html__( 'Alert URL', 'gulir' ),
					'subtitle' => esc_html__( 'Input your alert URL.', 'gulir' ),
					'required' => [ 'alert_bar', '=', true ],
					'default'  => '#',
				],
				[
					'id'          => 'alert_bg',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Background Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select background color for this section.', 'gulir' ),
					'required'    => [ 'alert_bar', '=', true ],
				],
				[
					'id'          => 'alert_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select text color for this section.', 'gulir' ),
					'required'    => [ 'alert_bar', '=', true ],
				],
				[
					'id'          => 'dark_alert_bg',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Dark Mode - Background Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select background color for this section in dark mode.', 'gulir' ),
					'required'    => [ 'alert_bar', '=', true ],
				],
				[
					'id'          => 'dark_alert_color',
					'type'        => 'color',
					'transparent' => false,
					'validate'    => 'color',
					'title'       => esc_html__( 'Dark Mode - Text Color', 'gulir' ),
					'subtitle'    => esc_html__( 'Select text color for this section in dark mode.', 'gulir' ),
					'required'    => [ 'alert_bar', '=', true ],
				],
				[
					'id'       => 'alert_sticky_hide',
					'title'    => esc_html__( 'Hide when Sticky', 'gulir' ),
					'subtitle' => esc_html__( 'Hide this bar when the navigation is sticking.', 'gulir' ),
					'type'     => 'switch',
					'required' => [ 'alert_bar', '=', true ],
					'default'  => false,
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_header_socials' ) ) {
	function gulir_register_options_header_socials() {
		return [
			'id'         => 'gulir_config_section_header_socials',
			'title'      => esc_html__( 'Social Icons', 'gulir' ),
			'icon'       => 'el el-facebook',
			'subsection' => true,
			'desc'       => esc_html__( 'Customize the social icons in the header.', 'gulir' ),
			'fields'     => [
				[
					'id'    => 'header_social_info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'To configure the social icons appearance, please navigate to Header Layout (select the style you used for your website) > Social Icons.', 'gulir' ),
				],
				[
					'id'    => 'header_social_profile_info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'Please navigate to Theme Options > Social Profiles to enter your site’s social profiles.', 'gulir' ),
				],
				[
					'id'          => 'social_custom_icon_size',
					'title'       => esc_html__( 'Icon Size', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a custom size (in px) for the social icon.', 'gulir' ),
					'placeholder' => '16',
					'type'        => 'text',
					'class'       => 'small',
				],
			],
		];
	}
}

if ( ! function_exists( 'gulir_register_options_header_cart' ) ) {
	function gulir_register_options_header_cart() {

		return [
			'id'         => 'gulir_config_section_mini_cart',
			'title'      => esc_html__( 'Mini Cart', 'gulir' ),
			'icon'       => 'el el-shopping-cart',
			'subsection' => true,
			'desc'       => esc_html__( 'Show a cart icon at the website header.', 'gulir' ),
			'fields'     => ! class_exists( 'WooCommerce' ) ? gulir_wc_plugin_status_info( 'header_mini_cart_warning' ) :
				[
					[
						'id'       => 'wc_mini_cart',
						'type'     => 'switch',
						'title'    => esc_html__( 'Header Mini Cart', 'gulir' ),
						'subtitle' => esc_html__( 'Show mini cart icon in the header.', 'gulir' ),
						'default'  => false,
					],
					[
						'id'       => 'wc_mobile_mini_cart',
						'type'     => 'switch',
						'title'    => esc_html__( 'Mobile Header - Mini Cart', 'gulir' ),
						'subtitle' => esc_html__( 'Show mini cart icon in the mobile header.', 'gulir' ),
						'default'  => false,
					],
					[
						'id'       => 'cart_counter',
						'type'     => 'switch',
						'title'    => esc_html__( 'Cart Counter', 'gulir' ),
						'subtitle' => esc_html__( 'Show number of products in the cart.', 'gulir' ),
						'default'  => true,
					],
					[
						'id'       => 'total_amount',
						'type'     => 'switch',
						'title'    => esc_html__( 'Total Amount', 'gulir' ),
						'subtitle' => esc_html__( 'Show total amount after the cart icon.', 'gulir' ),
						'default'  => false,
					],
					[
						'id'       => 'cart_custom_icon',
						'type'     => 'media',
						'title'    => esc_html__( 'Custom Cart SVG', 'gulir' ),
						'subtitle' => esc_html__( 'Override default cart icon with a SVG icon.', 'gulir' ),
					],
					[
						'id'          => 'cart_custom_icon_size',
						'title'       => esc_html__( 'Icon Size', 'gulir' ),
						'subtitle'    => esc_html__( 'Input a custom size (in px) for the cart icon.', 'gulir' ),
						'placeholder' => '20',
						'type'        => 'text',
						'class'       => 'small',
					],
				],
		];
	}
}
