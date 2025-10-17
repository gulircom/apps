<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_podcast_render_single' ) ) {
	function gulir_podcast_render_single() {

		$layout = gulir_get_single_setting( 'layout', 'single_podcast_layout' );
		switch ( $layout ) {
			case '2' :
				gulir_podcast_render_single_2();
				break;
			default:
				gulir_podcast_render_single_1();
		}
	}
}

if ( ! function_exists( 'gulir_podcast_render_single_1' ) ) {
	function gulir_podcast_render_single_1() {

		$classes          = [ 'single-podcast-1' ];
		$sidebar_name     = gulir_get_single_setting( 'sidebar_name', 'single_podcast_sidebar_name' );
		$sidebar_position = gulir_get_single_sidebar_position( 'sidebar_position', 'single_podcast_sidebar_position' );
		$autoplay         = boolval( gulir_get_single_setting( 'audio_autoplay', 'single_podcast_audio_autoplay' ) );
		$crop_size        = 'gulir_crop_o1';

		if ( 'none' === $sidebar_position ) {
			$sidebar_name = false;
		}
		if ( empty( $sidebar_name ) || ! is_active_sidebar( $sidebar_name ) ) {
			$classes[] = 'without-sidebar';
		} else {
			$classes[] = 'is-sidebar-' . $sidebar_position;
			$classes[] = gulir_get_single_sticky_sidebar( 'single_podcast' );
		} ?>
		<div class="<?php echo join( ' ', $classes ); ?>">
			<div <?php post_class(); ?>>
				<div class="podcast-header-1">
					<div class="rb-container edge-padding">
						<div class="single-header-columns">
							<div class="podcast-header-left">
								<?php
								gulir_single_breadcrumb( 'single_podcast' );
								gulir_single_entry_category( 'single_podcast' );
								gulir_single_title();
								gulir_single_tagline();
								?>
								<div class="podcast-embed-1">
									<?php
									echo gulir_get_audio_embed( get_the_ID(), $autoplay );
									gulir_podcast_socials();
									?>
								</div>
								<?php gulir_single_header_meta( 'single_podcast' ); ?>
							</div>
							<div class="podcast-header-right">
								<div class="podcast-feat-holder">
									<?php gulir_single_featured_image( $crop_size, [ 'class' => 'featured-img' ] ); ?>
								</div>
								<?php gulir_single_featured_caption(); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="rb-container edge-padding">
					<div class="grid-container">
						<div class="s-ct">
							<?php
							gulir_single_content();
							gulir_single_author_box();
							gulir_single_next_prev();
							gulir_single_comment();
							?>
						</div>
						<?php gulir_single_sidebar( $sidebar_name ); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="single-footer rb-container edge-padding">
			<?php gulir_single_footer(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_podcast_render_single_2' ) ) {
	function gulir_podcast_render_single_2() {

		$classes          = [ 'single-podcast-2' ];
		$sidebar_name     = gulir_get_single_setting( 'sidebar_name', 'single_podcast_sidebar_name' );
		$sidebar_position = gulir_get_single_sidebar_position( 'sidebar_position', 'single_podcast_sidebar_position' );
		$autoplay         = boolval( gulir_get_single_setting( 'audio_autoplay', 'single_podcast_audio_autoplay' ) );
		$crop_size        = 'gulir_crop_o2';

		if ( 'none' === $sidebar_position ) {
			$sidebar_name = false;
		}
		if ( empty( $sidebar_name ) || ! is_active_sidebar( $sidebar_name ) ) {
			$classes[] = 'without-sidebar';
		} else {
			$classes[] = 'is-sidebar-' . $sidebar_position;
			$classes[] = gulir_get_single_sticky_sidebar( 'single_podcast' );
		} ?>
		<div class="<?php echo join( ' ', $classes ); ?>">
			<div <?php post_class(); ?>>
				<div class="podcast-header-2">
					<div class="rb-small-container edge-padding">
						<?php
						gulir_single_breadcrumb( 'single_podcast' );
						gulir_single_entry_category( 'single_podcast' );
						gulir_single_title();
						gulir_single_tagline();
						gulir_single_header_meta( 'single_podcast' );
						?>
					</div>
					<div class="rb-container edge-padding">
						<div class="podcast-feat-holder">
							<?php gulir_single_featured_image( $crop_size, [ 'class' => 'featured-img' ] ); ?>
						</div>
					</div>
					<div class="rb-small-container edge-padding">
						<div class="podcast-embed-2 light-scheme">
							<?php
							echo gulir_get_audio_embed( get_the_ID(), $autoplay );
							gulir_podcast_socials();
							?>
						</div>
						<?php gulir_single_featured_caption(); ?>
					</div>
				</div>
			</div>
			<div class="rb-container edge-padding">
				<div class="grid-container">
					<div class="s-ct">
						<?php
						gulir_single_content();
						gulir_single_author_box();
						gulir_single_next_prev();
						gulir_single_comment();
						?>
					</div>
					<?php gulir_single_sidebar( $sidebar_name ); ?>
				</div>
			</div>
		</div>
		<div class="single-footer rb-container edge-padding">
			<?php gulir_single_footer(); ?>
		</div>
		<?php
	}
}
