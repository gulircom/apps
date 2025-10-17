<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_categories_2;

/**
 * Class Categories_List_2
 *
 * @package gulirElementor\Widgets
 */
class Categories_List_2 extends Widget_Base {

	public function get_name() {

		return 'gulir-categories-2';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Taxonomies List 2', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-folder-o';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'category', 'follow', 'bookmark', 'interest', 'tag', 'tax' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'followed_section', [
				'label' => esc_html__( 'User Followed', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'personalize_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Enable the "Show Followed" & "Follow Button" request to activate the Personalized System. You can configure this in Theme Options > Personalized System > Global', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'display_mode_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::display_mode_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'tax_slug_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::tax_name_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'followed',
			[
				'label'       => esc_html__( 'Show Followed', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::taxonomies_followed_description(),
				'options'     => Options::followed_dropdown(),
				'default'     => '-1',
			]
		);
		$this->add_control(
			'tax_followed',
			[
				'label'       => esc_html__( 'or Show Followed by Taxonomy Keys', 'gulir-core' ),
				'description' => Options::tax_slug_followed_description(),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'category, post_tag, genre',
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'default'     => '',
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
		$this->add_control(
			'display_mode',
			[
				'label'       => esc_html__( 'Display Mode', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::categories_display_mode_description(),
				'options'     => [
					'0'      => esc_html__( '- AJAX -', 'gulir-core' ),
					'direct' => esc_html__( 'Direct', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'general', [
				'label' => esc_html__( 'Manually Add', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tax_featured_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::tax_featured_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$categories = new Repeater();
		$categories->add_control(
			'category',
			[
				'label'   => esc_html__( 'Select a Category', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::cat_slug_dropdown(),
				'default' => 0,
			]
		);
		$categories->add_control(
			'tax_id',
			[
				'label'       => esc_html__( 'or Term ID', 'gulir-core' ),
				'description' => esc_html__( 'Input the tag or taxonomy Term ID; ensure that the featured image for this taxonomy is set for display in Posts > Edit "your taxonomy".', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'default'     => '',
			]
		);
		$categories->add_control(
			'tax_image',
			[
				'label'       => esc_html__( 'Add Custom Featured Image', 'gulir-core' ),
				'description' => esc_html__( 'Set a custom featured image for this term. This will override the default featured image set in the term settings panel.', 'gulir-core' ),
				'type'        => Controls_Manager::MEDIA,
				'ai'          => [ 'active' => false ],
			]
		);
		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Add Taxonomies', 'gulir-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $categories->get_controls(),
				'default'     => [
					[
						'category' => '',
						'tax_id'   => '',
					],
				],
				'title_field' => '{{{ tax_id ? "Term ID: " + tax_id : "Category: " + category }}}',
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
			'crop_size',
			[
				'label'       => esc_html__( 'Featured Image Size', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::crop_size(),
				'options'     => Options::crop_size_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'display_ratio', [
				'label'       => esc_html__( 'Custom Featured Ratio', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::display_ratio_description(),
				'selectors'   => [
					'{{WRAPPER}}' => '--feat-ratio: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'feat_align',
			[
				'label'       => esc_html__( 'Align', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::feat_align_description(),
				'options'     => [
					''       => esc_html__( '- Default -', 'gulir-core' ),
					'top'    => esc_html__( 'Top', 'gulir-core' ),
					'bottom' => esc_html__( 'Bottom', 'gulir-core' ),
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}}' => '--feat-position: center {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label'       => esc_html__( 'Title HTML Tag', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::heading_html_description(),
				'options'     => Options::heading_html_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'title_tag_size', [
				'label'       => esc_html__( 'Title Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::title_size_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--ctitle-size: {{VALUE}}px;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .cbox-title > *',
			]
		);
		$this->add_control(
			'count_posts',
			[
				'label'       => esc_html__( 'Count Posts', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::count_posts_description(),
				'options'     => Options::count_posts_dropdown(),
				'default'     => '1',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Count Posts Font', 'gulir-core' ),
				'name'     => 'count_font',
				'selector' => '{{WRAPPER}} .cbox-count.is-meta',
			]
		);
		$this->add_control(
			'gradient',
			[
				'label'       => esc_html__( 'Colorful Gradient', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Enable or disable overlay color gradient style for this block.', 'gulir-core' ),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'rounded_section', [
				'label' => esc_html__( 'Rounded Corner', 'gulir-core' ),
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
				'options'     => Options::columns_dropdown( [ 0, 1, 2, 3, 4 ] ),
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
		$this->add_responsive_control(
			'bottom_margin', [
				'label'       => esc_html__( 'Custom Bottom Margin', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom bottom margin values (in pixels) between items.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .block-wrap' => '--bottom-spacing: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_scroll_section', [
				'label' => esc_html__( 'Tablet/Mobile Horizontal Scroll', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'horizontal_scroll',
			[
				'label'       => esc_html__( 'Horizontal Scroll', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::horizontal_scroll_description(),
				'options'     => Options::horizontal_scroll_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'scroll_width_tablet', [
				'label'       => esc_html__( 'Tablet - Post Module Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '300',
				'description' => Options::scroll_width_tablet_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--tablet-scroll-width: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'scroll_width_mobile', [
				'label'       => esc_html__( 'Mobile - Post Module Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => '300',
				'description' => Options::scroll_width_mobile_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--mobile-scroll-width: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'gulir_get_categories_2' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_categories_2( $settings );
		}
	}
}