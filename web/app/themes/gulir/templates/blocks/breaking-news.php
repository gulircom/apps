<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_breaking_news' ) ) {
	/**
	 * @param array $settings
	 * @param null  $_query
	 *
	 * @return false|string
	 */
	function gulir_get_breaking_news( $settings = [], $_query = null ) {

		/** remove on amp */
		if ( gulir_is_amp() ) {
			return false;
		}

		$settings = wp_parse_args( $settings, [
			'uuid' => '',
			'name' => 'breaking_news',
		] );

		if ( empty( $settings['slider_play'] ) ) {
			$settings['slider_play'] = gulir_get_option( 'slider_play' );
		} elseif ( '-1' === (string) $settings['slider_play'] ) {
			$settings['slider_play'] = false;
		}
		if ( empty( $settings['slider_speed'] ) ) {
			$settings['slider_speed'] = gulir_get_option( 'slider_speed' );
		}
		$settings['classes'] = 'block-breaking-news';

		$settings = gulir_detect_dynamic_query( $settings );

		$settings['no_found_rows'] = true;
		$min_posts                 = 1;

		if ( ! $_query ) {
			$_query = gulir_query( $settings );
		}

		ob_start();
		gulir_block_open_tag( $settings, $_query );

		if ( ! $_query->have_posts() || $_query->post_count < $min_posts ) {
			gulir_error_posts( $_query, $min_posts );
		} else {
			gulir_loop_breaking_news( $settings, $_query );
			wp_reset_postdata();
		}
		gulir_block_close_tag();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_loop_breaking_news' ) ) {
	/**
	 * @param $settings
	 * @param $_query
	 */
	function gulir_loop_breaking_news( $settings, $_query ) {

		if ( $_query->have_posts() ) : ?>
			<?php if ( ! empty( $settings['heading'] ) ) : ?>
				<span class="breaking-news-heading"><i class="rbi rbi-fire"></i><span><?php echo esc_html( $settings['heading'] ); ?></span></span>
			<?php endif; ?>
			<div class="breaking-news-slider swiper-container pre-load" <?php gulir_slider_attrs( $settings ); ?>>
				<div class="swiper-wrapper">
					<?php while ( $_query->have_posts() ) {
						$_query->the_post();
						echo '<div class="swiper-slide">';
						gulir_entry_title( [
							'title_tag'     => 'h6',
							'title_classes' => 'breaking-news-title',
						] );
						echo '</div>';
					} ?>
				</div>
				<div class="breaking-news-nav">
					<div class="breaking-news-prev rbi rbi-prev"></div>
					<div class="breaking-news-next rbi rbi-next"></div>
				</div>
			</div>
		<?php
		endif;
	}
}


