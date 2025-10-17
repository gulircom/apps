<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_elementor_main_menu' ) ) {
	function gulir_elementor_main_menu( $settings = [] ) {

		if ( empty( $settings['main_menu'] ) || ! is_nav_menu( $settings['main_menu'] ) ) {
			return;
		}
		$args = [
				'menu'          => $settings['main_menu'],
				'menu_id'       => false,
				'container'     => '',
				'menu_class'    => 'main-menu rb-menu large-menu',
				'depth'         => 0,
				'items_wrap'    => '<ul id="%1$s" class="%2$s" itemscope itemtype="' . gulir_protocol() . '://www.schema.org/SiteNavigationElement">%3$s</ul>',
				'echo'          => true,
				'fallback_cb'   => function_exists( 'gulir_navigation_fallback' ) ? 'gulir_navigation_fallback' : false,
				'fallback_name' => esc_html__( 'Main Menu', 'gulir-core' ),
		];

		if ( class_exists( 'Gulir_Walker_Nav_Menu' ) ) {
			$args['walker'] = new Gulir_Walker_Nav_Menu();
		}

		if ( ! empty( $settings['color_scheme'] ) ) {
			$args['sub_scheme'] = 'light-scheme';
		}
		?>
		<nav id="site-navigation" class="main-menu-wrap template-menu" aria-label="<?php esc_attr_e( 'main menu', 'gulir-core' ); ?>">
			<?php
			wp_nav_menu( $args );
			if ( ! empty( $settings['menu_more'] ) ) {
				gulir_header_more( [ 'more' => true ] );
			} ?>
		</nav>
		<?php gulir_elementor_single_sticky_html( $settings );
	}
}

if ( ! function_exists( 'gulir_elementor_single_sticky_html' ) ) {
	function gulir_elementor_single_sticky_html( $settings = [] ) {

		if ( ! function_exists( 'gulir_single_sticky_html' ) || empty( $settings['is_main_menu'] ) ) {
			return;
		}

		if ( gulir_get_option( 'single_post_sticky_title' ) && is_single() && ! gulir_is_amp() ) {
			gulir_single_sticky_html();
		}
	}
}

if ( ! function_exists( 'gulir_elementor_social_list' ) ) {
	function gulir_elementor_social_list() {

		if ( ! function_exists( 'gulir_get_social_list' ) ) {
			return;
		}
		?>
		<div class="header-social-list">
			<div class="e-social-holder">
				<?php echo gulir_get_social_list( gulir_get_option() ); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_elementor_header_search' ) ) {
	function gulir_elementor_header_search( $settings = [] ) {

		if ( ! function_exists( 'gulir_header_search' ) || ! function_exists( 'gulir_header_search_form' ) ) {
			return;
		}

		if ( empty( $settings['search_layout'] ) || 'form' !== $settings['search_layout'] ) {
			gulir_header_search( $settings );
		} else {
			gulir_header_search_form( $settings );
		}
	}
}

if ( ! function_exists( 'gulir_elementor_mini_cart' ) ) {
	function gulir_elementor_mini_cart( $settings = [] ) {

		if ( ! function_exists( 'gulir_header_mini_cart_html' ) ) {
			return;
		}

		gulir_header_mini_cart_html();
	}
}

if ( ! function_exists( 'gulir_elementor_sidebar_menu' ) ) {
	function gulir_elementor_sidebar_menu( $settings = [] ) {

		if ( empty( $settings['menu'] ) || ! is_nav_menu( $settings['menu'] ) ) {
			return;
		}
		$classes = 'sidebar-menu';
		$depth   = 4;
		if ( ! empty( $settings['menu_layout'] ) ) {
			$classes .= ' is-horizontal rb-menu';
			$depth   = 1;
		} else {
			$classes .= ' is-vertical';
		}

		if ( ! empty( $settings['title'] ) ) {
			$settings['title_tag'] = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h4';
			echo '<' . strip_tags( $settings['title_tag'] ) . ' class="menu-heading">' . gulir_strip_tags( $settings['title'] ) . '</' . strip_tags( $settings['title_tag'] ) . '>';
		}
		wp_nav_menu( [
				'menu'       => $settings['menu'],
				'menu_id'    => false,
				'container'  => '',
				'menu_class' => $classes,
				'depth'      => $depth,
				'echo'       => true,
		] );
	}
}

if ( ! function_exists( 'gulir_elementor_single_category' ) ) {
	function gulir_elementor_single_category( $settings = [] ) {

		if ( ! function_exists( 'gulir_get_entry_categories' ) ) {
			return;
		}

		if ( empty( $settings['entry_category'] ) ) {
			$settings['entry_category'] = gulir_get_option( 'single_post_entry_category' );
		}

		if ( empty( $settings['entry_category'] ) && '-1' === (string) $settings['entry_category'] ) {
			return;
		}

		$classes = 's-cats';
		$parse   = explode( ',', $settings['entry_category'] );
		if ( ! empty( $parse[0] ) ) {
			$classes .= ' ecat-' . $parse[0];
		}
		if ( ! empty( $parse[1] ) ) {
			$classes .= ' ecat-size-' . $parse[1];
		}
		if ( ! empty( $settings['color_scheme'] ) ) {
			$classes .= ' light-scheme';
		}

		if ( ! empty( $settings['hide_category'] ) ) {
			switch ( $settings['hide_category'] ) {
				case 'mobile' :
					$classes .= ' mobile-hide';
					break;
				case 'tablet' :
					$classes .= ' tablet-hide';
					break;
				case 'all' :
					$classes .= ' mobile-hide tablet-hide';
					break;
			}
		}

		$settings['entry_category'] = true;
		$settings['is_singular']    = true;

		if ( ! empty( $settings['primary_category'] ) && '1' === (string) $settings['primary_category'] ) {
			$settings['only_primary'] = true;
		}
		?>
		<div class="<?php echo strip_tags( $classes ); ?>">
			<?php if ( gulir_is_edit_mode() ) {
				echo '<div class="p-categories"><a href="#" class="p-category">' . esc_html__( 'Dynamic Category', 'gulir-core' ) . '</a></div>';
			} else {
				echo gulir_get_entry_categories( $settings );
			}
			?>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_elementor_single_featured' ) ) {
	function gulir_elementor_single_featured( $settings = [] ) {

		if ( ! function_exists( 'gulir_single_standard_featured' ) ) {
			return;
		}

		if ( empty( $settings['crop_size'] ) ) {
			$settings['crop_size'] = 'full';
		}

		if ( empty( $settings['feat_lazyload'] ) ) {
			$settings['feat_lazyload'] = false;
		}

		$class_name = 's-feat-outer stemplate-feat';
		if ( ! empty( $settings['caption_line'] ) && '-1' === (string) $settings['caption_line'] ) {
			$class_name .= ' is-s-caption';
		}
		if ( ! empty( $settings['image_ratio'] ) ) {
			$class_name .= ' i-ratio';
		}
		?>
		<div class="<?php echo strip_tags( $class_name ); ?>">
			<?php
			if ( gulir_is_edit_mode() ) :
				echo '<div class="s-feat-placeholder"></div>';
				echo '<div class="feat-caption meta-text"><span class="caption-text meta-bold">' . esc_html__( 'This is a example featured caption', 'gulir-core' ) . '</span></div>';
			else :
				$post_id = get_the_ID();
				$format  = get_post_format( $post_id );
				switch ( $format ) {
					case 'video' :
						gulir_single_video_embed( $post_id );
						break;
					case 'audio':
						gulir_single_audio_embed( $post_id );
						break;
					case 'gallery':
						if ( empty( $settings['gallery_layout'] ) ) {
							$settings['gallery_layout'] = 'gallery_1';
						}
						if ( empty( $settings['gallery_crop_size'] ) ) {
							$settings['gallery_crop_size'] = 'full';
						}
						switch ( $settings['gallery_layout'] ) {
							case 'gallery_1' :
								gulir_single_gallery_slider( $settings['gallery_crop_size'], $post_id );
								break;
							case 'gallery_2' :
								gulir_single_gallery_carousel( $settings['gallery_crop_size'], $post_id );
								break;
							case 'gallery_3' :
								gulir_single_gallery_coverflow( $settings['gallery_crop_size'], $post_id );
								break;
						}
						break;
					default:
						gulir_single_standard_featured( $settings['crop_size'], $settings['feat_lazyload'] );
						gulir_single_featured_caption();
				}
			endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_elementor_custom_field_meta' ) ) {
	function gulir_elementor_custom_field_meta( $settings = [] ) {

		if ( empty( $settings['meta_id'] ) ) {
			return;
		}

		if ( gulir_is_edit_mode() ) {
			$value = esc_html__( 'dynamic meta value', 'gulir-core' );
		} else {
			$value = get_post_meta( get_the_ID(), trim( $settings['meta_id'] ), true );
		}

		if ( empty( $value ) ) {
			return;
		}
		if ( empty( $settings['label_position'] ) ) {
			$settings['icon_position'] = 'end';
		}

		if ( empty( $settings['icon_position'] ) ) {
			$settings['icon_position'] = 'begin';
		}

		echo '<span class="cfield-meta">';
		if ( 'begin' === $settings['icon_position'] ) {
			gulir_elementor_custom_field_icon( $settings );
		}
		if ( 'begin' === $settings['label_position'] ) {
			gulir_elementor_custom_field_label( $settings );
		}
		echo '<span class="meta-value">' . gulir_strip_tags( $value ) . '</span>';
		if ( 'end' === $settings['label_position'] ) {
			gulir_elementor_custom_field_label( $settings );
		}
		if ( 'end' === $settings['icon_position'] ) {
			gulir_elementor_custom_field_icon( $settings );
		}
		echo '</span>';
	}
}

if ( ! function_exists( 'gulir_elementor_custom_field_label' ) ) {
	function gulir_elementor_custom_field_label( $settings ) {

		if ( empty( $settings['meta_label'] ) ) {
			return;
		}
		?><span class="meta-tagline"><?php gulir_render_inline_html( $settings['meta_label'] ); ?></span>
	<?php }
}

if ( ! function_exists( 'gulir_elementor_custom_field_icon' ) ) {
	function gulir_elementor_custom_field_icon( $settings ) {

		if ( empty( $settings['meta_icon'] ) ) {
			return;
		}
		?>
		<span class="meta-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['meta_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
	<?php }
}

if ( ! function_exists( 'gulir_elementor_cta' ) ) {
	function gulir_elementor_cta( $settings = [] ) {

		$class_name = 'cta-wrap';
		$map        = [
				'align'           => 'cta-',
				'align_tablet'    => 't-cta-',
				'align_mobile'    => 'm-cta-',
				'position'        => 'cta-img-',
				'position_tablet' => 't-cta-img-',
				'position_mobile' => 'm-cta-img-',
				'btn_width'       => 'cta-btn-',
		];

		foreach ( $map as $key => $prefix ) {
			if ( ! empty( $settings[ $key ] ) ) {
				$class_name .= ' ' . $prefix . trim( $settings[ $key ] );
			}
		}
		?>
		<div class="<?php echo strip_tags( $class_name ); ?>">
			<?php
			if ( ! empty( $settings['img_link_apply'] ) ) {
				echo gulir_get_elementor_open_link( $settings['img_link'], 'cta-absolute-link' );
				echo gulir_get_elementor_close_link( $settings['img_link'] );
			}
			gulir_elementor_cta_featured( $settings );
			if ( empty( $settings['title_tag'] ) ) {
				$settings['title_tag'] = 'h2';
			}
			if ( empty( $settings['description_tag'] ) ) {
				$settings['description_tag'] = 'p';
			}
			?>
			<div class="cta-content">
				<?php
				if ( ! empty( $settings['title'] ) ) {
					echo '<' . strip_tags( $settings['title_tag'] ) . ' class="cta-title">' . gulir_strip_tags( $settings['title'] ) . '</' . strip_tags( $settings['title_tag'] ) . '>';
				}
				if ( ! empty( $settings['description'] ) ) {
					echo '<' . strip_tags( $settings['description_tag'] ) . ' class="cta-description rb-text">' . gulir_strip_tags( $settings['description'], '<strong><b><em><i><a><code><p><div><ol><ul><li><br><img><h2><h3><h4><h5><h6>' ) . '</' . strip_tags( $settings['description_tag'] ) . '>';
				}
				gulir_elementor_cta_buttons( $settings ); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_elementor_cta_featured' ) ) {
	function gulir_elementor_cta_featured( $settings = [] ) {

		if ( empty( $settings['image']['id'] ) ) {
			return;
		}

		if ( ! empty( $settings['img_link_apply'] ) ) {
			$settings['img_link'] = [];
		}

		$size  = ! empty( $settings['image_size'] ) ? $settings['image_size'] : 'full';
		$attrs = [];
		if ( ! empty( $settings['img_animation'] ) ) {
			$attrs['class'] = 'elementor-animation-' . trim( $settings['img_animation'] );
		} ?>
		<div class="cta-featured">
			<?php
			echo gulir_get_elementor_open_link( $settings['img_link'] );
			if ( empty( $settings['dark_image']['id'] ) ) :
				echo wp_get_attachment_image( $settings['image']['id'], $size, false, $attrs );
			else :
				$attrs['data-mode'] = 'default';
				echo wp_get_attachment_image( $settings['image']['id'], $size, false, $attrs );

				$attrs['data-mode'] = 'dark';
				echo wp_get_attachment_image( $settings['dark_image']['id'], $size, false, $attrs );
			endif;
			echo gulir_get_elementor_close_link( $settings['img_link'] );
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_elementor_cta_buttons' ) ) {
	function gulir_elementor_cta_buttons( $settings = [] ) {

		if ( empty( $settings['btn_link_1']['url'] ) && empty( $settings['btn_link_2']['url'] ) ) {
			return;
		}

		$btn_1_classes = 'cta-btn cta-btn-1';
		$btn_2_classes = 'cta-btn cta-btn-2';

		if ( ! empty( $settings['btn_1_hover_animation'] ) ) {
			$btn_1_classes .= ' elementor-animation-' . trim( $settings['btn_1_hover_animation'] );
		}
		if ( ! empty( $settings['btn_2_hover_animation'] ) ) {
			$btn_2_classes .= ' elementor-animation-' . trim( $settings['btn_2_hover_animation'] );
		}
		if ( empty( $settings['btn_label_1'] ) ) {
			$settings['btn_label_1'] = '';
		}
		if ( empty( $settings['btn_label_2'] ) ) {
			$settings['btn_label_2'] = '';
		}
		?>
		<div class="cta-buttons">
			<?php
			if ( ! empty( $settings['btn_link_1'] ) ) {
				echo gulir_get_elementor_open_link( $settings['btn_link_1'], $btn_1_classes ) . gulir_strip_tags( $settings['btn_label_1'] ) . gulir_get_elementor_close_link( $settings['btn_link_1'] );
			}
			if ( ! empty( $settings['btn_link_2'] ) ) {
				echo gulir_get_elementor_open_link( $settings['btn_link_2'], $btn_2_classes ) . gulir_strip_tags( $settings['btn_label_2'] ) . gulir_get_elementor_close_link( $settings['btn_link_2'] );
			}
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_get_elementor_open_link' ) ) {
	function gulir_get_elementor_open_link( $link = [], $classes = '' ) {

		if ( empty( $link['url'] ) ) {
			return false;
		}

		$output = '<a href="' . esc_url( $link['url'] ) . '"';
		if ( ! empty( $classes ) ) {
			$output .= ' class="' . strip_tags( $classes ) . '"';
		}

		$rel = [];

		if ( ! empty( $link['nofollow'] ) ) {
			$rel[] = 'nofollow';
		}

		if ( ! empty( $link['is_external'] ) ) {
			$output .= ' target="_blank"';
			$rel[]  = 'noopener';
		}
		if ( ! empty( $rel ) ) {
			$output .= ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"';
		}

		$output .= '>';

		return $output;
	}
}

if ( ! function_exists( 'gulir_get_elementor_close_link' ) ) {
	function gulir_get_elementor_close_link( $link = [] ) {

		if ( empty( $link['url'] ) ) {
			return false;
		}

		return '</a>';
	}
}

if ( ! function_exists( 'gulir_elementor_archive_title' ) ) {
	function gulir_elementor_archive_title( $settings = [] ) {

		$output = '';

		if ( is_category() ) {
			$archive_title = single_term_title( '', false );
			if ( empty( $settings['follow'] ) ) {
				$settings['follow'] = gulir_get_option( 'follow_category_header' );
			}
		} elseif ( is_search() ) {
			$archive_title = get_search_query();
		} elseif ( is_author() ) {
			$author        = get_queried_object();
			$archive_title = $author->display_name;
			if ( empty( $settings['follow'] ) ) {
				$settings['follow'] = gulir_get_option( 'follow_author_header' );
			}
		} elseif ( is_tag() ) {
			if ( empty( $settings['follow'] ) ) {
				$settings['follow'] = gulir_get_option( 'follow_tag_header' );
			}
			$archive_title = single_term_title( '', false );
		} elseif ( is_year() ) {
			$title['title'] = get_the_date( 'Y' );
		} elseif ( is_month() ) {
			$title['title'] = get_the_date( 'F Y' );
		} elseif ( is_day() ) {
			$title['title'] = get_the_date();
		} elseif ( is_post_type_archive() ) {
			$archive_title = post_type_archive_title( '', false );
		} elseif ( get_queried_object() ) {
			$archive_title = single_term_title( '', false );
		}

		if ( empty( $archive_title ) ) {
			return false;
		}

		if ( empty( $settings['title_tag'] ) ) {
			$settings['title_tag'] = 'h1';
		}

		if ( ! empty( $settings['dynamic_title'] ) && stripos( $settings['dynamic_title'], '{archive}' ) !== false ) {
			$archive_title = str_replace( '{archive}', $archive_title, $settings['dynamic_title'] );
		}

		if ( '-1' === (string) $settings['follow'] || gulir_is_amp() || ! gulir_get_option( 'bookmark_system' ) ) {
			$settings['follow'] = false;
		}

		if ( ! empty( $settings['follow'] ) ) {
			$output .= '<div class="archive-title e-archive-title b-follow">';
			$output .= '<' . $settings['title_tag'] . '>' . $archive_title . '</' . $settings['title_tag'] . '>';
			$output .= '<span class="rb-follow follow-trigger" data-name="' . $archive_title . '" data-cid="' . get_queried_object_id() . '"></span>';
			$output .= '</div>';
		} else {
			$output .= '<' . $settings['title_tag'] . ' class="archive-title e-archive-title">' . $archive_title . '</' . $settings['title_tag'] . '>';
		}

		return $output;
	}
}

if ( ! function_exists( 'gulir_elementor_archive_description' ) ) {
	function gulir_elementor_archive_description( $settings = [] ) {

		if ( is_search() ) {

			global $wp_query;
			if ( ! empty( $wp_query->found_posts ) ) {
				$total = $wp_query->found_posts;
			} else {
				$total = 0;
			}
			$description = sprintf( gulir_html__( 'Showing %s results for your search', 'gulir-core' ), (string) $total );
		} else {
			$description = '<div class="taxonomy-description e-taxonomy-description rb-text">' . get_the_archive_description() . '</div>';
		}

		return $description;
	}
}

if ( ! function_exists( 'gulir_current_date' ) ) {
	function gulir_current_date( $settings ) {

		if ( empty( $settings['format'] ) ) {
			return;
		}

		echo '<span class="current-date">' . date_i18n( trim( $settings['format'] ) ) . '</span>';
	}
}

if ( ! function_exists( 'gulir_elementor_tax_featured' ) ) {
	function gulir_elementor_tax_featured( $settings = [] ) {

		if ( ! is_archive() ) {
			return;
		}

		$data = rb_get_term_meta( 'gulir_category_meta', get_queried_object_id() );
		if ( empty( $data['featured_image'][0] ) ) {
			return;
		}

		$attrs = [];
		if ( ! empty( $settings['feat_lazyload'] ) && '1' === (string) $settings['feat_lazyload'] ) {
			$attrs['loading'] = 'lazy';
		} else {
			$attrs['loading'] = 'eager';
			$attrs['fetchpriority'] = 'high';
		}

		$class_name = 'e-tax-feat';
		if ( ! empty( $settings['image_ratio'] ) ) {
			$class_name .= ' i-ratio';
		}

		echo '<div class="' . $class_name . '"><div class="s-feat">' . wp_get_attachment_image( $data['featured_image'][0], $settings['crop_size'], false, $attrs ) . '</div></div>';
	}
}

if ( ! function_exists( 'gulir_elementor_popup_template' ) ) {
	function gulir_elementor_popup_template( $settings = [] ) {

		if ( empty( $settings['uuid'] ) || gulir_is_amp() ) {
			return;
		}

		// preview only
		if ( gulir_is_edit_mode() ) {
			echo gulir_elementor_get_popup_trigger( $settings );

			return;
		}

		if ( empty( $settings['popup_content'] ) ) {
			return;
		}

		if ( ! isset( $GLOBALS['rb_popup_template_data'] ) ) {
			$GLOBALS['rb_popup_template_data'] = [];
		}

		$settings['popup_content'] = trim( $settings['popup_content'] );
		$popup_contents            = array_column( $GLOBALS['rb_popup_template_data'], 'popup_content' );
		$existing_index            = array_search( $settings['popup_content'], $popup_contents, true );

		if ( $existing_index !== false ) {
			$settings['uuid'] = $GLOBALS['rb_popup_template_data'][ $existing_index ]['uuid'];
		} else {
			$GLOBALS['rb_popup_template_data'][] = $settings;
		}
		
		echo gulir_elementor_get_popup_trigger( $settings );
	}
}


if ( ! function_exists( 'gulir_elementor_get_popup_trigger' ) ) {
	function gulir_elementor_get_popup_trigger( $settings = [] ) {

		$id       = ! empty( $settings['uuid'] ) ? $settings['uuid'] : '';
		$position = ! empty( $settings['popup_position'] ) ? $settings['popup_position'] : 'rb-popup-left';
		$output   = '<div class="popup-trigger-btn h5" data-trigger="' . $id . '" data-position="' . $position . '">';
		if ( ! empty( $settings['btn_icon'] ) ) {
			$output .= '<i class="popup-trigger-svg"></i>';
		}
		if ( ! empty( $settings['btn_label'] ) ) {
			$output .= '<div class="popup-trigger-label">' . esc_html( $settings['btn_label'] ) . '</div>';
		}
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'gulir_elementor_get_popup_template' ) ) {
	function gulir_elementor_get_popup_template( $settings = [] ) {

		if ( empty( $settings['popup_content'] ) || empty( $settings['uuid'] ) ) {
			return false;
		}

		$output = '';

		if ( empty( $settings['yes_js_tag'] ) ) {
			$output .= '<script type="text/template" id="tmpl-' . esc_attr( $settings['uuid'] ) . '">';
			$output .= '<div class="popup-template-content">';
			$output .= do_shortcode( gulir_strip_tags( $settings['popup_content'] ) );
			$output .= '</div>';
			$output .= '</script>';
		} else {
			$output .= '<div class="is-hidden" id="tmpl-' . esc_attr( $settings['uuid'] ) . '">';
			$output .= '<div class="popup-template-content">';
			$output .= do_shortcode( $settings['popup_content'] );
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}

