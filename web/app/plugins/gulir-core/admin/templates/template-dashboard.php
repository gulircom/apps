<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;
?>
<div class="rb-dashboard-wrap">
	<div class="rb-dashboard-intro rb-dashboard-section rb-dashboard-fw">
		<div class="rb-intro-content">
			<div class="rb-intro-content-inner">
				<h1 class="rb-dashboard-headline">
					<i class="rbi-dash rbi-dash-license" aria-hidden="true"></i><?php esc_html_e( 'Welcome to Gulir', 'gulir-core' ); ?>
				</h1>
				<p class="rb-dashboard-tagline"><?php esc_html_e( 'Gulir is all set up! Begin crafting something remarkable. We’re excited for you to use it!', 'gulir-core' ); ?></p>
			</div>
			<div class="rb-intro-featured">
				<img src="<?php echo GULIR_CORE_URL . 'admin/assets/dashboard.jpg'; ?>" alt="<?php esc_html_e( 'Home', 'gulir-core' ); ?>">
			</div>
		</div>
		<div class="rb-dashboard-steps">
			<div class="rb-dashboard-step is-checked">
				<h3><?php esc_html_e( 'Register Your Website', 'gulir-core' ); ?></h3>
				<p class="rb-dashboard-desc"><?php esc_html_e( 'Start by registering your sites to initiate the setup procedure.', 'gulir-core' ); ?></p>
				<div class="rb-step-icon"><i class="rbi-dash rbi-dash-check"></i></div>
			</div>
			<?php
			$class_import_step = get_option('_rb_flag_imported', false) ? 'rb-dashboard-step is-checked' : 'rb-dashboard-step';
			?>
			<a class="<?php echo esc_attr($class_import_step); ?>" href="<?php echo ! empty( $menu['import']['url'] ) ? esc_url( $menu['import']['url'] ) : '#'; ?>">
				<h3><?php esc_html_e( 'Select a Rebuild Website', 'gulir-core' ); ?></h3>
				<p class="rb-dashboard-desc"><?php esc_html_e( 'Select a rebuilt website to import and update your site\'s look.', 'gulir-core' ); ?></p>
				<div class="rb-step-icon is-checked"><i class="rbi-dash rbi-dash-layer"></i></div>
			</a>
			<a class="rb-dashboard-step" href="<?php echo ! empty( $menu['options']['url'] ) ? esc_url( $menu['options']['url'] ) : '#'; ?>">
				<h3><?php esc_html_e( 'Personalize Your Website', 'gulir-core' ); ?></h3>
				<p class="rb-dashboard-desc"><?php esc_html_e( 'Adjust your site\'s design and features to align with your preferences and requirements.', 'gulir-core' ); ?></p>
				<div class="rb-step-icon is-checked"><i class="rbi-dash rbi-dash-arrow-right"></i></div>
			</a>
		</div>
	</div>
	<div class="rb-dashboard-section rb-dashboard-fw">
		<div class="rb-section-header"><h2>
				<i class="rbi-dash rbi-dash-phpinfo"></i><?php esc_html_e( 'PHP Information', 'gulir-core' ); ?></h2>
		</div>
		<div class="rb-info-content">
			<?php if ( ! empty( $system_info ) && is_array( $system_info ) ) :
				foreach ( $system_info as $info => $val ) :
					$class_name = 'info-el';
					if ( isset( $val['passed'] ) && ! $val['passed'] ) {
						$class_name .= ' is-warning';
					} ?>
					<div class="<?php echo esc_attr( $class_name ); ?>">
						<div class="info-content">
							<span class="info-label"><?php echo esc_attr( $val['title'] ) ?></span>
							<span class="info-value"><?php echo esc_attr( $val['value'] ) ?></span>
						</div>
						<?php if ( isset( $val['passed'] ) && ! $val['passed'] ) : ?>
							<span class="info-warning"><?php echo esc_attr( $val['warning'] ) ?></span>
						<?php endif; ?>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
</div>