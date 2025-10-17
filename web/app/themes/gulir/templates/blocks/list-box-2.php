<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_list_box_2' ) ) {
	/**
	 * @param array $settings
	 * @param null  $_query
	 *
	 * @return false|string
	 */
	function gulir_get_list_box_2( $settings = [], $_query = null ) {

		$settings = wp_parse_args( $settings, [
			'uuid' => '',
			'name' => 'list_box_2',
		] );

		$settings = gulir_detect_dynamic_query( $settings );

		if ( empty( $settings['pagination'] ) ) {
			$settings['no_found_rows'] = true;
		}

		$settings['classes'] = 'block-big block-list block-list-box-2';
		$min_posts           = 1;

		if ( ! $_query ) {
			$_query = gulir_query( $settings );
		}

		$settings = gulir_get_design_standard_block( $settings, 'list_box_2' );

		ob_start();
		gulir_block_open_tag( $settings, $_query );
		if ( ! $_query->have_posts() || $_query->post_count < $min_posts ) {
			gulir_error_posts( $_query, $min_posts );
		} else {
			gulir_block_inner_open_tag( $settings );
			gulir_loop_list_box_2( $settings, $_query );
			gulir_block_inner_close_tag( $settings );
			gulir_render_pagination( $settings, $_query );
			wp_reset_postdata();
		}
		gulir_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_loop_list_box_2' ) ) {
	/**
	 * @param  $settings
	 * @param  $_query
	 */
	function gulir_loop_list_box_2( $settings, $_query ) {

		$loop_index = 1;
		while ( $_query->have_posts() ) :
			$_query->the_post();
			if ( ! empty( $settings['eager_images'] ) ) {
				$settings['feat_lazyload'] = ( $loop_index <= $settings['eager_images'] ) ? 'none' : '1';
				$loop_index ++;
			}
			gulir_list_box_2( $settings );
		endwhile;
	}
}