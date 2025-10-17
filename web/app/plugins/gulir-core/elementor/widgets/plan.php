<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_render_pricing_plan;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Plan extends Widget_Base {

	public function get_name() {

		return 'gulir-plan';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Plan Subscription', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-price-table';
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'paywall', 'membership', 'restricted' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Input a title for this banner.', 'gulir-core' ),
				'default'     => 'Get <span>unlimited</span> access to everything',
			]
		);
		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'gulir-core' ),
				'description' => esc_html__( 'Input a description for this plan.', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => 'Plans starting at less than $9/month. <strong>Cancel anytime.</strong>',
			]
		);
		$this->add_control(
			'price',
			[
				'label'       => esc_html__( 'Price', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a price for this plan.', 'gulir-core' ),
				'default'     => '9',
			]
		);
		$this->add_control(
			'unit',
			[
				'label'       => esc_html__( 'Price Unit', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a price unit for this plan.', 'gulir-core' ),
				'default'     => '$',
			]
		);
		$this->add_control(
			'tenure',
			[
				'label'       => esc_html__( 'Price Tenure', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => esc_html__( 'Input a price tenure for this plan.', 'gulir-core' ),
				'default'     => '/month',
			]
		);
		$features = new Repeater();
		$features->add_control(
			'feature',
			[
				'label'       => esc_html__( 'Plan Feature', 'gulir-core' ),
				'description' => esc_html__( 'Input a feature for this plan.', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 1,
				'default'     => '',
			]
		);
		$this->add_control(
			'features',
			[
				'label'       => esc_html__( 'Plan Features', 'gulir-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $features->get_controls(),
				'title_field' => '{{{ feature }}}',

			]
		);
		$this->add_control(
			'shortcode',
			[
				'label'       => esc_html__( 'Membership Payment Button Shortcode', 'gulir-core' ),
				'description' => esc_html__( 'Input a payment button shortcode. Use button text if you would like to custom label, e.g. [swpm_payment_button id=1 button_text="Buy Now"]', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'placeholder' => '[swpm_payment_button id=1]',
				'rows'        => 2,
				'default'     => '',

			]
		);
		$this->add_control(
			'register_button',
			[
				'label'       => esc_html__( 'or Free Button', 'gulir-core' ),
				'description' => esc_html__( 'Input a free button label to navigate to the user to the register page. Leave blank the payment shortcode filed to use this setting.', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'placeholder' => 'Join Now',
				'rows'        => 1,
				'default'     => '',

			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'box_style_section', [
				'label' => esc_html__( 'Box Style', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'box_style',
			[
				'label'       => esc_html__( 'Box Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a box style for this block.', 'gulir-core' ),
				'options'     => [
					'shadow' => esc_html__( 'Shadow', 'gulir-core' ),
					'border' => esc_html__( 'Border', 'gulir-core' ),
					'bg'     => esc_html__( 'Background', 'gulir-core' ),
				],
				'default'     => 'shadow',
			]
		);
		$this->add_control(
			'box_style_color',
			[
				'label'       => esc_html__( 'Box Style Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for your box style.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}}' => '--plan-box-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_box_style_color',
			[
				'label'       => esc_html__( 'Dark Mode - Box Style Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a color for this plan box in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--plan-box-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'button_bg',
			[
				'label'       => esc_html__( 'Button Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} .plan-button-wrap' => '--plan-button-bg: {{VALUE}}; --plan-button-bg-opacity: {{VALUE}}ee;' ],
			]
		);
		$this->add_control(
			'dark_button_bg',
			[
				'label'       => esc_html__( 'Dark Mode - Button Background', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .plan-button-wrap' => '--plan-button-bg: {{VALUE}}; --plan-button-bg-opacity: {{VALUE}}ee;' ],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'       => esc_html__( 'Button Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '{{WRAPPER}} .plan-button-wrap' => '--plan-button-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_button_color',
			[
				'label'       => esc_html__( 'Dark Mode - Button Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select a background color for the payment button in dark mode.', 'gulir-core' ),
				'default'     => '',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .plan-button-wrap' => '--plan-button-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'size_section', [
				'label' => esc_html__( 'Font Size', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'title_size',
			[
				'label'       => esc_html__( 'Heading Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the plan heading.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .plan-heading' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_responsive_control(
			'desc_size',
			[
				'label'       => esc_html__( 'Description Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the description.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .plan-description' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_responsive_control(
			'feature_size',
			[
				'label'       => esc_html__( 'Feature List Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the description.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .plan-features' => 'font-size: {{VALUE}}px',
				],
			]
		);
		$this->add_responsive_control(
			'button_size',
			[
				'label'       => esc_html__( 'Button Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size (in px) for the payment button.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .plan-button-wrap' => '--plan-button-size: {{VALUE}}px',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'spacing_section', [
				'label' => esc_html__( 'Spacing', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'el_spacing',
			[
				'label'       => esc_html__( 'Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom spacing value(px) between element.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .plan-inner > *:not(:last-child)' => 'margin-bottom: {{VALUE}}px',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'color_section', [
				'label' => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_scheme',
			[
				'label'       => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::color_scheme_description(),
				'options'     => [
					'0' => esc_html__( 'Default (Dark Text)', 'gulir-core' ),
					'1' => esc_html__( 'Light Text', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'font_section', [
				'label' => esc_html__( 'Custom Font', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'custom_font_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::custom_font_info_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Heading Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .plan-heading',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Description Font', 'gulir-core' ),
				'name'     => 'description_font',
				'selector' => '{{WRAPPER}} .plan-description',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Plan Features Font', 'gulir-core' ),
				'name'     => 'feature_font',
				'selector' => '{{WRAPPER}} .plan-features',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_render_pricing_plan' ) ) {
			echo gulir_render_pricing_plan( $this->get_settings() );
		}
	}
}