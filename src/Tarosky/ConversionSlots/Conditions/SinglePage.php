<?php

namespace Tarosky\ConversionSlots\Conditions;

use Tarosky\ConversionSlots\Pattern\ConditionPattern;

/**
 * In all pages.
 *
 *
 */
class SinglePage extends ConditionPattern {

	/**
	 * {@inheritdoc}
	 */
	public function label() {
		return __( 'Single Page', 'taro-cs' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available( $args = '' ) {
		if ( ! $args ) {
			return is_singular();
		} elseif ( is_numeric( $args ) ) {
			return is_single( (int) $args );
		} else {
			return is_singular( $args );
		}
	}
}
