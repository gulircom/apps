<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_single_attachment' ) ) {
	function gulir_render_single_attachment() {

		$classes   = [];
		$classes[] = 'single-standard-1 without-sidebar'; ?>
		<div class="<?php echo join( ' ', $classes ); ?>">
			<div class="rb-s-container edge-padding">
				<?php gulir_single_open_tag(); ?>
				<div class="grid-container">
					<div class="block-inner">
						<div class="s-ct">
							<header class="single-header">
								<?php
								gulir_single_breadcrumb();
								gulir_single_title();
								gulir_single_tagline();
								gulir_single_header_meta();
								?>
							</header>
							<?php gulir_single_simple_content(); ?>
						</div>
					</div>
				</div>
				<?php
				gulir_single_close_tag(); ?>
			</div>
		</div>
		<?php
	}
}