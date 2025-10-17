<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_hierarchical_2' ) ) {
	/**
	 * @param $settings
	 *
	 * @return false|string
	 */
	function gulir_get_hierarchical_2( $settings ) {

		$settings = wp_parse_args( $settings, [
			'uuid' => '',
			'name' => 'hierarchical_2',
		] );

		$settings = gulir_detect_dynamic_query( $settings );

		$settings['classes'] = 'block-hrc hrc-2';

		if ( empty( $settings['pagination'] ) ) {
			$settings['no_found_rows'] = true;
		} else {
			$settings['classes'] .= ' short-pagination';
		}

		$min_posts = 2;
		$_query    = gulir_query( $settings );

		$settings = gulir_get_design_builder_block( $settings );
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}

		if ( empty( $settings['sub_title_tag'] ) ) {
			$settings['sub_title_tag'] = 'h5';
		}

		ob_start();
		gulir_block_open_tag( $settings, $_query );
		if ( ! $_query->have_posts() || $_query->post_count < $min_posts ) {
			gulir_error_posts( $_query, $min_posts );
		} else {
			gulir_block_inner_open_tag( $settings );
			gulir_loop_hierarchical_2( $settings, $_query );
			gulir_block_inner_close_tag( $settings );
			gulir_render_pagination( $settings, $_query );
			wp_reset_postdata();
		}
		gulir_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_loop_hierarchical_2' ) ) {
	/**
	 * @param  $settings
	 * @param  $_query
	 */
	function gulir_loop_hierarchical_2( $settings, $_query ) {

		$flag = true;
		while ( $_query->have_posts() ) :
			$_query->the_post();
			if ( $flag ) {
				gulir_list_small_1( $settings );
				$settings['title_tag'] = ! empty( $settings['sub_title_tag'] ) ? $settings['sub_title_tag'] : 'h5';
				$flag                  = false;
			} else {
				gulir_list_inline( $settings );
			}
		endwhile;
	}
}
