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
	 * @return string
	 */
	public static function value( $key ) {
		$positions = self::get();
		return isset( $positions[ $key ]['value'] ) ? $positions[ $key ]['value'] : '';
	}

	/**
	 * Get label.
	 *
	 * @param string $key Key name.
	 * @return string
	 */
	public static function label( $key ) {
		$positions = self::get();
		return isset( $positions[ $key ]['label'] ) ? $positions[ $key ]['label'] : '';
	}

	/**
	 * Get post object.
	 *
	 * @param int|null|\WP_Post $post Post object.
	 * @return string
	 */
	public static function get_position( $post = null ) {
		$post      = get_post( $post );
		$post_meta = get_post_meta( $post->ID, PostType::META_KEY_POSITION, true );
		return self::label( $post_meta );
	}
}
