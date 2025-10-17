<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_footer' ) ) {
	function gulir_render_footer() {

		if ( gulir_is_amp() ) {
			gulir_footer_amp();

			return;
		}

		gulir_footer_top();
		$layout     = gulir_get_option( 'footer_layout' );
		$template   = gulir_get_option( 'footer_template_shortcode' );
		$background = gulir_get_option( 'footer_background' );

		if ( is_singular() ) {
			$footer_template = rb_get_meta( 'footer_template', get_the_ID() );
			if ( ! empty( $footer_template ) ) {
				$template = $footer_template;
				$layout   = 'shortcode';
			}
		}

		$classes       = [ 'footer-wrap rb-section' ];
		$inner_classes = [ 'footer-inner' ];

		if ( gulir_get_option( 'footer_dot' ) ) {
			$classes[] = 'left-dot';
		}
		if ( gulir_get_option( 'footer_border' ) ) {
			$classes[] = 'top-border';
		}
		if ( ! empty( $layout ) && 'shortcode' === $layout ) {
			$classes[] = 'footer-etemplate';
		}
		if ( gulir_get_option( 'footer_column_border' ) ) {
			$inner_classes[] = 'has-border';
		}
		if ( gulir_get_option( 'footer_color_scheme' ) ) {
			$inner_classes[] = 'light-scheme';
		}
		if ( ! empty( $background['background-color'] ) || ! empty( $background['background-attachment'] ) ) {
			$inner_classes[] = 'footer-has-bg';
		}
		?>
		<footer class="<?php echo implode( ' ', $classes ); ?>">
			<?php
			if ( 'none' !== $layout ) {
				if ( ! empty( $layout ) && 'shortcode' === $layout ) {
					echo do_shortcode( $template );
					if ( gulir_get_footer_copyright() ) {
						echo '<div class="' . implode( ' ', $inner_classes ) . '">';
						gulir_footer_copyright();
						echo '</div>';
					}
				} else {
					echo '<div class="' . implode( ' ', $inner_classes ) . '">';
					gulir_render_footer_widgets( $layout );
					gulir_footer_copyright();
					echo '</div>';
				}
			} else {
				if ( gulir_get_footer_copyright() ) {
					echo '<div class="' . implode( ' ', $inner_classes ) . '">';
					gulir_footer_copyright();
					echo '</div>';
				}
			}
			?></footer>
		<?php
	}
}

if ( ! function_exists( 'gulir_footer_top' ) ) {
	function gulir_footer_top() {

		if ( is_active_sidebar( 'gulir_sidebar_fw_footer' ) )  : ?>
			<aside class="rb-section fw-widget top-footer edge-padding">
				<div class="top-footer-inner">
					<?php dynamic_sidebar( 'gulir_sidebar_fw_footer' ); ?>
				</div>
			</aside>
		<?php endif;
	}
}

if ( ! function_exists( 'gulir_render_footer_widgets' ) ) {
	function gulir_render_footer_widgets( $layout ) {

		if ( ! gulir_get_footer_widgets( $layout ) ) {
			return;
		}

		$classes = [ 'footer-columns rb-columns is-gap-25 rb-container edge-padding' ];
		switch ( $layout ) {
			case 5 :
				$classes[] = 'footer-5c';
				break;
			case 51:
				$classes[] = 'footer-51c';
				break;
			case 3:
				$classes[] = 'footer-3c';
				break;
			default:
				$classes[] = 'footer-4c';
		} ?>
		<div class="<?php echo implode( ' ', $classes ); ?>">
			<div class="block-inner">
				<?php echo gulir_get_footer_widgets( $layout ); ?>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_get_footer_widgets' ) ) {
	/**
	 * @param $layout
	 *
	 * @return false|string
	 */
	function gulir_get_footer_widgets( $layout ) {

		ob_start();

		if ( is_active_sidebar( 'gulir_sidebar_footer_1' ) ) {
			echo '<div class="footer-col">';
			dynamic_sidebar( 'gulir_sidebar_footer_1' );
			echo '</div>';
		}
		if ( is_active_sidebar( 'gulir_sidebar_footer_2' ) ) {
			echo '<div class="footer-col">';
			dynamic_sidebar( 'gulir_sidebar_footer_2' );
			echo '</div>';
		}
		if ( is_active_sidebar( 'gulir_sidebar_footer_3' ) ) {
			echo '<div class="footer-col">';
			dynamic_sidebar( 'gulir_sidebar_footer_3' );
			echo '</div>';
		}
		if ( is_active_sidebar( 'gulir_sidebar_footer_4' ) && ( '3' !== (string) $layout ) ) {
			echo '<div class="footer-col">';
			dynamic_sidebar( 'gulir_sidebar_footer_4' );
			echo '</div>';
		}
		if ( is_active_sidebar( 'gulir_sidebar_footer_5' ) && ! empty( $layout ) && ( '5' === (string) $layout || '51' === (string) $layout ) ) {
			echo '<div class="footer-col">';
			dynamic_sidebar( 'gulir_sidebar_footer_5' );
			echo '</div>';
		}

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_footer_copyright' ) ) :
	function gulir_footer_copyright() {

		if ( ! gulir_get_footer_copyright() ) {
			return;
		}

		$classes = 'footer-copyright';
		if ( ( gulir_is_amp() && gulir_get_option( 'amp_footer_bottom_center' ) ) || gulir_get_option( 'footer_bottom_center' ) ) {
			$classes .= ' footer-bottom-centered';
		} ?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<div class="rb-container edge-padding">
				<?php echo gulir_get_footer_copyright(); ?>
			</div>
		</div>
	<?php }
endif;

if ( ! function_exists( 'gulir_get_footer_copyright' ) ) {
	function gulir_get_footer_copyright() {

		$copyright = gulir_get_option( 'copyright' );
		$menu      = gulir_get_option( 'footer_menu' );

		if ( gulir_is_amp() ) {
			$social = gulir_get_option( 'amp_footer_social' );
			$logo   = gulir_get_option( 'amp_footer_logo' );

			/** unset copyright */
			if ( ! gulir_get_option( 'amp_copyright' ) ) {
				$copyright = $menu = false;
			}

		} elseif ( gulir_get_option( 'footer_logo_socials' ) ) {
			$social    = gulir_get_option( 'footer_social' );
			$logo      = gulir_get_option( 'footer_logo' );
			$dark_logo = gulir_get_option( 'dark_footer_logo' );
		}

		ob_start();
		if ( ! empty( $logo['url'] ) || ! empty( $social ) ) : ?>
			<div class="bottom-footer-section">
				<?php if ( ! empty( $logo['url'] ) ) : ?>
					<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
						<?php if ( empty( $dark_logo['url'] ) ) {
							$dark_logo = $logo;
						}
						echo gulir_get_logo_html( $logo, false, 'logo-default', 'default', 'lazy' );
						echo gulir_get_logo_html( $dark_logo, false, 'logo-dark', 'dark', 'lazy' );
						?>
					</a>
				<?php endif;
				if ( ! empty( $social ) ) : ?>
					<div class="footer-social-list">
						<span class="footer-social-list-title h6"><?php gulir_html_e( 'Follow US', 'gulir' ); ?></span>
						<?php echo gulir_get_social_list( gulir_get_option() ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif;

		if ( ! empty( $copyright ) || ! empty( $menu ) ) : ?>
			<div class="copyright-inner">
				<?php
				if ( ! empty( $copyright ) ) {
					echo '<div class="copyright">' . gulir_strip_tags( str_replace( '{year}', date( 'Y' ), $copyright ) ) . '</div>';
				}
				if ( ! empty( $menu ) && is_nav_menu( $menu ) ) {
					wp_nav_menu( [
							'menu'        => $menu,
							'menu_id'     => 'copyright-menu',
							'menu_class'  => 'copyright-menu',
							'container'   => false,
							'depth'       => 1,
							'echo'        => true,
							'fallback_cb' => '__return_false',
					] );
				} ?>
			</div>
		<?php endif;

		return ob_get_clean();
	}
}

if ( ! function_exists( 'gulir_footer_amp' ) ) {
	function gulir_footer_amp() {

		$classes    = [ 'footer-wrap amp-footer rb-section' ];
		$background = gulir_get_option( 'footer_background' );

		if ( gulir_get_option( 'footer_color_scheme' ) ) {
			$classes[] = 'light-scheme';
		}
		if ( gulir_get_option( 'footer_column_border' ) ) {
			$classes[] = 'has-border';
		}
		if ( gulir_get_option( 'footer_dot' ) ) {
			$classes[] = 'left-dot';
		}
		if ( gulir_get_option( 'footer_border' ) ) {
			$classes[] = 'top-border';
		}
		if ( ! empty( $background['background-color'] ) || ! empty( $background['background-attachment'] ) ) {
			$classes[] = 'footer-has-bg';
		}
		if ( function_exists( 'gulir_amp_ad' ) ) {
			gulir_amp_ad( [
					'type'      => gulir_get_option( 'amp_footer_ad_type' ),
					'client'    => gulir_get_option( 'amp_footer_adsense_client' ),
					'slot'      => gulir_get_option( 'amp_footer_adsense_slot' ),
					'size'      => gulir_get_option( 'amp_footer_adsense_size' ),
					'custom'    => gulir_get_option( 'amp_footer_ad_code' ),
					'classname' => 'footer-amp-ad amp-ad-wrap',
			] );
		}
		?>
		<footer class="<?php echo implode( ' ', $classes ); ?>">
			<?php gulir_footer_copyright();
			if ( gulir_get_option( 'amp_back_top' ) ) : ?>
				<a href="#top" class="amp-back-top" aria-label="<?php esc_attr_e( 'back top', 'gulir' ); ?>">&uarr;</a>
			<?php endif; ?>
		</footer>
		<?php
	}
}