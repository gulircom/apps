<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_header_t1' ) ) {
	function gulir_render_header_t1() {

		$settings                = gulir_get_header_settings( 'hd1' );
		$settings['transparent'] = true;
		$classes                 = 'header-wrap rb-section header-set-1 header-1 header-transparent';
		if ( ! empty( $settings['hd1_width'] ) ) {
			$classes .= ' header-fw';
		}
		?>
		<div id="site-header" class="<?php echo strip_tags( $classes ); ?>">
			<?php gulir_render_top_site();
			gulir_reading_process_indicator();
			?>
			<div id="navbar-outer" class="navbar-outer">
				<div id="sticky-holder" class="sticky-holder">
					<div class="navbar-wrap navbar-transparent">
						<div class="rb-container edge-padding">
							<div class="navbar-inner">
								<div class="navbar-left">
									<?php
									gulir_render_logo( $settings );
									gulir_render_main_menu( 'transparent-menu', $settings['sub_scheme'] );
									gulir_header_more( $settings );
									gulir_single_sticky();
									?>
								</div>
								<div class="navbar-right">
									<?php gulir_render_nav_right( $settings ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					gulir_header_mobile( $settings );
					gulir_header_alert( $settings );
					?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_render_header_t2' ) ) {
	function gulir_render_header_t2() {

		$settings                = gulir_get_header_settings( 'hd1' );
		$settings['transparent'] = true;
		$classes                 = 'header-wrap rb-section header-set-1 header-2 header-transparent';
		if ( ! empty( $settings['hd1_width'] ) ) {
			$classes .= ' header-fw';
		}
		?>
		<div id="site-header" class="<?php echo strip_tags( $classes ); ?>">
			<?php gulir_render_top_site();
			gulir_reading_process_indicator();
			?>
			<div id="navbar-outer" class="navbar-outer">
				<div id="sticky-holder" class="sticky-holder">
					<div class="navbar-wrap navbar-transparent">
						<div class="rb-container edge-padding">
							<div class="navbar-inner">
								<div class="navbar-left">
									<?php gulir_render_logo( $settings ); ?>
								</div>
								<div class="navbar-center">
									<?php
									gulir_render_main_menu( false, $settings['sub_scheme'] );
									gulir_header_more( $settings );
									gulir_single_sticky();
									?>
								</div>
								<div class="navbar-right">
									<?php gulir_render_nav_right( $settings ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					gulir_header_mobile( $settings );
					gulir_header_alert( $settings );
					?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_render_header_t3' ) ) {
	function gulir_render_header_t3() {

		$settings                = gulir_get_header_settings( 'hd1' );
		$settings['transparent'] = true;
		$classes                 = 'header-wrap rb-section header-set-1 header-3 header-transparent';
		if ( ! empty( $settings['hd1_width'] ) ) {
			$classes .= ' header-fw';
		}
		?>
		<div id="site-header" class="<?php echo strip_tags( $classes ); ?>">
			<?php gulir_render_top_site();
			gulir_reading_process_indicator();
			?>
			<div id="navbar-outer" class="navbar-outer">
				<div id="sticky-holder" class="sticky-holder">
					<div class="navbar-wrap navbar-transparent">
						<div class="rb-container edge-padding">
							<div class="navbar-inner">
								<div class="navbar-left">
									<?php
									gulir_render_logo( $settings );
									?>
								</div>
								<div class="navbar-center">
									<?php
									gulir_render_main_menu( false, $settings['sub_scheme'] );
									gulir_header_more( $settings );
									gulir_single_sticky();
									?>
								</div>
								<div class="navbar-right">
									<?php gulir_render_nav_right( $settings ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					gulir_header_mobile( $settings );
					gulir_header_alert( $settings );
					?>
				</div>
			</div>
		</div>
		<?php
	}
}