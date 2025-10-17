<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Gulir_Admin_Profile' ) ) {
	class Gulir_Admin_Profile {
		
		protected static $instance = null;
		
		static function get_instance() {
			
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}
		
		public function __construct() {
			
			self::$instance = $this;
			
			/** author settings supported */
			add_action( 'personal_options', [ $this, 'register_author_settings' ], 10, 1 );
			add_action( 'personal_options_update', [ $this, 'update_author_settings' ], 10, 1 );
			add_action( 'edit_user_profile_update', [ $this, 'update_author_settings' ], 10, 1 );
			add_filter( 'user_contactmethods', [ $this, 'user_contactmethods' ], 10 );
		}

		/**
		 * Supported of user contact methods.
		 *
		 * @param array|string $user User data or an empty array if not provided.
		 *
		 * @return array List of user contact methods with labels.
		 */
		function user_contactmethods( $user ) {

			return array_merge( (array) $user, [
					'job'         => esc_html__( 'Job Name', 'gulir-core' ),
					'facebook'    => esc_html__( 'Facebook profile URL', 'gulir-core' ),
					'twitter_url' => esc_html__( 'X profile URL', 'gulir-core' ),
					'youtube'     => esc_html__( 'Youtube profile URL', 'gulir-core' ),
					'instagram'   => esc_html__( 'Instagram profile URL', 'gulir-core' ),
					'pinterest'   => esc_html__( 'Pinterest profile URL', 'gulir-core' ),
					'tiktok'      => esc_html__( 'TikTok profile URL', 'gulir-core' ),
					'linkedin'    => esc_html__( 'LinkedIn profile URL', 'gulir-core' ),
					'medium'      => esc_html__( 'Medium profile URL', 'gulir-core' ),
					'twitch'      => esc_html__( 'Twitch profile URL', 'gulir-core' ),
					'steam'       => esc_html__( 'Steam profile URL', 'gulir-core' ),
					'tumblr'      => esc_html__( 'Tumblr profile URL', 'gulir-core' ),
					'discord'     => esc_html__( 'Discord profile URL', 'gulir-core' ),
					'flickr'      => esc_html__( 'Flickr profile URL', 'gulir-core' ),
					'skype'       => esc_html__( 'Skype profile URL', 'gulir-core' ),
					'snapchat'    => esc_html__( 'Snapchat profile URL', 'gulir-core' ),
					'quora'       => esc_html__( 'Quora profile URL', 'gulir-core' ),
					'myspace'     => esc_html__( 'Myspace profile URL', 'gulir-core' ),
					'bloglovin'   => esc_html__( 'Bloglovin profile URL', 'gulir-core' ),
					'digg'        => esc_html__( 'Digg profile URL', 'gulir-core' ),
					'dribbble'    => esc_html__( 'Dribbble profile URL', 'gulir-core' ),
					'soundcloud'  => esc_html__( 'Soundcloud profile URL', 'gulir-core' ),
					'vimeo'       => esc_html__( 'Vimeo profile URL', 'gulir-core' ),
					'reddit'      => esc_html__( 'Reddit profile URL', 'gulir-core' ),
					'vkontakte'   => esc_html__( 'Vkontakte profile URL', 'gulir-core' ),
					'telegram'    => esc_html__( 'Telegram profile URL', 'gulir-core' ),
					'whatsapp'    => esc_html__( 'Whatsapp profile URL', 'gulir-core' ),
					'truth'       => esc_html__( 'Truth profile URL', 'gulir-core' ),
					'threads'     => esc_html__( 'Threads profile URL', 'gulir-core' ),
					'bluesky'     => esc_html__( 'Bluesky profile URL', 'gulir-core' ),
					'rss'         => esc_html__( 'Rss', 'gulir-core' ),
			] );
		}

		/**
		 * Updates the author's settings based on user input.
		 *
		 * @param int $user_id The ID of the user whose settings are being updated.
		 */
		function update_author_settings( $user_id ) {

			if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'rb_user_profile_update', 'rb_nonce' ) ) {
				return;
			}

			if ( ! empty( $_POST['template_global'] ) ) {
				update_user_meta( $user_id, 'template_global', sanitize_text_field( trim( $_POST['template_global'] ) ) );
			} else {
				delete_user_meta( $user_id, 'template_global' );
			}

			if ( isset( $_POST['author_bio'] ) ) {
				update_user_meta( $user_id, 'author_bio', sanitize_text_field( $_POST['author_bio'] ) );
			}

			if ( isset( $_POST['author_tick'] ) ) {
				update_user_meta( $user_id, 'author_tick', sanitize_text_field( $_POST['author_tick'] ) );
			}

			if ( isset( $_POST['author_bio_lightbox'] ) ) {
				update_user_meta( $user_id, 'author_bio_lightbox', sanitize_text_field( $_POST['author_bio_lightbox'] ) );
			}

			if ( isset( $_POST['author_image_id'] ) && $_POST['author_image_id'] !== '' ) {
				update_user_meta( $user_id, 'author_image_id', intval( $_POST['author_image_id'] ) );
			} else {
				delete_user_meta( $user_id, 'author_image_id' );
			}
		}

		/**
		 * Displays and registers the author settings fields in the user profile.
		 *
		 *
		 * @param WP_User $profile_user The WP_User object representing the user whose profile is being edited.
		 */
		function register_author_settings( $profile_user ) {
			
			$user_id = $profile_user->ID;

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$author_bio   = get_user_meta( $user_id, 'author_bio', true );
			$tick         = get_user_meta( $user_id, 'author_tick', true );
			$bio_lightbox = get_user_meta( $user_id, 'author_bio_lightbox', true );

			wp_enqueue_media(); // Load WordPress media uploader

			?>
			<table class="form-table rb-profile-settings" role="presentation">
				<thead>
				<tr>
					<th><?php esc_html_e( 'Author Profile', 'gulir-core' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<tr class="user-template-wrap">
					<th><label for="description"><?php esc_html_e( 'Author Page Template Builder', 'gulir-core' ); ?></label>
					</th>
					<td>
						<textarea class="ruby-template-input" placeholder="[Ruby_E_Template id=&quot;1&quot;]" name="template_global" id="template-global" rows="2" cols="30"><?php echo get_user_meta( $user_id, 'template_global', true ); ?></textarea>
						<p class="description"><?php esc_html_e( 'Use the Ruby Template to customize the author profile and display details like biography, occupation, and skills.', 'gulir-core' ); ?></p>
					</td>
				</tr>
				<tr class="user-bio-box">
					<th><label for="role"><?php esc_html_e( 'Author Bio', 'gulir-core' ); ?></label></th>
					<td>
						<select name="author_bio" id="author_bio">
							<option value="0" <?php if ( $author_bio == '0' ) {
								echo 'selected';
							} ?>><?php esc_html_e( '- Default from Theme Options -', 'gulir-core' ); ?>
							</option>
							<option value="1" <?php if ( $author_bio == '1' ) {
								echo 'selected';
							} ?>><?php esc_html_e( 'Enable', 'gulir-core' ); ?>
							</option>
							<option value="-1" <?php if ( $author_bio == '-1' ) {
								echo 'selected';
							} ?>>
								<?php esc_html_e( 'Disable', 'gulir-core' ); ?>
							</option>
						</select>
						<p class="description"><?php esc_html_e( 'Display the author bio box in the header of the author page. Navigate to "Theme Options > Author Page > Author Bio" for global setting.', 'gulir-core' ); ?></p>
					</td>
				</tr>
				<tr class="user-verified">
					<th><label for="author_tick"><?php esc_html_e( 'Verified Tick for Author Box', 'gulir-core' ); ?></label>
					</th>
					<td>
						<select name="author_tick" id="author_tick">
							<option value="0" <?php if ( $tick == '0' ) {
								echo 'selected';
							} ?>><?php esc_html_e( '- Default from Theme Options -', 'gulir-core' ); ?>
							</option>
							<option value="verified" <?php if ( $tick === 'verified' ) {
								echo 'selected';
							} ?>><?php esc_html_e( 'Enable', 'gulir-core' ); ?>
							</option>
							<option value="-1" <?php if ( $tick == '-1' ) {
								echo 'selected';
							} ?>><?php esc_html_e( 'Disable', 'gulir-core' ); ?>
							</option>
						</select>
						<p class="description"><?php esc_html_e( 'Display a verified tick icon after the author meta in the author box. Navigate to "Theme Options > Author Page > Verified Tick" for global setting.', 'gulir-core' ); ?></p>
					</td>
				</tr>
				<tr class="bio-lightbox">
					<th><label for="author_bio_lightbox"><?php esc_html_e( 'Bio Lightbox', 'gulir-core' ); ?></label></th>
					<td>
						<select name="author_bio_lightbox" id="author_bio_lightbox">
							<option value="0" <?php if ( $bio_lightbox == '0' ) {
								echo 'selected';
							} ?>><?php esc_html_e( '- Default from Theme Options -', 'gulir-core' ); ?>
							</option>
							<option value="show" <?php if ( $bio_lightbox === 'show' ) {
								echo 'selected';
							} ?>><?php esc_html_e( 'Enable', 'gulir-core' ); ?>
							</option>
							<option value="-1" <?php if ( $bio_lightbox == '-1' ) {
								echo 'selected';
							} ?>><?php esc_html_e( 'Disable', 'gulir-core' ); ?>
							</option>
						</select>
						<p class="description"><?php esc_html_e( 'Enable a short bio lightbox that appears at the top of a single post when hovering over this author meta.', 'gulir-core' ); ?></p>
					</td>
				</tr>
				<tr class="user-image-wrap">
					<th>
						<label for="author_image"><?php esc_html_e( 'Author Gravatar', 'gulir-core' ); ?></label>
					</th>
					<td>
						<?php $image_id = get_user_meta( $user_id, 'author_image_id', true ); ?>
						<input type="hidden" name="author_image_id" id="rb-avatar-id" value="<?php echo esc_attr( $image_id ); ?>" />
						<button id="rb-upload-avatar" class="rb-upload-avatar"><?php esc_html_e( 'Set Avatar', 'gulir-core' ); ?></button>
						<div class="rb-avatar-preview-outer">
							<div id="rb-avatar-preview" class="avatar-preview">
								<?php if ( $image_id ) : ?>
									<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
								<?php endif; ?>
							</div>
							<div id="rb-remove-avatar" class="rb-remove-avatar"><span class="dashicons dashicons-no-alt"></span></div>
						</div>
						<p class="description">
							<?php esc_html_e( 'Upload your custom image for this user\'s image. This setting will override the Gravatar. A square image with a recommended size of 300x300px is suggested.', 'gulir-core' ); ?>
						</p>
					</td>
				</tr>
				</tbody>
			</table>
			<?php
			/** create nonce */
			wp_nonce_field( 'rb_user_profile_update', 'rb_nonce' );
		}
	}
}

/** init */
Gulir_Admin_Profile::get_instance();