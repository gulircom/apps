<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_file_path' ) ) {
	function gulir_get_file_path( $file = '' ) {

		$file = ltrim( $file, '/' );
		if ( file_exists( GULIR_CHILD_THEME_DIR . $file ) ) {
			return GULIR_CHILD_THEME_DIR . $file;
		} elseif ( file_exists( GULIR_THEME_DIR . $file ) ) {
			return GULIR_THEME_DIR . $file;
		}

		return false;
	}
}

if ( ! function_exists( 'gulir_get_file_uri' ) ) {
	function gulir_get_file_uri( $file = '' ) {

		$file = ltrim( $file, '/' );
		if ( file_exists( GULIR_CHILD_THEME_DIR . $file ) ) {
			return GULIR_CHILD_THEME_URI . $file;
		}

		return GULIR_THEME_URI . $file;
	}
}

if ( ! function_exists( 'gulir_get_option' ) ) {
	/**
	 * @param string $option_name
	 * @param false $default
	 *
	 * @return false|mixed|void
	 */
	function gulir_get_option( $option_name = '', $default = false ) {

		if ( ! isset( $GLOBALS[ GULIR_TOS_ID ] ) ) {
			$GLOBALS[ GULIR_TOS_ID ] = get_option( GULIR_TOS_ID, [] );
		}

		if ( ! $option_name ) {
			return (array) $GLOBALS[ GULIR_TOS_ID ];
		}

		return ! empty( $GLOBALS[ GULIR_TOS_ID ][ $option_name ] ) ? $GLOBALS[ GULIR_TOS_ID ][ $option_name ] : $default;
	}
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/** ensuring backward compatibility with versions of WordPress older than 5.2. */
	function wp_body_open() {

		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'gulir_convert_to_id' ) ) {
	function gulir_convert_to_id( $name ) {

		$name = strtolower( strip_tags( $name ) );
		$name = str_replace( ' ', '-', $name );
		$name = preg_replace( '/[^A-Za-z0-9\-]/', '', $name );

		return substr( $name, 0, 20 );
	}
}
