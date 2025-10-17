<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

get_header();
$gulir_settings = gulir_get_category_page_settings();
gulir_category_page_header( $gulir_settings );
if ( have_posts() ) {
	gulir_blog_embed_template( $gulir_settings );
	gulir_the_blog( $gulir_settings );
} else {
	gulir_blog_empty();
}
get_footer();