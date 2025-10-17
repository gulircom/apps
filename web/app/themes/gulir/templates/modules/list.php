<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_list_1' ) ) {
	function gulir_list_1( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		$settings['post_classes'] = 'p-list p-list-1';
		gulir_post_open_tag( $settings );
		?>
		<div class="list-holder">
			<div class="list-feat-holder">
				<?php gulir_featured_with_category( $settings ); ?>
			</div>
			<div class="p-content">
				<?php
				gulir_entry_title( $settings );
				gulir_entry_review( $settings );
				gulir_entry_excerpt( $settings );
				gulir_entry_meta( $settings );
				gulir_entry_readmore( $settings );
				?>
			</div>
		</div>
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_list_2' ) ) {
	function gulir_list_2( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		$settings['post_classes'] = 'p-list p-list-2';
		gulir_post_open_tag( $settings );
		?>
		<div class="list-holder">
			<div class="list-feat-holder">
				<?php gulir_featured_only( $settings ); ?>
			</div>
			<div class="p-content">
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
		<?php gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_list_small_1' ) ) {
	function gulir_list_small_1( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h5';
		}
		if ( empty( $settings['bottom_border'] ) ) {
			$settings['bottom_border'] = 'gray';
		}
		$settings['post_classes'] = 'p-small p-list-small-1';

		gulir_post_open_tag( $settings );
		?>
		<div class="p-content">
			<?php
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

if ( ! function_exists( 'gulir_list_small_2' ) ) {
	function gulir_list_small_2( $settings = [] ) {

		$settings['none_featured_extra'] = true;
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h5';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'thumbnail';
		}
		if ( ! isset( $settings['featured_classes'] ) ) {
			$settings['featured_classes'] = 'ratio-v1';
		}
		$settings['post_classes'] = 'p-small p-list-small-2';

		gulir_post_open_tag( $settings );
		gulir_featured_only( $settings ); ?>
		<div class="p-content">
			<?php
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

if ( ! function_exists( 'gulir_list_small_3' ) ) {
	function gulir_list_small_3( $settings = [] ) {

		$settings['none_featured_extra'] = true;
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h5';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'thumbnail';
		}
		if ( ! isset( $settings['featured_classes'] ) ) {
			$settings['featured_classes'] = 'ratio-q';
		}
		$settings['post_classes'] = 'p-small p-list-small-3 p-list-small-2';
		gulir_post_open_tag( $settings );
		gulir_featured_only( $settings ); ?>
		<div class="p-content">
			<?php
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

if ( ! function_exists( 'gulir_list_inline' ) ) {
	function gulir_list_inline( $settings = [] ) {

		$settings['post_classes'] = 'p-list-inline';
		$settings['title_prefix'] = '<i class="rbi rbi-plus" aria-hidden="true"></i>';
		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h5';
		}
		gulir_post_open_tag( $settings );
		gulir_entry_title( $settings );
		gulir_post_close_tag();
	}
}

if ( ! function_exists( 'gulir_list_box_1' ) ) {
	function gulir_list_box_1( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		if ( empty( $settings['box_style'] ) ) {
			$settings['box_style'] = 'bg';
		}
		$settings['post_classes'] = 'p-list p-box p-list-1 p-list-box-1 box-' . $settings['box_style'];
		gulir_post_open_tag( $settings ); ?>
		<div class="list-box">
			<div class="list-holder">
				<div class="list-feat-holder">
					<?php gulir_featured_with_category( $settings ); ?>
				</div>
				<div class="p-content">
					<?php
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

if ( ! function_exists( 'gulir_list_box_2' ) ) {
	function gulir_list_box_2( $settings = [] ) {

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}
		if ( empty( $settings['box_style'] ) ) {
			$settings['box_style'] = 'bg';
		}
		$settings['post_classes'] = 'p-list p-box p-list-2 p-list-box-2 box-' . $settings['box_style'];
		gulir_post_open_tag( $settings ); ?>
		<div class="list-box">
			<div class="list-holder">
				<div class="list-feat-holder">
					<?php gulir_featured_only( $settings ); ?>
				</div>
				<div class="p-content">
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

if ( ! function_exists( 'gulir_list_flex' ) ) {
	function gulir_list_flex( $settings = [] ) {

		if ( empty( $settings['block_structure'] ) || ! is_array( $settings['block_structure'] ) ) {
			return;
		}

		$settings['post_classes'] = 'p-list p-list-2';
		if ( ! empty( $settings['box_style'] ) ) {
			$settings['post_classes'] = 'p-list p-box p-list-2 p-list-box-2 box-' . $settings['box_style'];
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h3';
		}
		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'gulir_crop_g1';
		}

		gulir_post_open_tag( $settings );
		if ( ! empty( $settings['box_style'] ) ) {
			echo '<div class="list-box">';
		} ?>
		<div class="list-holder">
			<div class="list-feat-holder">
				<?php if ( ! empty( $settings['overlay_category'] ) ) {
					gulir_featured_with_category( $settings );
				} else {
					gulir_featured_only( $settings );
				} ?>
			</div>
			<div class="p-content">
				<?php foreach ( $settings['block_structure'] as $element ) :
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
						case 'review' :
							echo gulir_get_entry_review( $settings );
							break;
						case 'readmore' :
							gulir_entry_readmore( $settings );
							break;
						case 'divider' :
							gulir_entry_divider( $settings );
							break;
						default:
							break;
					}
				endforeach;
				?>
			</div>
		</div>
		<?php if ( ! empty( $settings['box_style'] ) ) {
			echo '</div>';
		}
		gulir_post_close_tag();
	}
}