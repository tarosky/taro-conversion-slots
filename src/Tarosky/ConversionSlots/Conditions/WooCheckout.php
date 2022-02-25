<?php

namespace Tarosky\ConversionSlots\Conditions;


use Tarosky\ConversionSlots\Pattern\ConditionPattern;

/**
 * Executed in WooCommerce
 */
class WooCheckout extends ConditionPattern {

	/**
	 * {@inheritdoc}
	 */
	public function label() {
		return __( 'WooCommerce Checkout', 'taro-cs' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available( $args = '' ) {
		if ( ! $this->has_woo() ) {
			return false;
		}
		if ( ! is_checkout() || ! empty( is_wc_endpoint_url( 'order-received' ) ) ) {
			return false;
		}
		if ( ! $args ) {
			return true;
		}
		// If args is set, check if the product id is in the cart.
		return $this->is_product_in_the_cart( $args );
	}
}
