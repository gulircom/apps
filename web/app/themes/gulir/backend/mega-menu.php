<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Admin_Mega_Menu', false ) ) {
	/**
	 * Class Gulir_Admin_Mega_Menu
	 */
	class Gulir_Admin_Mega_Menu {

		private static $instance;

		public static function get_instance() {

			if ( self::$instance === null ) {
				return new self();
			}

			return self::$instance;
		}

		public function __construct() {

			self::$instance = $this;

			add_action( 'wp_nav_menu_item_custom_fields', [ $this, 'settings' ], 10, 5 );
			add_action( 'wp_update_nav_menu', [ $this, 'update_settings' ], 10, 1 );
		}

		/**
		 * @param $item_id
		 * @param $item
		 * @param $depth
		 * @param $args
		 * @param $id
		 * setting form
		 */
		public function settings( $item_id, $item, $depth, $args, $id ) {

			global $wp_registered_sidebars;

			$settings = rb_get_nav_item_meta( 'gulir_menu_meta', $item_id );

			$columns_config       = [
					'1' => esc_html__( '1 Column', 'gulir' ),
					'2' => esc_html__( '2 Columns', 'gulir' ),
					'3' => esc_html__( '3 Columns', 'gulir' ),
					'4' => esc_html__( '4 Columns', 'gulir' ),
					'5' => esc_html__( '5 Columns', 'gulir' ),
			];
			$mega_category        = '';
			$mega_layout          = '';
			$mega_columns         = '';
			$mega_cpr             = '';
			$icon                 = '';
			$icon_id              = '';
			$icon_image           = '';
			$dark_icon_image      = '';
			$sub_label            = '';
			$sub_label_color      = '';
			$sub_label_bg         = '';
			$sub_label_dark_color = '';
			$sub_label_dark_bg    = '';
			$mega_shortcode       = '';
			$mega_width           = '';
			$mega_left            = '';
			$mega_background      = '';

			if ( isset( $settings['category'] ) ) {
				$mega_category = $settings['category'];
			}
			if ( isset( $settings['layout'] ) ) {
				$mega_layout = $settings['layout'];
			}
			if ( isset( $settings['sub_scheme'] ) ) {
				$mega_scheme = $settings['sub_scheme'];
			}
			if ( isset( $settings['columns'] ) ) {
				$mega_columns = $settings['columns'];
			}
			if ( isset( $settings['columns_per_row'] ) ) {
				$mega_cpr = $settings['columns_per_row'];
			}
			if ( isset( $settings['icon'] ) ) {
				$icon = $settings['icon'];
			}
			if ( isset( $settings['icon_id'] ) ) {
				$icon_id = $settings['icon_id'];
			}
			if ( isset( $settings['icon_image'] ) ) {
				$icon_image = $settings['icon_image'];
			}
			if ( isset( $settings['dark_icon_image'] ) ) {
				$dark_icon_image = $settings['dark_icon_image'];
			}
			if ( isset( $settings['sub_label'] ) ) {
				$sub_label = $settings['sub_label'];
			}
			if ( isset( $settings['sub_label_color'] ) ) {
				$sub_label_color = $settings['sub_label_color'];
			}
			if ( isset( $settings['sub_label_bg'] ) ) {
				$sub_label_bg = $settings['sub_label_bg'];
			}
			if ( isset( $settings['sub_label_dark_color'] ) ) {
				$sub_label_dark_color = $settings['sub_label_dark_color'];
			}
			if ( isset( $settings['sub_label_dark_bg'] ) ) {
				$sub_label_dark_bg = $settings['sub_label_dark_bg'];
			}
			if ( isset( $settings['mega_shortcode'] ) ) {
				$mega_shortcode = $settings['mega_shortcode'];
			}
			if ( isset( $settings['mega_width'] ) ) {
				$mega_width = $settings['mega_width'];
			}
			if ( isset( $settings['mega_left'] ) ) {
				$mega_left = $settings['mega_left'];
			}
			if ( isset( $settings['mega_background'] ) ) {
				$mega_background = $settings['mega_background'];
			}
			?>
			<div class="clearfix"></div>
			<div class="rb-menu-settings">
				<?php if ( empty( $depth ) ) :
					if ( 'category' === $item->object ) : ?>
						<h4 class="rb-mega-title"><?php esc_html_e( 'Category Mega Menu', 'gulir' ); ?></h4>
						<span class="rb-menu-description"><?php esc_html_e( 'Display latest posts of this category. These settings below will override the default settings in Theme Options.', 'gulir' ); ?></span>
						<div class="rb-menu-elements">
							<div class="rb-menu-el">
								<label class="rb-menu-label" for="edit-mega-category-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Mega Menu', 'gulir' ); ?></label>
								<select class="rb-menu-setting mega-category-setting" id="edit-mega-category-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][category]">
									<option value="0" <?php if ( empty( $mega_category ) ) {
										echo 'selected';
									} ?> ><?php esc_html_e( '-Disable-', 'gulir' ); ?></option>
									<option value="1" <?php if ( ! empty( $mega_category ) ) {
										echo 'selected';
									} ?> ><?php esc_html_e( 'Enable', 'gulir' ); ?></option>
								</select>
							</div>
							<div class="rb-menu-el">
								<label class="rb-menu-label" for="edit-mega-layout-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Blog Listing Layout', 'gulir' ); ?></label>
								<select id="edit-mega-layout-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][layout]">
									<option value="0" <?php if ( empty( $mega_layout ) ) {
										echo 'selected';
									} ?> ><?php esc_html_e( '- Default -', 'gulir' ); ?></option>
									<option value="1" <?php if ( ! empty( $mega_layout ) ) {
										echo 'selected';
									} ?> ><?php esc_html_e( 'Hierarchical', 'gulir' ); ?></option>
								</select>
							</div>
							<div class="rb-menu-el">
								<label class="rb-menu-label" for="edit-mega-scheme-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Text Color Scheme', 'gulir' ); ?></label>
								<select id="edit-mega-scheme-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][sub_scheme]">
									<option value="0" <?php if ( empty( $mega_scheme ) ) {
										echo 'selected';
									} ?> ><?php esc_html_e( '- Default -', 'gulir' ); ?></option>
									<option value="-1" <?php if ( ! empty( $mega_scheme ) && '-1' === (string) $mega_scheme ) {
										echo 'selected';
									} ?> ><?php esc_html_e( 'Dark Text', 'gulir' ); ?></option>
									<option value="1" <?php if ( ! empty( $mega_scheme ) && '1' === (string) $mega_scheme ) {
										echo 'selected';
									} ?> ><?php esc_html_e( 'Light Text', 'gulir' ); ?></option>
								</select>
							</div>
							<div class="rb-menu-el">
								<label class="rb-menu-label" for="edit-menu-mega-background-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Background', 'gulir' ); ?></label>
								<input type="text" placeholder="#ffffff" id="edit-menu-sub-mega-background-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][mega_background]" value="<?php echo esc_html( $mega_background ); ?>" />
							</div>
							<span class="rb-menu-description"><?php esc_html_e( 'The Text Color Scheme and Background affect the default mode for this menu item only. Light Color Schemes will be applied in dark mode.', 'gulir' ); ?></span>
						</div>
					<?php elseif ( 'custom' === $item->object ) : ?>
						<h4 class="rb-mega-title"><?php esc_html_e( 'Column Mega Menu', 'gulir' ); ?></h4>
						<span class="rb-menu-description"><?php esc_html_e( 'Assign this sidebar (Appearance > Widgets) as this mega menu. Each widget is added will be corresponding to a column.', 'gulir' ); ?></span>
						<div class="rb-menu-elements">
							<div class="rb-menu-el">
								<label class="rb-menu-label" for="edit-mega-columns-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Mega Menu', 'gulir' ); ?></label>
								<select class="rb-menu-setting" id="edit-mega-columns-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][columns]">
									<?php
									echo '<option value="0" ' . ( empty( $mega_columns ) ? 'selected' : '' ) . '>' . esc_html__( '- Disable -', 'gulir' ) . '</option>';
									foreach ( $wp_registered_sidebars as $key => $value ) :
										if ( $key == $mega_columns ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo '<option value="' . $key . '" ' . $selected . '>' . esc_html( $value['name'] ) . '</option>';
									endforeach;
									?>
								</select>
							</div>
							<div class="rb-menu-el">
								<label class="rb-menu-label" for="edit-mega-cpr-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Columns per Row', 'gulir' ); ?></label>
								<select id="edit-mega-cpr-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][columns_per_row]">
									<?php
									echo '<option value="0" ' . ( empty( $mega_cpr ) ? 'selected' : '' ) . '>' . esc_html__( '- Select Columns -', 'gulir' ) . '</option>';
									foreach ( $columns_config as $key => $value ) :
										if ( $key == $mega_cpr ) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo '<option value="' . $key . '" ' . $selected . '>' . esc_html( $value ) . '</option>';
									endforeach;
									?>
								</select>
							</div>
						</div>
						<h4 class="rb-mega-title"><?php esc_html_e( 'or Ruby Templates Shortcode', 'gulir' ); ?></h4>
						<span class="rb-menu-description"><?php esc_html_e( 'This setting will override on above settings.', 'gulir' ); ?></span>
						<div class="rb-menu-el">
							<label class="rb-menu-label" for="edit-mega-shortcode-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Template Shortcode', 'gulir' ); ?></label>
							<textarea class="rb-menu-setting ruby-template-input" rows="2" cols="50" placeholder="[Ruby_E_Template id=&quot;1&quot;]" id="edit-mega-shortcode-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][mega_shortcode]" /><?php echo stripslashes( $mega_shortcode ); ?></textarea>
						</div>
						<div class="rb-menu-el">
							<label class="rb-menu-label" for="edit-mega-width-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Section Width', 'gulir' ); ?></label>
							<span class="rb-menu-description"><?php esc_html_e( 'Input a width value (in px) for this mega section. Leave blank or 0 to set to full width.', 'gulir' ); ?></span>
							<input type="text" class="rb-menu-setting rb-fw-input" id="edit-mega-width-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][mega_width]" value="<?php echo esc_attr( $mega_width ); ?>" />
						</div>
						<div class="rb-menu-el">
							<label class="rb-menu-label" for="edit-mega-left-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Left Relative Position', 'gulir' ); ?></label>
							<span class="rb-menu-description"><?php esc_html_e( 'Input a left relative position value (in pixel) to the parent element for the mega menu. This setting will apply when the width is set, negative value allowed.', 'gulir' ); ?></span>
							<input type="text" class="rb-menu-setting rb-fw-input" id="edit-mega-left-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][mega_left]" value="<?php echo esc_attr( $mega_left ); ?>" />
						</div>
					<?php endif;
				endif; ?>
				<h4 class="rb-mega-title"><?php esc_html_e( 'Navigation Sub Label', 'gulir' ); ?></h4>
				<span class="rb-menu-description"><?php esc_html_e( 'Display a sub label after this navigation label.', 'gulir' ); ?></span>
				<div class="rb-menu-elements">
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-sub-label-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Sub Label', 'gulir' ); ?></label>
						<input placeholder="New" type="text" id="edit-menu-sub-label-title-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][sub_label]" value="<?php echo esc_html( $sub_label ); ?>" />
					</div>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-sub-label-color-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Text Color', 'gulir' ); ?></label>
						<input type="text" placeholder="#ffffff" id="edit-menu-sub-label-color-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][sub_label_color]" value="<?php echo esc_html( $sub_label_color ); ?>" />
					</div>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-sub-label-bg-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Background', 'gulir' ); ?></label>
						<input type="text" placeholder="#33333" id="edit-menu-sub-label-bg-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][sub_label_bg]" value="<?php echo esc_html( $sub_label_bg ); ?>" />
					</div>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-sub-label-dark-color-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Dark Mode - Text Color', 'gulir' ); ?></label>
						<input type="text" placeholder="#33333" id="edit-menu-sub-label-dark-color-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][sub_label_dark_color]" value="<?php echo esc_html( $sub_label_dark_color ); ?>" />
					</div>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-sub-label-dark-bg-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Dark Mode - Background', 'gulir' ); ?></label>
						<input type="text" placeholder="#33333" id="edit-menu-sub-label-dark-bg-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][sub_label_dark_bg]" value="<?php echo esc_html( $sub_label_dark_bg ); ?>" />
					</div>
				</div>
				<h4 class="rb-mega-title"><?php esc_html_e( 'Menu Icon', 'gulir' ); ?></h4>
				<span class="rb-menu-description"><?php esc_html_e( 'Display an icon before the menu label. The top setting takes priority, so leave it blank to apply the settings below.', 'gulir' ); ?></span>
				<div class="rb-menu-elements">
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-icon-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Icon Classname', 'gulir' ); ?></label>
						<input placeholder="fa fa-home" type="text" id="edit-menu-icon-title-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][icon]" value="<?php echo esc_html( $icon ); ?>" />
						<span class="rb-menu-item-description"><?php esc_html_e( 'Please ensure that Font Awesome is enabled under "Theme Options > Theme Design > Font Awesome" if you are using this font icon classname. Version 5 Free is supported!', 'gulir' ); ?></span>
					</div>
					<h4 class="rb-mega-title"><?php esc_html_e( 'or Attachment/SVG Icon', 'gulir' ); ?></h4>
					<span class="rb-menu-description"><?php esc_html_e( 'Input attachment image/SVG url or attachment ID to show your icon.', 'gulir' ); ?></span>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-icon-id-title-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'SVG Attachment ID', 'gulir' ); ?></label>
						<input placeholder="1" type="text" id="edit-menu-icon-id-title-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][icon_id]" value="<?php echo esc_attr( $icon_id ); ?>" />
						<span class="rb-menu-item-description"><?php esc_html_e( 'This setting will take priority over the options below. Enter the attachment ID of the uploaded SVG. This method will directly embed the SVG into the menu title, allowing you to control its color using the menu text color.', 'gulir' ); ?></span>
						<span class="rb-menu-item-description"><?php esc_html_e( 'Tip: Ensure the colors in the SVG are set to "CurrentColor" for the fill or stroke properties, allowing the menu color to be applied.', 'gulir' ); ?></span>
					</div>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-icon-image-title-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'or Attachment/SVG URL', 'gulir' ); ?></label>
						<textarea placeholder="https://yoursite.com/upload/year/month/icon.svg" rows="2" cols="50" id="edit-menu-icon-image-title-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][icon_image]" /><?php echo esc_url( $icon_image ); ?></textarea>
						<span class="rb-menu-item-description"><?php esc_html_e( 'Embed SVGs or images as background using CSS. This is useful when you want to use images or a colorful SVGs.', 'gulir' ); ?></span>
					</div>
					<div class="rb-menu-el">
						<label class="rb-menu-label" for="edit-menu-dark-icon-image-title-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Dark Mode - Attachment/SVG URL', 'gulir' ); ?></label>
						<textarea placeholder="https://yoursite.com/upload/year/month/dark-icon.svg" rows="2" cols="50" id="edit-menu-dark-icon-image-title-<?php echo esc_attr( $item_id ); ?>" name="rb_menu[<?php echo esc_attr( $item_id ); ?>][dark_icon_image]" /><?php echo esc_url( $dark_icon_image ); ?></textarea>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Save all custom menu item settings and update cache.
		 *
		 * This method runs once when a menu is saved.
		 * It updates both the post meta (for backward compatibility)
		 * and a single wp_options cache (for faster access).
		 *
		 * @param int $menu_id The ID of the menu being updated.
		 *
		 * @return void
		 */
		public function update_settings( $menu_id ) {

			// Ensure the current user has the right capability
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Bail if no data provided
			if ( empty( $_POST['rb_menu'] ) || ! is_array( $_POST['rb_menu'] ) ) {
				return;
			}

			$cache_key = 'gulir_queries_cache';
			$meta_key  = 'gulir_menu_meta';

			// Load existing cache or initialize
			$all_caches = get_option( $cache_key, [] );

			foreach ( $_POST['rb_menu'] as $item_id => $settings ) {

				$item_id = (int) $item_id;

				if ( ! $item_id ) {
					continue;
				}

				// Sanitize all values
				$validated_settings = array_map( 'sanitize_text_field', $settings );

				// Keep post meta for compatibility
				update_metadata( 'post', $item_id, $meta_key, $validated_settings );

				// Update cache
				$all_caches[ $meta_key . '_' . $item_id ] = $validated_settings;
			}

			// Save everything in one query
			update_option( $cache_key, $all_caches, false );
		}

		/**
		 * Display an admin-only notification message with a link to menu locations.
		 *
		 * @param string $messenger The message to display.
		 * @return void
		 */
		function empty_notification( $messenger = '' ) {
			if ( current_user_can( 'manage_options' ) ) { ?>
				<div class="rb-error">
					<p><?php echo esc_html( $messenger ); ?>
						<a href="<?php echo get_admin_url( get_current_blog_id(), 'nav-menus.php?action=locations' ); ?>"><?php esc_html_e( 'Manage Locations', 'gulir' ); ?></a>
					</p>
				</div>
			<?php }
		}

	}
}

/** load */
Gulir_Admin_Mega_Menu::get_instance();