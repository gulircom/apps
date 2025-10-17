<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_W_Follower' ) ) {

	class Gulir_W_Follower extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-follower';

		function __construct() {

			$this->params = [
				'title'            => 'Stay Connected',
				'style'            => '',
				'facebook_page'    => '',
				'facebook_count'   => '',
				'twitter_user'     => '',
				'twitter_count'    => '',
				'pinterest_user'   => '',
				'pinterest_count'  => '',
				'instagram_user'   => '',
				'instagram_count'  => '',
				'youtube_link'     => '',
				'youtube_count'    => '',
				'tiktok_link'      => '',
				'tiktok_count'     => '',
				'vkontakte_link'   => '',
				'vkontakte_count'  => '',
				'telegram_link'    => '',
				'telegram_count'   => '',
				'whatsapp_link'    => '',
				'whatsapp_count'   => '',
				'gnews_link'       => '',
				'gnews_count'      => '',
				'linkedin_link'    => '',
				'linkedin_count'   => '',
				'medium_link'      => '',
				'medium_count'     => '',
				'flipboard_link'   => '',
				'flipboard_count'  => '',
				'twitch_link'      => '',
				'twitch_count'     => '',
				'steam_link'       => '',
				'steam_count'      => '',
				'tumblr_link'      => '',
				'tumblr_count'     => '',
				'discord_link'     => '',
				'discord_count'    => '',
				'paypal_link'      => '',
				'paypal_count'     => '',
				'patreon_link'     => '',
				'patreon_count'    => '',
				'soundcloud_user'  => '',
				'soundcloud_count' => '',
				'vimeo_user'       => '',
				'vimeo_count'      => '',
				'dribbble_user'    => '',
				'dribbble_count'   => '',
				'snapchat_link'    => '',
				'snapchat_count'   => '',
				'quora_link'       => '',
				'quora_count'      => '',
				'spotify_link'     => '',
				'spotify_count'    => '',
				'truth_link'       => '',
				'truth_count'      => '',
				'threads_link'     => '',
				'threads_count'    => '',
				'bsky_link'        => '',
				'bsky_count'       => '',
				'rss_link'         => '',
				'rss_count'        => '',
				'font_size'        => '',
				'columns'          => '',
				'tablet_columns'   => '',
				'mobile_columns'   => '',
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Widget Social Counter', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display your media socials with total of followers in the sidebar.', 'gulir-core' ),
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

			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'style' ),
				'name'    => $this->get_field_name( 'style' ),
				'title'   => esc_html__( 'Style', 'gulir-core' ),
				'options' => [
					'1'  => esc_html__( 'Style 1', 'gulir-core' ),
					'2'  => esc_html__( 'Style 2', 'gulir-core' ),
					'3'  => esc_html__( 'Style 3', 'gulir-core' ),
					'4'  => esc_html__( 'Style 4', 'gulir-core' ),
					'5'  => esc_html__( 'Style 5', 'gulir-core' ),
					'6'  => esc_html__( 'Style 6', 'gulir-core' ),
					'7'  => esc_html__( 'Style 7', 'gulir-core' ),
					'8'  => esc_html__( 'Style 8', 'gulir-core' ),
					'9'  => esc_html__( 'Style 9', 'gulir-core' ),
					'10' => esc_html__( 'Style 10', 'gulir-core' ),
					'11' => esc_html__( 'Style 11', 'gulir-core' ),
					'12' => esc_html__( 'Style 12', 'gulir-core' ),
					'13' => esc_html__( 'Style 13', 'gulir-core' ),
					'14' => esc_html__( 'Style 14', 'gulir-core' ),
					'15' => esc_html__( 'Style 15', 'gulir-core' ),
				],
				'value'   => $instance['style'],
			] );

			echo '<div class="rb-form-2cols">';

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_facebook' ),
				'name'  => $this->get_field_name( 'head_facebook' ),
				'title' => esc_html__( 'Facebook', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'facebook_page' ),
				'name'  => $this->get_field_name( 'facebook_page' ),
				'title' => esc_html__( 'FanPage Name', 'gulir-core' ),
				'value' => $instance['facebook_page'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'facebook_count' ),
				'name'  => $this->get_field_name( 'facebook_count' ),
				'title' => esc_html__( 'Likes Value', 'gulir-core' ),
				'value' => $instance['facebook_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_twitter' ),
				'name'  => $this->get_field_name( 'head_twitter' ),
				'title' => esc_html__( 'X (Twitter)', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'twitter_user' ),
				'name'  => $this->get_field_name( 'twitter_user' ),
				'title' => esc_html__( 'Twitter Name', 'gulir-core' ),
				'value' => $instance['twitter_user'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'twitter_count' ),
				'name'  => $this->get_field_name( 'twitter_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['twitter_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_pinterest' ),
				'name'  => $this->get_field_name( 'head_pinterest' ),
				'title' => esc_html__( 'Pinterest', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'pinterest_user' ),
				'name'  => $this->get_field_name( 'pinterest_user' ),
				'title' => esc_html__( 'Pinterest Name', 'gulir-core' ),
				'value' => $instance['pinterest_user'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'pinterest_count' ),
				'name'  => $this->get_field_name( 'pinterest_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['pinterest_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_instagram' ),
				'name'  => $this->get_field_name( 'head_instagram' ),
				'title' => esc_html__( 'Instagram', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'instagram_user' ),
				'name'  => $this->get_field_name( 'instagram_user' ),
				'title' => esc_html__( 'Instagram Name', 'gulir-core' ),
				'value' => $instance['instagram_user'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'instagram_count' ),
				'name'  => $this->get_field_name( 'instagram_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['instagram_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_youtube' ),
				'name'  => $this->get_field_name( 'head_youtube' ),
				'title' => esc_html__( 'Youtube', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'youtube_link' ),
				'name'        => $this->get_field_name( 'youtube_link' ),
				'title'       => esc_html__( 'Youtube Channel or User URL', 'gulir-core' ),
				'placeholder' => 'https://www.youtube.com/channel/...',
				'value'       => $instance['youtube_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'youtube_count' ),
				'name'  => $this->get_field_name( 'youtube_count' ),
				'title' => esc_html__( 'Subscribers Value', 'gulir-core' ),
				'value' => $instance['youtube_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_tiktok' ),
				'name'  => $this->get_field_name( 'head_tiktok' ),
				'title' => esc_html__( 'Tiktok', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'tiktok_link' ),
				'name'        => $this->get_field_name( 'tiktok_link' ),
				'title'       => esc_html__( 'Tiktok Page URL', 'gulir-core' ),
				'placeholder' => 'https://tiktok.com/@...',
				'value'       => $instance['tiktok_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'tiktok_count' ),
				'name'  => $this->get_field_name( 'tiktok_count' ),
				'title' => esc_html__( 'Members Value', 'gulir-core' ),
				'value' => $instance['tiktok_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_vkontakte' ),
				'name'  => $this->get_field_name( 'head_vkontakte' ),
				'title' => esc_html__( 'Vkontakte', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'vkontakte_link' ),
				'name'        => $this->get_field_name( 'vkontakte_link' ),
				'title'       => esc_html__( 'Vkontakte URL', 'gulir-core' ),
				'placeholder' => 'https://vk.com/...',
				'value'       => $instance['vkontakte_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'vkontakte_count' ),
				'name'  => $this->get_field_name( 'vkontakte_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['vkontakte_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_telegram' ),
				'name'  => $this->get_field_name( 'head_telegram' ),
				'title' => esc_html__( 'Telegram', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'telegram_link' ),
				'name'        => $this->get_field_name( 'telegram_link' ),
				'title'       => esc_html__( 'Channel or Invite URL', 'gulir-core' ),
				'placeholder' => 'https://t.me/...',
				'value'       => $instance['telegram_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'telegram_count' ),
				'name'  => $this->get_field_name( 'telegram_count' ),
				'title' => esc_html__( 'Members Value', 'gulir-core' ),
				'value' => $instance['telegram_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_whatsapp' ),
				'name'  => $this->get_field_name( 'head_whatsapp' ),
				'title' => esc_html__( 'WhatsApp', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'whatsapp_link' ),
				'name'        => $this->get_field_name( 'whatsapp_link' ),
				'title'       => esc_html__( 'Channel or Invite URL', 'gulir-core' ),
				'placeholder' => 'https://chat.whatsapp.com/invite/...',
				'value'       => $instance['whatsapp_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'whatsapp_count' ),
				'name'  => $this->get_field_name( 'whatsapp_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['whatsapp_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_gnews' ),
				'name'  => $this->get_field_name( 'head_gnews' ),
				'title' => esc_html__( 'Youtube', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'gnews_link' ),
				'name'        => $this->get_field_name( 'gnews_link' ),
				'title'       => esc_html__( 'Google News URL', 'gulir-core' ),
				'placeholder' => 'https://news.google.com/publications/...',
				'value'       => $instance['gnews_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'gnews_count' ),
				'name'  => $this->get_field_name( 'gnews_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['gnews_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_linkedin' ),
				'name'  => $this->get_field_name( 'head_linkedin' ),
				'title' => esc_html__( 'LinkedIn', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'linkedin_link' ),
				'name'        => $this->get_field_name( 'linkedin_link' ),
				'title'       => esc_html__( 'LinkedIn URL', 'gulir-core' ),
				'placeholder' => 'https://www.linkedin.com/...',
				'value'       => $instance['linkedin_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'linkedin_count' ),
				'name'  => $this->get_field_name( 'linkedin_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['linkedin_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_medium' ),
				'name'  => $this->get_field_name( 'head_medium' ),
				'title' => esc_html__( 'Medium', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'medium_link' ),
				'name'        => $this->get_field_name( 'medium_link' ),
				'title'       => esc_html__( 'Medium URL', 'gulir-core' ),
				'placeholder' => 'https://www.medium.com/...',
				'value'       => $instance['medium_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'medium_count' ),
				'name'  => $this->get_field_name( 'medium_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['medium_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_flipboard' ),
				'name'  => $this->get_field_name( 'head_flipboard' ),
				'title' => esc_html__( 'Flipboard', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'flipboard_link' ),
				'name'        => $this->get_field_name( 'flipboard_link' ),
				'title'       => esc_html__( 'Flipboard URL', 'gulir-core' ),
				'placeholder' => 'https://www.flipboard.com/...',
				'value'       => $instance['flipboard_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'flipboard_count' ),
				'name'  => $this->get_field_name( 'flipboard_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['flipboard_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_twitch' ),
				'name'  => $this->get_field_name( 'head_twitch' ),
				'title' => esc_html__( 'Twitch', 'gulir-core' ),
			] );

			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'twitch_link' ),
				'name'        => $this->get_field_name( 'twitch_link' ),
				'title'       => esc_html__( 'Twitch URL', 'gulir-core' ),
				'placeholder' => 'https://www.twitch.tv/...',
				'value'       => $instance['twitch_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'twitch_count' ),
				'name'  => $this->get_field_name( 'twitch_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['twitch_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_steam' ),
				'name'  => $this->get_field_name( 'head_steam' ),
				'title' => esc_html__( 'Steam', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'steam_link' ),
				'name'        => $this->get_field_name( 'steam_link' ),
				'title'       => esc_html__( 'Steam URL', 'gulir-core' ),
				'placeholder' => 'https://www.steamcommunity.com/groups/...',
				'value'       => $instance['steam_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'steam_count' ),
				'name'  => $this->get_field_name( 'steam_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['steam_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_tumblr' ),
				'name'  => $this->get_field_name( 'head_tumblr' ),
				'title' => esc_html__( 'Tumblr', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'tumblr_link' ),
				'name'        => $this->get_field_name( 'tumblr_link' ),
				'title'       => esc_html__( 'Tumblr URL', 'gulir-core' ),
				'placeholder' => '',
				'value'       => $instance['tumblr_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'tumblr_count' ),
				'name'  => $this->get_field_name( 'tumblr_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['tumblr_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_discord' ),
				'name'  => $this->get_field_name( 'head_discord' ),
				'title' => esc_html__( 'Discord', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'discord_link' ),
				'name'        => $this->get_field_name( 'discord_link' ),
				'title'       => esc_html__( 'Tumblr URL', 'gulir-core' ),
				'placeholder' => 'https://discord.com/servers/...',
				'value'       => $instance['discord_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'discord_count' ),
				'name'  => $this->get_field_name( 'discord_count' ),
				'title' => esc_html__( 'Members Value', 'gulir-core' ),
				'value' => $instance['discord_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_paypal' ),
				'name'  => $this->get_field_name( 'head_paypal' ),
				'title' => esc_html__( 'PayPal', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'paypal_link' ),
				'name'        => $this->get_field_name( 'paypal_link' ),
				'title'       => esc_html__( 'PayPal URL', 'gulir-core' ),
				'placeholder' => 'https://paypal.me/...',
				'value'       => $instance['paypal_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'paypal_count' ),
				'name'  => $this->get_field_name( 'paypal_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['paypal_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_patreon' ),
				'name'  => $this->get_field_name( 'head_patreon' ),
				'title' => esc_html__( 'Patreon', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'patreon_link' ),
				'name'        => $this->get_field_name( 'patreon_link' ),
				'title'       => esc_html__( 'Patreon URL', 'gulir-core' ),
				'placeholder' => 'https://patreon.me/...',
				'value'       => $instance['patreon_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'patreon_count' ),
				'name'  => $this->get_field_name( 'patreon_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['patreon_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_soundcloud' ),
				'name'  => $this->get_field_name( 'head_soundcloud' ),
				'title' => esc_html__( 'SoundCloud', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'soundcloud_user' ),
				'name'  => $this->get_field_name( 'soundcloud_user' ),
				'title' => esc_html__( 'Soundcloud User Name', 'gulir-core' ),
				'value' => $instance['soundcloud_user'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'soundcloud_count' ),
				'name'  => $this->get_field_name( 'soundcloud_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['soundcloud_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_vimeo' ),
				'name'  => $this->get_field_name( 'head_vimeo' ),
				'title' => esc_html__( 'Vimeo', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'vimeo_user' ),
				'name'  => $this->get_field_name( 'vimeo_user' ),
				'title' => esc_html__( 'Vimeo User Name', 'gulir-core' ),
				'value' => $instance['vimeo_user'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'vimeo_count' ),
				'name'  => $this->get_field_name( 'vimeo_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['vimeo_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_dribbble' ),
				'name'  => $this->get_field_name( 'head_dribbble' ),
				'title' => esc_html__( 'Dribbble', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'dribbble_user' ),
				'name'  => $this->get_field_name( 'dribbble_user' ),
				'title' => esc_html__( 'Dribbble User Name', 'gulir-core' ),
				'value' => $instance['dribbble_user'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'dribbble_count' ),
				'name'  => $this->get_field_name( 'dribbble_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['dribbble_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_snapchat' ),
				'name'  => $this->get_field_name( 'head_snapchat' ),
				'title' => esc_html__( 'Snapchat', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'snapchat_link' ),
				'name'        => $this->get_field_name( 'snapchat_link' ),
				'title'       => esc_html__( 'Snapchat URL', 'gulir-core' ),
				'placeholder' => 'https://snapchat.com/...',
				'value'       => $instance['snapchat_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'snapchat_count' ),
				'name'  => $this->get_field_name( 'snapchat_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['snapchat_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_quora' ),
				'name'  => $this->get_field_name( 'head_quora' ),
				'title' => esc_html__( 'Quora', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'quora_link' ),
				'name'        => $this->get_field_name( 'quora_link' ),
				'title'       => esc_html__( 'Quora Social URL', 'gulir-core' ),
				'placeholder' => 'https://quora.com/...',
				'value'       => $instance['quora_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'quora_count' ),
				'name'  => $this->get_field_name( 'quora_count' ),
				'title' => esc_html__( 'Memembers Value', 'gulir-core' ),
				'value' => $instance['quora_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_spotify' ),
				'name'  => $this->get_field_name( 'head_spotify' ),
				'title' => esc_html__( 'Spotify', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'spotify_link' ),
				'name'        => $this->get_field_name( 'spotify_link' ),
				'title'       => esc_html__( 'Spotify URL', 'gulir-core' ),
				'placeholder' => 'https://open.spotify.com/artist/...',
				'value'       => $instance['spotify_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'spotify_count' ),
				'name'  => $this->get_field_name( 'spotify_count' ),
				'title' => esc_html__( 'Listeners Value', 'gulir-core' ),
				'value' => $instance['spotify_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_truth' ),
				'name'  => $this->get_field_name( 'head_truth' ),
				'title' => esc_html__( 'Truth Social', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'truth_link' ),
				'name'        => $this->get_field_name( 'truth_link' ),
				'title'       => esc_html__( 'Truth Social URL', 'gulir-core' ),
				'placeholder' => 'https://truthsocial.com/...',
				'value'       => $instance['truth_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'truth_count' ),
				'name'  => $this->get_field_name( 'truth_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['truth_count'],
			] );

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_threads' ),
				'name'  => $this->get_field_name( 'head_threads' ),
				'title' => esc_html__( 'Treads', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'threads_link' ),
				'name'        => $this->get_field_name( 'threads_link' ),
				'title'       => esc_html__( 'Threads URL', 'gulir-core' ),
				'placeholder' => 'https://www.threads.net/...',
				'value'       => $instance['threads_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'threads_count' ),
				'name'  => $this->get_field_name( 'threads_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['threads_count'],
			] );
			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_bsky' ),
				'name'  => $this->get_field_name( 'head_bsky' ),
				'title' => esc_html__( 'Bluesky', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'bsky_link' ),
				'name'        => $this->get_field_name( 'bsky_link' ),
				'title'       => esc_html__( 'Bluesky URL', 'gulir-core' ),
				'placeholder' => 'https://bsky.app/profile/...',
				'value'       => $instance['bsky_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'bsky_count' ),
				'name'  => $this->get_field_name( 'bsky_count' ),
				'title' => esc_html__( 'Followers Value', 'gulir-core' ),
				'value' => $instance['bsky_count'],
			] );
			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'head_rss' ),
				'name'  => $this->get_field_name( 'head_rss' ),
				'title' => esc_html__( 'Treads', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'rss_link' ),
				'name'  => $this->get_field_name( 'rss_link' ),
				'title' => esc_html__( 'RSS Feed URL', 'gulir-core' ),
				'value' => $instance['rss_link'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'rss_count' ),
				'name'  => $this->get_field_name( 'rss_count' ),
				'title' => esc_html__( 'Readers Value', 'gulir-core' ),
				'value' => $instance['rss_count'],
			] );

			echo '</div>';

			gulir_create_widget_heading_field( [
				'id'    => $this->get_field_id( 'style_settings' ),
				'name'  => $this->get_field_name( 'style_settings' ),
				'title' => esc_html__( 'Style', 'gulir-core' ),
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'font_size' ),
				'name'        => $this->get_field_name( 'font_size' ),
				'title'       => esc_html__( 'Icon Size', 'gulir-core' ),
				'description' => esc_html__( 'Input icon size value in px', 'gulir-core' ),
				'value'       => $instance['font_size'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'columns' ),
				'name'        => $this->get_field_name( 'columns' ),
				'title'       => esc_html__( 'Columns', 'gulir-core' ),
				'description' => esc_html__( 'Input the number of columns for this widget on desktop.', 'gulir-core' ),
				'value'       => $instance['columns'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'tablet_columns' ),
				'name'        => $this->get_field_name( 'tablet_columns' ),
				'title'       => esc_html__( 'Tablet Columns', 'gulir-core' ),
				'description' => esc_html__( 'Input the number of columns for this widget on tablet.', 'gulir-core' ),
				'value'       => $instance['tablet_columns'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'mobile_columns' ),
				'name'        => $this->get_field_name( 'mobile_columns' ),
				'title'       => esc_html__( 'Mobile Columns', 'gulir-core' ),
				'description' => esc_html__( 'Input the number of columns for this widget on mobile.', 'gulir-core' ),
				'value'       => $instance['mobile_columns'],
			] );
		}

		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			echo $args['before_widget'];

			if ( ! empty( $instance['columns'] ) || ! empty( $instance['tablet_columns'] ) || ! empty( $instance['mobile_columns'] ) || ! empty( $instance['font_size'] ) ) {

				echo '<style> [id="' . $args['widget_id'] . '"] {';
				if ( ! empty( $instance['font_size'] ) ) {
					echo '--s-icon-size : ' . absint( $instance['font_size'] ) . 'px;';
				}
				if ( ! empty( $instance['columns'] ) ) {
					echo '--s-columns: ' . absint( $instance['columns'] ) . ';';
				}
				if ( ! empty( $instance['tablet_columns'] ) ) {
					echo '--s-tcolumns: ' . absint( $instance['tablet_columns'] ) . ';';
				}
				if ( ! empty( $instance['mobile_columns'] ) ) {
					echo '--s-mcolumns: ' . absint( $instance['mobile_columns'] ) . ';';
				}
				echo '} </style>';
			}

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . gulir_strip_tags( $instance['title'] ) . $args['after_title'];
			}
			echo rb_social_follower( $instance, $instance['style'] );
			echo $args['after_widget'];
		}
	}
}