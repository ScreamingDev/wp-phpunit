# Actions

## Expect actions

Write your test and assert the execution of actions:

	\WP_PHPUnit::wp()->action( $tag )->expected();

Or a bit more detailled:

	// expect it not more than once
	\WP_PHPUnit::wp()->action( $tag )->expected()->atMost()->once();
    
	// expect the action with specific values
	\WP_PHPUnit::wp()->action( $tag )->expected()->with( [ 'value1', 'value2' ] );

	// or both
	\WP_PHPUnit::wp()->action( $tag )->expected()->with( [ 'value1', 'value2' ] )->atMost()->once();