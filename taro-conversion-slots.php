<?php
/**
Plugin Name: Taro Conversion Slots
Plugin URI: https://wordpress.org/plugins/taro-conversion-slots/
Description: Add slots for .
Author: Tarosky INC.
Version: nightly
Author URI: https://tarosky.co.jp/
License: GPL3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: taro-cs
Domain Path: /languages
 */

defined( 'ABSPATH' ) or die();

/**
 * Register plugin hooks.
 */
add_action( 'plugins_loaded', function() {
	// Load translations.
	load_plugin_textdomain( 'taro-cs', false, basename( __DIR__ ) . '/languages' );
	$autoloader = __DIR__ . '/vendor/autoload.php';
	if ( ! file_exists( $autoloader ) ) {
		trigger_error( 'Autoloader is missing', E_USER_WARNING );
		return;
	}
	require $autoloader;
	\Tarosky\ConversionSlots\Bootstrap::get_instance();
} );

