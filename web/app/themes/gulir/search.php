<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

get_header();
$gulir_settings = gulir_get_search_page_settings();
gulir_search_page_header( $gulir_settings );
if ( have_posts() ) {
	gulir_the_blog( $gulir_settings );
} else {
	gulir_search_empty();
}
get_footer();