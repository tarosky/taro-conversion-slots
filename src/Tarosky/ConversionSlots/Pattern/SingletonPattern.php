<?php

namespace Tarosky\ConversionSlots\Pattern;


/**
 * Singleton pattern
 *
 * @package taro-cs
 */
abstract class SingletonPattern {

	/**
	 * Instances.
	 *
	 * @var static[]
	 */
	private static $instances = [];

	/**
	 * Constructor.
	 */
	final protected function __construct() {
		$this->init();
	}

	/**
	 * Executed in constructor.
	 *
	 * @return void
	 */
	protected function init() {
		// Do something.
	}

	/**
	 * Instance getter.
	 *
	 * @return static
	 */
	public static function get_instance() {
		$class_name = get_called_class();
		if ( ! isset( self::$instances[ $class_name ] ) ) {
			self::$instances[ $class_name ] = new $class_name();
		}
		return self::$instances[ $class_name ];
	}
}
