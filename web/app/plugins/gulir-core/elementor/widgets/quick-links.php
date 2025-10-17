<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_quick_links;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Quick_links extends Widget_Base {

	public function get_name() {

		return 'gulir-quick-links';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Quick Links', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-editor-link';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'menu', 'links' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$quick_links = new Repeater();

		$source_options = [
			'0'    => esc_html__( 'Manually Add', 'gulir-core' ),
			'tax'  => esc_html__( 'Top Taxonomies', 'gulir-core' ),
			'both' => esc_html__( 'Manual & Top Taxonomies', 'gulir-core' ),
		];

		$source_description = esc_html__( 'Choose the data source used to display quick link data.', 'gulir-core' );

		if ( gulir_is_ruby_template() ) {
			$source_options['sub'] = esc_html__( 'Sub Terms', 'gulir-core' );
			$source_description    = esc_html__( 'Choose the data source used to display quick link data. The "Sub Terms" option will show child taxonomies when used in category or taxonomy templates.', 'gulir-core' );
		}

		$this->start_controls_section(
			'content-label-section', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'header',
			[
				'label'       => esc_html__( 'Label', 'gulir-core' ),
				'description' => esc_html__( 'HTML tags allowed in case you want to add an icon (i tag).', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'default'     => esc_html__( 'Quick Links', 'gulir-core' ),
			]
		);
		$this->add_control(
			'source', [
				'label'       => esc_html__( 'Data Source', 'gulir-core' ),
				'description' => $source_description,
				'type'        => Controls_Manager::SELECT,
				'options'     => $source_options,
				'default'     => '0',

			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'tax-section', [
				'label' => esc_html__( 'for Top Taxonomies', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'source_tax', [
				'label'       => esc_html__( 'Taxonomy Keys', 'gulir-core' ),
				'description' => esc_html__( 'Input the taxonomy slugs/names/keys you want to collect, separated by commas if you want to display multiple taxonomies (e.g., category, post_tag, genre).', 'gulir-core' ),
				'placeholder' => 'category, post_tag',
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'default'     => 'category, post_tag',
			]
		);
		$this->add_control(
			'total', [
				'label'       => esc_html__( 'Total', 'gulir-core' ),
				'description' => esc_html__( 'Max taxonomy items to show.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content-section', [
				'label' => esc_html__( 'for Manually Add', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$quick_links->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'gulir-core' ),
				'description' => esc_html__( 'HTML tags allowed in case you want to add an icon (i tag).', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'placeholder' => esc_html__( 'Trending', 'gulir-core' ),
				'default'     => '',
			]
		);
		$quick_links->add_control(
			'url',
			[
				'label' => esc_html__( 'URL', 'gulir-core' ),
				'type'  => Controls_Manager::URL,
			]
		);
		$this->add_control(
			'quick_links',
			[
				'label'       => esc_html__( 'Add Quick Link', 'gulir-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $quick_links->get_controls(),
				'default'     => [
					[
						'url'   => '',
						'title' => esc_html__( 'Quick Link #1', 'gulir-core' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'label-section', [
				'label' => esc_html__( 'Block Label', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Label Font', 'gulir-core' ),
				'name'     => 'heading_font',
				'selector' => '{{WRAPPER}} .qlink-label',
			]
		);
		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Label Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '{{WRAPPER}}' => '--label-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_label_color',
			[
				'label'     => esc_html__( 'Dark Mode - Label Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ '[data-theme="dark"] {{WRAPPER}}' => '--label-color: {{VALUE}};' ],
			]
		);
		$this->add_responsive_control(
			'label_spacing', [
				'label'     => esc_html__( 'Right Spacing', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--label-spacing: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'item-section', [
				'label' => esc_html__( 'Quick Link Items', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Item Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .qlink a',
			]
		);
		$this->add_responsive_control(
			'item_spacing', [
				'label'       => esc_html__( 'Column Spacing', 'gulir-core' ),
				'description' => esc_html__( 'Input gap spacing between quick link item.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--qlink-gap: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'row_spacing', [
				'label'       => esc_html__( 'Row Spacing', 'gulir-core' ),
				'description' => esc_html__( 'Input row gap for the block in case you wrap items.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--r-qlink-gap: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Item Style', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'Text Only', 'gulir-core' ),
					'2' => esc_html__( 'Button', 'gulir-core' ),
					'3' => esc_html__( 'Underline', 'gulir-core' ),
					'4' => esc_html__( 'Border', 'gulir-core' ),
				],
				'default' => '1',
			]
		);
		$this->add_control(
			'item_color',
			[
				'label'     => esc_html__( 'Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--qlink-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_item_color',
			[
				'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--qlink-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hover_effect',
			[
				'label'     => esc_html__( 'Hover Effect', 'gulir-core' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'layout' => [ '1', '3' ],
				],
				'options'   => [
					'underline' => esc_html__( 'Underline Line', 'gulir-core' ),
					'dotted'    => esc_html__( 'Underline Dotted', 'gulir-core' ),
					'double'    => esc_html__( 'Underline Double', 'gulir-core' ),
					'color'     => esc_html__( 'Text Color', 'gulir-core' ),
				],
				'default'   => 'underline',
			]
		);
		$this->add_control(
			'item_bg',
			[
				'label'     => esc_html__( 'Secondary Background/Border', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'layout' => [ '2', '4' ],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--qlink-bg: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_item_bg',
			[
				'label'     => esc_html__( 'Dark Mode - Secondary Background/Border', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'layout' => [ '2', '4' ],
				],
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--qlink-bg: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'inner_padding',
			[
				'label'     => esc_html__( 'Item Padding', 'gulir-core' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'layout' => [ '2', '4' ],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--qlink-padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'item_border', [
				'label'     => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'layout' => [ '2', '4' ],
				],
				'selectors' => [ '{{WRAPPER}}' => '--round-3: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'overflow-section', [
				'label' => esc_html__( 'Overflow', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'overflow',
			[
				'label'   => esc_html__( 'Overflow', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => esc_html__( 'Desktop Line Wrap - Mobile Horizontal Scroll', 'gulir-core' ),
					'2' => esc_html__( 'Line Wrap', 'gulir-core' ),
					'3' => esc_html__( 'Horizontal Scroll', 'gulir-core' ),
				],
				'default' => '0',
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'gulir-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'condition' => [
					'overflow' => [ '0', '2' ],
				],
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'gulir-core' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'gulir-core' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'gulir-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => '',
				'selectors' => [ '{{WRAPPER}} .qlinks-inner' => 'justify-content: {{VALUE}};' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'divider-section', [
				'label' => esc_html__( 'Divider', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'divider', [
				'label'        => esc_html__( 'Divider Style', 'gulir-core' ),
				'description'  => esc_html__( 'Select a divider style between quick link items.', 'gulir-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'0'      => esc_html__( 'None', 'gulir-core' ),
					'slash'  => esc_html__( 'Slash (/)', 'gulir-core' ),
					'pipe'   => esc_html__( 'Pipe (|)', 'gulir-core' ),
					'pipe-2' => esc_html__( 'Pipe 2 (|)', 'gulir-core' ),
					'hyphen' => esc_html__( 'Hyphen (-)', 'gulir-core' ),
					'dot'    => esc_html__( 'Dot (.)', 'gulir-core' ),
					'dot-2'  => esc_html__( 'Dot 2(.)', 'gulir-core' ),
				],
				'prefix_class' => 'is-divider-',
				'default'      => '0',

			]
		);
		$this->add_control(
			'divider_color',
			[
				'label'       => esc_html__( 'Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for divider.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}}' => '--divider-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_divider_color',
			[
				'label'       => esc_html__( 'Dark Mode - Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for divider in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--divider-color: {{VALUE}};' ],
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

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_get_quick_links' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_quick_links( $settings );
		}
	}
}