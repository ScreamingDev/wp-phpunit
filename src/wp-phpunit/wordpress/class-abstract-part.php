<?php

namespace WP_PHPUnit\WordPress;

use WP_PHPUnit\Framework\Interceptor;

abstract class Abstract_Part {
	protected $_registered_actions = [ ];
	protected $_registered_filter  = [ ];

	public function reset() {
		$this->resetFilter();
		$this->resetActions();
	}

	protected function resetFilter() {
		foreach ( $this->_registered_actions as $tag => $functions ) {
			foreach ( $functions as $callable ) {
				remove_action( $tag, $callable );
			}
		}
	}

	protected function resetActions() {
		foreach ( $this->_registered_filter as $tag => $functions ) {
			foreach ( $functions as $callable ) {
				remove_filter( $tag, $callable );
			}
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

	/**
	 * @return \Mockery\MockInterface
	 */
	protected function getInterceptorMock() {
		return \Mockery::instanceMock( new Interceptor() );
	}
}