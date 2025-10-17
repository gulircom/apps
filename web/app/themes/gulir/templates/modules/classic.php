<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_classic_1' ) ) {
	/**
	 * @param $settings
	 */
	function gulir_classic_1( $settings = [] ) {

		$settings['post_classes']  = 'p-grid p-classic-1 p-grid-1';
		$settings['title_classes'] = 'h1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h2';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_o1';
		}

		gulir_post_open_tag( $settings );
		gulir_featured_with_category( $settings );
		gulir_entry_title( $settings );
		gulir_entry_review( $settings );
		gulir_entry_excerpt( $settings );
		gulir_entry_meta( $settings );
		gulir_entry_readmore( $settings );
		gulir_post_close_tag();
	}
}
