<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Ad_Script' ) ) :
	class Gulir_Ad_Script extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-ad-script';

		function __construct() {

			$this->params = [
				'title'        => esc_html__( '- Advertisement -', 'gulir-core' ),
				'code'         => '',
				'size'         => 0,
				'desktop_size' => 1,
				'tablet_size'  => 2,
				'mobile_size'  => 3,
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Widget Ad Script', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( 'Display your Js ad or Google Adsense in the sidebars or full width widget areas.', 'gulir-core' ),
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
				'title' => esc_html__( 'Description', 'gulir-core' ),
				'value' => $instance['title'],
			] );

			gulir_create_widget_textarea_field( [
				'id'          => $this->get_field_id( 'code' ),
				'name'        => $this->get_field_name( 'code' ),
				'title'       => esc_html__( 'Ad/Adsense Code', 'gulir-core' ),
				'description' => esc_html__( 'Input your custom ad or Adsense code. Use Adsense units code to ensure it display exactly where you put. The widget will not work if you are using auto ads.', 'gulir-core' ),
				'value'       => $instance['code'],
			] );

			gulir_create_widget_select_field( [
				'id'          => $this->get_field_id( 'size' ),
				'name'        => $this->get_field_name( 'size' ),
				'title'       => esc_html__( 'Ad Size', 'gulir-core' ),
				'description' => esc_html__( 'Select a custom size for this ad if you use the adsense ad units code.', 'gulir-core' ),
				'options'     => [
					'0' => esc_html__( 'Do not Override', 'gulir-core' ),
					'1' => esc_html__( 'Custom Size Below', 'gulir-core' ),
				],
				'value'       => $instance['size'],
			] );

			gulir_create_widget_select_field( [
				'id'          => $this->get_field_id( 'desktop_size' ),
				'name'        => $this->get_field_name( 'desktop_size' ),
				'title'       => esc_html__( 'Size on Desktop', 'gulir-core' ),
				'description' => esc_html__( 'Select a size on desktop devices.', 'gulir-core' ),
				'options'     => $this->ad_sizes_config(),
				'value'       => $instance['desktop_size'],
			] );

			gulir_create_widget_select_field( [
				'id'          => $this->get_field_id( 'tablet_size' ),
				'name'        => $this->get_field_name( 'tablet_size' ),
				'title'       => esc_html__( 'Size on Tablet', 'gulir-core' ),
				'description' => esc_html__( 'Select a size on tablet devices.', 'gulir-core' ),
				'options'     => $this->ad_sizes_config(),
				'value'       => $instance['tablet_size'],
			] );

			gulir_create_widget_select_field( [
				'id'          => $this->get_field_id( 'mobile_size' ),
				'name'        => $this->get_field_name( 'mobile_size' ),
				'title'       => esc_html__( 'Size on Mobile', 'gulir-core' ),
				'description' => esc_html__( 'Select a size on mobile devices/', 'gulir-core' ),
				'options'     => $this->ad_sizes_config(),
				'value'       => $instance['mobile_size'],
			] );
		}

		function widget( $args, $instance ) {

			$instance['cache_id'] = $args['widget_id'];

			$instance = wp_parse_args( (array) $instance, $this->params );

			echo $args['before_widget'];
			$instance['id']         = $args['widget_id'];
			$instance['no_spacing'] = true;

			if ( ! empty( $instance['title'] ) ) {
				$instance['description'] = $instance['title'];
			}

			if ( ! empty( $instance['code'] ) ) : ?>
				<?php echo gulir_get_adsense( $instance ); ?>
			<?php endif;

			echo $args['after_widget'];
		}

		public function ad_sizes_config() {

			return [
				'0'  => esc_html__( 'Hide on Desktop', 'gulir-core' ),
				'1'  => esc_html__( 'Leaderboard (728x90)', 'gulir-core' ),
				'2'  => esc_html__( 'Banner (468x60)', 'gulir-core' ),
				'3'  => esc_html__( 'Half banner (234x60)', 'gulir-core' ),
				'4'  => esc_html__( 'Button (125x125)', 'gulir-core' ),
				'5'  => esc_html__( 'Skyscraper (120x600)', 'gulir-core' ),
				'6'  => esc_html__( 'Wide Skyscraper (160x600)', 'gulir-core' ),
				'7'  => esc_html__( 'Small Rectangle (180x150)', 'gulir-core' ),
				'8'  => esc_html__( 'Vertical Banner (120 x 240)', 'gulir-core' ),
				'9'  => esc_html__( 'Small Square (200x200)', 'gulir-core' ),
				'10' => esc_html__( 'Square (250x250)', 'gulir-core' ),
				'11' => esc_html__( 'Medium Rectangle (300x250)', 'gulir-core' ),
				'12' => esc_html__( 'Large Rectangle (336x280)', 'gulir-core' ),
				'13' => esc_html__( 'Half Page (300x600)', 'gulir-core' ),
				'14' => esc_html__( 'Portrait (300x1050)', 'gulir-core' ),
				'15' => esc_html__( 'Mobile Banner (320x50)', 'gulir-core' ),
				'16' => esc_html__( 'Large Leaderboard (970x90)', 'gulir-core' ),
				'17' => esc_html__( 'Billboard (970x250)', 'gulir-core' ),
				'18' => esc_html__( 'Mobile Banner (320x100)', 'gulir-core' ),
				'19' => esc_html__( 'Mobile Friendly (300x100)', 'gulir-core' ),
			];
		}
	}
endif;