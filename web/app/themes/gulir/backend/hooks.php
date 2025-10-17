<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Admin_Hooks' ) ) {
	class Gulir_Admin_Hooks {

		protected static $instance = null;

		static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_action( 'after_switch_theme', [ $this, 'set_defaults' ], 9 );
			add_action( 'switch_theme', [ $this, 'set_defaults' ], 9 );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
			add_action( 'enqueue_block_assets', [ $this, 'enqueue_editor' ], 90 );

			/** add settings to theme options panel */
			add_filter( 'ruby_post_types_config', [ $this, 'ctp_supported' ], 0 );
			add_filter( 'ruby_taxonomies_config', [ $this, 'ctax_supported' ], 0 );

			add_action( 'save_post', [ $this, 'update_metaboxes' ], 10, 1 );
			add_action( 'save_post', [ $this, 'content_word_count' ], 100, 1 );
		}

		public function set_defaults() {

			/** disable default elementor schemes */
			update_option( 'elementor_disable_color_schemes', 'yes' );
			update_option( 'elementor_disable_typography_schemes', 'yes' );

			$current = get_option( GULIR_TOS_ID, [] );
			if ( is_array( $current ) && count( $current ) ) {
				return;
			}

			include gulir_get_file_path( 'backend/panels/default-options.php' );
			set_transient( '_ruby_old_settings', $current, 30 * 86400 );
			update_option( GULIR_TOS_ID, gulir_theme_options_default_values() );
		}

		function enqueue( $hook ) {

			wp_enqueue_style( 'gulir-admin-style', gulir_get_file_uri( 'backend/assets/admin.css' ), [], GULIR_THEME_VERSION );

			$allowed_hooks = [ 'gulir_page_ruby-options', 'post.php', 'post-new.php', 'widgets.php', 'nav-menus.php', 'term.php', 'profile.php', 'user-edit.php' ];

			if ( in_array( $hook, [ 'profile.php', 'user-edit.php' ], true ) ) {
				wp_enqueue_media();
			}

			if ( in_array( $hook, $allowed_hooks, true ) ) {
				wp_enqueue_script( 'gulir-admin', gulir_get_file_uri( 'backend/assets/admin.js' ), [ 'jquery' ], GULIR_THEME_VERSION, true );
			}
		}


		/**
		 * Enqueues the necessary scripts and styles for the WordPress editor.
		 *
		 * @return void
		 */
		function enqueue_editor() {

			if ( ! is_admin() ) {
				return;
			}

			$deps = [];

			$uri       = ! is_rtl() ? 'backend/assets/editor.css' : 'backend/assets/editor-rtl.css';
			$gfont_url = Gulir_Font::get_font_url();
			if ( ! empty( $gfont_url ) ) {
				wp_register_style( 'gulir-gfonts-editor', esc_url_raw( $gfont_url ), $deps, GULIR_THEME_VERSION, 'all' );
				$deps[] = 'gulir-gfonts-editor';
			}
			wp_register_style( 'gulir-editor-style', gulir_get_file_uri( $uri ), $deps, GULIR_THEME_VERSION, 'all' );
			wp_enqueue_style( 'gulir-editor-style' );
		}

		/**
		 * supported custom post types.
		 *
		 * @return mixed|void Returns filtered custom post type data or void if no data is found.
		 */
		function ctp_supported() {

			$post_types = apply_filters( 'cptui_get_post_type_data', get_option( 'cptui_post_types', [] ), get_current_blog_id() );

			if ( function_exists( 'acf_maybe_unserialize' ) ) {
				$acf_query = new WP_Query( [
					'posts_per_page'         => - 1,
					'post_type'              => 'acf-post-type',
					'orderby'                => 'menu_order title',
					'order'                  => 'ASC',
					'suppress_filters'       => false,
					'cache_results'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'post_status'            => [ 'publish', 'acf-disabled' ],
				] );

				if ( $acf_query->have_posts() ) {
					while ( $acf_query->have_posts() ) {
						$acf_query->the_post();
						global $post;
						$data = (array) acf_maybe_unserialize( $post->post_content );
						if ( empty( $data['post_type'] ) ) {
							continue;
						}
						$key                = $data['post_type'];
						$label              = ! empty( $data['labels']['singular_name'] ) ? $data['labels']['singular_name'] : $data['post_type'];
						$post_types[ $key ] = [ 'label' => $label ];
					}

					wp_reset_postdata();
				}
			}

			return $post_types;
		}

		/**
		 * Supported custom taxonomies.
		 *
		 * @return mixed|void Returns filtered custom taxonomy data or void if no data is found.
		 */
		function ctax_supported() {

			$taxonomies = apply_filters( 'cptui_get_taxonomy_data', get_option( 'cptui_taxonomies', [] ), get_current_blog_id() );

			if ( function_exists( 'acf_maybe_unserialize' ) ) {
				$acf_query = new WP_Query( [
					'posts_per_page'         => - 1,
					'post_type'              => 'acf-taxonomy',
					'orderby'                => 'menu_order title',
					'order'                  => 'ASC',
					'suppress_filters'       => false,
					'cache_results'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'post_status'            => [ 'publish', 'acf-disabled' ],
				] );

				if ( $acf_query->have_posts() ) {
					while ( $acf_query->have_posts() ) {
						$acf_query->the_post();
						global $post;
						$data = (array) acf_maybe_unserialize( $post->post_content );

						if ( empty( $data['taxonomy'] ) ) {
							continue;
						}
						$key                = $data['taxonomy'];
						$label              = ! empty( $data['labels']['singular_name'] ) ? $data['labels']['singular_name'] : $data['taxonomy'];
						$taxonomies[ $key ] = [ 'label' => $label ];
					}

					wp_reset_postdata();
				}
			}

			return $taxonomies;
		}


		/**
		 * update posts
		 *
		 * @param $post_id
		 *
		 */
		function update_metaboxes( $post_id ) {

			if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
				return;
			}

			if ( gulir_is_sponsored_post( $post_id ) ) {
				update_post_meta( $post_id, 'gulir_sponsored', 1 );
			} else {
				delete_post_meta( $post_id, 'gulir_sponsored' );
			}

			$review = gulir_get_review_settings( $post_id );

			if ( ! empty( $review['average'] ) ) {
				if ( empty( $review['type'] ) || 'score' === $review['type'] ) {
					update_post_meta( $post_id, 'gulir_review_average', floatval( $review['average'] ) );
				} else {
					update_post_meta( $post_id, 'gulir_review_average', floatval( $review['average'] ) * 2 );
				}
			} else {
				delete_post_meta( $post_id, 'gulir_review_average' );
			}

			delete_post_meta( $post_id, 'rb_content_images' );
		}

		/**
		 * @param string $post_id
		 */
		function content_word_count( $post_id = '' ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
				return;
			}

			delete_post_meta( $post_id, 'gulir_content_total_word' );
			gulir_update_word_count( $post_id );
		}
	}
}

/** load */
Gulir_Admin_Hooks::get_instance();