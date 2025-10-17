<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

get_header();
$gulir_settings = gulir_get_archive_page_settings( 'blog_' );
if ( have_posts() ) {
	gulir_blog_embed_template( $gulir_settings );
	gulir_the_blog( $gulir_settings );
	gulir_blog_embed_template_bottom( $gulir_settings );
} else {
	gulir_blog_empty();
}
get_footer();