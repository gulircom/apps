<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_single_audio_3' ) ) {
	function gulir_render_single_audio_3() {

		$classes          = [ 'single-standard-7 single-embed-3' ];
		$sidebar_name     = gulir_get_single_setting( 'sidebar_name' );
		$sidebar_position = gulir_get_single_sidebar_position();

		if ( 'none' === $sidebar_position ) {
			$sidebar_name = false;
		}
		if ( empty( $sidebar_name ) || ! is_active_sidebar( $sidebar_name ) ) {
			$classes[] = 'without-sidebar';
		} else {
			$classes[] = 'is-sidebar-' . $sidebar_position;
			$classes[] = gulir_get_single_sticky_sidebar();
		} ?>
		<div class="<?php echo join( ' ', $classes ); ?>">
			<?php gulir_single_open_tag(); ?>
			<header class="single-header">
				<div class="rb-small-container edge-padding">
					<?php
					gulir_single_breadcrumb();
					gulir_single_entry_category();
					gulir_single_title();
					gulir_single_tagline();
					gulir_single_header_meta();
					?>
				</div>
				<div class="rb-s-container edge-padding">
					<?php
					gulir_single_audio_embed();
					gulir_disclosure_box();
					?>
				</div>
			</header>
			<div class="rb-s-container edge-padding">
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
			<?php gulir_single_close_tag(); ?>
			<div class="rb-s-container edge-padding">
				<?php gulir_single_footer(); ?>
			</div>
		</div>
		<?php
	}
}