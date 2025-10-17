<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_single_footer' ) ) {
	function gulir_single_footer( $override = false ) {

		if ( get_query_var( 'rbsnp' ) || ( gulir_get_option( 'amp_disable_related' ) && gulir_is_amp() ) ) {
			return;
		}

		$post_id           = get_the_ID();
		$popular_shortcode = gulir_get_option( 'single_post_popular_shortcode' );
		$related_shortcode = gulir_get_option( 'single_post_related_shortcode' );
		$related_section   = gulir_get_option( 'single_post_related' );

		if ( $override || $related_section ) {

			$settings = [
					'uuid'       => 'uuid_r' . $post_id,
					'layout'     => gulir_get_option( 'single_post_related_layout' ),
					'pagination' => gulir_get_option( 'single_post_related_pagination' ),
					'unique'     => true,
			];

			/** $_query */
			$_query = gulir_query_related( $settings );

			if ( ! $_query->have_posts() ) {
				return;
			}
			?>
			<div class="<?php echo strip_tags('sfoter-sec' . ( ! $override ? ' single-related' : '')); ?>">
				<?php if ( 'rb_template' === $related_section && ! empty( $related_shortcode ) ) :
					$GLOBALS['ruby_template_query'] = $_query;
					echo do_shortcode( $related_shortcode );
				else :
					/**  standard layout */
					$related_title = gulir_get_option( 'single_post_related_blog_heading' );
					if ( empty( $related_title ) ) {
						$related_title = gulir_html__( 'You Might Also Like', 'gulir' );
					}
					if ( '-1' !== (string) $related_title ) {
						echo gulir_get_heading( [
								'title'    => $related_title,
								'layout'   => gulir_get_option( 'single_post_related_blog_heading_layout' ),
								'html_tag' => gulir_get_option( 'single_post_related_heading_tag' ),
						] );
					}
					echo gulir_get_single_footer_listing( $settings, $_query );
				endif; ?>
			</div>
			<?php
		}
		if ( ! empty( $popular_shortcode ) && is_singular( 'post' ) && ! $override ) : ?>
			<div class="single-popular"><?php echo do_shortcode( $popular_shortcode ); ?></div>
		<?php endif;
	}
}

if ( ! function_exists( 'gulir_get_single_footer_listing' ) ) {
	function gulir_get_single_footer_listing( $settings = [], $_query = null ) {

		if ( empty( $settings['layout'] ) ) {
			return false;
		}

		$settings['excerpt_length'] = 0;
		$settings['excerpt']        = 1;

		switch ( $settings['layout'] ) {
			case 'grid_1' :
				$settings['columns'] = 3;

				return gulir_get_grid_1( $settings, $_query );
			case 'grid_2' :
				$settings['columns'] = 3;

				return gulir_get_grid_2( $settings, $_query );
			case 'grid_box_1' :
				$settings['columns'] = 3;

				return gulir_get_grid_box_1( $settings, $_query );
			case 'grid_box_2' :
				$settings['columns'] = 3;

				return gulir_get_grid_box_2( $settings, $_query );
			default:
				$settings['columns'] = 4;

				return gulir_get_grid_small_1( $settings, $_query );
		}
	}
}
