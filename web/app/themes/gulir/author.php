<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

get_header();
$gulir_settings = gulir_get_author_page_settings();
gulir_author_page_header( $gulir_settings );
if ( have_posts() ) {
	gulir_the_blog( $gulir_settings );
} else {
	gulir_blog_empty();
}
get_footer();