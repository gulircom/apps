<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Fonts_Enqueued', false ) ) {
	class Gulir_Fonts_Enqueued {

		private static $instance;

		public $settings;

		// Cache key for storing generated CSS
		private static $cache_key = 'gulir_lfontsup_css';

		/**
		 * Returns the singleton instance of the class.
		 *
		 * @return Gulir_Fonts_Enqueued
		 */
		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		/**
		 * Gulir_Fonts_Enqueued constructor.
		 * Initializes hooks for font handling.
		 */
		function __construct() {

			self::$instance = $this;

			add_action( 'wp_enqueue_scripts', [ $this, 'adobe_font_css' ], 2 );
			add_action( 'wp_head', [ $this, 'generate_local_font_faces' ], 20 );

		}

		/**
		 * Generates CSS rules from Adobe font settings.
		 *
		 * This function parses a font setting string, extracts the font family, weight, and style,
		 * and returns a CSS-compatible string for use in inline styles.
		 *
		 * @param string $setting The Adobe font setting string in the format "fontName::weight".
		 *
		 * @return string The generated CSS rules for the font family, weight, and style.
		 */
		public function generate_adobe_font_css( $setting ) {

			$params    = explode( '::', $setting );
			$font_data = get_option( 'rb_adobe_fonts', [] );
			$output    = '';

			if ( isset( $params[0] ) ) {
				if ( ! empty( $font_data['fonts'][ $params[0] ]['backup'] ) ) {
					$output .= 'font-family:' . $font_data['fonts'][ $params[0] ]['backup'] . ';';
				} else {
					$output .= 'font-family:' . $params[0] . ';';
				}
			}

			if ( ! empty( $params[1] ) ) {
				$output .= 'font-weight:' . intval( $params[1] ) . ';';
			}

			if ( substr( $params[1], - 1 ) === 'i' ) {
				$output .= 'font-style: italic;';
			}

			return $output;
		}

		/**
		 * Generates and enqueues inline CSS for Adobe Fonts based on saved settings.
		 *
		 * Retrieves Adobe font settings from the database, processes them into CSS rules,
		 * and enqueues them using `wp_add_inline_style()`.
		 *
		 * @return void
		 */
		public function adobe_font_css() {
			$settings = get_option( 'rb_adobe_font_settings', [] );
			if ( ! empty( $settings['project_id'] ) ) {
				$css_output = '';
				foreach ( $settings as $tag => $setting ) {
					if ( ! empty( $setting ) ) {
						$css_output .= $tag . '{' . $this->generate_adobe_font_css( $setting ) . '}';
					}
				}

				wp_add_inline_style( 'adobe-fonts', $css_output );
			}
		}

		/**
		 * Generates and enqueues @font-face CSS rules for locally uploaded fonts.
		 *
		 * This function retrieves font settings and font file variants from the database,
		 * then generates the necessary @font-face rules based on the uploaded font files.
		 *
		 * @return void
		 */
		public function generate_local_font_faces() {

			if ( ! defined( 'LOCAL_FONTS_UPLOADER_VERSION' ) ) {
				return;
			}

			$cached_css = get_option( self::$cache_key, '' );

			if ( ! empty( $cached_css ) ) {
				if ( 'unset' !== $cached_css ) {
					echo "<style id='local-fonts-uploader-inline'>\n{$cached_css}\n</style>\n";
				}

				return;
			}

			global $wpdb;
			$settings         = gulir_get_option();
			$font_families    = [];
			$output_font_face = '';

			// Retrieve font variants from the database
			$table_name = $wpdb->prefix . 'lfontsup_variants';

			// Check if the table exists
			if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) === null ) {
				return;
			}

			$uploader_variants = $wpdb->get_results(  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				"SELECT font_name, variant, file_url, assign_to FROM {$table_name}",
				ARRAY_A
			);

			if ( empty( $uploader_variants ) ) {
				return;
			}

			// Collect unique font-family names from settings
			foreach ( $settings as $id => $field ) {
				if ( isset( $field['font-family'] ) ) {
					$font_families[] = $field['font-family'];
				}
			}
			$font_families = array_unique( $font_families );

			// Generate @font-face rules for each font
			foreach ( $font_families as $font_name ) {
				foreach ( $uploader_variants as $variant ) {

					if ( $variant['font_name'] === $font_name && empty( $variant['assign_to'] ) ) {
						// Extract font-weight and font-style from variant value
						$font_weight = preg_replace( '/[^0-9]/', '', $variant['variant'] );
						$font_style  = ( strpos( $variant['variant'], 'italic' ) !== false ) ? 'italic' : 'normal';
						$file_ext    = pathinfo( $variant['file_url'], PATHINFO_EXTENSION );

						$output_font_face .= "@font-face {\n";
						$output_font_face .= "    font-family: '{$font_name}';\n";
						$output_font_face .= "    font-weight: {$font_weight};\n";
						$output_font_face .= "    font-style: {$font_style};\n";
						$output_font_face .= "    src: url('{$variant['file_url']}') format('{$this->get_font_format($file_ext)}');\n";
						$output_font_face .= "    font-display: swap;\n";
						$output_font_face .= "}\n";
					}
				}
			}

			if ( ! empty( $output_font_face ) ) {
				echo "<style id='local-fonts-uploader-inline'>\n{$output_font_face}\n</style>\n";
			} else {
				$output_font_face = 'unset';
			}

			update_option( self::$cache_key, $output_font_face );
		}

		/**
		 * Returns the correct font format for a given file extension.
		 *
		 * @param string $file_ext The file extension of the font file.
		 *
		 * @return string The corresponding CSS font format.
		 */
		public function get_font_format( $file_ext ) {

			$font_formats = [
				'woff2' => 'woff2',
				'woff'  => 'woff',
				'ttf'   => 'truetype',
				'otf'   => 'opentype',
				'eot'   => 'embedded-opentype',
			];

			return ! empty( $font_formats[ $file_ext ] ) ? $font_formats[ $file_ext ] : 'woff2';
		}
	}
}

/* LOAD */
Gulir_Fonts_Enqueued::get_instance();

