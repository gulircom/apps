<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_FW_Banner' ) ) :
	class Gulir_FW_Banner extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-banner';

		function __construct() {

			$this->params = [
				'title'        => '',
				'description'  => '',
				'image'        => '',
				'dark_image'   => '',
				'color_scheme' => '1',
				'submit'       => '',
				'url'          => '',
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Widget Banner', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display banner with text and background image in the sidebar.', 'gulir-core' ),
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
				'id'    => $this->get_field_id( 'description' ),
				'name'  => $this->get_field_name( 'description' ),
				'title' => esc_html__( 'Description', 'gulir-core' ),
				'value' => $instance['description'],
			] );

			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'image' ),
				'name'        => $this->get_field_name( 'image' ),
				'title'       => esc_html__( 'Background Image URL', 'gulir-core' ),
				'description' => esc_html__( 'Input a background image (attachment URL) for this banner.', 'gulir-core' ),
				'value'       => $instance['image'],
			] );

			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'dark_image' ),
				'name'        => $this->get_field_name( 'dark_image' ),
				'title'       => esc_html__( 'Dark Mode - Background Image URL', 'gulir-core' ),
				'description' => esc_html__( 'Input a background image (attachment URL) for this banner in dark mode.', 'gulir-core' ),
				'value'       => $instance['dark_image'],
			] );

			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'color_scheme' ),
				'name'    => $this->get_field_name( 'color_scheme' ),
				'title'   => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'desc'    => esc_html__( 'Text Select a text color scheme (light or dark) to suit with the background of the block it will be displayed on.', 'gulir-core' ),
				'options' => [
					'1' => esc_html__( 'Light Text', 'gulir-core' ),
					'0' => esc_html__( 'Dark Text', 'gulir-core' ),
				],
				'value'   => $instance['color_scheme'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'url' ),
				'name'  => $this->get_field_name( 'url' ),
				'title' => esc_html__( 'Button Destination URL', 'gulir-core' ),
				'value' => $instance['url'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'submit' ),
				'name'  => $this->get_field_name( 'submit' ),
				'title' => esc_html__( 'Button Label', 'gulir-core' ),
				'value' => $instance['submit'],
			] );
		}

		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			echo $args['before_widget'];
			rb_sidebar_banner( $instance );
			echo $args['after_widget'];
		}
	}
endif;