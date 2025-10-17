<?php

use Elementor\Core\Files\CSS\Post;
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Rb_E_Template' ) ) {
	class Rb_E_Template {

		protected static $instance = null;

		static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function __construct() {

			self::$instance = $this;

			add_action( 'init', [ $this, 'register_post_type' ], 2 );
			add_action( 'elementor/init', [ $this, 'enable_support' ] );
			add_shortcode( 'Ruby_E_Template', [ $this, 'render' ] );
			add_action( 'add_meta_boxes', [ $this, 'shortcode_info' ] );
			add_filter( 'manage_rb-etemplate_posts_columns', [ $this, 'add_column' ] );
			add_action( 'manage_rb-etemplate_posts_custom_column', [ $this, 'column_shortcode_info' ], 10, 2 );
			add_filter( 'template_include', [ $this, 'template' ], 99 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ], 500 );
			add_filter( 'wp_sitemaps_posts_query_args', [ $this, 'no_sitemap' ], 20, 2 );
			add_action( 'gulir_elementor_single_style', [$this, 'load_single_style'], 10, 1 );
		}

		public function template( $template ) {

			global $post;
			if ( ! $post || ( 'rb-etemplate' !== get_post_type( $post ) ) ) {
				return $template;
			}

			$file_path = GULIR_CORE_PATH . 'elementor/ruby-templates/single.php';
			if ( file_exists( $file_path ) ) {
				return $file_path;
			}
		}


		/**
		 * @param $attrs
		 *
		 * @return false|string
		 */
		function render( $attrs ) {

			$settings = shortcode_atts( [
					'id'   => '',
					'slug' => '',
			], $attrs );

			if ( ( empty( $settings['id'] ) && empty( $settings['slug'] ) ) || ! gulir_is_elementor_active() || ! did_action( 'elementor/loaded' ) ) {
				return false;
			}

			/** fallback to slug if empty ID */
			if ( empty( $settings['id'] ) && ! empty( $settings['slug'] ) ) {
				$ids = get_posts( [
						'post_type'      => 'rb-etemplate',
						'posts_per_page' => 1,
						'name'           => $settings['slug'],
						'fields'         => 'ids',
				] );
				if ( ! empty( $ids[0] ) ) {
					$settings['id'] = $ids[0];
				}
			}

			if ( empty( $settings['id'] ) || gulir_amp_suppressed_elementor() ) {
				return false;
			}

			return Plugin::instance()->frontend->get_builder_content_for_display( $settings['id'] );
		}

		/**
		 * load style
		 */
		function enqueue_style() {

			if ( ! class_exists( '\Elementor\Core\Files\CSS\Post' ) || gulir_is_amp() ) {
				return;
			}

			$shortcodes                = [];
			$shortcodes[]              = gulir_get_option( 'collapse_template' );
			$shortcodes['mh_template'] = gulir_get_option( 'mh_template' );

			$top_ad = gulir_get_option( 'ad_top_code' );
			if ( strpos( $top_ad, '[Ruby_E_Template' ) !== false ) {
				$shortcodes[] = $top_ad;
			}

			if ( is_home() ) {
				$blog_header_template = gulir_get_option( 'blog_header_template' );
				if ( $blog_header_template ) {
					$shortcodes['header_template'] = $blog_header_template;
				}
				$shortcodes[] = gulir_get_option( 'blog_template' );
				$shortcodes[] = gulir_get_option( 'blog_template_bottom' );
				$shortcodes[] = gulir_get_option( 'blog_template_global' );
			} elseif ( is_singular() ) {

				$post_id = get_the_ID();
				if ( is_single() && function_exists( 'gulir_get_single_layout' ) ) {

					$layout = gulir_get_single_layout();
					if ( ! empty( $layout['shortcode'] ) ) {
						$shortcodes[] = $layout['shortcode'];
					}
					$post_type = get_post_type( $post_id );
					if ( 'post' === $post_type ) {
						$format_options = [
								'video'   => 'single_post_header_template_video',
								'audio'   => 'single_post_header_template_audio',
								'gallery' => 'single_post_header_template_gallery',
						];
						if ( ! empty( $layout['format'] ) && ! empty( $format_options[ $layout['format'] ] ) ) {
							$single_header_shortcode = gulir_get_option( $format_options[ $layout['format'] ] );
						}
					} elseif ( 'podcast' == $post_type ) {
						$single_header_shortcode = gulir_get_option( 'single_podcast_header_template' );
					}
					if ( empty( $single_header_shortcode ) ) {
						$single_header_shortcode = gulir_get_option( 'single_post_header_template' );
					}

					if ( ! empty( $single_header_shortcode ) ) {
						$shortcodes['header_template'] = $single_header_shortcode;
					}

					if ( ! empty( $layout['layout'] ) && 'stemplate' !== $layout['layout'] && function_exists( 'gulir_get_single_sidebar_name' ) ) {

						$sidebar_name     = gulir_get_single_sidebar_name();
						$sidebar_position = function_exists( 'gulir_get_single_sidebar_position' ) ? gulir_get_single_sidebar_position() : 'none';

						if ( ! empty( $sidebar_name ) && 'none' !== $sidebar_position ) {

							$sidebars_widgets = get_option( 'sidebars_widgets', [] );
							$widget_template  = get_option( 'widget_widget-template', [] );
							if ( ! empty( $sidebars_widgets[ $sidebar_name ] ) && ! empty( $widget_template ) ) {
								foreach ( $sidebars_widgets[ $sidebar_name ] as $widget ) {
									if ( strpos( $widget, 'widget-template' ) !== false ) {
										$widget_id = absint( str_replace( 'widget-template-', '', $widget ) );
										if ( ! empty( $widget_template[ $widget_id ]['shortcode'] ) ) {
											$shortcodes[] = trim( $widget_template[ $widget_id ]['shortcode'] );
										} elseif ( ! empty( $widget_template[ $widget_id ]['template_id'] ) ) {
											$shortcodes[] = '[Ruby_E_Template id="' . $widget_template[ $widget_id ]['template_id'] . '"]';
										}
									}
								}
							}
						}
					}
					$shortcodes[] = gulir_get_option( 'single_post_related_shortcode' );
					$shortcodes[] = gulir_get_option( 'single_post_popular_shortcode' );
				}

				if ( is_page_template( 'bookmark.php' ) ) {
					$shortcodes[] = gulir_get_option( 'saved_template' );
				}
				$header = rb_get_meta( 'header_template', $post_id );
				$footer = rb_get_meta( 'footer_template', $post_id );
				$mobile = rb_get_meta( 'mh_template', $post_id );

				if ( ! empty( $header ) ) {
					$shortcodes['header_template'] = $header;
				}
				if ( ! empty( $mobile ) ) {
					$shortcodes['mh_template'] = $mobile;
				}
				if ( ! empty( $footer ) ) {
					$shortcodes['footer_template'] = $footer;
				}
			} elseif ( is_category() ) {

				$term_meta = rb_get_term_meta( 'gulir_category_meta', get_queried_object_id() );
				if ( ! empty( $term_meta['template_global'] ) ) {
					$shortcodes['template_global'] = $term_meta['template_global'];
				} elseif ( empty( $term_meta['layout'] ) ) {
					$shortcodes['template_global'] = gulir_get_option( 'category_template_global' );
				}
				$shortcodes[]                  = ! empty( $term_meta['template'] ) ? $term_meta['template'] : gulir_get_option( 'category_template' );
				$shortcodes['header_template'] = ! empty( $term_meta['header_template'] ) ? $term_meta['header_template'] : gulir_get_option( 'category_header_template' );
			} elseif ( is_tax( 'series' ) ) {
				$term_meta                     = rb_get_term_meta( 'gulir_category_meta', get_queried_object_id() );
				$shortcodes['template_global'] = ! empty( $term_meta['template_global'] ) ? $term_meta['template_global'] : gulir_get_option( 'series_template_global' );
				$shortcodes['header_template'] = ! empty( $term_meta['header_template'] ) ? $term_meta['header_template'] : gulir_get_option( 'series_header_template' );
			} elseif ( is_search() ) {

				$shortcodes[]                  = gulir_get_option( 'search_top_template' );
				$shortcodes['header_template'] = gulir_get_option( 'search_header_template' );
				$shortcodes['template_global'] = gulir_get_option( 'search_template_global' );
			} elseif ( is_tag() ) {

				$term_meta                     = rb_get_term_meta( 'gulir_category_meta', get_queried_object_id() );
				$shortcodes[]                  = ! empty( $term_meta['template'] ) ? $term_meta['template'] : gulir_get_option( 'tag_template' );
				$shortcodes['header_template'] = ! empty( $term_meta['header_template'] ) ? $term_meta['header_template'] : null;
				$shortcodes['template_global'] = ! empty( $term_meta['template_global'] ) ? $term_meta['template_global'] : gulir_get_option( 'tag_template_global', gulir_get_option( 'archive_template_global' ) );
			} elseif ( is_tax() ) {

				$term                          = get_queried_object();
				$term_meta                     = rb_get_term_meta( 'gulir_category_meta', $term->term_id );
				$shortcodes['header_template'] = ! empty( $term_meta['header_template'] ) ? $term_meta['header_template'] : null;

				if ( ! empty( $term_meta['template_global'] ) ) {
					$shortcodes['template_global'] = $term_meta['template_global'];
				} else {
					$shortcodes['template_global'] = gulir_get_option( $term->taxonomy . '_tax_template_global', gulir_get_option( 'tax_template_global', gulir_get_option( 'archive_template_global' ) ) );
				}
			} elseif ( is_post_type_archive() ) {

				$archive = get_queried_object();
				$key     = $archive->name;

				$shortcodes['template_global'] = gulir_get_option( $key . '_archive_template_global', gulir_get_option( 'archive_template_global' ) );
			} elseif ( is_archive() ) {
				$shortcodes['template_global'] = gulir_get_option( 'archive_template_global' );
			} elseif ( is_404() ) {
				$shortcodes[] = gulir_get_option( 'page_404_template' );
			}

			if ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$shortcodes[] = gulir_get_option( 'wc_shop_template' );
			}

			if ( empty( $shortcodes['header_template'] ) ) {
				$shortcodes['header_template'] = gulir_get_option( 'header_template' );
			}
			if ( empty( $shortcodes['footer_template'] ) ) {
				$shortcodes['footer_template'] = gulir_get_option( 'footer_template_shortcode' );
			}

			/** add styles */
			$shortcodes = array_filter( $shortcodes );
			if ( count( $shortcodes ) ) {
				$elementor = Plugin::instance();
				$elementor->frontend->enqueue_styles();
				foreach ( $shortcodes as $shortcode ) {
					if ( ! empty( $shortcode ) ) {
						$shortcode = trim( $shortcode );
						preg_match( '/' . get_shortcode_regex() . '/s', $shortcode, $matches );
						if ( ! empty( $matches[3] ) ) {
							$atts = shortcode_parse_atts( $matches[3] );
							if ( ! empty( $atts['id'] ) ) {
								$css_file = new Post( $atts['id'] );
								$css_file->enqueue();
							} elseif ( ! empty( $atts['slug'] ) ) {
								$ids = get_posts( [
										'post_type'      => 'rb-etemplate',
										'posts_per_page' => 1,
										'name'           => $atts['slug'],
										'fields'         => 'ids',
								] );
								if ( ! empty( $ids[0] ) ) {
									$css_file = new Post( $ids[0] );
									$css_file->enqueue();
								}
							}
						}
					}
				}
			}
		}


		/**
		 * Load and print the inline Elementor CSS for next posts using template.
		 *
		 * This function parses the given shortcode to extract either an ID or a slug,
		 * resolves the corresponding `rb-etemplate` post, then loads its Elementor CSS.
		 *
		 * @param string $shortcode The shortcode string, e.g. [Ruby_E_Template id="123"] or [Ruby_E_Template slug="my-template"].
		 *
		 * @return void
		 */
		public function load_single_style( $shortcode ) {

			if ( ! class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				return;
			}

			// Check if the shortcode is a Ruby_E_Template shortcode
			if ( strpos( $shortcode, '[Ruby_E_Template' ) === false ) {
				return;
			}

			$post_id = null;
			$slug    = null;

			// Extract ID if present
			if ( preg_match( '/id="?(\d+)"?/i', $shortcode, $m ) ) {
				$post_id = intval( $m[1] );
			} elseif ( preg_match( '/slug="?(.*?)"?/i', $shortcode, $m ) ) {
				$slug = sanitize_title( $m[1] );
			}

			if ( empty( $post_id ) && ! empty( $slug ) ) {
				$post = get_page_by_path( $slug, OBJECT, 'rb-etemplate' );
				if ( $post ) {
					$post_id = intval( $post->ID );
				}
			}

			if ( empty( $post_id ) ) {
				return;
			}

			// Generate Elementor CSS for this template
			$css_file = new \Elementor\Core\Files\CSS\Post( $post_id );
			$css_file->enqueue();
			$raw_css = $css_file->get_content();
			if ( ! empty( $raw_css ) ) {
				echo '<style id="elementor-inline-css-' . intval( $post_id ) . '">' . $raw_css . '</style>';
			}

		}


		/** enable support for Elementor */
		function enable_support() {

			add_post_type_support( 'rb-etemplate', 'elementor' );
		}

		public function register_post_type() {

			if ( ! defined( 'GULIR_THEME_VERSION' ) ) {
				return;
			}

			register_post_type( 'rb-etemplate', [
					'labels'              => [
							'name'               => esc_html__( 'Ruby Templates', 'gulir-core' ),
							'all_items'          => esc_html__( 'All Templates', 'gulir-core' ),
							'menu_name'          => esc_html__( 'Ruby Templates', 'gulir-core' ),
							'singular_name'      => esc_html__( 'Ruby Template', 'gulir-core' ),
							'add_new'            => esc_html__( 'Add Template', 'gulir-core' ),
							'add_item'           => esc_html__( 'New Template', 'gulir-core' ),
							'add_new_item'       => esc_html__( 'Add New Template', 'gulir-core' ),
							'new_item'           => esc_html__( 'Add New Template', 'gulir-core' ),
							'edit_item'          => esc_html__( 'Edit Template', 'gulir-core' ),
							'not_found'          => esc_html__( 'No template item found.', 'gulir-core' ),
							'not_found_in_trash' => esc_html__( 'No template item found in Trash.', 'gulir-core' ),
							'parent_item_colon'  => '',
					],
					'public'              => true,
					'has_archive'         => false,
					'can_export'          => true,
					'rewrite'             => false,
					'capability_type'     => 'page',
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'menu_position'       => 5,
					'show_ui'             => true,
					'menu_icon'           => 'dashicons-art',
					'supports'            => [ 'title', 'editor' ],
			] );
		}

		public function no_sitemap( $args, $post_type ) {
			if ( 'rb-etemplate' === $post_type ) {
				return [
						'post_type' => $post_type,
						'post__in'  => [ 0 ],
				];
			}

			return $args;
		}

		function shortcode_info() {

			add_meta_box( 'rb_etemplate_info', 'Template Shortcode', [
					$this,
					'render_info',
			], 'rb-etemplate', 'side', 'high' );
		}

		function render_info( $post ) { ?>
			<h4 style="margin-bottom:5px;">shortcode Text</h4>
			<input type='text' class='widefat' value='[Ruby_E_Template id="<?php echo $post->ID; ?>"]' readonly="">
			<?php
		}

		function add_column( $columns ) {

			$columns['rb_e_shortcode'] = esc_html__( 'Template Shortcode', 'gulir-core' );

			return $columns;
		}

		function column_shortcode_info( $column, $post_id ) {

			if ( 'rb_e_shortcode' === $column ) {
				echo '<input type="text" class="widefat" value=\'[Ruby_E_Template id="' . $post_id . '"]\' readonly="">';
			}
		}
	}
}

/** LOAD */
Rb_E_Template::get_instance();