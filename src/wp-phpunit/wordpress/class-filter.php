<?php

namespace WP_PHPUnit\WordPress;

class Filter extends Abstract_Named_Part {
	protected $registered = [ ];

	public function disable( $callable ) {
		$this->disable_filter( $this->getName(), $callable );
	}

	public function expected() {

		$mock = $this->getInterceptorMock();

		$handle = $mock->shouldDeferMissing()->shouldReceive( 'passthrough' );

		$handle->withAnyArgs()->atLeast()->once()->passthru();

		$this->add( $this->getName(), [ $mock, 'passthrough' ] );

		return $handle;
	}

	public function add( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$this->add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}
}