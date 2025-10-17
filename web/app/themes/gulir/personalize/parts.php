<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_bookmark_trigger' ) ) {
	function gulir_bookmark_trigger( $post_id = '' ) {

		echo gulir_get_bookmark_trigger( $post_id );
	}
}

if ( ! function_exists( 'gulir_follow_trigger' ) ) {
	function gulir_follow_trigger( $settings = [] ) {

		echo gulir_get_follow_trigger( $settings );
	}
}

if ( ! function_exists( 'gulir_get_bookmark_trigger' ) ) {
	function gulir_get_bookmark_trigger( $post_id = '' ) {

		if ( gulir_is_amp() || ! gulir_get_option( 'bookmark_system' ) ) {
			return false;
		}

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$output = '<span class="rb-bookmark bookmark-trigger"';
		if ( is_rtl() ) {
			$output .= ' dir="rtl"';
		}
		$output .= ' data-pid="' . $post_id . '"></span>';
		$output .= '';

		return $output;
	}
}

if ( ! function_exists( 'gulir_get_follow_trigger' ) ) {
	function gulir_get_follow_trigger( $settings = [] ) {

		if ( gulir_is_amp() || ! gulir_get_option( 'bookmark_system' ) ) {
			return false;
		}

		$classes   = [];
		$classes[] = 'rb-follow follow-trigger';
		$name      = ! empty( $settings['name'] ) ? $settings['name'] : get_cat_name( $settings['id'] );

		if ( ! empty( $settings['classes'] ) ) {
			$classes[] = $settings['classes'];
		}

		if ( ! empty( $settings['type'] ) && 'author' === $settings['type'] ) {
			$attrs = 'data-uid="' . $settings['id'] . '" data-name="' . get_the_author_meta( 'display_name', $settings['id'] ) . '"';
		} else {
			$attrs = 'data-cid="' . $settings['id'] . '" data-name="' . strip_tags( $name ) . '"';
		}

		return '<span class="' . join( ' ', $classes ) . '" ' . $attrs . '></span>';
	}
}

if ( ! function_exists( 'gulir_saved_empty' ) ) {
	function gulir_saved_empty() {
		?>
		<div class="empty-saved">
			<div class="rb-container edge-padding">
				<h4 class="empty-saved-title"><?php gulir_html_e( 'You haven\'t saved anything yet.', 'gulir' ); ?></h4>
				<p class="empty-saved-desc"><?php printf( gulir_html__( 'Start saving your interested articles by clicking the %s icon and you\'ll find them all here.', 'gulir' ), '<i class="rbi rbi-bookmark" aria-hidden="true"></i>' ); ?></p>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_saved_restrict_info' ) ) {
	function gulir_saved_restrict_info() {

		$title = gulir_get_option( 'bookmark_restrict_title' );
		$desc  = gulir_get_option( 'bookmark_restrict_desc' );
		if ( empty( $title ) ) {
			return;
		}
		?>
		<div class="empty-saved restricted">
			<div class="rb-container edge-padding">
				<h4 class="empty-saved-title"><?php gulir_render_inline_html( $title ); ?></h4>
				<?php if ( ! empty( $desc ) ) : ?>
					<p class="empty-saved-desc"><?php gulir_render_inline_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_reading_history_empty' ) ) {
	function gulir_reading_history_empty() {

		$title = gulir_get_option( 'reading_history_title' );
		$desc  = gulir_get_option( 'reading_history_desc' );
		if ( empty( $title ) ) {
			return;
		}
		?>
		<div class="empty-saved">
			<div class="rb-container edge-padding">
				<?php if ( current_user_can( 'manage_options' ) && ! gulir_get_option( 'reading_history' ) ) : ?>
					<p class="rb-error"><?php esc_html_e( 'Reading history is disabled. Please navigate to Theme Options > Personalized System > Read History to turn it on and activate this feature.', 'gulir' ); ?></p>
				<?php endif; ?>
				<h4 class="empty-saved-title"><?php gulir_render_inline_html( $title ); ?></h4>
				<?php if ( ! empty( $desc ) ) : ?>
					<p class="empty-saved-desc"><?php gulir_render_inline_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_bookmark_info_template' ) ) {
	function gulir_bookmark_info_template() {

		if ( ! gulir_get_option( 'bookmark_system' ) || gulir_is_amp() ) {
			return;
		}

		$disable_login_popup = gulir_get_option('disable_login_popup');
		?>
		<script type="text/template" id="bookmark-toggle-template">
			<i class="rbi rbi-bookmark" aria-hidden="true" data-title="<?php gulir_html_e( 'Save it', 'gulir' ) ?>"></i>
			<i class="bookmarked-icon rbi rbi-bookmark-fill" aria-hidden="true" data-title="<?php gulir_html_e( 'Undo Save', 'gulir' ); ?>"></i>
		</script>
		<script type="text/template" id="bookmark-ask-login-template">
			<a class="login-toggle"<?php if ( ! $disable_login_popup ) {
				echo ' role="button"';
			} ?> rel="nofollow" data-title="<?php gulir_html_e( 'Sign In to Save', 'gulir' ); ?>" href="<?php echo esc_url( wp_login_url( gulir_get_current_permalink() ) ); ?>"><i class="rbi rbi-bookmark" aria-hidden="true"></i></a>
		</script>
		<script type="text/template" id="follow-ask-login-template">
			<a class="login-toggle"<?php if ( ! $disable_login_popup ) {
				echo ' role="button"';
			} ?> rel="nofollow" data-title="<?php gulir_html_e( 'Sign In to Follow', 'gulir' ); ?>" href="<?php echo esc_url( wp_login_url( gulir_get_current_permalink() ) ); ?>"><i class="follow-icon rbi rbi-plus" data-title="<?php gulir_html_e( 'Sign In to Follow', 'gulir' ); ?>" aria-hidden="true"></i></a>
		</script>
		<script type="text/template" id="follow-toggle-template">
			<i class="follow-icon rbi rbi-plus" data-title="<?php gulir_html_e( 'Follow', 'gulir' ); ?>"></i>
			<i class="followed-icon rbi rbi-bookmark-fill" data-title="<?php gulir_html_e( 'Unfollow', 'gulir' ) ?>"></i>
		</script>
		<?php if ( gulir_get_option( 'bookmark_notification' ) ) : ?>
			<aside id="bookmark-notification" class="bookmark-notification"></aside>
			<script type="text/template" id="bookmark-notification-template">
				<div class="bookmark-notification-inner {{classes}}">
					<div class="bookmark-featured">{{image}}</div>
					<div class="bookmark-inner">
						<span class="bookmark-title h5">{{title}}</span><span class="bookmark-desc">{{description}}</span>
					</div>
				</div>
			</script>
			<script type="text/template" id="follow-notification-template">
				<div class="follow-info bookmark-notification-inner {{classes}}">
					<span class="follow-desc"><span>{{description}}</span><strong>{{name}}</strong></span>
				</div>
			</script>
		<?php
		endif;
	}
}