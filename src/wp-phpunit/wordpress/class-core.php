<?php

namespace WP_PHPUnit\WordPress;

class Core extends Abstract_Part {
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