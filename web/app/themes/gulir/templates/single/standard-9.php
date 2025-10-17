<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_single_standard_9' ) ) {
	function gulir_render_single_standard_9() {

		$classes          = [ 'single-standard-1 single-no-featured' ];
		$sidebar_name     = gulir_get_single_sidebar_name();
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
			<div class="rb-s-container edge-padding">
				<?php gulir_single_open_tag(); ?>
				<header class="single-header">
					<?php
					gulir_single_breadcrumb();
					gulir_single_entry_category();
					gulir_single_title( 'fw-headline' );
					gulir_single_tagline( 'fw-tagline' );
					gulir_single_header_meta();
					gulir_disclosure_box();
					?>
				</header>
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
				<?php
				gulir_single_close_tag();
				gulir_single_footer();
				?>
			</div>
		</div>
		<?php
	}
}