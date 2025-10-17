<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

get_header();
$gulir_series_settings = gulir_get_series_settings();
gulir_series_page_header( $gulir_series_settings );
if ( have_posts() ) {
	gulir_podcast_blog( $gulir_series_settings );
} else {
	gulir_blog_empty();
}
get_footer();