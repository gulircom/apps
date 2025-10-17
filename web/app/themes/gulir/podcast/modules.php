<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_podcast_grid_flex_1' ) ) {
	/**
	 * @param $settings
	 */
	function gulir_podcast_grid_flex_1( $settings = array() ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}

		$settings['post_classes'] = 'p-grid p-grid-1 podcast-grid-flex-1';
		if ( ! empty( $settings['box_style'] ) ) {
			$settings['post_classes'] = 'p-box p-grid-box-1 podcast-grid-flex-1 box-' . $settings['box_style'];
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}

		gulir_post_open_tag( $settings );
		if ( ! empty( $settings['box_style'] ) ) {
			echo '<div class="grid-box">';
		}
		foreach ( $settings['block_structure'] as $element ) :
			switch ( $element ) {
				case 'thumbnail' :
					if ( ! empty( $settings['overlay_category'] ) ) {
						gulir_podcast_featured_with_category( $settings );
					} else {
						gulir_podcast_featured_only( $settings );
					}
					break;
				case 'category' :
					gulir_entry_top( $settings );
					break;
				case 'title' :
					gulir_podcast_title( $settings );
					break;
				case 'excerpt' :
					gulir_entry_excerpt( $settings );
					break;
				case 'meta' :
					gulir_podcast_entry_meta( $settings );
					break;
				case 'readmore' :
					gulir_entry_readmore( $settings );
					break;
				case 'divider' :
					gulir_entry_divider( $settings );
					break;
				case 'player' :
					gulir_podcast_entry_player( $settings );
					break;
			}
		endforeach;
		if ( ! empty( $settings['box_style'] ) ) {
			echo '</div>';
		}
		gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_podcast_overlay_flex_1' ) ) {
	/**
	 * @param array $settings
	 *
	 */
	function gulir_podcast_overlay_flex_1( $settings = array() ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		$settings['post_classes'] = 'p-overlay podcast-overlay-flex-1';
		gulir_post_open_tag( $settings );
		?>
        <div class="overlay-holder">
			<?php gulir_podcast_featured( $settings ); ?>
            <div class="overlay-wrap">
                <div class="p-content light-scheme overlay-inner">
					<?php
					foreach ( $settings['block_structure'] as $element ) :
						switch ( $element ) {
							case 'category' :
								gulir_entry_top( $settings );
								break;
							case 'title' :
								gulir_podcast_title( $settings );
								break;
							case 'excerpt' :
								gulir_entry_excerpt( $settings );
								break;
							case 'meta' :
								gulir_podcast_entry_meta( $settings );
								break;
							case 'readmore' :
								gulir_entry_readmore( $settings );
								break;
							case 'divider' :
								gulir_entry_divider( $settings );
								break;
							case 'player' :
								gulir_podcast_entry_player( $settings );
								break;
						}
					endforeach;
					?>
                </div>
            </div>
        </div>
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_podcast_list_flex_1' ) ) {
	/**
	 * @param $settings
	 */
	function gulir_podcast_list_flex_1( $settings = array() ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		$settings['post_classes'] = 'p-list podcast-list-flex-1 p-list-1';
		gulir_post_open_tag( $settings );
		?>
        <div class="list-holder">
            <div class="list-feat-holder">
				<?php if ( ! empty( $settings['overlay_category'] ) ) {
					gulir_podcast_featured_with_category( $settings );
				} else {
					gulir_podcast_featured_only( $settings );
				} ?>
            </div>
            <div class="p-content">
				<?php
				foreach ( $settings['block_structure'] as $element ) :
					switch ( $element ) {
						case 'category' :
							gulir_entry_top( $settings );
							break;
						case 'title' :
							gulir_podcast_title( $settings );
							break;
						case 'excerpt' :
							gulir_entry_excerpt( $settings );
							break;
						case 'meta' :
							gulir_podcast_entry_meta( $settings );
							break;
						case 'readmore' :
							gulir_entry_readmore( $settings );
							break;
						case 'divider' :
							gulir_entry_divider( $settings );
							break;
						case 'player' :
							gulir_podcast_entry_player( $settings );
							break;
					}
				endforeach;
				?>
            </div>
        </div>
		<?php gulir_post_close_tag();
	}
}