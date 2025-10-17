<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Updater' ) ) {
	class Gulir_Updater {

		protected static $instance = null;

		static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;
			add_action( 'upgrader_process_complete', [ $this, 'async_upgrade' ], 10, 2 );
		}

		function async_upgrade( $upgrader, $options ) {

			if ( isset( $options['type'], $options['plugins'] ) && $options['type'] === 'plugin' && in_array( 'gulir-core/gulir-core.php', $options['plugins'], true ) ) {

				$this->clear_update_flags();
				$this->elementor_cache_clearing();
				$this->update_db_settings();
			}
		}

		public function clear_update_flags() {

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			delete_option( '_rb_flag_update_logo' );
			delete_option( '_rb_flag_update_tax_meta' );
			delete_option( '_rb_flag_update' );
		}

		public function elementor_cache_clearing() {
			if ( class_exists( '\Elementor\Plugin' ) ) {
				\Elementor\Plugin::$instance->files_manager->clear_cache();
			}
		}

		public function update_db_settings() {

			$flag = get_option( 'rb_flag_updater', false );

			if ( $flag || ! current_user_can( 'manage_options' ) || is_network_admin() ) {
				return;
			}

			$settings = get_option( GULIR_TOS_ID, [] );

			$font_excerpt_size = ! empty( $settings['font_excerpt_size'] ) ? (int) $settings['font_excerpt_size'] : false;

			if ( ! empty( $font_excerpt_size ) ) {

				set_transient( GULIR_TOS_ID, $settings, 2592000 );
				set_transient( 'RB_UPGRADER_BACKUP_TOPS', $settings, 2592000 );

				$settings['font_excerpt']['font-size'] = $font_excerpt_size . 'px';

				update_option( GULIR_TOS_ID, $settings );
			}

			/** set flag */
			update_option( 'rb_flag_updater', 'ver-260' );
		}
	}
}

/** init */
Gulir_Updater::get_instance();
