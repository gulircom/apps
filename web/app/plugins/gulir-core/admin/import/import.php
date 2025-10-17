<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'rbSubPageImport', false ) ) {
	class rbSubPageImport extends RB_ADMIN_SUB_PAGE {

		private static $instance;
		public $data = [];
		public $demos_path;
		public $demos_url;

		/** get_instance */
		static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			parent::__construct();

			$this->demos_path = apply_filters( 'rb_importer_demos_path', trailingslashit( plugin_dir_path( __FILE__ ) . 'demos' ) );
			$this->demos_url  = apply_filters( 'rb_importer_demos_url', trailingslashit( plugin_dir_url( __FILE__ ) . 'demos' ) );
			$this->data       = RB_ADMIN_CORE::get_instance()->get_imports();
			add_filter( 'rb_admin_localize_data', [ $this, 'localize_data' ] );
			add_action( 'admin_footer', [ $this, 'template_form_import' ], 50 );
		}

		/** set sub page */
		public function set_sub_page() {

			$this->page_title = esc_html__( 'Demo Importer', 'gulir-core' );
			$this->menu_title = esc_html__( 'Demo Importer', 'gulir-core' );
			$this->menu_slug  = 'rb-demo-importer';
			$this->capability = 'manage_options';
			$this->position   = 5;
		}

		public function localize_data( $params = [] ) {

			if ( ! empty( $this->data ) ) {
				foreach ( $this->data as $key => $item ) {
					$params['importData'][ $key ] = [
						'directory' => $key,
						'demoName'  => $item['name'] ? $item['name'] : '',
						'plugins'   => $item['plugins'] ? $item['plugins'] : [],
						'preview'   => $item['preview'] ? $item['preview'] : '',
					];
				}
			}

			return $params;
		}

		public function get_slug() {

			return 'admin/import/template';
		}

		public function get_name() {

			return false;
		}

		public function get_params() {

			// Refresh token to ensure it is valid for import
			do_action('ruby_refresh_token');

			$params          = [];
			$imported        = get_option( 'rb_imported_demos' );
			$params['demos'] = $this->data;
			if ( is_array( $params['demos'] ) && count( $params['demos'] ) ) {
				foreach ( $params['demos'] as $directory => $values ) {
					if ( empty( $params['demos'][ $directory ]['preview'] ) ) {
						$params['demos'][ $directory ]['preview'] = $this->demos_url . $directory . '.jpg';
					}
					if ( is_array( $imported ) && ! empty( $imported[ $directory ] ) ) {
						$params['demos'][ $directory ]['imported'] = $imported[ $directory ];
					} else {
						$params['demos'][ $directory ]['imported'] = 'none';
					}
				}
			}
			$params = apply_filters( 'rb_importer_params', $params );

			return $params;
		}

		function template_form_import() { ?>
			<script type="text/html" id="tmpl-rb-import">
				<div class="rb-import-form">
					<div class="rb-import-header" style="background-image: url('{{ data.preview }}');">
						<h3>{{ data.demoName }}</h3>
						<div class="rb-close-import"><i class="rbi-dash rbi-dash-close"></i></div>
					</div>
					<div class="rb-import-content">
						<div class="rb-import-step rb-step-select activated-step">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3>
										<i class="rbi-dash rbi-dash-laptop"></i><?php echo esc_html__( 'Import Content', 'gulir-core' ); ?>
									</h3>
									<p><?php esc_html_e( 'You can import all content, including all, or select specific items like pages, theme options, and widgets to avoid unnecessary dummy content.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-section-body">
									<label class="rb-import-checkbox" for="import_all">
										<input type="checkbox" id="import_all" data-action="import_all" class="rb-importer-checkbox" checked="checked">
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><?php echo esc_html__( 'All Content', 'gulir-core' ); ?></span>
									</label>
									<label class="rb-import-checkbox left-indent" for="import_content">
										<input type="checkbox" id="import_content" data-action="import_content" class="rb-importer-checkbox rb_import_content" checked="checked">
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><?php echo esc_html__( 'Content', 'gulir-core' ); ?></span>
									</label>
									<label class="rb-import-checkbox left-indent" for="import_pages">
										<input type="checkbox" id="import_pages" data-action="import_pages" class="rb-importer-checkbox rb_import_pages" checked="checked">
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><?php echo esc_html__( 'Pages Only', 'gulir-core' ); ?></span>
									</label>
									<label class="rb-import-checkbox left-indent" for="import_opts">
										<input type="checkbox" id="import_opts" data-action="import_opts" class="rb-importer-checkbox" checked="checked">
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><?php echo esc_html__( 'Theme Options', 'gulir-core' ); ?></span>
									</label>
									<label class="rb-import-checkbox left-indent" for="import_widgets">
										<input type="checkbox" id="import_widgets" data-action="import_widgets" class="rb-importer-checkbox" checked="checked">
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><?php echo esc_html__( 'Widgets', 'gulir-core' ); ?></span>
									</label>
									<label class="rb-import-checkbox is-clear-up" for="clean_up">
										<input type="checkbox" id="clean_up" data-action="clean_up" class="rb-importer-clear-up">
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><?php echo esc_html__( 'Pure Installation', 'gulir-core' ); ?></span>
									</label>
									<div class="clear-up-label"><?php esc_html_e( 'Selecting this option will remove all previously imported content and initiate a fresh.', 'gulir-core' ); ?></div>
								</div>
							</div>
							<input type="hidden" data-directory="{{ data.directory }}">
							<button type="button" id="rb-import-next" class="rb-import-btn"><?php esc_html_e( 'Next', 'gulir-core' ); ?>
								<i class="rbi-dash rbi-dash-arrow-right"></i></button>
						</div>
						<div class="rb-import-step rb-step-plugin">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3>
										<i class="rbi-dash rbi-dash-plugin"></i><?php echo esc_html__( 'Required Plugins', 'gulir-core' ); ?>
									</h3>
									<p><?php esc_html_e( 'Select the plugins you want to install and activate before importing. Activating the required and recommended plugins is essential to fully utilize the demo features.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-section-body">
									<# _.each( data.plugins, function( plugin, index ) { #>
									<label class="rb-install-plugin rb-import-checkbox" for="plugin-{{ index }}">
										<input type="checkbox" id="plugin-{{ index }}" value="{{ plugin.slug }}" data-action="install_plugin" <# if ( plugin.info.toLowerCase() === 'required' || plugin.info.toLowerCase() === 'recommended' ) { #>checked<# } #>>
										<span class="rb-checkbox-style"><i></i></span>
										<span class="rb-import-label"><span class="rb-plugin-name">{{ plugin.name }}</span><span class="rb-plugin-info is-{{ plugin.info.toLowerCase() }}">{{ plugin.info }}</span></span>
									</label>
									<# } ); #>
								</div>
							</div>
							<button type="button" id="rb-import-action" class="rb-import-btn"><?php esc_html_e( 'Import Demo', 'gulir-core' ); ?>
								<i class="rbi-dash rbi-dash-arrow-right"></i></button>
						</div>
						<div class="rb-import-step rb-step-importing">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3>
										<span class="rb-loading"><i class="rbi-dash rbi-dash-load"></i></span>
										<?php echo esc_html__( 'Building the website...', 'gulir-core' ); ?>
									</h3>
									<p><?php esc_html_e( 'The import process may take approximately 1 to 5 minutes, depending on server performance.', 'gulir-core' ); ?></p>
									<p><?php esc_html_e( 'If the process exceeds 5 minutes, please reload the page and try again.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-section-body">
									<div class="rb-import-progress">
										<div class="rb-import-progress-title">
											<div class="rb-import-progress-label"><?php esc_html_e( 'Installing...', 'gulir-core' ); ?></div>
											<div class="rb-import-progress-percent">0%</div>
										</div>
										<div class="rb-import-progress-bar">
											<div class="rb-import-progress-indicator"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="rb-import-step rb-step-complete">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3><i class="rbi-dash rbi-dash-check"></i>
										<?php echo esc_html__( 'Import Completed', 'gulir-core' ); ?>
									</h3>
									<p class="b-description"><?php esc_html_e( 'Your website is now ready! Feel free to customize the text, images, and design to truly make it your own.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-section-body">
									<div class="rb-import-buttons">
										<a class="rb-panel-button is-view-site" href="<?php echo get_home_url( '/' ); ?>" target="_blank" rel="nofollow"><?php esc_html_e( 'View Site', 'gulir-core' ); ?></a>
										<a class="rb-panel-button" href="<?php echo admin_url( 'admin.php?page=ruby-options' ); ?>" rel="nofollow"><?php esc_html_e( 'Customize', 'gulir-core' ); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="rb-import-step rb-step-error">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3><i class="rbi-dash rbi-dash-info"></i>
										<?php echo esc_html__( 'Error!', 'gulir-core' ); ?>
									</h3>
									<p class="b-description"><?php esc_html_e( 'An error occurred during the import. Please click the "Try Fixing Import" button and try again, or contact support for assistance.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-buttons">
									<button class="rb-panel-button refresh-exp-btn no-confirm"><?php esc_html_e( 'Try Fixing Import', 'gulir-core' ); ?></button>
									<a class="rb-panel-button is-outlined" href="<?php echo admin_url( 'admin.php?page=rb-demo-importer' ); ?>" rel="nofollow"><?php esc_html_e( 'Reload', 'gulir-core' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</script>
			<script type="text/html" id="tmpl-rb-cleanup">
				<div class="rb-import-form rb-cleanup-form">
					<div class="rb-close-import"><i class="rbi-dash rbi-dash-close"></i></div>
					<div class="rb-import-content">
						<div class="rb-import-step rb-step-cleanup activated-step">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3>
										<i class="rbi-dash rbi-dash-broom"></i><?php echo esc_html__( 'Clear Importer Content', 'gulir-core' ); ?>
									</h3>
									<p><?php esc_html_e( 'This action helps to clean up imported data. You can choose to remove all imported content or specifically target posts and attachments.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-section-body">
									<div class="rb-cleanup-buttons">
										<button type="button" data-cleanup="post" class="rb-cleanup-import-data is-big-button rb-panel-button"><?php esc_html_e( 'Posts & Attachments', 'gulir-core' ); ?></button>
										<button type="button" data-cleanup="all" class="rb-cleanup-import-data is-big-button rb-panel-button is-outlined"><?php esc_html_e( 'All Content', 'gulir-core' ); ?></button>
									</div>
									<div class="rb-cleanup-info is-hidden">
										<span class="rb-loading"><i class="rbi-dash rbi-dash-load"></i></span>
										<?php esc_html_e( 'Cleaning up imported content...', 'gulir-core' ); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="rb-import-step rb-step-complete">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3><i class="rbi-dash rbi-dash-check"></i>
										<?php echo esc_html__( 'Import Data Cleanup Finished', 'gulir-core' ); ?>
									</h3>
									<p class="b-description"><?php esc_html_e( 'The imported data has been successfully deleted from your website.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-section-body">
									<div class="rb-import-buttons">
										<a class="rb-panel-button is-view-site" href="<?php echo get_home_url( '/' ); ?>" target="_blank" rel="nofollow"><?php esc_html_e( 'View Site', 'gulir-core' ); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="rb-import-step rb-step-error">
							<div class="rb-import-section">
								<div class="rb-step-title">
									<h3><i class="rbi-dash rbi-dash-info"></i>
										<?php echo esc_html__( 'Error!', 'gulir-core' ); ?>
									</h3>
									<p class="b-description"><?php esc_html_e( 'An error occurred while cleaning up the content.', 'gulir-core' ); ?></p>
								</div>
								<div class="rb-import-buttons">
									<a class="rb-panel-button" href="<?php echo admin_url( 'admin.php?page=rb-demo-importer' ); ?>" rel="nofollow"><?php esc_html_e( 'Reload', 'gulir-core' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</script>
		<?php }
	}
}