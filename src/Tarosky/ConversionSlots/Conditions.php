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

	/**
	 * Get condition name.
	 *
	 * @param null|int|\WP_Post $post Post object.
	 * @return string
	 */
	public static function get_condition_name( $post = null ) {
		$conditions = self::get();
		$post       = get_post( $post );
		$post_meta  = get_post_meta( $post->ID, PostType::META_KEY_CONDITION, true );
		return isset( $conditions[ $post_meta ] ) ? $conditions[ $post_meta ]->label() : '';
	}
}
