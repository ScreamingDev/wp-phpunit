<?php

namespace WP_PHPUnit\WordPress;

class Core extends Abstract_Part {
	/**
	 * @return \Mockery\Expectation
	 */
	public function expectWpDie() {
		$mock = \Mockery::mock( 'wp_die' );

		$this->add_filter( 'wp_die_ajax_handler', [ $mock, 'run' ] );
		$this->add_filter( 'wp_die_xmlrpc_handler', [ $mock, 'run' ] );
		$this->add_filter( 'wp_die_handler', [ $mock, 'run' ] );

		$handle = $mock->shouldReceive( 'run' );
		$handle->andReturn( '__return_null' );
		$handle->atLeast()->once();

		return $handle;
	}

	/**
	 * @return \Mockery\Expectation
	 */
	public function expectWpRedirect() {
		$mock   = $this->getInterceptorMock();
		$handle = $mock->shouldDeferMissing()
		               ->shouldReceive( 'passthrough' )
		               ->withAnyArgs()
		               ->atLeast()->once()
		               ->passthru();

		$this->add_filter( 'wp_redirect', [ $mock, 'passthrough' ], 10, 2 );
		$this->add_filter( 'wp_redirect', '__return_false', PHP_INT_MAX );

		return $handle;
	}
}