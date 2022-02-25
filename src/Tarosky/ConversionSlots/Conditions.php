<?php

namespace Tarosky\ConversionSlots;


use Tarosky\ConversionSlots\Pattern\ConditionPattern;

/**
 * Conditions.
 */
class Conditions {

	/**
	 * Get conditions.
	 *
	 * @return ConditionPattern[]
	 */
	public static function get() {
		return apply_filters( 'taro_conversion_slots_instances', [] );
	}

	/**
	 * Get condition instance.
	 *
	 * @param string $key Condition name.
	 * @return ConditionPattern|null
	 */
	public static function instance( $key ) {
		$instances = self::get();
		return isset( $instances[ $key ] ) ? $instances[ $key ] : null;
	}
}
