<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function rb_weather_data;

/**
 * Class Block_Weather
 *
 * @package gulirElementor\Widgets
 */
class Block_Weather extends Widget_Base {

	public function get_name() {

		return 'gulir-weather';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Weather', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-nerd-wink';
	}

	public function get_keywords() {

		return [ 'weather', 'sidebar' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Input your title.', 'gulir-core' ),
				'default'     => esc_html__( 'Weather', 'gulir-core' ),
			]
		);

		$this->add_control(
			'units',
			[
				'label'   => esc_html__( 'Units:', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'C' => esc_html__( '&deg;C', 'gulir-core' ),
					'F' => esc_html__( '&deg;F', 'gulir-core' ),
				],
				'default' => 'C',
			]
		);

		$this->add_control(
			'location',
			[
				'label'       => esc_html__( 'Location:', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => '<a target="_blank" href="https://openweathermap.org/find/">' . esc_html__( 'Find your location', 'gulir-core' ) . '</a>&nbsp;&nbsp;' . esc_html__( '(i.e: London, GB)', 'gulir-core' ),
				'default'     => esc_html__( 'London', 'gulir-core' ),
			]
		);

		$this->add_control(
			'api_key',
			[
				'label'       => esc_html__( 'Weather API Key:', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => '<a target="_blank" href="//openweathermap.org/appid#get">' . esc_html__( 'How to get API key', 'gulir-core' ) . '</a>',
				'default'     => '',
			]
		);

		$this->add_control(
			'forecast_days',
			[
				'label'   => esc_html__( 'Forecast:', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1'    => esc_html__( '1 day', 'gulir-core' ),
					'2'    => esc_html__( '2 days', 'gulir-core' ),
					'3'    => esc_html__( '3 days', 'gulir-core' ),
					'4'    => esc_html__( '4 days', 'gulir-core' ),
					'5'    => esc_html__( '5 days', 'gulir-core' ),
					'hide' => esc_html__( 'Do not display', 'gulir-core' ),
				],
				'default' => '5',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'font_section', [
				'label' => esc_html__( 'Typography', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .rb-w-title.h4',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Location Font', 'gulir-core' ),
				'name'     => 'location_font',
				'selector' => '{{WRAPPER}} .rb-header-name',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Current Temperature Font', 'gulir-core' ),
				'name'     => 'temp_font',
				'selector' => '{{WRAPPER}} .rb-w-header .rb-w-units span',
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
	}

	protected function render() {

		if ( function_exists( 'rb_weather_data' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();

			echo rb_weather_data(
				[
					'title'         => $settings['title'],
					'location'      => $settings['location'],
					'api_key'       => $settings['api_key'],
					'units'         => $settings['units'],
					'forecast_days' => $settings['forecast_days'],
					'color_scheme'  => $settings['color_scheme'],
				] );
		}
	}
}