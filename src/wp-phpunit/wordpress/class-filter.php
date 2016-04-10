<?php

namespace WP_PHPUnit\WordPress;

class Filter extends Abstract_Part {
	protected $registered = [ ];

	public function expect( $tag, $priority = 10, $accepted_args = 1 ) {

		$mock = $this->getInterceptorMock();

		$handle = $mock->shouldDeferMissing()->shouldReceive( 'passthrough' );

		$handle->withAnyArgs()->atLeast()->once()->passthru();

		$this->add( $tag, [ $mock, 'passthrough' ], $priority, $accepted_args );

		return $handle;
	}

	public function add( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$this->add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}

	public function disable( $action, $callable ) {
		$this->disable_filter( $action, $callable );
	}
}