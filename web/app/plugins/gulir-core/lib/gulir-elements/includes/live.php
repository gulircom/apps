<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

add_action( 'save_post_post', 'gulir_update_live_medata', 22 );

if ( ! function_exists( 'gulir_render_block_live' ) ) {
	function gulir_render_block_live( $attributes, $content ) {

		if ( empty( $attributes['liveDate'] ) ) {
			return false;
		}
		$inner_classes = 'live-card gb-wrap rb-text';
		if ( ! empty( $attributes['shadow'] ) ) {
			$inner_classes .= ' yes-shadow';
		}

		$output = '';
		$output .= '<div ' . get_block_wrapper_attributes( [ 'class' => 'live-card-outer' ] ) . '>';
		$output .= gulir_render_live_datetime( strtotime( $attributes['liveDate'] ) );
		$output .= '<div class="' . $inner_classes . '" style="' . gulir_get_block_live_style( $attributes ) . '">' . $content . '</div>';
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'gulir_update_live_medata' ) ) {
	function gulir_update_live_medata( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}

		delete_transient( 'ruby_live_' . $post_id );

		if ( ! has_blocks( $post_id ) ) {
			return;
		}

		$live_blog = rb_get_meta( 'live_blog', $post_id );

		if ( empty( $live_blog ) || 'default' === $live_blog ) {
			delete_post_meta( $post_id, 'ruby_total_live_blocks' );
			delete_post_meta( $post_id, 'ruby_live_metadata' );

			return;
		}

		$post_content = get_post_field( 'post_content', $post_id );

		$matches       = [];
		$ref_matches   = [];
		$live_metadata = gulir_get_all_live_medata( $post_content );
		$count         = 0;

		/** direct blocks */
		$pattern = '/<!--\s*\/wp:gulir-elements\/live\s*-->/';
		if ( preg_match_all( $pattern, $post_content, $matches ) ) {
			$count += count( $matches[0] );
		}

		/** reusable */
		$ref_pattern = '/<!-- wp:block {"ref":(\d+)}/';
		if ( preg_match_all( $ref_pattern, $post_content, $ref_matches ) ) {
			$matches = [];
			if ( ! empty( $ref_matches[1] && is_array( $ref_matches[1] ) ) ) {
				foreach ( $ref_matches[1] as $ref_id ) {
					$ref_content = get_post_field( 'post_content', $ref_id );
					if ( preg_match_all( $pattern, $ref_content, $matches ) ) {
						$count += count( $matches[0] );
					}
				}
			}
		}

		if ( empty( $count ) ) {
			delete_post_meta( $post_id, 'ruby_total_live_blocks' );
			delete_post_meta( $post_id, 'ruby_live_metadata' );
		} else {
			update_post_meta( $post_id, 'ruby_total_live_blocks', $count );
			if ( ! empty( $live_metadata ) ) {
				update_post_meta( $post_id, 'ruby_live_metadata', $live_metadata );
			}
		}
	}
}

if ( ! function_exists( 'gulir_get_all_live_medata' ) ) {
	function gulir_get_all_live_medata( $content ) {

		$data        = [];
		$ref_matches = [];

		$ref_pattern = '/<!-- wp:block {"ref":(\d+)}/';
		if ( preg_match_all( $ref_pattern, $content, $ref_matches ) ) {
			if ( ! empty( $ref_matches[1] && is_array( $ref_matches[1] ) ) ) {
				foreach ( $ref_matches[1] as $ref_id ) {
					$ref_content = get_post_field( 'post_content', $ref_id );
					$data        = gulir_extract_live_medata( $ref_content, $data );
				}
			}
		}

		return gulir_extract_live_medata( $content, $data );
	}
}

if ( ! function_exists( 'gulir_extract_live_medata' ) ) {
	function gulir_extract_live_medata( $content, $data = [] ) {

		$matches = [];
		$pattern = '/<!--\s*wp:gulir-elements\/live\s*({[^}]+})\s*-->(.*?)<!--\s*\/wp:gulir-elements\/live\s*-->/s';
		preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );

		if ( empty( $matches ) ) {
			return [];
		}

		foreach ( $matches as $match ) {
			$metadata = $match[1];
			if ( ! isset( $match[1] ) ) {
				continue;
			}
			preg_match( '/"liveDate"\s*:\s*"([^"]+)"/', $metadata, $date_match );
			if ( $date_match ) {
				if ( ! empty( $date_match[1] ) && ! empty( $match[2] ) ) {
					$item                  = gulir_extract_live_item_medata( $match[2] );
					$item['datePublished'] = $date_match[1];
					$data[]                = $item;
				}
			}
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_extract_live_item_medata' ) ) {
	function gulir_extract_live_item_medata( $content ) {

		$matches = [];
		$data    = [];
		$pattern = '/<!--\s*wp:(heading|paragraph)[^>]*-->(.*?)<!--\s*\/wp:\1\s*-->/s';
		preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );

		if ( ! empty( $matches ) ) {
			foreach ( $matches as $match ) {
				if ( ! empty( $data['headline'] ) && ! empty( $data['articleBody'] ) ) {
					break;
				}
				$tag     = $match[1];
				$content = trim( strip_tags( $match[2] ) );
				if ( $tag === 'heading' ) {
					if ( empty( $data['headline'] ) ) {
						$data['headline'] = wp_strip_all_tags( $content );
					}
					continue;
				} elseif ( $tag === 'paragraph' ) {
					if ( empty( $data['articleBody'] ) ) {
						$data['articleBody'] = wp_strip_all_tags( $content );
					}
					continue;
				}
			}
		}

		if ( empty( $data['headline'] ) && empty( $data['articleBody'] ) ) {
			$data['headline']    = wp_trim_words( $content, 10, '...' );
			$data['articleBody'] = wp_strip_all_tags( $content );
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_render_live_datetime' ) ) {
	function gulir_render_live_datetime( $timestamp ) {

		$to     = time();
		$diff   = (int) abs( $to - $timestamp );
		$since  = '';
		$format = gulir_get_option( 'single_post_update_format' );
		if ( empty( $format ) ) {
			$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
		}
		if ( $diff < MINUTE_IN_SECONDS ) {
			$since = gulir_html__( 'A few seconds ago', 'gulir-core' );
		} elseif ( $diff < HOUR_IN_SECONDS && $diff >= MINUTE_IN_SECONDS ) {
			$mins = round( $diff / MINUTE_IN_SECONDS );
			if ( $mins <= 1 ) {
				$mins = 1;
			}
			$since = sprintf( gulir_html__( '%s min ago', 'gulir-core' ), $mins );
		} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
			$hours = round( $diff / HOUR_IN_SECONDS );
			$mins  = round( ( $diff % HOUR_IN_SECONDS ) / MINUTE_IN_SECONDS );

			if ( $hours <= 1 ) {
				$hours = 1;
			}

			if ( $mins < 1 ) {
				$since = sprintf( gulir_html__( '%s hr ago', 'gulir-core' ), $hours );
			} else {
				$since = sprintf( gulir_html__( '%s hr %s min ago', 'gulir-core' ), $hours, $mins );
			}
		} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
			$days  = round( $diff / DAY_IN_SECONDS );
			$hours = round( ( $diff % DAY_IN_SECONDS ) / HOUR_IN_SECONDS );

			if ( $days <= 1 ) {
				if ( $hours < 1 ) {
					$since = sprintf( gulir_html__( '1 day ago', 'gulir-core' ), $days );
				} else {
					$since = sprintf( gulir_html__( '1 day %s hr ago', 'gulir-core' ), $hours );
				}
			} else {
				if ( $hours < 1 ) {
					$since = sprintf( gulir_html__( '%s days ago', 'gulir-core' ), $days );
				} else {
					$since = sprintf( gulir_html__( '%s days %s hr ago', 'gulir-core' ), $days, $hours );
				}
			}
		} elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
			$weeks = round( $diff / WEEK_IN_SECONDS );
			if ( $weeks <= 1 ) {
				$since = sprintf( gulir_html__( '1 week ago', 'gulir-core' ), $weeks );
			} else {
				$since = sprintf( gulir_html__( '%s weeks ago', 'gulir-core' ), $weeks );
			}
		} elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
			$months = round( $diff / MONTH_IN_SECONDS );
			if ( $months <= 1 ) {
				$since = sprintf( gulir_html__( '1 month ago', 'gulir-core' ), $months );
			} else {
				$since = sprintf( gulir_html__( '%s months ago', 'gulir-core' ), $months );
			}
		} elseif ( $diff >= YEAR_IN_SECONDS ) {
			$years = round( $diff / YEAR_IN_SECONDS );
			if ( $years <= 1 ) {
				$since = gulir_html__( '1 year ago', 'gulir-core' );
			} else {
				$since = sprintf( gulir_html__( '%s years ago', 'gulir-core' ), $years );
			}
		}

		$gtm_offset = (float) get_option( 'gmt_offset' );
		$output     = '';
		$output     .= '<div class="live-datetime meta-text">';
		$output     .= '<span class="live-datetime-dot"></span>';
		$output     .= '<strong class="live-hdate meta-bold" data-timestamp= ' . $timestamp . '>' . $since . '</strong>';
		$output     .= '<span class="live-fdate">' . date_i18n( $format, $timestamp + $gtm_offset * 3600 ) . '</span>';
		$output     .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'gulir_get_block_live_style' ) ) {
	function gulir_get_block_live_style( $attributes ) {

		$css = [];

		if ( ! empty( $attributes['borderStyle'] ) ) {
			$css['--border-style'] = $attributes['borderStyle'];
		}
		if ( ! empty( $attributes['borderRadius'] ) ) {
			$css['--border-radius'] = $attributes['borderRadius'] . 'px';
		}
		if ( ! empty( $attributes['borderWidth'] ) ) {
			$css['--border-width'] = gulir_get_block_border_width_css( $attributes['borderWidth'] );
		}
		if ( ! empty( $attributes['borderColor'] ) ) {
			$css['--border-color'] = $attributes['borderColor'];
		}
		if ( ! empty( $attributes['darkBorderColor'] ) ) {
			$css['--dark-border-color'] = $attributes['darkBorderColor'];
		}
		if ( ! empty( $attributes['background'] ) ) {
			$css['--bg'] = $attributes['background'];
		}
		if ( ! empty( $attributes['darkBackground'] ) ) {
			$css['--dark-bg'] = $attributes['darkBackground'];
		}
		if ( ! empty( $attributes['desktopPadding'] ) ) {
			$css['--desktop-padding'] = gulir_get_block_padding_css( $attributes['desktopPadding'] );
		}
		if ( ! empty( $attributes['tabletPadding'] ) ) {
			$css['--tablet-padding'] = gulir_get_block_padding_css( $attributes['tabletPadding'] );
		}
		if ( ! empty( $attributes['mobilePadding'] ) ) {
			$css['--mobile-padding'] = gulir_get_block_padding_css( $attributes['mobilePadding'] );
		}
		$css_attributes = '';
		foreach ( $css as $key => $value ) {
			$css_attributes .= "$key: $value;";
		}

		return apply_filters( 'ruby_inline_live_blog_css', $css_attributes );
	}
}
