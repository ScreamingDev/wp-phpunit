<?php

namespace WP_PHPUnit\WordPress;

class Action extends Abstract_Part {
	protected $registered = [ ];

	/**
	 * @param $action
	 *
	 * @return \Mockery\Expectation
	 */
	public function expect( $action, $priority = 10, $accepted_args = 1 ) {

		$mock   = $this->getInterceptorMock();
		
		$handle = $mock->shouldDeferMissing()->shouldReceive( 'noop' );
		$handle->atLeast()->once();

		$this->add_action( $action, array( $mock, 'noop' ), $priority, $accepted_args );

		return $handle;
	}

	public function add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		if ( ! isset( $this->registered[ $tag ] ) ) {
			$this->registered[ $tag ] = [ ];
		}

		$this->registered[ $tag ][] = $function_to_add;

		add_action( $tag, $function_to_add, $priority, $accepted_args );
	}

	/**
	 * @return array
	 */
	protected function getRegistered() {
		return $this->registered;
	}

	public function reset() {
		foreach ( $this->registered as $action => $callbacks ) {
			foreach ( $callbacks as $added_function ) {
				remove_action( $action, $added_function );
			}
		}
	}
}