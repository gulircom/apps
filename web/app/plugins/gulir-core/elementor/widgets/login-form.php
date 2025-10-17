<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use function gulir_is_edit_mode;
use function gulir_render_frontend_login;
use function gulir_render_user_login;

class Login_Form extends Widget_Base {

	public function get_name() {

		return 'gulir-login-form';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Login Form', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-person';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'template', 'builder', 'user', 'login', 'register', 'create' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'label_section', [
				'label' => esc_html__( 'Login Form', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'lform_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block allows you to create a frontend login page with your own custom design.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'login_failed_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'DEFINE FRONTEND LOGIN: Gulir uses the default wp-login.php to manage user logins, ensuring maximum security. To prevent redirecting to wp-login.php, navigate to "Theme Options > Login > Custom Login Page URL" and set the login page to the page URL where you place this block.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'login_header',
			[
				'label'       => esc_html__( 'Login Header Content', 'gulir-core' ),
				'description' => esc_html__( 'Display custom information at the top of the login form. Allows raw HTML code.', 'gulir-core' ),
				'placeholder' => '<h1>Login</h1>',
				'default'     => '<h1>Login</h1>',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'label_username',
			[
				'label'   => esc_html__( 'Username Label', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 1,
				'ai'      => [ 'active' => false ],
				'default' => '',
			]
		);
		$this->add_control(
			'label_password',
			[
				'label'   => esc_html__( 'Password Label', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 1,
				'ai'      => [ 'active' => false ],
				'default' => '',
			]
		);
		$this->add_control(
			'label_remember',
			[
				'label'   => esc_html__( 'Remember Label', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 1,
				'ai'      => [ 'active' => false ],
				'default' => '',
			]
		);
		$this->add_control(
			'label_log_in',
			[
				'label'   => esc_html__( 'Login Button Label', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 1,
				'ai'      => [ 'active' => false ],
				'default' => '',
			]
		);
		$this->add_control(
			'login_form_hook',
			[
				'label'       => esc_html__( 'Login Form Hook', 'gulir-core' ),
				'description' => esc_html__( 'Enable this setting to display third-party captcha verification if it is not automatically enabled for the login form.', 'gulir-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'ai'          => [ 'active' => false ],
				'default'     => '',
			]
		);

		$this->add_control(
			'login_form_hook_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'If you experience duplicate Captchas, try turning off the login form hook. This may help resolve the issue.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'lostpassword', [
				'label' => esc_html__( 'Lost Password Form', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'lostpassword_header',
			[
				'label'       => esc_html__( 'Lost Password Header Content', 'gulir-core' ),
				'description' => esc_html__( 'Display custom information when a visitor clicks on the lost password link. Allows raw HTML code.', 'gulir-core' ),
				'default'     => '<h1><i class="rbi rbi-unlock"></i>Get Your Password</h1><p>Please enter your username or email address. You will receive an email message with instructions on how to reset your password.</p>',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'confirmemail_header',
			[
				'label'       => esc_html__( 'Confirm Email Header Content', 'gulir-core' ),
				'description' => esc_html__( 'Display custom information when a visitor successfully resets their password. Allows raw HTML code.', 'gulir-core' ),
				'default'     => '<h1><i class="rbi rbi-unlock"></i>Get Your Password</h1><p>A password reset email has been sent. It may take a few minutes to arrive. Please wait 10 minutes before requesting another reset.</p>',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'logged_section', [
				'label' => esc_html__( 'Logged Status Box', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'logged_status',
			[
				'label'       => esc_html__( 'Logged Status ', 'gulir-core' ),
				'description' => esc_html__( 'Select a layout if the user is logged in.', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'0' => esc_html__( 'None', 'gulir-core' ),
					'1' => esc_html__( 'Status with Avatar', 'gulir-core' ),
					'2' => esc_html__( 'Minimal', 'gulir-core' ),
				],
				'default'     => '1',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'label_style_section', [
				'label' => esc_html__( 'Label', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'label_style',
			[
				'label'        => esc_html__( 'Label Style', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'description'  => esc_html__( 'Select a style for the login label.', 'gulir-core' ),
				'options'      => [
					'none' => esc_html__( 'None', 'gulir-core' ),
					'pipe' => esc_html__( 'Pipe (|)', 'gulir-core' ),
					'dot'  => esc_html__( 'Dot (.)', 'gulir-core' ),
				],
				'default'      => 'none',
				'prefix_class' => 'is-label-',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Label Font', 'gulir-core' ),
				'name'     => 'label_font',
				'selector' => '{{WRAPPER}} .rb-login-label, {{WRAPPER}} .logged-status-simple',
			]
		);
		$this->add_responsive_control(
			'label_spacing', [
				'label'       => esc_html__( 'Label Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom bottom margin for the label.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--llabel-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--llabel-color : {{VALUE}};' ],
			]
		);
		$this->add_control(
			'label_icon',
			[
				'label'     => esc_html__( 'Icon Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--licon-color : {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_label_color',
			[
				'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--llabel-color : {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_label_icon',
			[
				'label'     => esc_html__( 'Dark Mode - Icon Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--licon-color : {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'input_style_section', [
				'label' => esc_html__( 'Input Fields', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'input_spacing', [
				'label'       => esc_html__( 'Input Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing between input fields.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--linput-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Input Font', 'gulir-core' ),
				'name'     => 'input_font',
				'selector' => '{{WRAPPER}} .user-login-form input',
			]
		);
		$this->add_control(
			'input_style',
			[
				'label'        => esc_html__( 'Input Style', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'bg'     => esc_html__( 'Gray Background', 'gulir-core' ),
					'border' => esc_html__( 'Gray Border', 'gulir-core' ),
				],
				'default'      => 'bg',
				'prefix_class' => 'is-input-',
			]
		);
		$this->add_responsive_control(
			'input_border', [
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--round-7: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'button_section', [
				'label' => esc_html__( 'Login Button', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Button Font', 'gulir-core' ),
				'name'     => 'button_font',
				'selector' => '{{WRAPPER}} .user-login-form input[type="submit"]',
			]
		);
		$this->add_control(
			'button_width', [
				'label'     => esc_html__( 'Button Width', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--lbutton-width: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'button_border', [
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--round-3: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'button_padding',
			[
				'label'       => esc_html__( 'Inner Padding', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Input a custom padding for the login button', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--lbutton-padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--btn-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'button_bg',
			[
				'label'     => esc_html__( 'Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--btn-primary: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_button_color',
			[
				'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--btn-accent: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_button_bg',
			[
				'label'     => esc_html__( 'Dark Mode - Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--btn-primary: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'form_meta_section', [
				'label' => esc_html__( 'Footer Links & Lost your password?', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Meta Font', 'gulir-core' ),
				'name'     => 'meta_font',
				'selector' => '{{WRAPPER}} .lostpassw-link, {{WRAPPER}} .login-form-footer',
			]
		);
		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}} .lostpassw-link, {{WRAPPER}} .login-form-footer' => 'color : {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_meta_color',
			[
				'label'     => esc_html__( 'Dark Mode - Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}} .lostpassw-link, [data-theme="dark"] {{WRAPPER}} .login-form-footer' => 'color : {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'padding_section', [
				'label' => esc_html__( 'Inner Padding', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'padding_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'The settings below allow you to set different inner spacing for the login form and logged status. Use the Advanced tab for additional style settings: background, shadow, and border...', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_responsive_control(
			'form_padding',
			[
				'label'       => esc_html__( 'Login Form', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Input a custom inner padding for the login form.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--lform-padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'logged_padding',
			[
				'label'       => esc_html__( 'Logged Box Padding', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'description' => esc_html__( 'Enter custom padding for the logged status box.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--lstatus-padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings         = $this->get_settings();
		$settings['uuid'] = 'uid_' . $this->get_id();
		if ( gulir_is_edit_mode() ) {
			gulir_render_frontend_login( $settings );
		} else {
			gulir_render_user_login( $settings );
		}
	}
}