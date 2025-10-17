<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_overlay_1' ) ) {
	function gulir_overlay_1( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h2';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}
		$settings['post_classes'] = 'p-highlight p-overlay-1';
		$inner_classes            = 'overlay-inner p-content' . ( empty( $settings['overlay_scheme'] ) ? ' light-scheme' : '' );

		gulir_post_open_tag( $settings );
		?>
		<div class="overlay-holder">
			<?php gulir_entry_featured( $settings ); ?>
			<div class="overlay-wrap">
				<div class="<?php echo strip_tags( $inner_classes ); ?>">
					<?php
					gulir_entry_top( $settings );
					gulir_entry_title( $settings );
					gulir_entry_review( $settings );
					gulir_entry_excerpt( $settings );
					gulir_entry_meta( $settings );
					gulir_entry_readmore( $settings );
					?>
				</div>
			</div>
		</div>
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_overlay_2' ) ) {
	function gulir_overlay_2( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}

		$settings['post_classes'] = 'p-overlay p-overlay-2';
		$inner_classes            = 'overlay-inner p-content' . ( empty( $settings['overlay_scheme'] ) ? ' light-scheme' : '' );

		gulir_post_open_tag( $settings );
		?>
		<div class="overlay-holder">
			<?php gulir_entry_featured( $settings ); ?>
			<div class="overlay-wrap">
				<div class="<?php echo strip_tags( $inner_classes ); ?>">
					<?php
					gulir_entry_top( $settings );
					gulir_entry_title( $settings );
					gulir_entry_review( $settings );
					gulir_entry_excerpt( $settings );
					gulir_entry_meta( $settings );
					gulir_entry_readmore( $settings );
					?>
				</div>
			</div>
		</div>
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_overlay_flex' ) ) {
	function gulir_overlay_flex( $settings = [] ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		$settings['post_classes'] = 'p-overlay p-overlay-flex';
		$inner_classes            = 'overlay-inner p-content' . ( empty( $settings['overlay_scheme'] ) ? ' light-scheme' : '' );

		gulir_post_open_tag( $settings );
		?>
		<div class="overlay-holder">
			<?php gulir_entry_featured( $settings ); ?>
			<div class="overlay-wrap">
				<div class="<?php echo strip_tags( $inner_classes ); ?>">
					<?php
					foreach ( $settings['block_structure'] as $element ) :
						switch ( $element ) {
							case 'category' :
								gulir_entry_top( $settings );
								break;
							case 'title' :
								gulir_entry_title( $settings );
								break;
							case 'excerpt' :
								gulir_entry_excerpt( $settings );
								break;
							case 'meta' :
								gulir_entry_meta( $settings );
								break;
							case 'readmore' :
								gulir_entry_readmore( $settings );
								break;
							case 'divider' :
								gulir_entry_divider( $settings );
								break;
							case 'review' :
								echo gulir_get_entry_review( $settings );
								break;
						}
					endforeach; ?>
				</div>
			</div>
		</div>
		<?php gulir_post_close_tag();
	}
}
