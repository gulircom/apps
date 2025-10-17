<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

// LOAD
add_action( 'init', [ 'Gulir_GTM_Tags', 'get_instance' ], 10 );

/**
 * Class Gulir_GTM_Tags
 *
 * Handles the integration of Google Tag Manager (GTM) and Google Global Site Tag (gtag.js).
 * This singleton class ensures that tracking scripts are added to the site only when
 * a valid GTM or gtag ID is present.
 */
if ( ! class_exists( 'Gulir_GTM_Tags', false ) ) {
	class Gulir_GTM_Tags {

		/**
		 * Singleton instance of the class.
		 *
		 * @var Gulir_GTM_Tags|null
		 */
		protected static $instance = null;
		protected static $tag_added = false;

		/**
		 * Retrieves the singleton instance of the class.
		 *
		 * @return Gulir_GTM_Tags The instance of this class.
		 */
		static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Gulir_GTM_Tags constructor.
		 *
		 * Initializes the class by retrieving GTM/gtag IDs and adding relevant script hooks.
		 * If no valid GTM or gtag ID is found, the class does not add any tracking scripts.
		 */
		public function __construct() {

			self::$instance = $this;

			//Add GTM or GTAG script
			add_action( 'wp_head', [ $this, 'add_script_tag' ] );

			add_action( 'wp_body_open', [ $this, 'add_noscript_tag' ], 1 );
			add_action( 'wp_footer', [ $this, 'add_noscript_tag' ], 1 );

			// AMP Supported
			add_action( 'wp_body_open', [ $this, 'add_amp_tag' ], 15 );

		}

		/**
		 * Adds the GTM or gtag.js script tag in the head.
		 */
		public function add_script_tag() {

			$gtm_id  = get_option( 'simple_gtm_id' );
			$gtag_id = get_option( 'simple_gtag_id' );

			if ( gulir_is_amp() || ( empty( $gtm_id ) && empty( $gtag_id ) ) ) {
				return;
			}

			if ( ! empty( $gtm_id ) ) : ?>
				<!-- Google Tag Manager -->
				<script>(function (w, d, s, l, i) {
						w[l] = w[l] || [];
						w[l].push({
							'gtm.start':
									new Date().getTime(), event: 'gtm.js'
						});
						var f = d.getElementsByTagName(s)[0],
								j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
						j.async = true;
						j.src =
								'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
						f.parentNode.insertBefore(j, f);
					})(window, document, 'script', 'dataLayer', '<?php echo esc_attr( $gtm_id ); ?>');</script><!-- End Google Tag Manager -->
			<?php elseif ( ! empty( $gtag_id ) ) : ?>
				<!-- Google tag (gtag.js) -->
				<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $gtag_id ); ?>"></script>
				<script> window.dataLayer = window.dataLayer || [];

					function gtag() {
						dataLayer.push(arguments);
					}

					gtag('js', new Date());
					gtag('config', '<?php echo esc_attr( $gtag_id ); ?>');
				</script>
			<?php endif;
		}

		/**
		 * Adds AMP-specific GTM or gtag.js tracking.
		 */
		public function add_amp_tag() {

			if ( ! gulir_is_amp() ) {
				return;
			}

			$gtm_id  = get_option( 'simple_gtm_id' );
			$gtag_id = get_option( 'simple_gtag_id' );

			if ( ! empty( $gtm_id ) ) : ?>
				<!-- Google Tag Manager -->
				<amp-analytics config="https://www.googletagmanager.com/amp.json?id=<?php echo esc_attr( $gtm_id ); ?>" data-credentials="include"></amp-analytics>
			<?php elseif ( ! empty( $gtag_id ) ) : ?>
				<!-- Google tag (gtag.js) -->
				<amp-analytics type="gtag" data-credentials="include">
					<script type="application/json">
						{
							"vars" : {
								"gtag_id": "<?php echo esc_attr( $gtag_id ); ?>",
								"config" : {
									"<?php echo esc_attr( $gtag_id ); ?>": { "groups": "default" }
								}
							}
						}
					</script>
				</amp-analytics>
			<?php endif;
		}

		/**
		 * Adds the GTM noscript tag in the body.
		 */
		public function add_noscript_tag() {
			
			$gtm_id = get_option( 'simple_gtm_id' );

			if ( gulir_is_amp() || empty( $gtm_id ) || self::$tag_added ) {
				return;
			}
			?>
			<!-- Google Tag Manager (noscript) -->
			<noscript>
				<iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
			</noscript><!-- End Google Tag Manager (noscript) -->
			<?php
			// set flag
			self::$tag_added = true;
		}
	}
}