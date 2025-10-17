<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Admin_Font_Handler', false ) ) {
	class Gulir_Admin_Font_Handler {

		private static $instance;

		public $settings;
		public $supported_headings;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		function __construct() {

			self::$instance = $this;
			add_filter( 'ruby_fonts', [ $this, 'add_adobe_settings' ] );
			add_filter( 'redux/' . GULIR_TOS_ID . '/localize', [ $this, 'local_font_uploader_settings' ], 10, 1 );

			// Clean stylesheet caching when settings are updated
			add_action( 'update_option_' . GULIR_TOS_ID, [ $this, 'clean_stylesheet_caching' ], 20 );

		}

		/**
		 * Clears the local font uploader cache.
		 *
		 * This function is triggered when the option associated with GULIR_TOS_ID
		 * is updated. It ensures that outdated cached stylesheets and stored
		 * Google Fonts links are removed, preventing the use of stale data.
		 *
		 * @return void
		 */
		public function clean_stylesheet_caching() {

			// Delete cached local font CSS uploader data
			delete_option( 'gulir_lfontsup_css' );

			// Delete stored Google Fonts remote link
			delete_option( 'gulir_gfonts_link' );
		}

		public function get_variant_name( $variant ) {

			switch ( $variant ) {
				case '100':
					return esc_html__( 'Light 100', 'gulir-core' );
				case '300':
					return esc_html__( 'Book 300', 'gulir-core' );
				case '400':
					return esc_html__( 'Normal 400', 'gulir-core' );
				case '500':
					return esc_html__( 'Medium 500', 'gulir-core' );
				case '600':
					return esc_html__( 'Semi-Bold 600', 'gulir-core' );
				case '700':
					return esc_html__( 'Bold 700', 'gulir-core' );
				case '800':
					return esc_html__( 'Extra-Bold 800', 'gulir-core' );
				case '900':
					return esc_html__( 'Extra-Bold 900', 'gulir-core' );
				case '100italic':
					return esc_html__( 'Light 100 Italic', 'gulir-core' );
				case '300italic':
					return esc_html__( 'Book 300 Italic', 'gulir-core' );
				case '400italic':
					return esc_html__( 'Normal 400 Italic', 'gulir-core' );
				case '500italic':
					return esc_html__( 'Medium 500 Italic', 'gulir-core' );
				case '600italic':
					return esc_html__( 'Semi-Bold 600 Italic', 'gulir-core' );
				case '700italic':
					return esc_html__( 'Bold 700 Italic', 'gulir-core' );
				case '800italic':
					return esc_html__( 'Extra-Bold 800 Italic', 'gulir-core' );
				case '900italic':
					return esc_html__( 'Extra-Bold 900 Italic', 'gulir-core' );
				default:
					return $variant;
			}
		}

		public function add_adobe_settings( $fonts ) {

			$adobe_fonts = get_option( 'rb_adobe_fonts', [] );

			if ( ! empty( $adobe_fonts['fonts'] ) ) {
				foreach ( $adobe_fonts['fonts'] as $name => $data ) {

					$new = [
						'subsets' => [
							[
								'id'   => 'adobe',
								'name' => esc_html__( 'Based on Adobe', 'gulir-core' ),
							],
						],
					];

					if ( empty( $data['variations'] ) || ! is_array( $data['variations'] ) ) {
						$data['variations'] = [ '400', '700' ];
					}

					foreach ( $data['variations'] as $variant ) {
						if ( stripos( $variant, 'i' ) ) {
							$variant = trim( $variant ) . 'talic';
						}
						$new['variants'][] = [
							'id'   => $variant,
							'name' => $this->get_variant_name( $variant ),
						];
					}

					if ( empty( $fonts[ $name ] ) ) {
						$fonts[ $name ] = $new;
					}
				}
			}

			return $fonts;
		}

		/**
		 * added the font uploader settings to Theem Options
		 *
		 * @param array $params The existing parameters for the font uploader.
		 *
		 * @return array The modified parameters including local fonts.
		 */
		public function local_font_uploader_settings( $params ) {

			if ( ! defined( 'LOCAL_FONTS_UPLOADER_VERSION' ) || ! class_exists( 'Local_Fonts_Uploader_Data' ) ) {
				return $params;
			}

			$fonts    = Local_Fonts_Uploader_Data::get_fonts();
			$children = [];

			if ( ! empty( $fonts ) && is_array( $fonts ) ) {
				foreach ( $fonts as $font ) {
					if ( ! empty( $font['name'] ) ) {
						$formatted_variants = $this->get_local_font_variants( $font['name'] );
						if ( ! empty( $formatted_variants ) ) {
							$children[] = [
								'id'          => $font['name'],
								'text'        => $font['name'],
								'subsets'     => 'custom',
								'data-google' => 'false',
								'variants'    => $formatted_variants,
							];
						}
					}
				}
			}

			$params['customfonts'] = [
				'text'     => esc_html__( 'Local Fonts Uploader', 'gulir-core' ),
				'children' => $children,
			];

			return $params;
		}

		/**
		 * Retrieves the local font variants for a given font name.
		 *
		 * @param string $font_name The name of the font.
		 *
		 * @return array An associative array where keys are variant identifiers and values are their names.
		 */
		public function get_local_font_variants( $font_name ) {
			$data = [];

			// Fetch font variants
			$variants = Local_Fonts_Uploader_Data::get_variants( $font_name );

			// Ensure variants exist and are an array before processing
			if ( is_array( $variants ) && ! empty( $variants ) ) {
				foreach ( $variants as $variant ) {
					if ( ! empty( $variant['variant'] ) ) {
						$data[ $variant['variant'] ] = $this->get_variant_name( $variant['variant'] );
					}
				}
			}

			return $data;
		}
	}
}

/** load */
Gulir_Admin_Font_Handler::get_instance();
