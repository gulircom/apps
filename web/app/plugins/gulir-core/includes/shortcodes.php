<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Shortcodes', false ) ) {
	class Gulir_Shortcodes {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_shortcode( 'ruby_static_newsletter', [ $this, 'render_static_newsletter' ] );
			add_shortcode( 'ruby_related', [ $this, 'render_related' ] );
			add_shortcode( 'ruby_review_box', [ $this, 'render_review_box' ] );
		}

		public function render_static_newsletter( $attrs ) {

			$settings = shortcode_atts( [
				'classes'         => '',
				'title'           => gulir_get_option( 'single_post_newsletter_title' ),
				'description'     => gulir_get_option( 'single_post_newsletter_description' ),
				'code'            => gulir_get_option( 'single_post_newsletter_code' ),
				'policy'          => gulir_get_option( 'single_post_newsletter_policy' ),
				'heading_tag'     => 'h2',
				'description_tag' => 'h6',
			], $attrs );

			$output     = '';
			$class_name = 'newsletter-box';
			if ( ! empty( $settings['classes'] ) ) {
				$class_name .= ' ' . $settings['classes'];
			}
			$output .= '<div class="' . esc_attr( $class_name ) . '">';
			$output .= '<div class="newsletter-box-header">';
			$output .= '<span class="newsletter-icon"><i class="rbi rbi-plane"></i></span>';
			$output .= '<div class="inner">';
			if ( ! empty( $settings['title'] ) ) {
				$output .= '<' . esc_attr( $settings['heading_tag'] ) . ' class="newsletter-box-title">' . esc_html( $settings['title'] ) . '</' . esc_attr( $settings['heading_tag'] ) . '>';
			}
			if ( ! empty( $settings['title'] ) ) {
				$output .= '<' . esc_attr( $settings['description_tag'] ) . ' class="newsletter-box-description">' . esc_html( $settings['description'] ) . '</' . esc_attr( $settings['description_tag'] ) . '>';
			}
			$output .= '</div>';
			$output .= '</div>';
			$output .= '<div class="newsletter-box-content">';
			if ( ! empty( $settings['code'] ) ) {
				$output .= do_shortcode( $settings['code'] );
			}
			$output .= '</div>';
			if ( ! empty( $settings['policy'] ) ) {
				$output .= '<div class="newsletter-box-policy">' . $settings['policy'] . '</div>';
			}
			$output .= '</div>';

			return $output;
		}

		/**
		 * @param $attrs
		 *
		 * @return false|string
		 */
		public function render_related( $attrs ) {

			$settings = shortcode_atts( [
				'heading'        => '',
				'heading_tag'    => '',
				'heading_layout' => '',
				'total'          => 2,
				'layout'         => 1,
				'ids'            => '',
				'where'          => '',
				'order'          => '',
				'style'          => 'boxed',
				'width'          => '',
				'post_id'        => get_the_ID(),
			], $attrs );

			if ( empty( $settings['heading_layout'] ) ) {
				$settings['heading_layout'] = gulir_get_option( 'heading_layout' );
			}

			$func_name = 'gulir_get_layout_related_' . absint( $settings['layout'] );
			if ( function_exists( $func_name ) ) {
				ob_start();
				call_user_func( $func_name, $settings );

				return ob_get_clean();
			}

			return false;
		}

		public function render_review_box( $attrs ) {

			if ( function_exists( 'gulir_single_review' ) ) {
				ob_start();
				gulir_single_review( null, true );

				return ob_get_clean();
			}

			return false;
		}
	}
}

/** init */
Gulir_Shortcodes::get_instance();



