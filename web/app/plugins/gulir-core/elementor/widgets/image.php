<?php

namespace gulirElementor\Widgets;
defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;
use gulirElementorControl\Options;
use function gulir_is_edit_mode;

/**
 * Class
 *
 * @package gulirElementor\Widgets
 */
class Image extends Widget_Base {

	public function get_name() {

		return 'gulir-image';
	}

	public function get_title() {

		return esc_html__( 'Gulir - Image', 'gulir-core' );
	}

	public function get_icon() {

		return 'eicon-image';
	}

	public function get_categories() {

		return [ 'gulir_element' ];
	}

	public function get_keywords() {

		return [ 'image', 'photo', 'visual' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
				'section_image',
				[
						'label' => esc_html__( 'Image', 'gulir-core' ),
				]
		);

		$this->add_control(
				'image',
				[
						'label'   => esc_html__( 'Choose Image', 'gulir-core' ),
						'type'    => Controls_Manager::MEDIA,
						'ai'      => [ 'active' => false ],
						'default' => [
								'url' => Utils::get_placeholder_image_src(),
						],
				]
		);
		$this->add_control(
				'dark_image',
				[
						'label'   => esc_html__( 'Dark Mode - Choose Image', 'gulir-core' ),
						'type'    => Controls_Manager::MEDIA,
						'ai'      => [ 'active' => false ],
						'default' => [
								'url' => Utils::get_placeholder_image_src(),
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
		$this->add_control(
				'info_dark_image',
				[
						'type'            => Controls_Manager::RAW_HTML,
						'raw'             => esc_html__( 'Dark mode image will not show in the light box if it is enabled.', 'gulir-core' ),
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
		);
		$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
						'name'      => 'image',
						'default'   => 'large',
						'separator' => 'none',
				]
		);

		$this->add_responsive_control(
				'align',
				[
						'label'     => esc_html__( 'Alignment', 'gulir-core' ),
						'type'      => Controls_Manager::CHOOSE,
						'options'   => [
								'left'   => [
										'title' => esc_html__( 'Left', 'gulir-core' ),
										'icon'  => 'eicon-text-align-left',
								],
								'center' => [
										'title' => esc_html__( 'Center', 'gulir-core' ),
										'icon'  => 'eicon-text-align-center',
								],
								'right'  => [
										'title' => esc_html__( 'Right', 'gulir-core' ),
										'icon'  => 'eicon-text-align-right',
								],
						],
						'selectors' => [
								'{{WRAPPER}}' => 'text-align: {{VALUE}};',
						],
				]
		);

		$this->add_control(
				'caption_source',
				[
						'label'   => esc_html__( 'Caption', 'gulir-core' ),
						'type'    => Controls_Manager::SELECT,
						'options' => [
								'none'       => esc_html__( 'None', 'gulir-core' ),
								'attachment' => esc_html__( 'Attachment Caption', 'gulir-core' ),
								'custom'     => esc_html__( 'Custom Caption', 'gulir-core' ),
						],
						'default' => 'none',
				]
		);

		$this->add_control(
				'caption',
				[
						'label'       => esc_html__( 'Custom Caption', 'gulir-core' ),
						'type'        => Controls_Manager::TEXT,
						'ai'          => [ 'active' => false ],
						'default'     => '',
						'placeholder' => esc_html__( 'Enter image caption text...', 'gulir-core' ),
						'condition'   => [
								'caption_source' => 'custom',
						],
				]
		);

		$this->add_control(
				'link_to',
				[
						'label'   => esc_html__( 'Link', 'gulir-core' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'none',
						'options' => [
								'none'   => esc_html__( 'None', 'gulir-core' ),
								'file'   => esc_html__( 'Media File', 'gulir-core' ),
								'custom' => esc_html__( 'Custom URL', 'gulir-core' ),
						],
				]
		);

		$this->add_control(
				'link',
				[
						'label'       => esc_html__( 'Link', 'gulir-core' ),
						'type'        => Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'gulir-core' ),
						'condition'   => [
								'link_to' => 'custom',
						],
						'show_label'  => false,
				]
		);

		$this->add_control(
				'open_lightbox',
				[
						'label'     => esc_html__( 'Lightbox', 'gulir-core' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'default',
						'options'   => [
								'default' => esc_html__( '- Default -', 'gulir-core' ),
								'yes'     => esc_html__( 'Yes', 'gulir-core' ),
								'no'      => esc_html__( 'No', 'gulir-core' ),
						],
						'condition' => [
								'link_to' => 'file',
						],
				]
		);

		$this->add_control(
				'view',
				[
						'label'   => esc_html__( 'View', 'gulir-core' ),
						'type'    => Controls_Manager::HIDDEN,
						'default' => 'traditional',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
				'section_style_image',
				[
						'label' => esc_html__( 'Image', 'gulir-core' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				]
		);

		$this->add_responsive_control(
				'width',
				[
						'label'          => esc_html__( 'Width', 'gulir-core' ),
						'type'           => Controls_Manager::SLIDER,
						'default'        => [
								'unit' => '%',
						],
						'tablet_default' => [
								'unit' => '%',
						],
						'mobile_default' => [
								'unit' => '%',
						],
						'size_units'     => [ '%', 'px', 'vw' ],
						'range'          => [
								'%'  => [
										'min' => 1,
										'max' => 100,
								],
								'px' => [
										'min' => 1,
										'max' => 1000,
								],
								'vw' => [
										'min' => 1,
										'max' => 100,
								],
						],
						'selectors'      => [
								'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
						],
				]
		);

		$this->add_responsive_control(
				'space',
				[
						'label'          => esc_html__( 'Max Width', 'gulir-core' ),
						'type'           => Controls_Manager::SLIDER,
						'default'        => [
								'unit' => '%',
						],
						'tablet_default' => [
								'unit' => '%',
						],
						'mobile_default' => [
								'unit' => '%',
						],
						'size_units'     => [ '%', 'px', 'vw' ],
						'range'          => [
								'%'  => [
										'min' => 1,
										'max' => 100,
								],
								'px' => [
										'min' => 1,
										'max' => 1000,
								],
								'vw' => [
										'min' => 1,
										'max' => 100,
								],
						],
						'selectors'      => [
								'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
						],
				]
		);

		$this->add_responsive_control(
				'height',
				[
						'label'          => esc_html__( 'Height', 'gulir-core' ),
						'type'           => Controls_Manager::SLIDER,
						'default'        => [
								'unit' => 'px',
						],
						'tablet_default' => [
								'unit' => 'px',
						],
						'mobile_default' => [
								'unit' => 'px',
						],
						'size_units'     => [ 'px', 'vh' ],
						'range'          => [
								'px' => [
										'min' => 1,
										'max' => 500,
								],
								'vh' => [
										'min' => 1,
										'max' => 100,
								],
						],
						'selectors'      => [
								'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
						],
				]
		);

		$this->add_responsive_control(
				'object-fit',
				[
						'label'     => esc_html__( 'Object Fit', 'gulir-core' ),
						'type'      => Controls_Manager::SELECT,
						'condition' => [
								'height[size]!' => '',
						],
						'options'   => [
								''        => esc_html__( '- Default -', 'gulir-core' ),
								'fill'    => esc_html__( 'Fill', 'gulir-core' ),
								'cover'   => esc_html__( 'Cover', 'gulir-core' ),
								'contain' => esc_html__( 'Contain', 'gulir-core' ),
						],
						'default'   => '',
						'selectors' => [
								'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
						],
				]
		);

		$this->add_control(
				'separator_panel_style',
				[
						'type'  => Controls_Manager::DIVIDER,
						'style' => 'thick',
				]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
				[
						'label' => esc_html__( 'Normal', 'gulir-core' ),
				]
		);

		$this->add_control(
				'opacity',
				[
						'label'     => esc_html__( 'Opacity', 'gulir-core' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
								'px' => [
										'max'  => 1,
										'min'  => 0.10,
										'step' => 0.01,
								],
						],
						'selectors' => [
								'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
						],
				]
		);

		$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
						'name'     => 'css_filters',
						'selector' => '{{WRAPPER}} img',
				]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
				[
						'label' => esc_html__( 'Hover', 'gulir-core' ),
				]
		);

		$this->add_control(
				'opacity_hover',
				[
						'label'     => esc_html__( 'Opacity', 'gulir-core' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
								'px' => [
										'max'  => 1,
										'min'  => 0.10,
										'step' => 0.01,
								],
						],
						'selectors' => [
								'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
						],
				]
		);

		$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
						'name'     => 'css_filters_hover',
						'selector' => '{{WRAPPER}}:hover img',
				]
		);

		$this->add_control(
				'background_hover_transition',
				[
						'label'      => esc_html__( 'Transition Duration', 'gulir-core' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => [ 's', 'ms' ],
						'default'    => [
								'unit' => 's',
						],
						'selectors'  => [
								'{{WRAPPER}} img' => 'transition-duration: {{SIZE}}{{UNIT}}',
						],
				]
		);

		$this->add_control(
				'hover_animation',
				[
						'label' => esc_html__( 'Hover Animation', 'gulir-core' ),
						'type'  => Controls_Manager::HOVER_ANIMATION,
				]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
						'name'      => 'image_border',
						'selector'  => '{{WRAPPER}} img',
						'separator' => 'before',
				]
		);

		$this->add_responsive_control(
				'image_border_radius',
				[
						'label'      => esc_html__( 'Border Radius', 'gulir-core' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors'  => [
								'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
				]
		);

		$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
						'name'     => 'image_box_shadow',
						'exclude'  => [
								'box_shadow_position',
						],
						'selector' => '{{WRAPPER}} img',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
				'section_style_caption',
				[
						'label'     => esc_html__( 'Caption', 'gulir-core' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => [
								'caption_source!' => 'none',
						],
				]
		);

		$this->add_responsive_control(
				'caption_align',
				[
						'label'     => esc_html__( 'Alignment', 'gulir-core' ),
						'type'      => Controls_Manager::CHOOSE,
						'options'   => [
								'left'    => [
										'title' => esc_html__( 'Left', 'gulir-core' ),
										'icon'  => 'eicon-text-align-left',
								],
								'center'  => [
										'title' => esc_html__( 'Center', 'gulir-core' ),
										'icon'  => 'eicon-text-align-center',
								],
								'right'   => [
										'title' => esc_html__( 'Right', 'gulir-core' ),
										'icon'  => 'eicon-text-align-right',
								],
								'justify' => [
										'title' => esc_html__( 'Justified', 'gulir-core' ),
										'icon'  => 'eicon-text-align-justify',
								],
						],
						'default'   => '',
						'selectors' => [
								'{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
						],
				]
		);

		$this->add_control(
				'text_color',
				[
						'label'     => esc_html__( 'Text Color', 'gulir-core' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
								'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
						],
						'global'    => [
								'default' => Global_Colors::COLOR_TEXT,
						],
				]
		);

		$this->add_control(
				'dark_text_color',
				[
						'label'     => esc_html__( 'Dark Mode - Text Color', 'gulir-core' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
								'[data-theme="dark"] {{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
						],
						'global'    => [
								'default' => Global_Colors::COLOR_TEXT,
						],
				]
		);

		$this->add_control(
				'caption_background_color',
				[
						'label'     => esc_html__( 'Background Color', 'gulir-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
								'{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
						],
				]
		);

		$this->add_control(
				'dark_caption_background_color',
				[
						'label'     => esc_html__( 'Dark Mode - Background Color', 'gulir-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
								'[data-theme="dark"] {{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
						],
				]
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
						'name'     => 'caption_typography',
						'selector' => '{{WRAPPER}} .widget-image-caption',
						'global'   => [
								'default' => Global_Typography::TYPOGRAPHY_TEXT,
						],
				]
		);

		$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
						'name'     => 'caption_text_shadow',
						'selector' => '{{WRAPPER}} .widget-image-caption',
				]
		);

		$this->add_responsive_control(
				'caption_space',
				[
						'label'     => esc_html__( 'Spacing', 'gulir-core' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
								'px' => [
										'min' => 0,
										'max' => 100,
								],
						],
						'selectors' => [
								'{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
						],
				]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = $this->has_caption( $settings );

		$link = $this->get_link_url( $settings );

		if ( $link ) {
			$this->add_link_attributes( 'link', $link );

			if ( gulir_is_edit_mode() ) {
				$this->add_render_attribute( 'link', [
						'class' => 'elementor-clickable',
				] );
			}
			if ( 'custom' !== $settings['link_to'] ) {
				$this->add_lightbox_data_attributes( 'link', $settings['image']['id'], $settings['open_lightbox'] );
			}
		}

		if ( $has_caption ) : ?>
			<figure class="wp-caption">
		<?php endif;
	if ( $link ) : ?>
		<a <?php $this->print_render_attribute_string( 'link' ); ?>>
	<?php endif;

		$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings );

		if ( ! empty( $settings['feat_lazyload'] ) && 'none' === $settings['feat_lazyload'] ) {
			$image_html = $this->layzload_attr( $image_html, 'eager' );
		} else {
			$image_html = $this->layzload_attr( $image_html, 'lazy' );
		}

		if ( ! empty( $settings['dark_image']['url'] ) ) {
			$dark_image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'dark_image' );
			$dark_image_html = $this->layzload_attr( $dark_image_html, 'lazy' );

			$image_html      = str_replace( '<img ', '<img data-mode="default" ', $image_html );
			$dark_image_html = str_replace( '<img ', '<img data-mode="dark" ', $dark_image_html );

			echo $image_html . $dark_image_html;
		} else {
			echo $image_html;
		}

	if ( $link ) : ?>
		</a>
	<?php endif;
		if ( $has_caption ) : ?>
			<figcaption class="widget-image-caption wp-caption-text"><?php
				echo gulir_strip_tags( $this->get_caption( $settings ) );
				?></figcaption>
		<?php endif;
		if ( $has_caption ) : ?>
			</figure>
		<?php endif;
	}

	private function has_caption( $settings ) {

		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	private function get_link_url( $settings ) {

		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}

			return $settings['link'];
		}

		return [
				'url' => $settings['image']['url'],
		];
	}

	/**
	 * @param $image_html
	 * @param $loading
	 *
	 * @return string|string[]|null
	 */
	private function layzload_attr( $image_html, $loading ) {

		if ( preg_match( '/<img[^>]+loading=["\'][^"\']*["\']/', $image_html ) ) {
			$image_html = preg_replace( '/loading=["\'][^"\']*["\']/', 'loading="' . $loading . '"', $image_html );
		} else {
			$image_html = preg_replace( '/<img([^>]+)>/', '<img$1 loading="' . $loading . '">', $image_html );
		}

		return $image_html;
	}

	/**
	 * Get the caption for current widget.
	 *
	 * @access private
	 *
	 * @param $settings
	 *
	 * @return string
	 * @since  2.3.0
	 */
	private function get_caption( $settings ) {

		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
					break;
			}
		}

		return $caption;
	}
}