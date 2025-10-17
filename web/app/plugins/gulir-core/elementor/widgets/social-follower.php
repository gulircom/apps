<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function rb_social_follower;

/**
 * Class Social_Follower
 *
 * @package gulirElementor\Widgets
 */
class Social_Follower extends Widget_Base {

	public function get_name() {

		return 'gulir-social-follower';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Social Follower', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-social-icons';
	}

	public function get_keywords() {

		return [ 'template', 'builder', 'fan', 'follow', 'counter' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_fb', [
				'label' => esc_html__( 'Facebook', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'facebook_page',
			[
				'label' => esc_html__( 'FanPage Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);

		$this->add_control(
			'facebook_count',
			[
				'label' => esc_html__( 'Facebook Likes Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_twitter', [
				'label' => esc_html__( 'X (Twitter)', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'twitter_user',
			[
				'label' => esc_html__( 'X User Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);

		$this->add_control(
			'twitter_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_pinterest', [
				'label' => esc_html__( 'Pinterest', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'pinterest_user',
			[
				'label' => esc_html__( 'Pinterest Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);

		$this->add_control(
			'pinterest_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_instagram', [
				'label' => esc_html__( 'Instagram', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'instagram_user',
			[
				'label' => esc_html__( 'Instagram Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->add_control(
			'instagram_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_youtube', [
				'label' => esc_html__( 'Youtube', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'youtube_link',
			[
				'label'       => esc_html__( 'Youtube Channel or User URL', 'gulir-core' ),
				'placeholder' => 'https://www.youtube.com/channel/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);

		$this->add_control(
			'youtube_count',
			[
				'label' => esc_html__( 'Youtube Subscribers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_tiktok', [
				'label' => esc_html__( 'Tiktok', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tiktok_link',
			[
				'label'       => esc_html__( 'Tiktok URL', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'https://tiktok.com/@...',
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'tiktok_count',
			[
				'label' => esc_html__( 'Tiktok Members Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_vkontakte', [
				'label' => esc_html__( 'Vkontakte', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'vkontakte_link',
			[
				'label'       => esc_html__( 'Vkontakte URL', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'https://vk.com/...',
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'vkontakte_count',
			[
				'label' => esc_html__( 'Vkontakte Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_telegram', [
				'label' => esc_html__( 'Telegram', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'telegram_link',
			[
				'label'       => esc_html__( 'Channel or Invite URL', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'https://t.me/...',
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);

		$this->add_control(
			'telegram_count',
			[
				'label' => esc_html__( 'Telegram Members Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_whatsapp', [
				'label' => esc_html__( 'WhatsApp', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'whatsapp_link',
			[
				'label'       => esc_html__( 'Channel or Invite URL', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'https://chat.whatsapp.com/invite...',
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'whatsapp_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_gnews', [
				'label' => esc_html__( 'Google News', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'gnews_link',
			[
				'label'       => esc_html__( 'Google News URL', 'gulir-core' ),
				'placeholder' => 'https://news.google.com/publications/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'gnews_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_linkedin', [
				'label' => esc_html__( 'LinkedIn', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'linkedin_link',
			[
				'label'       => esc_html__( 'LinkedIn URL', 'gulir-core' ),
				'placeholder' => 'https://www.linkedin.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'linkedin_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_medium', [
				'label' => esc_html__( 'Medium', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'medium_link',
			[
				'label'       => esc_html__( 'Medium URL', 'gulir-core' ),
				'placeholder' => 'https://www.medium.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'medium_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_flipboard', [
				'label' => esc_html__( 'Flipboard', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'flipboard_link',
			[
				'label'       => esc_html__( 'Flipboard URL', 'gulir-core' ),
				'placeholder' => 'https://www.flipboard.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'flipboard_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_twitch', [
				'label' => esc_html__( 'Twitch', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'twitch_link',
			[
				'label'       => esc_html__( 'Twitch URL', 'gulir-core' ),
				'placeholder' => 'https://www.twitch.tv/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'twitch_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_steam', [
				'label' => esc_html__( 'Steam', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'steam_link',
			[
				'label'       => esc_html__( 'Steam URL', 'gulir-core' ),
				'placeholder' => 'https://www.steamcommunity.com/groups/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'steam_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_tumblr', [
				'label' => esc_html__( 'Tumblr', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tumblr_link',
			[
				'label' => esc_html__( 'Tumblr URL', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->add_control(
			'tumblr_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_discord', [
				'label' => esc_html__( 'Discord', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'discord_link',
			[
				'label' => esc_html__( 'Discord Server URL', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->add_control(
			'discord_count',
			[
				'label' => esc_html__( 'Members Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_paypal', [
				'label' => esc_html__( 'PayPal', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'paypal_link',
			[
				'label'       => esc_html__( 'PayPal URL', 'gulir-core' ),
				'placeholder' => 'https://paypal.me/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'paypal_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_patreon', [
				'label' => esc_html__( 'Patreon', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'patreon_link',
			[
				'label'       => esc_html__( 'Patreon URL', 'gulir-core' ),
				'placeholder' => 'https://www.patreon.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'patreon_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_soundcloud', [
				'label' => esc_html__( 'Soundcloud', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'soundcloud_user',
			[
				'label' => esc_html__( 'User Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);

		$this->add_control(
			'soundcloud_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_vimeo', [
				'label' => esc_html__( 'Vimeo', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'vimeo_user',
			[
				'label' => esc_html__( 'Vimeo User Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);

		$this->add_control(
			'vimeo_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_dribbble', [
				'label' => esc_html__( 'Dribbble', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'dribbble_user',
			[
				'label' => esc_html__( 'Dribbble User Name', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);

		$this->add_control(
			'dribbble_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_snapchat', [
				'label' => esc_html__( 'Snapchat', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'snapchat_link',
			[
				'label'       => esc_html__( 'Snapchat URL', 'gulir-core' ),
				'placeholder' => 'https://www.snapchat.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'snapchat_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_quora', [
				'label' => esc_html__( 'Quora', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'quora_link',
			[
				'label'       => esc_html__( 'Quora Social URL', 'gulir-core' ),
				'placeholder' => 'https://quora.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'quora_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_spotify', [
				'label' => esc_html__( 'Spotify', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'spotify_link',
			[
				'label'       => esc_html__( 'Spotify URL', 'gulir-core' ),
				'placeholder' => 'https://open.spotify.com/artist/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'spotify_count',
			[
				'label' => esc_html__( 'Listeners Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_truth', [
				'label' => esc_html__( 'Truth Social', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'truth_link',
			[
				'label'       => esc_html__( 'Truth Social URL', 'gulir-core' ),
				'placeholder' => 'https://truthsocial.com/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'truth_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_threads', [
				'label' => esc_html__( 'Threads', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'threads_link',
			[
				'label'       => esc_html__( 'Threads URL', 'gulir-core' ),
				'placeholder' => 'https://www.threads.net/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'threads_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_blue_sky', [
				'label' => esc_html__( 'Bluesky', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'bsky_link',
			[
				'label'       => esc_html__( 'Bluesky URL', 'gulir-core' ),
				'placeholder' => 'https://bsky.app/profile/...',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
			]
		);
		$this->add_control(
			'bbsky_count',
			[
				'label' => esc_html__( 'Followers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_rss', [
				'label' => esc_html__( 'RSS', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'rss_link',
			[
				'label' => esc_html__( 'RSS Feed URL', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->add_control(
			'rss_count',
			[
				'label' => esc_html__( 'Readers Value', 'gulir-core' ),
				'type'  => Controls_Manager::TEXTAREA,
				'ai'    => [ 'active' => false ],
				'rows'  => 1,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section', [
				'label' => esc_html__( 'Widget Style', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'style',
			[
				'label'       => esc_html__( 'Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a style for your social followers.', 'gulir-core' ),
				'options'     => [
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
				'default'     => '1',
			]
		);
		$this->add_control(
			'color_style', [
				'label'        => esc_html__( 'Color Style', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'description'  => esc_html__( 'Show icons in monochromatic black color or in colorful variations.', 'gulir-core' ),
				'options'      => [
					'colorful' => esc_html__( 'Colorful', 'gulir-core' ),
					'mono'     => esc_html__( 'Monochromatic', 'gulir-core' ),
				],
				'default'      => 'colorful',
				'prefix_class' => 'yes-',
			]
		);
		$this->add_control(
			'mono_dark_accent',
			[
				'label'       => esc_html__( 'Monochromatic Color', 'gulir-core' ),
				'description' => esc_html__( 'Select an accent color for the Monochromatic mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'condition'   => [
					'color_style' => 'mono',
				],
				'selectors'   => [ '{{WRAPPER}}' => '--dark-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'mono_color',
			[
				'label'       => esc_html__( 'Secondary Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a secondary color for the Monochromatic mode, This setting applies only in specific cases.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'condition'   => [
					'color_style' => 'mono',
				],
				'selectors'   => [ '{{WRAPPER}}' => '--sub-icon-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_mono_dark_accent',
			[
				'label'       => esc_html__( 'Dark Mode - Monochromatic Color', 'gulir-core' ),
				'description' => esc_html__( 'Select an accent color for the Monochromatic mode in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'separator'   => 'before',
				'condition'   => [
					'color_style' => 'mono',
				],
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}} .light-scheme' => '--dark-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_mono_color',
			[
				'label'       => esc_html__( 'Dark Mode - Secondary Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a secondary color for Monochromatic mode in dark mode. This setting applies only in specific cases.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'condition'   => [
					'color_style' => 'mono',
				],
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}},  {{WRAPPER}} .light-scheme' => '--sub-icon-color: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'widget_font_size', [
				'label'       => esc_html__( 'Custom Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set a custom font size for the social follower icons.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--s-icon-size : {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'spacing', [
				'label'       => esc_html__( 'Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Adjust the spacing between elements.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--s-spacing : {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'icon_spacing', [
				'label'       => esc_html__( 'Icon Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Adjust the spacing between the icon and the text.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--s-icon-spacing : {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'font_section', [
				'label' => esc_html__( 'Typography', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'custom_font_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::custom_font_info_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Total Fans Text Font', 'gulir-core' ),
				'name'     => 'fan_font',
				'selector' => '{{WRAPPER}} .follower-el .fntotal, {{WRAPPER}} .follower-el .fnlabel',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Description Font', 'gulir-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .follower-el .text-count',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color_section', [
				'label' => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_scheme',
			[
				'label'       => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::color_scheme_description(),
				'options'     => [
					'0' => esc_html__( 'Default (Dark Text)', 'gulir-core' ),
					'1' => esc_html__( 'Light Text', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'block_columns', [
				'label' => esc_html__( 'Columns', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'custom_columns',
			[
				'label'        => esc_html__( 'Custom Columns', 'gulir-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_responsive_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input number of columns for the socials.', 'gulir-core' ),
				'default'     => '',
				'condition'   => [
					'custom_columns' => 'yes',
				],
				'selectors'   => [ '{{WRAPPER}}' => '--s-columns : {{VALUE}}' ],
			]
		);
		$this->add_responsive_control(
			'column_gap',
			[
				'label'     => esc_html__( 'Column Gap', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'condition' => [
					'custom_columns' => 'yes',
				],
				'selectors' => [ '{{WRAPPER}} ' => '--colgap: {{VALUE}}px' ],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		$settings         = $this->get_settings();
		$settings['uuid'] = 'uid_' . $this->get_id();
		$style            = $settings['style'];
		echo rb_social_follower( $settings, $style );
	}
}