<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Admin_Information' ) ) {
	class Gulir_Admin_Information {

		private static $instance;
		private $taxonomy;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		function get_current_taxonomy() {

			if ( wp_doing_ajax() ) {
				if ( isset( $_POST['taxonomy'] ) && is_string( $_POST['taxonomy'] ) ) {
					return sanitize_text_field( wp_unslash( $_POST['taxonomy'] ) );
				}
			} elseif ( isset( $_GET['taxonomy'] ) && is_string( $_GET['taxonomy'] ) ) {
				return sanitize_text_field( wp_unslash( $_GET['taxonomy'] ) );
			}

			return null;
		}

		public function __construct() {

			self::$instance = $this;

			$this->taxonomy = $this->get_current_taxonomy();
			add_action( 'admin_notices', [ $this, 'hosted_data_notices' ], 20 );
			add_action( 'admin_notices', [ $this, 'easy_post_submission_notice' ], 20 );

			add_action( 'in_plugin_update_message-' . RUBY_THEME_NAME . '-core/' . RUBY_THEME_NAME . '-core.php', [
				$this,
				'version_update_warning',
			] );
			if ( ! empty( $this->taxonomy ) ) {
				add_filter( 'manage_edit-' . $this->taxonomy . '_columns', [ $this, 'add_columns' ] );
				add_filter( 'manage_edit-' . $this->taxonomy . '_sortable_columns', [ $this, 'sortable_columns' ] );
				add_filter( 'manage_' . $this->taxonomy . '_custom_column', [ $this, 'column_content' ], 10, 3 );
			}
		}


		function add_columns( $columns ) {

			$new_columns = [];
			foreach ( $columns as $key => $value ) {
				$new_columns[ $key ] = $value;
				if ( $key === 'slug' ) {
					$new_columns['term_id'] = 'Term ID';
				}
			}

			return $new_columns;
		}

		public function sortable_columns( $sortable_columns ) {

			$sortable_columns['term_id'] = 'term_id';

			return $sortable_columns;
		}

		function column_content( $content, $column_name, $term_id ) {

			if ( $column_name === 'term_id' ) {
				return $term_id;
			}

			return $content;
		}

		public function hosted_data_notices() {

			$current_screen = get_current_screen();
			if ( ! $current_screen || $current_screen->id !== 'gulir_page_ruby-options' ) {
				return;
			}

			$buffer        = '';
			$site_host     = parse_url( home_url(), PHP_URL_HOST );
			$settings      = get_option( GULIR_TOS_ID );

			foreach ( $settings as $key => $item ) {

				$value = false;

				if ( ! empty( $item['url'] ) ) {
					$value = $item['url'];
				} elseif ( in_array( $key, [ 'login_register', 'login_page', 'login_redirect', 'logout_redirect' ] ) ) {
					$value = (string) $item;
				}

				if ( empty( $value ) ) {
					continue;
				}

				$check_host = parse_url( $value, PHP_URL_HOST );
				if ( $site_host !== $check_host ) {
					$buffer .= '<li><strong>' . $this->info( $key ) . ': </strong><span class="url-info">' . $value . '</span></li>';
				}
			}

			if ( empty( $buffer ) ) {
				return;
			}

			echo '<div class="notice notice-warning rb-setting-warning is-dismissible">';
			echo '<h3 class="rb-setting-warning-title"><i class="rbi-dash rbi-dash-info"></i>' . esc_html__( 'IMPORTANT: Please Host Images on Your Own Server!', 'gulir-core' ) . '</h3>';
			echo '<p class="rb-setting-warning-desc">' . esc_html__( 'Some images, including SVG icons and internal links, are not hosted on your website. These resources can negatively affect your website\'s SEO ranking and loading speed. To enhance performance, we strongly recommend replacing them with self-hosted images and links.', 'gulir-core' ) . '</p>';
			echo '<ul>' . $buffer . '</ul>';

			echo '</div>';
		}

		/**
		 * Retrieves specific theme-related information based on the provided key.
		 *
		 * This function returns an associative array containing various theme settings
		 * and their corresponding descriptions. The returned value is used to provide
		 * helpful information about theme options.
		 *
		 * @param string $key The key used to retrieve the corresponding settings information.
		 *
		 * @return string The translated description of the theme setting.
		 */
		function info( $key ) {

			$data = [
				'logo'                       => esc_html__( 'Logo > Default Logos > Main Logo', 'gulir-core' ),
				'dark_logo'                  => esc_html__( 'Logo > Default Logos > Dark Mode - Main Logo', 'gulir-core' ),
				'mobile_logo'                => esc_html__( 'Logo > Mobile Logos > Mobile Logo', 'gulir-core' ),
				'dark_mobile_logo'           => esc_html__( 'Logo > Mobile Logos > Dark Mode - Mobile Logo', 'gulir-core' ),
				'transparent_logo'           => esc_html__( 'Logo > Transparent Logos > Transparent Logo', 'gulir-core' ),
				'logo_organization'          => esc_html__( 'Logo > Organization Logo > Organization Logo', 'gulir-core' ),
				'icon_touch_apple'           => esc_html__( 'Logo > Bookmarklet > iOS Bookmarklet Icon', 'gulir-core' ),
				'icon_touch_metro'           => esc_html__( 'Logo > Bookmarklet > Metro UI Bookmarklet Icon', 'gulir-core' ),
				'ad_top_image'               => esc_html__( 'Ads & Slide Up > Top Site > Ad Image', 'gulir-core' ),
				'ad_top_dark_image'          => esc_html__( 'Ads & Slide Up > Top Site > Dark Mode - Ad Image', 'gulir-core' ),
				'ad_single_image'            => esc_html__( 'Ads & Slide Up > Inline Single Content > Ad Image', 'gulir-core' ),
				'ad_single_dark_image'       => esc_html__( 'Ads & Slide Up > Inline Single Content > Dark Mode - Ad Image', 'gulir-core' ),
				'amp_footer_logo'            => esc_html__( 'AMP > General > AMP Footer Logo', 'gulir-core' ),
				'page_404_featured'          => esc_html__( '404 Page > Header Image', 'gulir-core' ),
				'page_404_dark_featured'     => esc_html__( '404 Page > Dark Mode - Header Image', 'gulir-core' ),
				'saved_image'                => esc_html__( 'Personalize > Reading List Header > Description Image', 'gulir-core' ),
				'saved_image_dark'           => esc_html__( 'Personalize > Reading List Header > Dark Mode - Description Image', 'gulir-core' ),
				'interest_image'             => esc_html__( 'Personalize > User Interests > Categories > Description Image', 'gulir-core' ),
				'interest_image_dark'        => esc_html__( 'Personalize > User Interests > Categories > Dark Mode - Description Image', 'gulir-core' ),
				'interest_author_image'      => esc_html__( 'Personalize > User Interests > Authors > Description Image', 'gulir-core' ),
				'interest_author_image_dark' => esc_html__( 'Personalize > User Interests > Authors > Dark Mode - Description Image', 'gulir-core' ),
				'footer_logo'                => esc_html__( 'Footer > Footer Logo', 'gulir-core' ),
				'dark_footer_logo'           => esc_html__( 'Footer > Dark Mode - Footer Logo', 'gulir-core' ),
				'header_search_custom_icon'  => esc_html__( 'Theme Design > Search > Custom Search SVG', 'gulir-core' ),
				'notification_custom_icon'   => esc_html__( 'Header > Notification > Custom Notification SVG', 'gulir-core' ),
				'login_custom_icon'          => esc_html__( 'Header > Sign In Buttons > Custom Login SVG', 'gulir-core' ),
				'cart_custom_icon'           => esc_html__( 'Header > Mini Cart > Custom Cart SVG Icon', 'gulir-core' ),
				'header_login_logo'          => esc_html__( 'Login > Popup Sign In > Form Logo', 'gulir-core' ),
				'header_login_dark_logo'     => esc_html__( 'Login > Popup Sign In > Dark Mode - Form Logo', 'gulir-core' ),
				'login_screen_logo'          => esc_html__( 'Login > Login Screen Layout > Login Logo', 'gulir-core' ),
				'newsletter_cover'           => esc_html__( 'Popup Newsletter > Cover Image', 'gulir-core' ),
				'facebook_default_img'       => esc_html__( 'SEO Optimized > Fallback Share Image', 'gulir-core' ),
				'single_post_review_image'   => esc_html__( 'Single Post > Review & Rating > Default Review Image', 'gulir-core' ),
				'podcast_custom_icon'        => esc_html__( 'Podcast > General > Custom Podcast SVG', 'gulir-core' ),
				'dark_mode_light_icon'       => esc_html__( 'Dark Mode > Custom Light (Sun) Icon', 'gulir-core' ),
				'dark_mode_dark_icon'        => esc_html__( 'Dark Mode > Custom Dark (Moon) Icon', 'gulir-core' ),
				'login_register'             => esc_html__( 'Login > Custom Registration Page URL', 'gulir-core' ),
				'login_page'                 => esc_html__( 'Login > Custom Login Page URL', 'gulir-core' ),
				'login_redirect'             => esc_html__( 'Login > Logged-In Redirect URL', 'gulir-core' ),
				'logout_redirect'            => esc_html__( 'Login > Logout Redirect URL', 'gulir-core' ),
			];

			if ( ! empty( $data[ $key ] ) ) {
				return $data[ $key ];
			}

			return esc_html__( 'External link', 'gulir-core' );
		}

		/**
		 * Displays a warning message indicating that the Gulir Core plugin needs an update.
		 *
		 * This function generates an HTML warning message advising the user to update the theme
		 * before updating the Gulir Core plugin. It also suggests backing up the site and
		 * testing updates in a staging environment.
		 *
		 * @return string The HTML output for the update warning message.
		 */
		public function version_update_warning() {

			$output = '<hr class="rb-update-separator">';
			$output .= '<div class="rb-update-warning">';
			$output .= '<div class="rb-update-warning-title"><i class="dashicons-before dashicons-info"></i>' . esc_html__( 'The Gulir Core needs to be updated!', 'gulir-core' ) . '</div>';
			$output .= '<div>' . sprintf( 'Please update the theme before updating Gulir Core. We strongly advise  %1$sbacking up your site%2$s to ensure the safety of your data, and make sure you first update in a staging environment.', '<a href="https://help.luncur.com/gulir/backup-restore-website-data/">', '</a>' ) . '</div>';
			$output .= '</div>';

			echo $output;
		}

		/**
		 * Displays a warning notice in the WordPress admin panel if the "Easy Post Submission" plugin is outdated.
		 *
		 * This function checks if the current admin screen is related to the Gulir plugin settings.
		 * If the screen matches specific pages and the "Easy Post Submission" plugin is outdated,
		 * a dismissible warning notice is displayed, prompting the user to update the plugin.
		 *
		 * @return void
		 */
		function easy_post_submission_notice() {

			$current_screen = get_current_screen();

			if ( empty( $current_screen->id ) || ! defined( 'RUBY_SUBMISSION_VERSION' ) ) {
				return;
			}

			if ( $current_screen->id === 'toplevel_page_gulir-admin' || 'gulir_page_ruby-submission' === $current_screen->id || 'gulir_page_easy-post-submission' === $current_screen->id ) {

				echo '<div class="notice notice-warning rb-setting-warning is-dismissible">';
				echo '<h3 class="rb-setting-warning-title"><i class="rbi-dash rbi-dash-info"></i> ';
				echo esc_html__( 'Update Request:', 'gulir-core' ) . ' ';
				echo esc_html__( 'Please update the "Easy Post Submission" plugin to the latest version.', 'gulir-core' );
				echo '</h3>';

				echo '<p>' . esc_html__( 'An outdated version of Easy Post Submission is currently installed on your website, and it is no longer available. The new version of this plugin has been published on WordPress.org. Please switch to using the WordPress.org repository version:', 'gulir-core' ) . ' ';
				echo '<a href="' . esc_url( 'https://wordpress.org/plugins/easy-post-submission/' ) . '" target="_blank">';
				echo esc_html__( 'Get the latest version here.', 'gulir-core' );
				echo '</a></p>';
				echo '<p>' . esc_html__( 'To ensure full compatibility, please remove the old plugin. All your settings and forms will remain intact only the shortcodes need to be updated.', 'gulir-core' ) . '</p>';
				echo '<p><strong>' . esc_html__( 'Steps to update:', 'gulir-core' ) . '</strong></p>';

				echo '<ul>';
				echo '<li>' . esc_html__( 'Disable and DELETE the current Easy Post Submission plugin (version 0.1) from the', 'gulir-core' ) . ' ';
				echo '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">';
				echo esc_html__( 'plugins page', 'gulir-core' );
				echo '</a>.';
				echo '</li>';
				echo '<li>' . esc_html__( 'Go to Gulir Dashboard > Recommended Plugins, then install and activate the latest version of Easy Post Submission.', 'gulir-core' ) . '</li>';
				echo '<li>' . esc_html__( 'Update all shortcodes from', 'gulir-core' ) . ' ';
				echo '<code>[ruby_submission_*]</code> ';
				echo esc_html__( 'to', 'gulir-core' ) . ' ';
				echo '<code>[easy_post_submission_*]</code>.';
				echo '</li>';
				echo '</ul>';

				echo '</div>';
			}
		}
	}
}
