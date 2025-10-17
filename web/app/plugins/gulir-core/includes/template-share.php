<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_render_share_list' ) ) {
	function gulir_render_share_list( $settings = [] ) {

		if ( ! empty( $settings['post_id'] ) ) {
			$post_id = $settings['post_id'];
		} else {
			$post_id = get_the_ID();
		}

		$twitter_user = gulir_get_twitter_name();
		$post_title   = urlencode( html_entity_decode( get_the_title( $post_id ), ENT_COMPAT, 'UTF-8' ) );

		if ( function_exists( 'wpme_get_shortlink' ) ) {
			$permalink = wpme_get_shortlink( $post_id );
		}
		if ( empty( $permalink ) ) {
			$permalink = get_permalink( $post_id );
		}
		$tipsy_gravity = '';
		if ( ! empty( $settings['tipsy_gravity'] ) ) {
			$tipsy_gravity = ' data-gravity=' . $settings['tipsy_gravity'] . ' ';
		}
		if ( ! empty( $settings['facebook'] ) ) : ?>
			<a class="share-action share-trigger icon-facebook" aria-label="<?php esc_attr_e( 'Share on Facebook', 'gulir-core' ); ?>" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( $permalink ); ?>" data-title="Facebook"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-facebook" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Facebook', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['twitter'] ) ) : ?>
		<a class="share-action share-trigger icon-twitter" aria-label="<?php esc_attr_e( 'Share on X', 'gulir-core' ); ?>" href="https://twitter.com/intent/tweet?text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>&amp;url=<?php echo urlencode( $permalink ); ?>&amp;via=<?php echo urlencode( $twitter_user ); ?>" data-title="X"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener">
			<i class="rbi rbi-twitter" aria-hidden="true"></i></a>
		<?php endif;

		if ( ! empty( $settings['flipboard'] ) ) :
			?>
			<a class="share-action share-trigger icon-flipboard" aria-label="<?php esc_attr_e( 'Share on Flipboard', 'gulir-core' ); ?>" href="https://share.flipboard.com/bookmarklet/popout?url=<?php echo urlencode( $permalink ); ?>" data-title="Flipboard"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener">
				<i class="rbi rbi-flipboard" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Flipboard', 'gulir-core' ) . '</span>';
				} ?>
			</a>
		<?php endif;
		if ( ! empty( $settings['pinterest'] ) ) :
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'gulir_780x0-2x' );
			if ( gulir_is_plugin_active( 'wordpress-seo/wp-seo.php' ) && get_post_meta( $post_id, '_yoast_wpseo_metadesc', true ) !== '' ) {
				$pinterest_description = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true );
			} else {
				$pinterest_description = $post_title;
			} ?>
			<a class="share-action share-trigger share-trigger icon-pinterest" aria-label="<?php esc_attr_e( 'Share on Pinterest', 'gulir-core' ); ?>" rel="nofollow noopener" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode( $permalink ); ?>&amp;media=<?php if ( ! empty( $image[0] ) ) {
				echo( esc_url( $image[0] ) );
			} ?>&amp;description=<?php echo htmlspecialchars( $pinterest_description, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Pinterest"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-pinterest" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Pinterest', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['whatsapp'] ) ) : ?>
			<a class="share-action icon-whatsapp is-web" aria-label="<?php esc_attr_e( 'Share on Whatsapp', 'gulir-core' ); ?>" href="https://web.whatsapp.com/send?text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ) . ' &#9758; ' . urlencode( $permalink ); ?>" target="_blank" data-title="WhatsApp"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-whatsapp" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Whatsapp', 'gulir-core' ) . '</span>';
				} ?></a>
			<a class="share-action icon-whatsapp is-mobile" aria-label="<?php esc_attr_e( 'Share on Whatsapp', 'gulir-core' ); ?>" href="whatsapp://send?text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ) . ' &#9758; ' . urlencode( $permalink ); ?>" target="_blank" data-title="WhatsApp"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-whatsapp" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Whatsapp', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['linkedin'] ) ) : ?>
			<a class="share-action share-trigger icon-linkedin" aria-label="<?php esc_attr_e( 'Share on Linkedin', 'gulir-core' ); ?>" href="https://linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( $permalink ); ?>&amp;title=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="linkedIn"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-linkedin" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'LinkedIn', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['tumblr'] ) ) : ?>
			<a class="share-action share-trigger icon-tumblr" aria-label="<?php esc_attr_e( 'Share on Tumblr', 'gulir-core' ); ?>" href="https://www.tumblr.com/share/link?url=<?php echo urlencode( $permalink ); ?>&amp;name=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>&amp;description=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Tumblr"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-tumblr" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Tumblr', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['reddit'] ) ) : ?>
			<a class="share-action share-trigger icon-reddit" aria-label="<?php esc_attr_e( 'Share on Reddit', 'gulir-core' ); ?>" href="https://www.reddit.com/submit?url=<?php echo urlencode( $permalink ); ?>&amp;title=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Reddit"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-reddit" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Reddit', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['vk'] ) ) : ?>
			<a class="share-action share-trigger icon-vk" aria-label="<?php esc_attr_e( 'Share on VKontakte', 'gulir-core' ); ?>" href="https://vkontakte.ru/share.php?url=<?php echo urlencode( $permalink ); ?>" data-title="VKontakte" rel="nofollow noopener"><i class="rbi rbi-vk" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'VKontakte', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['telegram'] ) ) : ?>
			<a class="share-action share-trigger icon-telegram" aria-label="<?php esc_attr_e( 'Share on Telegram', 'gulir-core' ); ?>" href="https://t.me/share/?url=<?php echo urlencode( $permalink ); ?>&amp;text=<?php echo htmlspecialchars( $post_title, ENT_COMPAT, 'UTF-8' ); ?>" data-title="Telegram"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener"><i class="rbi rbi-telegram" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Telegram', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['threads'] ) ) : ?>
			<a class="share-action share-trigger icon-threads" aria-label="<?php esc_attr_e( 'Share on Threads', 'gulir-core' ); ?>" href="https://threads.net/intent/post?text=<?php echo htmlspecialchars( $post_title . ' ', ENT_COMPAT, 'UTF-8' ) . urlencode( $permalink ); ?>" data-title="Threads"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener">
				<i class="rbi rbi-threads" aria-hidden="true"></i>
				<?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Threads', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['bsky'] ) ) : ?>
			<a class="share-action share-trigger icon-bluesky" aria-label="<?php esc_attr_e( 'Share on Bluesky', 'gulir-core' ); ?>" href="https://bsky.app/share?text=<?php echo htmlspecialchars( $post_title . ' ', ENT_COMPAT, 'UTF-8' ) . urlencode( $permalink ); ?>" data-title="Bluesky"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow noopener">
				<i class="rbi rbi-bluesky" aria-hidden="true"></i>
				<?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Bluesky', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['email'] ) ) :
			$subject = get_the_title( $post_id ) . ' | ' . get_bloginfo( 'name' );

			$body = strip_tags( rb_get_meta( 'tagline', $post_id ) );
			if ( empty( $body ) ) {
				$body = gulir_html__( 'I found this article interesting and thought of sharing it with you. Check it out:', 'gulir-core' );
			}
			?>
			<a class="share-action icon-email" aria-label="<?php esc_attr_e( 'Email', 'gulir-core' ); ?>" href="<?php echo sprintf( 'mailto:?subject=%s&body=%s', htmlspecialchars( $subject, ENT_COMPAT, 'UTF-8' ), htmlspecialchars( $body , ENT_COMPAT, 'UTF-8' ) . urlencode( "\n\n" . $permalink ) ); ?>" data-title="Email"<?php echo esc_html( $tipsy_gravity ); ?> rel="nofollow">
			<i class="rbi rbi-email" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Email', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;

		if ( ! empty( $settings['copy'] ) && ! gulir_is_amp() ) : ?>
			<a class="share-action icon-copy copy-trigger" aria-label="<?php esc_attr_e( 'Copy Link', 'gulir-core' ); ?>" href="#" rel="nofollow" role="button" data-copied="<?php gulir_attr_e( 'Copied!', 'gulir-core' ); ?>" data-link="<?php echo esc_url( $permalink ); ?>" data-copy="<?php gulir_html_e( 'Copy Link' ); ?>"<?php echo esc_html( $tipsy_gravity ); ?>><i class="rbi rbi-link-o" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Copy Link', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;
		if ( ! empty( $settings['print'] ) && ! gulir_is_amp() ) : ?>
			<a class="share-action icon-print" aria-label="<?php esc_attr_e( 'Print', 'gulir-core' ); ?>" rel="nofollow" role="button" href="javascript:if(window.print)window.print()" data-title="<?php gulir_html_e( 'Print' ); ?>"<?php echo esc_html( $tipsy_gravity ); ?>><i class="rbi rbi-print" aria-hidden="true"></i><?php if ( ! empty( $settings['social_name'] ) ) {
					echo '<span>' . gulir_html__( 'Print', 'gulir-core' ) . '</span>';
				} ?></a>
		<?php endif;
		if ( ! empty( $settings['native'] ) && ! gulir_is_amp() ) : ?>
			<a class="share-action native-share-trigger more-icon" aria-label="<?php esc_attr_e( 'More', 'gulir-core' ); ?>" href="#" rel="nofollow" role="button" data-link="<?php echo esc_url( $permalink ); ?>" data-ptitle="<?php echo esc_attr( get_the_title() ) ?>" data-title="<?php gulir_html_e( 'More', 'gulir-core' ); ?>" <?php echo esc_html( $tipsy_gravity ); ?>><i class="rbi rbi-more" aria-hidden="true"></i></a>
		<?php endif;
	}
}