<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_overlay_personalize;

/**
 * Class Overlay_Personalize
 *
 * @package gulirElementor\Widgets
 */
class Overlay_Personalize extends Widget_Base {

	public function get_name() {

		return 'gulir-overlay-personalize';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Personalized Overlay', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-rating';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'bookmark', 'follow', 'recommended' ];
	}

	public function get_categories() {

		return [ 'gulir_flex' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'display_section', [
				'label' => esc_html__( 'Display Mode', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
			'display_mode',
			[
				'label'       => esc_html__( 'Display Mode', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::display_mode_description(),
				'options'     => [
					'0'      => esc_html__( '- AJAX -', 'gulir-core' ),
					'direct' => esc_html__( 'Direct', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'query_filters', [
				'label' => esc_html__( 'Query Settings', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'query_filters_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'This block will query posts based on your user\'s interests.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'reading_history_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::reading_history_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'bookmark_restrict_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Navigate to "Theme Options > Personalization" to set up restricted information if guest bookmarks are disabled.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'content_source',
			[
				'label'       => esc_html__( 'Query Source', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::content_source_description(),
				'options'     => [
					'recommended' => esc_html__( 'Recommended Based on User Followed', 'gulir-core' ),
					'saved'       => esc_html__( 'User Saved', 'gulir-core' ),
					'history'     => esc_html__( 'User Read History', 'gulir-core' ),
				],
				'default'     => 'recommended',
			]
		);
		$this->add_control(
			'post_type',
			[
				'label'       => esc_html__( 'Custom Post Type', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::post_type_dropdown(),
				'description' => Options::source_post_type_description(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'Number of Posts', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::posts_per_page_description(),
				'default'     => '3',
			]
		);
		$this->add_control(
			'offset',
			[
				'label'       => esc_html__( 'Post Offset', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::offset_description(),
				'default'     => '',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'block_pagination', [
				'label' => esc_html__( 'Ajax Pagination', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'pagination',
			[
				'label'       => esc_html__( 'Pagination Type', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::pagination_description(),
				'options'     => Options::pagination_dropdown( [ 'next_prev' ] ),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'block_structure_section', [
				'label' => esc_html__( 'Block Structure', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'block_structure_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Allow you to sort order elements to show such as category, title, meta...', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'block_structure_key_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Keys include: [category, title, meta, review, excerpt, readmore, divider]', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'block_structure',
			[
				'label'       => esc_html__( 'Block Structure Order', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => esc_html__( 'Input element keys to show, separate by comma. e.g. category, title, meta', 'gulir-core' ),
				'placeholder' => 'category, title, thumbnail, meta, review, excerpt, readmore',
				'default'     => '',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'featured_image_section', [
				'label' => esc_html__( 'Featured Image', 'gulir-core' ),
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
			'feat_hover',
			[
				'label'       => esc_html__( 'Hover Effect', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::feat_hover_description(),
				'options'     => Options::feat_hover_dropdown(),
				'default'     => '0',
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
			'feat_lazyload',
			[
				'label'       => esc_html__( 'Lazy Load', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::feat_lazyload_description(),
				'options'     => Options::feat_lazyload_dropdown(),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_category_section', [
				'label' => esc_html__( 'Entry Category', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'entry_category',
			[
				'label'       => esc_html__( 'Entry Category', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::entry_category_description(),
				'options'     => Options::extended_entry_category_dropdown( false ),
				'default'     => 'bg-1',
			]
		);
		$this->add_control(
			'entry_tax',
			[
				'label'       => esc_html__( 'Replace Category by Taxonomy', 'gulir-core' ),
				'description' => Options::post_type_tax_info_description(),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::taxonomy_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'entry_category_size', [
				'label'       => esc_html__( 'Entry Category Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_category_size_description(),
				'selectors'   => [ '{{WRAPPER}} .p-category' => 'font-size: {{VALUE}}px !important;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Custom Entry Category Font', 'gulir-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .p-categories',
			]
		);
		$this->add_control(
			'hide_category',
			[
				'label'       => esc_html__( 'Hide Entry Category', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_category_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_title_section', [
				'label' => esc_html__( 'Post Title', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
				'selectors'   => [ '{{WRAPPER}}' => '--title-size: {{VALUE}}px;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .entry-title',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_meta_section', [
				'label' => esc_html__( 'Entry Meta', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'entry_meta_flex_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::meta_flex_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'entry_meta_prefix_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::meta_prefix_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'entry_meta',
			[
				'label'       => esc_html__( 'Entry Meta Tags', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => Options::entry_meta_tags_description(),
				'placeholder' => Options::entry_meta_tags_placeholder(),
				'default'     => 'avatar, author, update',
			]
		);
		$this->add_control(
			'meta_divider',
			[
				'label'       => esc_html__( 'Divider Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::meta_divider_description(),
				'options'     => Options::meta_divider_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'review',
			[
				'label'       => esc_html__( 'Review Meta', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::review_description(),
				'separator'   => 'before',
				'options'     => Options::review_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->add_control(
			'review_meta',
			[
				'label'       => esc_html__( 'Review Meta Description', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::review_meta_description(),
				'options'     => Options::review_meta_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->add_control(
			'sponsor_meta',
			[
				'label'       => esc_html__( 'Sponsored Meta', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::sponsor_meta_description(),
				'options'     => Options::sponsor_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->add_responsive_control(
			'entry_meta_size', [
				'label'       => esc_html__( 'Entry Meta Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_meta_size_description(),
				'separator'   => 'before',
				'selectors'   => [ '{{WRAPPER}}' => '--meta-fsize: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'avatar_size', [
				'label'       => esc_html__( 'Author Avatar Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::avatar_size_description(),
				'selectors'   => [ 'body {{WRAPPER}} .meta-avatar img' => 'width: {{VALUE}}px; height: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'review_size',
			[
				'label'       => esc_html__( 'Review Rating Icon Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::review_size_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--rating-size: {{VALUE}}px;' ],
				'default'     => '',
			]
		);
		$this->add_control(
			'tablet_hide_meta',
			[
				'label'       => esc_html__( 'Hide Entry Meta on Tablet', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => Options::tablet_hide_meta_description(),
				'placeholder' => esc_html__( 'avatar, author', 'gulir-core' ),
				'default'     => [],
			]
		);
		$this->add_control(
			'mobile_hide_meta',
			[
				'label'       => esc_html__( 'Hide Entry Meta on Mobile', 'gulir-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'ai'          => [ 'active' => false ],
				'rows'        => 2,
				'description' => Options::mobile_hide_meta_description(),
				'placeholder' => esc_html__( 'avatar, author', 'gulir-core' ),
				'default'     => [],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'bookmark_section', [
				'label' => esc_html__( 'Bookmark', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'bookmark',
			[
				'label'       => esc_html__( 'Bookmark Icon', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::bookmark_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_format_section', [
				'label' => esc_html__( 'Post Format', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'entry_format',
			[
				'label'       => esc_html__( 'Post Format Icon', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::entry_format_description(),
				'options'     => Options::entry_format_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->add_responsive_control(
			'entry_format_size', [
				'label'       => esc_html__( 'Icon Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_format_size_description(),
				'selectors'   => [ '{{WRAPPER}} .p-format' => 'font-size: {{VALUE}}px !important;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'excerpt_section', [
				'label' => esc_html__( 'Excerpt', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'excerpt_length',
			[
				'label'       => esc_html__( 'Excerpt - Max Length', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::max_excerpt_description(),
				'default'     => 12,
			]
		);
		$this->add_control(
			'excerpt_source',
			[
				'label'       => esc_html__( 'Excerpt - Source', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::excerpt_source_description(),
				'options'     => Options::excerpt_source_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'entry_excerpt_size', [
				'label'       => esc_html__( 'Entry Excerpt Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::excerpt_size_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--excerpt-fsize: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'excerpt_columns',
			[
				'label'       => esc_html__( 'Excerpt - Columns', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::excerpt_columns_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--excerpt-columns: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'excerpt_gap',
			[
				'label'     => esc_html__( 'Excerpt - Column Gap', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--excerpt-gap: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'hide_excerpt',
			[
				'label'       => esc_html__( 'Hide Excerpt', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_excerpt_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			]
		);
		$this->add_control(
			'hide_excerpt_t',
			[
				'label'       => esc_html__( 'Hide Excerpt by Title Words', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::hide_excerpt_by_title_description(),
				'placeholder' => '15',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'readmore_section', [
				'label' => esc_html__( 'Read More', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'readmore_size', [
				'label'       => esc_html__( 'Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::readmore_size_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--readmore-fsize : {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'counter_section', [
				'label' => esc_html__( 'Index Counter', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'counter_index_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::counter_index_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'counter',
			[
				'label'       => esc_html__( 'Show Counter', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::counter_description(),
				'options'     => Options::counter_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'counter_zero', [
				'label'       => esc_html__( 'Zero Number', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::counter_zero_description(),
				'options'     => Options::counter_zero_dropdown(),
				'default'     => 'decimal-leading-zero',
				'selectors'   => [
					'{{WRAPPER}}' => '--counter-zero: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'counter_set',
			[
				'label'       => esc_html__( 'Counter Offset', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::counter_set_description(),
				'selectors'   => [
					'{{WRAPPER}} .block-wrap' => 'counter-increment: trend-counter {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'counter_size', [
				'label'       => esc_html__( 'Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::counter_size_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--counter-size: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'counter_color',
			[
				'label'     => esc_html__( 'Counter Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--counter-color: {{VALUE}}; --counter-opacity: 1;',
				],
			]
		);
		$this->add_control(
			'dark_counter_color',
			[
				'label'     => esc_html__( 'Dark Mode - Counter Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--counter-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'counter_bg',
			[
				'label'     => esc_html__( 'Counter Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'counter' =>  [ 'circle', 'circle-sq', 'circle-b', 'circle-sqb' ],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--counter-bg: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_counter_bg',
			[
				'label'     => esc_html__( 'Dark Mode - Counter Background', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'counter' =>  [ 'circle', 'circle-sq', 'circle-b', 'circle-sqb' ],
				],
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}' => '--counter-bg: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'divider_section', [
				'label' => esc_html__( 'Entry Divider', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'divider_style',
			[
				'label'       => esc_html__( 'Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::divider_style_description(),
				'options'     => Options::divider_style_dropdown(),
				'default'     => 'solid',
			]
		);
		$this->add_responsive_control(
			'divider_width',
			[
				'label'       => esc_html__( 'Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::divider_width_description(),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .p-divider:before' => 'max-width: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'divider_color',
			[
				'label'       => esc_html__( 'Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::divider_color_description(),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}}' => '--divider-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'divider_dark_color',
			[
				'label'       => esc_html__( 'Dark Mode - Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::divider_dark_color_description(),
				'default'     => '',
				'selectors'   => [
					'[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}} .light-scheme' => '--divider-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'hide_divider',
			[
				'label'       => esc_html__( 'Hide Divider', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_divider_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'pagination_style_section', [
				'label' => esc_html__( 'Pagination', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'pagination_style',
			[
				'label'       => esc_html__( 'Pagination Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::pagination_style_description(),
				'options'     => Options::pagination_style_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'pagination_size',
			[
				'label'       => esc_html__( 'Label Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::pagination_size_description(),
				'selectors'   => [
					'{{WRAPPER}}' => '--pagi-size: {{VALUE}}px;',
				],
			]
		);
		$this->add_control(
			'pagination_color',
			[
				'label'       => esc_html__( 'Label Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::pagination_color_description(),
				'separator'   => 'before',
				'selectors'   => [ '{{WRAPPER}}' => '--pagi-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'pagination_accent_color',
			[
				'label'       => esc_html__( 'Background & Border', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::pagination_accent_color_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--pagi-accent-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_pagination_color',
			[
				'label'       => esc_html__( 'Dark Mode - Label Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::pagination_dark_color_description(),
				'separator'   => 'before',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--pagi-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_pagination_accent_color',
			[
				'label'       => esc_html__( 'Dark Mode - Background & Border', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::pagination_dark_accent_color_description(),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}' => '--pagi-accent-color: {{VALUE}};' ],
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
		$this->end_controls_section();
		$this->start_controls_section(
			'border_section', [
				'label' => esc_html__( 'Grid Borders', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'border_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::column_border_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
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
		$this->add_control(
			'bottom_border',
			[
				'label'       => esc_html__( 'Bottom Border', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::bottom_border_description(),
				'options'     => Options::column_border_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'last_bottom_border',
			[
				'label'       => esc_html__( 'Last Bottom Border', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::last_bottom_border_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_section', [
				'label' => esc_html__( 'Overlay Content', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'content_style',
			[
				'label'       => esc_html__( 'Content Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose a display style for the inner content.', 'gulir-core' ),
				'options'     => [
					'0'     => esc_html__( 'Transparent Overlay', 'gulir-core' ),
					'boxed' => esc_html__( 'Boxed Background', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'overlay_padding', [
				'label'       => esc_html__( 'Inner Content Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom padding values (in pixels) for the overlay content.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .overlay-inner' => 'padding: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'overlay_width', [
				'label'       => esc_html__( 'Inner Content Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::inner_width_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--overlay-width: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'overlay_margin', [
				'label'       => esc_html__( 'Boxed Margin', 'gulir-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', 'custom' ],
				'description' => Options::overlay_margin_description(),
				'condition'   => [
					'content_style' => 'boxed',
				],
				'selectors'   => [
					'{{WRAPPER}} .is-inner-boxed .overlay-inner' => 'margin:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label'     => esc_html__( 'Boxed Overlay Shadow', 'gulir-core' ),
				'name'      => 'overlay_shadow',
				'condition' => [
					'content_style' => 'boxed',
				],
				'selector'  => '{{WRAPPER}} .overlay-inner',
			]
		);
		$this->add_control(
			'overlay_scheme',
			[
				'label'       => esc_html__( 'Text Color Scheme', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::color_scheme_description(),
				'options'     => [
					'0'    => esc_html__( 'Light Text', 'gulir-core' ),
					'dark' => esc_html__( 'Dark Text', 'gulir-core' ),
				],
				'default'     => '0',
			]
		);
		$this->add_control(
			'transparent_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::overlay_bg_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'overlay_bg_heading',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<strong>' . esc_html__( 'Background Overlay', 'gulir-core' ) . '</strong>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'overlay_bg',
				'types'    => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .p-gradient .overlay-inner, {{WRAPPER}} .p-top-gradient .overlay-inner, {{WRAPPER}} .p-bg-overlay .overlay-wrap:before',
			]
		);
		$this->add_control(
			'dark_overlay_bg_heading',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<strong>' . esc_html__( 'Dark Mode - Background Overlay', 'gulir-core' ) . '</strong>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'dark_overlay_bg',
				'types'    => [ 'gradient' ],
				'selector' => '[data-theme="dark"] {{WRAPPER}} .p-gradient .overlay-inner, [data-theme="dark"] {{WRAPPER}} .p-top-gradient .overlay-inner, [data-theme="dark"] {{WRAPPER}} .p-bg-overlay .overlay-wrap:before',
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
			'el_spacing', [
				'label'       => esc_html__( 'Custom Element Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_spacing_description(),
				'selectors'   => [ '{{WRAPPER}} .p-wrap' => '--el-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'bottom_margin', [
				'label'       => esc_html__( 'Custom Bottom Margin', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_margin_description(),
				'selectors'   => [ '{{WRAPPER}} .block-wrap' => '--bottom-spacing: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'center_section', [
				'label' => esc_html__( 'Centering', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'center_mode',
			[
				'label'       => esc_html__( 'Centering Content', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::center_mode_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->add_control(
			'middle_mode',
			[
				'label'       => esc_html__( 'Vertical Align', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::middle_mode_description(),
				'options'     => Options::vertical_align_dropdown(),
				'default'     => '0',
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
			'horizontal_scroll_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::horizontal_scroll_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
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

		if ( ! gulir_get_option( 'bookmark_system' ) ) {
			if ( current_user_can( 'manage_options' ) ) {
				echo '<div class="rb-error">' . esc_html__( 'The Personalized System is currently disabled. Please enable it in "Theme Options > Personalized System > Global" to activate this block.', 'gulir-core' ) . '</div>';
			}

			return;
		}

		if ( function_exists( 'gulir_get_overlay_personalize' ) ) {
			$settings             = $this->get_settings();
			$settings['uuid']     = 'uid_' . $this->get_id();
			$settings['readmore'] = 1;

			echo gulir_get_overlay_personalize( $settings );
		}
	}
}