<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_single_standard_10' ) ) {
	function gulir_render_single_standard_10() {

		$classes          = [ 'single-standard-8 single-standard-10' ];
		$sidebar_name     = gulir_get_single_sidebar_name();
		$sidebar_position = gulir_get_single_sidebar_position();
		$crop_size        = gulir_get_single_crop_size( '2048x2048' );

		if ( 'none' === $sidebar_position ) {
			$sidebar_name = false;
		}
		if ( empty( $sidebar_name ) || ! is_active_sidebar( $sidebar_name ) ) {
			$classes[] = 'without-sidebar';
		} else {
			$classes[] = 'is-sidebar-' . $sidebar_position;
			$classes[] = gulir_get_single_sticky_sidebar();
		}
		if ( gulir_get_option( 'single_10_ratio' ) ) {
			$classes[] = 'has-feat-ratio';
		} ?>
		<div class="<?php echo join( ' ', $classes ); ?>">
			<div class="rb-s-container edge-padding">
				<?php gulir_single_open_tag(); ?>
				<div class="s-feat-outer">
					<?php
					gulir_single_standard_featured( $crop_size );
					gulir_single_featured_caption(); ?>
				</div>
				<div class="grid-container">
					<div class="s-ct">
						<header class="single-header">
							<?php
							gulir_single_breadcrumb();
							gulir_single_entry_category();
							gulir_single_title();
							gulir_single_tagline();
							gulir_single_header_meta();
							gulir_disclosure_box();
							?>
						</header>
						<?php
						gulir_single_content();
						gulir_single_author_box();
						gulir_single_next_prev();
						gulir_single_comment();
						?>
					</div>
					<?php gulir_single_sidebar( $sidebar_name ); ?>
				</div>
				<?php
				gulir_single_close_tag();
				gulir_single_footer();
				?>
			</div>
		</div>
		<?php
	}
}