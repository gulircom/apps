<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

get_header();
$gulir_settings = gulir_get_tag_page_settings();
gulir_archive_page_header( $gulir_settings );
if ( have_posts() ) {
	gulir_blog_embed_template( $gulir_settings );
	gulir_the_blog( $gulir_settings );
} else {
	gulir_blog_empty();
}
get_footer();