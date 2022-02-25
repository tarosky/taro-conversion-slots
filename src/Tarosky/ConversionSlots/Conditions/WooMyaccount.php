<?php

namespace Tarosky\ConversionSlots\Conditions;


use Tarosky\ConversionSlots\Pattern\ConditionPattern;

/**
 * Executed in WooCommerce
 */
class WooMyaccount extends ConditionPattern {

	/**
	 * {@inheritdoc}
	 */
	public function label() {
		return __( 'WooCommerce My Account', 'taro-cs' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available( $args = '' ) {
		if ( ! $this->has_woo() ) {
			return false;
		}
		if ( ! is_account_page() ) {
			return false;
		}
		if ( ! $args ) {
			return true;
		}
		return (bool) is_wc_endpoint_url( $args );
	}
}
