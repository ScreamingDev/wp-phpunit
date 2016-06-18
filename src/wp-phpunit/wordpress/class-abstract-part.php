<?php

namespace WP_PHPUnit\WordPress;

use WP_PHPUnit\Framework\Interceptor;

abstract class Abstract_Part {
	protected $_disabled_filter    = [ ];
	protected $_registered_actions = [ ];
	protected $_registered_filter  = [ ];
	protected $_removed_filter = [ ];

	public function reset() {
		$this->resetFilter();
		$this->resetActions();
	}

	protected function resetFilter() {
		// recover filter
		foreach ( $this->_removed_filter as $tag => $value ) {
			$GLOBALS['wp_filter'][ $tag ] = $value;

			unset( $this->_removed_filter[ $tag ] );
		}

		// removed mocked actions
		foreach ( $this->_registered_filter as $tag => $functions ) {
			foreach ( $functions as $callable ) {
				remove_action( $tag, $callable );
			}
		}

		// recover disabled filter
		foreach ( $this->_disabled_filter as $item ) {
			$GLOBALS['wp_filter'][ $item['tag'] ][ $item['priority'] ][ $item['id'] ] = $item['value'];
		}
	}

	protected function resetActions() {
		foreach ( $this->_registered_actions as $tag => $functions ) {
			foreach ( $functions as $callable ) {
				remove_filter( $tag, $callable );
			}
		}
	}

	protected function recoverGlobals() {
		foreach ( $this->_globalsBackup as $name => $value ) {
			$GLOBALS[ $name ] = $value;
		}
	}

	protected function add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		if ( ! isset( $this->_registered_actions[ $tag ] ) ) {
			$this->_registered_actions[ $tag ] = [ ];
		}

		add_action( $tag, $function_to_add, $priority, $accepted_args );
	}

	protected function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		if ( ! isset( $this->_registered_filter[ $tag ] ) ) {
			$this->_registered_filter[ $tag ] = [ ];
		}

		$this->_registered_filter[ $tag ][] = add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}

	protected function disable_filter( $tag, $callable ) {
		if ( isset( $this->_removed_filter[ $tag ] ) && $this->_removed_filter[ $tag ] ) {
			throw new \OverflowException( 'You can disable a complete filter only once.' );
		}

		if ( null === $callable ) {
			$this->_removed_filter[ $tag ] = $GLOBALS['wp_filter'][ $tag ];

			$GLOBALS['wp_filter'][ $tag ] = [ ];

			return;
		}

		$priority = has_filter( $tag, $callable );

		if ( false === $priority ) {
			return;
		}

		$function_to_remove = _wp_filter_build_unique_id( $tag, $callable, $priority );

		$this->_disabled_filter[] = [
			'tag'      => $tag,
			'priority' => $priority,
			'id'       => $function_to_remove,
			'value'    => $GLOBALS['wp_filter'][ $tag ][ $priority ][ $function_to_remove ]
		];

		$passthrough = [ 'function' => [ new Interceptor(), 'passthrough' ], 'accepted_args' => 1 ];

		$GLOBALS['wp_filter'][ $tag ][ $priority ][ $function_to_remove ] = $passthrough;
	}

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getInterceptorMock() {
		return \Mockery::instanceMock( new Interceptor() );
	}
}