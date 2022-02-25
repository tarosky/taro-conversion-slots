<?php

namespace Tarosky\ConversionSlots\Conditions;


use Tarosky\ConversionSlots\Pattern\ConditionPattern;

/**
 * Executed in WooCommerce
 */
class WooCart extends ConditionPattern {

	/**
	 * {@inheritdoc}
	 */
	public function label() {
		return __( 'WooCommerce Cart', 'taro-cs' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available( $args = '' ) {
		if ( ! $this->has_woo() ) {
			return false;
		}
		if ( ! is_cart() ) {
			return false;
		}
		if ( ! $args ) {
			return true;
		}
		// If $args is numeric, try to find product in cart.
		return $this->is_product_in_the_cart( $args );
	}
}
