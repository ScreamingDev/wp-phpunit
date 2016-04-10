<?php

class WP_PHPUnit {
	static protected $_wp;

	public static function tearDown() {
		\Mockery::close();

		static::wp()->reset();
	}

	/**
	 * @return \WP_PHPUnit\WordPress
	 */
	public static function wp() {
		if ( ! static::$_wp ) {
			static::$_wp = new \WP_PHPUnit\WordPress();
		}

		return static::$_wp;
	}
}