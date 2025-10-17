<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

/** support wc */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
add_action( 'woocommerce_before_shop_loop', 'gulir_wc_before_shop_loop', 5 );
add_action( 'woocommerce_no_products_found', 'gulir_wc_before_shop_loop', 5 );
add_action( 'woocommerce_after_main_content', 'gulir_wc_after_main_content', 10 );
add_action( 'woocommerce_after_main_content', 'woocommerce_get_sidebar', 5 );
add_action( 'woocommerce_after_shop_loop', 'gulir_wc_after_shop_loop', 99 );
add_action( 'woocommerce_no_products_found', 'gulir_wc_after_shop_loop', 99 );
add_action( 'woocommerce_grouped_product_list_before_quantity', 'gulir_wc_group_thumbnail', 10 );
add_action( 'woocommerce_after_quantity_input_field', 'gulir_quantity_input_field', 10 );


add_action( 'wp_footer', 'gulir_add_cart_popup', 15 );

/** changes columns */
add_filter( 'loop_shop_columns', 'gulir_wc_shop_columns' );

/** remove zipcode request */
add_filter( 'woocommerce_default_address_fields', 'gulir_optional_postcode_checkout' );

/** posts per page */
add_filter( 'woocommerce_output_related_products_args', 'gulir_wc_related_posts_per_page' );

/** sale percent */
add_filter( 'woocommerce_sale_flash', 'gulir_wc_sale_percent', 10, 3 );

/** single related columns */
add_filter( 'woocommerce_cross_sells_columns', 'gulir_wc_cross_sells_columns' );

/** review box */
add_filter( 'woocommerce_product_tabs', 'gulir_wc_review_box' );

/** remove single breadcrumb */
add_action( 'woocommerce_before_main_content', 'gulir_remove_single_breadcrumb', 1 );

/** change single rating position */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 12 );

/** remove additional information heading */
add_filter( 'woocommerce_product_additional_information_heading', 'gulir_additional_information_heading' );

/** change add cart button position */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 100 );

/** cross sell position */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 25 );

/** add category */
add_filter( 'woocommerce_shop_loop_item_title', 'gulir_wc_product_category', 1 );

/** change rating position */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/** css */
add_filter( 'woocommerce_enqueue_styles', 'gulir_wc_enqueue_styles' );

/** checkout layout */
add_action( 'woocommerce_checkout_before_customer_details', 'gulir_checkout_customer_details_before' );
add_action( 'woocommerce_checkout_after_customer_details', 'gulir_checkout_customer_details_after' );
add_action( 'woocommerce_checkout_after_order_review', 'gulir_checkout_order_after', 20 );

/** mini cart */
add_filter( 'woocommerce_add_to_cart_fragments', 'gulir_wc_add_to_cart_fragments', 10 );

/** single  */
add_action( 'woocommerce_single_product_summary', 'gulir_wc_single_breadcrumb', 4 );
add_action( 'gulir_wc_header_template', 'gulir_wc_template', 10 );

/** re-setup link */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_before_shop_loop_item', 'gulir_wc_absolute_product_link', 1 );

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'gulir_wc_fix_lightbox', 10 );

add_filter( 'shortcode_atts_products', 'gulir_wc_support_offset', 10, 4 );
add_filter( 'woocommerce_shortcode_products_query', 'gulir_setup_offset_attr', 10, 3 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'gulir_wc_add_to_cart_wrapper' );

/** shop wrapper */
if ( ! function_exists( 'gulir_wc_before_shop_loop' ) ) {
	function gulir_wc_before_shop_loop() {

		if ( is_shop() ) {
			$sidebar_position = gulir_get_option( 'wc_shop_sidebar_position' );
		} elseif ( is_product_category() ) {
			$sidebar_position = gulir_get_option( 'wc_archive_sidebar_position' );
		}

		if ( ! empty( $sidebar_position ) && 'none' !== $sidebar_position ) {

			$class_name     = 'shop-page is-sidebar-' . $sidebar_position;
			$sticky_sidebar = gulir_get_option( 'sticky_sidebar' );

			if ( ! empty( $sticky_sidebar ) ) {
				if ( '2' === (string) $sticky_sidebar ) {
					$class_name .= ' sticky-last-w';
				} else {
					$class_name .= ' sticky-sidebar';
				}
			}
			echo '<div class="' . esc_attr( $class_name ) . '">';
		} else {
			echo '<div class="shop-page without-sidebar">';
		}
		echo '<div class="rb-container edge-padding">';
		echo '<div class="grid-container"><div class="shop-page-content">';
	}
}

/** close site-main */
if ( ! function_exists( 'gulir_wc_template' ) ) {
	function gulir_wc_template() {

		if ( ! is_shop() ) {
			return false;
		}

		$template = gulir_get_option( 'wc_shop_template' );

		if ( ! empty( $template ) ) {
			echo do_shortcode( $template );
		}
	}
}

/** close site-main */
if ( ! function_exists( 'gulir_wc_after_shop_loop' ) ) {
	function gulir_wc_after_shop_loop() {

		echo '</div>';
	}
}

/** close wrapper page-content */
if ( ! function_exists( 'gulir_wc_after_main_content' ) ) {
	function gulir_wc_after_main_content() {

		echo '</div></div></div>';
	}
}

/** shop posts per page */
if ( ! function_exists( 'gulir_wc_related_posts_per_page' ) ) {
	function gulir_wc_related_posts_per_page( $args ) {

		$total                  = gulir_get_option( 'wc_related_posts_per_page' );
		$args['posts_per_page'] = $total;
		$args['columns']        = 4;

		return $args;
	}
}

/** remove zip code */
if ( ! function_exists( 'gulir_optional_postcode_checkout' ) ) {
	function gulir_optional_postcode_checkout( $fields ) {

		$fields['postcode']['required'] = false;

		return $fields;
	}
}

if ( ! function_exists( 'gulir_checkout_customer_details_before' ) ) {
	function gulir_checkout_customer_details_before() {

		?>
		<div class="checkout-col col-left">
		<?php
	}
}

if ( ! function_exists( 'gulir_checkout_customer_details_after' ) ) {
	function gulir_checkout_customer_details_after() { ?>
		</div><div class="checkout-col col-right">
		<?php
	}
}

if ( ! function_exists( 'gulir_checkout_order_after' ) ) {
	function gulir_checkout_order_after() { ?>
		</div>
		<?php
	}
}

/** remove description */
if ( ! function_exists( 'gulir_additional_information_heading' ) ) {
	function gulir_additional_information_heading( $heading ) {

		return false;
	}
}

/** product review box */
if ( ! function_exists( 'gulir_wc_review_box' ) ) {
	function gulir_wc_review_box( $tabs ) {

		$check = gulir_get_option( 'wc_box_review' );
		if ( empty( $check ) ) {
			unset( $tabs['reviews'] );
		}

		return $tabs;
	}
}

/** cross sell */
if ( ! function_exists( 'gulir_wc_cross_sells_columns' ) ) {
	function gulir_wc_cross_sells_columns( $columns ) {

		return 4;
	}
}

/** listing columns */
if ( ! function_exists( 'gulir_wc_shop_columns' ) ) {
	function gulir_wc_shop_columns() {

		if ( is_shop() ) {
			$sidebar_position = gulir_get_option( 'wc_shop_sidebar_position' );
		} elseif ( is_product_category() ) {
			$sidebar_position = gulir_get_option( 'wc_archive_sidebar_position' );
		}

		if ( ! empty( $sidebar_position ) && 'none' === $sidebar_position ) {
			return 4;
		} else {
			return 3;
		}
	}
}

if ( ! function_exists( 'gulir_wc_sale_percent' ) ) {
	function gulir_wc_sale_percent( $html, $post, $product ) {

		if ( ! gulir_get_option( 'wc_sale_percent' ) || empty( $product->get_regular_price() ) ) {
			return $html;
		}

		if ( $product->is_on_sale() ) {
			$attachment_ids = $product->get_gallery_image_ids();
			$class_name     = 'onsale percent ';
			if ( empty( $attachment_ids ) ) {
				$class_name = 'onsale percent without-gallery';
			}
			$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );

			return '<span class="' . esc_attr( $class_name ) . '"><span class="onsale-inner"><strong>' . '-' . esc_html( $percentage ) . '</strong><i aria-hidden="true">&#37;' . '</i></span></span>';
		}
	}
}

if ( ! function_exists( 'gulir_wc_add_to_cart_fragments' ) ) {
	function gulir_wc_add_to_cart_fragments( $fragments ) {

		$cart = WC()->cart;

		if ( ! $cart || ! $cart instanceof \WC_Cart ) {
			$count    = 0;
			$subtotal = 0;
		} else {
			$count    = $cart->get_cart_contents_count();
			$subtotal = $cart->get_cart_subtotal();
		}

		if ( gulir_get_option( 'wc_mini_cart' ) || gulir_get_option( 'wc_mobile_mini_cart' ) ) {
			$fragments['span.cart-counter']  = '<span class="cart-counter">' . $count . '</span>';
			$fragments['span.total-amount']  = '<span class="total-amount">' . $subtotal . '</span>';
			$fragments['div.mini-cart-wrap'] = '<div class="mini-cart-wrap woocommerce">' . $fragments['div.widget_shopping_cart_content'] . '</div>';
			unset( $fragments['div.widget_shopping_cart_content'] );
		}

		if ( gulir_get_option( 'wc_add_cart_popup' ) ) {
			$fragments['span.add-cart-popup'] = '<span class="add-cart-popup"><span class="added-info">' . gulir_html__( 'Product added to cart!', 'gulir' ) . '</span>';
			$fragments['span.add-cart-popup'] .= '<a class="is-btn" href="' . wc_get_cart_url() . '">' . gulir_html__( 'View Cart', 'gulir' ) . '</a></span>';
		}

		return $fragments;
	}
}

if ( ! function_exists( 'gulir_remove_single_breadcrumb' ) ) {
	function gulir_remove_single_breadcrumb() {

		if ( is_product() ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		}
	}
}

if ( ! function_exists( 'gulir_wc_product_category' ) ) {
	function gulir_wc_product_category( $args = [] ) {

		$terms = get_the_terms( get_the_ID(), 'product_cat' );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			echo '<div class="product-top">';
			echo '<div class="product-entry-categories p-categories">';
			foreach ( $terms as $term ) {
				echo '<a href="' . gulir_get_term_link( $term ) . '" class="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</a>';
			}
			echo '</div>';

			if ( function_exists( 'wc_get_template' ) ) {
				wc_get_template( 'loop/rating.php' );
			}
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'gulir_wc_enqueue_styles' ) ) {
	function gulir_wc_enqueue_styles( $styles ) {

		unset( $styles['woocommerce-general'] );

		return $styles;
	}
}

if ( ! function_exists( 'gulir_wc_single_breadcrumb' ) ) {
	function gulir_wc_single_breadcrumb() {

		if ( function_exists( 'woocommerce_breadcrumb' ) ) {
			woocommerce_breadcrumb();
		}
	}
}

if ( ! function_exists( 'gulir_wc_absolute_product_link' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function gulir_wc_absolute_product_link() {

		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link product-absolute-link"></a>';
	}
}

if ( ! function_exists( 'gulir_wc_fix_lightbox' ) ) {
	/**
	 * @param $html
	 *
	 * @return string|string[]|null
	 */
	function gulir_wc_fix_lightbox( $html ) {

		if ( gulir_is_elementor_active() ) {
			return preg_replace( '/<a(.*)href="([^"]*)"(.*)>/', '<a$1href="#"$3>', $html );
		}

		return $html;
	}
}

if ( ! function_exists( 'gulir_wc_group_thumbnail' ) ) {
	/**
	 * @return false
	 */
	function gulir_wc_group_thumbnail() {

		if ( ! gulir_get_option( 'wc_group_thumbnail' ) ) {
			return false;
		}
		?>
		<td class="product-thumbnail grouped-thumb"><?php echo woocommerce_get_product_thumbnail(); ?></td>
		<?php
	}
}

if ( ! function_exists( 'gulir_add_cart_popup' ) ) {
	function gulir_add_cart_popup() {

		if ( gulir_get_option( 'wc_add_cart_popup' ) && class_exists( 'WooCommerce' ) ) {
			echo '<div id="add-cart-popup"><span class="add-cart-popup"></span></div>';
		}
	}
}

if ( ! function_exists( 'gulir_get_classes_products_loop' ) ) {
	function gulir_get_classes_products_loop() {

		$classes = [
			'products-outer',
		];

		if ( gulir_get_option( 'wc_box_style' ) ) {
			$classes[]   = 'is-boxed-' . gulir_get_option( 'wc_box_style', '0' );
			$cart_layout = 'visible';
		} else {
			$cart_layout = '0';
		}

		$classes[] = 'cart-layout-' . $cart_layout;

		if ( gulir_get_option( 'wc_add_cart_style' ) ) {
			$classes[] = 'cart-style-' . gulir_get_option( 'wc_add_cart_style' );
		}

		if ( gulir_get_option( 'wc_responsive_list' ) ) {
			$classes[] = 'is-m-list';
		}

		if ( gulir_get_option( 'wc_centered' ) ) {
			$classes[] = 'p-center';
		}

		if ( $GLOBALS['wp_query']->get( 'wc_query' ) ) {
			$classes[] = 'yes-ploop';
		}

		return join( ' ', $classes );
	}
}

if ( ! function_exists( 'gulir_wc_add_to_cart_wrapper' ) ) {
	function gulir_wc_add_to_cart_wrapper( $html ) {

		return '<div class="product-btn">' . $html . '</div>';
	}
}

if ( ! function_exists( 'gulir_wc_support_offset' ) ) {
	function gulir_wc_support_offset( $out, $pairs, $atts, $shortcode ) {

		if ( ! empty( $atts['offset'] ) ) {
			$out['offset'] = $atts['offset'];
		}

		return $out;
	}
}

if ( ! function_exists( 'gulir_setup_offset_attr' ) ) {
	function gulir_setup_offset_attr( $query_args, $attributes, $type ) {

		if ( ! empty( $attributes['offset'] ) && ( empty( $attributes['page'] ) || $attributes['page'] < 2 ) ) {
			$query_args['offset'] = absint( $attributes['offset'] );
		}

		return $query_args;
	}
}

if ( ! function_exists( 'gulir_quantity_input_field' ) ) {
	function gulir_quantity_input_field() {
		echo '<span class="quantity-btn up"></span><span class="quantity-btn down"></span>';
	}
}
