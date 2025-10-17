<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gulir_register_options_reaction' ) ) {
	function gulir_register_options_reaction() {

		return [
			'title'  => esc_html__( 'Like & Reaction', 'gulir' ),
			'id'     => 'gulir_config_section_reaction',
			'desc'   => esc_html__( 'Customize user voting and post reactions.', 'gulir' ),
			'icon'   => 'el el-smiley',
			'fields' => [
				[
					'id'    => 'voting_info',
					'type'  => 'info',
					'style' => 'info',
					'desc'  => esc_html__( 'You can enable the like/dislike meta in the Standard Block Design panels or Elementor block.', 'gulir' ),
				],
				[
					'id'     => 'section_start_reaction_global',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'General', 'gulir' ),
					'notice' => [
						esc_html__( 'These settings below will apply to the post like/dislike meta and post reactions.', 'gulir' ),
						esc_html__( 'If a user likes a post after their previous like has expired and the browser cookies have been cleared, it will count as a new like.', 'gulir' ),
					],
					'indent' => true,
				],
				[
					'id'       => 'reaction_guest_expired',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Guest Expiration', 'gulir' ),
					'subtitle' => esc_html__( 'Input a value for the number of days after which to clear up database data for guest users.', 'gulir' ),
					'default'  => 14,
				],
				[
					'id'       => 'reaction_logged_expired',
					'type'     => 'text',
					'class'    => 'small',
					'validate' => 'numeric',
					'title'    => esc_html__( 'Logged Expiration', 'gulir' ),
					'subtitle' => esc_html__( 'Input a value for the number of days after which to clear up database data for logged users.', 'gulir' ),
					'default'  => 14,
				],
				[
					'id'       => 'reaction_ip',
					'type'     => 'switch',
					'title'    => esc_html__( 'tracking by IP', 'gulir' ),
					'subtitle' => esc_html__( 'By default, the theme will track voting using device cookies. If you want to limit likes per IP, you can enable tracking by IP address.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'          => 'js_count',
					'type'        => 'switch',
					'validate'    => 'numeric',
					'title'       => esc_html__( 'Optimize Counter for Caches', 'gulir' ),
					'subtitle'    => esc_html__( 'By default, Total likes, reactions will not increase immediately after user interactions if you use caching. Enabling this feature will make the total count increase/decrease based on the user\'s cookies, accurately reflecting their actions.', 'gulir' ),
					'description' => esc_html__( 'Please note: You don\'t need to enable this if you do not use a caching plugin.', 'gulir' ),
					'default'     => false,
				],
				[
					'id'     => 'section_end_reaction_global',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false,
				],
				[
					'id'     => 'section_start_single_reaction',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Post Reactions', 'gulir' ),
					'notice' => [
						esc_html__( 'The reaction will appear at the end of single post content.', 'gulir' ),
					],
					'indent' => true,
				],
				[
					'id'       => 'single_post_reaction',
					'type'     => 'switch',
					'title'    => esc_html__( 'Single Post Reactions', 'gulir' ),
					'subtitle' => esc_html__( 'Enable or disable the reaction section.', 'gulir' ),
					'default'  => false,
				],
				[
					'id'          => 'single_post_reaction_title',
					'type'        => 'text',
					'title'       => esc_html__( 'Reaction Heading', 'gulir' ),
					'subtitle'    => esc_html__( 'Input a heading for the reaction section.', 'gulir' ),
					'placeholder' => esc_html__( 'What do you think?', 'gulir' ),
					'required'    => [ 'single_post_reaction', '=', true ],
				],
				[
					'id'       => 'reaction_items',
					'title'    => esc_html__( 'Reaction Items', 'gulir' ),
					'subtitle' => esc_html__( 'Choose and sort order reaction items you would like to show.', 'gulir' ),
					'type'     => 'sorter',
					'required' => [ 'single_post_reaction', '=', true ],
					'options'  => [
						'enabled'  => [
							'love'   => esc_html__( 'Love', 'gulir' ),
							'sad'    => esc_html__( 'Sad', 'gulir' ),
							'happy'  => esc_html__( 'Happy', 'gulir' ),
							'sleepy' => esc_html__( 'Sleepy', 'gulir' ),
							'angry'  => esc_html__( 'Angry', 'gulir' ),
							'dead'   => esc_html__( 'Dead', 'gulir' ),
							'wink'   => esc_html__( 'Wink', 'gulir' ),
						],
						'disabled' => [
							'cry'       => esc_html__( 'Cry', 'gulir' ),
							'embarrass' => esc_html__( 'Embarrass', 'gulir' ),
							'joy'       => esc_html__( 'Joy', 'gulir' ),
							'shy'       => esc_html__( 'Shy', 'gulir' ),
							'surprise'  => esc_html__( 'Surprise', 'gulir' ),
						],
					],
					[
						'id'     => 'section_end_post_reaction',
						'type'   => 'section',
						'class'  => 'ruby-section-end',
						'indent' => false,
					],
				],
			],
		];
	}
}



