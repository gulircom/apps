<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_authors_2;
use function gulir_is_ruby_template;

class Authors_List_2 extends Widget_Base {

	public function get_name() {

		return 'gulir-authors-2';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Authors List 2', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-person';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'writer', 'team', 'follow', 'user', 'bookmark' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', [
				'label' => esc_html__( 'Authors', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'category_list_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block use user Gravatar image to display.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$categories = new Repeater();
		$categories->add_control(
			'author',
			[
				'label'   => esc_html__( 'Select a Author', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ( gulir_is_ruby_template() ) ? Options::author_dropdown( true, false ) : Options::author_dropdown( false, false ),
				'default' => '',
			]
		);
		$this->add_control(
			'authors',
			[
				'label'       => esc_html__( 'Add Authors', 'gulir-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $categories->get_controls(),
				'default'     => [
					[
						'author' => '',
					],
				],
				'title_field' => 'Author ID: {{{ author }}}',

			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'follow_section', [
				'label' => esc_html__( 'Follow', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'personalize_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Enable the "Follow Button" request to activate the Personalized System. You can configure this in Theme Options > Personalized System > Global', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'follow',
			[
				'label'       => esc_html__( 'Follow Button', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::switch_dropdown( false ),
				'description' => esc_html__( 'Enable or disable the follow button.', 'gulir-core' ),
				'default'     => '-1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'design_section', [
				'label' => esc_html__( 'Block Design', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'count_posts',
			[
				'label'       => esc_html__( 'Count Posts', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::count_posts_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->add_control(
			'description_length',
			[
				'label'       => esc_html__( 'Description Length', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Maximum number of words for the description to show. Leave it blank to display the full bio.', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_responsive_control(
			'featured_width', [
				'label'       => esc_html__( 'Image Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'devices'     => [ 'desktop', 'tablet' ],
				'description' => esc_html__( 'Input custom width values (in pixels) for the author avatar image.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}} .a-card' => '--featured-width: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'feat_lazyload',
			[
				'label'   => esc_html__( 'Lazy Load', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::feat_lazyload_simple_dropdown(),
				'default' => '0',
			]
		);
		$this->add_responsive_control(
			'avatar_radius', [
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'devices'     => [ 'desktop', 'tablet' ],
				'description' => esc_html__( 'Input custom border values (in pixels) for the author avatar image.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--avatar-radius: {{VALUE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'title_tag_size', [
				'label'       => esc_html__( 'Title Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'selectors'   => [ '{{WRAPPER}} .nice-name' => 'font-size: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'desc_size', [
				'label'       => esc_html__( 'Description Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'selectors'   => [ '{{WRAPPER}} .description-text' => 'font-size: {{VALUE}}px;' ],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'box_section', [
				'label' => esc_html__( 'Boxed', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'box_border',
			[
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::border_description(),
				'selectors'   => [
					'{{WRAPPER}}' => '--wrap-border: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'box_style',
			[
				'label'       => esc_html__( 'Box Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a box style for this block.', 'gulir-core' ),
				'options'     => [
					'shadow'    => esc_html__( 'Shadow', 'gulir-core' ),
					'gray'      => esc_html__( 'Gray Solid', 'gulir-core' ),
					'dark'      => esc_html__( 'Dark Solid', 'gulir-core' ),
					'gray-dot'  => esc_html__( 'Gray Dotted', 'gulir-core' ),
					'dark-dot'  => esc_html__( 'Dark Dotted', 'gulir-core' ),
					'gray-dash' => esc_html__( 'Gray Dashed', 'gulir-core' ),
					'dark-dash' => esc_html__( 'Dark Dashed', 'gulir-core' ),
					'none'      => esc_html__( 'None', 'gulir-core' ),
				],
				'default'     => 'shadow',
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
			'block_columns', [
				'label' => esc_html__( 'Columns', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns on Desktop', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_description(),
				'options'     => Options::columns_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'columns_tablet',
			[
				'label'       => esc_html__( 'Columns on Tablet', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_tablet_description(),
				'options'     => Options::columns_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'columns_mobile',
			[
				'label'       => esc_html__( 'Columns on Mobile', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_mobile_description(),
				'options'     => Options::columns_dropdown( [ 0, 1, 2 ] ),
				'default'     => '0',
			]
		);
		$this->add_control(
			'column_gap',
			[
				'label'       => esc_html__( 'Column Gap', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::column_gap_description(),
				'options'     => Options::column_gap_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'column_gap_custom', [
				'label'       => esc_html__( '1/2 Custom Gap Value', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::column_gap_custom_description(),
				'selectors'   => [
					'{{WRAPPER}} .is-gap-custom'                  => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px; --colgap: {{VALUE}}px;',
					'{{WRAPPER}} .is-gap-custom .block-inner > *' => 'padding-left: {{VALUE}}px; padding-right: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'column_border',
			[
				'label'       => esc_html__( 'Column Border', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::column_border_description(),
				'options'     => Options::column_border_dropdown(),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'spacing_section', [
				'label' => esc_html__( 'Spacing', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'inner_padding',
			[
				'label'       => esc_html__( 'Inner Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom inner padding spacing for this block', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--inner-padding: {{VALUE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'bottom_margin', [
				'label'       => esc_html__( 'Custom Bottom Margin', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom bottom margin values (in pixels) between items.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .block-wrap' => '--bottom-spacing: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'gulir_get_authors_2' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_authors_2( $settings );
		}
	}
}