<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_W_Post', false ) ) {
	class Gulir_W_Post extends WP_Widget {

		private $params = [];
		private $widgetID = 'widget-post';

		function __construct() {

			$this->params = [
				'title'             => '',
				'posts_per_page'    => '4',
				'category'          => '',
				'categories'        => '',
				'category_not_in'   => '',
				'tags'              => '',
				'tag_not_in'        => '',
				'format'            => '0',
				'post_not_in'       => '',
				'post_in'           => '',
				'offset'            => '',
				'featured_position' => '',
				'order'             => 'date_post',
				'entry_meta'        => 'category',
			];

			parent::__construct( $this->widgetID, esc_html__( 'Gulir - Post Listing', 'gulir-core' ), [
				'classname'   => $this->widgetID,
				'description' => esc_html__( '[Sidebar Widget] Display a small list latest post listing in the sidebar.', 'gulir-core' ),
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
				'id'          => $this->get_field_id( 'category' ),
				'name'        => $this->get_field_name( 'category' ),
				'title'       => esc_html__( 'Category Filter', 'gulir-core' ),
				'description' => esc_html__( 'Select a category you would like to show.', 'gulir-core' ),
				'data'        => 'category',
				'value'       => $instance['category'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'categories' ),
				'name'        => $this->get_field_name( 'categories' ),
				'title'       => esc_html__( 'Categories Filter', 'gulir-core' ),
				'description' => esc_html__( 'Filter posts by multiple category IDs. Separated by commas (e.g. 1, 2, 3).', 'gulir-core' ),
				'value'       => $instance['categories'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'category_not_in' ),
				'name'        => $this->get_field_name( 'category_not_in' ),
				'title'       => esc_html__( 'Exclude Category IDs', 'gulir-core' ),
				'description' => esc_html__( 'Exclude category IDs. This setting is only available when selecting all categories, separated by commas (e.g. 1, 2, 3).', 'gulir-core' ),
				'value'       => $instance['category_not_in'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'tags' ),
				'name'        => $this->get_field_name( 'tags' ),
				'title'       => esc_html__( 'Tags Slug Filter', 'gulir-core' ),
				'description' => esc_html__( 'Filter posts by tag slugs, separated by commas (e.g. tag1,tag2,tag3).', 'gulir-core' ),
				'value'       => $instance['tags'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'tag_not_in' ),
				'name'        => $this->get_field_name( 'tag_not_in' ),
				'title'       => esc_html__( 'Exclude Tags Slug', 'gulir-core' ),
				'description' => esc_html__( 'Exclude tag slugs, separated by commas (e.g. tag1,tag2,tag3).', 'gulir-core' ),
				'value'       => $instance['tag_not_in'],
			] );
			gulir_create_widget_select_field( [
				'id'          => $this->get_field_id( 'format' ),
				'name'        => $this->get_field_name( 'format' ),
				'title'       => esc_html__( 'Post Format', 'gulir-core' ),
				'description' => esc_html__( 'Filter posts by post format.', 'gulir-core' ),
				'options'     => [
					'0'       => esc_html__( '- All -', 'gulir-core' ),
					'default' => esc_html__( 'Post Only', 'gulir-core' ),
					'gallery' => esc_html__( 'Gallery', 'gulir-core' ),
					'video'   => esc_html__( 'Video', 'gulir-core' ),
					'audio'   => esc_html__( 'Audio', 'gulir-core' ),
				],
				'value'       => $instance['format'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'post_not_in' ),
				'name'        => $this->get_field_name( 'post_not_in' ),
				'title'       => esc_html__( 'Exclude Post IDs', 'gulir-core' ),
				'description' => esc_html__( 'Exclude posts by Post IDs, separated by commas (e.g. 1,2,3).', 'gulir-core' ),
				'value'       => $instance['post_not_in'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'post_in' ),
				'name'        => $this->get_field_name( 'post_in' ),
				'title'       => esc_html__( 'Post IDs Filter', 'gulir-core' ),
				'description' => esc_html__( 'Filter posts by post IDs. separated by commas (e.g. 1,2,3).', 'gulir-core' ),
				'value'       => $instance['post_in'],
			] );
			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'order' ),
				'name'    => $this->get_field_name( 'order' ),
				'title'   => esc_html__( 'Order By', 'gulir-core' ),
				'options' => gulir_query_order_selection(),
				'value'   => $instance['order'],
			] );
			gulir_create_widget_text_field( [
				'id'    => $this->get_field_id( 'posts_per_page' ),
				'name'  => $this->get_field_name( 'posts_per_page' ),
				'title' => esc_html__( 'Posts per Page', 'gulir-core' ),
				'value' => $instance['posts_per_page'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'offset' ),
				'name'        => $this->get_field_name( 'offset' ),
				'title'       => esc_html__( 'Post Offset', 'gulir-core' ),
				'description' => esc_html__( 'Select number of posts to pass over. Leave this option blank to set at the beginning.', 'gulir-core' ),
				'value'       => $instance['offset'],
			] );
			gulir_create_widget_text_field( [
				'id'          => $this->get_field_id( 'entry_meta' ),
				'name'        => $this->get_field_name( 'entry_meta' ),
				'title'       => esc_html__( 'Entry Meta Tags', 'gulir-core' ),
				'description' => esc_html__( 'Input custom entry meta tags to show, separate by comma. e.g. avatar,author,update. Keys include: [avatar, author, date, category, tag, view, comment, update, read, like, bookmark, custom]', 'gulir-core' ),
				'value'       => $instance['entry_meta'],
			] );
			gulir_create_widget_select_field( [
				'id'      => $this->get_field_id( 'featured_position' ),
				'name'    => $this->get_field_name( 'featured_position' ),
				'title'   => esc_html__( 'Featured Image Position', 'gulir-core' ),
				'options' => [
					'0'     => esc_html__( 'Left', 'gulir-core' ),
					'right' => esc_html__( 'Right', 'gulir-core' ),
				],
				'value'   => $instance['featured_position'],
			] );
		}

		function widget( $args, $instance ) {

			$instance           = wp_parse_args( (array) $instance, $this->params );
			$instance['review'] = 'replace';
			$instance['unique'] = '1';

			if ( empty( $instance['entry_meta'] ) ) {
				$instance['entry_meta'] = [ 'category' ];
			} else {
				$instance['entry_meta'] = explode( ',', strval( $instance['entry_meta'] ) );
				$instance['entry_meta'] = array_map( 'trim', $instance['entry_meta'] );
			}

			if ( ! function_exists( 'gulir_query' ) || ! function_exists( 'gulir_loop_list_small_2' ) ) {
				return;
			}

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . gulir_strip_tags( $instance['title'] ) . $args['after_title'];
			}

			$_query = gulir_query( $instance );
			echo '<div class="widget-p-listing' . ( ! empty( $instance['featured_position'] ) ? ' is-feat-right' : '' ).'">';
			if ( $_query->have_posts() ) {
				gulir_loop_list_small_2( $instance, $_query );
				wp_reset_postdata();
			}
			echo '</div>';

			echo $args['after_widget'];
		}
	}
}