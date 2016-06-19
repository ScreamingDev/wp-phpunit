# Filter

## Assertion on filter

Expect the execution of a filter:

	\WP_PHPUnit::wp()->filter( $tag )->expected();

Or a bit more detailled:

	// expect it not more than once
	\WP_PHPUnit::wp()->filter( $tag )->expected()->atMost()->once();
    
	// expect the filter with specific values
	\WP_PHPUnit::wp()->filter( $tag )->expected()->with( 'value1' );

	// or both
	\WP_PHPUnit::wp()->filter( $tag )->expected()->with( 'value1' )->atMost()->once();

## Disable filter

When a filter disturbs your testing then disable it for this particular test:

	\WP_PHPUnit::wp()->filter( $tag )->disable();

Or just a specific function using:

	\WP_PHPUnit::wp()->filter( $tag )->disable( $callable );

Complete filters can be removed only once during a test-method.
Removed filter will be recovered during `\WP_PHPUnit::tearDown()`.