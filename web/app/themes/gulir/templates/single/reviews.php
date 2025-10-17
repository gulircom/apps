<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_single_review' ) ) {
	/**
	 * @param string $post_id
	 * @param false $is_shortcode
	 *
	 * @return false
	 */
	function gulir_single_review( $post_id = '', $is_shortcode = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$_post = get_post( $post_id );
		if ( false !== strpos( $_post->post_content, '[ruby_review_box]' ) && ! $is_shortcode ) {
			return false;
		}

		$settings = gulir_get_review_settings( $post_id );
		if ( empty( $settings ) || ! is_array( $settings ) ) {
			return false;
		}

		if ( empty( $settings['type'] ) || 'score' === $settings['type'] ) {
			gulir_single_review_score( $settings );
		} else {
			gulir_single_review_star( $settings );
		}
	}
}

if ( ! function_exists( 'gulir_single_review_score' ) ) {
	/**
	 * @param array $settings
	 */
	function gulir_single_review_score( $settings = [] ) { ?>
		<div class="review-section type-score">
			<div class="inner">
				<?php gulir_render_review_header( $settings ); ?>
				<div class="review-content">
					<?php if ( is_array( $settings['criteria'] ) ) :
						foreach ( $settings['criteria'] as $element ) :
							if ( empty( $element['label'] ) || empty( $element['rating'] ) ) {
								continue;
							}
							if ( $element['rating'] > 10 ) {
								$element['rating'] = 10;
							} elseif ( $element['rating'] < 1 ) {
								$element['rating'] = 1;
							} ?>
							<div class="review-el">
								<div class="review-label">
									<span class="review-label-info h4"><?php gulir_render_inline_html( $element['label'] ); ?></span>
									<span class="rating-info is-meta"><?php gulir_render_inline_html( $element['rating'] ) . ' ' . gulir_html__( 'out of 10', 'gulir' ); ?></span>
								</div>
								<span class="review-rating">
                                    <?php echo gulir_get_review_line( $element['rating'] ); ?>
                                </span>
							</div>
						<?php endforeach;
					endif; ?>
				</div>
				<div class="review-footer">
					<?php
					gulir_render_review_pros_cons( $settings );
					gulir_render_review_summary( $settings );
					gulir_render_review_rating( $settings )
					?>
				</div>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_single_review_star' ) ) {
	/**
	 * @param array $settings
	 */
	function gulir_single_review_star( $settings = [] ) { ?>
		<div class="review-section type-star">
			<div class="inner">
				<?php gulir_render_review_header( $settings ); ?>
				<div class="review-content">
					<?php if ( is_array( $settings['criteria'] ) ) :
						foreach ( $settings['criteria'] as $element ) :
							if ( empty( $element['label'] ) || empty( $element['rating'] ) ) {
								continue;
							}
							if ( $element['rating'] > 5 ) {
								$element['rating'] = 5;
							} elseif ( $element['rating'] < 1 ) {
								$element['rating'] = 1;
							} ?>
							<div class="review-el">
								<div class="review-label">
									<span class="review-label-info h4"><?php gulir_render_inline_html( $element['label'] ); ?></span>
									<span class="rating-info is-meta"><?php gulir_render_inline_html( $element['rating'] ) . ' ' . gulir_html__( 'out of 5', 'gulir' ); ?></span>
								</div>
								<span class="review-rating">
                                    <?php echo gulir_get_review_stars( $element['rating'] ); ?>
                                </span>
							</div>
						<?php endforeach;
					endif; ?>
				</div>
				<div class="review-footer">
					<?php
					gulir_render_review_pros_cons( $settings );
					gulir_render_review_summary( $settings );
					gulir_render_review_rating( $settings )
					?>
				</div>
			</div>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_render_review_header' ) ) {
	/**
	 * @param array $settings
	 */
	function gulir_render_review_header( $settings = [] ) { ?>
		<div class="review-header review-intro">
			<?php if ( ! empty( $settings['image'] ) ) : ?>
				<div class="review-bg">
					<?php if ( ! is_array( $settings['image'] ) ) : ?>
						<?php echo wp_get_attachment_image( $settings['image'], 'full' ); ?>
					<?php elseif ( ! empty( $settings['image']['url'] ) ) : ?>
						<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo strip_tags( $settings['image']['alt'] ); ?>" height="<?php echo strip_tags( $settings['image']['height'] ); ?>" width="<?php echo strip_tags( $settings['image']['width'] ); ?>">
					<?php endif ?>
				</div>
			<?php endif; ?>
			<div class="inner light-scheme">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<div class="review-heading">
						<span class="h2"><?php gulir_render_inline_html( $settings['title'] ); ?></span>
					</div>
				<?php endif; ?>
				<div class="meta-info">
					<?php if ( ! empty( $settings['average'] ) ) :
						if ( 'star' === $settings['type'] )  :
							echo gulir_get_review_stars( $settings['average'] );
						else:
							echo gulir_get_review_line( $settings['average'] );
						endif;
						?><span class="average"><?php if ( ! empty( $settings['meta'] ) ) : ?>
						<span class="meta-text"><span class="meta-description"><?php gulir_render_inline_html( $settings['meta'] ); ?></span></span>
					<?php endif; ?><span class="h1"><?php gulir_render_inline_html( $settings['average'] ); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_render_review_pros_cons' ) ) {
	function gulir_render_review_pros_cons( $settings = [] ) {

		if ( empty( $settings['pros'] ) && empty( $settings['cons'] ) ) {
			return;
		}

		$pros_label = ! empty( $settings['pros_label'] ) ? $settings['pros_label'] : gulir_html__( 'Good Stuff', 'gulir' );
		$cons_label = ! empty( $settings['cons_label'] ) ? $settings['cons_label'] : gulir_html__( 'Bad Stuff', 'gulir' );
		$class_name = 'pros-cons' . ( ! empty( $settings['classes'] ) ? ' ' . $settings['classes'] : '' ) . ' stuff-col-' . gulir_get_option( 'single_post_review_stuff_cols', 2 );
		?>
		<div class="<?php echo strip_tags( $class_name ); ?>">
			<div class="pros-cons-holder">
				<?php if ( is_array( $settings['pros'] ) ) : ?>
					<div class="pros-list-wrap">
						<div class="pros-cons-list-inner">
							<span class="pros-cons-title h4"><i class="rbi rbi-like"></i><?php echo strip_tags( $pros_label ); ?></span>
							<?php foreach ( $settings['pros'] as $item ) :
								if ( ! empty( $item['pros_item'] ) ) :?>
									<span class="pros-cons-el"><?php gulir_render_inline_html( $item['pros_item'] ); ?></span>
								<?php endif;
							endforeach; ?>
						</div>
					</div>
				<?php endif;
				if ( is_array( $settings['cons'] ) ) : ?>
					<div class="cons-list-wrap">
						<div class="pros-cons-list-inner">
							<span class="pros-cons-title h4"><i class="rbi rbi-dislike"></i><?php echo strip_tags( $cons_label ); ?></span>
							<?php foreach ( $settings['cons'] as $item ) :
								if ( ! empty( $item['cons_item'] ) ) :?>
									<span class="pros-cons-el"><?php gulir_render_inline_html( $item['cons_item'] ); ?></span>
								<?php endif;
							endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_render_review_summary' ) ) {
	function gulir_render_review_summary( $settings = [] ) {

		if ( ! empty( $settings['summary'] ) )  : ?>
			<div class="summary-wrap">
				<span class="h3 review-summary-title"><?php gulir_html_e( 'Summary', 'gulir' ); ?></span>
				<div class="summary-content rb-text">
					<?php gulir_render_inline_html( $settings['summary'] ); ?>
				</div>
			</div>
		<?php endif;
		if ( ! empty( $settings['button'] ) && ! empty( $settings['destination'] ) ) : ?>
			<div class="review-action">
				<a class="review-btn is-btn" href="<?php echo esc_url( $settings['destination'] ); ?>" target="_blank" rel="nofollow noopener"><?php gulir_render_inline_html( $settings['button'] ); ?></a>
			</div>
		<?php endif;
	}
}

if ( ! function_exists( 'gulir_render_review_rating' ) ) {
	function gulir_render_review_rating( $settings = [] ) {

		if ( empty( $settings['user_rating']['count'] ) || empty( $settings['user_rating']['average'] ) || empty( $settings['type'] ) ) {
			return;
		} ?>
		<div class="user-rating">
			<div class="rating-header">
				<i class="rbi rbi-like"></i><span class="h4"><?php echo gulir_html__( 'User Votes', 'gulir' ); ?></span>
				<?php if ( ! empty( $settings['user_rating']['count'] ) ) :
					if ( '1' === (string) $settings['user_rating']['count'] ) {
						$vote_output = $settings['user_rating']['count'] . ' ' . gulir_html__( 'vote', 'gulir' );
					} else {
						$vote_output = $settings['user_rating']['count'] . ' ' . gulir_html__( 'votes', 'gulir' );
					}
					?><span class="total-vote is-meta"><?php echo '(' . strip_tags( $vote_output ) . ')'; ?></span>
				<?php endif; ?>
			</div>
			<div class="average-info">
				<?php echo gulir_get_review_stars( $settings['user_rating']['average'] ); ?>
			</div>
		</div>
		<?php
	}
}
