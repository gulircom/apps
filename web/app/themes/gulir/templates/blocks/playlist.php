<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_get_playlist' ) ) {
	function gulir_get_playlist( $settings = [] ) {

		$settings = apply_filters( 'gulir_playlist_thumbnails',
			wp_parse_args( $settings, [
				'uuid'   => '',
				'name'   => 'playlist',
				'videos' => [],
			] )
		);

		if ( empty( $settings['videos'] ) && ! is_array( $settings['videos'] ) && ! class_exists( 'Gulir_Video_Thumb' ) ) {
			return false;
		}

		$settings['classes'] = 'block-playlist light-scheme is-gap-none';

		foreach ( $settings['videos'] as $key => $item ) {
			if ( empty( $item['url'] ) ) {
				unset( $settings['videos'][ $key ] );
			} else {
				$settings['videos'][ $key ]['video_id'] = Gulir_Video_Thumb::get_instance()->get_video_yt_id( $item['url'] );
			}
		}

		$index = 1;
		$total = count( $settings['videos'] );

		ob_start();
		gulir_block_open_tag( $settings );
		?>
		<div class="block-inner yt-playlist" data-block="<?php echo strip_tags( $settings['uuid'] ); ?>" data-id="<?php echo strip_tags( $settings['videos'][0]['video_id'] ); ?>">
			<div class="yt-embed">
				<div class="iframe-holder">
					<div class="yt-player"></div>
				</div>
			</div>
			<div class="plist-items">
				<div class="plist-items-inner">
					<div class="play-panel">
						<div class="play-content">
							<div class="play-index meta-text">
								<span><?php gulir_html_e( 'Now Playing', 'gulir' ); ?></span>
								<span class="index-info"><span class="video-index">1</span><?php gulir_render_inline_html( '/' . $total ); ?></span>
							</div>
							<?php if ( ! empty( $settings['videos'][0]['title'] ) ) : ?>
								<span class="h4 play-title"><?php gulir_render_inline_html( $settings['videos'][0]['title'] ); ?></span>
							<?php endif; ?>
						</div>
						<a class="yt-trigger" href="#" role="button"><span class="yt-trigger-icons"><?php gulir_render_svg( 'play' ); gulir_render_svg( 'pause' ); ?></span></a>
					</div>
					<div class="plist-holder scroll-holder">
						<?php foreach ( $settings['videos'] as $item ) : ?>
							<a class="plist-item" href="#" role="button" data-id="<?php gulir_render_inline_html( $item['video_id'] ); ?>" data-index="<?php echo strip_tags( $index ); ?>">
								<img class="plist-item-thumb" src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo strip_tags( $item['title'] ); ?>"/>
								<div class="plist-item-content">
									<?php if ( ! empty( $item['title'] ) ) : ?>
										<span class="h4 plist-item-title"><?php gulir_render_inline_html( $item['title'] ); ?></span>
									<?php endif;
									if ( ! empty( $item['meta'] ) ) : ?>
										<span class="plist-meta is-meta"><?php gulir_render_inline_html( $item['meta'] ); ?></span>
									<?php endif; ?>
								</div>
							</a>
							<?php $index ++;
						endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		gulir_block_close_tag();

		return ob_get_clean();
	}
}