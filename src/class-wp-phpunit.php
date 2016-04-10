<?php

class WP_PHPUnit {
	static protected $_wp;
	protected        $_actions;

	public function __construct() {
		$this->_actions = new \WP_PHPUnit\Actions();
	}

	public static function tearDown() {
		\Mockery::close();

		static::wp()->reset();
	}

	public function reset() {
		$this->actions()->reset();
	}

	/**
	 * @return \WP_PHPUnit\Actions
	 */
	public function actions() {
		return $this->_actions;
	}

	/**
	 * @return \WP_PHPUnit
	 */
	public static function wp() {
		if ( ! static::$_wp ) {
			static::$_wp = new static;
		}

		return static::$_wp;
	}

	/**
	 * @return \Mockery\Expectation
	 */
	public function expectWpDie() {
		$mock = \Mockery::mock( 'wp_die' );

		add_filter( 'wp_die_ajax_handler', [ $mock, 'run' ] );
		add_filter( 'wp_die_xmlrpc_handler', [ $mock, 'run' ] );
		add_filter( 'wp_die_handler', [ $mock, 'run' ] );

		$handle = $mock->shouldReceive( 'run' );
		$handle->andReturn( '__return_null' );
		$handle->atLeast()->once();

		return $handle;
	}
}