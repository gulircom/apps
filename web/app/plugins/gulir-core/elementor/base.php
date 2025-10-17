<?php

namespace gulirElementor;
defined( 'ABSPATH' ) || exit;

class Plugin {

	private static $instance = null;


	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/** load elementor */
	public function __construct() {

		self::$instance = $this;

		if ( ! $this->get_activation() ) {
			return;
		}

		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ], 1 );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ], 0 );
	}


	/**
	 * Registers a custom Elementor widget category.
	 *
	 * This function adds a new category to the Elementor elements manager.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager The Elementor elements manager instance.
	 *
	 * @return void
	 */
	public function register_categories( $elements_manager ) {

		$elements_manager->add_category( 'gulir_flex',
			[
				'title' => esc_html__( 'Gulir - Flex', 'gulir-core' ),
			]
		);
		$elements_manager->add_category( 'gulir',
			[
				'title' => esc_html__( 'Gulir - Standard', 'gulir-core' ),
			]
		);
		$elements_manager->add_category( 'gulir_element',
			[
				'title' => esc_html__( 'Gulir - Element', 'gulir-core' ),
			]
		);
		$elements_manager->add_category( 'gulir_header',
			[
				'title' => esc_html__( 'Gulir Header', 'gulir-core' ),
			]
		);
		$elements_manager->add_category( 'gulir_podcast',
			[
				'title' => esc_html__( 'Gulir Podcast', 'gulir-core' ),
			]
		);
		$elements_manager->add_category( 'gulir_single',
			[
				'title' => esc_html__( 'Gulir Single', 'gulir-core' ),
			]
		);
	}

	/**
	 * Registers Elementor widgets.
	 *
	 * This function loads the necessary widget files and initializes the widgets.
	 *
	 * @return void
	 */
	public function register_widgets() {

		$this->load_files();

		$widgets = [
			'Block_Heading',
			'Classic_1',
			'Grid_1',
			'Grid_2',
			'Grid_Box_1',
			'Grid_Box_2',
			'Grid_Flex_1',
			'Grid_Flex_2',
			'Grid_Personalize_1',
			'Grid_Personalize_2',
			'Grid_Small_1',
			'List_1',
			'List_2',
			'list_Box_1',
			'list_Box_2',
			'List_Small_1',
			'List_Small_2',
			'List_Small_3',
			'List_Flex',
			'List_Personalize',
			'Overlay_1',
			'Overlay_2',
			'Overlay_Flex',
			'Overlay_Personalize',
			'Hierarchical_1',
			'Hierarchical_2',
			'Hierarchical_3',
			'Categories_List_1',
			'Categories_List_2',
			'Categories_List_3',
			'Categories_List_4',
			'Categories_List_5',
			'Categories_List_6',
			'Authors_List_1',
			'Authors_List_2',
			'Newsletter_1',
			'Newsletter_2',
			'Newsletter_3',
			'Playlist',
			'Quick_Links',
			'Breaking_News',
			'Covid_Data',
			'Ad_Image',
			'Ad_Script',
			'Block_Weather',
			'Social_Follower',
			'Banner',
			'Plan',
			'Logo',
			'Dark_Mode_Toggle',
			'Navigation',
			'Social_List',
			'Header_Search_Icon',
			'Header_Notification',
			'Mini_Cart',
			'Header_Login_Icon',
			'Header_Register_Link',
			'Font_Resizer_Icon',
			'Sidebar_Menu',
			'Header_Collapse_Toggle',
			'Header_Mobile_Search',
			'Header_Mobile_Cart',
			'Simple_Gallery',
			'Lightbox_Gallery',
			'Image',
			'Product_Grid',
			'Single_Title',
			'Single_Meta_Bar',
			'Single_Custom_Meta',
			'Single_Tagline',
			'Single_Category',
			'Single_Featured',
			'Single_Content',
			'Single_Author',
			'Single_Pagination',
			'Single_Comment',
			'Single_Related',
			'Single_Breadcrumb',
			'Search_Category',
			'CTA',
			'Archive_Title',
			'Archive_Description',
			'Taxonomy_Featured',
			'Web_Stories',
			'Web_Story',
			'Current_Date',
			'Login_Form',
			'Register_Form',
			'Tax_Accordion',
			'Popup_Template',
		];

		foreach ( apply_filters( 'gulir_elementor_registered_widgets', $widgets ) as $widget ) {
			$widget_name = 'gulirElementor\Widgets\\' . $widget;
			if ( class_exists( $widget_name ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register( new $widget_name() );
			}
		}
	}

	/**
	 * Checks if the activation is set.
	 *
	 * This function data from the database and checks
	 * whether its value is not 'unset'. It determines if activation is enabled.
	 *
	 * @return bool Returns true if the activation option is set, false otherwise.
	 */
	private function get_activation() {
		return ( get_option( 'ruby_activation', '' ) !== 'unset' );
	}

	/**
	 * Loads required Elementor widget files.
	 *
	 * This function includes various Elementor widget files needed for the application.
	 *
	 * @return void
	 */
	public function load_files() {

		require_once GULIR_CORE_PATH . 'elementor/widgets/ad-image.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/ad-script.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/archive-description.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/archive-title.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/author-box.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/authors-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/authors-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/banner.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/breaking-news.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/call-to-action.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/categories-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/categories-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/categories-3.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/categories-4.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/categories-5.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/categories-6.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/classic-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/collapse-toggle.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/covid-data.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/dark-toggle.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/date.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/font-resizer.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/gallery.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/gallery-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-box-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-box-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-flex-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-flex-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-personalize-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-personalize-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/grid-small-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/heading.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/hierarchical-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/hierarchical-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/hierarchical-3.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/image.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-box-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-box-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-flex.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-personalize.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-small-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-small-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/list-small-3.php';

		require_once GULIR_CORE_PATH . 'elementor/widgets/login-form.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/login-icon.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/logo.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/menu.php';

		require_once GULIR_CORE_PATH . 'elementor/widgets/mini-cart.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/mobile-mini-cart.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/mobile-search-icon.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/navigation.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/newsletter-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/newsletter-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/newsletter-3.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/notification-icon.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/overlay-1.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/overlay-2.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/overlay-flex.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/overlay-personalize.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/plan.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/product-grid.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/quick-links.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/register-form.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/register-link.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/search-category.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/search-icon.php';

		require_once GULIR_CORE_PATH . 'elementor/widgets/single-breadcrumb.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-category.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-comment.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-content.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-custom-meta.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-featured.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-meta-bar.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-pagination.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-related.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-tagline.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/single-title.php';

		require_once GULIR_CORE_PATH . 'elementor/widgets/social-follower.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/social-list.php';

		if ( gulir_is_plugin_active( 'web-stories/web-stories.php' ) ) {
			require_once GULIR_CORE_PATH . 'elementor/widgets/stories.php';
			require_once GULIR_CORE_PATH . 'elementor/widgets/story.php';
		}

		require_once GULIR_CORE_PATH . 'elementor/widgets/tax-accordion.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/tax-featured.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/videos.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/weather.php';
		require_once GULIR_CORE_PATH . 'elementor/widgets/popup-template.php';
	}
}

/** load plugin */
Plugin::get_instance();