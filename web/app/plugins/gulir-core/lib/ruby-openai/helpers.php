<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'rb_openai_content_generator' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return array|false|string|string[]|null
	 */
	function rb_openai_content_generator( $settings = [] ) {

		$settings = wp_parse_args(
			$settings,
			[
				'api_key'     => get_option( 'rb_openai_api_key' ),
				'prompt'      => '',
				'max_tokens'  => get_option( 'rb_openai_max_tokens', 200 ),
				'temperature' => get_option( 'rb_openai_temperature', 0.8 ),
			]
		);

		if ( empty( $settings['prompt'] ) || empty( $settings['api_key'] ) ) {
			return false;
		}

		$response = wp_remote_post( 'https://api.openai.com/v1/chat/completions', [
			'headers' => [
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $settings['api_key'],
			],
			'body'    => json_encode( [
				'messages'          => [
					[
						'role'    => 'system',
						'content' => 'You are a helpful assistant.',
					],
					[
						'role'    => 'user',
						'content' => $settings['prompt'],
					],
				],
				'model'             => "gpt-3.5-turbo",
				'temperature'       => floatval( $settings['temperature'] ),
				'max_tokens'        => intval( $settings['max_tokens'] ),
				'frequency_penalty' => 0.0,
				'presence_penalty'  => 0.0,
				'top_p'             => 1,
			] ),
			'timeout' => 300,
		] );

		if ( is_wp_error( $response ) ) {
			$error_messages = $response->get_error_messages();

			return [
				'error'   => json_encode( $error_messages ),
				'content' => '',
			];
		}

		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body, true );

		if ( ! empty( $body['choices'][0]['message']['content'] ) ) {
			$content = preg_replace( '/^\n+/', '', wp_kses_post( $body['choices'][0]['message']['content'] ) );
			$content = trim( $content, '"' );

			return [
				'content' => $content,
			];
		} elseif ( isset( $body['error']['message'] ) ) {
			return [
				'error'   => preg_replace( '/^\n+/', '', wp_kses_post( $body['error']['message'] ) ),
				'content' => '',
			];
		} else {
			return [
				'error'   => esc_html__( 'Content generation failed.', 'gulir-core' ),
				'content' => '',
			];
		}
	}
}

if ( ! function_exists( 'rb_openai_content_type_selection' ) ) {
	function rb_openai_content_type_selection() {

		return [
			'title'       => esc_html__( 'Title', 'gulir-core' ),
			'excerpt'     => esc_html__( 'Excerpt', 'gulir-core' ),
			'content'     => esc_html__( 'Content', 'gulir-core' ),
			'description' => esc_html__( 'Meta Description', 'gulir-core' ),
			'keys'        => esc_html__( 'Meta Keywords', 'gulir-core' ),
			'tags'        => esc_html__( 'Tags', 'gulir-core' ),
		];
	}
}

if ( ! function_exists( 'rb_openai_writing_style_selection' ) ) {
	function rb_openai_writing_style_selection() {

		return [
			'informative'   => esc_html__( 'Informative', 'gulir-core' ),
			'creative'      => esc_html__( 'Creative', 'gulir-core' ),
			'journalistic'  => esc_html__( 'Journalistic', 'gulir-core' ),
			'academic'      => esc_html__( 'Academic', 'gulir-core' ),
			'technical'     => esc_html__( 'Technical', 'gulir-core' ),
			'evaluative'    => esc_html__( 'Evaluative', 'gulir-core' ),
			'biographical'  => esc_html__( 'Biographical', 'gulir-core' ),
			'Argumentative' => esc_html__( 'Argumentative', 'gulir-core' ),
		];
	}
}
/**
 * @return array
 */
if ( ! function_exists( 'rb_openai_languages_selection' ) ) {
	function rb_openai_languages_selection() {

		if ( ! function_exists( 'wp_get_available_translations' ) ) {
			require_once ABSPATH . 'wp-admin/includes/translation-install.php';
		}

		$data = [
			'English' => esc_html__( 'English (United States)', 'gulir-core' ),
		];

		$languages = wp_get_available_translations();

		foreach ( $languages as $language ) {
			if ( isset( $language['english_name'] ) && isset( $language['native_name'] ) ) {
				$data[ $language['english_name'] ] = $language['native_name'];
			}
		}

		return $data;
	}
}
