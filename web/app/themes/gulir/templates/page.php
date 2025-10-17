<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_single_page' ) ) {
	function gulir_single_page() {

		$page_id = get_the_ID();

		$classes          = [ 'single-page' ];
		$header_style     = gulir_get_page_header_style( $page_id );
		$sidebar_name     = gulir_get_single_setting( 'sidebar_name', 'page_sidebar_name', $page_id );
		$breadcrumb_pos   = gulir_get_single_setting( 'breadcrumb_pos', 'page_breadcrumb_pos', $page_id );
		$sidebar_position = gulir_get_single_sidebar_position( 'sidebar_position', 'page_sidebar_position', $page_id );
		$content_classes  = 'rb-container edge-padding';

		if ( 'none' === $sidebar_position ) {
			$sidebar_name = false;
		}
		if ( '-1' === (string) $header_style ) {
			$classes[] = 'none-header';
		}
		if ( ! empty( $breadcrumb_pos ) && 'right' === $breadcrumb_pos ) {
			$classes[] = 'right-breadcrumb';
		}
		if ( empty( $sidebar_name ) || ! is_active_sidebar( $sidebar_name ) ) {
			$classes[] = 'without-sidebar';
			if ( gulir_get_page_content_width() ) {
				$content_classes = 'rb-small-container edge-padding';
			}
		} else {
			$classes[] = 'is-sidebar-' . $sidebar_position;
			$classes[] = gulir_get_single_sticky_sidebar( 'page' );
		}
		if ( gulir_is_wc_pages() ) {
			$content_classes = 'rb-container edge-padding';
		}
		?>
		<div class="<?php echo join( ' ', $classes ); ?>">
			<?php if ( function_exists( 'gulir_page_header_' . $header_style ) ) {
				call_user_func( 'gulir_page_header_' . $header_style );
			} ?>
			<div class="<?php echo esc_attr( $content_classes ); ?>">
				<div class="grid-container">
					<div class="s-ct">
						<?php
						gulir_single_simple_content();
						gulir_single_comment();
						?>
					</div>
					<?php gulir_single_sidebar( $sidebar_name ); ?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_page_header_1' ) ) {
	function gulir_page_header_1() {

		$classes = 'page-header page-header-1 edge-padding';
		if ( ! gulir_is_sw_header() ) {
			$classes .= ' rb-container';
		} else {
			$classes .= ' rb-small-container';
		} ?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<div class="page-header-inner">
				<?php
				gulir_single_title();
				gulir_single_page_breadcrumb();
				?>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="page-featured"><?php the_post_thumbnail( 'gulir_crop_o2', [ 'class' => 'featured-img' ] ); ?></div>
			<?php endif; ?>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_page_header_2' ) ) {
	function gulir_page_header_2() {

		if ( ! gulir_is_sw_header() ) {
			$classes = 'rb-container edge-padding';
		} else {
			$classes = 'rb-small-container edge-padding';
		} ?>
		<div class="page-header page-header-2">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="page-featured-overlay"><?php the_post_thumbnail( '2048×2048', [ 'class' => 'featured-img' ] ); ?></div>
			<?php endif; ?>
			<div class="<?php echo esc_attr( $classes ); ?>">
				<div class="page-header-inner light-scheme">
					<?php
					gulir_single_title();
					gulir_single_page_breadcrumb();
					?>
				</div>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_page_header_3' ) ) {
	function gulir_page_header_3() {

		if ( ! gulir_is_sw_header() ) {
			$classes = 'rb-container edge-padding';
		} else {
			$classes = 'rb-small-container edge-padding';
		} ?>
		<div class="page-header page-header-2 is-centered">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="page-featured-overlay"><?php the_post_thumbnail( '2048×2048', [ 'class' => 'featured-img' ] ); ?></div>
			<?php endif; ?>
			<div class="<?php echo esc_attr( $classes ); ?>">
				<div class="page-header-inner light-scheme">
					<?php
					gulir_single_title();
					gulir_single_page_breadcrumb();
					?>
				</div>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_page_header_4' ) ) {
	function gulir_page_header_4() {

		if ( ! has_post_thumbnail() ) {
			gulir_page_header_1();

			return false;
		}

		$classes = 'page-header-inner light-scheme';
		if ( ! gulir_is_sw_header() ) {
			$classes .= ' rb-container';
		} else {
			$classes .= ' rb-small-container';
		} ?>
		<div class="page-header page-header-4 edge-padding rb-container">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="page-featured">
					<?php the_post_thumbnail( 'gulir_crop_o2', [ 'class' => 'featured-img' ] ); ?>
					<div class="single-header-overlay">
						<div class="<?php echo esc_attr( $classes ); ?>">
							<?php
							gulir_single_title();
							gulir_single_page_breadcrumb();
							?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_page_404' ) ) {
	function gulir_page_404() {

		$featured           = gulir_get_option( 'page_404_featured' );
		$dark_featured      = gulir_get_option( 'page_404_dark_featured' );
		$heading            = gulir_get_option( 'page_404_heading' );
		$description        = gulir_get_option( 'page_404_description' );
		$search             = gulir_get_option( 'page_404_search' );
		$template           = trim( gulir_get_option( 'page_404_template' ) );
		$template_w_content = gulir_get_option( 'page_404_template_w_content' );

		if ( ! empty( $template ) && empty( $template_w_content ) ) {
			gulir_blog_template( $template );

			return;
		}

		$class_name = 'page404-wrap rb-container edge-padding' . ( ! empty( $template ) ? ' has-404-template' : '' );

		if ( empty( $heading ) ) {
			$heading = gulir_html__( 'Something\'s wrong here...', 'gulir' );
		}
		if ( empty( $description ) ) {
			$description = gulir_html__( 'It looks like nothing was found at this location. The page you were looking for does not exist or was loading incorrectly.', 'gulir' );
		}
		?>
		<div class="<?php echo esc_attr( $class_name ); ?>">
			<div class="page404-inner">
				<?php if ( ! empty( $featured['url'] ) ) : ?>
					<div class="page404-featured">
						<?php if ( ! empty( $dark_featured['url'] ) ) : ?>
							<img data-mode="default" src="<?php echo esc_url( $featured['url'] ); ?>" alt="<?php echo esc_attr( $featured['alt'] ); ?>" height="<?php echo esc_attr( $featured['height'] ); ?>" width="<?php echo esc_attr( $featured['width'] ); ?>" />
							<img data-mode="dark" src="<?php echo esc_url( $dark_featured['url'] ); ?>" alt="<?php echo esc_attr( $dark_featured['alt'] ); ?>" height="<?php echo esc_attr( $dark_featured['height'] ); ?>" width="<?php echo esc_attr( $dark_featured['width'] ); ?>" />
						<?php else : ?>
							<img src="<?php echo esc_url( $featured['url'] ); ?>" alt="<?php echo esc_attr( $featured['alt'] ); ?>" height="<?php echo esc_attr( $featured['height'] ); ?>" width="<?php echo esc_attr( $featured['width'] ); ?>" />
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<h1 class="page-title"><?php echo esc_html( $heading ); ?></h1>
				<p class="page404-description"><?php echo esc_html( $description ); ?></p>
				<?php if ( ! empty( $search ) ) {
					get_search_form();
				} ?>
				<div class="page404-btn-wrap">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="page404-btn is-btn"><?php gulir_html_e( 'Return to Home', 'gulir' ); ?></a>
				</div>
			</div>
		</div>
		<?php
		if ( ! empty( $template ) ) {
			gulir_blog_template( $template );
		}
	}
}

if ( ! function_exists( 'gulir_single_page_breadcrumb' ) ) {
	function gulir_single_page_breadcrumb() {

		$setting = rb_get_meta( 'page_breadcrumb' );

		if ( ! empty( $setting ) && '-1' === (string) $setting ) {
			return;
		}

		if ( '1' === (string) $setting || ( gulir_get_option( 'single_page_breadcrumb' ) && gulir_get_option( 'breadcrumb' ) ) ) {
			if ( gulir_is_wc_pages() && function_exists( 'woocommerce_breadcrumb' ) ) {
				woocommerce_breadcrumb();
			} else {
				echo gulir_get_breadcrumb( 'page-breadcrumb', false );
			}
		}
	}
}