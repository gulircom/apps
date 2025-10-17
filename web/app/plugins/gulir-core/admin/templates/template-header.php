<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

$theme_ver = esc_html__( 'Ver: ', 'gulir-core' ) . ( defined( 'GULIR_THEME_VERSION' ) ? GULIR_THEME_VERSION : GULIR_CORE_VERSION );
$query_str = isset( $_SERVER['QUERY_STRING'] ) ? $_SERVER['QUERY_STRING'] : '';
$reload = ! empty( $status ) && preg_match( '/gulir-admin|rb-demo-importer|ruby-gmt-integration|ruby-system-info|ruby-adobe-fonts|ruby-translation/', $query_str );

?>
<div class="rb-dashboard-header">
	<div class="rb-dashboard-header-inner">
		<div class="rb-dashboard-topbar">
			<div class="rb-dashboard-topbar-left">
				<div class="rb-dashboard-logo">
					<i class="rbi-dash rbi-dash-brand"></i>
					<h2 class="rb-theme-name"><?php echo esc_html( $title ); ?></h2>
				</div>
				<div class="rb-dashboard-meta rb-ver"><?php echo esc_html( $theme_ver ); ?></div>
				<?php if ( empty( $status ) ) : ?>
					<h3 class="rb-theme-status is-unregistered"><?php esc_html_e( 'Unregistered', 'gulir-core' ); ?></h3>
				<?php elseif ( 'unset' !== $status ) : ?>
					<h3 class="rb-theme-status is-registered"><?php esc_html_e( 'Registered', 'gulir-core' ); ?></h3>
				<?php else : ?>
					<h3 class="rb-theme-status is-error"><?php esc_html_e( 'Verification Failed', 'gulir-core' ); ?></h3>
					<span class="rb-tooltip">
						<i class="rbi-dash rbi-dash-info"></i>
						<div class="rb-tooltip-content"><?php esc_html_e( 'It seems an error occurred while validating. Please try to register the theme again or contact support for assistance.', 'gulir-core' ); ?></div>
          </span>
				<?php endif; ?>
			</div>
			<div class="rb-links">
				<a href="https://luncur.com" target="_blank"><?php esc_html_e( 'Themes', 'gulir-core' ) ?></a>
				<a href="https://help.luncur.com/gulir/" target="_blank"><?php esc_html_e( 'Documentation', 'gulir-core' ) ?></a>
				<a href="https://luncur.ticksy.com/" target="_blank"><?php esc_html_e( 'Open a Ticket', 'gulir-core' ) ?></a>
				<a href="https://gulir.luncur.com/whats-new/" class="rb-dashboard-changelog" target="_blank"><i class="rbi-dash rbi-dash-horn"></i><?php esc_html_e( 'What\'s new', 'gulir-core' ); ?>
				</a>
			</div>
		</div>
		<div class="rbi-dashboard-menu-wrap">
			<div class="rb-dashboard-menu">
				<?php
				if ( ! empty( $menu ) && is_array( $menu ) ) :
					$menu = apply_filters( 'ruby_dashboard_menu', $menu );
					foreach ( $menu as $key => $menu_item ) :
						if ( empty( $key ) ) {
							continue;
						}
						$class_name = strpos( $menu_item['url'], $query_str ) ? 'rb-menu-item active' : 'rb-menu-item';
						if ( empty( $menu_item['sub_items'] ) || ! is_array( $menu_item['sub_items'] ) ) : ?>
							<a class="<?php echo esc_attr( $class_name ); ?>" href="<?php echo esc_url( $menu_item['url'] ); ?>">
								<i class="rbi-dash <?php echo esc_attr( $menu_item['icon'] ); ?>"></i>
								<?php echo esc_html( $menu_item['title'] ); ?></a>
						<?php else: ?>
							<div class="rb-menu-has-child">
								<a class="<?php echo esc_attr( $class_name ); ?>" href="<?php echo esc_url( $menu_item['url'] ); ?>">
									<i class="rbi-dash <?php echo esc_attr( $menu_item['icon'] ); ?>"></i>
									<?php echo esc_html( $menu_item['title'] ); ?></a>
								<div class="rb-submenu-items">
									<?php foreach ( $menu_item['sub_items'] as $sub_item ) :
										$class_name = strpos( $sub_item['url'], $query_str ) ? 'rb-submenu-item active' : 'rb-submenu-item';
										?>
										<a class="<?php echo esc_attr( $class_name ); ?>" href="<?php echo esc_url( $sub_item['url'] ); ?>">
											<i class="rbi-dash <?php echo esc_attr( $sub_item['icon'] ); ?>"></i>
											<?php echo esc_html( $sub_item['title'] ); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach;
				endif; ?>
			</div>
			<div class="rb-dashboard-menu-right">
					<div class="rb-dashboard-meta"><?php
						echo esc_html__( 'Supported Until: ', 'gulir-core' ) . '<span class="is-valid">' . date( 'F j, Y' ) . '</span>'
						?>
						</div>


				<a class="buy-now-btn" target="_blank" rel="nofollow" href="//luncur.com/" aria-label="buy now"><i class="rbi-dash rbi-dash-bag"></i><?php esc_html_e( 'Buy License', 'gulir-core' ); ?></a>
			</div>
		</div>
	</div>
</div>
<div class="wrap"><h2></h2></div>
