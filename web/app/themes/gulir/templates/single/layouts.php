<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_single_post' ) ) {
	function gulir_single_post() {

		if ( ! isset( $GLOBALS['gulir_queried_ids'] ) ) {
			$GLOBALS['gulir_queried_ids'] = [];
		}
		array_push( $GLOBALS['gulir_queried_ids'], get_the_ID() );

		if ( 'attachment' === get_post_type() ) {
			gulir_render_single_attachment();

			return;
		}

		/** only for default pos type */
		if ( is_singular( 'post' ) ) {
			if ( ! empty( gulir_get_option( 'ajax_next_cat' ) ) ) {
				$post_prev = get_previous_post( true );
			} else {
				$post_prev = get_previous_post();
			}
		}

		if ( ( ( gulir_get_single_setting( 'ajax_next_post' ) && ! empty( $post_prev ) ) || get_query_var( 'rbsnp' ) ) && ! gulir_is_amp() ) :
			$class_name = 'single-post-infinite';
			if ( ! empty( gulir_get_option( 'ajax_next_hide_sidebar' ) ) ) {
				$class_name .= ' none-mobile-sb';
			} ?>
			<div id="single-post-infinite" class="<?php echo strip_tags( $class_name ); ?>" data-nextposturl="<?php echo esc_url( get_permalink( $post_prev ) ); ?>">
				<div class="single-post-outer activated" data-postid="<?php echo get_the_ID(); ?>" data-postlink="<?php echo esc_url( get_permalink() ); ?>">
					<?php gulir_render_single_post(); ?>
				</div>
			</div>
			<div id="single-infinite-point" class="single-infinite-point pagination-wrap">
				<i class="rb-loader" aria-hidden="true"></i>
			</div>
		<?php else :
			gulir_render_single_post();
		endif;
	}
}

if ( ! function_exists( 'gulir_render_single_post' ) ) {
	function gulir_render_single_post() {

		$layout = gulir_get_single_layout();

		if ( 'stemplate' !== $layout['layout'] ) {
			$func = 'gulir_render_single_' . $layout['layout'];
			if ( function_exists( $func ) ) {
				call_user_func( $func );
			}
		} else {
			gulir_single_open_tag();
			echo do_shortcode( $layout['shortcode'] );
			if ( isset( $GLOBALS['gulir_rbsnp'] ) && $GLOBALS['gulir_rbsnp'] ) {
				do_action( 'gulir_elementor_single_style', $layout['shortcode'] );
			}
			gulir_single_close_tag();
		}
	}
}