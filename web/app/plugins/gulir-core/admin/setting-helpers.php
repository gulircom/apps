<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Rb_Category_Select_Walker', false ) ) {
	class Rb_Category_Select_Walker extends Walker {

		var $tree_type = 'category';
		var $cat_array = [];
		var $db_fields = [
			'id'     => 'term_id',
			'parent' => 'parent',
		];

		public function start_lvl( &$output, $depth = 0, $args = [] ) {
		}

		public function end_lvl( &$output, $depth = 0, $args = [] ) {
		}

		public function start_el( &$output, $object, $depth = 0, $args = [], $current_object_id = 0 ) {

			$this->cat_array[ str_repeat( ' - ', $depth ) . $object->name . ' - [ ID: ' . $object->term_id . ' / Posts: ' . $object->category_count . ' ]' ] = $object->term_id;
		}

		public function end_el( &$output, $object, $depth = 0, $args = [] ) {
		}
	}
}

if ( ! function_exists( 'rb_admin_get_template_part' ) ) {
	/**
	 * @param       $slug
	 * @param null  $name
	 * @param array $params
	 *
	 * @return bool|string
	 * load template
	 */
	function rb_admin_get_template_part( $slug, $name = null, $params = [] ) {

		$name = (string) $name;
		if ( '' !== $name ) {
			$template = "{$slug}-{$name}.php";
		} else {
			$template = "{$slug}.php";
		}

		$template = GULIR_CORE_PATH . $template;

		if ( file_exists( $template ) ) {
			if ( is_array( $params ) && count( $params ) ) {
				extract( $params, EXTR_SKIP );
			}

			ob_start();
			include( $template );

			return ob_get_clean();
		}

		return false;
	}
}

if ( ! function_exists( 'rb_admin_hide_code' ) ) {
	/**
	 * @param string $code
	 *
	 * @return bool|string
	 * hide purchase info
	 */
	function rb_admin_hide_code( $code = '' ) {

		if ( $code ) {
			return preg_replace( '[[a-z0-9]]', '*', substr( esc_attr( $code ), 0, - 9 ) ) . substr( esc_attr( $code ), - 9, 9 );
		}

		return false;
	}
}

if ( ! function_exists( 'gulir_create_widget_heading_field' ) ) {
	/**
	 * @param array $param
	 * create text field
	 */
	function gulir_create_widget_heading_field( $param = [] ) {

		$param = wp_parse_args( $param, [
			'id'          => '',
			'title'       => '',
			'name'        => '',
			'description' => '',
		] );
		?>
		<div class="rb-w-input rb-wheading">
			<h3><?php echo esc_html( $param['title'] ); ?></h3>
			<?php echo ( $param['description'] ) ? '<p>' . gulir_strip_tags( $param['description'] ) . '</p>' : false; ?>
			<label for="<?php echo esc_attr( $param['id'] ); ?>"></label>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_create_widget_text_field' ) ) {
	/**
	 * @param array $param
	 * create text field
	 */
	function gulir_create_widget_text_field( $param = [] ) {

		$param = wp_parse_args( $param, [
			'id'          => '',
			'title'       => '',
			'name'        => '',
			'value'       => '',
			'description' => '',
			'placeholder' => '',
		] );
		?>
		<div class="rb-w-input">
			<h4><?php echo esc_html( $param['title'] ); ?></h4>
			<?php echo ( $param['description'] ) ? '<p>' . gulir_strip_tags( $param['description'] ) . '</p>' : false; ?>
			<label for="<?php echo esc_attr( $param['id'] ); ?>"></label>
			<input placeholder="<?php echo esc_attr( $param['placeholder'] ); ?>" class="widefat" id="<?php echo esc_attr( $param['id'] ); ?>" name="<?php echo esc_attr( $param['name'] ); ?>" type="text" value="<?php echo esc_html( $param['value'] ); ?>"/>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_create_widget_select_field' ) ) {
	/**
	 * @param array $param
	 * create select field
	 */
	function gulir_create_widget_select_field( $param = [] ) {

		$param = wp_parse_args( $param, [
			'id'          => '',
			'title'       => '',
			'name'        => '',
			'options'     => [],
			'data'        => '',
			'value'       => '',
			'description' => '',
		] );

		if ( ! empty( $param['data'] ) ) {
			switch ( $param['data'] ) {
				case 'menu' :
					$param['options'] = gulir_menu_selection();
					break;
				case 'menu_locations' :
					$param['options'] = gulir_menu_location_selection();
					break;
				case 'page' :
					$param['options'] = gulir_page_selection();
					break;
				case 'sidebar' :
					$param['options'] = gulir_sidebar_selection();
					break;
				case 'user' :
					$param['options'] = gulir_user_selection();
					break;
				case 'template' :
					$param['options'] = gulir_ruby_template_selection();
					break;
				case 'category' :
					$param['options'] = gulir_config_cat_selection();
					break;
				case 'on-off' :
					$param['options'] = [
						'on'  => esc_html__( 'Enable', 'gulir-core' ),
						'off' => esc_html__( 'Disable', 'gulir-core' ),
					];
					break;
			}
		}
		?>
		<div class="rb-w-input">
			<h4><?php echo esc_html( $param['title'] ); ?></h4>
			<?php echo ( $param['description'] ) ? '<p>' . gulir_strip_tags( $param['description'] ) . '</p>' : false; ?>
			<label for="<?php echo esc_attr( $param['id'] ); ?>"></label>
			<select class="widefat" id="<?php echo esc_attr( $param['id'] ); ?>" name="<?php echo esc_attr( $param['name'] ); ?>">
				<?php foreach ( $param['options'] as $option_value => $option_title ) :
					if ( (string) $param['value'] === (string) $option_value ) : ?>
						<option value="<?php echo esc_html( $option_value ); ?>" selected><?php echo esc_html( $option_title ); ?></option>
					<?php else: ?>
						<option value="<?php echo esc_html( $option_value ); ?>"><?php echo esc_html( $option_title ); ?></option>
					<?php endif;
				endforeach; ?>
			</select>
		</div>
	<?php }
}

if ( ! function_exists( 'gulir_create_widget_textarea_field' ) ) {
	/**
	 * @param array $param
	 * create textarea field
	 */
	function gulir_create_widget_textarea_field( $param = [] ) {

		$param = wp_parse_args( $param, [
			'id'          => '',
			'title'       => '',
			'name'        => '',
			'value'       => '',
			'description' => '',
			'row'         => '',
			'placeholder' => '',
		] );

		if ( empty( $param['row'] ) ) {
			$param['row'] = 4;
		}
		?>
		<div class="rb-w-input">
			<h4><?php echo esc_html( $param['title'] ); ?></h4>
			<?php echo ( $param['description'] ) ? '<p>' . gulir_strip_tags( $param['description'] ) . '</p>' : false; ?>
			<label for="<?php echo esc_attr( $param['id'] ); ?>"></label>
			<textarea placeholder="<?php echo esc_attr( $param['placeholder'] ); ?>" rows="<?php echo esc_attr( $param['row'] ); ?>>" cols="10" id="<?php echo esc_attr( $param['name'] ); ?>" name="<?php echo esc_attr( $param['name'] ); ?>" class="widefat"><?php echo esc_html( $param['value'] ); ?></textarea>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gulir_menu_location_selection' ) ) {
	/**
	 * @return array
	 * get nav selection
	 */
	function gulir_menu_location_selection() {

		$data = [];
		global $_wp_registered_nav_menus;

		if ( is_array( $_wp_registered_nav_menus ) ) {
			foreach ( $_wp_registered_nav_menus as $key => $value ) {
				$data[ $key ] = $value;
			}
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_menu_selection' ) ) {
	/**
	 * @return array
	 * menu selection
	 */
	function gulir_menu_selection() {

		$data  = [];
		$menus = wp_get_nav_menus();
		if ( ! empty ( $menus ) ) {
			foreach ( $menus as $item ) {
				$data[ $item->term_id ] = $item->name;
			}
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_config_cat_selection' ) ) {
	/**
	 * @param false  $dynamic
	 * @param string $post_type
	 *
	 * @return array
	 */
	function gulir_config_cat_selection( $dynamic = false, $post_type = 'post' ) {

		$data = [
			'0' => esc_html__( '-- All categories --', 'gulir-core' ),
		];

		if ( $dynamic ) {
			$data['dynamic'] = esc_html__( 'Dynamic Query', 'gulir-core' );
		}

		$categories = get_categories( [
			'hide_empty' => 0,
			'type'       => $post_type,
			'parent'     => '0',
		] );

		$pos = 1;
		foreach ( $categories as $index => $item ) {
			$children = get_categories( [
				'hide_empty' => 0,
				'type'       => $post_type,
				'child_of'   => $item->term_id,
			] );
			if ( ! empty( $children ) ) {
				array_splice( $categories, $pos + $index, 0, $children );
				$pos += count( $children );
			}
		}

		foreach ( $categories as $item ) {
			$deep = '';
			if ( ! empty( $item->parent ) ) {
				$deep = '--';
			}
			$data[ $item->term_id ] = $deep . ' ' . esc_attr( $item->name ) . ' - [ID: ' . esc_attr( $item->term_id ) . ' / Posts: ' . gulir_count_posts_category( $item ) . ']';
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_ruby_template_selection' ) ) {
	/**
	 * @return array
	 * get page select
	 */
	function gulir_ruby_template_selection() {

		$data                   = [];
		$args['posts_per_page'] = - 1;
		$args['post_type']      = 'rb-etemplate';
		$templates              = get_posts( $args );
		$data[0]                = esc_html__( '- Select a Template -', 'gulir-core' );

		if ( ! empty ( $templates ) ) {
			foreach ( $templates as $template ) {
				$data[ $template->ID ] = $template->post_title . ' - [Ruby_E_Template id="' . $template->ID . '"]';
			}
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_sidebar_selection' ) ) {
	/**
	 * @return array
	 * sidebar selection
	 */
	function gulir_sidebar_selection() {

		$data = [];

		global $wp_registered_sidebars;

		foreach ( $wp_registered_sidebars as $key => $value ) {
			$data[ $key ] = $value['name'];
		}

		return $data;
	}
}

if ( ! function_exists( 'gulir_user_selection' ) ) {
	/**
	 * @return array
	 * user selection
	 */
	function gulir_user_selection() {

		$data  = [];
		$users = get_users();
		if ( ! empty ( $users ) ) {
			foreach ( $users as $user ) {
				$data[ $user->ID ] = $user->display_name;
			}
		}

		return $data;
	}
}
