<?php

namespace WP_PHPUnit\WordPress;

class Action extends Abstract_Named_Part {
	public function assertCalled() {
		global $merged_filters;

		if ( isset( $merged_filters[ $this->getName() ] ) ) {
			return;
		}

		throw new \Exception(
			sprintf(
				'Filter %s has not been called.',
				$this->getName()
			)
		);
	}

	/**
	 * @param $action
	 *
	 * @return \Mockery\Expectation
	 */
	public function expected() {

		$mock = $this->getInterceptorMock();

		$handle = $mock->shouldDeferMissing()->shouldReceive( 'noop' );
		$handle->atLeast()->once();

		$this->add( $this->getName(), array( $mock, 'noop' ) );

		return $handle;
	}

	public function add( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		$this->add_action( $tag, $function_to_add, $priority, $accepted_args );
	}
}