<?php

namespace WP_PHPUnit\WordPress;

class Filter {
	protected $registered = [ ];

	public function expect( $tag, $priority = 10, $accepted_args = 1 ) {

		$name = $this->sanitizeClassName( 'filter_' . $tag );

		$mock   = \Mockery::mock( $name );
		$handle = $mock->shouldReceive( 'handle' );
		$handle->withAnyArgs()->andReturnUsing(
			function ( $value ) {
				return $value;
			}
		);

		$handle->atLeast()->once();

		$this->add( $tag, [ $mock, 'handle' ], $priority, $accepted_args );

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