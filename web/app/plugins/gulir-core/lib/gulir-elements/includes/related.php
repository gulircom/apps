<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_block_related' ) ) {
	function gulir_render_block_related( $attributes ) {

		$attributes['layout']         = $attributes['layout'] ?? 1;
		$attributes['total']          = $attributes['total'] ?? 4;
		$attributes['heading_tag']    = $attributes['heading_tag'] ?? 'h4';
		$attributes['heading_layout'] = $attributes['heading_layout'] ?? '';
		$attributes['ids']            = isset( $attributes['ids'] ) ? trim( $attributes['ids'] ) : '';
		$attributes['where']          = $attributes['where'] ?? 'all';
		$attributes['width']          = $attributes['width'] ?? 'wide';
		$attributes['order']          = $attributes['order'] ?? 'rand';
		$attributes['style']          = $attributes['style'] ?? 'default';

		return do_shortcode(
			sprintf(
				'[ruby_related heading_tag="%s" heading="%s" heading_layout="%s" total="%d" ids="%s" layout="%d" order="%s" where="%s" width="%s" style="%s"]',
				$attributes['heading_tag'],
				esc_html( $attributes['heading'] ?? '' ),
				$attributes['heading_layout'],
				$attributes['total'],
				$attributes['ids'],
				$attributes['layout'],
				$attributes['order'],
				$attributes['where'],
				$attributes['width'],
				$attributes['style'],
			)
		);
	}
}
