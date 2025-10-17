<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

class RB_ADMIN_CORE {

	static $panel_slug = 'admin/templates/template';
	static $header = 'header';
	static $icon = 'dashicons-awards';
	static $recommended_plugins = [];
	protected static $instance = null;
	private static $theme_id = null;
	private static $core_plugin_id = null;
	private static $sub_pages;
	private static $dashboard_slug = 'gulir-admin';
	private static $nonce = 'gulir-admin';
	private static $license = null;
	public $panel_name = 'dashboard';
	public $panel_template = 'admin_template';
	private $params = [];

	/**
	 * Class constructor.
	 *
	 * Initializes the singleton instance and hooks the initialization method
	 * to the 'plugins_loaded' action.
	 */
	public function __construct() {
		self::$instance = $this;

		add_action( 'plugins_loaded', [ $this, 'init' ], 0 );
	}

	/**
	 * Retrieves the singleton instance of the class.
	 *
	 * If the instance does not exist, it creates a new one.
	 *
	 * @return self The singleton instance of the class.
	 */
	static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Prevents cloning of the instance.
	 *
	 * This ensures that the singleton pattern is maintained by
	 * preventing the object from being cloned.
	 *
	 * @return void
	 */
	public function __clone() {

		_doing_it_wrong( __FUNCTION__, esc_html__( 'Not allowed!', 'gulir-core' ), GULIR_CORE_VERSION );
	}

	/**
	 * Prevents unserializing of the instance.
	 *
	 * This protects the singleton instance from being unserialized,
	 * which could lead to multiple instances.
	 *
	 * @return void
	 */
	public function __wakeup() {

		_doing_it_wrong( __FUNCTION__, esc_html__( 'Not allowed!', 'gulir-core' ), GULIR_CORE_VERSION );
	}

	/**
	 * Initializes the Gulir Admin functionality.
	 *
	 * This function checks if the current user has the necessary permissions
	 * before proceeding with the initialization.
	 *
	 * @return void
	 */
	function init() {

		$this->get_configs();

		// Admin Only
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$this->subpage_files();

		add_action( 'init', [ $this, 'get_params' ], 0 );
		add_action( 'admin_menu', [ $this, 'register_dashboard' ], 0 );
		add_action( 'admin_menu', [ $this, 'register_subpages' ], 50 );
		add_action( 'admin_menu', [ $this, 'register_system_info' ], PHP_INT_MAX );

		add_action( 'wp_ajax_rb_recommended_plugin', [ $this, 'recommended_plugin' ] );

		add_action( 'redux/' . GULIR_TOS_ID . '/panel/before', [ $this, 'header_template' ] );
		add_action( 'admin_init', [ 'Gulir_Admin_Information', 'get_instance' ], 25 );
		add_action( 'admin_init', [ 'Ruby_Importer', 'get_instance' ], 10 );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ], 15 );
		add_filter( 'http_request_args', [ $this, 'set_headers' ], PHP_INT_MAX, 2 );
		add_filter( 'gulir_elementor_registered_widgets', [ $this, 'register_widgets' ], 10, 2 );

	}

	/**
	 * Retrieves and sets theme configuration values.
	 *
	 * This function assigns various configuration values related to the theme,
	 * ensuring they are properly defined before use.
	 *
	 * @return void
	 */
	private function get_configs() {

		self::$theme_id       = RUBY_THEME_NAME;
		self::$core_plugin_id = RUBY_THEME_NAME . '-core/' . RUBY_THEME_NAME . '-core.php';
		self::$sub_pages      = $this->set_sub_pages();
	}

	/**
	 * Sets the sub-pages for the admin panel based on purchase code availability.
	 *
	 * @return array The list of sub-pages with their respective classes and paths.
	 */
	public function set_sub_pages() {

		$args = [];

			$args[] = [
				'class' => 'Translation',
				'path'  => 'admin/translation/translation.php',
			];
			$args[] = [
				'class' => 'AdobeFonts',
				'path'  => 'admin/fonts/fonts.php',
			];
			$args[] = [
				'class' => 'GTM',
				'path'  => 'admin/gtm/gtm.php',
			];
		

		return $args;
	}


	/**
	 * Loads required subpage files.
	 *
	 * Iterates through the list of subpages and includes the corresponding files.
	 *
	 * @return void
	 */
	public function subpage_files() {

		$pages = self::$sub_pages;

		array_push( $pages, [
			'class' => 'SystemInfo',
			'path'  => 'admin/system-info/system-info.php',
		] );

		foreach ( $pages as $sub_page ) {
			if ( ! empty( $sub_page['path'] ) ) {
				require_once GULIR_CORE_PATH . $sub_page['path'];
			}
		}
	}


	/**
	 * Retrieve and parse core parameters.
	 *
	 * This method initializes the `$params` property by merging the default values
	 * with the existing license data.
	 */
	public function get_params() {

		$this->params = wp_parse_args( self::$license, [
			'title'               => esc_html__( 'Gulir', 'gulir-core' ),
			'system_info'         => $this->get_system_info(),
			'menu'                => $this->get_dashboard_menu(),
			'step'                => get_option( 'gulir_setup_current_step', 1 ),
			'can_install_plugins' => current_user_can( 'install_plugins' ),
		] );
	}


	/**
	 * Retrieves system environment information including PHP version, memory limit, and server details.
	 *
	 * This function provides an array of system information used for debugging and compatibility checks.
	 *
	 * @return array An associative array containing system details.
	 */
	public function get_system_info() {

		return [
			'php_version'     => [
				'title'   => esc_html__( 'PHP Version', 'gulir-core' ),
				'value'   => phpversion(),
				'min'     => '5.6',
				'passed'  => version_compare( phpversion(), '7.0.0' ) >= 0,
				'warning' => esc_html__( 'WordPress recommended PHP version 7.0 or greater to get better performance for your site.', 'gulir-core' ),
			],
			'memory_limit'    => [
				'title'   => esc_html__( 'Memory Limit', 'gulir-core' ),
				'value'   => size_format( wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) ) ),
				'min'     => '64M',
				'passed'  => wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) ) >= 67108864,
				'warning' => esc_html__( 'The memory_limit value is set low. The theme recommended this value to be at least 64MB for the theme in order to work.', 'gulir-core' ),
			],
			'max_input_vars'  => [
				'title'   => esc_html__( 'Max Input Vars', 'gulir-core' ),
				'value'   => ini_get( 'max_input_vars' ),
				'min'     => '3000',
				'passed'  => (int) ini_get( 'max_input_vars' ) >= 2000,
				'warning' => esc_html__( 'The max_input_vars value is set low. The theme recommended this value to be at least 3000.', 'gulir-core' ),
			],
			'post_max_size'   => [
				'title'   => esc_html__( 'Post Max Size', 'gulir-core' ),
				'value'   => ini_get( 'post_max_size' ),
				'min'     => '32',
				'passed'  => (int) ini_get( 'post_max_size' ) >= 32,
				'warning' => esc_html__( 'The post_max_size value is set low. We recommended this value to be at least 32M.', 'gulir-core' ),
			],
			'max_upload_size' => [
				'title'   => esc_html__( 'Max Upload Size', 'gulir-core' ),
				'value'   => size_format( wp_max_upload_size() ),
				'min'     => '32',
				'passed'  => (int) wp_max_upload_size() >= 33554432,
				'warning' => esc_html__( 'The post_max_size value is set low. We recommended this value to be at least 32M.', 'gulir-core' ),
			],
			'zip_archive'     => [
				'title'   => esc_html__( 'ZipArchive Support', 'gulir-core' ),
				'value'   => class_exists( '\ZipArchive' ) ? 'Yes' : 'No',
				'passed'  => class_exists( '\ZipArchive' ),
				'warning' => esc_html__( 'ZipArchive can be used to autonomously update the theme.', 'gulir-core' ),
			],
		];
	}

	/**
	 * Retrieves the dashboard menu structure.
	 *
	 * This function returns an array of menu items for the dashboard,
	 * including system info and other sections based on validation.
	 *
	 * @return array The structured dashboard menu items.
	 */
	public function get_dashboard_menu() {

		$menus              = [];
		$is_imported        = get_option( '_rb_flag_imported', false );
		$import_menu        = [
			'title' => esc_html__( 'Demo Importer', 'gulir-core' ),
			'icon'  => 'rbi-dash-layer',
			'url'   => $this->get_admin_menu_url( 'rb-demo-importer' ),
		];
		$menus['dashboard'] = [
			'title' => esc_html__( 'Dashboard', 'gulir-core' ),
			'icon'  => 'rbi-dash-dashboard',
			'url'   => $this->get_admin_menu_url( self::$dashboard_slug ),
		];
		if ( ! $is_imported ) {
			$menus['import'] = $import_menu;
		}
		$menus['options'] = [
			'title' => esc_html__( 'Theme Options', 'gulir-core' ),
			'icon'  => 'rbi-dash-option',
			'url'   => $this->get_admin_menu_url( 'ruby-options' ),
		];
		$menus['more']    = [
			'title'     => esc_html__( 'Extra Features', 'gulir-core' ),
			'icon'      => 'rbi-dash-more',
			'url'       => '#',
			'sub_items' => [],
		];
		if ( $is_imported ) {
			$menus['more']['sub_items']['import'] = $import_menu;
		}
		$menus['more']['sub_items']['translation'] = [
			'title' => esc_html__( 'Quick Translation', 'gulir-core' ),
			'icon'  => 'rbi-dash-translate',
			'url'   => $this->get_admin_menu_url( 'ruby-translation' ),
		];
		$menus['more']['sub_items']['adobe']       = [
			'title' => esc_html__( 'Adobe Fonts', 'gulir-core' ),
			'icon'  => 'rbi-dash-adobe',
			'url'   => $this->get_admin_menu_url( 'ruby-adobe-fonts' ),
		];
		$menus['more']['sub_items']['gtm']         = [
			'title' => esc_html__( 'Analytics 4', 'gulir-core' ),
			'icon'  => 'rbi-dash-gtm',
			'url'   => $this->get_admin_menu_url( 'ruby-gmt-integration' ),
		];
		$menus['more']['sub_items']['openai']      = [
			'title' => esc_html__( 'OpenAI Assistant', 'gulir-core' ),
			'icon'  => 'rbi-dash-openai',
			'url'   => $this->get_admin_menu_url( 'ruby-openai' ),
		];

		if ( gulir_is_plugin_active( 'bbpress/bbpress.php' ) ) {
			$menus['more']['sub_items']['bbpress'] = [
				'title' => esc_html__( 'bbPress Forums', 'gulir-core' ),
				'icon'  => 'rbi-dash-chat',
				'url'   => $this->get_admin_menu_url( 'ruby-bbp-supported' ),
			];
		}

		$menus['system'] = [
			'title' => esc_html__( 'System Info', 'gulir-core' ),
			'icon'  => 'rbi-dash-info',
			'url'   => $this->get_admin_menu_url( 'ruby-system-info' ),
		];

		return $menus;
	}

	/**
	 * Generates the full URL for a given admin menu page.
	 *
	 * This function constructs an admin panel URL based on the provided menu slug.
	 *
	 * @param string $menu_slug The slug of the admin menu page.
	 *
	 * @return string The full admin menu URL.
	 */
	private function get_admin_menu_url( $menu_slug ) {
		return admin_url( add_query_arg( 'page', $menu_slug, 'admin.php' ) );
	}

	/**
	 * Registers the enqueue action for loading assets in the WordPress admin panel.
	 *
	 * This function hooks into 'admin_enqueue_scripts' to enqueue necessary assets
	 * for the plugin or theme. The priority is set to 25 to ensure assets are loaded
	 * at the appropriate time.
	 *
	 * @return void
	 */
	public function load_assets() {

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ], 25 );
	}

	/**
	 * Registers and enqueues JavaScript and CSS assets for the admin dashboard.
	 *
	 * This function determines the appropriate CSS file based on the site's text direction
	 * (LTR or RTL) and registers the necessary assets.
	 *
	 * @return void
	 */
	public function register_assets() {

		$css_path = ! is_rtl() ? 'dashboard' : 'dashboard-rtl';
		wp_enqueue_style( 'rb-admin-style', plugins_url( GULIR_REL_PATH . '/admin/assets/' . $css_path . '.css' ), [], GULIR_CORE_VERSION, 'all' );
		wp_register_script( 'rb-searcher', plugins_url( GULIR_REL_PATH . '/admin/assets/searcher.js' ), [ 'jquery' ], GULIR_CORE_VERSION, true );
		wp_register_script( 'rb-admin-script', plugins_url( GULIR_REL_PATH . '/admin/assets/panel.js' ), [
			'jquery',
			'wp-util',
			'rb-searcher',
		], GULIR_CORE_VERSION, true );
		wp_localize_script( 'rb-admin-script', 'gulirAdminCore', $this->localize_params() );
	}

	/**
	 * Filters and returns localized parameters for the admin interface.
	 *
	 * This function allows modification of admin-related parameters through the
	 * 'rb_admin_' filter hook before returning them.
	 *
	 * @return mixed The filtered parameters for admin use.
	 */
	public function localize_params() {

		return apply_filters( 'rb_admin_localize_data', [
			'ajaxUrl'                => admin_url( 'admin-ajax.php' ),
			'_rbNonce'               => wp_create_nonce( self::$nonce ),
			'updating'               => esc_html__( 'Updating...', 'gulir-core' ),
			'reload'                 => esc_html__( 'Reload...', 'gulir-core' ),
			'error'                  => esc_html__( 'Error!', 'gulir-core' ),
			'confirmDeleteImporter'  => esc_html__( 'Are you sure you want to delete the imported content? This action cannot be undone.', 'gulir-core' ),
			'confirmUpdateExp'       => esc_html__( 'Revalidate the support period and update demo data?', 'gulir-core' ),
			'confirmDeleteAdobeFont' => esc_html__( 'Are you sure to delete this font project?', 'gulir-core' ),
			'confirmDeactivate'      => esc_html__( 'Are you sure you want to deactivate the current license? This action could lead to site errors or disruptions.', 'gulir-core' ),
			'confirmDeleteGA'        => esc_html__( 'Are you sure to delete the Google Tag?', 'gulir-core' ),
		] );
	}

	/**
	 * Enqueues admin JavaScript assets.
	 *
	 * This function enqueues the 'rb-admin-script' JavaScript file for use in the
	 * WordPress admin panel.
	 *
	 * @return void
	 */
	public function enqueue_assets() {

		wp_enqueue_script( 'rb-admin-script' );
	}

	/**
	 * Renders the admin panel template.
	 *
	 * This function outputs the header template and the main admin template part
	 * based on the specified panel slug and panel name.
	 *
	 * @return void
	 */
	public function admin_template() {

		$this->header_template();
		echo rb_admin_get_template_part( self::$panel_slug, $this->panel_name, $this->params );
	}

	/**
	 * Renders the admin panel header template.
	 *
	 * This function outputs the header section of the admin panel.
	 *
	 * @return void
	 */
	public function header_template() {

		echo rb_admin_get_template_part( self::$panel_slug, self::$header, $this->params );
	}

	/**
	 * Registers the dashboard menu in the WordPress admin panel.
	 *
	 * This function adds a custom dashboard page if the theme is active.
	 *
	 * @return void
	 */
	public function register_dashboard() {

		if ( ! defined( 'GULIR_THEME_VERSION' ) ) {
			return;
		}

		$panel_title = esc_html__( 'Gulir', 'gulir-core' );

		$panel_hook_suffix = add_menu_page( $panel_title, $panel_title, 'manage_options', self::$dashboard_slug,
			[ $this, $this->panel_template ], self::$icon, 3 );

		add_action( 'load-' . $panel_hook_suffix, [ $this, 'load_assets' ] );
	}

	/**
	 * Registers subpages in the WordPress admin menu.
	 *
	 * This function checks if the theme is defined and if subpages exist before registering them.
	 *
	 * @return void
	 */
	public function register_subpages() {

		if ( ! defined( 'GULIR_THEME_VERSION' ) || empty( self::$sub_pages ) ) {
			return;
		}

		global $submenu;
		foreach ( self::$sub_pages as $sub_page ) {

			if ( empty( $sub_page['class'] ) || empty( $sub_page['path'] ) ) {
				continue;
			}

			$class_name = 'rbSubPage' . $sub_page['class'];
			$sub_page   = new $class_name();
			if ( ! empty( $sub_page->menu_slug ) ) {
				$page_hook_suffix = add_submenu_page( self::$dashboard_slug, $sub_page->page_title, $sub_page->menu_title, $sub_page->capability, $sub_page->menu_slug,
					[ $sub_page, 'render' ], $sub_page->position );
				add_action( 'load-' . $page_hook_suffix, [ $this, 'load_assets' ] );
			}
		}

		if ( isset( $submenu[ self::$dashboard_slug ][0][0] ) ) {
			$submenu[ self::$dashboard_slug ][0][0] = $this->get_dashboard_label();
		}
	}

	/**
	 * Retrieves the dashboard label based on the activation.
	 *
	 * @return string The localized dashboard label.
	 */
	public function get_dashboard_label() {

		return esc_html__( 'Home', 'gulir-core' );

	}

	/**
	 * Registers the System Info subpage in the WordPress admin panel.
	 *
	 * This function adds a "System Info" subpage under the main dashboard menu.
	 *
	 * @return void
	 */
	public function register_system_info() {

		$sub_page = [
			'class' => 'SystemInfo',
			'path'  => 'admin/system-info/system-info.php',
		];

		$class_name = 'rbSubPage' . $sub_page['class'];
		$sub_page   = new $class_name();

		if ( ! empty( $sub_page->menu_slug ) ) {
			$page_hook_suffix = add_submenu_page( self::$dashboard_slug, $sub_page->page_title, $sub_page->menu_title, $sub_page->capability, $sub_page->menu_slug,
				[ $sub_page, 'render' ] );
			add_action( 'load-' . $page_hook_suffix, [ $this, 'load_assets' ] );
		}
	}

	/**
	 * Filters and returns the registered widgets.
	 *
	 * This function checks if widgets are registered and returns them;
	 * otherwise, it returns an empty array.
	 *
	 * @param array $widgets The array of widgets to be registered.
	 *
	 * @return array The filtered array of widgets.
	 */
	public function register_widgets( $widgets ) {
		return $widgets;
	}

	/**
	 *
	 * This function checks if the request is targeting the WordPress theme update API
	 * and processes the request data accordingly.
	 *
	 * @param array $request The original request arguments.
	 * @param string $url The request URL being checked.
	 *
	 * @return mixed The modified request arguments or processed data.
	 */
	public function set_headers( $request, $url ) {

		if ( false !== strpos( $url, '//api.wordpress.org/themes/update-check/1.1/' ) ) {
			$data = json_decode( $request['body']['themes'] );
			unset( $data->themes->{self::$theme_id} );
			$request['body']['themes'] = wp_json_encode( $data );
		} elseif ( false !== strpos( $url, '//api.wordpress.org/plugins/update-check/1.1/' ) ) {

			$data = json_decode( $request['body']['plugins'] );
			unset( $data->plugins->{self::$core_plugin_id} );

			$request['body']['plugins'] = wp_json_encode( $data );
		} elseif ( false !== strpos( $url, RUBY_API_HOST ) ) {
			$request['headers'] = $this->get_headers();
		}

		return $request;
	}


	/**
	 * Retrieves information about the WordPress environment.
	 *
	 * This function returns an array containing details such as the WordPress version,
	 * debug mode status, site URL, and multisite configuration.
	 *
	 * @return array An associative array of WordPress system details.
	 */
	public function get_wp_info() {

		return [
			'wp_version'    => [
				'title' => esc_html__( 'WordPress Version', 'gulir-core' ),
				'value' => isset( $GLOBALS['wp_version'] ) ? $GLOBALS['wp_version'] : '',
			],
			'debug_mode'    => [
				'title'   => esc_html__( 'Debug Mode', 'gulir-core' ),
				'value'   => ( WP_DEBUG ) ? 'Enabled' : 'Disabled',
				'passed'  => ( WP_DEBUG ) ? false : true,
				'warning' => esc_html__( 'Enabling WordPress debug mode might display details about your site\'s PHP code to visitors.', 'gulir-core' ),
			],
			'debug_log'     => [
				'title' => esc_html__( 'Debug Log', 'gulir-core' ),
				'value' => ( WP_DEBUG_LOG ) ? 'Enabled' : 'Disabled',
			],
			'theme_name'    => [
				'title' => esc_html__( 'Theme Name', 'gulir-core' ),
				'value' => wp_get_theme()->Name,
			],
			'theme_version' => [
				'title' => esc_html__( 'Theme Version', 'gulir-core' ),
				'value' => wp_get_theme()->Version,
			],
			'theme_author'  => [
				'title' => esc_html__( 'Theme Author', 'gulir-core' ),
				'value' => '<a target="_blank" href="//luncur">Luncur</a>',
			],
		];
	}

}

/** LOAD */
RB_ADMIN_CORE::get_instance();