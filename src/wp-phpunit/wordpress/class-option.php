<?php

namespace WP_PHPUnit\WordPress;

class Option extends Abstract_Named_Part {
	public function lock() {
		$oldValue = get_option( $this->getName() );

		$this->set( $oldValue );

		$self = $this;

		$this->disable_filter( 'pre_update_option', null );

		$this->add_filter(
			'pre_update_option',
			function ( $value, $option = null ) use ( $oldValue, $self ) {
				if ( $option != $self->getName() ) {
					return $value;
				}

				return $oldValue;
			},
			10,
			2
		);
	}

	public function set( $value ) {
		$this->disable_filter( 'pre_option_' . $this->getName(), null );

		$this->add_filter(
			'pre_option_' . $this->getName(),
			function () use ( $value ) {
				return $value;
			}
		);
	}
}