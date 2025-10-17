<?php
/**
 * Sidebar
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! is_shop() && ! is_product_category() ) {
	return;
}

if ( is_shop() ) {
	$gulir_wc_sidebar_position = gulir_get_option( 'wc_shop_sidebar_position' );
	$gulir_wc_sidebar_name     = gulir_get_option( 'wc_shop_sidebar_name' );
} else {
	$gulir_wc_sidebar_position = gulir_get_option( 'wc_archive_sidebar_position' );
	$gulir_wc_sidebar_name     = gulir_get_option( 'wc_archive_sidebar_name' );
}

if ( empty( $gulir_wc_sidebar_position ) || 'none' === $gulir_wc_sidebar_position ) {
	return;
}

if ( empty( $gulir_wc_sidebar_name ) ) {
	$gulir_wc_sidebar_name = 'gulir_sidebar_default';
}

gulir_single_sidebar( $gulir_wc_sidebar_name );