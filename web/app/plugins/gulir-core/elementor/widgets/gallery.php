<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_simple_gallery;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Simple_Gallery extends Widget_Base {

	public function get_name() {

		return 'gulir-simple-gallery';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Simple Gallery', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-gallery-grid';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'images', 'showcase', 'list', 'photo', 'gallery' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', [
				'label' => esc_html__( 'General', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$gallery_item = new Repeater();
		$gallery_item->add_control(
			'image',
			[
				'label' => esc_html__( 'Item Image', 'gulir-core' ),
				'type'  => Controls_Manager::MEDIA,
				'ai'    => [ 'active' => false ],
			]
		);
		$gallery_item->add_control(
			'title',
			[
				'label'   => esc_html__( 'Item Title', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'ai'      => [ 'active' => false ],
				'rows'    => 1,
				'default' => '',
			]
		);
		$gallery_item->add_control(
			'description',
			[
				'label'   => esc_html__( 'Item Description', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'ai'      => [ 'active' => false ],
				'rows'    => 2,
				'default' => '',
			]
		);
		$gallery_item->add_control(
			'meta',
			[
				'label'   => esc_html__( 'Meta', 'gulir-core' ),
				'type'    => Controls_Manager::TEXT,
				'ai'      => [ 'active' => false ],
				'default' => '',
			]
		);
		$gallery_item->add_control(
			'link',
			[
				'label'   => esc_html__( 'Item URL', 'gulir-core' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => false,
				],
			]
		);
		$this->add_control(
			'gallery_data',
			[
				'label'       => esc_html__( 'Add Gallery Item', 'gulir-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $gallery_item->get_controls(),
				'default'     => [
					[
						'title'       => esc_html__( 'Item #1', 'gulir-core' ),
						'description' => '',
						'image'       => '',
						'link'        => '',
						'meta'        => '',
					],
				],
				'title_field' => '{{{ title }}} - {{{ description }}}',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'image_section', [
				'label' => esc_html__( 'Image', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'image_style', [
				'label'       => esc_html__( 'Image Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a style for the gallery image', 'gulir-core' ),
				'options'     => [
					'shadow'   => esc_html__( 'Shadow', 'gulir-core' ),
					'border'   => esc_html__( 'Dark Border', 'gulir-core' ),
					'g-border' => esc_html__( 'Gray Border', 'gulir-core' ),
					'none'     => esc_html__( 'None', 'gulir-core' ),
				],
				'default'     => 'shadow',
			]
		);
		$this->add_responsive_control(
			'image_border_width', [
				'label'       => esc_html__( 'Image Border Width', 'gulir-core' ),
				'description' => esc_html__( 'Input a custom border width value for the gallery image.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--gallery-border-width: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'image_border_radius', [
				'label'       => esc_html__( 'Image Border Radius', 'gulir-core' ),
				'description' => esc_html__( 'Input a custom border radius value for the gallery image.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--gallery-border-radius: {{VALUE}}px;' ],
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
			'title_section', [
				'label' => esc_html__( 'Title', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the title.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .simple-gallery-title' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_title_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the title in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#fff',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .simple-gallery-title' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Title Font', 'gulir-core' ),
				'name'     => 'heading_font',
				'selector' => '{{WRAPPER}} .simple-gallery-title',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'description_section', [
				'label' => esc_html__( 'Description', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the description', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .simple-gallery-desc' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_desc_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the description in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#eee',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .simple-gallery-desc' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Description Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .simple-gallery-desc',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'meta_section', [
				'label' => esc_html__( 'Meta', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Meta Font', 'gulir-core' ),
				'name'     => 'meta_font',
				'selector' => '{{WRAPPER}} .simple-gallery-meta',
			]
		);
		$this->add_responsive_control(
			'meta_border_radius', [
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'description' => esc_html__( 'Input a custom border radius value for the meta.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}} .simple-gallery-meta' => 'border-radius: {{VALUE}}px;' ],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(), [
				'label'    => esc_html__( 'Meta Background', 'gulir-core' ),
				'name'     => 'meta_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .simple-gallery-meta',
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
				'selectors'   => [ '{{WRAPPER}} .block-wrap' => '--el-spacing: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'image_spacing', [
				'label'       => esc_html__( 'Image Spacing', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom a bottom spacing values (in pixels) for the images.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--image-spacing: {{VALUE}}px;' ],
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
				'default'     => '1',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_get_simple_gallery' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_simple_gallery( $settings );
		}
	}
}