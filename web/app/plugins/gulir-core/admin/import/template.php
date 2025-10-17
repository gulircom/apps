<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( '<div class="notice notice-warning"><p>' . esc_html__( 'We\'re sorry, you are not authorized to install demos on this site.', 'gulir-core' ) . '</p></div>' );
}
?>
<div class="rb-dashboard-wrap rb-dashboard-importer">
	<div class="rb-dashboard-section rb-dashboard-fw">
		<div class="rb-intro-content yes-button">
			<div class="rb-intro-content-inner">
				<h2 class="rb-dashboard-title">
					<i class="rbi-dash rbi-dash-click" aria-hidden="true"></i><?php esc_html_e( 'Import a Prebuilt Website', 'gulir-core' ); ?>
				</h2>
				<p class="rb-dashboard-tagline"><?php esc_html_e( 'Allows you to quickly customize your site without building content from scratch.', 'gulir-core' ); ?></p>
			</div>
			<div class="rb-intro-buttons">
				<button class="rb-panel-button is-outlined" id="rb-cleanup-import"><i class="rbi-dash rbi-dash-broom"></i><?php esc_html_e( 'Cleanup Import', 'rb-importer' ); ?></button>
			</div>
		</div>
		<div class="rb-dashboard-tips">
			<p>
				<i class="dashicons dashicons-lightbulb"></i><?php esc_html_e( 'If the import process takes longer than 5 minutes, please refresh this page and try importing again!', 'gulir-core' ); ?>
			</p>
			<p>
				<i class="dashicons dashicons-info"></i><?php esc_html_e( 'We are unable to include certain demo images in the content due to copyright restrictions. As a result, the images may appear different from the demo. However, the demo structures will remain intact, and you can replace the images with your own if desired.', 'gulir-core' ); ?>
			</p>
		</div>
		<div class="rb-section-header">
			<h2><i class="rbi-dash rbi-dash-card"></i><?php esc_html_e( 'Prebuilt Websites', 'gulir-core' ); ?></h2>
			<div class="scs-form">
				<input id="rb-search-form" type="text" placeholder="<?php esc_html_e( 'Search demos...', 'gulir-core' ); ?>">
				<i class="rbi-dash rbi-dash-search"></i>
			</div>
		</div>
		<?php if ( ! empty( $demos ) && is_array( $demos ) ) : ?>
		<div class="rb-demos rb-search-area">
			<?php foreach ( $demos as $directory => $item ) :
				if ( ! empty( $item['imported'] ) && is_array( $item['imported'] ) ) {
					$item_classes   = 'rb-demo-item rb-search-item active is-imported';
					$import_message = esc_html__( 'Imported', 'gulir-core' );
				} else {
					$item_classes   = 'rb-demo-item rb-search-item not-imported';
					$import_message = '';
				} ?>
				<div class="<?php echo esc_attr( $item_classes ); ?>">
					<div class="inner-item">
						<div class="demo-preview">
							<img class="demo-image" src="<?php echo esc_html( $item['preview'] ); ?>" alt="<?php esc_attr( $item['name'] ); ?>"/>
						</div>
						<div class="demo-content">
							<div class="demo-name">
								<h3><i class="rbi-dash rbi-dash-laptop"></i><?php echo esc_html( $item['name'] ); ?></h3>
								<?php if ( ! empty( $import_message ) ) : ?>
									<p class="demo-status"><?php echo esc_html( $import_message ); ?></p>
								<?php endif; ?>
							</div>
							<div class="import-actions">
								<?php if ( ! empty( $item['demo_url'] ) ) : ?>
									<a class="rb-panel-button is-outlined" href="<?php echo $item['demo_url']; ?>" target="_blank" rel="nofollow"><i class="rbi-dash rbi-dash-external"></i><?php esc_html_e( 'Preview', 'gulir-core' ) ?>
									</a>
								<?php endif ?>
								<span class="rb-do-import rb-importer-btn" data-id="<?php echo esc_attr( $directory ); ?>"><?php esc_html_e( 'Import', 'gulir-core' ) ?></span>
							</div>
						</div>
					</div>
					<?php if ( ! empty( $item['keywords'] ) ) : ?>
						<p class="is-hidden search-keywords"><?php esc_html( $item['keywords'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php else: ?>
		<div class="rb-dashboard-tips is-error">
			<p><i class="dashicons dashicons-info"></i><?php esc_html_e( 'Something went wrong. Please click the "Reload" icon at the top right to reload the demos, or contact our support team for assistance.', 'gulir-core' ); ?></p>
		</div>
		<?php endif; ?>
	</div>
	<div id="rb-preview" class="rb-preview"></div>
	<div id="rb-importer" class="rb-importer"></div>
</div>
