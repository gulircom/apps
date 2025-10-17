<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_podcast_grid_flex_1;
use function gulir_is_ruby_template;

class Podcast_Grid_Flex_1 extends Widget_Base {

	public function get_name() {

		return 'gulir-podcast-grid-flex-1';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Podcast Flex Grid', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-posts-grid';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'podcast', 'listing', 'audio', 'music' ];
	}

	public function get_categories() {

		return [ 'gulir_podcast' ];
	}

	protected function register_controls() {

		if ( gulir_is_ruby_template() ) {
			$this->start_controls_section(
				'template-builder-section', [
					'label' => esc_html__( 'Template Builder - Global Query', 'gulir-core' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'template_builder_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => esc_html__( 'Settings below allow you to apply the global query loop to this block and show it as a the main listing for the show, archive etc...', 'gulir-core' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'template_builder_unique_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::template_builder_unique_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->add_control(
				'template_builder_available_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::template_builder_available_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->add_control(
				'template_builder_pagination_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::template_builder_pagination_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->add_control(
				'template_builder_posts_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::template_builder_posts_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->add_control(
				'template_builder_total_posts_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::template_builder_total_posts_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'template_builder_admin_info',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => Options::template_builder_admin_info(),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				]
			);
			$this->add_control(
				'query_mode',
				[
					'label'       => esc_html__( 'Query Mode', 'gulir-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => Options::query_mode_description(),
					'options'     => [
						'0'      => esc_html__( 'Use Custom Query (default)', 'gulir-core' ),
						'global' => esc_html__( 'Use WP Global Query', 'gulir-core' ),
					],
					'default'     => '0',
				]
			);
			$this->add_control(
				'builder_pagination',
				[
					'label'       => esc_html__( 'WP Global Query Pagination', 'gulir-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => Options::template_pagination_description(),
					'options'     => Options::template_builder_pagination_dropdown(),
					'default'     => '0',
				]
			);
			$this->end_controls_section();
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
				'label'       => esc_html__( 'Show Filter', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::category_description(),
				'options'     => ( gulir_is_ruby_template() ) ? Options::cat_dropdown( true, 'series' ) : Options::cat_dropdown( false, 'series' ),
				'default'     => '0',
			]
		);
		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Multiple Shows Filter', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => Options::categories_description(),
				'ai'          => [ 'active' => false ],
				'default'     => '',
			]
		);
		$this->add_control(
			'category_not_in',
			[
				'label'       => esc_html__( 'Exclude Show IDs', 'gulir-core' ),
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
			'author',
			[
				'label'       => esc_html__( 'Host Filter', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::author_description(),
				'options'     => ( gulir_is_ruby_template() ) ? Options::author_dropdown( true ) : Options::author_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'post_not_in',
			[
				'label'       => esc_html__( 'Exclude Episode IDs', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'description' => Options::post_not_in_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'post_in',
			[
				'label'       => esc_html__( 'Episode IDs Filter', 'gulir-core' ),
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
				'options'     => Options::order_dropdown( [
					'post_index'      => esc_html__( 'Episode Index ASC', 'gulir-core' ),
					'post_index_desc' => esc_html__( 'Episode Index DECS', 'gulir-core' ),
				] ),
				'default'     => 'date_post',
			]
		);
		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'Number of Episodes', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::posts_per_page_description(),
				'default'     => '3',
			]
		);
		$this->add_control(
			'offset',
			[
				'label'       => esc_html__( 'Episode Offset', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::offset_description(),
				'default'     => '',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'extend_query_section', [
				'label' => esc_html__( 'Taxonomies', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'podcast_tax_query_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::podcast_tax_query_info_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'taxonomy',
			[
				'label'       => esc_html__( 'Define Taxonomy', 'gulir-core' ),
				'description' => Options::taxonomy_query_description(),
				'placeholder' => esc_html__( 'genre', 'gulir-core' ),
				'type'        => Controls_Manager::TEXT,
				'ai'          => [ 'active' => false ],
				'default'     => '',
			]
		);
		$this->add_control(
			'tax_slugs',
			[
				'label'       => esc_html__( 'Term Slugs', 'gulir-core' ),
				'description' => Options::term_slugs_description(),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 1,
				'ai'          => [ 'active' => false ],
				'placeholder' => esc_html__( 'termslug1, termslug2, termslug3', 'gulir-core' ),
				'default'     => '',
			]
		);
		$this->add_control(
			'tax_operator',
			[
				'label'   => esc_html__( 'Query Operator', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0'   => esc_html__( '- Default (IN) -', 'gulir-core' ),
					'not' => esc_html__( 'NOT IN', 'gulir-core' ),
					'and' => esc_html__( 'AND', 'gulir-core' ),
				],
				'default' => '0',
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
				'options'     => Options::pagination_dropdown(),
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
				'label' => esc_html__( 'Unique Episode', 'gulir-core' ),
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
				'label'       => esc_html__( 'Unique Episode', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::unique_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
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
				'raw'             => esc_html__( 'Allow you to sort order elements to show such as title, thumbnail, meta...', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'block_structure_key_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Keys include: [category, title, thumbnail, meta, review, excerpt, readmore, divider, player ]', 'gulir-core' ),
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
				'description' => esc_html__( 'Input element keys to show, separate by comma. e.g. thumbnail, title, meta', 'gulir-core' ),
				'placeholder' => 'category, title, thumbnail, meta, review, excerpt, readmore, player',
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
			'overlay_category',
			[
				'label'       => esc_html__( 'Overlay Entry Show', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Enable or disable the entry show on the feature image.', 'gulir-core' ),
				'options'     => [
					'0' => esc_html__( '- Disable -', 'gulir-core' ),
					'1' => esc_html__( 'Enable', 'gulir-core' ),
				],
				'default'     => '1',
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
				'label' => esc_html__( 'Entry Show', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'entry_category',
			[
				'label'       => esc_html__( 'Entry Show', 'gulir-core' ),
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
				'label'       => esc_html__( 'Entry Show Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::entry_category_size_description(),
				'selectors'   => [ '{{WRAPPER}} .p-category' => 'font-size: {{VALUE}}px !important;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Custom Entry Show Font', 'gulir-core' ),
				'name'     => 'category_font',
				'selector' => '{{WRAPPER}} .p-categories',
			]
		);
		$this->add_control(
			'hide_category',
			[
				'label'       => esc_html__( 'Hide Entry Show', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::hide_category_description(),
				'options'     => Options::hide_dropdown( false ),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'entry_title_section', [
				'label' => esc_html__( 'Episode Title', 'gulir-core' ),
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
		$this->add_control(
			'title_index',
			[
				'label'       => esc_html__( 'Episode Index', 'gulir-core' ),
				'description' => esc_html__( 'Show the episode index before the post title.', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__( 'Title Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::title_color_description(),
				'default'     => '',
				'selectors'   => [
					'body:not([data-theme="dark"]) {{WRAPPER}}' => '--title-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Custom Episode Title Font', 'gulir-core' ),
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
				'description' => Options::podcast_entry_meta_tags_description(),
				'placeholder' => Options::podcast_entry_meta_tags_placeholder(),
				'default'     => 'play, index, duration',
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
				'default'     => '-1',
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
			'player_section', [
				'label' => esc_html__( 'Player', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'player_btn_size',
			[
				'label'       => esc_html__( 'Button Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom size for the play/pause button', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--player-btn-size: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'player_btn_fsize',
			[
				'label'       => esc_html__( 'Icon Size', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input a custom font size for the play/pause icon', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--player-btn-fsize: {{VALUE}}px;' ],
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
			'box_section', [
				'label' => esc_html__( 'Boxed', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'box_style',
			[
				'label'       => esc_html__( 'Box Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::box_style_description(),
				'options'     => Options::box_style_dropdown(),
				'default'     => '0',
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
		$this->add_responsive_control(
			'box_padding', [
				'label'       => esc_html__( 'Box Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_spacing_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--box-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'box_color',
			[
				'label'       => esc_html__( 'Box Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::box_color_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--box-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_box_color',
			[
				'label'       => esc_html__( 'Dark Mode - Box Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::box_dark_color_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--dark-box-color: {{VALUE}};' ],
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
		$this->end_controls_section();
		$this->start_controls_section(
			'responsive_section', [
				'label' => esc_html__( 'Responsive Layouts', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'tablet_layout',
			[
				'label'       => esc_html__( 'Tablet Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::tablet_layout_description(),
				'options'     => Options::responsive_layout_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			't_featured_list_width', [
				'label'       => esc_html__( 'Tablet List - Image Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::tablet_featured_width_description(),
				'placeholder' => '150',
				'selectors'   => [ '{{WRAPPER}}' => '--t-feat-list-width: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			' mobile_layout',
			[
				'label'       => esc_html__( 'Mobile Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::mobile_layout_description(),
				'options'     => Options::responsive_layout_dropdown(),
				'default'     => '0',
			]
		);
		$this->add_control(
			'featured_list_width', [
				'label'       => esc_html__( 'List - Image Width', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::mobile_featured_width_description(),
				'placeholder' => '150',
				'selectors'   => [ '{{WRAPPER}}' => '--feat-list-width: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'featured_list_position', [
				'label'       => esc_html__( 'List - Image Position', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::featured_position_description(),
				'options'     => Options::featured_position_dropdown(),
				'default'     => '0',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'carousel_section', [
				'label' => esc_html__( 'Carousel Mode', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'carousel_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => Options::carousel_info_description(),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'carousel',
			[
				'label'       => esc_html__( 'Carousel', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_mode_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->add_responsive_control(
			'carousel_columns',
			[
				'label'       => esc_html__( 'Number of Slides', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::carousel_columns_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'carousel_wide_columns',
			[
				'label'       => esc_html__( 'Wide Screen - Number of Slides', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::wide_carousel_columns_description(),
				'default'     => '',
			]
		);
		$this->add_responsive_control(
			'carousel_gap',
			[
				'label'       => esc_html__( 'Carousel Gap', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::carousel_gap_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'carousel_dot',
			[
				'label'       => esc_html__( 'Pagination Dot', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_dot_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->add_control(
			'carousel_nav',
			[
				'label'       => esc_html__( 'Next/Prev', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_nav_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '1',
			]
		);
		$this->add_responsive_control(
			'carousel_footer_margin',
			[
				'label'       => esc_html__( 'Nav Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::carousel_nav_spacing_description(),
				'selectors'   => [ '{{WRAPPER}} .slider-footer' => 'margin-top: {{VALUE}}px;' ],
			]
		);
		$this->add_control(
			'slider_play',
			[
				'label'       => esc_html__( 'Auto Play Next Slides', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_autoplay_description(),
				'options'     => Options::switch_dropdown(),
				'default'     => 0,
			]
		);
		$this->add_responsive_control(
			'slider_speed',
			[
				'label'       => esc_html__( 'Auto Play Speed', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::carousel_speed_description(),
				'default'     => '',
			]
		);
		$this->add_control(
			'slider_fmode',
			[
				'label'       => esc_html__( 'Free Mode', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_freemode_description(),
				'options'     => Options::switch_dropdown(),
				'default'     => 0,
			]
		);
		$this->add_control(
			'slider_centered',
			[
				'label'       => esc_html__( 'Centered Sliders', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::carousel_centered_description(),
				'options'     => Options::switch_dropdown( false ),
				'default'     => '-1',
			]
		);
		$this->add_control(
			'slider_nav_color',
			[
				'label'       => esc_html__( 'Nav, Dots Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::carousel_nav_color_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--slider-nav-color: {{VALUE}};' ],
				'default'     => '',
			]
		);
		$this->add_control(
			'dark_slider_nav_color',
			[
				'label'       => esc_html__( 'Dark Mode - Nav, Dots Color', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => Options::carousel_nav_color_description(),
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}}, .light-scheme {{WRAPPER}}' => '--slider-nav-color: {{VALUE}};' ],
				'default'     => '',
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

		if ( function_exists( 'gulir_get_podcast_grid_flex_1' ) ) {

			$settings              = $this->get_settings();
			$settings['readmore']  = 1;
			$settings['post_type'] = 'podcast';

			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_podcast_grid_flex_1( $settings );
		}
	}
}