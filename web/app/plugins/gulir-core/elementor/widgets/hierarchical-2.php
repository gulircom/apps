<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_hierarchical_2;
use function gulir_is_ruby_template;

class Hierarchical_2 extends Widget_Base {

	public function get_name() {

		return 'gulir-hierarchical-2';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Hierarchical 2', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-sitemap';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'post', 'listing', 'blog', 'mixed' ];
	}

	public function get_categories() {

		return [ 'gulir' ];
	}

	protected function register_controls() {

		if ( gulir_is_ruby_template() ) {
			$this->start_controls_section(
				'dynamic_info_section', [
					'label' => esc_html__( 'Dynamic Query Tips', 'gulir-core' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'dynamic_query_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::dynamic_query_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'dynamic_tag_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::dynamic_tag_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'dynamic_render_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::dynamic_render_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->end_controls_section();
		}

		$this->start_controls_section(
			'query_filters', [
				'label' => esc_html__( 'Query Settings', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Category Filter', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::category_description(),
				'options'     => ( gulir_is_ruby_template() ) ? Options::cat_dropdown( true ) : Options::cat_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories Filter', 'gulir-core' ),
				'placeholder' => esc_html__( '1,2,3', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::categories_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'category_not_in',
			[
				'label'       => esc_html__( 'Exclude Category IDs', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::category_not_in_description(),
				'placeholder' => esc_html__( '1,2,3', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'tags',
			[
				'label'       => esc_html__( 'Tags Slug Filter', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::tags_description(),
				'separator'   => 'before',
				'placeholder' => esc_html__( 'tag1,tag2,tag3', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'tag_not_in',
			[
				'label'       => esc_html__( 'Exclude Tags Slug', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::tag_not_in_description(),
				'placeholder' => esc_html__( 'tag1,tag2,tag3', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'format',
			[
				'label'       => esc_html__( 'Post Format', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::format_description(),
				'options'     => Options::format_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'author',
			[
				'label'       => esc_html__( 'Author Filter', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::author_description(),
				'options'     => ( gulir_is_ruby_template() ) ? Options::author_dropdown( true ) : Options::author_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'post_not_in',
			[
				'label'       => esc_html__( 'Exclude Post IDs', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::post_not_in_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'post_in',
			[
				'label'       => esc_html__( 'Post IDs Filter', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::post_in_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'order',
			[
				'label'       => esc_html__( 'Order By', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::order_description(),
				'options'     => Options::order_dropdown(),
				'separator'   => 'before',
				'default'     => 'date_post',
			]
		);
		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'Number of Posts', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::posts_per_page_description(),
				'default'     => '5',
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
				'options'     => Options::pagination_dropdown( [ 'load_more', 'infinite_scroll' ] ),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		if ( defined( 'JETPACK__VERSION' ) ) {
			$this->start_controls_section(
				'jetpack_section', [
					'label' => esc_html__( 'Jetpack Top Posts', 'gulir-core' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'jetpack_query_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'The Top posts will display the top posts calculated from 24-48 hours of statistics gathered by the Jetpack plugin. The filter has its cache, so changes may take a while to propagate.', 'gulir-core' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'jetpack_filter_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'The settings in this section will override other query settings such as: sort order and more...', 'gulir-core' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->add_control(
				'jetpack_total_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'The maximum number of posts to show is 10, you can set this value in the "Query Settings > Posts Per Page".', 'gulir-core' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'jetpack_top_posts',
				[
					'label'       => esc_html__( 'Show Top Posts', 'gulir-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => esc_html__( 'Enable or disable the jetpack top posts filters.', 'gulir-core' ),
					'options'     => Options::switch_dropdown( false ),
					'default'     => '-1',
				]
			);
			$this->add_control(
				'jetpack_days',
				[
					'label'       => esc_html__( 'Number of Days', 'gulir-core' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'The number of days used to calculate Top Posts for the Top Posts is not recommended to exceed 10 days at once', 'gulir-core' ),
					'placeholder' => '2',
					'default'     => 2,
				]
			);
			if ( defined( 'IS_WPCOM' ) && IS_WPCOM ) {
				$this->add_control(
					'jetpack_sort_order',
					[
						'label'   => esc_html__( 'Order Top Posts By', 'gulir-core' ),
						'type'    => Controls_Manager::SELECT,
						'options' => [
							'views' => esc_html__( 'Views', 'gulir-core' ),
							'likes' => esc_html__( 'Likes', 'gulir-core' ),
						],
						'default' => 'views',
					]
				);
			}
			$this->end_controls_section();
		}
		$this->start_controls_section(
			'unique_section', [
				'label' => esc_html__( 'Unique Post', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'unique_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::unique_info(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'unique',
			[
				'label'       => esc_html__( 'Unique Post', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::unique_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
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
		$this->add_control(
			'sub_title_tag',
			[
				'label'       => esc_html__( 'Secondary Title HTML Tag', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::sub_heading_html_description(),
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
		$this->add_responsive_control(
			'sub_title_tag_size', [
				'label'       => esc_html__( 'Secondary Title Font Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::sub_title_size_description(),
				'selectors'   => [ '{{WRAPPER}} .p-list-inline .entry-title' => 'font-size: {{VALUE}}px;' ],
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
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Secondary Title Font', 'gulir-core' ),
				'name'     => 'sub_title_font',
				'selector' => '{{WRAPPER}} .p-list-inline > .entry-title',
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
				'default'     => 'avatar,author,update',
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
				'default'     => 'replace',
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
		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--meta-fcolor: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'meta_b_color',
			[
				'label'       => esc_html__( 'Important Meta Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}}' => '--meta-b-fcolor: {{VALUE}}; --ecat-highlight: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'dark_meta_color',
			[
				'label'     => esc_html__( 'Dark Mode - Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}} .light-scheme' => '--meta-fcolor: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dark_meta_b_color',
			[
				'label'     => esc_html__( 'Dark Mode - Important Meta Color', 'gulir-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'[data-theme="dark"] {{WRAPPER}}, {{WRAPPER}} .light-scheme' => '--meta-b-fcolor: {{VALUE}}; --ecat-highlight: {{VALUE}}',
				],
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
				'default'     => '-1',
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
				'options'     => [
					'after-category' => esc_html__( 'After Entry Category', 'gulir-core' ),
					'-1'             => esc_html__( 'Disable', 'gulir-core' ),
				],
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
			'hide_excerpt',
			[
				'label'       => esc_html__( 'Hide Excerpt', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_excerpt_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'readmore_section', [
				'label' => esc_html__( 'Read More', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'readmore',
			[
				'label'       => esc_html__( 'Read More Button', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::readmore_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
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
		$this->add_responsive_control(
			'first_bottom_margin', [
				'label'       => esc_html__( 'First Post Bottom Margin', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom bottom margin values (in pixels) for the first post.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}} .p-wrap:first-child' => 'margin-bottom: {{VALUE}}px; padding-bottom: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {

		if ( function_exists( 'gulir_get_hierarchical_2' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_hierarchical_2( $settings );
		}
	}
}