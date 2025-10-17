<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_W_Address' ) ) :
	class Gulir_W_Address extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-address';

		function __construct() {

			$this->params = [
				'title'            => '',
				'address_title'    => '',
				'address'          => '',
				'phone_title'      => '',
				'phone'            => '',
				'tel'              => '',
				'email'            => '',
				'additional_title' => '',
				'additional'       => '',
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Widget Address', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display the address information in the sidebar.', 'gulir-core' ),
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

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'address_title' ),
				'name'  => $this->get_field_name( 'address_title' ),
				'title' => esc_html__( 'Address Title', 'gulir-core' ),
				'value' => $instance['address_title'],
			] );

			gulir_create_widget_textarea_field( [
				'id'    => $this->get_field_id( 'address' ),
				'name'  => $this->get_field_name( 'address' ),
				'title' => esc_html__( 'Office Address', 'gulir-core' ),
				'value' => $instance['address'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'phone_title' ),
				'name'  => $this->get_field_name( 'phone_title' ),
				'title' => esc_html__( 'Phone/Tel Label', 'gulir-core' ),
				'value' => $instance['phone_title'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'phone' ),
				'name'  => $this->get_field_name( 'phone' ),
				'title' => esc_html__( 'Phone Number', 'gulir-core' ),
				'value' => $instance['phone'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'tel' ),
				'name'  => $this->get_field_name( 'tel' ),
				'title' => esc_html__( 'Tel Number', 'gulir-core' ),
				'value' => $instance['tel'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'email' ),
				'name'  => $this->get_field_name( 'email' ),
				'title' => esc_html__( 'Email Address', 'gulir-core' ),
				'value' => $instance['email'],
			] );

			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'additional_title' ),
				'name'  => $this->get_field_name( 'additional_title' ),
				'title' => esc_html__( 'Additional Label', 'gulir-core' ),
				'value' => $instance['additional_title'],
			] );

			gulir_create_widget_textarea_field( [
				'id'    => $this->get_field_id( 'additional' ),
				'name'  => $this->get_field_name( 'additional' ),
				'title' => esc_html__( 'Additional Info', 'gulir-core' ),
				'value' => $instance['additional'],
			] );
		}

		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->params );

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . gulir_strip_tags( $instance['title'] ) . $args['after_title'];
			}
			if ( ! empty( $instance['address_title'] ) || ! empty( $instance['address'] ) || ! empty( $instance['phone_title'] ) || ! empty( $instance['phone'] ) || ! empty( $instance['tel'] ) || ! empty( $instance['email'] ) || ! empty( $instance['additional'] ) )  : ?>
				<div class="address-info">
					<?php
					if ( ! empty( $instance['address_title'] ) ) : ?>
						<h5 class="office-address-title h4"><?php gulir_render_inline_html( $instance['address_title'] ); ?></h5>
					<?php endif;
					if ( ! empty( $instance['address'] ) ) : ?>
						<div class="office-address"><?php gulir_render_svg( 'placeholder', '', 'address' ) ?><?php gulir_render_inline_html( $instance['address'] ); ?></div>
					<?php endif;
					if ( ! empty( $instance['phone_title'] ) ) : ?>
						<h5 class="phone-title h4"><?php gulir_render_inline_html( $instance['phone_title'] ); ?></h5>
					<?php endif;
					if ( ! empty( $instance['phone'] ) ) : ?>
						<div class="phone"><?php gulir_render_svg( 'smartphone', '', 'address' ) ?><?php gulir_render_inline_html( $instance['phone'] ); ?></div>
					<?php endif;
					if ( ! empty( $instance['tel'] ) ) : ?>
						<div class="tel"><?php gulir_render_svg( 'telephone', '', 'address' ) ?><?php gulir_render_inline_html( $instance['tel'] ); ?></div>
					<?php endif;
					if ( ! empty( $instance['email'] ) ) : ?>
						<div class="email"><?php gulir_render_svg( 'envelope', '', 'address' ) ?><?php gulir_render_inline_html( $instance['email'] ); ?></div>
					<?php endif;
					if ( ! empty( $instance['additional_title'] ) ) : ?>
						<h5 class="additional-title h4"><?php gulir_render_inline_html( $instance['additional_title'] ); ?></h5>
					<?php endif;
					if ( ! empty( $instance['additional'] ) ) : ?>
						<div class="additional"><?php gulir_render_inline_html( $instance['additional'] ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif;
			echo $args['after_widget'];
		}

	}
endif;