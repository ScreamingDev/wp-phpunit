<?php

namespace WP_PHPUnit\WordPress;

class Option extends AbstractNamedPart {
	public function lockValue( $value = null ) {
		if ( null === $value ) {
			$value = get_option( $this->getName() );
		}

		$this->disable_filter( 'pre_option_' . $this->getName(), null );

		$this->add_filter(
			'pre_option_' . $this->getName(),
			function () use ( $value ) {
				return $value;
			}
		);

		$self = $this;

		$this->disable_filter( 'pre_update_option', null );

		$this->add_filter(
			'pre_update_option',
			function ( $newValue, $option = null ) use ( $value, $self ) {
				if ( $option != $self->getName() ) {
					return $newValue;
				}

				return $value;
			},
			10,
			2
		);
	}
}