<?php

namespace Tarosky\ConversionSlots\Pattern;


/**
 * Condition pattern.
 *
 * @package taro-cs
 */
abstract class ConditionPattern extends SingletonPattern {

	/**
	 * Convert string.
	 *
	 * @return string
	 */
	public function name() {
		$class_name = explode( '\\', get_called_class() );
		$class_name = $class_name[ count( $class_name ) - 1 ];
		return preg_replace( '/^-/u', '', preg_replace_callback( '#[A-Z]#u', function( $matches ) {
			return '-' . strtolower( $matches[0] );
		}, $class_name ) );
	}

	/**
	 * Get label.
	 *
	 * @return string
	 */
	abstract public function label();

	/**
	 * Is available?
	 *
	 * @param string $args
	 * @return bool
	 */
	public function is_available( $args = '' ) {
		return true;
	}

	/**
	 * Description about
	 *
	 * @return string
	 */
	public function description() {
		return '';
	}

	/**
	 * Has option field?
	 *
	 * @return string text,textarea,number etc.
	 */
	public function option_type() {
		return '';
	}

	/**
	 * Render tag.
	 *
	 * @param string   $tag  Tag to render.
	 * @param \WP_Post $post Post object.
	 * @param string   $arg  Optional arguments.
	 *
	 * @return string
	 */
	public function render( $tag, $post, $arg ) {
		return $tag;
	}

	/**
	 * Is WooCommerce active?
	 *
	 * @return bool
	 */
	protected function has_woo() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check if product in the cart.
	 *
	 * @param int|string $product_id Product ID.
	 * @return bool
	 */
	protected function is_product_in_the_cart( $product_id ) {
		if ( ! function_exists( 'WC' ) ) {
			return false;
		}
		return (bool) WC()->cart->find_product_in_cart( $product_id );
	}
}
