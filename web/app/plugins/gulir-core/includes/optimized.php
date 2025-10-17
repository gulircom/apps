<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

add_action( 'init', [ 'Gulir_Optimized', 'get_instance' ] );

if ( ! class_exists( 'Gulir_Optimized', false ) ) {
	class Gulir_Optimized {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_action( 'wp', [ $this, 'header_buffer' ], 100 );
			add_action( 'wp_head', [ $this, 'site_description' ], 2 );
			add_action( 'wp_head', [ $this, 'schema_organization' ], 5 );
			add_action( 'wp_head', [ $this, 'site_links' ], 10 );
			add_action( 'wp_head', [ $this, 'article_markup' ], 12 );
			add_action( 'wp_head', [ $this, 'review_markup' ], 15 );
			add_action( 'wp_head', [ $this, 'live_blog_markup' ], 16 );
			add_action( 'wp_head', [ $this, 'podcast_markup' ], 20 );
			add_action( 'wp_head', [ $this, 'breadcrumb_markup' ], 25 );

			/** use jetpack og tags */
			if ( gulir_get_option( 'open_graph' ) ) {
				if ( class_exists( 'Jetpack' ) ) {
					add_filter( 'jetpack_enable_open_graph', '__return_true', 10 );
				} else {
					add_action( 'wp_head', [ $this, 'open_graph' ], 20 );
				}
			}
			add_action( 'wp_footer', [ $this, 'post_list_markup' ] );
			add_filter( 'post_class', [ $this, 'remove_hatom' ], 10, 1 );

			add_action( 'init', [ $this, 'set_elementor_font_display' ], 20 );
			add_filter( 'pvc_enqueue_styles', '__return_false' );
			add_filter( 'wp_get_attachment_image_attributes', [ $this, 'optimize_featured_image' ], 10, 3 );
			add_filter( 'wp_lazy_loading_enabled', [ $this, 'lazyload_content_image' ] );
			add_filter( 'wp_img_tag_add_srcset_and_sizes_attr', [ $this, 'remove_srcset_content_image' ], 10, 1 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_optimized' ], 999 );
			add_action( 'wp_head', [ $this, 'preload_font_icon' ], 9 );
			add_filter( 'get_the_date', [ $this, 'force_updated_date' ], 999, 3 );
			add_filter( 'get_the_time', [ $this, 'force_updated_time' ], 999, 3 );
		}

		private $open_graph_conflicting_plugins = [
			'2-click-socialmedia-buttons/2-click-socialmedia-buttons.php',
			'add-link-to-facebook/add-link-to-facebook.php',
			'add-meta-tags/add-meta-tags.php',
			'complete-open-graph/complete-open-graph.php',
			'easy-facebook-share-thumbnails/esft.php',
			'heateor-open-graph-meta-tags/heateor-open-graph-meta-tags.php',
			'facebook/facebook.php',
			'facebook-awd/AWD_facebook.php',
			'facebook-featured-image-and-open-graph-meta-tags/fb-featured-image.php',
			'facebook-meta-tags/facebook-metatags.php',
			'wonderm00ns-simple-facebook-open-graph-tags/wonderm00n-open-graph.php',
			'facebook-revised-open-graph-meta-tag/index.php',
			'facebook-thumb-fixer/_facebook-thumb-fixer.php',
			'facebook-and-digg-thumbnail-generator/facebook-and-digg-thumbnail-generator.php',
			'network-publisher/networkpub.php',
			'nextgen-facebook/nextgen-facebook.php',
			'social-networks-auto-poster-facebook-twitter-g/NextScripts_SNAP.php',
			'og-tags/og-tags.php',
			'opengraph/opengraph.php',
			'open-graph-protocol-framework/open-graph-protocol-framework.php',
			'seo-facebook-comments/seofacebook.php',
			'seo-ultimate/seo-ultimate.php',
			'sexybookmarks/sexy-bookmarks.php',
			'shareaholic/sexy-bookmarks.php',
			'sharepress/sharepress.php',
			'simple-facebook-connect/sfc.php',
			'social-discussions/social-discussions.php',
			'social-sharing-toolkit/social_sharing_toolkit.php',
			'socialize/socialize.php',
			'squirrly-seo/squirrly.php',
			'only-tweet-like-share-and-google-1/tweet-like-plusone.php',
			'wordbooker/wordbooker.php',
			'wpsso/wpsso.php',
			'wp-caregiver/wp-caregiver.php',
			'wp-facebook-like-send-open-graph-meta/wp-facebook-like-send-open-graph-meta.php',
			'wp-facebook-open-graph-protocol/wp-facebook-ogp.php',
			'wp-ogp/wp-ogp.php',
			'zoltonorg-social-plugin/zosp.php',
			'wp-fb-share-like-button/wp_fb_share-like_widget.php',
			'open-graph-metabox/open-graph-metabox.php',
			'seo-by-rank-math/rank-math.php',
			'slim-seo/slim-seo.php',
			'all-in-one-seo-pack/all_in_one_seo_pack.php',
		];

		private $meta_description_conflicting_plugins = [
			'seo-by-rank-math/rank-math.php',
			'slim-seo/slim-seo.php',
			'all-in-one-seo-pack/all_in_one_seo_pack.php',
			'wordpress-seo/wp-seo.php',
			'seo-ultimate/seo-ultimate.php',
		];

		/**
		 * @return bool
		 */
		public function check_conflict_open_graph() {

			$active_plugins = gulir_get_active_plugins();
			if ( in_array( 'wordpress-seo/wp-seo.php', $active_plugins, true ) ) {
				$yoast_social = get_option( 'wpseo_social' );
				if ( ! empty( $yoast_social['opengraph'] ) ) {
					return true;
				}
			}

			if ( in_array( 'wp-seopress/seopress.php', $active_plugins, true ) ) {
				$seopress_setting = get_option( 'seopress_social_option_name' );
				if ( ! empty( $seopress_setting['seopress_social_facebook_og'] ) ) {
					return true;
				}
			}

			if ( ! empty( $active_plugins ) ) {
				foreach ( $this->open_graph_conflicting_plugins as $plugin ) {
					if ( in_array( $plugin, $active_plugins, true ) ) {
						return true;
					}
				}
			}

			return false;
		}

		public function get_description( $post_id, $max_length = 52 ) {

			if ( empty( $post_id ) ) {
				return false;
			}

			$description = rb_get_meta( 'meta_description', $post_id );

			if ( empty( $description ) ) {
				$description = rb_get_meta( 'tagline', $post_id );
			}
			if ( empty( $description ) ) {
				$description = get_post_field( 'post_excerpt', $post_id );
			}
			if ( empty( $description ) ) {
				$description = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), $max_length, '' );
			}

			return $description;
		}

		/**
		 * @return false
		 */
		function site_links() {

			if ( ! gulir_get_option( 'website_markup' ) ) {
				return false;
			}

			$home_url = home_url( '/' );
			$json_ld  = [
				'@context'        => gulir_protocol() . '://schema.org',
				'@type'           => 'WebSite',
				'@id'             => $home_url . '#website',
				'url'             => $home_url,
				'name'            => get_bloginfo( 'name' ),
				'potentialAction' => [
					'@type'       => 'SearchAction',
					'target'      => $home_url . '?s={search_term_string}',
					'query-input' => 'required name=search_term_string',
				],
			];

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		public function site_description() {

			if ( ! gulir_get_option( 'website_description' ) ) {
				return false;
			}

			$active_plugins = gulir_get_active_plugins();
			if ( ! empty( $active_plugins ) ) {
				foreach ( $this->meta_description_conflicting_plugins as $plugin ) {
					if ( in_array( $plugin, $active_plugins, true ) ) {
						return false;
					}
				}
			}

			if ( is_front_page() ) {
				$content = gulir_get_option( 'site_description' );
				if ( empty( $content ) ) {
					$content = get_bloginfo( 'description' );
				}
				if ( ! empty ( $content ) ) {
					echo '<meta name="description" content="' . wp_strip_all_tags( $content ) . '">';
				}
			} elseif ( is_single() ) {
				$content = $this->get_description( get_the_ID() );
				if ( ! empty( $content ) ) {
					echo '<meta name="description" content="' . wp_strip_all_tags( $content ) . '">';
				}
			} elseif ( is_page() ) {
				$content = rb_get_meta( 'meta_description' );
				if ( ! empty( $content ) ) {
					echo '<meta name="description" content="' . wp_strip_all_tags( $content ) . '">';
				}
			} elseif ( is_archive() ) {
				$content = get_the_archive_description();
				if ( ! empty( $content ) ) {
					$content = gulir_get_option( 'limit_archive_description' ) ? wp_trim_words( wp_strip_all_tags( $content ), 160, '...' ) : wp_strip_all_tags( $content );
					echo '<meta name="description" content="' . $content . '">';
				}
			}

			return false;
		}

		function schema_organization() {

			if ( ! gulir_get_option( 'organization_markup' ) ) {
				return false;
			}

			$site_street   = gulir_get_option( 'site_street' );
			$site_locality = gulir_get_option( 'site_locality' );
			$site_phone    = gulir_get_option( 'site_phone' );
			$site_email    = gulir_get_option( 'site_email' );
			$postal_code   = gulir_get_option( 'postal_code' );

			$home_url = home_url( '/' );

			$json_ld = [
				'@context'  => gulir_protocol() . '://schema.org',
				'@type'     => 'Organization',
				'legalName' => get_bloginfo( 'name' ),
				'url'       => $home_url,
			];

			if ( ! empty( $site_street ) || ! empty( $site_locality ) ) {
				$json_ld['address']['@type'] = 'PostalAddress';

				if ( ! empty( $site_street ) ) {
					$json_ld['address']['streetAddress'] = esc_html( $site_street );
				}

				if ( ! empty( $site_locality ) ) {
					$json_ld['address']['addressLocality'] = esc_html( $site_locality );
				}

				if ( ! empty( $postal_code ) ) {
					$json_ld['address']['postalCode'] = esc_html( $postal_code );
				}
			}

			if ( ! empty( $site_email ) ) {
				$json_ld['email'] = esc_html( $site_email );
			}

			if ( ! empty( $site_phone ) ) {
				$json_ld['contactPoint'] = [
					'@type'       => 'ContactPoint',
					'telephone'   => esc_html( $site_phone ),
					'contactType' => 'customer service',
				];
			}

			$logo = gulir_get_option( 'logo_organization' );
			if ( empty( $logo['url'] ) ) {
				$logo = gulir_get_option( 'logo' );
			}
			if ( ! empty( $logo['url'] ) ) {
				$json_ld['logo'] = $logo['url'];
			}
			$social = [
				gulir_get_option( 'facebook' ),
				gulir_get_option( 'twitter' ),
				gulir_get_option( 'youtube' ),
				gulir_get_option( 'googlenews' ),
				gulir_get_option( 'instagram' ),
				gulir_get_option( 'pinterest' ),
				gulir_get_option( 'tiktok' ),
				gulir_get_option( 'linkedin' ),
				gulir_get_option( 'medium' ),
				gulir_get_option( 'flipboard' ),
				gulir_get_option( 'twitch' ),
				gulir_get_option( 'steam' ),
				gulir_get_option( 'tumblr' ),
				gulir_get_option( 'discord' ),
				gulir_get_option( 'skype' ),
				gulir_get_option( 'snapchat' ),
				gulir_get_option( 'quora' ),
				gulir_get_option( 'spotify' ),
				gulir_get_option( 'apple_podcast' ),
				gulir_get_option( 'google_podcast' ),
				gulir_get_option( 'stitcher' ),
				gulir_get_option( 'myspace' ),
				gulir_get_option( 'bloglovin' ),
				gulir_get_option( 'digg' ),
				gulir_get_option( 'dribbble' ),
				gulir_get_option( 'flickr' ),
				gulir_get_option( 'soundcloud' ),
				gulir_get_option( 'vimeo' ),
				gulir_get_option( 'reddit' ),
				gulir_get_option( 'vkontakte' ),
				gulir_get_option( 'telegram' ),
				gulir_get_option( 'whatsapp' ),
				gulir_get_option( 'truth' ),
				gulir_get_option( 'paypal' ),
				gulir_get_option( 'patreon' ),
				gulir_get_option( 'threads' ),
				gulir_get_option( 'bluesky' ),
				gulir_get_option( 'rss' ),
				gulir_get_option( 'custom_social_1_url' ),
				gulir_get_option( 'custom_social_2_url' ),
				gulir_get_option( 'custom_social_3_url' ),
			];

			foreach ( $social as $key => $el ) {
				if ( empty( $el ) || '#' === $el ) {
					unset( $social[ $key ] );
				}
			}

			if ( count( $social ) ) {
				$json_ld['sameAs'] = array_values( $social );
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		function get_authors( $post_id ) {

			$data        = [];
			$author_id   = get_post_field( 'post_author', $post_id );
			$author_name = get_the_author_meta( 'display_name', $author_id );
			$author_link = get_the_author_meta( 'url', $author_id );
			if ( empty( $author_link ) ) {
				$author_link = get_author_posts_url( $author_id );
			}

			if ( ! function_exists( 'get_post_authors' ) ) {
				$data = [
					'@type' => 'Person',
					'name'  => $author_name,
					'url'   => $author_link,
				];
			} else {
				$authors = get_post_authors( $post_id );
				if ( is_array( $authors ) && count( $authors ) > 1 ) {
					foreach ( $authors as $auth ) {
						$auth_id   = $auth->ID;
						$auth_link = get_the_author_meta( 'url', $auth_id );
						if ( empty( $auth_link ) ) {
							$auth_link = get_author_posts_url( $auth_id );
						}
						$data[] = [
							'@type' => 'Person',
							'name'  => get_the_author_meta( 'display_name', $auth_id ),
							'url'   => $auth_link,
						];
					}
				} else {
					$data = [
						'@type' => 'Person',
						'name'  => $author_name,
						'url'   => $author_link,
					];
				}
			}

			return $data;
		}

		function get_publisher() {

			$logo = gulir_get_option( 'logo_organization' );
			if ( empty( $logo['url'] ) ) {
				$logo = gulir_get_option( 'logo' );
			}
			if ( empty( $logo['url'] ) ) {
				$logo = gulir_get_option( 'dark_logo' );
			}
			if ( ! empty( $logo['url'] ) ) {
				$publisher_logo = esc_url( $logo['url'] );
			} else {
				$publisher_logo = '';
			}

			return [
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
				'logo'  => [
					'@type' => 'ImageObject',
					'url'   => $publisher_logo,
				],
			];
		}

		function get_current_page() {

			$page = get_query_var( 'page' );
			if ( ! empty( $page ) ) {
				return (int) $page;
			}

			$paged = get_query_var( 'paged' );
			if ( ! empty( $paged ) ) {
				return (int) $paged;
			}

			return 1;
		}

		function article_markup() {

			if ( ! is_singular( 'post' ) || gulir_conflict_schema() || gulir_is_doing_ajax() ) {
				return false;
			}

			$post_id = get_the_ID();
			$markup  = rb_get_meta( 'article_markup' );

			if ( empty( $markup ) || 'default' === $markup ) {
				$markup = gulir_get_option( 'single_post_article_markup' );
			}

			if ( empty( $markup ) || '-1' === $markup ) {
				return false;
			}

			$type = 'Article';

			if ( '2' === (string) $markup ) {
				$type = 'NewsArticle';
			}

			$categories = get_the_category( $post_id );
			$image      = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

			$json_ld = [
				'@context'         => gulir_protocol() . '://schema.org',
				'@type'            => $type,
				'headline'         => get_the_title(),
				'description'      => $this->get_description( $post_id ),
				'mainEntityOfPage' => [
					"@type" => 'WebPage',
					'@id'   => get_permalink(),
				],
				'author'           => $this->get_authors( $post_id ),
				'publisher'        => $this->get_publisher(),
				'dateModified'     => get_the_modified_date( DATE_W3C, $post_id ),
				'datePublished'    => get_the_date( DATE_W3C, $post_id ),
				'image'            => [
					'@type'  => 'ImageObject',
					'url'    => ! empty( $image[0] ) ? esc_url( $image[0] ) : '',
					'width'  => ! empty( $image[1] ) ? esc_attr( $image[1] ) : '',
					'height' => ! empty( $image[2] ) ? esc_attr( $image[2] ) : '',
				],
				'commentCount'     => get_comment_count( $post_id )['approved'],
			];

			if ( is_array( $categories ) ) {
				foreach ( $categories as $category ) {
					$json_ld['articleSection'][] = $category->name;
				}
			}

			$current_page = $this->get_current_page();
			if ( 1 < $current_page ) {
				$json_ld['pagination'] = $current_page;
			}

			if ( gulir_get_option( 'single_post_video_markup' ) && 'video' === get_post_format( $post_id ) ) {

				$video_hosted = rb_get_meta( 'video_hosted', $post_id );
				$duration     = trim( rb_get_meta( 'duration', $post_id ) );

				if ( ! empty( $hosted_video ) ) {
					$attachment_url = wp_get_attachment_url( $video_hosted );
					if ( ! empty( $attachment_url ) ) {

						$json_ld['video'] = [
							'@type'        => 'VideoObject',
							'name'         => get_the_title(),
							'thumbnailUrl' => ! empty( $image[0] ) ? esc_url( $image[0] ) : '',
							'description'  => $this->get_description( $post_id ),
							'contentUrl'   => $attachment_url,
							'uploadDate'   => get_the_date( DATE_W3C, $post_id ),
						];
					}
				} else {

					$iframe_code = trim( rb_get_meta( 'video_embed', $post_id ) );
					if ( empty( $iframe_code ) ) {
						$video_url = trim( rb_get_meta( 'video_url', $post_id ) );
						if ( ! empty( $video_url ) ) {
							$iframe_code = wp_oembed_get( $video_url, [
								'width'  => 740,
								'height' => 415,
							] );
						}
					}
					if ( ! empty( $iframe_code ) ) {
						$pattern = '/<iframe.*?src="(.*?)".*?>/i';
						if ( preg_match( $pattern, $iframe_code, $matches ) ) {
							$embed_url = $matches[1];
						}
					}

					if ( ! empty( $embed_url ) ) {
						$embed_url        = explode( '?', $embed_url )[0];
						$json_ld['video'] = [
							'@type'        => 'VideoObject',
							'name'         => get_the_title(),
							'thumbnailUrl' => ! empty( $image[0] ) ? esc_url( $image[0] ) : '',
							'description'  => $this->get_description( $post_id ),
							'embedUrl'     => $embed_url,
							'uploadDate'   => get_the_date( DATE_W3C, $post_id ),
						];
					}
				}

				if ( ! empty( $duration ) && ! empty( $json_ld['video'] ) ) {
					$sec = strtotime( $duration, 0 );
					if ( intval( $sec ) ) {
						$json_ld['video']['duration'] = $this->iso8601_duration( $sec );
					}
				}
			}

			$sponsor = rb_get_meta( 'sponsor_post', $post_id );
			if ( ! empty( $sponsor ) && '1' === (string) $sponsor ) {
				$sponsor_logo_id = rb_get_meta( 'sponsor_logo', $post_id );
				$sponsor_name    = rb_get_meta( 'sponsor_name', $post_id );

				$json_ld['sponsor'] = [
					'@type' => 'Organization',
					'url'   => esc_url( rb_get_meta( 'sponsor_url', $post_id ) ),
				];

				if ( ! empty( $sponsor_name ) ) {
					$json_ld['sponsor']['name'] = $sponsor_name;
				}

				if ( ! empty( $sponsor_logo_id ) ) {
					$logo_url = wp_get_attachment_image_url( $sponsor_logo_id, 'full' );
					if ( $logo_url ) {
						$json_ld['sponsor']['logo'] = [
							'@type' => 'ImageObject',
							'url'   => esc_url( $logo_url ),
						];
					}
				}
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		/**
		 * @return false
		 */
		function review_markup() {

			if ( ! is_single() || ! function_exists( 'gulir_get_review_settings' ) || gulir_is_doing_ajax() ) {
				return false;
			}

			$markup = rb_get_meta( 'review_markup' );
			if ( ( ! empty( $markup ) && '-1' === (string) $markup ) || ( empty( $markup ) || 'default' === $markup ) && ! gulir_get_option( 'single_post_review_markup' ) ) {
				return false;
			}

			$post_id  = get_the_ID();
			$settings = gulir_get_review_settings( $post_id );
			if ( empty( $settings ) || ! is_array( $settings ) ) {
				return false;
			}

			$bestRating   = 5;
			$worstRating  = 1;
			$average      = 5;
			$rating_value = 5;
			$rating_count = 3;

			if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
				$bestRating   = 10;
				$worstRating  = 1;
				$average      = 10;
				$rating_value = 10;
				$rating_count = 3;
			}

			if ( isset( $settings['average'] ) ) {
				$average      = $settings['average'];
				$rating_value = $settings['average'];
			}

			$author = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
			$image  = get_the_post_thumbnail_url( $post_id, 'full' );
			$sku    = get_post_field( 'post_name', $post_id );
			$name   = get_the_title( $post_id );

			if ( isset( $settings['summary'] ) ) {
				$description = $settings['summary'];
			} else {
				$description = $this->get_description( $post_id );
			}

			if ( ! empty( $settings['user_rating']['count'] ) ) {
				$rating_count = $settings['user_rating']['count'];
			}

			if ( ! empty( $settings['user_rating']['average'] ) ) {
				if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
					$rating_value = floatval( $settings['user_rating']['average'] ) * 2;
				} else {
					$rating_value = $settings['user_rating']['average'];
				}
			}

			$json_ld = [
				'@context'    => gulir_protocol() . '://schema.org',
				'@type'       => 'Product',
				'description' => $description,
				'image'       => $image,
				'name'        => $name,
				'mpn'         => $post_id,
				'sku'         => $sku,
				'brand'       => [
					'@type' => 'Brand',
					'name'  => get_bloginfo( 'name' ),
				],
			];

			$json_ld['review'] = [
				'author'       => [
					'@type' => 'Person',
					'name'  => $author,
				],
				'@type'        => 'Review',
				'reviewRating' => [
					'@type'       => 'Rating',
					'ratingValue' => $average,
					'bestRating'  => $bestRating,
					'worstRating' => $worstRating,
				],
			];

			if ( ! empty( $settings['user'] ) ) {
				$json_ld['aggregateRating'] = [
					'@type'       => 'AggregateRating',
					'ratingValue' => $rating_value,
					'ratingCount' => $rating_count,
					'bestRating'  => $bestRating,
					'worstRating' => $worstRating,
				];
			}

			if ( ! empty( $settings['destination'] ) && ! empty( $settings['price'] ) ) {
				if ( empty( $settings['currency'] ) ) {
					$settings['currency'] = 'USD';
				}
				$json_ld['offers'] = [
					'@type'         => 'Offer',
					'url'           => esc_url( $settings['destination'] ),
					'price'         => ltrim( preg_replace( '/[^\d.]/', '', $settings['price'] ), '0' ),
					'priceCurrency' => $settings['currency'],
					'itemCondition' => 'https://schema.org/UsedCondition',
					'availability'  => 'https://schema.org/InStock',
				];

				if ( ! empty( $settings['expired'] ) ) {
					$json_ld['offers']['priceValidUntil'] = esc_attr( $settings['expired'] );
				}
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		function is_live_blog( $post_id ) {

			$live_blog = rb_get_meta( 'live_blog', $post_id );
			if ( empty( $live_blog ) || 'default' === $live_blog ) {
				return false;
			}

			return true;
		}

		function live_blog_markup() {

			if ( ! is_single() || ! gulir_get_option( 'single_post_live_markup' ) || gulir_is_doing_ajax() ) {
				return false;
			}
			$post_id = get_the_ID();
			if ( ! $this->is_live_blog( $post_id ) ) {
				return false;
			}
			$location = rb_get_meta( 'live_location', $post_id );

			$json_ld = [
				'@context'          => gulir_protocol() . '://schema.org',
				'@type'             => 'LiveBlogPosting',
				'@id'               => get_permalink( $post_id ),
				'headline'          => get_the_title( $post_id ),
				'description'       => $this->get_description( $post_id ),
				'about'             => [
					'@type'     => 'Event',
					'startDate' => get_the_date( DATE_W3C, $post_id ),
					'name'      => get_the_title( $post_id ),
					'location'  => $location ? $location : '',
				],
				'author'            => $this->get_authors( $post_id ),
				'publisher'         => $this->get_publisher(),
				'datePublished'     => get_the_date( DATE_W3C, $post_id ),
				'coverageStartTime' => get_the_date( DATE_W3C, $post_id ),
				'dateModified'      => get_the_modified_date( DATE_W3C, $post_id ),
			];
			$medata  = get_post_meta( $post_id, 'ruby_live_metadata', true );
			if ( ! empty( $medata ) ) {
				foreach ( $medata as $index => $metas ) {
					$medata[ $index ]['@type'] = 'BlogPosting';
				}
				$json_ld['liveBlogUpdate'] = $medata;
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		function open_graph() {

			if ( $this->check_conflict_open_graph() || gulir_is_amp() ) {
				return;
			}

			global $post;
			$data = $post;

			$description_length = 197;
			$default_image      = gulir_get_option( 'facebook_default_img' );
			$tags               = [
				'og:description'     => '',
				'og:site_name'       => get_bloginfo( 'name' ),
				'og:locale'          => get_bloginfo( 'language' ),
				'fb:facebook_app_id' => gulir_get_option( 'facebook_app_id' ),
				'og:type'            => 'website',
			];

			if ( is_home() || is_front_page() ) {
				$front_page_id = get_option( 'page_for_posts' );
				if ( 'page' === get_option( 'show_on_front' ) && $front_page_id && is_home() ) {
					$url = get_permalink( $front_page_id );
				} else {
					$url         = home_url( '/' );
					$description = gulir_get_option( 'site_description' );
				}
				if ( empty( $description ) ) {
					$description = get_bloginfo( 'description' );
				}
				$tags['og:title']       = get_bloginfo( 'name' );
				$tags['og:description'] = $description;
				$tags['og:url']         = $url;

				$logo_organization = gulir_get_option( 'logo_organization' );
				if ( ! empty( $logo_organization['url'] ) ) {
					$tags['og:image'] = esc_url( $logo_organization['url'] );
					if ( ! empty( $logo_organization['height'] ) ) {
						$tags['og:image:height'] = (int) $logo_organization['height'];
					}
					if ( ! empty( $logo_organization['width'] ) ) {
						$tags['og:image:width'] = (int) $logo_organization['width'];
					}
					if ( ! empty( $logo_organization['alt'] ) ) {
						$tags['og:image:alt'] = (string) $logo_organization['alt'];
					}
				} else {
					$dark_logo = gulir_get_option( 'dark_logo' );
					if ( ! empty( $dark_logo['url'] ) ) {
						$tags['og:image'] = esc_url( $dark_logo['url'] );
					}
					if ( ! empty( $dark_logo['height'] ) ) {
						$tags['og:image:height'] = (int) $dark_logo['height'];
					}
					if ( ! empty( $dark_logo['width'] ) ) {
						$tags['og:image:width'] = (int) $dark_logo['width'];
					}
				}
			} elseif ( is_author() ) {
				$tags['og:type'] = 'profile';
				$author          = get_queried_object();
				if ( is_a( $author, 'WP_User' ) ) {
					$tags['og:title'] = $author->display_name;
					if ( ! empty( $author->user_url ) ) {
						$tags['og:url'] = $author->user_url;
					} else {
						$tags['og:url'] = get_author_posts_url( $author->ID );
					}
					$tags['og:description']     = $author->description;
					$tags['profile:first_name'] = get_the_author_meta( 'first_name', $author->ID );
					$tags['profile:last_name']  = get_the_author_meta( 'last_name', $author->ID );
					$tags['og:image']           = get_avatar_url( $author->ID, [ 'size' => '999' ] );
				}
			} elseif ( is_archive() ) {
				$archive          = get_queried_object();
				$archive_id       = get_queried_object_id();
				$tags['og:title'] = wp_get_document_title();

				if ( $archive instanceof WP_Term ) {
					$tags['og:url']         = get_term_link( $archive->term_id, $archive->taxonomy );
					$tags['og:description'] = $archive->description;
				} elseif ( ! empty( $archive ) && is_post_type_archive() ) {
					$tags['og:url']         = get_post_type_archive_link( $archive->name );
					$tags['og:description'] = $archive->description;
				}
				$data = rb_get_term_meta( 'gulir_category_meta', $archive_id );
				if ( ! empty( $data['featured_image'][0] ) ) {
					$thumbnail_url = wp_get_attachment_image_url( $data['featured_image'][0], 'full' );
					if ( ! empty( $thumbnail_url ) ) {
						$tags['og:image'] = $thumbnail_url;
						$image_metadata   = wp_get_attachment_metadata( $data['featured_image'][0] );
						$alt_text         = get_post_meta( $data['featured_image'][0], '_wp_attachment_image_alt', true );
						if ( $image_metadata && isset( $image_metadata['width'], $image_metadata['height'] ) ) {
							$tags['og:image:width']  = (int) $image_metadata['width'];
							$tags['og:image:height'] = (int) $image_metadata['height'];
						}
						if ( ! empty( $alt_text ) ) {
							$tags['og:image:alt'] = (string) $alt_text;
						}
					}
				}

				if ( empty( $tags['og:image'] ) && ! empty( $default_image['url'] ) ) {
					$tags['og:image'] = $default_image['url'];
					if ( ! empty( $default_image['height'] ) ) {
						$tags['og:image:height'] = (int) $default_image['height'];
					}
					if ( ! empty( $default_image['width'] ) ) {
						$tags['og:image:width'] = (int) $default_image['width'];
					}
					if ( ! empty( $default_image['alt'] ) ) {
						$tags['og:image:alt'] = (string) $default_image['alt'];
					}
				}
			} elseif ( is_singular() && is_a( $data, 'WP_Post' ) ) {
				$count = intval( get_post_meta( $data->ID, 'gulir_content_total_word', true ) );
				if ( $count > 0 ) {
					$read_speed = intval( gulir_get_option( 'read_speed' ) );
					if ( empty( $read_speed ) ) {
						$read_speed = 130;
					}
					$minutes = floor( $count / $read_speed );
					$second  = floor( ( $count / $read_speed ) * 60 ) % 60;
					if ( $second > 30 ) {
						$minutes ++;
					}
				}
				$tags['og:type']        = 'article';
				$tags['og:title']       = apply_filters( 'the_title', $data->post_title, $data->ID );
				$tags['og:description'] = $this->get_description( $data->ID, $description_length );
				$tags['og:url']         = get_permalink( $data );

				if ( has_post_thumbnail( $data->ID ) ) {
					$image_id         = get_post_thumbnail_id( $data->ID );
					$image_metadata   = wp_get_attachment_metadata( $image_id );
					$alt_text         = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					$tags['og:image'] = wp_get_attachment_image_url( $image_id, 'full' );
					if ( $image_metadata && isset( $image_metadata['width'], $image_metadata['height'] ) ) {
						$tags['og:image:width']  = (int) $image_metadata['width'];
						$tags['og:image:height'] = (int) $image_metadata['height'];
					}
					if ( ! empty( $alt_text ) ) {
						$tags['og:image:alt'] = (string) $alt_text;
					}
				}

				$tags['article:published_time'] = get_the_date( DATE_W3C, $data );
				$tags['article:modified_time']  = get_the_modified_date( DATE_W3C, $data );
				$tags['author']                 = [
					'type'    => 'name',
					'content' => get_the_author_meta( 'display_name', $data->post_author ),
				];
				$publicize_facebook             = get_the_author_meta( 'facebook', $data->post_author );
				if ( ! empty( $publicize_facebook ) ) {
					$tags['article:author'] = esc_url( $publicize_facebook );
				}
				$tags['twitter:card']    = [ 'type' => 'name', 'content' => 'summary_large_image' ];
				$tags['twitter:creator'] = [ 'type' => 'name', 'content' => '@' . gulir_get_twitter_name() ];
				$tags['twitter:label1']  = [
					'type'    => 'name',
					'content' => esc_html__( 'Written by', 'gulir-core' ),
				];
				$tags['twitter:data1']   = [
					'type'    => 'name',
					'content' => get_the_author_meta( 'display_name', $data->post_author ),
				];

				if ( ! empty( $minutes ) ) {
					$tags['twitter:label2'] = [
						'type'    => 'name',
						'content' => esc_html__( 'Est. reading time', 'gulir-core' ),
					];
					$tags['twitter:data2']  = [ 'type' => 'name', 'content' => $minutes . ' minutes' ];
				}

				/** fallback to default image */
				if ( empty( $tags['og:image'] ) && ! empty( $default_image['url'] ) ) {
					$tags['og:image'] = $default_image['url'];
					if ( ! empty( $default_image['height'] ) ) {
						$tags['og:image:height'] = (int) $default_image['height'];
					}
					if ( ! empty( $default_image['width'] ) ) {
						$tags['og:image:width'] = (int) $default_image['width'];
					}
					if ( ! empty( $default_image['alt'] ) ) {
						$tags['og:image:alt'] = (string) $default_image['alt'];
					}
				}
			} elseif ( is_search() ) {
				if ( '' !== get_query_var( 's', '' ) ) {
					$tags['og:title'] = wp_get_document_title();
				}
			}

			/** fallback for empty values */
			if ( empty( $tags['og:title'] ) ) {
				$tags['og:title'] = gulir_html__( '(no title)', 'gulir-core' );
			}
			if ( empty( $tags['og:url'] ) ) {
				$tags['og:url'] = gulir_get_current_permalink();
			}
			if ( ! empty( $tags['og:image'] ) && strpos( $tags['og:image'], 'https' ) !== false ) {
				$tags['og:image:secure_url'] = $tags['og:image'];
			}
			$tags['og:description'] = strlen( $tags['og:description'] ) > $description_length ? mb_substr( $tags['og:description'], 0, $description_length ) . '…' : $tags['og:description'];

			/** render og markup */
			foreach ( $tags as $key => $data ) {
				if ( ! is_array( $data ) ) {
					echo '<meta property="' . esc_attr( $key ) . '" content="' . esc_attr( $data ) . '"/>' . "\n";
				} else {
					if ( isset( $data['type'] ) && isset( $data['content'] ) ) {
						echo '<meta ' . $data['type'] . '="' . esc_attr( $key ) . '" content="' . esc_attr( $data['content'] ) . '"/>' . "\n";
					}
				}
			}
		}

		/**
		 * @return false
		 */
		function post_list_markup() {

			if ( ! gulir_get_option( 'site_itemlist' ) || is_single() || ! isset( $GLOBALS['gulir_queried_ids'] ) || ! array_filter( $GLOBALS['gulir_queried_ids'] ) ) {
				return false;
			}

			$items_list = [];
			$index      = 1;
			$items      = array_unique( $GLOBALS['gulir_queried_ids'] );
			foreach ( $items as $post_id ) {
				$data = [
					'@type'    => "ListItem",
					'position' => $index,
					'url'      => get_permalink( $post_id ),
					'name'     => get_the_title( $post_id ),
					'image'    => get_the_post_thumbnail_url( $post_id, 'full' ),
				];
				array_push( $items_list, $data );
				$index ++;
			}
			$post_data = [
				'@context'        => 'https://schema.org',
				'@type'           => 'ItemList',
				"itemListElement" => $items_list,
			];

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $post_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $post_data );
			}
			echo '</script>', "\n";

			return false;
		}

		/**
		 * @param $classes
		 *
		 * @return mixed
		 */
		function remove_hatom( $classes ) {

			foreach ( $classes as $key => $value ) {
				if ( $value === 'hentry' ) {
					unset( $classes[ $key ] );
				}
			}

			return $classes;
		}

		function lazyload_content_image() {

			if ( empty( gulir_get_option( 'lazy_load_content' ) ) ) {
				return false;
			} else {
				return true;
			}
		}

		function set_elementor_font_display() {

			if ( empty( get_option( 'elementor_font_display' ) ) ) {
				update_option( 'elementor_font_display', 'swap' );
			}
		}

		/**
		 * @param $attr
		 * @param $attachment
		 * @param $size
		 *
		 * @return mixed
		 */
		function optimize_featured_image( $attr, $attachment, $size ) {

			if ( gulir_get_option( 'disable_srcset' ) ) {
				unset( $attr['srcset'] );
				unset( $attr['sizes'] );
			}

			return $attr;
		}

		/**
		 * @param $add
		 *
		 * @return false
		 */
		function remove_srcset_content_image( $add ) {

			if ( gulir_get_option( 'disable_srcset_content' ) ) {
				return false;
			}

			return $add;
		}

		function is_elementor_page() {

			if ( ! is_page() || ! gulir_is_elementor_active() || gulir_amp_suppressed_elementor() ) {
				return false;
			}

			$document = Elementor\Plugin::$instance->documents->get( get_the_ID() );
			if ( $document && $document->is_built_with_elementor() ) {
				return true;
			}

			return false;
		}

		function enqueue_optimized() {

			if ( ! empty( $_GET['elementor-preview'] ) || is_admin() || gulir_is_amp() ) {
				return false;
			}

			if ( gulir_get_option( 'disable_dashicons' ) && ! is_user_logged_in() ) {
				wp_deregister_style( 'dashicons' );
			}

			if ( gulir_get_option( 'disable_block_style' ) && $this->is_elementor_page() && ! is_admin() ) {
				wp_deregister_style( 'wp-block-library' );
			}
		}

		public function header_buffer() {

			// Skip buffering for AMP, admin, or Elementor preview
			if ( gulir_is_amp() || is_admin() || ! empty( $_GET['elementor-preview'] ) ) {
				return;
			}

			// Exit early if no font preload is needed
			$disable_gfonts = gulir_get_option( 'disable_google_font' );
			$preload        = $disable_gfonts ? true : gulir_get_option( 'preload_gfonts' );

			if ( ! $preload ) {
				return;
			}

			// Hook into wp_head to start and end output buffering
			add_action( 'wp_head', [ $this, 'start_head_buffer' ], 0 );
			add_action( 'wp_head', [ $this, 'end_head_buffer' ], PHP_INT_MAX );
		}


		function start_head_buffer() {
			ob_start();
		}


		function end_head_buffer() {

			$in = ob_get_clean();

			$disable_gfonts = gulir_get_option( 'disable_google_font' );

			$markup = preg_replace( '/<!--(.*)-->/Uis', '', $in );
			preg_match_all( '#<link(?:\s+(?:(?!href\s*=\s*)[^>])+)?(?:\s+href\s*=\s*([\'"])((?:https?:)?\/\/fonts\.googleapis\.com\/css(?:(?!\1).)+)\1)(?:\s+[^>]*)?>#iU', $markup, $matches );

			if ( ! $matches[2] ) {
				echo $in;

				return;
			}

			$fonts_data    = [];
			$index         = 0;
			$fonts_string  = '';
			$subset_string = '';
			$add_pos       = '<link';

			foreach ( $matches[2] as $font ) {
				if ( ! preg_match( '/rel=["\']dns-prefetch["\']/', $matches[0][ $index ] ) ) {
					$font = str_replace( [ '%7C', '%7c' ], '|', $font );
					if ( strpos( $font, 'fonts.googleapis.com/css2' ) !== false ) {
						$font = rawurldecode( $font );
						$font = str_replace( [
							'css2?',
							'ital,wght@',
							'wght@',
							'ital@',
							'0,',
							'1,',
							':1',
							';',
							'&family=',
						], [ 'css?', '', '', '', '', 'italic', ':italic', ',', '%7C' ], $font );
					}
					$font      = explode( 'family=', $font );
					$font      = ( isset( $font[1] ) ) ? explode( '&', $font[1] ) : [];
					$this_font = array_values( array_filter( explode( '|', reset( $font ) ) ) );
					if ( ! empty( $this_font ) ) {
						$fonts_data[ $index ]['fonts'] = $this_font;
						$subset                        = ( is_array( $font ) ) ? end( $font ) : '';
						if ( false !== strpos( $subset, 'subset=' ) ) {
							$subset                          = str_replace( [ '%2C', '%2c' ], ',', $subset );
							$subset                          = explode( 'subset=', $subset );
							$fonts_data[ $index ]['subsets'] = explode( ',', $subset[1] );
						}
					}
					$in = str_replace( $matches[0][ $index ], '', $in );
				}
				$index ++;
			}

			foreach ( $fonts_data as $font ) {
				$fonts_string .= '|' . trim( implode( '|', $font['fonts'] ), '|' );
				if ( ! empty( $font['subsets'] ) ) {
					$subset_string .= ',' . trim( implode( ',', $font['subsets'] ), ',' );
				}
			}

			if ( ! empty( $subset_string ) ) {
				$subset_string = str_replace( ',', '%2C', ltrim( $subset_string, ',' ) );
				$fonts_string  = $fonts_string . '&#038;subset=' . $subset_string;
			}

			$fonts_string = str_replace( '|', '%7C', ltrim( $fonts_string, '|' ) );
			$fonts_string .= '&amp;display=swap';

			$fonts_html = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
			$fonts_html .= '<link rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" id="rb-preload-gfonts" href="https://fonts.googleapis.com/css?family=' . $fonts_string . '" crossorigin>';
			$fonts_html .= '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . $fonts_string . '"></noscript>';

			/** remove all google fonts */
			if ( $disable_gfonts ) {
				$fonts_html = '';
			}

			echo substr_replace( $in, $fonts_html . $add_pos, strpos( $in, $add_pos ), strlen( $add_pos ) );

		}

		function preload_font_icon() {

			if ( gulir_get_option( 'preload_font_icon' ) && ! is_admin() ) {
				echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/icons.woff2?ver=2.5.0' ) . '" as="font" type="font/woff2" crossorigin="anonymous"> ';
				if ( gulir_get_option( 'font_awesome' ) ) {
					echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/fa-brands-400.woff2' ) . '" as="font" type="font/woff2" crossorigin="anonymous"> ';
					echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/fa-regular-400.woff2' ) . '" as="font" type="font/woff2" crossorigin="anonymous"> ';
				}
			}
		}

		/**
		 * @return false
		 */
		public function podcast_markup() {

			if ( ! is_singular( 'podcast' ) || ! gulir_get_option( 'single_podcast_markup' ) ) {
				return false;
			}

			$post_id  = get_the_ID();
			$duration = rb_get_meta( 'duration', $post_id );
			$terms    = get_the_terms( $post_id, 'series' );

			$self_hosted_audio_id = rb_get_meta( 'audio_hosted', $post_id );
			if ( ! empty( $self_hosted_audio_id ) ) {
				$attachment_url = wp_get_attachment_url( $self_hosted_audio_id );
			} else {
				$attachment_url = rb_get_meta( 'audio_url', $post_id );
			}

			$json_ld = [
				'@context'        => gulir_protocol() . '://schema.org',
				'@type'           => 'PodcastEpisode',
				'description'     => $this->get_description( $post_id ),
				'name'            => get_the_title( $post_id ),
				'url'             => get_permalink( $post_id ),
				'datePublished'   => get_the_date( DATE_W3C, $post_id ),
				'dateModified'    => get_the_modified_date( DATE_W3C, $post_id ),
				'associatedMedia' => [
					'@type'      => 'MediaObject',
					'contentUrl' => $attachment_url,
				],
			];

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$json_ld['partOfSeries'] = [
						'@type' => 'PodcastSeries',
						'name'  => $term->name,
						'url'   => gulir_get_term_link( $term ),
					];
					break;
				}
			}

			if ( ! empty( $duration ) ) {
				$sec = strtotime( $duration, 0 );
				if ( intval( $sec ) ) {
					$json_ld['timeRequired'] = $this->iso8601_duration( $sec );
				}
			}

			echo '<script type="application/ld+json">';
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				echo wp_json_encode( $json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			} else {
				echo wp_json_encode( $json_ld );
			}
			echo '</script>', "\n";

			return false;
		}

		public function breadcrumb_markup() {

			if ( ! gulir_get_option( 'site_breadcrumb' ) ) {
				return;
			}

			if ( function_exists( 'bcn_display_json_ld' ) ) {
				echo '<script type="application/ld+json">';
				bcn_display_json_ld( false, true, true );
				echo '</script>', "\n";
			}
		}

		function iso8601_duration( $seconds ) {

			$hours   = floor( $seconds / 3600 );
			$seconds = $seconds % 3600;

			$minutes = floor( $seconds / 60 );
			$seconds = $seconds % 60;

			return sprintf( 'PT%dH%dM%dS', $hours, $minutes, $seconds );
		}

		/**
		 * @param $the_date
		 * @param $format
		 * @param $post
		 *
		 * @return false|int|string
		 */
		function force_updated_date( $the_date, $format, $post ) {

			if ( gulir_get_option( 'force_modified_date' ) && ! is_admin() ) {
				return get_the_modified_date( $format, $post );
			} else {
				return $the_date;
			}
		}

		/**
		 * @param $the_time
		 * @param $format
		 * @param $post
		 *
		 * @return false|int|string
		 */
		function force_updated_time( $the_time, $format, $post ) {

			if ( gulir_get_option( 'force_modified_date' ) && ! is_admin() ) {
				return get_the_modified_time( $format, $post );
			} else {
				return $the_time;
			}
		}
	}
}
