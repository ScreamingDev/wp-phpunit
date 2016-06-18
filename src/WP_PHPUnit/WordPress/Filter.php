<?php

namespace WP_PHPUnit\WordPress;

class Filter extends AbstractNamedPart {
	protected $registered = [ ];

	public function disable( $callable = null ) {
		$this->disable_filter( $this->getName(), $callable );
	}

	public function expected() {

		$mock = $this->getInterceptorMock();

		$handle = $mock->shouldDeferMissing()->shouldReceive( 'passthrough' );

		$handle->withAnyArgs()->atLeast()->once()->passthru();

		$this->add( [ $mock, 'passthrough' ] );

		return $handle;
	}

	public function add( $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$this->add_filter( $this->getName(), $function_to_add, $priority, $accepted_args );
	}
}