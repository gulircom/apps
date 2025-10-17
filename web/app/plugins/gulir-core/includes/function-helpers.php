<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_pretty_number' ) ) {
	function gulir_pretty_number( $number ) {

		$number = intval( $number );
		if ( $number > 999999 ) {
			$number = str_replace( '.00', '', number_format( ( $number / 1000000 ), 2 ) ) . gulir_attr__( 'M', 'gulir-core' );
		} elseif ( $number > 999 ) {
			$number = str_replace( '.0', '', number_format( ( $number / 1000 ), 1 ) ) . gulir_attr__( 'k', 'gulir-core' );
		}

		return $number;
	}
}

if ( ! function_exists( 'gulir_is_ruby_template' ) ) {
	function gulir_is_ruby_template() {

		static $is_template;

		if ( isset( $is_template ) ) {
			return $is_template;
		}

		$is_template = ( get_post_type() === 'rb-etemplate' || ! is_admin() );

		return $is_template;
	}
}


if ( ! function_exists( 'gulir_extract_number' ) ) {
	function gulir_extract_number( $str ) {

		return intval( preg_replace( '/[^0-9]+/', '', $str ), 10 );
	}
}

/**
 * Translate and escape HTML text using custom translation data.
 *
 * This function checks for a translated string in the custom option
 * 'rb_translated_data'. If not found, it falls back to WordPress's esc_html__().
 *
 * @param string $text The text to translate.
 * @param string $domain The text domain. Default 'gulir-core'.
 *
 * @return string Translated and escaped string.
 */
if ( ! function_exists( 'gulir_html__' ) ) {
	function gulir_html__( $text, $domain = 'gulir-core' ) {

		if ( ! isset( $GLOBALS['gulir_translated_data'] ) ) {
			$GLOBALS['gulir_translated_data'] = get_option( 'rb_translated_data', [] );
		}

		$id = gulir_convert_to_id( $text );

		if ( ! empty( $GLOBALS['gulir_translated_data'][ $id ] ) ) {
			return $GLOBALS['gulir_translated_data'][ $id ];
		}

		return esc_html__( $text, $domain );
	}
}

/**
 * Translate and escape attribute text using custom translation data.
 *
 * Similar to gulir_html__(), but uses esc_attr__() to escape for attributes.
 *
 * @param string $text The text to translate.
 * @param string $domain The text domain. Default 'gulir-core'.
 *
 * @return string Translated and escaped attribute-safe string.
 */
if ( ! function_exists( 'gulir_attr__' ) ) {
	function gulir_attr__( $text, $domain = 'gulir-core' ) {

		if ( ! isset( $GLOBALS['gulir_translated_data'] ) ) {
			$GLOBALS['gulir_translated_data'] = get_option( 'rb_translated_data', [] );
		}

		$id = gulir_convert_to_id( $text );
		if ( ! empty( $GLOBALS['gulir_translated_data'][ $id ] ) ) {
			return $GLOBALS['gulir_translated_data'][ $id ];
		}

		return esc_attr__( $text, $domain );
	}
}

if ( ! function_exists( 'gulir_html_e' ) ) {
	function gulir_html_e( $text, $domain = 'gulir-core' ) {

		echo gulir_html__( $text, $domain );
	}
}

if ( ! function_exists( 'gulir_attr_e' ) ) {
	function gulir_attr_e( $text, $domain = 'gulir-core' ) {

		echo gulir_attr__( $text, $domain );
	}
}

if ( ! function_exists( 'gulir_page_selection' ) ) {
	function gulir_page_selection() {

		$data                   = [];
		$args['posts_per_page'] = - 1;
		$pages                  = get_pages( $args );

		if ( ! empty ( $pages ) ) {
			foreach ( $pages as $page ) {
				$data[ $page->ID ] = $page->post_title;
			}
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_is_svg' ) ) {
	function gulir_is_svg( $attachment = '' ) {

		return substr( strtolower( $attachment ), - 4 ) === '.svg';
	}
}

if ( ! function_exists( 'gulir_calc_average_rating' ) ) {
	function gulir_calc_average_rating( $post_id ) {

		global $wpdb;

		$data         = [];
		$total_review = [];
		$raw_total    = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rbrating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
			AND meta_value > 0
			GROUP BY meta_value",
				$post_id
			)
		);

		foreach ( $raw_total as $count ) {
			$total_review[] = absint( $count->meta_value_count );
		}

		$data['count'] = array_sum( $total_review );

		$ratings = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rbrating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0",
				$post_id
			)
		);

		if ( ! empty( $data['count'] ) && ! empty( $ratings ) ) {
			$data['average'] = number_format( $ratings / $data['count'], 1, '.', '' );
		}

		update_post_meta( $post_id, 'gulir_user_rating', $data );

		return false;
	}
}

if ( ! function_exists( 'gulir_get_image_size' ) ) {
	function gulir_get_image_size( $filename ) {

		if ( is_string( $filename ) ) {
			return @getimagesize( $filename ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}

		return [];
	}
}

if ( ! function_exists( 'gulir_get_theme_mode' ) ) {
	function gulir_get_theme_mode() {

		$dark_mode = gulir_get_option( 'dark_mode' );

		if ( empty( $dark_mode ) || 'browser' === $dark_mode ) {
			return 'default';
		} elseif ( 'dark' === $dark_mode ) {
			return 'dark';
		}

		$is_cookie_mode = (string) gulir_get_option( 'dark_mode_cookie' );
		if ( '1' === $is_cookie_mode ) {
			$id = GULIR_CORE::get_instance()->get_dark_mode_id();
			if ( ! empty( $_COOKIE[ $id ] ) ) {
				return $_COOKIE[ $id ];
			}
		}

		$first_visit_mode = gulir_get_option( 'first_visit_mode' );
		if ( empty( $first_visit_mode ) ) {
			$first_visit_mode = 'default';
		}

		return $first_visit_mode;
	}
}

if ( ! function_exists( 'gulir_conflict_schema' ) ) {
	function gulir_conflict_schema() {

		$schema_conflicting_plugins = [
			'seo-by-rank-math/rank-math.php',
			'all-in-one-seo-pack/all_in_one_seo_pack.php',
		];

		$active_plugins = gulir_get_active_plugins();

		if ( ! empty( $active_plugins ) ) {
			foreach ( $schema_conflicting_plugins as $plugin ) {
				if ( in_array( $plugin, $active_plugins, true ) ) {
					return true;
				}
			}
		}

		return false;
	}
}

if ( ! function_exists( 'gulir_ajax_localize_script' ) ) {
	function gulir_ajax_localize_script( $id, $js_settings ) {

		if ( empty( $id ) ) {
			return false;
		}

		if ( ! empty( $js_settings['live_block'] ) ) {
			if ( ! empty( $js_settings['paged'] ) ) {
				$js_settings['paged'] = 0;
			}
			if ( empty( $js_settings['page_max'] ) ) {
				$js_settings['page_max'] = 2;
			}
			$output = '<script>';
			$output .= esc_attr( $id ) . '.paged = ' . $js_settings['paged'] . ';';
			$output .= esc_attr( $id ) . '.page_max = ' . $js_settings['page_max'] . ';';
			$output .= '</script>';
			echo $output;
		} else {
			echo '<script> var ' . esc_attr( $id ) . ' = ' . wp_json_encode( $js_settings ) . '</script>';
		}
	}
}

if ( ! function_exists( 'gulir_wc_strip_wrapper' ) ) {
	function gulir_wc_strip_wrapper( $html ) {

		if ( empty( $html ) || ! class_exists( 'DOMDocument', false ) ) {
			return false;
		}

		$output = '';
		libxml_use_internal_errors( true );
		$dom = new DOMDocument();
		@$dom->loadHTML( '<?xml encoding="' . get_bloginfo( 'charset' ) . '" ?>' . $html );
		libxml_clear_errors();
		$xpath = new DomXPath( $dom );
		$nodes = $xpath->query( "//*[contains(@class, 'products ')]" );
		if ( $nodes->item( 0 ) ) {
			foreach ( $nodes->item( 0 )->childNodes as $node ) {
				$output .= $dom->saveHTML( $node );
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'gulir_get_term_link' ) ) {
	function gulir_get_term_link( $term, $taxonomy = '' ) {

		if ( ! is_object( $term ) ) {
			$term = (int) $term;
		}

		$link = get_term_link( $term, $taxonomy );
		if ( empty( $link ) || is_wp_error( $link ) ) {
			return '#';
		}

		return $link;
	}
}

if ( ! function_exists( 'gulir_amp_suppressed_elementor' ) ) {
	function gulir_amp_suppressed_elementor() {

		if ( gulir_is_amp() ) {
			$amp_options        = get_option( 'amp-options' );
			$suppressed_plugins = ( ! empty( $amp_options['suppressed_plugins'] ) && is_array( $amp_options['suppressed_plugins'] ) ) ? $amp_options['suppressed_plugins'] : [];
			if ( ! empty( $suppressed_plugins['elementor'] ) ) {
				return true;
			}
		}

		return false;
	}
}


if ( ! function_exists( 'gulir_get_twitter_name' ) ) {
	function gulir_get_twitter_name() {

		if ( is_single() ) {
			global $post;
			$name = get_the_author_meta( 'twitter_url', $post->post_author );
		}

		if ( empty( $name ) ) {
			$name = gulir_get_option( 'twitter' );
		}

		if ( empty( $name ) ) {
			$name = get_bloginfo( 'name' );
		}

		// Ensure the name is a valid URL before parsing
		if ( ! filter_var( $name, FILTER_VALIDATE_URL ) ) {
			$name = 'https://' . ltrim( $name, '/' ); // Add scheme if missing
		}

		$name = parse_url( $name, PHP_URL_PATH );

		return str_replace( '/', '', (string) $name );
	}
}

if ( ! function_exists( 'gulir_get_current_permalink' ) ) {
	function gulir_get_current_permalink() {

		if ( isset( $_SERVER ) && is_array( $_SERVER ) ) {
			$scheme = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
			$host   = ! empty( $_SERVER['HTTP_HOST'] ) ? wp_unslash( $_SERVER['HTTP_HOST'] ) : null;
			$path   = ! empty( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';

			if ( $host ) {
				return esc_url_raw( sprintf( '%s://%s%s', $scheme, $host, $path ) );
			}
		}

		global $wp;

		return home_url( add_query_arg( [], $wp->request ) );
	}
}

if ( ! function_exists( 'gulir_count_content' ) ) {
	function gulir_count_content( $content = '' ) {

		if ( empty( $content ) ) {
			return '-1';
		}

		// Separate HTML tags with spaces to prevent them from being concatenated
		$content = preg_replace( '/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2', $content );

		// Convert newlines to <br> tags to handle line breaks
		$content = nl2br( $content );

		// Strip all HTML tags from the content
		$content = strip_tags( $content );

		if ( preg_match( "/[\x{4e00}-\x{9fa5}]+/u", $content ) ) {
			// Chinese characters
			$count = mb_strlen( $content, get_bloginfo( 'charset' ) );
		} elseif ( preg_match( "/[А-Яа-яЁё]/u", $content ) ) {
			// Cyrillic characters
			$count = count( preg_split( '~[^\p{L}\p{N}\']+~u', $content ) );
		} elseif ( preg_match( "/[\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7A3}]+/u", $content ) ) {
			// Korean characters
			$count = count( preg_split( '/[^\p{L}\p{N}\']+/', $content ) );
		} elseif ( preg_match( "/[\x{3040}-\x{309F}\x{30A0}-\x{30FF}]+/u", $content ) ) {
			// Japanese characters
			$count = count( preg_split( '/[^\p{L}\p{N}\']+/', $content ) );
		} else {
			// Default to word count for other languages
			$count = count( preg_split( '/\s+/', $content ) );
		}

		if ( empty( $count ) ) {
			$count = '-1';
		}

		return $count;
	}
}

/**
 * Retrieves the list of locally uploaded fonts.
 *
 * This function checks if the Local Fonts Uploader plugin is available and then
 * queries the database to fetch the list of uploaded fonts.
 *
 * @return array List of local font names, or an empty array if none are found.
 */
if ( ! function_exists( 'gulir_get_local_fonts' ) ) {
	function gulir_get_local_fonts() {

		// Ensure the Local Fonts Uploader plugin is available
		if ( ! defined( 'LOCAL_FONTS_UPLOADER_VERSION' ) ) {
			return [];
		}

		global $wpdb;

		$table_name = $wpdb->prefix . 'lfontsup_fonts';

		if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) === null ) {
			return [];
		}

		// Query the database to retrieve all uploaded fonts
		$results = $wpdb->get_results( "SELECT * FROM {$table_name}", ARRAY_A );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

		// Extract font names if available
		if ( ! empty( $results ) && is_array( $results ) ) {
			return array_column( $results, 'name' );
		}

		return [];
	}
}