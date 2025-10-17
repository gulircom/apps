<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_list_personalize' ) ) {
	/**
	 * @param array $settings
	 * @param null $_query
	 *
	 * @return false|string
	 */
	function gulir_get_list_personalize( $settings = [], $_query = null ) {

		if ( gulir_is_amp() ) {
			return false;
		}

		$settings = wp_parse_args( $settings, [
			'uuid' => '',
			'name' => 'list_personalize',
		] );

		$settings['classes'] = 'block-list block-list-personalize';

		if ( empty( $settings['display_mode'] ) ) {
			$settings['classes'] .= ' is-ajax-block';
		}

		if ( empty( $settings['content_source'] ) ) {
			$settings['content_source'] = 'recommended';
		}

		if ( empty( $settings['columns'] ) ) {
			$settings['columns'] = 1;
		}

		if ( empty( $settings['column_gap'] ) ) {
			$settings['column_gap'] = 20;
		}

		if ( empty( $settings['pagination'] ) ) {
			$settings['no_found_rows'] = true;
		}

		$settings = gulir_get_design_builder_block( $settings );

		$is_recommended = ! empty( $settings['content_source'] ) && 'recommended' === $settings['content_source'];
		if ( $is_recommended && ! empty( $GLOBALS['gulir_queried_ids'] ) && is_array( $GLOBALS['gulir_queried_ids'] ) ) {
			$settings['post_not_in'] = implode( ',', $GLOBALS['gulir_queried_ids'] );
		}

		/** ajax mode */
		if ( empty( $settings['display_mode'] ) ) {
			$settings['live_block'] = 1;
			gulir_live_block_localize( $settings );
		}

		ob_start();
		gulir_block_open_tag( $settings, $_query );
		if ( gulir_is_edit_mode() ) {
			gulir_live_block_list_personalize( $settings );
		} else {
			if ( empty( $settings['display_mode'] ) ) {
				echo '<div class="block-loader">' . gulir_get_svg( 'loading', '', 'animation' ) . '</div>';
			} else {
				gulir_live_block_list_personalize( $settings );
			}
		}
		gulir_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_loop_list_personalize' ) ) {
	/**
	 * @param  $settings
	 * @param  $_query
	 */
	function gulir_loop_list_personalize( $settings, $_query ) {

		$loop_index = 1;
		if ( empty( $settings['block_structure'] ) ) {
			$settings['block_structure'] = [ 'title', 'excerpt', 'meta' ];
		} else {
			$settings['block_structure'] = explode( ',', preg_replace( '/\s+/', '', (string) $settings['block_structure'] ) );
		}
		while ( $_query->have_posts() ) :
			$_query->the_post();

			if ( ! empty( $settings['eager_images'] ) ) {
				$settings['feat_lazyload'] = ( $loop_index <= $settings['eager_images'] ) ? 'none' : '1';
				$loop_index ++;
			}
			gulir_list_flex( $settings );
		endwhile;
	}
}

if ( ! function_exists( 'gulir_live_block_list_personalize' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function gulir_live_block_list_personalize( $settings = [] ) {

		if ( ! is_user_logged_in() && 'saved' == $settings['content_source'] && ! empty( gulir_get_option( 'bookmark_enable_when' ) ) ) {
			gulir_saved_restrict_info();

			return false;
		}

		$_query = gulir_personalize_query( $settings );

		if ( empty( $_query ) || ! $_query->have_posts() ) {
			if ( ! empty( $settings['content_source'] ) ) {
				if ( 'saved' == $settings['content_source'] ) {
					gulir_saved_empty();
				} elseif ( 'history' === $settings['content_source'] ) {
					gulir_reading_history_empty();
				}
			} else {
				gulir_error_posts( $_query );
			}
		} else {
			gulir_block_inner_open_tag( $settings );
			gulir_loop_list_personalize( $settings, $_query );
			gulir_block_inner_close_tag( $settings );
			gulir_render_pagination( $settings, $_query );
			wp_reset_postdata();
		}
	}
}
