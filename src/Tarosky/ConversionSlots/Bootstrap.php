<?php

namespace Tarosky\ConversionSlots;


use Tarosky\ConversionSlots\Conditions\AllPages;
use Tarosky\ConversionSlots\Conditions\SinglePage;
use Tarosky\ConversionSlots\Conditions\WooCart;
use Tarosky\ConversionSlots\Conditions\WooCheckout;
use Tarosky\ConversionSlots\Conditions\WooMyaccount;
use Tarosky\ConversionSlots\Conditions\WooThankyou;
use Tarosky\ConversionSlots\Pattern\SingletonPattern;

/**
 * Plugin bootstrap.
 *
 * @package taro-cs
 */
class Bootstrap extends SingletonPattern {

	/**
	 * {@inheritdoc}
	 */
	protected function init() {
		// Post type.
		PostType::get_instance();
		Renderer::get_instance();
		// Default conditions.
		add_filter( 'taro_conversion_slots_instances', [ $this, 'register_instances' ] );
	}

	/**
	 * Register instances.
	 *
	 * @param array $instances Instance of condition.
	 * @return array
	 */
	public function register_instances( $instances ) {
		$classes = [
			AllPages::class,
			SinglePage::class,
		];
		if ( class_exists( 'WooCommerce' ) ) {
			$classes[] = WooCart::class;
			$classes[] = WooCheckout::class;
			$classes[] = WooThankyou::class;
			$classes[] = WooMyaccount::class;
		}
		foreach ( $classes as $class_name ) {
			$instance                       = $class_name::get_instance();
			$instances[ $instance->name() ] = $instance;
		}
		return $instances;
	}
}
