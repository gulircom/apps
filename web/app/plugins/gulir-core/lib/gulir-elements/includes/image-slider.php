<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_block_image_slider' ) ) {
	function gulir_render_block_image_slider( $attributes, $content ) {

		if ( function_exists( 'gulir_is_amp' ) && gulir_is_amp() ) {
			return $content;
		}

		$ratio    = $attributes['ratio'] ?? '60';
		$autoplay = ! empty( $attributes['autoplay'] );

		$output = '<div class="gb-image-slider" style="--slider-ratio:' . $ratio . ';' . ( ! empty( $attributes['borderRadius'] ) ? ' --round-3:' . absint($attributes['borderRadius']) . 'px;' : '' ) . '">';
		$output .= '<div class="gb-slider-scrollbar pre-load" data-autoplay="' . ( $autoplay ? 1 : '' ) . '">';
		$output .= '<div class="swiper-wrapper">';
		$output .= $content;
		$output .= '</div>';
		$output .= '<div class="swiper-scrollbar"></div>';
		$output .= '</div>';
		$output .= '<div class="gb-image-caption meta-text"></div>';
		$output .= '</div>';

		return $output;
	}
}
