<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_W_Social_Icon', false ) ) {
	class Gulir_W_Social_Icon extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-social-icon';

		function __construct() {

			$this->params = [
				'title'          => 'Find Us on Socials',
				'content'        => '',
				'new_tab'        => true,
				'style'          => 1,
				'data_social'    => 1,
				'facebook'       => '',
				'twitter'        => '',
				'youtube'        => '',
				'googlenews'     => '',
				'instagram'      => '',
				'pinterest'      => '',
				'tiktok'         => '',
				'linkedin'       => '',
				'medium'         => '',
				'flipboard'      => '',
				'twitch'         => '',
				'steam'          => '',
				'tumblr'         => '',
				'discord'        => '',
				'skype'          => '',
				'snapchat'       => '',
				'quora'          => '',
				'spotify'        => '',
				'apple_podcast'  => '',
				'google_podcast' => '',
				'stitcher'       => '',
				'myspace'        => '',
				'bloglovin'      => '',
				'digg'           => '',
				'dribbble'       => '',
				'flickr'         => '',
				'soundcloud'     => '',
				'vimeo'          => '',
				'reddit'         => '',
				'vkontakte'      => '',
				'telegram'       => '',
				'whatsapp'       => '',
				'truth'          => '',
				'paypal'         => '',
				'patreon'        => '',
				'threads'        => '',
				'bluesky'        => '',
				'rss'            => ''
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Widget Social Icons/About', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display about me information and social icons in the sidebar.', 'gulir-core' ),
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
				'id'    => $this->get_field_id( 'content' ),
				'name'  => $this->get_field_name( 'content' ),
				'title' => esc_html__( 'Short biography (raw HTML allowed)', 'gulir-core' ),
				'value' => $instance['content'],
			] );

			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'style' ),
				'name'    => $this->get_field_name( 'style' ),
				'title'   => esc_html__( 'Align Content', 'gulir-core' ),
				'options' => [
					'1' => esc_html__( 'Left', 'gulir-core' ),
					'2' => esc_html__( 'Center', 'gulir-core' ),
				],
				'value'   => $instance['style'],
			] );

			gulir_create_widget_select_field( [
				'id'          => $this->get_field_id( 'data_social' ),
				'name'        => $this->get_field_name( 'data_social' ),
				'title'       => esc_html__( 'Social Profiles Source', 'gulir-core' ),
				'description' => esc_html__( 'To set social profiles from the Theme Options, Navigate to: <strong>Theme Options -> Social Profiles.</strong>', 'gulir-core' ),
				'options'     => [
					'1' => esc_html__( 'Theme Options', 'gulir-core' ),
					'2' => esc_html__( 'Use Custom', 'gulir-core' ),
				],
				'value'       => $instance['data_social'],
			] );

			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'new_tab' ),
				'name'    => $this->get_field_name( 'new_tab' ),
				'title'   => esc_html__( 'Open in new tab', 'gulir-core' ),
				'options' => [
					'1' => esc_html__( '- Default -', 'gulir-core' ),
					'2' => esc_html__( 'New Tab', 'gulir-core' ),
				],
				'value'   => $instance['new_tab'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'settings' ),
				'name'  => $this->get_field_name( 'settings' ),
				'title' => esc_html__( 'Social Settings', 'gulir-core' ),
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'facebook' ),
				'name'  => $this->get_field_name( 'facebook' ),
				'title' => esc_html__( 'Facebook URL', 'gulir-core' ),
				'value' => $instance['facebook'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'twitter' ),
				'name'  => $this->get_field_name( 'twitter' ),
				'title' => esc_html__( 'X (Twitter) URL', 'gulir-core' ),
				'value' => $instance['twitter'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'youtube' ),
				'name'  => $this->get_field_name( 'youtube' ),
				'title' => esc_html__( 'Youtube URL', 'gulir-core' ),
				'value' => $instance['youtube'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'googlenews' ),
				'name'  => $this->get_field_name( 'googlenews' ),
				'title' => esc_html__( 'GoogleNews URL', 'gulir-core' ),
				'value' => $instance['googlenews'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'instagram' ),
				'name'  => $this->get_field_name( 'instagram' ),
				'title' => esc_html__( 'Instagram URL', 'gulir-core' ),
				'value' => $instance['instagram'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'pinterest' ),
				'name'  => $this->get_field_name( 'pinterest' ),
				'title' => esc_html__( 'Pinterest URL', 'gulir-core' ),
				'value' => $instance['pinterest'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'linkedin' ),
				'name'  => $this->get_field_name( 'linkedin' ),
				'title' => esc_html__( 'Linkedin URL', 'gulir-core' ),
				'value' => $instance['linkedin'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'medium' ),
				'name'  => $this->get_field_name( 'medium' ),
				'title' => esc_html__( 'Medium URL', 'gulir-core' ),
				'value' => $instance['medium'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'flipboard' ),
				'name'  => $this->get_field_name( 'flipboard' ),
				'title' => esc_html__( 'Flipboard URL', 'gulir-core' ),
				'value' => $instance['flipboard'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'twitch' ),
				'name'  => $this->get_field_name( 'twitch' ),
				'title' => esc_html__( 'Twitch URL', 'gulir-core' ),
				'value' => $instance['twitch'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'steam' ),
				'name'  => $this->get_field_name( 'steam' ),
				'title' => esc_html__( 'Steam URL', 'gulir-core' ),
				'value' => $instance['steam'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'tumblr' ),
				'name'  => $this->get_field_name( 'tumblr' ),
				'title' => esc_html__( 'Tumblr URL', 'gulir-core' ),
				'value' => $instance['tumblr'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'discord' ),
				'name'  => $this->get_field_name( 'discord' ),
				'title' => esc_html__( 'Discord URL', 'gulir-core' ),
				'value' => $instance['discord'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'flickr' ),
				'name'  => $this->get_field_name( 'flickr' ),
				'title' => esc_html__( 'Flickr URL', 'gulir-core' ),
				'value' => $instance['flickr'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'skype' ),
				'name'  => $this->get_field_name( 'skype' ),
				'title' => esc_html__( 'Skype URL', 'gulir-core' ),
				'value' => $instance['skype'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'snapchat' ),
				'name'  => $this->get_field_name( 'snapchat' ),
				'title' => esc_html__( 'Snapchat URL', 'gulir-core' ),
				'value' => $instance['snapchat'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'quora' ),
				'name'  => $this->get_field_name( 'quora' ),
				'title' => esc_html__( 'Quora URL', 'gulir-core' ),
				'value' => $instance['quora'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'spotify' ),
				'name'  => $this->get_field_name( 'spotify' ),
				'title' => esc_html__( 'Spotify URL', 'gulir-core' ),
				'value' => $instance['spotify'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'apple_podcast' ),
				'name'  => $this->get_field_name( 'apple_podcast' ),
				'title' => esc_html__( 'Apple Podcasts URL', 'gulir-core' ),
				'value' => $instance['apple_podcast'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'google_podcast' ),
				'name'  => $this->get_field_name( 'google_podcast' ),
				'title' => esc_html__( 'Google Podcasts URL', 'gulir-core' ),
				'value' => $instance['google_podcast'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'stitcher' ),
				'name'  => $this->get_field_name( 'stitcher' ),
				'title' => esc_html__( 'Stitcher URL', 'gulir-core' ),
				'value' => $instance['stitcher'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'myspace' ),
				'name'  => $this->get_field_name( 'myspace' ),
				'title' => esc_html__( 'Myspace URL', 'gulir-core' ),
				'value' => $instance['myspace'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'bloglovin' ),
				'name'  => $this->get_field_name( 'bloglovin' ),
				'title' => esc_html__( 'Bloglovin URL', 'gulir-core' ),
				'value' => $instance['bloglovin'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'digg' ),
				'name'  => $this->get_field_name( 'digg' ),
				'title' => esc_html__( 'Digg URL', 'gulir-core' ),
				'value' => $instance['digg'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'dribbble' ),
				'name'  => $this->get_field_name( 'dribbble' ),
				'title' => esc_html__( 'Dribbble URL', 'gulir-core' ),
				'value' => $instance['dribbble'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'flickr' ),
				'name'  => $this->get_field_name( 'flickr' ),
				'title' => esc_html__( 'Flickr URL', 'gulir-core' ),
				'value' => $instance['flickr'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'soundcloud' ),
				'name'  => $this->get_field_name( 'soundcloud' ),
				'title' => esc_html__( 'SoundCloud URL', 'gulir-core' ),
				'value' => $instance['soundcloud'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'vimeo' ),
				'name'  => $this->get_field_name( 'vimeo' ),
				'title' => esc_html__( 'Vimeo URL', 'gulir-core' ),
				'value' => $instance['vimeo'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'reddit' ),
				'name'  => $this->get_field_name( 'reddit' ),
				'title' => esc_html__( 'Reddit URL', 'gulir-core' ),
				'value' => $instance['reddit'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'vkontakte' ),
				'name'  => $this->get_field_name( 'vkontakte' ),
				'title' => esc_html__( 'VKontakte URL', 'gulir-core' ),
				'value' => $instance['vkontakte'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'telegram' ),
				'name'  => $this->get_field_name( 'telegram' ),
				'title' => esc_html__( 'Telegram URL', 'gulir-core' ),
				'value' => $instance['telegram'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'whatsapp' ),
				'name'  => $this->get_field_name( 'whatsapp' ),
				'title' => esc_html__( 'Whatsapp URL', 'gulir-core' ),
				'value' => $instance['whatsapp'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'truth' ),
				'name'  => $this->get_field_name( 'truth' ),
				'title' => esc_html__( 'Truth Social URL', 'gulir-core' ),
				'value' => $instance['truth'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'paypal' ),
				'name'  => $this->get_field_name( 'paypal' ),
				'title' => esc_html__( 'PayPal URL', 'gulir-core' ),
				'value' => $instance['paypal'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'patreon' ),
				'name'  => $this->get_field_name( 'patreon' ),
				'title' => esc_html__( 'Patreon URL', 'gulir-core' ),
				'value' => $instance['patreon'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'threads' ),
				'name'  => $this->get_field_name( 'threads' ),
				'title' => esc_html__( 'Threads URL', 'gulir-core' ),
				'value' => $instance['threads'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'bluesky' ),
				'name'  => $this->get_field_name( 'bluesky' ),
				'title' => esc_html__( 'Bluesky URL', 'gulir-core' ),
				'value' => $instance['bluesky'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'rss' ),
				'name'  => $this->get_field_name( 'rss' ),
				'title' => esc_html__( 'RSS URL', 'gulir-core' ),
				'value' => $instance['rss'],
			] );
		}

		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			if ( '2' === (string) $instance['new_tab'] ) {
				$instance['new_tab'] = true;
			} else {
				$instance['new_tab'] = false;
			}

			if ( '1' === (string) $instance['data_social'] ) {
				$data_social = $this->gulir_get_web_socials();
			} else {
				$data_social = $instance;
			}

			$bio_class_name    = 'about-bio';
			$social_class_name = 'social-icon-wrap tooltips-n';

			if ( ! empty( $instance['style'] ) && '2' === (string) $instance['style'] ) {
				$bio_class_name    .= ' is-centered';
				$social_class_name .= ' is-centered';
			}

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . gulir_strip_tags( $instance['title'] ) . $args['after_title'];
			} ?>
			<div class="about-content-wrap">
				<?php if ( ! empty( $instance['content'] ) ) : ?>
					<div class="<?php echo strip_tags( $bio_class_name ); ?>">
						<?php echo gulir_strip_tags( $instance['content'] ); ?>
					</div>
				<?php endif; ?>
				<div class="<?php echo strip_tags( $social_class_name ); ?>"><?php
					if ( function_exists( 'gulir_get_social_list' ) ) {
						echo gulir_get_social_list( $data_social, $instance['new_tab'] );
					}
					?></div>
			</div>
			<?php echo $args['after_widget'];
		}

		function gulir_get_web_socials() {

			return shortcode_atts( [
				'facebook'       => '',
				'twitter'        => '',
				'youtube'        => '',
				'googlenews'     => '',
				'instagram'      => '',
				'pinterest'      => '',
				'tiktok'         => '',
				'linkedin'       => '',
				'medium'         => '',
				'flipboard'      => '',
				'twitch'         => '',
				'steam'          => '',
				'tumblr'         => '',
				'discord'        => '',
				'skype'          => '',
				'snapchat'       => '',
				'quora'          => '',
				'spotify'        => '',
				'apple_podcast'  => '',
				'google_podcast' => '',
				'stitcher'       => '',
				'myspace'        => '',
				'bloglovin'      => '',
				'digg'           => '',
				'dribbble'       => '',
				'flickr'         => '',
				'soundcloud'     => '',
				'vimeo'          => '',
				'reddit'         => '',
				'vkontakte'      => '',
				'telegram'       => '',
				'whatsapp'       => '',
				'truth'          => '',
				'paypal'         => '',
				'patreon'        => '',
				'threads'        => '',
				'bluesky'        => '',
				'rss'            => '',
			], gulir_get_option() );
		}
	}
}