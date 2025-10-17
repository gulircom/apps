<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_grid_1' ) ) {
	function gulir_grid_1( $settings = [] ) {

		$settings['post_classes'] = 'p-grid p-grid-1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}

		gulir_post_open_tag( $settings );
		gulir_featured_with_category( $settings );
		gulir_entry_title( $settings );
		gulir_entry_review( $settings );
		gulir_entry_excerpt( $settings );
		gulir_entry_meta( $settings );
		gulir_entry_readmore( $settings );
		gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_grid_2' ) ) {
	function gulir_grid_2( $settings = [] ) {

		$settings['post_classes'] = 'p-grid p-grid-2';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}
		gulir_post_open_tag( $settings );
		gulir_featured_only( $settings );
		gulir_entry_top( $settings );
		gulir_entry_title( $settings );
		gulir_entry_review( $settings );
		gulir_entry_excerpt( $settings );
		gulir_entry_meta( $settings );
		gulir_entry_readmore( $settings );
		gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_grid_small_1' ) ) {
	/**
	 * @param $settings
	 */
	function gulir_grid_small_1( $settings = [] ) {

		$settings['post_classes'] = 'p-grid p-grid-small-1';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h4';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}

		gulir_post_open_tag( $settings );
		gulir_featured_with_category( $settings );
		?>
		<div class="p-content">
			<?php
			gulir_entry_title( $settings );
			gulir_entry_review( $settings );
			gulir_entry_excerpt( $settings );
			gulir_entry_meta( $settings );
			gulir_entry_readmore( $settings );
			?>
		</div>
		<?php
		gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_grid_box_1' ) ) {
	function gulir_grid_box_1( $settings = [] ) {

		if ( empty( $settings['box_style'] ) ) {
			$settings['box_style'] = 'bg';
		}
		$settings['post_classes'] = 'p-grid p-box p-grid-box-1 box-' . $settings['box_style'];

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}

		gulir_post_open_tag( $settings ); ?>
		<div class="grid-box">
			<?php gulir_featured_with_category( $settings );
			gulir_entry_title( $settings );
			gulir_entry_review( $settings );
			gulir_entry_excerpt( $settings );
			gulir_entry_meta( $settings );
			gulir_entry_readmore( $settings );
			?>
		</div>
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_grid_box_2' ) ) {
	function gulir_grid_box_2( $settings = [] ) {

		$settings['post_classes'] = 'p-grid p-box p-grid-box-2 box-' . $settings['box_style'];

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}

		gulir_post_open_tag( $settings );
		?>
		<div class="grid-box">
			<?php gulir_featured_only( $settings );
			gulir_entry_top( $settings );
			gulir_entry_title( $settings );
			gulir_entry_review( $settings );
			gulir_entry_excerpt( $settings );
			gulir_entry_meta( $settings );
			gulir_entry_readmore( $settings );
			?>
		</div>
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_grid_flex_1' ) ) {
	function gulir_grid_flex_1( $settings = [] ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}

		$settings['post_classes'] = 'p-grid p-grid-1';
		if ( ! empty( $settings['box_style'] ) ) {
			$settings['post_classes'] = 'p-box p-grid-box-1 box-' . $settings['box_style'];
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}

		gulir_post_open_tag( $settings );
		if ( ! empty( $settings['box_style'] ) ) {
			echo '<div class="grid-box">';
		}
		foreach ( $settings['block_structure'] as $element ) :
			switch ( $element ) {
				case 'thumbnail' :
					gulir_featured_with_category( $settings );
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
				case 'review' :
					echo gulir_get_entry_review( $settings );
					break;
				case 'readmore' :
					gulir_entry_readmore( $settings );
					break;
				case 'divider' :
					gulir_entry_divider( $settings );
					break;
				case 'images' :
					gulir_entry_teaser_images( $settings );
					break;
				default:
					break;
			}
		endforeach;
		if ( ! empty( $settings['box_style'] ) ) {
			echo '</div>';
		}
		gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_grid_flex_2' ) ) {
	function gulir_grid_flex_2( $settings = [] ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}
		$settings['post_classes'] = 'p-grid p-grid-2';
		if ( ! empty( $settings['box_style'] ) ) {
			$settings['post_classes'] = 'p-box p-grid-box-2 box-' . $settings['box_style'];
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g2';
		}

		gulir_post_open_tag( $settings );
		if ( ! empty( $settings['box_style'] ) ) {
			echo '<div class="grid-box">';
		}
		foreach ( $settings['block_structure'] as $element ) :
			switch ( $element ) {
				case 'thumbnail' :
					gulir_featured_only( $settings );
					break;
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
				case 'review' :
					echo gulir_get_entry_review( $settings );
					break;
				case 'readmore' :
					gulir_entry_readmore( $settings );
					break;
				case 'divider' :
					gulir_entry_divider( $settings );
					break;
				case 'images' :
					gulir_entry_teaser_images( $settings );
					break;
				default:
					break;
			}
		endforeach;
		if ( ! empty( $settings['box_style'] ) ) {
			echo '</div>';
		}
		gulir_post_close_tag();
	}
}