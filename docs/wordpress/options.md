# Options

## Freeze values

Make an option unchangeable

	// Keep the value
	\WP_PHPUnit::wp()->option( $tag )->lockValue();
	
	// or have one for the whole test
	\WP_PHPUnit::wp()->option( $tag )->lockValue( $value );
