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

	protected function sanitizeClassName( $string ) {
		return preg_replace( '@[^A-Z0-9]@is', '_', $string );
	}

	public function add( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		if ( ! isset( $this->registered[ $tag ] ) ) {
			$this->registered[ $tag ] = [ ];
		}

		$this->registered[ $tag ][] = add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}

	public function reset() {
		foreach ( $this->registered as $tag => $callbacks ) {
			foreach ( $callbacks as $added_function ) {
				remove_filter( $tag, $added_function );
			}
		}
	}
}