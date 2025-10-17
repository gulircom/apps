<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_classic_1' ) ) {
	/**
	 * @param array $settings
	 * @param null  $_query
	 *
	 * @return false|string
	 */
	function gulir_get_classic_1( $settings = [], $_query = null ) {

		$settings = wp_parse_args( $settings, [
			'uuid' => '',
			'name' => 'classic_1',
		] );

		$settings = gulir_detect_dynamic_query( $settings );

		if ( empty( $settings['pagination'] ) ) {
			$settings['no_found_rows'] = true;
		}

		$settings['classes'] = 'block-big block-classic block-classic-1';

		if ( ! $_query ) {
			$_query = gulir_query( $settings );
		}

		$settings = gulir_get_design_standard_block( $settings, 'classic_1' );

		ob_start();
		gulir_block_open_tag( $settings, $_query );
		if ( ! $_query->have_posts() ) {
			gulir_error_posts( $_query );
		} else {
			gulir_block_inner_open_tag( $settings );
			gulir_loop_classic_1( $settings, $_query );
			gulir_block_inner_close_tag( $settings );
			gulir_render_pagination( $settings, $_query );
			wp_reset_postdata();
		}
		gulir_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_loop_classic_1' ) ) {
	/**
	 * @param  $settings
	 * @param  $_query
	 */
	function gulir_loop_classic_1( $settings, $_query ) {

		$loop_index = 1;
		while ( $_query->have_posts() ) :
			$_query->the_post();
			if ( ! empty( $settings['eager_images'] ) ) {
				$settings['feat_lazyload'] = ( $loop_index <= $settings['eager_images'] ) ? 'none' : '1';
				$loop_index ++;
			}
			gulir_classic_1( $settings );
		endwhile;
	}
}