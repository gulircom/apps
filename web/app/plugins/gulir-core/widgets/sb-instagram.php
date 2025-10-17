<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_W_Instagram' ) ) {
	class Gulir_W_Instagram extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-sb-instagram';

		function __construct() {

			$this->params = [
				'title'           => 'Instagram',
				'instagram_token' => '',
				'total_images'    => 9,
				'total_cols'      => 'rb-c3',
				'footer_intro'    => 'Follow Us on @ Instagram',
				'footer_url'      => '#',
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Widget Instagram', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display a grid of instagram images in the sidebar.', 'gulir-core' ),
			] );
		}

		function update( $new_instance, $old_instance ) {

			if ( current_user_can( 'unfiltered_html' ) ) {
				return wp_parse_args( (array) $new_instance, $this->params );
			} else {
				$instance = [];
				foreach ( $new_instance as $id => $value ) {
					$instance[ $id ] = sanitize_text_field( $value );
				}

				return wp_parse_args( $instance, $this->params );
			}
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'title' ),
				'name'  => $this->get_field_name( 'title' ),
				'title' => esc_html__( 'Title', 'gulir-core' ),
				'value' => $instance['title'],
			] );

			gulir_create_widget_textarea_field( [
				'id'          => $this->get_field_id( 'instagram_token' ),
				'name'        => $this->get_field_name( 'instagram_token' ),
				'title'       => esc_html__( 'Input Instagram Token', 'gulir-core' ),
				'description' => esc_html__( 'Refer to this <a target="_blank" href="//help.luncur.com/gulir/how-to-create-a-new-instagram-access-token/">Documentation</a> to create an Instagram token', 'gulir-core' ),
				'value'       => $instance['instagram_token'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'total_images' ),
				'name'  => $this->get_field_name( 'total_images' ),
				'title' => esc_html__( 'Default Grid - Total Images', 'gulir-core' ),
				'value' => $instance['total_images'],
			] );

			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'total_cols' ),
				'name'    => $this->get_field_name( 'total_cols' ),
				'title'   => esc_html__( 'Style', 'gulir-core' ),
				'options' => [
					'rb-c2' => esc_html__( '2 columns', 'gulir-core' ),
					'rb-c3' => esc_html__( '3 columns', 'gulir-core' ),
					'rb-c4' => esc_html__( '4 columns', 'gulir-core' ),
				],
				'value'   => $instance['total_cols'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'footer_intro' ),
				'name'  => $this->get_field_name( 'footer_intro' ),
				'title' => esc_html__( 'Footer Description', 'gulir-core' ),
				'desc'  => esc_html__( 'Input a short description to display at the footer, raw HTML allowed.', 'gulir-core' ),
				'value' => $instance['footer_intro'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'footer_url' ),
				'name'  => $this->get_field_name( 'footer_url' ),
				'title' => esc_html__( 'Footer Link', 'gulir-core' ),
				'value' => $instance['footer_url'],
			] );
		}

		function widget( $args, $instance ) {

			$instance             = wp_parse_args( (array) $instance, $this->params );
			$instance['cache_id'] = $args['widget_id'];

			echo $args['before_widget'];

			$data_images = $this->gulir_data_instagram_token( $instance );

			if ( ! empty( $data_images['error'] ) ) :
				if ( current_user_can( 'manage_options' ) ) :
					echo '<div class="rb-error"><strong>' . esc_html__( 'Instagram Error: ', 'gulir-core' ) . '</strong>' . gulir_strip_tags( $data_images['error'] ) . '</div>';
				endif;
			else :
				if ( ! empty( $instance['title'] ) ) {
					echo $args['before_title'] . gulir_strip_tags( $instance['title'] ) . $args['after_title'];
				} ?>
				<div class="sb-instagram-grid">
					<?php $data_images = array_slice( $data_images, 0, $instance['total_images'] ); ?>
					<div class="grid-holder <?php echo strip_tags( $instance['total_cols'] ) ?>">
						<?php foreach ( $data_images as $image ) : ?>
							<div class="grid-el">
								<?php if ( ! empty( $image['thumbnail_src'] ) ) :
									$image_size = gulir_get_asset_image( $image['thumbnail_src'] );
									?>
									<div class="instagram-box">
										<a href="<?php echo esc_url( $image['link'] ); ?>" target="_blank" rel="noopener nofollow">
											<?php if ( $image['media'] === "VIDEO" && $image['media'] !== "IMAGE" ) : ?>
												<video>
													<source src="<?php echo esc_url( $image['thumbnail_src'] ) ?>" type="video/mp4">
												</video>
											<?php else : ?>
												<img loading="lazy" decoding="async" src="<?php echo esc_url( $image['thumbnail_src'] ); ?>" alt="<?php echo strip_tags( $image['caption'] ); ?>" width="<?php if ( ! empty( $image_size[0] ) ) {
													echo strip_tags( $image_size[0] );
												} ?>" height="<?php if ( ! empty( $image_size[1] ) ) {
													echo strip_tags( $image_size[1] );
												} ?>">
											<?php endif; ?>
										</a>
										<div class="box-content">
											<?php if ( ! empty( $image['likes'] ) ) : ?>
												<span class="likes"><i class="rbi rbi-heart"></i><?php echo strip_tags( $image['likes'] ); ?></span>
											<?php endif;
											if ( ! empty( $image['comments'] ) ) : ?>
												<span class="comments"><i class="rbi rbi-chat-bubble"></i><?php gulir_render_inline_html( $image['comments'] ); ?></span>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<?php if ( ! empty( $instance['footer_intro'] ) ) : ?>
						<div class="grid-footer">
							<a href="<?php echo esc_url( $instance['footer_url'] ); ?>" target="_blank" rel="noopener nofollow"><?php gulir_render_inline_html( $instance['footer_intro'] ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif;
			echo $args['after_widget'];
		}

		function gulir_data_instagram_token( $settings = [] ) {

			$cache_name  = 'gulir_sb_instagram_cache';
			$cache_data  = get_transient( $cache_name );
			$data_images = [];
			$cache_id    = 0;

			if ( empty( $settings['instagram_token'] ) ) {
				$data_images['error'] = esc_html__( 'Instagram token not found', 'gulir-core' );

				return $data_images;
			}

			if ( ! empty( $settings['cache_id'] ) ) {
				$cache_id = $settings['cache_id'];
			}
			if ( empty( $cache_data ) || ! is_array( $cache_data ) ) {
				$cache_data = [];
			}

			if ( ! empty( $cache_data[ $cache_id ] ) ) {
				return $cache_data[ $cache_id ];
			} else {
				$url      = 'https://graph.instagram.com/me/media?fields=id,caption,media_url,permalink,media_type&access_token=' . trim( $settings['instagram_token'] );
				$response = wp_remote_get( $url, [
					'sslverify' => false,
					'timeout'   => 30,
				] );

				if ( is_wp_error( $response ) || empty( $response['response']['code'] ) || 200 !== $response['response']['code'] ) {
					$response = json_decode( wp_remote_retrieve_body( $response ) );
					if ( ! empty( $response->error->message ) ) {
						$data_images['error'] = gulir_strip_tags( $response->error->message );
					} else {
						$data_images['error'] = esc_html__( 'Could not connect to Instagram API server.', 'gulir-core' );
					}

					return $data_images;
				}

				$response = json_decode( wp_remote_retrieve_body( $response ) );
				if ( ! empty( $response->data ) && is_array( $response->data ) ) {
					foreach ( $response->data as $image ) {

						$caption   = esc_html__( 'instagram image', 'gulir-core' );
						$link      = '#';
						$likes     = '';
						$comments  = '';
						$thumbnail = '#';
						$media     = '';

						if ( ! empty( $image->permalink ) ) {
							$link = esc_url( $image->permalink );
						}

						if ( ! empty( $image->media_url ) ) {
							$thumbnail = esc_url( $image->media_url );
						}

						if ( ! empty( $image->media_type ) ) {
							$media = esc_html( $image->media_type );
						}

						if ( ! empty( $image->$caption ) ) {
							$caption = $image->$caption;
						}

						$data_images[] = [
							'thumbnail_src' => $thumbnail,
							'caption'       => $caption,
							'link'          => $link,
							'likes'         => $likes,
							'comments'      => $comments,
							'media'         => $media,
						];
					}

					$cache_data[ $cache_id ] = $data_images;
					delete_transient( $cache_name );
					set_transient( $cache_name, $cache_data, 21600 );
				} else {
					$data_images['error'] = esc_html__( 'Token did not work or has expired, Try to create a new token.', 'gulir-core' );
				}

				return $data_images;
			}
		}
	}
}