<?php

namespace Tarosky\ConversionSlots\Conditions;

use Tarosky\ConversionSlots\Pattern\ConditionPattern;

/**
 * In all pages.
 *
 *
 */
class AllPages extends ConditionPattern {

	/**
	 * {@inheritdoc}
	 */
	public function label() {
		return __( 'All Pages', 'taro-cs' );
	}
}
