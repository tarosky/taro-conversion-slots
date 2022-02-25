<?php

namespace Tarosky\ConversionSlots;


/**
 * Position constatnts
 */
class Positions {

	/**
	 * Get positions.
	 *
	 * @return array[]
	 */
	public static function get() {
		return apply_filters( 'taro_conversion_slots_positions', [
			'not_display' => [
				'label' => __( 'Not display', 'taro-cs' ),
				'value' => '',
			],
			'head'        => [
				'label' => __( 'in <head> tag', 'taro-cs' ),
				'value' => 'head',
			],
			'footer'      => [
				'label' => __( 'Before <body> tag', 'taro-cs' ),
				'value' => 'footer',
			],
		] );
	}

	/**
	 * Get value.
	 *
	 * @param string $key Key name.
	 *
	 * @return string
	 */
	public static function value( $key ) {
		$positions = self::get();
		return isset( $positions[ $key ]['value'] ) ? $positions[ $key ]['value'] : '';
	}
}
