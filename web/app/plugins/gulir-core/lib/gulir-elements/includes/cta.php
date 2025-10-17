<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_block_cta' ) ) {
	function gulir_render_block_cta( $attributes ) {

		$heading     = $attributes['heading'] ?? '';
		$description = $attributes['description'] ?? '';
		$headingTag  = $attributes['headingHTMLTag'] ?? 'h3';
		$imagePos    = $attributes['imagePos'] ?? false;
		$image       = $attributes['image'] ?? '';
		$imageID     = $attributes['imageID'] ?? '';

		if ( empty( $image ) && ! empty( $attributes['imageURL'] ) ) {
			$image = $attributes['imageURL'];
		}

		$wrapperClassName = 'gb-wrap gb-cta' .
		                    ( ! empty( $attributes['shadow'] ) ? ' yes-shadow' : '' ) .
		                    ( ! empty( $imagePos ) ? ' cta-left' : '' );

		$heading_classes = 'gb-heading' . ( empty( $attributes['tocAdded'] ) ? ' none-toc' : '' );

		$output = '';
		$output .= '<div ' . get_block_wrapper_attributes( [
				'class' => $wrapperClassName,
				'style' => gulir_get_block_cta_style( $attributes ),
			] ) . '>';

		$output .= '<div class="gb-cta-inner">';

		$output .= '<div class="gb-cta-content">';
		$output .= '<div class="gb-cta-header">';
		if ( ! empty( $heading ) ) {
			$output .= '<' . $headingTag . ' class="' . $heading_classes . '">' . gulir_strip_tags( $heading ) . '</' . $headingTag . '>';
		}
		if ( ! empty( $description ) ) {
			$output .= '<div class="cta-description">' . gulir_strip_tags( $description ) . '</div>';
		}
		$output .= '</div>';

		if ( ! empty( $imageID ) && wp_attachment_is_image( $imageID ) ) {
			$output .= '<div class="gb-cta-featured">';
			$output .= wp_get_attachment_image(
				$imageID,
				'full',
				false,
				[
					'class'   => 'gb-image',
					'loading' => 'lazy',
				]
			);
			$output .= '</div>';
		} elseif ( ! empty( $image ) ) {
			// Fallback to raw image URL
			$size  = gulir_get_image_size( $image );
			$attrs = ! empty( $size[3] ) ? ' ' . trim( $size[3] ) : '';

			$output .= '<div class="gb-cta-featured">';
			$output .= '<img loading="lazy" class="gb-image" src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Featured image', 'gulir-core' ) . '"' . $attrs . '>';
			$output .= '</div>';
		}
		$output .= '</div>';

		$output .= gulir_block_cta_buttons( $attributes );

		$output .= '</div>';
		$output .= '</div>';

		return $output;

	}
}

if ( ! function_exists( 'gulir_block_cta_buttons' ) ) {
	function gulir_block_cta_buttons( $attributes ) {

		if ( empty( $attributes['ctaButtons'] ) || ! is_array( $attributes['ctaButtons'] ) ) {
			return false;
		}

		$output = '<div class="gb-buttons">';

		foreach ( $attributes['ctaButtons'] as $item ) {
			$rel = [];

			if ( ! empty( $item['noFollow'] ) ) {
				$rel[] = 'nofollow';
			}

			if ( ! empty( $item['isNewTab'] ) ) {
				$rel[] = 'noopener';
			}

			$classes = 'cta-btn gb-btn is-btn ' . ( ! empty( $item['isButtonBorder'] ) ? 'btn-outlined' : 'btn-filled' );

			$output .= sprintf(
				'<a href="%1$s"%2$s%3$s class="%4$s">%5$s</a>',
				esc_url( ! empty( $item['link'] ) ? $item['link'] : '#' ),
				! empty( $item['isNewTab'] ) ? ' target="_blank"' : '',
				! empty( $rel ) ? ' rel="' . esc_attr( implode( ' ', $rel ) ) . '"' : '',
				esc_attr( $classes ),
				esc_html( ! empty( $item['label'] ) ? $item['label'] : __( 'Get Started', 'gulir-core' ) )
			);
		}

		$output .= '</div>';

		return $output;
	}
}


if ( ! function_exists( 'gulir_get_block_cta_style' ) ) {
	function gulir_get_block_cta_style( $attributes ) {

		$css = [];

		if ( ! empty( $attributes['headingColor'] ) ) {
			$css['--heading-color'] = $attributes['headingColor'];
		}
		if ( ! empty( $attributes['darkHeadingColor'] ) ) {
			$css['--dark-heading-color'] = $attributes['darkHeadingColor'];
		}
		if ( ! empty( $attributes['desktopHeadingSize'] ) ) {
			$css['--desktop-heading-size'] = $attributes['desktopHeadingSize'] . 'px';
		}
		if ( ! empty( $attributes['tabletHeadingSize'] ) ) {
			$css['--tablet-heading-size'] = $attributes['tabletHeadingSize'] . 'px';
		}
		if ( ! empty( $attributes['mobileHeadingSize'] ) ) {
			$css['--mobile-heading-size'] = $attributes['mobileHeadingSize'] . 'px';
		}

		if ( ! empty( $attributes['desktopHeadingMargin'] ) ) {
			$css['--desktop-heading-margin'] = $attributes['desktopHeadingMargin'] . 'px';
		}
		if ( ! empty( $attributes['tabletHeadingMargin'] ) ) {
			$css['--tablet-heading-margin'] = $attributes['tabletHeadingMargin'] . 'px';
		}
		if ( ! empty( $attributes['mobileHeadingMargin'] ) ) {
			$css['--mobile-heading-margin'] = $attributes['mobileHeadingMargin'] . 'px';
		}

		if ( ! empty( $attributes['descriptionColor'] ) ) {
			$css['--description-color'] = $attributes['descriptionColor'];
		}
		if ( ! empty( $attributes['darkDescriptionColor'] ) ) {
			$css['--dark-description-color'] = $attributes['darkDescriptionColor'];
		}
		if ( ! empty( $attributes['desktopDescriptionSize'] ) ) {
			$css['--desktop-description-size'] = $attributes['desktopDescriptionSize'] . 'px';
		}
		if ( ! empty( $attributes['tabletDescriptionSize'] ) ) {
			$css['--tablet-description-size'] = $attributes['tabletDescriptionSize'] . 'px';
		}
		if ( ! empty( $attributes['mobileDescriptionSize'] ) ) {
			$css['--mobile-description-size'] = $attributes['mobileDescriptionSize'] . 'px';
		}
		if ( ! empty( $attributes['desktopDescriptionMargin'] ) ) {
			$css['--desktop-description-margin'] = $attributes['desktopDescriptionMargin'] . 'px';
		}
		if ( ! empty( $attributes['tabletDescriptionMargin'] ) ) {
			$css['--tablet-description-margin'] = $attributes['tabletDescriptionMargin'] . 'px';
		}
		if ( ! empty( $attributes['mobileDescriptionMargin'] ) ) {
			$css['--mobile-description-margin'] = $attributes['mobileDescriptionMargin'] . 'px';
		}

		if ( ! empty( $attributes['desktopImageSize'] ) ) {
			$css['--desktop-image-size'] = $attributes['desktopImageSize'] . 'px';
		}
		if ( ! empty( $attributes['tabletImageSize'] ) ) {
			$css['--tablet-image-size'] = $attributes['tabletImageSize'] . 'px';
		}
		if ( ! empty( $attributes['mobileImageSize'] ) ) {
			$css['--mobile-image-size'] = $attributes['mobileImageSize'] . 'px';
		}

		if ( ! empty( $attributes['imageRadius'] ) ) {
			$css['--image-radius'] = $attributes['imageRadius'] . 'px';
		}

		if ( ! empty( $attributes['desktopButtonSize'] ) ) {
			$css['--desktop-button-size'] = $attributes['desktopButtonSize'] . 'px';
		}
		if ( ! empty( $attributes['tabletButtonSize'] ) ) {
			$css['--tablet-button-size'] = $attributes['tabletButtonSize'] . 'px';
		}
		if ( ! empty( $attributes['mobileButtonSize'] ) ) {
			$css['--mobile-button-size'] = $attributes['mobileButtonSize'] . 'px';
		}

		if ( ! empty( $attributes['buttonColor'] ) ) {
			$css['--button-color'] = $attributes['buttonColor'];
		}
		if ( ! empty( $attributes['buttonBg'] ) ) {
			$css['--button-bg'] = $attributes['buttonBg'];
		}
		if ( ! empty( $attributes['darkButtonColor'] ) ) {
			$css['--dark-button-color'] = $attributes['darkButtonColor'];
		}
		if ( ! empty( $attributes['darkButtonBg'] ) ) {
			$css['--dark-button-bg'] = $attributes['darkButtonBg'];
		}

		if ( ! empty( $attributes['isBorderButtonColor'] ) ) {
			$css['--is-border-button-color'] = $attributes['isBorderButtonColor'];
		}
		if ( ! empty( $attributes['isBorderButtonBorder'] ) ) {
			$css['--is-border-button-border'] = $attributes['isBorderButtonBorder'];
		}
		if ( ! empty( $attributes['isBorderDarkButtonColor'] ) ) {
			$css['--dark-is-border-button-color'] = $attributes['isBorderDarkButtonColor'];
		}
		if ( ! empty( $attributes['isBorderDarkButtonBg'] ) ) {
			$css['--dark-is-border-button-border'] = $attributes['isBorderDarkButtonBg'];
		}

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

		return $css_attributes;
	}
}
