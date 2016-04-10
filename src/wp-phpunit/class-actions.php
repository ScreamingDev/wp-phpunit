<?php

namespace WP_PHPUnit;

class Actions {
	protected $_expected = [ ];


	/**
	 * @param $action
	 *
	 * @return \Mockery\Expectation
	 */
	public function expect( $action, $priority = 10, $accepted_args = 1 ) {

		$mock   = \Mockery::mock( $action );
		$handle = $mock->shouldReceive( 'handle' );
		$handle->atLeast()->once();

		$this->add_action( $action, array( $mock, 'handle' ), $priority, $accepted_args );

		return $handle;
	}

	public function add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		if ( ! isset( $this->_expected[ $tag ] ) ) {
			$this->_expected[ $tag ] = [ ];
		}

		$this->_expected[ $tag ][] = $function_to_add;

		add_action( $tag, $function_to_add, $priority, $accepted_args );
	}

	/**
	 * @return array
	 */
	public function getExpected() {
		return $this->_expected;
	}

	public function reset() {
		foreach ( $this->_expected as $action => $callbacks ) {
			foreach ( $callbacks as $added_function ) {
				remove_action( $action, $added_function );
			}
		}
	}
}