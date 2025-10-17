<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_blocks' ) ) {
	function gulir_register_options_blocks() {

		return [
			'id'    => 'gulir_config_section_block_design',
			'title' => esc_html__( 'Standard Blog Design', 'gulir' ),
			'icon'  => 'el el-puzzle',
		];
	}
}
