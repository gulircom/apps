<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_get_lightbox_gallery;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Lightbox_Gallery extends Widget_Base {

	public function get_name() {

		return 'gulir-lightbox-gallery';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Lightbox Gallery', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-gallery-grid';
	}

	public function get_keywords() {

		return [ 'gulir', 'ruby', 'images', 'showcase', 'list', 'photo', 'gallery', 'popup' ];
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', [
				'label' => esc_html__( 'Gallery', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$gallery_item = new Repeater();
		$gallery_item->add_control(
			'image',
			[
				'label' => esc_html__( 'Upload Image', 'gulir-core' ),
				'type'  => Controls_Manager::MEDIA,
				'ai'    => [ 'active' => false ],
			]
		);
		$gallery_item->add_responsive_control(
			'ratio',
			[
				'label'       => esc_html__( 'Ratio', 'gulir-core' ),
				'description' => esc_html__( 'Adjust the aspect ratio of this gallery item for improved visual balance.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--feat-ratio: {{VALUE}};',
				],
			]
		);
		$gallery_item->add_control(
			'title',
			[
				'label'   => esc_html__( 'Image Title', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'ai'      => [ 'active' => false ],
				'rows'    => 1,
				'default' => '',
			]
		);
		$gallery_item->add_control(
			'excerpt',
			[
				'label'   => esc_html__( 'Caption', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'ai'      => [ 'active' => false ],
				'rows'    => 2,
				'default' => '',
			]
		);
		$gallery_item->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'gulir-core' ),
				'type'    => Controls_Manager::TEXTAREA,
				'ai'      => [ 'active' => false ],
				'default' => '',
			]
		);
		$this->add_control(
			'gallery_data',
			[
				'label'       => esc_html__( 'Add Item', 'gulir-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $gallery_item->get_controls(),
				'default'     => [
					[
						'title'       => esc_html__( 'Item #1', 'gulir-core' ),
						'excerpt'     => '',
						'description' => '',
						'image'       => '',
					],
				],
				'title_field' => '{{{ excerpt }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout', [
				'label' => esc_html__( 'Style & Layout', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'gird_layout_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'PLEASE NOTE: The Masonry layout relies on CSS, which arranges the gallery items in a column-based (vertical) order.', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'grid_layout', [
				'label'       => esc_html__( 'Grid Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a grid layout for the gallery.', 'gulir-core' ),
				'options'     => [
					'masonry' => esc_html__( 'CSS Masonry', 'gulir-core' ),
					'flex'    => esc_html__( 'Flexbox', 'gulir-core' ),
				],
				'default'     => 'masonry',
			]
		);
		$this->add_responsive_control(
			'masonry_columns', [
				'label'       => esc_html__( 'Masonry Columns', 'gulir-core' ),
				'description' => esc_html__( 'Set the number of columns for the Masonry layout.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [ 'grid_layout' => 'masonry' ],
				'selectors'   => [
					'{{WRAPPER}}' => '--gallery-masonry: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'masonry_gap', [
				'label'       => esc_html__( 'Masonry Column Gap', 'gulir-core' ),
				'description' => esc_html__( 'Set the column gap value for the Masonry layout.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [ 'grid_layout' => 'masonry' ],
				'selectors'   => [
					'{{WRAPPER}}' => '--gallery-masonry-gap: {{VALUE}}px',
				],
				'default'     => 10,
			]
		);
		$this->add_control(
			'content_layout', [
				'label'       => esc_html__( 'Content Layout', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a layout for the content, including caption and description.', 'gulir-core' ),
				'options'     => [
					'overlay'  => esc_html__( 'Overlay', 'gulir-core' ),
					'standard' => esc_html__( 'Standard', 'gulir-core' ),
				],
				'default'     => 'overlay',
			]
		);
		$this->add_control(
			'image_style', [
				'label'       => esc_html__( 'Item Box Style', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select a style for the gallery item', 'gulir-core' ),
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
				'label'       => esc_html__( 'Border Width', 'gulir-core' ),
				'description' => esc_html__( 'Input a custom border width value for the gallery item.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--gallery-border-width: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'image_border_radius', [
				'label'       => esc_html__( 'Border Radius', 'gulir-core' ),
				'description' => esc_html__( 'Input a custom border radius value for the gallery image.', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'selectors'   => [ '{{WRAPPER}}' => '--gallery-border-radius: {{VALUE}}px;' ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'image_section', [
				'label' => esc_html__( 'Image', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
		$this->add_responsive_control(
			'display_ratio', [
				'label'       => esc_html__( 'Default Ratio', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select a default ratio for the gallery image.', 'gulir-core' ),
				'selectors'   => [
					'{{WRAPPER}}' => '--feat-ratio: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'crop_size',
			[
				'label'       => esc_html__( 'Crop Size', 'gulir-core' ),
				'description' => esc_html__( 'This setting applies only to the gallery layout. The lightbox gallery will use full-size images.', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Options::crop_size_dropdown(),
				'default'     => '0',
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
				'label' => esc_html__( 'Caption', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__( 'Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the title.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ '{{WRAPPER}} .gallery-item-excerpt' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_title_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the caption in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#fff',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .gallery-item-excerpt' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Caption Font', 'gulir-core' ),
				'name'     => 'heading_font',
				'selector' => '{{WRAPPER}} .gallery-item-excerpt',
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
				'selectors'   => [ '{{WRAPPER}} .gallery-item-desc' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'dark_desc_color',
			[
				'label'       => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
				'description' => esc_html__( 'Select a color for the description in dark mode.', 'gulir-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#eee',
				'selectors'   => [ '[data-theme="dark"] {{WRAPPER}} .gallery-item-desc' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Description Font', 'gulir-core' ),
				'name'     => 'title_font',
				'selector' => '{{WRAPPER}} .gallery-item-desc',
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
				'label' => esc_html__( 'Flexbox - Columns', 'gulir-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'column_info',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Column settings are only available for Flexbox layout', 'gulir-core' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);
		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns on Desktop', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_description(),
				'options'     => Options::columns_dropdown(),
				'condition'   => [
					'grid_layout' => 'flex',
				],
				'default'     => '3',
			]
		);
		$this->add_control(
			'columns_tablet',
			[
				'label'       => esc_html__( 'Columns on Tablet', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_tablet_description(),
				'options'     => Options::columns_dropdown(),
				'condition'   => [
					'grid_layout' => 'flex',
				],
				'default'     => '0',
			]
		);
		$this->add_control(
			'columns_mobile',
			[
				'label'       => esc_html__( 'Columns on Mobile', 'gulir-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => Options::columns_mobile_description(),
				'options'     => Options::columns_dropdown(),
				'condition'   => [
					'grid_layout' => 'flex',
				],
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
				'condition'   => [
					'grid_layout' => 'flex',
				],
				'default'     => '0',
			]
		);
		$this->add_responsive_control(
			'column_gap_custom', [
				'label'       => esc_html__( '1/2 Custom Gap Value', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::column_gap_custom_description(),
				'condition'   => [
					'grid_layout' => 'flex',
				],
				'selectors'   => [
					'{{WRAPPER}} .is-gap-custom'                  => 'margin-left: -{{VALUE}}px; margin-right: -{{VALUE}}px; --colgap: {{VALUE}}px;',
					'{{WRAPPER}} .is-gap-custom .block-inner > *' => 'padding-left: {{VALUE}}px; padding-right: {{VALUE}}px;',
				],
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
				'label'     => esc_html__( 'Custom Element Spacing', 'gulir-core' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ '{{WRAPPER}}' => '--el-spacing: {{VALUE}}px;' ],
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
			'content_padding', [
				'label'       => esc_html__( 'Content Padding', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Input custom padding content including caption and description.', 'gulir-core' ),
				'selectors'   => [ '{{WRAPPER}}' => '--gallery-content-padding: {{VALUE}}px;' ],
			]
		);
		$this->add_responsive_control(
			'bottom_margin', [
				'label'       => esc_html__( 'Custom Bottom Margin', 'gulir-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => Options::el_margin_description(),
				'selectors'   => [ '{{WRAPPER}}' => '--bottom-spacing: {{VALUE}}px;' ],
				'default'     => 10,
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
				'label'   => esc_html__( 'Centering Content', 'gulir-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Options::switch_dropdown( false ),
				'default' => '-1',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		if ( function_exists( 'gulir_get_lightbox_gallery' ) ) {
			$settings         = $this->get_settings();
			$settings['uuid'] = 'uid_' . $this->get_id();
			echo gulir_get_lightbox_gallery( $settings );
		}
	}
}